<?php
namespace App\Api\V1\Validators;

use Prettus\Validator\LaravelValidator;
use Prettus\Validator\Contracts\ValidatorInterface;

class IntegrationValidator extends LaravelValidator
{
    protected $rules = [
       ValidatorInterface::RULE_CREATE => [
            'cat_name' => 'required'
        ],
        ValidatorInterface::RULE_UPDATE => [
            'id' => 'required',
            'cat_name' => 'required',
            'parent_id' => 'required'
        ],
        'login' => [
            'email' => 'required',
            'password' => 'required'
        ],
        'change_password' => [
            'old_password' => 'required',
            'password' => 'required',
            'password_confirmation' => 'required',
        ],
        'sign_up' => [
            'email' => 'required|unique:member,email',
            'password' => 'required|min:6'
        ]
    ];
}