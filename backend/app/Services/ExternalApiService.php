<?php

namespace App\Services;

use App\Services\Interfaces\ExternalApiServiceInterface;
use GuzzleHttp\Client;
use TennisTrack\SportRadar\Domain\Models\Path;

class ExternalApiService implements ExternalApiServiceInterface
{
    /**
     * {@inheritDoc}
     */
    public function execute(Path $path): mixed
    {
        $client = new Client();
        $query = ['api_key' => env('SPORT_RADAR_API_KEY')];
        $headers = ['Accept' => 'application/json', 'Content-Type' => 'application/json'];
        $response = $client->request('GET', $path->toString(), ['query' => $query], ['headers' => $headers]);

        if ($response->getStatusCode() !== 200) {
            throw new \Exception($response->getBody()->getContents());
        }

        return json_decode($response->getBody()->getContents(), true);
    }
}
