<?php

namespace App\Constant;

enum BookTypes: string
{
    case PAPER_BOOK = 'paper';

    case AUDIO_BOOK = 'audio';

    case ELECTRONIC_BOOK = 'electronic';
}