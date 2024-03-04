<?php

namespace App\Console\Commands\Scraping;

use App\Modules\ApplicationLogger;
use App\Repositories\Interfaces\PlayerRepositoryInterface;
use App\Services\Interfaces\TennisScrapingServiceInterface;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ScrapeTennisPlayerInfoCommand extends Command
{
    protected $signature = 'command:ScrapeTennisPlayerInfo';

    protected $description = 'テニスの選手データ詳細をスクレイピングで取得するコマンド';

    /* 進捗表示バー用 */
    private const PROCESS_COUNT = 150;

    /* playersテーブル保存時のチャンクサイズ */
    private const CHUNK_SIZE = 10;

    /* アップデート対象のplayersテーブルのカラム */
    private const UPDATE_COLUMNS = [
        'name_en',
        'country',
        'sport_category_id',
        'dominant_arm',
        'birthday',
        'turn_to_pro_year',
        'height',
        'weight',
        'updated_at',
    ];

    /**
     * @param TennisScrapingServiceInterface $tennisScrapingService
     * @param PlayerRepositoryInterface $playerRepository
     */
    public function __construct(
        private TennisScrapingServiceInterface $tennisScrapingService,
        private PlayerRepositoryInterface $playerRepository,
    ) {
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
        $this->info('[ Start ]');
        $progressBar = $this->output->createProgressBar(self::PROCESS_COUNT);
        try {
            $logger->write('スクレイピング開始');
            $this->info("\nスクレイピング開始");
            $tennisPlayers = $this->tennisScrapingService->scrapeTennisPlayerInfo($progressBar);
            if (empty($tennisPlayers)) {
                throw new \Exception('スクレイピングに失敗しました.');
            }
            $progressBar->finish();
            $logger->write('スクレイピング'.count($tennisPlayers).'件取得完了');
            $this->info("\n".'スクレイピング'.count($tennisPlayers).'件取得完了');

            $logger->write('playersテーブル更新開始');
            $this->info("\n playersテーブル更新開始");
            $chunks = array_chunk($tennisPlayers, self::CHUNK_SIZE);
            DB::transaction(function () use ($chunks) {
                foreach ($chunks as $chunk) {
                    $this->playerRepository->updateMultiple($chunk, self::UPDATE_COLUMNS);
                }
            });
            $logger->write('playersテーブル更新終了');
            $this->info("\n playersテーブル更新終了");
        } catch (\Exception $e) {
            $logger->exception($e);
            throw $e;
        }
        $this->info('[ Finish ]');
        $logger->success();
    }
}
