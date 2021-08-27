<?php

declare(strict_types=1);

namespace App\Exception;

use Exception;
use Throwable;

class InvalidMapCoordinatesException extends Exception
{
    private function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public static function coordinatesAlreadyOccupied(int $x, int $y): self
    {
        return new self("the coordinates x: $x, y: $y are already occupied by another rover.");
    }

    public static function coordinatesOutOfBounds(int $maxX, int $maxY): self
    {
        return new self("coordinates x must be between 0 and $maxX and coordinates y must be between 0 and $maxY");
    }

    public static function maxCoordinatesGreaterThan0(): self
    {
        return new self('map must have x and y greater than 0');
    }
}
