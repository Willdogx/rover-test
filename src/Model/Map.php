<?php

declare(strict_types=1);

namespace App\Model;

use App\Exception\InvalidMapCoordinatesException;
use App\Exception\RoverNotInMapException;
use RuntimeException;
use function array_fill;

class Map
{
    /**
     * @var array<int, array<int, Rover|null>>
     */
    private array $grid;

    public function __construct(
        private int $maxX,
        private int $maxY
    ) {
        if ($maxX <= 0 || $maxY <= 0) {
            throw InvalidMapCoordinatesException::maxCoordinatesGreaterThan0();
        }
        $this->grid = array_fill(0, $maxX, []);
        foreach ($this->grid as &$column) {
            $column = array_fill(0, $maxY, null);
        }
    }

    /**
     * @return array<int, array<int, Rover|null>>
     */
    public function getGrid(): array
    {
        return $this->grid;
    }

    /**
     * @return array{int, int}
     */
    public function getRoverPosition(Rover $rover): array
    {
        foreach ($this->grid as $xPosition => $yColumn) {
            $yPosition = array_search($rover, $yColumn, true);
            if ($yPosition !== false) {
                return [$xPosition, $yPosition];
            }
        }

        throw new RoverNotInMapException();
    }

    public function placeRover(Rover $rover, int $x, int $y): self
    {
        if ($x < 0 || $x > $this->maxX || $y < 0 || $y > $this->maxY) {
            throw InvalidMapCoordinatesException::coordinatesOutOfBounds($this->maxX, $this->maxY);
        }
        if (!empty($this->grid[$x][$y])) {
            throw InvalidMapCoordinatesException::coordinatesAlreadyOccupied($x, $y);
        }

        $this->grid[$x][$y] = $rover;

        return $this;
    }

    /**
     * @return array{int, int}
     */
    public function moveRover(Rover $rover): array
    {
        [$xPosition, $yPosition] = $this->getRoverPosition($rover);

        $newYPosition = $yPosition;
        $newXPosition = $xPosition;

        $roverDirection = $rover->getDirection();

        match ($roverDirection) {
            RoverDirection::NORTH() => ++$newYPosition,
            RoverDirection::SOUTH() => --$newYPosition,
            RoverDirection::EAST() => ++$newXPosition,
            RoverDirection::WEST() => --$newXPosition,
            default => throw new RuntimeException('Unexpected RoverDirection Enum')
        };

        $this->placeRover($rover, $newXPosition, $newYPosition);

        $this->grid[$xPosition][$yPosition] = null;

        return [$newXPosition, $newYPosition];
    }
}
