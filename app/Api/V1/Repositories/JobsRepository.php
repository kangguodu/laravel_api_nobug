<?php
namespace App\Api\V1\Repositories;

use App\Order;
use App\OrderGroup;
use App\OrderGroupDetail;
use App\Jobs\RefundOver as RefundOverJob;
use App\Jobs\Orders as CancelOrderJob;
use App\Api\V1\Services\OrderService;

class JobsRepository
{
    /**
     * 未付款的订单,24小时之后未支付，自动取消订单
     * @param $order_id
     */
    public function autoCancelPayFailOrder($order_id){
        \Log::debug("autocancel");
        $signalOrder = (new Order())->where('id',$order_id)
            ->where('order_status',0)
            ->first([
                'order_status',
                'goods_id',
                'sku_number',
                'sku_id',
                'order_time'
            ]);
        if($signalOrder){
            $order_time = $signalOrder->order_time + OrderService::getQueueDelayConfig('cancel_order');
            if($order_time <= time()){
                //到时间 修改订单状态
                $this->cancelOrder($order_id,$signalOrder->goods_id,$signalOrder->sku_id,$signalOrder->sku_number);
            }else{
                //未到时间 重新将订单加入到队列中
                $delay_time = time() - $order_time;
                if($delay_time > 0){
                    $job = (new CancelOrderJob($order_id))->onQueue('order')->delay($delay_time);
                    dispatch($job);
                }
            }
        }
    }

    /**
     * @param $order_id
     * @param int $goods_id
     * @param int $sku_id
     * @param int $sku_number
     * @return bool
     */
    public function cancelOrder($order_id,$goods_id = 0,$sku_id = 0,$sku_number = 0){
        \DB::beginTransaction();
        try{
            \DB::table('orders')->where('id', $order_id)->update(['order_status'=>6, 'cancel_time' =>time()]);
            \DB::table('goods')->where('id', $goods_id)->increment('goods_total', $sku_number);
            \DB::table('goods_sku')->where('sku_id', $sku_id)->increment('stock', $sku_number);
            \DB::commit();
            return true;
        }catch (\Exception $e){
            \DB::rollback();
            \Log::error("cancel order fail".$e->getMessage().', '.$e->getLine());
            return false;
        }
    }

    /**
     * @param $group_id
     */
    public function autoCancelGroup($group_order_id,$order_id){
        $count = (new OrderGroup())->where('group_order_status',1)
            ->where('group_order_id',$group_order_id)
            ->count();
        if($count){
            \DB::beginTransaction();
            try{
                (new OrderGroup())->where('group_order_id',$group_order_id)->update([
                    'group_order_status' => 3,
                    'success_time' => time()
                ]);

                (new Order())->where('id',$order_id)->update(['group_time'=>time()]);

                \DB::commit();

            }catch (\Exception $e){
                \DB::rollback();
                \Log::error("cancel group fail".$e->getMessage().', '.$e->getLine());
            }
        }

    }

}