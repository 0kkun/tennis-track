<?php

namespace App\Services\Interfaces;

interface TranslateServiceInterface
{
    /**
     * 「みんなの自動翻訳API」を使用して日本語->英語翻訳を行う
     * 1日2MBまで。それ以上超えたらその日は使用できなくなる。
     *
     * @param array $requestParams
     * @throws IdentityProviderException
     * @return array $results
     */
    public function translateByMihon(array $requestParams): array;
}
