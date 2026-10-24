<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'amount',
        'status',
        'currency',
        'transaction_id',
    ];
}
