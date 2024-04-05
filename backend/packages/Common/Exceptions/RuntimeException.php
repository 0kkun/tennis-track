<?php

declare(strict_types=1);

namespace TennisTrack\Common\Exceptions;

final class RuntimeException extends \Exception implements DomainExceptionInterface
{
    /**
     * @param string $message
     * @param int $code
     * @param \Throwable|null $previous
     */
    public function __construct(
        string $message = 'Runtime Exception',
        int $code = 0,
        \Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
