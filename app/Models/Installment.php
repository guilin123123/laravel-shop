<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Installment extends Model
{
    const STATUS_PENDING = 'pending';
    const STATUS_REPAYING = 'repaying';
    const STATUS_FINISHED = 'finished';

    public static $statusMap = [
        self::STATUS_PENDING  => '未执行',
        self::STATUS_REPAYING => '还款中',
        self::STATUS_FINISHED => '已完成',
    ];

    protected $fillable = ['no', 'total_amount', 'count', 'fee_rate', 'fine_rate', 'status'];

    protected static function boot()
    {
        parent::boot();

        // 监听模型创建时间, 在写入数据库之前触发
        static::creating(function ($model) {
            // 如果模型的 no 字段为空
            if (!$model->no) {
                // 调用 findAvailableNo 方法生成分期流水号
                $model->no = static::findAvailableNo();
                // 生成失败 终止创建订单
                if (!$model->no) {
                    return false;
                }
            }
        });
    }

    // 关联用户
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 关联订单
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // 关联分期项
    public function items()
    {
        return $this->hasMany(InstallmentItem::class);
    }

    public static function findAvailableNo()
    {
        // 前缀
        $prefix = date('YmdHis');

        // 循环10次
        for ($i = 0; $i < 10; $i++) {
            // 随机生成 6 位的数字
             $no = $prefix.str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

             // 判断是否已经存在
             if (!static::query()->where('no', $no)->exists()) {
                 // 不存在即返回
                 return $no;
             }

             // 写入日志文件
             Log::warning(sprintf('find installment no failed'));

             // 返回失败
             return false;
        }
    }

    public function refreshRefundStatus()
    {
        $allSuccess = true;
        // 重新加载 items，保证与数据库中数据同步
        $this->load(['items']);
        foreach ($this->items as $item) {
            if ($item->paid_at && $item->refund_status !== InstallmentItem::REFUND_STATUS_SUCCESS) {
                $allSuccess = false;
                break;
            }
        }
        if ($allSuccess) {
            $this->order->update([
                'refund_status' => Order::REFUND_STATUS_SUCCESS,
            ]);
        }
    }
}
