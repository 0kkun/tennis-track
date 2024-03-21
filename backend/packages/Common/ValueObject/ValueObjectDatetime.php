<?php

declare(strict_types=1);

namespace TennisTrack\Common\ValueObject;

use Carbon\Carbon;

trait ValueObjectDatetime
{
    use ValueObjectFrom;

    /**
     * @param Carbon|null $value
     */
    private function __construct(private ?Carbon $value = null)
    {
        $this->value = $value;
    }

    /**
     * @return Carbon|null
     */
    public function get(): ?Carbon
    {
        return $this->value;
    }

    /**
     * @param string $format
     * @return string
     */
    public function format(string $format): string
    {
        return $this->isNull() ? '' : $this->value->format($format);
    }

    /**
     * @return string
     */
    public function toDateString(): string
    {
        return $this->format('Y-m-d');
    }

    /**
     * @return string
     */
    public function toDatetimeString(): string
    {
        return $this->format('Y-m-d H:i:s');
    }

    /**
     * @return int
     */
    public function timestamp(): int
    {
        return $this->value->getTimestamp();
    }

    /**
     * @return self
     */
    public function startOfDay(): self
    {
        if ($this->isNull()) {
            return $this;
        }
        $date = $this->value->copy()->startOfDay();

        return new self($date);
    }

    /**
     * @return self
     */
    public function endOfDay(): self
    {
        if ($this->isNull()) {
            return $this;
        }
        $date = $this->value->copy()->endOfDay();

        return new self($date);
    }

    /**
     * @param int $days
     * @return self
     */
    public function addDays(int $days = 1): self
    {
        if ($this->isNull()) {
            return $this;
        }
        $date = $this->value->copy()->addDays($days);

        return new self($date);
    }

    /**
     * @param Carbon|string|null $value
     * @return self
     */
    public static function from($value = null): self
    {
        if ($value instanceof Carbon) {
            return new self($value->copy());
        } elseif ($value instanceof self) {
            return $value;
        } elseif (is_null($value) || ($value === '0000-00-00')) {
            return new self();
        } elseif (is_string($value) && strtotime($value)) {
            return new self(new Carbon($value));
        } else {
            throw self::createInvalidArgumentException(is_object($value) ? get_class($value) : $value);
        }
    }

    /**
     * @return static
     */
    public static function now(): self
    {
        return new self(Carbon::now());
    }
}
