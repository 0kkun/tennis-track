<?php
declare(strict_types=1);

namespace TennisTrack\Common\Exceptions;

interface DomainExceptionInterface extends \Throwable
{
    public function __construct(string $message);
}
