<?php

declare(strict_types=1);

namespace TennisTrack\Player\Domain\Models;

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
    public function __construct(
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

    public function id(): Id
    {
        return $this->id;
    }

    public function nameEn(): NameEn
    {
        return $this->nameEn;
    }

    public function nameJa(): NameJa
    {
        return $this->nameJa;
    }

    public function country(): Country
    {
        return $this->country;
    }

    public function countryCode(): CountryCode
    {
        return $this->countryCode;
    }

    public function abbreviation(): Abbreviation
    {
        return $this->abbreviation;
    }

    public function gender(): Gender
    {
        return $this->gender;
    }

    public function birthday(): Birthday
    {
        return $this->birthday;
    }

    public function proYear(): ProYear
    {
        return $this->proYear;
    }

    public function handedness(): Handedness
    {
        return $this->handedness;
    }

    public function height(): Height
    {
        return $this->height;
    }

    public function weight(): Weight
    {
        return $this->weight;
    }

    public function highestSinglesRanking(): HighestSinglesRanking
    {
        return $this->highestSinglesRanking;
    }

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
            Id::from($data['id']),
            array_key_exists('name_en', $data) ? NameEn::from($data['name_en']) : NameEn::from(''),
            NameJa::from($data['name_ja']),
            Country::from($data['country']),
            CountryCode::from($data['country_code']),
            Abbreviation::from($data['abbreviation']),
            Gender::from($data['gender']),
            Birthday::from($data['birthday']),
            ProYear::from($data['pro_year']),
            Handedness::from($data['handedness']),
            Height::from($data['height']),
            Weight::from($data['weight']),
            HighestSinglesRanking::from($data['highest_singles_ranking']),
            HighestDoublesRanking::from($data['highest_doubles_ranking']),
        );
    }
}
