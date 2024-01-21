<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class UserRoleType extends Enum
{
    const Author =   1;
    const Admin =   2;
    const SuperAdmin =   9;
}
