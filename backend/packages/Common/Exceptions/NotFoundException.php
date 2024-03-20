<?php
declare(strict_types=1);

namespace TennisTrack\Common\Exceptions;

final class NotFoundException extends \Exception implements DomainExceptionInterface
{
    /**
     * @param string $message
     * @param integer $code
     * @param \Throwable|null $previous
     */
    public function __construct(
        string $message = 'Not Found Exception',
        int $code = 0,
        \Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
