<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'address_line',
        'city',
        'state',
        'country',
        'phone',
        'customer_id',
        'is_default',
    ];

    protected $casts = [
        'is_default' => 'boolean',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function getFullAddressAttribute()
    {
        $addressParts = [
            $this->address_line,
            $this->city,
            $this->state,
            $this->country,
        ];

        $addressString = implode(', ', array_filter($addressParts));

        return $addressString;
    }
}
