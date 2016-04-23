<?php

namespace App\Console\Commands;

use App\Services\RssRetrievalService;
use Illuminate\Console\Command;

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

            $this->retrievalService->saveRssHistory($items);
        } catch (\Exception $e) {
            var_dump($e->getMessage());
        }
    }
}

