<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use App\Jobs\Group;

class Groups extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Cancel';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '取消拼團';

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

        $group = DB::table('orders_group')->where('end_time','<=',time())->where('group_order_status',1)->select('group_order_id')->get();
        if($group){
            foreach ($group as $v){
                $job = (new Group($v->group_order_id));
                dispatch($job);

            }
        }


    }

}
