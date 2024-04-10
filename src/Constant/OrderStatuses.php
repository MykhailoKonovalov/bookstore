<?php

namespace App\Constant;

enum OrderStatuses: string
{
    public const STARTED = 'started';

    public const PENDING = 'pending';

    public const WAITING_PAYMENT = 'waiting_payment';

    public const PROCESSING = 'processing';

    public const COMPLETED = 'completed';
}