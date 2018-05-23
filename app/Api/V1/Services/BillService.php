<?php
namespace App\Api\V1\Services;

use App\BillDaily;
use App\BillMonth;

/**
 * 賬單服務類
 * Class BillService
 * @package App\Api\V1\Services
 */
class BillService extends BaseService
{

    public static function updateBillDailyAndMonth($mall_id,$number = 0,$amount = 0,$isIncome = false){
        $dailyDate = date('Y-m-d');
        $monthDate = date('Y-m-01');
        $dailyModel = new BillDaily();
        $monthModel = new BillMonth();
        if($isIncome){
            self::updateBillReport($dailyModel,$dailyDate,$mall_id,$number,$amount,0,0);
            self::updateBillReport($monthModel,$monthDate,$mall_id,$number,$amount,0,0);
        }else{
            self::updateBillReport($dailyModel,$dailyDate,$mall_id,0,0,$number,$amount);
            self::updateBillReport($monthModel,$monthDate,$mall_id,0,0,$number,$amount);
        }
    }

    //更新日账单
    public static function updateBillReport($model,$bill_date,$mall_id,$income_number = 0,$income_amount = 0,$outcome_number = 0,$outcome_amount = 0){
        $dailyData = $model->where('mall_id',$mall_id)
            ->where('bill_date',$bill_date)
            ->first([
                'id',
                'income_number',
                'income_amount',
                'outcome_number',
                'outcome_amount',
                'before_amount',
                'after_amount',
            ]);
        if($dailyData == null){
            $afterAmount = $model->where(['mall_id'=>$mall_id])->where('bill_date','<',$bill_date)
                ->orderBy('bill_date','DESC')
                ->first(['after_amount']);
            if($afterAmount ==null){
                $beforeAmount = 0;
            }else{
                $beforeAmount = $afterAmount->after_amount;
            }
            $initData = [
                'mall_id' => $mall_id,
                'bill_date' => $bill_date,
                'income_number' => $income_number,
                'income_amount'  => $income_amount,
                'outcome_number'  => $outcome_number,
                'outcome_amount'  => $outcome_amount,
                'before_amount'  => $beforeAmount,
                'after_amount'  => ($beforeAmount + $income_amount + $outcome_amount),
                'created_at' => date('Y-m-d H:i:s')
            ];
            $model->insert($initData);
        }else{
            $dailyData->income_number += $income_number;
            $dailyData->income_amount += $income_amount;
            $dailyData->outcome_number += $outcome_number;
            $dailyData->outcome_amount += $outcome_amount;
            $dailyData->after_amount = ($dailyData->before_amount + $dailyData->income_amount + $dailyData->outcome_amount);
            $dailyData->save();
        }
    }
}