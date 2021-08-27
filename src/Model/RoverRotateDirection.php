<?php

declare(strict_types=1);

namespace App\Model;

use MabeEnum\Enum;

/**
 * @method static RoverRotateDirection RIGHT()
 * @method static RoverRotateDirection LEFT()
 */
class RoverRotateDirection extends Enum
{
    public const RIGHT = 'R';
    public const LEFT = 'L';
}
