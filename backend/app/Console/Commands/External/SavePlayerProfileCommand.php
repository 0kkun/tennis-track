<?php

namespace App\Console\Commands\External;

use App\Modules\ApplicationLogger;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use TennisTrack\Player\Domain\Models\Player;
use TennisTrack\SportRadar\Domain\Models\ApiName;
use TennisTrack\SportRadar\Domain\Models\Endpoint;

class SavePlayerProfileCommand extends Command
{
    protected $signature = 'command:SavePlayerProfile {--playerId= : プレイヤ-ID}';

    protected $description = '選手のプロフィール情報を外部APIで取得し保存するコマンド';

    public function __construct(
    ) {
        parent::__construct();
    }

    /**
     * @return void
     */
    public function handle(): void
    {
        $logger = new ApplicationLogger(__METHOD__);
        $this->info('[ Start ]');

        $apiKey = env('SPORT_RADAR_API_KEY');
        $playerId = $this->option('playerId');
        if (empty($playerId)) {
            // デフォルトはジョコビッチ
            $playerId = 'sr:competitor:14882';
        }
        // 選手プロフィール取得のエンドポイント生成
        $endpointForProfile = Endpoint::fromArray([
            'api_name' => ApiName::playerProfile(),
            'player_id_main' => $playerId,
        ])->path()->toString();

        $client = new Client();
        $response = $client->request('GET', $endpointForProfile, [
            'query' => [
                'api_key' => $apiKey,
            ],
        ], [
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ]);
        $body = $response->getBody();
        $result = json_decode($body, true);

        if (array_key_exists('error', $result)) {
            $this->info('[ Finish ]');
            $logger->failure();

            return;
        }

        if (array_key_exists('player', $result)) {
            $playerProfileResponse = $result['player'];
            $playerProfile = Player::fromArray([
                'id' => $playerProfileResponse['id'],
                'name_ja' => $playerProfileResponse['name'],
                'country' => $playerProfileResponse['nationality'],
                'country_code' => $playerProfileResponse['country_code'],
                'abbreviation' => $playerProfileResponse['abbreviation'],
                'gender' => $playerProfileResponse['gender'],
                'birthday' => Carbon::parse($playerProfileResponse['date_of_birth']),
                'pro_year' => $playerProfileResponse['pro_year'],
                'handedness' => $playerProfileResponse['handedness'],
                'height' => $playerProfileResponse['height'],
                'weight' => $playerProfileResponse['weight'],
                'highest_singles_ranking' => $playerProfileResponse['highest_singles_ranking'],
                'highest_doubles_ranking' => $playerProfileResponse['highest_doubles_ranking'],
            ]);
            dd($playerProfile);
        }

        $this->info('[ Finish ]');
        $logger->success();
    }
}
