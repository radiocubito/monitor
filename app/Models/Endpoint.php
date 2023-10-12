<?php

namespace App\Models;

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

    public function site()
    {
        return $this->belongsTo(Site::class);
    }
}
