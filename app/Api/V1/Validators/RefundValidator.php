<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/24
 * Time: 9:38
 */

namespace App\Api\V1\Validators;
use Prettus\Validator\LaravelValidator;
use Prettus\Validator\Contracts\ValidatorInterface;

class RefundValidator extends LaravelValidator
{
    protected $rules = [
        'add'=>[
            'order_id' => 'required',
            'type' => 'required',
            'reason' => 'required',
            'money'=>'required',
            'remark'=>'max:170',
            'phone'=>'required',
        ],
        'update'=>[
            'id' => 'required',
            'type' => 'required',
            'reason' => 'required',
            'remark'=>'max:170',
            'money'=>'required',
            'phone'=>'required',
        ],
        'apply'=>[
            'refund_id'=> 'required',
            'remark' => 'required',
        ],
        'remark'=>[
            'refund_id'=> 'required',
        ]
    ];
}