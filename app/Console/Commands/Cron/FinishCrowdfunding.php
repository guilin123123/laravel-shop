<?php

namespace App\Console\Commands\Cron;

use App\Jobs\RefundCrowdfundingOrders;
use App\Models\CrowdfundingProduct;
use App\Models\Order;
use App\Services\OrderService;
use DemeterChain\C;
use const Grpc\STATUS_FAILED_PRECONDITION;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class FinishCrowdfunding extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:finish-crowdfunding';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '结束众筹';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        CrowdfundingProduct::query()
            // 众筹结束时间早于当前时间
            ->where('end_at', '<=', Carbon::now())
            // 众筹状态为众筹中
            ->where('status', CrowdfundingProduct::STATUS_FUNDING)
            ->get()
            ->each(function (CrowdfundingProduct $crowdfundingProduct) {
                // 如果众筹目标金额大于实际众筹金额
                if ($crowdfundingProduct->torget_amount > $crowdfundingProduct->total_amount) {
                    // 众筹失败
                    $this->crowfundinfFailed($crowdfundingProduct);
                } else {
                    // 众筹成功
                    $this->crowfundingSucceed($crowdfundingProduct);
                }
            });
    }

    protected function crowfundingSucceed(CrowdfundingProduct $crowdfundingProduct)
    {
        $crowdfundingProduct->update([
            'status' => CrowdfundingProduct::STATUS_SUCCESS,
        ]);
    }

    protected function crowfundinfFailed(CrowdfundingProduct $crowdfundingProduct)
    {
        $crowdfundingProduct->update([
            'status' => CrowdfundingProduct::STATUS_FAIL,
        ]);

        // 订单退款逻辑
        dispatch(new RefundCrowdfundingOrders($$crowdfundingProduct));
    }
}
