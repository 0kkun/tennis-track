<?php

namespace App\Console\Commands\ExternalApi;

use App\Modules\ApplicationLogger;
use App\Services\Interfaces\ExternalApiServiceInterface;
use Carbon\Carbon;
use Illuminate\Console\Command;
use TennisTrack\Player\Domain\Models\TennisPlayer;
use TennisTrack\Player\Domain\Models\TennisPlayers;
use TennisTrack\Player\UseCase\UpsertPlayer;
use TennisTrack\SportRadar\Domain\Models\ApiName;
use TennisTrack\SportRadar\Domain\Models\Endpoint;

class SavePlayerProfileCommand extends Command
{
    protected $signature = 'command:SavePlayerProfile {--playerId= : プレイヤ-ID}';

    protected $description = '選手のプロフィール情報を外部APIで取得し保存するコマンド';

    /**
     * @param UpsertPlayer $upsertPlayerUseCase
     * @param ExternalApiServiceInterface $externalAPiService
     */
    public function __construct(
        private UpsertPlayer $upsertPlayerUseCase,
        private ExternalApiServiceInterface $externalAPiService,
    ) {
        parent::__construct();
        $this->upsertPlayerUseCase = $upsertPlayerUseCase;
        $this->externalAPiService = $externalAPiService;
    }

    /**
     * @return void
     */
    public function handle(): void
    {
        $logger = new ApplicationLogger(__METHOD__);
        $this->info('[ Start ]');

        $playerId = $this->option('playerId');
        if (empty($playerId)) {
            // デフォルトはジョコビッチ
            $playerId = 'sr:competitor:14882';
        }
        // 選手プロフィール取得のエンドポイント生成
        $path = Endpoint::fromArray([
            'api_name' => ApiName::playerProfile(),
            'player_id_main' => $playerId,
        ])->path();

        try {
            $result = $this->externalAPiService->execute($path);
            if (array_key_exists('player', $result)) {
                $player = $this->makePlayerFromResponse($result['player']);
                $this->upsertPlayerUseCase->execute(TennisPlayers::fromArray([$player]));
            }
        } catch (\Exception $e) {
            $logger->exception($e);

            return;
        }

        $this->info('[ Finish ]');
        $logger->success();
    }

    /**
     * @param array $playerResponse
     * @return TennisPlayer
     */
    private function makePlayerFromResponse(array $playerResponse): TennisPlayer
    {
        return TennisPlayer::fromArray([
            'id' => $playerResponse['id'],
            'name_ja' => $playerResponse['name'],
            'country' => $playerResponse['nationality'],
            'country_code' => $playerResponse['country_code'],
            'abbreviation' => $playerResponse['abbreviation'],
            'gender' => $playerResponse['gender'],
            'birthday' => Carbon::parse($playerResponse['date_of_birth']),
            'pro_year' => $playerResponse['pro_year'],
            'handedness' => $playerResponse['handedness'],
            'height' => $playerResponse['height'],
            'weight' => $playerResponse['weight'],
            'highest_singles_ranking' => $playerResponse['highest_singles_ranking'],
            'highest_doubles_ranking' => $playerResponse['highest_doubles_ranking'],
        ]);
    }
}
