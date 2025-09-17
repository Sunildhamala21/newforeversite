<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $guarded = ['id'];

    const PROCESSING = 2;

    const PAID = 1;

    const FAILED = 3;

    const CANCELED = 4;
}
