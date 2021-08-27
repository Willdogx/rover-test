<?php

declare(strict_types=1);

namespace App\Model;

class RoverInfo
{
    public function __construct(
        private int $xPosition,
        private int $yPosition,
        private RoverDirection $direction,
    ) {
    }

    public function __toString(): string
    {
        return sprintf('%s %s %s', $this->xPosition, $this->yPosition, $this->direction->getValue());
    }
}
