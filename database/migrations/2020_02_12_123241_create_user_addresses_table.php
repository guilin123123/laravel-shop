<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 收货地址
        Schema::create('user_addresses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');// 设置外键user_id
            $table->string('province')->comment('省');
            $table->string('city')->comment('市');
            $table->string('district')->comment('地区');
            $table->string('address')->comment('地址');
            $table->unsignedInteger('zip')->comment('邮编');
            $table->string('contact_name')->comment('联系人姓名');
            $table->string('contact_phone')->comment('联系人电话');
            $table->dateTime('last_used_at')->nullable()->comment('最后一次使用时间');
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
        Schema::dropIfExists('user_addresses');
    }
}
