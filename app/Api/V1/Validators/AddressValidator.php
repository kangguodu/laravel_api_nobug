<?php

namespace App\Api\V1\Validators;

use Prettus\Validator\LaravelValidator;
use Prettus\Validator\Contracts\ValidatorInterface;

class AddressValidator extends LaravelValidator
{
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'name' => 'required',
            'mobile' => 'required',
            'province_id' => 'required',
            'city_id' => 'required',
            'address' => 'required',
        ],
        ValidatorInterface::RULE_UPDATE => [
            'id' => 'required',
            'name' => 'required',
            'mobile' => 'required',
            'province_id' => 'required',
            'city_id' => 'required',
            'address' => 'required',
        ],
        'delete' => [
            'id' => 'required'
        ]
    ];

    protected $attributes = [
        'name' => '姓名',
        'mobile' => '手機號碼',
        'province_id' => '省市',
        'city_id' => '省市',
        'address' => '詳細地址',
    ];
}