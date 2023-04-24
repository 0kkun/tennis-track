<?php

namespace App\Console\Commands\Scraping;

use App\Services\Interfaces\TennisScrapingServiceInterface;
use Illuminate\Console\Command;
use App\Modules\ApplicationLogger;

class ScrapeTennisRankingCommand extends Command
{
    protected $signature = 'command:ScrapeTennisRanking';
    protected $description = 'テニスのランキングデータをスクレイピングで取得するコマンド';

    /* 進捗表示バー用 */
    private const PROCESS_COUNT = 150;

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
     * @return void
     */
    public function handle(): void
    {
        $logger = new ApplicationLogger(__METHOD__);
        $this->info("[ Start ]");
        $progressBar = $this->output->createProgressBar(self::PROCESS_COUNT);
        $progressBar->start();
        try {
            $tennisRankings = $this->tennisScrapingService->scrapeTennisRanking($progressBar);
            $this->info("\n" . 'スクレイピング' . count($tennisRankings) . '件取得完了');
            $logger->write(print_r($tennisRankings, true));
        } catch (\Exception $e) {
            $logger->exception($e);
            throw $e;
        }
        $progressBar->finish();
        $this->info("[ Finish ]");
        $logger->success();
    }
}
