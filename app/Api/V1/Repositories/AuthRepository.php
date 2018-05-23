<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/19
 * Time: 9:36
 */

namespace App\Api\V1\Repositories;


use App\User;
use Config;

class AuthRepository
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @todo 修改默認頭像url
     */
    public function signUp($request){
        $email = $request['email'];
        if(is_numeric($email)){
            if(strlen($email) >= 10){
                $replace_str = substr($email,3,4);
                $email = str_replace($replace_str,'****',$email);
            }
        }
        $userData = array(
            'email' => $request['email'],
            'nickname' => $email,
            'password' => $request['password'],
            'avatar' => 'http://office.techrare.com:5681/wopinapi/public/upload/avatar/003.png',
            'source' => 4,
        );
        User::unguard();
        $user = User::create($userData);
        User::reguard();
        if(!$user->id) {
            return false;
        }else{
            return true;
        }
    }

    public function getByPhone($email){
        $userInfo = $this->user->select('id','email','avatar','gender','status','sightml','nickname','birthday')
            ->where('email', $email)
            ->first();
        return $userInfo;
    }

    public function getById($id){
        $userInfo = $this->user->select('id','email','avatar','gender','status','sightml','nickname','birthday')
            ->where('id', $id)
            ->first();
        return $userInfo;
    }

    private function updateDataFilter($request,$keys){
        $data = array();
        foreach ($keys as $key=>$value){
            if(isset($request[$value])){
                $data[$value] = $request[$value];
            }
        }
        return $data;
    }

    public function updateProfile($request,$user){
        $update_field = array('nickname','avatar','sightml','birthday','gender');
        $data = $this->updateDataFilter($request,$update_field);
        if(count($data)){
            (new User())->where('id','=',$user->id)
                ->update($data);
        }
    }
}