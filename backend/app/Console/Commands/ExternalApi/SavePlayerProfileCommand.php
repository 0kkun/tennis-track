<?php

namespace App\Console\Commands\ExternalApi;

use App\Modules\ApplicationLogger;
use App\Services\Interfaces\ExternalApiServiceInterface;
use Carbon\Carbon;
use Illuminate\Console\Command;
use TennisTrack\Player\Domain\Models\TennisPlayer;
use TennisTrack\Player\Domain\Models\TennisPlayers;
use TennisTrack\Player\UseCase\GetTennisPlayer;
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
        private GetTennisPlayer $getTennisPlayerUseCase,
        private UpsertPlayer $upsertPlayerUseCase,
        private ExternalApiServiceInterface $externalAPiService,
    ) {
        parent::__construct();
        $this->getTennisPlayerUseCase = $getTennisPlayerUseCase;
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
        $this->info('get existing players from db');
        $existingPlayers = $this->getTennisPlayerUseCase->execute();
        $chunk = array_chunk($existingPlayers, 50);

        $progressBar = $this->output->createProgressBar(count($chunk));
        $progressBar->start();

        // FIXME: APIの制限があるため、必要な分だけ取得するように修正する
        try {
            $players = [];
            foreach ($chunk[0] as $existingPlayer) {
                $path = Endpoint::fromArray([
                    'api_name' => ApiName::playerProfile(),
                    'player_id_main' => $existingPlayer['id'],
                ])->path();
                $result = $this->externalAPiService->execute($path);
                if (array_key_exists('player', $result)) {
                    $players[] = $this->makePlayerFromResponse($result['player']);
                    $progressBar->advance(1);
                }
            }
        } catch (\Exception $e) {
            $progressBar->finish();
            $this->error($e->getMessage());
            $logger->exception($e);

            return;
        }

        $this->info('insert new players from db');
        $this->upsertPlayerUseCase->execute(TennisPlayers::fromArray($players));
        $this->info('[ Finish ]');
        $progressBar->finish();
        $logger->success();
    }

    /**
     * @param array $playerResponse
     * @return TennisPlayer
     */
    private function makePlayerFromResponse(array $playerResponse): TennisPlayer
    {
        $birthday = array_key_exists('date_of_birth', $playerResponse) ? Carbon::parse($playerResponse['date_of_birth']) : null;

        return TennisPlayer::fromArray([
            'id' => $playerResponse['id'],
            'name_ja' => $playerResponse['name'],
            'country' => $playerResponse['nationality'] ?? null,
            'country_code' => $playerResponse['country_code'] ?? null,
            'abbreviation' => $playerResponse['abbreviation'] ?? null,
            'gender' => $playerResponse['gender'],
            'birthday' => $birthday,
            'pro_year' => $playerResponse['pro_year'] ?? null,
            'handedness' => $playerResponse['handedness'] ?? null,
            'height' => $playerResponse['height'] ?? null,
            'weight' => $playerResponse['weight'] ?? null,
            'highest_singles_ranking' => $playerResponse['highest_singles_ranking'] ?? null,
            'highest_doubles_ranking' => $playerResponse['highest_doubles_ranking'] ?? null,
        ]);
    }
}
