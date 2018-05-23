<?php
namespace App\Api\V1\Services;

/**
 *  積分計劃服務類
 * Class RebateOrderService
 * @package App\Api\V1\Services
 */
class RebateService
{
    /**
     * 生成 訂單號
     * @param $order_count
     * @param $out_order_no
     * @return string
     */
    public function generateOrderNo($order_count,$out_order_no){
        $order_count += mt_rand(10,99);
        return $out_order_no.'i18'.sprintf('%07d',$order_count).mt_rand(10,99);
    }


    public static function OrderStatus(){
        $status = array(
            0 => array(
                'title' => '待返利',
                'code' => 'REBATE_CREATE',
            ),
            1 => array(
                'title' => '待返利',
                'code' => 'REBATE_WAIT',
            ),
            2 => array(
                'title' => '返利中',
                'code' => 'REBATE_START'
            ),
            3 => array(
                'title' => '回贈完畢',
                'code' => 'REBATE_FINISH',
            ),
            4 => array(
                'title' => '取消返利',
                'code' => 'REBATE_CANCEL',
            ),
            5 => array(
                'title' => '返利異常',
                'code' => 'REBATE_ERROR'
            )
        );

    }
}