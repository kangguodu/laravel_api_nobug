<?php
namespace App\Api\V1\Services;


class OrderService extends BaseService
{

    public static function getAppOrderConnomStatus(){
        $status = array(
            array(
                'status_id' => 0,
                'status_name' => '待付款',
                'is_refund' => 0, // 是否可以申請退款
                'operation' => array(

                ),
                'member_operation' => array(
                    '0' => array(
                        'no' => 5, 
                        'name' => '支付'
                    ),
                    '1' => array(
                        'no' => 6,
                        'name' => '取消訂單'
                    )
                )
            ),
            array(
                'status_id' => 5,
                'status_name' => '待發貨',
                'is_refund' => 1,
                'operation' => array(

                ),
                'member_operation' => array(
                    0 => array(
                        'no' => 13,
                        'name' => '已确认收货(待评价)'
                    ),
                    1 => array(
                        'no' => 17,
                        'name' => '已完成'
                    ),
                    2 => array(
                        'no' => -1,
                        'name' => '申請退款'
                    ),
                    3 => array(
                        'no' => 9,
                        'name' => '發貨'
                    )
                )
            ),
             array(
                'status_id' => 9,
                'status_name' => '已發貨',
                'is_refund' => 0,
                'operation' => array(),
                'member_operation' => array(
                    0 => array(
                        'no' => 13,
                        'name' => '已确认收货(待评价)'
                    ),
                    1 => array(
                        'no' => 17,
                        'name' => '已完成'
                    ),
                    2 => array(
                        'no' => -1,
                        'name' => '申請退款'
                    )
                )
            ),
            array(
                'status_id' => 6,
                'status_name' => '已取消',
                'is_refund' => 0,
                'operation' => array(),
                'member_operation' => array()
            ),
            array(
                'status_id' => 13,
                'status_name' => '確認收貨',
                'is_refund' => 0,
                'operation' => array(),
                'member_operation' => array(
                    0 => array(
                        'no' => 17,
                        'name' => '評價完成'
                    )
                )
            )
        );
        return $status;
    }

    public static function getOrderCommonStatus(){
        $status = array(
            array(
                'status_id' => '0',
                'status_name' => '待付款',
                'is_refund' => 0, // 是否可以申請退款
                'operation' => array(
                    '0' => array(
                        'no' => 'pay',
                        'name' => '線下支付',
                        'color' => '#FF9800'
                    ),
                    '1' => array(
                        'no' => 'close',
                        'color' => '#E61D1D',
                        'name' => '交易關閉'
                    ),
                    '2' => array(
                        'no' => 'adjust_price',
                        'color' => '#4CAF50',
                        'name' => '修改價格'
                    ),
                    '3' => array(
                        'no' => 'seller_memo',
                        'color' => '#8e8c8c',
                        'name' => '添加備注'
                    )
                ),
                'member_operation' => array(
                    '0' => array(
                        'no' => 'pay',//2
                        'name' => '去支付',
                        'color' => '#F15050'
                    ),

                    '1' => array(
                        'no' => 'close',//6
                        'name' => '取消訂單',
                        'color' => '#999999'
                    )
                )
            ),
            array(
                'status_id' => '5',
                'status_name' => '待發貨',
                'is_refund' => 1,
                'operation' => array(
                    '0' => array(
                        'no' => 'delivery',
                        'color' => 'green',
                        'name' => '發貨'
                    ),
                    '1' => array(
                        'no' => 'seller_memo',
                        'color' => '#8e8c8c',
                        'name' => '添加備注'
                    ),
                    '2' => array(
                        'no' => 'update_address',
                        'color' => '#51A351',
                        'name' => '修改地址'
                    )
                ),
                'member_operation' => array(
//                    '0' => array(
//                        'no' => 'push_shipment',
//                        'name' => '催發貨',
//                        'color' => '#FF6600'
//                    ),
                )
            ),
            array(
                'status_id' => '9',
                'status_name' => '已發貨',
                'is_refund' => 1,
                'operation' => array(
                    '0' => array(
                        'no' => 'seller_memo',
                        'color' => '#8e8c8c',
                        'name' => '添加備注'
                    ),
                    '1' => array(
                        'no' => 'logistics',
                        'color' => '#ccc',
                        'name' => '查看物流'
                    ),
                    '2' => array(
                        'no' => 'getdelivery',
                        'name' => '確認收貨',
                        'color' => '#FF6600'
                    )
                ),

                'member_operation' => array(
                    '0' => array(
                        'no' => 'getdelivery',//13
                        'name' => '確認收貨',
                        'color' => '#FF6600'
                    ),
                    '1' => array(
                        'no' => 'logistics', 
                        'color' => '#ccc',
                        'name' => '查看物流'
                    ),
                    '2' => array(
                        'no' => 'delay_receving', //11 
                        'name' => '延遲收貨',
                        'color' => '#FF6600'
                    ),
                )
            ),
            array(
                'status_id' => '13',
                'status_name' => '已收貨',
                'is_refund' => 0,
                'operation' => array(
                    '0' => array(
                        'no' => 'seller_memo',
                        'color' => '#8e8c8c',
                        'name' => '添加備注'
                    ),
                    '1' => array(
                        'no' => 'logistics',
                        'color' => '#ccc',
                        'name' => '查看物流'
                    )
                ),
                'member_operation' => array(
                    '0' => array(
                        'no' => 'logistics',
                        'color' => '#ccc',
                        'name' => '查看物流'
                    ),
                    '1' => array(
                        'no' => 'comment', 
                        'color' => '#ccc',
                        'name' => '立即評價'
                    )
                )
            ),
            array(
                'status_id' => '17',
                'status_name' => '已完成',
                'is_refund' => 0,
                'operation' => array(
                    '0' => array(
                        'no' => 'seller_memo',
                        'color' => '#8e8c8c',
                        'name' => '添加備注'
                    ),
                    '1' => array(
                        'no' => 'logistics',
                        'color' => '#ccc',
                        'name' => '查看物流'
                    )
                ),
                'member_operation' => array(
                    '0' => array(
                        'no' => 'logistics',
                        'color' => '#ccc',
                        'name' => '查看物流'
                    ),
                    '1' => array(
                        'no' => 'comment',
                        'color' => '#ccc',
                        'name' => '立即評價'
                    ),
                    '2' => array(
                        'no' => 'delete_order',
                        'color' => '#ff0000',
                        'name' => '刪除訂單'
                    )
                )
            ),
            array(
                'status_id' => '21',
                'status_name' => '已關閉',
                'is_refund' => 0,
                'operation' => array(
                    '0' => array(
                        'no' => 'seller_memo',
                        'color' => '#8e8c8c',
                        'name' => '添加備注'
                    ),
                    '1' => array(
                        'no' => 'delete_order',
                        'color' => '#ff0000',
                        'name' => '刪除訂單'
                    )
                ),
                'member_operation' => array(
                    '0' => array(
                        'no' => 'delete_order',
                        'color' => '#ff0000',
                        'name' => '刪除訂單'
                    )
                )
            ),
            array(
                'status_id' => '-1',
                'status_name' => '退款申請中',
                'is_refund' => 1,
                'operation' => array(
                    '0' => array(
                        'no' => 'seller_memo',
                        'color' => '#8e8c8c',
                        'name' => '添加備注'
                    )
                ),
                'member_operation' => array()
            ),
            array(
                'status_id' => '-2',
                'status_name' => '退款中',
                'is_refund' => 1,
                'operation' => array(
                    '0' => array(
                        'no' => 'seller_memo',
                        'color' => '#8e8c8c',
                        'name' => '添加備注'
                    )
                ),
                'member_operation' => array()
            ),
            array(
                'status_id' => '-3',
                'status_name' => '已退款',
                'is_refund' => 1,
                'operation' => array(
                    '0' => array(
                        'no' => 'seller_memo',
                        'color' => '#8e8c8c',
                        'name' => '添加備注'
                    )
                ),
                'member_operation' => array()
            )
        );
        return $status;
    }

