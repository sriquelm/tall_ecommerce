<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'external_code', 'geographic_zone_code', 'active'];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function cities()
    {
        return $this->hasMany(City::class);
    }
}
