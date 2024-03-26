<?php

declare(strict_types=1);

namespace TennisTrack\Player\Domain\Models;

use Carbon\Carbon;

final class Player
{
    /**
     * @param Id $id
     * @param NameEn|null $nameEn
     * @param NameJa|null $nameJa
     * @param Country|null $country
     * @param CountryCode|null $countryCode
     * @param Abbreviation|null $abbreviation
     * @param Gender|null $gender
     * @param Birthday|null $birthday
     * @param ProYear|null $proYear
     * @param Handedness|null $handedness
     * @param Height|null $height
     * @param Weight|null $weight
     * @param HighestSinglesRanking|null $highestSinglesRanking
     * @param HighestDoublesRanking|null $highestDoublesRanking
     */
    private function __construct(
        private Id $id,
        private ?NameEn $nameEn,
        private ?NameJa $nameJa,
        private ?Country $country,
        private ?CountryCode $countryCode,
        private ?Abbreviation $abbreviation,
        private ?Gender $gender,
        private ?Birthday $birthday,
        private ?ProYear $proYear,
        private ?Handedness $handedness,
        private ?Height $height,
        private ?Weight $weight,
        private ?HighestSinglesRanking $highestSinglesRanking,
        private ?HighestDoublesRanking $highestDoublesRanking
    ) {
        $this->id = $id;
        $this->nameEn = $nameEn ?? NameEn::from('');
        $this->nameJa = $nameJa ?? NameJa::from('');
        $this->country = $country ?? Country::from('');
        $this->countryCode = $countryCode ?? CountryCode::from('');
        $this->abbreviation = $abbreviation ?? Abbreviation::from('');
        $this->gender = $gender ?? Gender::from('');
        $this->birthday = $birthday ?? Birthday::from(null);
        $this->proYear = $proYear ?? ProYear::from(null);
        $this->handedness = $handedness ?? Handedness::from('');
        $this->height = $height ?? Height::from(null);
        $this->weight = $weight ?? Weight::from(null);
        $this->highestSinglesRanking = $highestSinglesRanking ?? HighestSinglesRanking::from(null);
        $this->highestDoublesRanking = $highestDoublesRanking ?? HighestDoublesRanking::from(null);
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
            'birthday' => $this->birthday->format('Y-m-d'),
            'pro_year' => $this->proYear->toInt(),
            'handedness' => $this->handedness->toInt(),
            'height' => $this->height->toInt(),
            'weight' => $this->weight->toInt(),
            'highest_singles_ranking' => $this->highestSinglesRanking->toInt(),
            'highest_doubles_ranking' => $this->highestDoublesRanking->toInt(),
        ];
    }
}
