<?php

declare(strict_types=1);

namespace App\Service;

use App\Model\Map;
use App\Model\Rover;
use App\Model\RoverDirection;
use App\Model\RoverInfo;
use App\Model\RoverRotateDirection;

class RoverService
{
    private Map $map;
    private Rover $currentRover;

    public function initMap(int $maxX, int $maxY): void
    {
        $this->map = new Map($maxX, $maxY);
    }

    public function placeRover(int $x, int $y, RoverDirection $direction): void
    {
        $this->currentRover = new Rover($direction);
        $this->map->placeRover($this->currentRover, $x, $y);
    }

    public function rotateRover(RoverRotateDirection $direction): RoverInfo
    {
        $this->currentRover->rotate($direction);
        [$x, $y] = $this->map->getRoverPosition($this->currentRover);

        return new RoverInfo($x, $y, $this->currentRover->getDirection());
    }

    public function moveRover(): RoverInfo
    {
        [$x, $y] = $this->map->moveRover($this->currentRover);

        return new RoverInfo($x, $y, $this->currentRover->getDirection());
    }
}
