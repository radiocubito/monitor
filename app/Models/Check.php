<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Check extends Model
{
    use HasFactory;

    protected $fillable = [
        'response_code',
        'response_body',
    ];

    public function endpoint()
    {
        return $this->belongsTo(Endpoint::class);
    }
}
