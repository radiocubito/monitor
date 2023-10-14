<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    use HasFactory;

    protected $fillable = [
        'default',
        'domain',
        'scheme',
        'notification_emails',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function endpoints()
    {
        return $this->hasMany(Endpoint::class)
            ->withCount(['checks as successful_checks_count' => function ($query) {
                $query->where('response_code', '>=', '200')->where('response_code', '<', '300');
            }])
            ->latest();
    }

    public function url()
    {
        return $this->scheme . '://' . $this->domain;
    }
}
