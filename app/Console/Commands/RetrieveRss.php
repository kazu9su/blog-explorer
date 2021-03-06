<?php

namespace App\Console\Commands;

use App\Services\RssRetrievalService;
use DB;
use Illuminate\Console\Command;
use Log;

class RetrieveRss extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rss:retrieve';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Retrieve RSS of FC2BLOG';

    /**
     * @var RssRetrievalService
     */
    protected $retrievalService;

    /**
     * Create a new command instance.
     * RetrieveRss constructor.
     * @param RssRetrievalService $retrievalService
     */
    public function __construct(RssRetrievalService $retrievalService)
    {
        $this->retrievalService = $retrievalService;
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
            $items = $this->retrievalService->retrieve();
            DB::transaction(function () use ($items) {
                $this->retrievalService->saveRssHistory($items);
            });
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            Log::error($e->getTrace());
        }
    }
}

