<?php

namespace App\Console\Commands\Scraping;

use App\Services\Interfaces\TennisScrapingServiceInterface;
use Illuminate\Console\Command;
use App\Modules\ApplicationLogger;

class ScrapeTennisRankingCommand extends Command
{
    protected $signature = 'command:ScrapeTennisRanking';
    protected $description = 'テニスのランキングデータをスクレイピングで取得するコマンド';

    /**
     * @param TennisScrapingServiceInterface $tennisScrapingService
     */
    public function __construct(
        private TennisScrapingServiceInterface $tennisScrapingService,
    )
    {
        parent::__construct();
        $this->tennisScrapingService = $tennisScrapingService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $logger = new ApplicationLogger(__METHOD__);
        $this->info("[ Start ]");
        $tennisRankings = $this->tennisScrapingService->scrapeTennisRanking();
        $this->info('スクレイピング' . count($tennisRankings) . '件取得完了');
        $this->info("[ Finish ]");
        $logger->success();
        return Command::SUCCESS;
    }
}
