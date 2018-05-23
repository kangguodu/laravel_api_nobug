<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
class Refund_24 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Refund_24';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '商家24小時未處理,自動退款';

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
        $refund_24 = DB::table('orders')->join('order_refund','orders.id','=','order_id')
            ->where(['order_status'=>-1,'after_sales'=>3,'status'=>1])
            ->where('submit_at','<=',time()-48*3600)
            ->select([
                'orders.id as order_id',
                'order_refund.id as refund_id'
            ])
            ->get();
        if($refund_24){
            foreach ($refund_24 as $v){
                DB::transaction(function() use($v) {
                    DB::table('orders')->where('id', $v->order_id)->update(['order_status' => -2, 'after_sales' => 4]);
                    DB::table('order_refund')->where('id', $v->refund_id)->update(['status' => 3]);
                });
            }
        }
    }
}
