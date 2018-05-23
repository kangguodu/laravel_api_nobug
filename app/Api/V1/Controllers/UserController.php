<?php
namespace App\Api\V1\Controllers;


use App\Api\V1\Transformers\UserTransformer;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Tymon\JWTAuth\Facades\JWTAuth;
use Prettus\Validator\Exceptions\ValidatorException;
use Illuminate\Validation\ValidationException;
use Validator;

use App\Member;
use App\Api\V1\Repositories\AuthRepository;
use App\Api\V1\Validators\AuthValidator;


class UserController extends BaseController
{

    protected $authRepository;
    protected $authValidator;


    use  AuthenticatesUsers;
    protected $guard = 'customers';


    public function __construct(AuthRepository $authRepository,AuthValidator $authValidator){
        $this->authRepository = $authRepository;
        $this->authValidator = $authValidator;
    }

    public function login(Request $request){
        $credentials = $request->only(['email','password']);
        try{
            $this->authValidator->with($credentials)->passesOrFail('login');
            try {
               // array_push($credentials,false);
                if (! $token = JWTAuth::attempt($credentials)) {
                    return $this->responseError(trans("messages.auth_error"),$this->status_login_error);
                }
            } catch (JWTException $e) {
                return $this->responseError(trans("messages.auth_error"),$this->status_login_error);
            }
            $user = $this->authRepository->getByPhone($credentials['email']);
            $user->token = $token;
            return $this->response()->item($user,new UserTransformer());
        }catch (ValidatorException $e){
            return $this->responseError($e->getMessageBag()->first(),$this->status_validator_error,422);
        }

    }

    public function signUp(Request $request)
    {
        $credentials = $request->all();
        try{
            $this->authValidator->with($credentials)->passesOrFail('sign_up');
            $result = $this->authRepository->signUp($credentials);
            if($result){
                return array('success' => true);
            }else{
                return array('success' => false);
            }
        }catch (ValidatorException $e){
            return $this->responseError($e->getMessageBag()->first(),$this->status_validator_error,422);
        }
    }

    public function userInfo(Request $request){
        $user = $this->auth->user();
        $user_id = $user->id;
        $userInfo = $this->authRepository->getById($user_id);
        return $this->response()->item($userInfo,new UserTransformer());
    }

    public function updateUser(Request $request){
        $credentials = $request->all();
        $user = $this->auth->user();
        $this->authRepository->updateProfile($credentials,$user);
        return array();
    }

    public function changepassword(Request $request){
        $credentials = $request->only(
            'old_password', 'password', 'password_confirmation'
        );
        //get jwt auth user info
        $user = $this->auth->user();
        $hashed_password = $user->password;
        $message = array(
            'old_password.password_hash_check' => "舊密碼不正確",
        );
        $validator = Validator::make($credentials, [
            'old_password' => 'required|password_hash_check:'.$hashed_password,
            'password' => 'required|confirmed|min:6',
        ],$message);

        if($validator->fails()) {
            return $this->responseError($validator->errors()->first(),422);
        }
        $user->password = $credentials['password'];
        $user->save();
        return array();
    }

    public function logout(Request $request){
        $token = JWTAuth::getToken();
        try {
            JWTAuth::setToken($token)->invalidate();
        } catch (TokenExpiredException $e) {
            return $this->responseError(trans("messages.logout_success"),$this->status_jwt_invalidate,401);
        } catch (JWTException $e) {
            return $this->responseError(trans("messages.logout_success"),$this->status_jwt_invalidate,401);
        } catch (TokenBlacklistedException $e){
            return $this->responseError(trans("messages.logout_success"),$this->status_jwt_invalidate,401);
        } catch (TokenInvalidException $e){
            return $this->responseError(trans("messages.logout_success"),$this->status_jwt_invalidate,401);
        }
        return array();
    }


}