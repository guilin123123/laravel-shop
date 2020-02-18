<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use App\Models\CartItem;

class CartService
{
    public function get()
    {
        return Auth::user()->cartItems()->with(['productSku.product'])->get();
    }

    /**
     * @param $skuId 加入购物车的具体商品
     * @param $amount 商品的数量
     * @return CartItem 购物车项的具体模型
     */
    public function add($skuId, $amount)
    {
        $user = Auth::user();

        // 查询该商品是否已经在购物车中
        if ($item = $user->cartItems()->where('product_sku_id', $skuId)->first()) {
            // 如果存在则直接叠加数量
            $item->update([
                'amount' => $item->amount + $amount,
            ]);
        } else {
            // 否则创建一个新的购物车记录
            $item =  new CartItem(['amount' => $amount]);
            $item->user()->associate($user);
            $item->productSku()->associate($skuId);
            $item->save();
        }

        return $item;
    }

    /**
     * @param $skuIds 要删除的具体商品
     */
    public function remove($skuIds)
    {
        // 可以传单个ID或者ID数组
        if (!is_array($skuIds)) {
            $skuIds = [$skuIds];
        }

        Auth::user()->cartItems()->whereIn('product_sku_id', $skuIds)->delete();
    }
}
