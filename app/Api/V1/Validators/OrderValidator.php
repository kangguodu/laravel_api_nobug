<?php
namespace App\Api\V1\Validators;

use Prettus\Validator\LaravelValidator;
use Prettus\Validator\Contracts\ValidatorInterface;
class OrderValidator extends LaravelValidator
{
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'address_id' => 'required',
            'goods' => 'required|array|min:1',
            'goods.*.sku_id' => 'required|integer|min:1',
            'goods.*.sku_number' => 'required|integer|min:1',
            'goods.*.goods_id' => 'required|integer|min:1',
        ],
        ValidatorInterface::RULE_UPDATE => [
            'id' => 'required',
            'cat_name' => 'required',
            'parent_id' => 'required'
        ],
        'simple_pay' => [
            'order_id' => 'required',
        ],
        'cancel'=>[
            'order_id' => 'required',
            'reason' => 'required',
            'type' => 'required',
        ],
        'address'=>[
            'order_id' => 'required',
            'address_id' => 'required',
        ],
        'prepay' => [
            'order_sn' => 'required',
            'app_id' => 'required'
        ]
    ];

    protected $messages = array(
        'address_id' => '收貨地址編號',
        'payment_type' => '支付方式',
        'goods' => '商品',
        'goods.*.sku_id' => '商品規格編號',
        'goods.*.sku_number' => '購買商品數量',
        'goods.*.goods_id' => '商品編號',
        'order_sn' => '订单编号',
        'app_id' => '支付方式ID'
    );
}