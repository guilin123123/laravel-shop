<?php

namespace App\Providers;

use App\Events\OrderPaid;
use App\Events\OrderReviewed;
use App\Listeners\SendOrderPaidMail;
use App\Listeners\UpdateProductRating;
use App\Listeners\UpdateProductSoldCount;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        // 订单完成后续商品数据的处理
        // 订单完成后发送邮件通知
        OrderPaid::class => [
            UpdateProductSoldCount::class,
            SendOrderPaidMail::class,
        ],
        // 评价完成更新商品的评分
        OrderReviewed::class => [
            UpdateProductRating::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
