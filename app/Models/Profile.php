<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'phone',
        'date_of_birth',
        'skills',
    ];

    protected $casts = [
        'skills' => 'array',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}