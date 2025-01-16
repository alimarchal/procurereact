<?php

namespace App\Enums;

enum CommissionStatus: string
{
    case Pending = 'pending';
    case Processed = 'processed';
    case Paid = 'paid';
}
