<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/15
 * Time: 9:36
 */

namespace App\Api\V1\Controllers;
use App\Api\V1\Repositories\RebateRepository;
use App\Api\V1\Transformers\HomeProductTransformer;
use Illuminate\Support\Facades\Cache;
use App\Api\V1\Repositories\ToolsRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use JWTAuth;
use JWTFactory;
use Tymon\JWTAuth\Exceptions\JWTException;
use Dingo\Api\Exception\ValidationHttpException;

class ToolsController extends BaseController
{
    protected $repository;
    public function __construct(ToolsRepository $toolsRepository){
        $this->repository = $toolsRepository;
    }

    /**
     * 获取所有分类列表
     */
    public function categoryList(){
        Cache::forget('app_categories');
        if(Cache::has('app_categories')){
            return Cache::store('file')->get('app_categories',function(){
                return $this->repository->getCategories();
            });
        }else{
            $data = $this->repository->getCategories();
            $expiresAt = Carbon::now()->addMinutes(24*60);
            Cache::put('app_categories',$data, $expiresAt);
            return $data;
        }
    }

    public function homeGoods(Request $request){
        $per_page = $request->get('per_page',10);
        $result = $this->repository->getHomeProduct($per_page);
        $result->appends('per_page',$per_page);
        return $this->response()->paginator($result,new HomeProductTransformer());
    }

    public function regionLists(Request $request){
        //Cache::forget('app_regions');
        if(Cache::has('app_regions')){
            return Cache::store('file')->get('app_regions',function(){
                return $this->repository->getRegions();
            });
        }else{
            $data = $this->repository->getRegions();
            $expiresAt = Carbon::now()->addMinutes(24*60*60);
            Cache::put('app_regions',$data, $expiresAt);
            return $data;
        }
    }

    public function rank(Request $request){
        $per_page = $request->get('per_page',10);
        $result = $this->repository->rank($per_page);
        $result->appends('per_page',$per_page);
        return $this->response()->paginator($result,new HomeProductTransformer());
    }

     public function tokenCheck(Request $request){
        $token = JWTAuth::getToken();
        try {
            JWTAuth::setToken($token)->getPayload();
        } catch (TokenExpiredException $e) {
            return $this->responseError(trans("messages.invalid_token"),$this->status_jwt_invalidate,401);
        } catch (JWTException $e) {
            return $this->responseError(trans("messages.invalid_token"),$this->status_jwt_invalidate,401);
        } catch (TokenBlacklistedException $e){
            return $this->responseError(trans("messages.invalid_token"),$this->status_jwt_invalidate,401);
        } catch (TokenInvalidException $e){
            return $this->responseError(trans("messages.invalid_token"),$this->status_jwt_invalidate,401);
        }
        return array();
    }

    public function test2(Request $request){
        $order_no =  $request->get('order_no','');
        RebateRepository::startRebateOrder($order_no);
    }

}