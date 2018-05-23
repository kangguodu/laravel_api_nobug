<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use DB;

/**
 * 自动退款
 * Class AutoRefund
 * @package App\Jobs
 */
class AutoRefund implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $refund_id;
    protected $order_id;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($refund_id,$order_id)
    {
        $this->refund_id = $refund_id;
        $this->order_id = $order_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //商家48小時未處理，自動退款
        $refund_id = $this->refund_id;
        $order_id = $this->order_id;

        $count = DB::table('order_refund')->join('orders','orders.id','=','order_id')
            ->where(['order_status'=>-1,'after_sales'=>3,'status'=>1,'order_refund.id'=>$refund_id])
            ->where('submit_at','<=',time()-48*3600)
            ->count();
        if($count){
            DB::transaction(function() use($refund_id,$order_id) {
                DB::table('orders')->where('id', $order_id)->update(['order_status' => -2, 'after_sales' => 4]);
                DB::table('order_refund')->where('id',$refund_id)->update(['status' => 3]);
            });
        }
    }
}
