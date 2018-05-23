<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/20
 * Time: 11:40
 */

namespace App\Api\V1\Validators;
use Prettus\Validator\LaravelValidator;
use Prettus\Validator\Contracts\ValidatorInterface;

class CommentValidator extends LaravelValidator
{
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'goods_id' => 'required',
            'order_id'=> 'required',
            'rate' => 'required',
        ],
        'add'=> [
            'goods_id' => 'required',
            'order_id'=> 'required',
            'content'=> 'required',
        ],
    ];
}