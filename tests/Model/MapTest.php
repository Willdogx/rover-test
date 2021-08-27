<?php

declare(strict_types=1);

namespace App\Tests\Model;

use App\Exception\InvalidMapCoordinatesException;
use App\Model\Map;
use App\Model\Rover;
use App\Model\RoverDirection;
use PHPUnit\Framework\TestCase;

/**
 * @covers Map
 */
class MapTest extends TestCase
{
    public function testMapThrowsExceptionWhenMaxCoordinatesAreNotGreaterThan0(): void
    {
        $this->expectException(InvalidMapCoordinatesException::class);
        $this->expectExceptionMessage('map must have x and y greater than 0');
        $map = new Map(0, 0);
    }

    public function testPlaceRoverThrowsExceptionIfCoordinatesAreOutOfBound(): void
    {
        $map = new Map(5, 5);
        $rover = new Rover(RoverDirection::NORTH());
        $this->expectException(InvalidMapCoordinatesException::class);
        $this->expectExceptionMessage('coordinates x must be between 0 and 5 and coordinates y must be between 0 and 5');
        $map->placeRover($rover, 6, 5);
    }

    public function testPlaceRoverThrowsExceptionIfCoordinatesAreAlreadyOccupied(): void
    {
        $map = new Map(5, 5);
        $rover1 = new Rover(RoverDirection::NORTH());
        $map->placeRover($rover1, 5, 5);
        $rover2 = new Rover(RoverDirection::NORTH());

        $this->expectException(InvalidMapCoordinatesException::class);
        $this->expectExceptionMessage('the coordinates x: 5, y: 5 are already occupied by another rover.');
        $map->placeRover($rover2, 5, 5);
    }

    public function testPlaceRoverInsertsRoverInGrid(): void
    {
        $map = new Map(5, 5);
        $rover = new Rover(RoverDirection::NORTH());
        $map->placeRover($rover, 3, 3);

        $expected = array_fill(0, 5, []);
        foreach ($expected as &$row) {
            $row = array_fill(0, 5, null);
        }
        $expected[3][3] = $rover;

        $this->assertSame($expected, $map->getGrid());
    }

    /**
     * @dataProvider moveRoverProvider
     */
    public function testMoveRoverChangesPositionOfRoverInTheGrid(
        int $amountOfTimesToMove,
        RoverDirection $direction,
        int $expectedX,
        int $expectedY
    ): void {
        $map = new Map(5, 5);
        $rover = new Rover($direction);
        $map->placeRover($rover, 1, 1);

        $expected = array_fill(0, 5, []);
        foreach ($expected as &$row) {
            $row = array_fill(0, 5, null);
        }
        $expected[$expectedX][$expectedY] = $rover;

        for ($i = 0; $i < $amountOfTimesToMove; $i++) {
            $map->moveRover($rover);
        }

        $this->assertSame($expected, $map->getGrid());
    }

    /**
     * @return array<string, array<int|RoverDirection>>
     */
    public function moveRoverProvider(): array
    {
        return [
            '1 movement North' => [1, RoverDirection::NORTH(), 1, 2],
            '2 movements North' => [2, RoverDirection::NORTH(), 1, 3],
            '3 movements east' => [3, RoverDirection::EAST(), 4, 1]
        ];
    }
}
