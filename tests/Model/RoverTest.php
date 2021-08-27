<?php

declare(strict_types=1);

namespace App\Tests\Model;

use App\Model\Rover;
use App\Model\RoverDirection;
use App\Model\RoverRotateDirection;
use PHPUnit\Framework\TestCase;

/**
 * @covers Rover
 */
class RoverTest extends TestCase
{
    /**
     * @dataProvider rotateDirectionProvider
     */
    public function testRotateRotatesDirection(RoverRotateDirection $rotateDirection, RoverDirection $expectedNewDirection): void
    {
        $rover = new Rover(RoverDirection::NORTH());
        $rover->rotate($rotateDirection);
        $this->assertSame($expectedNewDirection, $rover->getDirection());
    }

    /**
     * @return array<array{0: RoverRotateDirection, 1: RoverDirection}>
     */
    public function rotateDirectionProvider(): array
    {
        return [
            [RoverRotateDirection::RIGHT(), RoverDirection::EAST()],
            [RoverRotateDirection::LEFT(), RoverDirection::WEST()]
        ];
    }
}
