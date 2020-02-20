<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupon_codes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->comment('优惠券标题');
            $table->string('code')->unique()->comment('优惠码');
            $table->string('type')->comment('优惠券类型,支持百分比抵扣和固定金额');
            $table->decimal('value')->comment('折扣值,类型不同含义不同');
            $table->unsignedInteger('total')->comment('全站可兑换数量');
            $table->unsignedInteger('used')->default(0)->comment('全站已兑换数量');
            $table->decimal('min_amount', 10, 2)->comment('使用该优惠券的最低订单金额');
            $table->datetime('not_before')->nullable()->comment('在这个时间之前不可用');
            $table->datetime('not_after')->nullable()->comment('在这个时间之后不可用');
            $table->boolean('enabled')->comment('是否生效');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coupon_codes');
    }
}
