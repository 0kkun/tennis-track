<?php

declare(strict_types=1);

namespace App\Console\Commands\ExternalApi\RapidApi;

use App\Modules\ApplicationLogger;
use App\Services\Interfaces\RapidApiServiceInterface;
use Illuminate\Console\Command;
use TennisTrack\Player\UseCase\UpsertPlayer;
use TennisTrack\Ranking\UseCase\UpsertTennisRanking;

class SaveTennisRankingCommand extends Command
{
    protected $signature = 'command:RapidSaveTennisRanking';

    protected $description = 'テニスのランキングデータを外部API(RapidApi)で取得し保存するコマンド';

    /**
     * @param RapidApiServiceInterface $rapidApiService
     * @param UpsertTennisRanking $upsertTennisRankingUseCase
     * @param UpsertPlayer $upsertPlayerUseCase
     */
    public function __construct(
        private RapidApiServiceInterface $rapidApiService,
        private UpsertTennisRanking $upsertTennisRankingUseCase,
        private UpsertPlayer $upsertPlayerUseCase
    ) {
        parent::__construct();
        $this->rapidApiService = $rapidApiService;
        $this->upsertTennisRankingUseCase = $upsertTennisRankingUseCase;
        $this->upsertPlayerUseCase = $upsertPlayerUseCase;
    }

    /**
     * @return void
     */
    public function handle(): void
    {
        $logger = new ApplicationLogger(__METHOD__);
        $this->info('[ Start ]');
        // $rankings = $this->rapidApiService->getAtpRankings();
        $player = $this->rapidApiService->getPlayer(14882);
        $logger->write(print_r($player, true));
        $this->info('[ End ]');
        $logger->success();
    }
}
