<?php

namespace App\Http\Controllers\Apis\V1\Admins\Translate;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admins\Translate\TranslateByMihonRequest;
use App\Http\Resources\Translate\TranslateByMihonResource;
use App\Modules\ApplicationLogger;
use App\Services\Interfaces\TranslateServiceInterface;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;

class TranslateController extends Controller
{
    /**
     * @param TranslateServiceInterface $translateService
     */
    public function __construct(
        private TranslateServiceInterface $translateService,
    ) {
        $this->translateService = $translateService;
    }

    /**
     * みんなの自動翻訳APIを使用した、日本語->英語 翻訳API
     *
     * @param TranslateByMihonRequest $request
     * @throws IdentityProviderException
     * @return TranslateByMihonResource
     */
    public function translateByMihon(TranslateByMihonRequest $request): TranslateByMihonResource
    {
        $logger = new ApplicationLogger(__METHOD__);
        try {
            $logger->write('翻訳実行開始');
            $requestParams = $request->getParams();
            $results = $this->translateService->translateByMihon($requestParams);
            $logger->write(print_r($results, true));

        } catch (IdentityProviderException $e) {
            $logger->exception($e);
            throw $e;
        }
        $logger->success();

        return new TranslateByMihonResource($results);
    }
}
