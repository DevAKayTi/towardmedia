<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 *  @method static static OptionOne()
 *  @method static static OptionTwo()
 *  @method static static OptionThree()
 **/
final class PostType extends Enum
{
    const News_Article =1;
    const Newsletter =2;
    const Newsbulletin =3;
    const Podcast =4;
    const Article =5;
    const News =6;
}
