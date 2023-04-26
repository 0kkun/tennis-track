<?php

namespace App\Console\Commands\Scraping;

use App\Services\Interfaces\TennisScrapingServiceInterface;
use Illuminate\Console\Command;
use App\Modules\ApplicationLogger;
use App\Repositories\Interfaces\PlayerRepositoryInterface;
use Illuminate\Support\Facades\DB;

class ScrapeTennisPlayerCommand extends Command
{
    protected $signature = 'command:ScrapeTennisPlayer';
    protected $description = 'テニスの選手データをスクレイピングで取得するコマンド';

    /* 進捗表示バー用 */
    private const PROCESS_COUNT = 12139;
    /* playersテーブル保存時のチャンクサイズ */
    private const CHUNK_SIZE = 1000;

    /**
     * @param TennisScrapingServiceInterface $tennisScrapingService
     * @param PlayerRepositoryInterface $playerRepository
     */
    public function __construct(
        private TennisScrapingServiceInterface $tennisScrapingService,
        private PlayerRepositoryInterface $playerRepository,
    )
    {
        parent::__construct();
        $this->tennisScrapingService = $tennisScrapingService;
        $this->playerRepository = $playerRepository;
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
        try {
            $logger->write('スクレイピング開始');
            $this->info("\nスクレイピング開始");
            $tennisPlayers = $this->tennisScrapingService->scrapeTennisPlayer($progressBar);
            if (empty($tennisPlayers)) throw new \Exception('スクレイピングに失敗しました.');
            $progressBar->finish();
            $logger->write('スクレイピング' . count($tennisPlayers) . '件取得完了');
            $this->info("\n" . 'スクレイピング' . count($tennisPlayers) . '件取得完了');

            $logger->write('playersテーブルへ保存開始');
            $this->info("\n playersテーブルへ保存開始");
            $chunks = array_chunk($tennisPlayers, self::CHUNK_SIZE);
            DB::transaction(function () use ($chunks) {
                foreach ($chunks as $chunk) {
                    $this->playerRepository->upsertByNameEn($chunk);
                }
            });
            $logger->write('playersテーブルへ保存終了');
            $this->info("\n playersテーブルへ保存終了");

        } catch (\Exception $e) {
            $logger->exception($e);
            throw $e;
        }
        $this->info("[ Finish ]");
        $logger->success();
    }
}
