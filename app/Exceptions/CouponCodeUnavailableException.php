<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Throwable;

class CouponCodeUnavailableException extends Exception
{
    public function __construct(string $message = "", int $code = 403, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    // 当这个异常被触发时, 会调用render 方法输出给用户
    public function render(Request $request)
    {
        // 如果通过API 请求.则返回JSON格式的错误信息
        if ($request->expectsJson()) {
            return response()->json(['msg' => $this->message], $this->code);
        }

        // 否则返回上一页并带有错误信息
        return redirect()->back()->withErrors(['coupon_code' => $this->message]);
    }
}
