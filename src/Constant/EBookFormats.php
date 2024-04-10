<?php

namespace App\Constant;

enum EBookFormats: string
{
    case PDF = 'pdf';

    case EPUB = 'epub';

    case MOBI = 'mobi';

    case FB2 = 'fb2';
}