    public static function userOrderTypeCondition($type = 0){

        $condition = array(
            0 => array(),
            1 => array(
                'orders.order_status' => 0,
            ),
            2 => array(
                'orders.order_status' => 5,
                'orders.order_type' => 2,
                ['orders.group_time','=','0'], //未成團成功
            ),
            3 => array(
                'orders.order_status' => 5,
                ['orders.group_time','>','0'], //成團成功
            ),
            4 => array(
                'orders.order_status' => 9
            ),
            5 => array(
                'orders.order_status' => 13
            )
        );
        return $condition[$type];
    }
    public static function getRefundCommonStatus(){
        $status = array(
            array(
                'status_id' => '1',
                'status_name' => '無售後',
                'afterSalesType'=> '0',
                'member_operation' => array(
                    '0' => array(
                        'name' => '申請售後',
                    ),
                )
            ),
            array(
                'status_id' => '2',
                'afterSalesType'=> '0',
                'status_name' => '售後已取消',
                'is_refund' => 1,
                'member_operation' => array(
                    '0' => array(
                        'name' => '申請售後',
                    ),
                ),
            ),
            array(
                'status_id' => '3',
                'afterSalesType'=> '1',
                'status_name' => '退款申請中，待賣家處理',
                'member_operation' => array(
                    '0' => array(
                        'name' => '待賣家處理(詳情)'
                    ),
                ),
            ),
            array(
                'status_id' => '3',
                'afterSalesType'=> '2',
                'status_name' => '退貨退款申請中，待賣家處理',
                'member_operation' => array(
                    '0' => array(
                        'name' => '待賣家處理(詳情)'
                    ),
                ),
            ),
            array(
                'status_id' => '4',
                'status_name' => '退款中，請稍後',
                'afterSalesType'=> '1',
                'member_operation' => array(
                    '0' => array(
                        'name' => '待賣家處理(詳情)'
                    )
                )
            ),
            array(
                'status_id' => '5',
                'status_name' => '退款成功',
                'is_refund' => 0,
                'member_operation' => array(
                    '0' => array(
                        'name' => '退款成功(詳情)'
                    ),
                    '1' => array(
                        'name' => '錢款去向'
                    )
                ),
            ),
            array(
                'status_id' => '21',
                'status_name' => '已關閉',
                'is_refund' => 0,
                'operation' => array(
                    '0' => array(
                        'no' => 'seller_memo',
                        'color' => '#8e8c8c',
                        'name' => '添加備注'
                    ),
                    '1' => array(
                        'no' => 'delete_order',
                        'color' => '#ff0000',
                        'name' => '刪除訂單'
                    )
                ),
                'member_operation' => array(
                    '0' => array(
                        'no' => 'delete_order',
                        'color' => '#ff0000',
                        'name' => '刪除訂單'
                    )
                )
            ),
            array(
                'status_id' => '-1',
                'status_name' => '退款申請中',
                'is_refund' => 1,
                'operation' => array(
                    '0' => array(
                        'no' => 'seller_memo',
                        'color' => '#8e8c8c',
                        'name' => '添加備注'
                    )
                ),
                'member_operation' => array()
            ),
            array(
                'status_id' => '-2',
                'status_name' => '退款中',
                'is_refund' => 1,
                'operation' => array(
                    '0' => array(
                        'no' => 'seller_memo',
                        'color' => '#8e8c8c',
                        'name' => '添加備注'
                    )
                ),
                'member_operation' => array()
            ),
            array(
                'status_id' => '-3',
                'status_name' => '已退款',
                'is_refund' => 1,
                'operation' => array(
                    '0' => array(
                        'no' => 'seller_memo',
                        'color' => '#8e8c8c',
                        'name' => '添加備注'
                    )
                ),
                'member_operation' => array()
            )
        );
        return $status;
    }

