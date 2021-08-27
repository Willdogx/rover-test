<?php

declare(strict_types=1);

namespace App\Model;

use MabeEnum\Enum;

/**
 * @method static RoverDirection NORTH()
 * @method static RoverDirection EAST()
 * @method static RoverDirection SOUTH()
 * @method static RoverDirection WEST()
 */
class RoverDirection extends Enum
{
    public const NORTH = 'N';
    public const EAST = 'E';
    public const SOUTH = 'S';
    public const WEST = 'W';
}
