<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/15
 * Time: 9:37
 */

namespace App\Api\V1\Repositories;

use Config;

class ToolsRepository
{


    public function getCategories(){
        $parent_categories = (new \App\Category())->where('parent_id','=',0)
            ->get();
        $result = array();
        $imageUrl = Config::get('ijoins.backend_public').'/upload/category/';
        foreach ($parent_categories as $value){
            $temp = array(
                'id' => $value->id,
                'name' => $value->cat_name,
                'logo' => $imageUrl.$value->img,
                'cat2' => array()
            );
            $categories = (new \App\Category())->whereBetween('lft',[$value->lft,$value->rgt])
                ->orderBy('level','ASC')->get();
            foreach($categories as $v1=>$v2){
                $tempChild = array(
                    'id' => $v2->id,
                    'name' => $v2->cat_name
                );
                if($v2->level == 2){
                    if(array_key_exists($v2->parent_id,$temp['cat2'])){
                        $temp['cat2'][$v2->parent_id]['cat3'][] = $tempChild;
                    }
                }else if($v2->level == 1){
                    $tempChild['img'] =  $imageUrl.$v2->img;
                    $tempChild['cat3'] = array(
                        array(
                            'id' => 0,
                            'name' => '全部'
                        )
                    );
                    if(!array_key_exists($v2->id,$temp['cat2'])){
                        $temp['cat2'][$v2->id] = $tempChild;
                    }
                }
            }
            $temp['cat2'] =array_merge($temp['cat2'],array());
            array_push($result,$temp);
        }
        return $result;
    }
    
    public function getHomeProduct($page_size = 10){
        return (new \App\Goods())->where('goods.is_onsale','=',1)
            ->where('goods.checked','=',1)
            ->where('goods.is_sku',0)
            ->select([
                'goods.id',
                'goods.goods_name',
                'goods.tiny_name',
                'goods.image_url',
                'goods.sold_quantity',
                'goods.prom_price',
                'goods.shop_price',
                'goods.prom',
                'goods.market_price',
                'goods.hd_thumb_url',
            ])
            ->paginate($page_size);
    }

    public function getRegions(){

        $regions = (new \App\Region())->select([
            'region_id',
            'region_name',
            'parent_id'
        ])->get()->toArray();
        $new = array();
        foreach ($regions as $a){
            $new[$a['parent_id']][] = $a;
        }
        $tree = $this->createTree($new, array($regions[0]));
        return $this->formatTree($tree);
    }

    function createTree(&$list, $parent){
        $tree = array();
        foreach ($parent as $k=>$l){
            if(isset($list[$l['region_id']])){
                $l['children'] = $this->createTree($list, $list[$l['region_id']]);
            }
            $tree[] = $l;
        }
        return $tree;
    }

    function formatTree($data){
        $result = array(
            array('options' => array()),
            array('options' => array()),
        );
        //level 1
        foreach($data[0]['children'] as $value){
            array_push($result[0]['options'],array(
                'text' => $value['region_name'],
                'value' => $value['region_id']
            ));
            foreach($value['children'] as $v){
                array_push($result[1]['options'],array(
                    'text' => $v['region_name'],
                    'value' => $v['region_id'],
                    'parentVal' => $v['parent_id']
                ));
            }
        }
        return $result;
    }
    public function rank($page_size = 10){
        return (new \App\Goods())->where('goods.is_onsale','=',1)
            ->where('goods.checked','=',1)
            ->where('goods.is_sku',0)
            ->select([
                'goods.id',
                'goods.goods_name',
                'goods.tiny_name',
                'goods.image_url',
                'goods.sold_quantity',
                'goods.prom_price',
                'goods.shop_price',
                'goods.prom',
                'goods.market_price',
                'goods.hd_thumb_url',
            ])
            ->orderBy('sold_quantity','DESC')
            ->paginate($page_size);
    }

}