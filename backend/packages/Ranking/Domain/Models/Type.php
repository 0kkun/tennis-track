<?php

declare(strict_types=1);

namespace TennisTrack\Ranking\Domain\Models;

use TennisTrack\Common\ValueObject\ValueObjectString;

final class Type
{
    use ValueObjectString;

    /** @var string */
    private const ATP_SINGLES = 'atp_singles';

    /** @var string */
    private const ATP_DOUBLES = 'atp_doubles';

    /** @var string */
    private const WTA_SINGLES = 'wta_singles';

    /** @var string */
    private const WTA_DOUBLES = 'wta_doubles';

    /**
     * @return self
     */
    public static function asAtpSingles(): self
    {
        return new self(self::ATP_SINGLES);
    }

    /**
     * @return self
     */
    public static function asAtpDoubles(): self
    {
        return new self(self::ATP_DOUBLES);
    }

    /**
     * @return self
     */
    public static function asWtaSingles(): self
    {
        return new self(self::WTA_SINGLES);
    }

    /**
     * @return self
     */
    public static function asWtaDoubles(): self
    {
        return new self(self::WTA_DOUBLES);
    }
}
