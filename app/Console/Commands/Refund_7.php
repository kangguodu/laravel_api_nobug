<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
class Refund_7 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Refund_7';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '買家7天未處理，退款失敗';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $refund_7 = DB::table('orders')->join('order_refund','orders.id','=','order_id')
            ->where(function($query){
                $query->where('status',6)->orWhere('status',7);
            })
            ->where('submit_at','<=',time()-7*24*3600)
            ->select([
                'orders.id as order_id',
                'order_refund.id as refund_id'
            ])
            ->get();
        if($refund_7){
            foreach ($refund_7 as $v){
                DB::transaction(function() use($v) {
                    $status = DB::table('order_refund')->where('id', $v->refund_id)->select('old_order_status')->first();
                    DB::table('orders')->where('id', $v->order_id)->update(['order_status' => intval($status->old_order_status), 'after_sales' => 6]);
                    DB::table('order_refund')->where('id', $v->refund_id)->update(['status' => 14]);
                });
            }
        }
    }
}
