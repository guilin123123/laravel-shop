<?php

namespace App\Http\Controllers;

use App\Events\OrderPaid;
use App\Exceptions\InvalidRequestException;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    //
    public function payByAlipay(Order $order, Request $request)
    {
        // 判断订单是否属于当前用户
        $this->authorize('own', $order);
        // 判断订单的状态
        if ($order->paid_at || $order->closed) {
            throw new InvalidRequestException('订单状态不正确');
        }

        // 调用支付宝的网页支付
        return app('alipay')->web([
            'out_trade_no' => $order->no, //订单编号, 需保证在商户端不重复
            'total_amount' => $order->total_amount, // 订单金额, 单位元, 支付小数点后两位
            'subject' => '支付 Laravel Shop 的订单:' . $order->no, // 订单标题
        ]);
    }

    // 前端回调页面
    public function alipayReturn()
    {
        try {
            app('alipay')->verify();
        } catch (\Exception $exception) {
            return view('pages.error', ['msg' => '数据不正确']);
        }

        return view('pages.success', ['msg' => '付款成功']);
    }

    // 服务器端回调
    public function alipayNotify()
    {
        $data = app('alipay')->verify();
        // 如果订单状态不是成功或者结束, 则不走后续的逻辑
        // 所有交易状态: https://docs.open.alipay.com/59/103672
        if (!in_array($data->trade_status, ['TRADE_SUCCESS', 'TRADE_FINSHED'])) {
            return app('alipay')->success();
        }
        // $data->out_trade_no 拿到订单流水号, 并在数据库中查询
        $order = Order::where('no', $data->out_trade_no)->first();

        // 代码的健壮性
        if (!$order) {
            return 'fail';
        }
        // 如果这笔订单已支付
        if ($order->paid_at) {
//            返回数据给支付宝
            return app('alipay')->success();
        }

        $order->update([
            'paid_at' => Carbon::now(), // 支付时间
            'payment_method' => 'alipay', // 支付方式
            'payment_no' => $data->trade_no // 支付宝订单号
        ]);

        $this->afterPaid($order);

        return app('alipay')->success();
//        Log::debug('Alipay notify', $data->all());
    }

    public function afterPaid(Order $order)
    {
        // 触发事件
        event(new OrderPaid($order));
    }
}