    /**
     * 队列 延时时间，单位: 秒
     * @param string $operation
     * @return integer
     */
    public static function getQueueDelayConfig($operation = 'cancel_order'){
        $config =  array(
            'cancel_order' => 1 * 60, //1天 未付款 自动取消订单
            'close_group' => 1 * 60, //1天 之后，团未成功，自动完成
            'auto_refund' => 2 * 60, //2天 自动退款
            'close_service' => 15 * 60, //15天 之后关闭订单售后服务
        );
        return isset($config[$operation])?$config[$operation]:0;
    }

    public static function generateOrderNo($user_id = 0){
        return date('ymdHis').mt_rand(10,99).sprintf('%05d',$user_id).mt_rand(10,99);
    }

    public static function getOrderPaymentType(){
        return array(
          array(
               'name' => '貨到付款',
               'paymentType' => 2,
          ),
        );

    }

    public static function getCheckoutPaymentType($paymentType){
        $paymentInfo = self::getOrderPaymentType();
        $result = 2;
        foreach ($paymentInfo as $value){
            if(isset($value['paymentType']) && $value['paymentType'] == $paymentType){
                $result = $value['paymentType'];
                break;
            }
        }
        return $result;
    }

    /**
     * 拼團 團長返利百分比
     * @param $groupMemberCount
     * @return float
     */
    public static function getGroupHeadPercent($groupMemberCount){
        $basePercent = (3/100);
        $groupPercent = array(
            '2' => $basePercent * 2,
            '3' => $basePercent * 3,
            '4' => $basePercent * 4
        );
        return isset($groupPercent[$groupMemberCount])?$groupPercent[$groupMemberCount]:0;
    }

    /**
     * 交易手續費
     * @return float
     */
    public static function getServiceCharge(){
        return 0.6/100; //0.6%
    }

    public static function queryOrderStatusField(){
        return array(
            'id',
            'buyer_id',
            'mall_id',
            'order_no',
            'goods_id',
            'goods_name',
            'goods_price',
            'order_status',
            'pay_status',
            'after_sales',
            'order_type',
            'sku_id',
            'sku_number',
            'group_order_id',
            'order_no',
            'integration_fee',
            'amount',
        );
    }

    public static function addCancelOrderQueue($orderId){
        $job = (new \App\Jobs\Orders($orderId))->onQueue('order')->delay(self::getQueueDelayConfig('cancel_order'));
        dispatch($job);
    }

    public static function addCancelGroupQueue($groupOrderId,$order_id){
        $job = (new \App\Jobs\Group($groupOrderId,$order_id))->onQueue('group')->delay(self::getQueueDelayConfig('close_group'));
        dispatch($job);
    }

    public static function addAutoRefundOverQueue($orderId){
        $job = (new \App\Jobs\RefundOver($orderId))->onQueue('refund_over')->delay(self::getQueueDelayConfig('close_service'));
        dispatch($job);
    }

    public static function addAutoRefundQueue($refundOrderId,$orderId){
        $job = (new \App\Jobs\AutoRefund($refundOrderId,$orderId))->onQueue('auto_refund')->delay(self::getQueueDelayConfig('auto_refund'));
        dispatch($job);
    }

    public static function addSyncRebateOrderQueue($orderId){
        \Log::debug('add sync create order Job: '.$orderId);
        $syncJob = (new \App\Jobs\SyncSingleOrderJob($orderId))->onQueue('sync_order');
        dispatch($syncJob);
    }
}