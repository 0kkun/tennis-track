<?php

declare(strict_types=1);

namespace TennisTrack\SportRadar\Domain\Models;

use TennisTrack\Common\Exceptions\InvalidArgumentException;

final class Endpoint
{
    /** @var string */
    private const API_BASE_URL = 'https://api.sportradar.com/tennis';

    /**
     * @param ApiName $apiName
     * @param string|null $playerIdMain
     * @param string|null $playerIdSub
     * @param AccessLevel|null $accessLevel
     * @param Version|null $version
     * @param LanguageCode|null $languageCode
     * @param Category|null $category
     * @param Format|null $format
     * @param Path|null $path
     */
    public function __construct(
        private ApiName $apiName,
        private ?string $playerIdMain,
        private ?string $playerIdSub,
        private ?AccessLevel $accessLevel,
        private ?Version $version,
        private ?LanguageCode $languageCode,
        private ?Category $category,
        private ?Format $format,
        private ?Path $path
    ) {
        $this->apiName = $apiName;
        $this->playerIdMain = $playerIdMain;
        $this->playerIdSub = $playerIdSub;
        $this->accessLevel = $accessLevel ?? AccessLevel::trial();
        $this->version = $version ?? Version::v2();
        $this->languageCode = $languageCode ?? LanguageCode::ja();
        $this->category = $category ?? Category::players();
        $this->format = $format ?? Format::json();
        $this->path = $path ?? Path::from('');
    }

    /**
     * @param array $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        $apiName = array_key_exists('api_name', $data) ? ApiName::from($data['api_name']) : ApiName::playerRankings();
        $accessLevel = array_key_exists('access_level', $data) ? AccessLevel::from($data['access_level']) : AccessLevel::trial();
        $version = array_key_exists('version', $data) ? Version::from($data['version']) : Version::v2();
        $languageCode = array_key_exists('language_code', $data) ? LanguageCode::from($data['language_code']) : LanguageCode::ja();
        $category = array_key_exists('category', $data) ? Category::from($data['category']) : Category::players();
        $format = array_key_exists('format', $data) ? Format::from($data['format']) : Format::json();
        $path = array_key_exists('path', $data) ? Path::from($data['path']) : Path::from('');

        return new self(
            $apiName,
            $data['player_id_main'] ?? '',
            $data['player_id_sub'] ?? '',
            $accessLevel,
            $version,
            $languageCode,
            $category,
            $format,
            $path,
        );
    }

    /**
     * @return Path
     */
    public function path(): Path
    {
        return match ($this->apiName->toString()) {
            'player_profile' => Path::from($this->getUrlForPlayerProfile()),
            'player_rankings' => Path::from($this->getUrlForPlayerRankings()),
            'player_race_rankings' => Path::from($this->getUrlForPlayerRaceRankings()),
            'player_head_to_head' => Path::from($this->getUrlForPlayerHeadToHead()),
            default => throw new InvalidArgumentException('Invalid api name'),
        };
    }

    /**
     * 特定の選手プロフィール取得用APIのURLを返す
     * @return string
     */
    private function getUrlForPlayerProfile(): string
    {
        return sprintf(
            '%s/%s/%s/%s/%s/%s/profile.%s',
            self::API_BASE_URL,
            $this->accessLevel->toString(),
            $this->version->toString(),
            $this->languageCode->toString(),
            $this->category->toString(),
            $this->playerIdMain,
            $this->format->toString(),
        );
    }

    /**
     * ATPランキングのURLを返す
     * @return string
     */
    private function getUrlForPlayerRankings(): string
    {
        return sprintf(
            '%s/%s/%s/%s/%s/rankings.%s',
            self::API_BASE_URL,
            $this->accessLevel->toString(),
            $this->version->toString(),
            $this->languageCode->toString(),
            $this->category->toString(),
            $this->format->toString(),
        );
    }

    /**
     * 賞金レースランキング取得用APIのURLを返す
     * @param AccessLevel|null $accessLevel
     * @param Version|null $version
     * @param LanguageCode|null $languageCode
     * @param Format|null $format
     * @return string
     */
    private function getUrlForPlayerRaceRankings(): string
    {
        return sprintf(
            '%s/%s/%s/%s/%s/race_rankings.%s',
            self::API_BASE_URL,
            $this->accessLevel->toString(),
            $this->version->toString(),
            $this->languageCode->toString(),
            $this->category->toString(),
            $this->format->toString(),
        );
    }

    /**
     * プレイヤーの過去の直接対決取得用APIのURLを返す
     * @return string
     */
    private function getUrlForPlayerHeadToHead(): string
    {
        return sprintf(
            '%s/%s/%s/%s/%s/%s/versus/%s/matches.%s',
            self::API_BASE_URL,
            $this->accessLevel->toString(),
            $this->version->toString(),
            $this->languageCode->toString(),
            $this->category->toString(),
            $this->playerIdMain,
            $this->playerIdSub,
            $this->format->toString(),
        );
    }
}
