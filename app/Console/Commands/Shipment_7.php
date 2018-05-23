<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
class Shipment_7 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Shipment_7';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '用戶已發貨，商家七天未處理';

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
        $shipment_7 = DB::table('orders')->join('order_refund','orders.id','=','order_id')
            ->where('status',2)
            ->whereBetween('buyer_shipment_time',[0,time()-7*24*3600])
            ->where('submit_at','<=',time()-7*24*3600)
            ->select([
                'orders.id as order_id',
                'order_refund.id as refund_id'
            ])
            ->get();
        if($shipment_7){
            foreach ($shipment_7 as $v){
                DB::transaction(function() use($v){
                    DB::table('orders')->where('id',$v->order_id)->update(['order_status'=>-2,'after_sales'=>4]);
                    DB::table('order_refund')->where('id',$v->refund_id)->update(['status'=>3]);
                });

            }
        }

    }
}
