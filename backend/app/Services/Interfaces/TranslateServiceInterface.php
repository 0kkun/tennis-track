<?php

namespace App\Services\Interfaces;

interface TranslateServiceInterface
{
    /**
     * 「みんなの自動翻訳API」を使用して日本語->英語翻訳を行う
     *
     * @param array $requestParams
     * @return array $results
     * @throws IdentityProviderException
     */
    public function translateByMihon(array $requestParams): array;
}