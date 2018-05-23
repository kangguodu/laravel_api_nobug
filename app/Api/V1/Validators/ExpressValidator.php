<?php
namespace App\Api\V1\Validators;

use Prettus\Validator\LaravelValidator;
use Prettus\Validator\Contracts\ValidatorInterface;

class ExpressValidator extends LaravelValidator
{
    protected $rules = [
        'get_cost'=> [
            'goods_id' => 'required',
            'sku_id'=> 'required',
            'cost_template_id'=> 'required',
            'province_id'=> 'required',
            'goods_item'=> 'required',
            'goods_weight'=> 'required',
            'order_amount'=> 'required',
            'uid' => 'required'
        ],
    ];

    protected $messages = array(
        'goods_id' => '商品編號',
        'sku_id'=> '規格編號',
        'cost_template_id'=> '運費模板編號',
        'province_id'=> '省份編號',
        'goods_item'=> '購買數量',
        'goods_weight'=> '商品重量',
        'order_amount'=> '商品單價',
        'uid' => '會員編號'
    );
}