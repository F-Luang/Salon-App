<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $fillable = [
        'appointment_id',
        'amount',
        'status',
        'payment_method',
        'paid_at',
        'notes',
    ];

    protected $casts = ['paid_at' => 'datetime'];

    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class);
    }
}