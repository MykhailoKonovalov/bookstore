<?php

namespace App\Constant;

use App\Constant\Trait\EnumToArrayTrait;

enum EBookFormats: string
{
    use EnumToArrayTrait;

    case PDF = 'pdf';

    case EPUB = 'epub';

    case MOBI = 'mobi';

    case FB2 = 'fb2';
}