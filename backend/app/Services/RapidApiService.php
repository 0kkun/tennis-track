<?php

namespace App\Services;

use App\Services\Interfaces\RapidApiServiceInterface;
use GuzzleHttp\Client;
use Illuminate\Support\Carbon;

class RapidApiService implements RapidApiServiceInterface
{
    private $headers;

    private Client $client;

    private const RAPID_API_ENDPOINT = 'https://tennisapi1.p.rapidapi.com/api/tennis/';

    public function __construct()
    {
        $this->client = new Client();
        $this->headers = [
            'Content-Type' => 'application/json',
            'x-rapidapi-host' => env('RAPID_API_HOST'),
            'x-rapidapi-key' => env('RAPID_API_KEY'),
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function getAtpRankings()
    {
        $path = self::RAPID_API_ENDPOINT.'rankings/atp';
        $response = $this->client->request('GET', $path, ['headers' => $this->headers]);

        if ($response->getStatusCode() !== 200) {
            throw new \Exception($response->getBody()->getContents());
        }
        $result = json_decode($response->getBody()->getContents(), true);

        return $this->makeRankingsResponse($result);
    }

    /**
     * {@inheritDoc}
     */
    public function getPlayer(int $id)
    {
        $path = self::RAPID_API_ENDPOINT.'player/'.$id;
        $response = $this->client->request('GET', $path, ['headers' => $this->headers]);

        if ($response->getStatusCode() !== 200) {
            throw new \Exception($response->getBody()->getContents());
        }
        $result = json_decode($response->getBody()->getContents(), true);

        return $this->makePlayerResponse($result);
    }

    private function makeRankingsResponse(mixed $result): array
    {
        $updatedAt = Carbon::createFromTimestamp($result['updatedAtTimestamp']);
        $rankings = [];
        $players = [];

        foreach ($result['rankings'] as $ranking) {
            $rankings[] = [
                'player_id' => $ranking['team']['id'],
                'ranking' => $ranking['ranking'] ?? 0,
                'point' => $ranking['points'] ?? 0,
                'played_count' => $ranking['tournamentsPlayed'] ?? 0,
                'ranking_date' => $updatedAt,
                'previous_point' => $ranking['previousPoints'] ?? 0,
                'movement' => array_key_exists('previousRanking', $ranking) ? $ranking['previousRanking'] - $ranking['ranking'] : 0,
            ];
            $players[] = [
                'player_id' => $ranking['team']['id'],
                'name_en' => $ranking['rowName'] ?? '',
                'abbreviation' => $ranking['team']['nameCode'] ?? '',
                'gender' => $ranking['team']['gender'], // M
                'country' => $ranking['team']['country']['name'] ?? '',
                'country_code' => $ranking['team']['country']['alpha3'] ?? '',
                'highest_singles_ranking' => $ranking['bestRanking'] ?? 0,
            ];
        }

        return [$rankings, $players];
    }

    private function makePlayerResponse(mixed $result): array
    {
        $team = $result['team'];
        $player = [
            'player_id' => $team['id'],
            'name_en' => $team['fullName'] ?? '',
            'abbreviation' => $team['nameCode'] ?? '',
            'gender' => $team['gender'],
            'country' => $team['country']['name'] ?? '',
            'country_code' => $team['country']['alpha3'] ?? '',
            'birthday' => Carbon::createFromTimestamp($team['playerTeamInfo']['birthDateTimestamp']),
            'pro_year' => $team['playerTeamInfo']['turnedPro'] ?? null,
            'handedness' => $team['playerTeamInfo']['plays'],
            'weight' => $team['playerTeamInfo']['weight'],
            'height' => $team['playerTeamInfo']['height'] ?? 0,
        ];

        return $player;
    }
}
