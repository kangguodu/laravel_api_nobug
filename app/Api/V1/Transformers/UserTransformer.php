<?php
namespace App\Api\V1\Transformers;

use App\User;
use League\Fractal\TransformerAbstract;


class UserTransformer extends TransformerAbstract
{
    public function transform(User $object){
        $object->avatar = empty($object->avatar)?url('/images/avatar/').'/003.png':$object->avatar;
        $result = array(
            'id' => $object->id,
            'email' => $object->email,
            'avatar' =>  $object->avatar,
            'status' => intval($object->status),
            'gender' => $object->gender,
            'nickname' => $object->nickname,
            'birthday' => $object->birthday,
            'sightml' => $object->sightml,
        );
        if(isset($object->token)){
            $result['token'] = $object->token;
        }
        if(isset($object->rebate_info)){
            $result['rebate_info'] = $object->rebate_info;
        }
        return $result;
    }
}