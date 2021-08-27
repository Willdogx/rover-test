<?php

declare(strict_types=1);

namespace App\Exception;

use Exception;
use Throwable;

class InvalidRoverDirectionException extends Exception
{
    private function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public static function invalidDirection(): self
    {
        return new self('direction must be either `N`, `E`, `S`, or `W`');
    }

    public static function invalidRotateDirection(): self
    {
        return new self('the rotate direction must be `R` or `L`');
    }
}
