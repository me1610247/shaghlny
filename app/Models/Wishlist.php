<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Wishlist extends Model
{
    protected $fillable = [
        'user_id',
        'job_id',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Define the relationship between Wishlist and Job
    public function job()
    {
        return $this->belongsTo(Job::class);
    }
}
