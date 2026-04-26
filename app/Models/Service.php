<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    protected $fillable = ['name', 'price', 'duration', 'description', 'is_active'];

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }
}