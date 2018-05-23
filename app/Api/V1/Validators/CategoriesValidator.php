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

class CategoriesValidator extends LaravelValidator
{
    protected $rules = [
        'search' => [
            'keyword' =>'required'
        ]
    ];
}