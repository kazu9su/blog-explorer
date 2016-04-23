<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use DB;
use Illuminate\Console\Command;
use App\RssHistory;
use Log;

class DeleteRss extends Command
{
    const DAYS = 14;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rss:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete RSS older than 2 weeks ago';

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
        try {
            DB::transaction(function () {   
                RssHistory::where('date', '<', Carbon::now()->subDays(self::DAYS)->toIso8601String())->delete();
            });
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            Log::error($e->getTrace());
        }
    }
}
