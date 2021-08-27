<?php

declare(strict_types=1);

namespace App\Model;

use RuntimeException;
use function array_search;

class Rover
{
    public const DIRECTIONS = ['N', 'E', 'S', 'W'];
    public function __construct(
        public RoverDirection $direction
    ) {
    }

    public function getDirection(): RoverDirection
    {
        return $this->direction;
    }

    public function rotate(RoverRotateDirection $rotateDirection): self
    {
        $directionKey = array_search($this->direction->getValue(), self::DIRECTIONS, true);

        $newDirectionKey = match ($rotateDirection) {
            RoverRotateDirection::RIGHT() => ++$directionKey,
            RoverRotateDirection::LEFT() => --$directionKey,
            default => throw new RuntimeException('Unexpected RoverRotateDirection Enum'),
        };

        $directionsMaxKey = count(self::DIRECTIONS) - 1;
        $newDirectionKey = match (true) {
            $newDirectionKey > $directionsMaxKey => 0,
            $newDirectionKey < 0 => $directionsMaxKey,
            default => $newDirectionKey
        };

        $this->direction = RoverDirection::byValue(self::DIRECTIONS[$newDirectionKey]);


        return $this;
    }
}
