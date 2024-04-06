<?php

declare(strict_types=1);

namespace App\Console\Commands\ExternalApi;

use App\Modules\ApplicationLogger;
use App\Services\Interfaces\ExternalApiServiceInterface;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use TennisTrack\Player\Domain\Models\TennisPlayer;
use TennisTrack\Player\Domain\Models\TennisPlayers;
use TennisTrack\Player\UseCase\UpsertPlayer;
use TennisTrack\Ranking\Domain\Models\TennisRanking;
use TennisTrack\Ranking\Domain\Models\TennisRankings;
use TennisTrack\Ranking\Domain\Models\Type;
use TennisTrack\Ranking\UseCase\UpsertTennisRanking;
use TennisTrack\SportRadar\Domain\Models\ApiName;
use TennisTrack\SportRadar\Domain\Models\Endpoint;

class SaveTennisRankingCommand extends Command
{
    protected $signature = 'command:SaveTennisRanking';

    protected $description = 'テニスのランキングデータを外部APIで取得し保存するコマンド';

    private $generatedAt;

    /**
     * @param ExternalApiServiceInterface $externalAPiService
     * @param UpsertTennisRanking $upsertTennisRankingUseCase
     * @param UpsertPlayer $upsertPlayerUseCase
     */
    public function __construct(
        private ExternalApiServiceInterface $externalAPiService,
        private UpsertTennisRanking $upsertTennisRankingUseCase,
        private UpsertPlayer $upsertPlayerUseCase
    ) {
        parent::__construct();
        $this->externalAPiService = $externalAPiService;
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

        // ATPランキング
        $path = Endpoint::fromArray([
            'api_name' => ApiName::playerRankings()->toString(),
        ])->path();

        try {
            $result = $this->externalAPiService->execute($path);

            if (array_key_exists('generated_at', $result)) {
                $this->generatedAt = Carbon::parse($result['generated_at']);
            }

            if (array_key_exists('rankings', $result)) {
                [$tennisRankings, $players] = $this->makeRankingsFromResponse($result['rankings']);
            }
        } catch (\Exception $e) {
            $logger->exception($e);

            return;
        }

        DB::transaction(function () use ($tennisRankings, $players) {
            $this->upsertPlayerUseCase->execute(TennisPlayers::fromArray($players));
            $this->upsertTennisRankingUseCase->execute(TennisRankings::fromArray($tennisRankings));
        });

        $this->info('[ Finish ]');
        $logger->success();
    }

    /**
     * @param array $rankings
     * @return array
     */
    private function makeRankingsFromResponse(array $rankings): array
    {
        $wtaRankings = $rankings[0]['player_rankings'];
        $atpRankings = $rankings[1]['player_rankings'];

        $tennisRankings = [];
        $players = [];
        foreach ($atpRankings as $atpRanking) {
            $tennisRankings[] = TennisRanking::fromArray([
                'rank' => $atpRanking['rank'],
                'player_id' => $atpRanking['player']['id'],
                'point' => $atpRanking['points'],
                'movement' => $atpRanking['ranking_movement'],
                'played_count' => $atpRanking['tournaments_played'],
                'type' => Type::asAtpSingles()->toString(),
                'ranking_date' => $this->generatedAt,
            ]);
            $players[] = TennisPlayer::fromArray([
                'id' => $atpRanking['player']['id'],
                'name_ja' => $atpRanking['player']['name'],
                'country' => $atpRanking['player']['nationality'],
                'country_code' => $atpRanking['player']['country_code'] ?? null,
                'abbreviation' => $atpRanking['player']['abbreviation'] ?? null,
            ]);
        }

        foreach ($wtaRankings as $wtaRanking) {
            $tennisRankings[] = TennisRanking::fromArray([
                'rank' => $wtaRanking['rank'],
                'player_id' => $wtaRanking['player']['id'],
                'point' => $wtaRanking['points'],
                'movement' => $wtaRanking['ranking_movement'],
                'played_count' => $wtaRanking['tournaments_played'],
                'type' => Type::asWtaSingles()->toString(),
                'ranking_date' => $this->generatedAt,
            ]);
            $players[] = TennisPlayer::fromArray([
                'id' => $wtaRanking['player']['id'],
                'name_ja' => $wtaRanking['player']['name'],
                'country' => $wtaRanking['player']['nationality'],
                'country_code' => $wtaRanking['player']['country_code'] ?? null,
                'abbreviation' => $wtaRanking['player']['abbreviation'] ?? null,
            ]);
        }

        return [$tennisRankings, $players];
    }
}
