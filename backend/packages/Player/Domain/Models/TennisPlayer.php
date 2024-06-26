<?php

declare(strict_types=1);

namespace TennisTrack\Player\Domain\Models;

use Carbon\Carbon;
use TennisTrack\SportCategory\Domain\Models\Id as SportCategoryId;

final class TennisPlayer
{
    private function __construct(
        private Id $id,
        private NameEn $nameEn,
        private NameJa $nameJa,
        private Country $country,
        private CountryCode $countryCode,
        private Abbreviation $abbreviation,
        private Gender $gender,
        private Birthday $birthday,
        private ProYear $proYear,
        private Handedness $handedness,
        private Height $height,
        private Weight $weight,
        private HighestSinglesRanking $highestSinglesRanking,
        private HighestDoublesRanking $highestDoublesRanking,
        private SportCategoryId $sportCategoryId
    ) {
        $this->id = $id;
        $this->nameEn = $nameEn;
        $this->nameJa = $nameJa;
        $this->country = $country;
        $this->countryCode = $countryCode;
        $this->abbreviation = $abbreviation;
        $this->gender = $gender;
        $this->birthday = $birthday;
        $this->proYear = $proYear;
        $this->handedness = $handedness;
        $this->height = $height;
        $this->weight = $weight;
        $this->highestSinglesRanking = $highestSinglesRanking;
        $this->highestDoublesRanking = $highestDoublesRanking;
        $this->sportCategoryId = $sportCategoryId;
    }

    /**
     * @return Id
     */
    public function id(): Id
    {
        return $this->id;
    }

    /**
     * @return NameEn
     */
    public function nameEn(): NameEn
    {
        return $this->nameEn;
    }

    /**
     * @return NameJa
     */
    public function nameJa(): NameJa
    {
        return $this->nameJa;
    }

    /**
     * @return Country
     */
    public function country(): Country
    {
        return $this->country;
    }

    /**
     * @return CountryCode
     */
    public function countryCode(): CountryCode
    {
        return $this->countryCode;
    }

    /**
     * @return Abbreviation
     */
    public function abbreviation(): Abbreviation
    {
        return $this->abbreviation;
    }

    /**
     * @return Gender
     */
    public function gender(): Gender
    {
        return $this->gender;
    }

    /**
     * @return Birthday
     */
    public function birthday(): Birthday
    {
        return $this->birthday;
    }

    /**
     * @return ProYear
     */
    public function proYear(): ProYear
    {
        return $this->proYear;
    }

    /**
     * @return Handedness
     */
    public function handedness(): Handedness
    {
        return $this->handedness;
    }

    /**
     * @return Height
     */
    public function height(): Height
    {
        return $this->height;
    }

    /**
     * @return Weight
     */
    public function weight(): Weight
    {
        return $this->weight;
    }

    /**
     * @return HighestSinglesRanking
     */
    public function highestSinglesRanking(): HighestSinglesRanking
    {
        return $this->highestSinglesRanking;
    }

    /**
     * @return HighestDoublesRanking
     */
    public function highestDoublesRanking(): HighestDoublesRanking
    {
        return $this->highestDoublesRanking;
    }

    /**
     * @return SportCategoryId
     */
    public function sportCategoryId(): SportCategoryId
    {
        return $this->sportCategoryId;
    }

    /**
     * @param array $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            Id::from($data['id'] ?? ''),
            NameEn::from($data['name_en'] ?? null),
            NameJa::from($data['name_ja'] ?? null),
            Country::from($data['country'] ?? null),
            CountryCode::from($data['country_code'] ?? null),
            Abbreviation::from($data['abbreviation'] ?? null),
            Gender::from($data['gender'] ?? null),
            Birthday::from($data['birthday'] ?? null),
            ProYear::from($data['pro_year'] ?? null),
            Handedness::from($data['handedness'] ?? null),
            Height::from($data['height'] ?? null),
            Weight::from($data['weight'] ?? null),
            HighestSinglesRanking::from($data['highest_singles_ranking'] ?? null),
            HighestDoublesRanking::from($data['highest_doubles_ranking'] ?? null),
            SportCategoryId::from($data['sport_category_id'] ?? 0),
        );
    }

    /**
     * @return int
     */
    public function age(Carbon $now): int
    {
        return $this->birthday->age($now);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id->toString(),
            'name_en' => $this->nameEn->toString(),
            'name_ja' => $this->nameJa->toString(),
            'country' => $this->country->toString(),
            'country_code' => $this->countryCode->toString(),
            'abbreviation' => $this->abbreviation->toString(),
            'gender' => $this->gender->toInt(),
            'birthday' => $this->birthday->get(),
            'pro_year' => $this->proYear->toString(),
            'handedness' => $this->handedness->toInt(),
            'height' => $this->height->toFloat(),
            'weight' => $this->weight->toInt(),
            'highest_singles_ranking' => $this->highestSinglesRanking->toInt(),
            'highest_doubles_ranking' => $this->highestDoublesRanking->toInt(),
            'sport_category_id' => $this->sportCategoryId->toInt(),
        ];
    }
}
