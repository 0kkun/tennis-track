<?php

namespace App\Services;

use App\Services\Interfaces\TranslateServiceInterface;
use League\OAuth2\Client\Provider\GenericProvider;

class TranslateService implements TranslateServiceInterface
{
    private const API_NAME = 'mt';

    private const API_PARAM = 'generalNT_ja_en';

    private const BASE_API_URL = 'https://mt-auto-minhon-mlt.ucri.jgn-x.jp';

    /**
     * {@inheritDoc}
     */
    public function translateByMihon(array $requestParams): array
    {
        $provider = new GenericProvider(
            [
                'clientId' => env('MIHON_API_KEY'),
                'clientSecret' => env('MIHON_API_SECRET'), // API secret
                'redirectUri' => '', // リダイレクトURI（不要）
                'urlAuthorize' => '', // 認可コード取得URI（不要）
                'urlAccessToken' => self::BASE_API_URL.'/oauth2/token.php', // アクセストークン取得URI
                'urlResourceOwnerDetails' => '',
            ],
        );
        $accessToken = $provider->getAccessToken('client_credentials');
        // プロバイダは、アクセストークンを用いて、サービスに対する認証済みAPIリクエストを取得する方法を提供する
        $params = [
            'access_token' => $accessToken->getToken(),
            'key' => env('MIHON_API_KEY'),
            'api_name' => self::API_NAME,
            'api_param' => self::API_PARAM,
            'name' => env('MIHON_LOGIN_ID'),
            'type' => 'json', // レスポンスタイプ
        ] + $requestParams;

        $request = $provider->getAuthenticatedRequest(
            'POST',
            self::BASE_API_URL.'/api/?'.http_build_query($params), // URL + URLパラメータ
            $accessToken,
        );
        $response = $provider->getResponse($request);
        $results = $response->getBody()->getContents();

        return json_decode($results, true);
    }
}
