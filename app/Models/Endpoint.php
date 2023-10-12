<?php

namespace App\Models;

use App\Enums\EndpointFrequency;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Endpoint extends Model
{
    use HasFactory;

    protected $fillable = [
        'location',
        'frequency',
        'next_check',
    ];

    protected $casts = [
        'next_check' => 'datetime',
    ];

    protected function frequencyLabel(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => EndpointFrequency::from($attributes['frequency'])->label(),
        );
    }

    public function site()
    {
        return $this->belongsTo(Site::class);
    }
}
