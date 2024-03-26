<?php

// declare(strict_types=1);

namespace App\Console\Commands\External;

use App\Modules\ApplicationLogger;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use TennisTrack\SportRadar\Domain\Models\ApiName;
use TennisTrack\SportRadar\Domain\Models\Endpoint;

class SaveAtpRankingCommand extends Command
{
    protected $signature = 'command:SaveAtpRanking';

    protected $description = 'テニスのATPランキングデータを外部APIで取得し保存するコマンド';

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

        // "https://api.sportradar.com"
        $endpointBase = env('SPORT_RADAR_API_ENDPOINT_BASE');
        $apiKey = env('SPORT_RADAR_API_KEY');
        $languageCode = 'ja';
        $sport = 'tennis';
        $accesslevel = 'trial';
        $version = 'v2';
        $format = 'json';
        $competitorId = 'sr:competitor:14882';

        // 選手プロフィール
        $endpointForProfile = Endpoint::fromArray([
            'api_name' => ApiName::playerProfile(),
            'player_id_main' => $competitorId,
        ])->path()->toString();

        // dd($endpointForProfile);

        // ATPランキング
        $endpointForRanking = Endpoint::fromArray([
            'api_name' => ApiName::playerRankings()->toString(),
        ])->path()->toString();
        // プレイヤーの直接対決
        $endpointForHeadToHead = Endpoint::fromArray([
            'api_name' => ApiName::playerHeadToHead()->toString(),
            'player_id_main' => $competitorId,
            'player_id_sub' => 'sr:competitor:14882',
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
        $logger->writeArray($result);
        dd(1);
        if (array_key_exists('rankings', $result)) {
            $playerRankings = $result['rankings'];
            // dd($playerRankings[1]['player_rankings'][0]);
            $wtaRankings = $playerRankings[0]['player_rankings'];
            $atpRankings = $playerRankings[1]['player_rankings'];
            dd(count($atpRankings));
            // $logger->writeArray($playerRankings);
        }

        $this->info('[ Finish ]');
        $logger->success();
    }
}
