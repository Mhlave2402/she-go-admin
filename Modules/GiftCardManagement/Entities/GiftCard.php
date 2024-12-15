<?php

namespace Modules\GiftCardManagement\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GiftCard extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'amount',
        'expiration_date',
    ];

    protected $casts = [
        'amount' => 'float',
    ];
}
