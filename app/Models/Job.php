<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Job extends Model
{
    use HasFactory;
    protected $table = 'job';  // Explicitly set the table name

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'location',
        'job_type',
        'salary',
        'image',
        'company_name'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function wishlists()
{
    return $this->hasMany(Wishlist::class);
}
public function applicants()
{
    return $this->belongsToMany(User::class, 'applied_job');
}
public function applications()
{
    return $this->hasMany(JobApplication::class);
}
public function questions()
    {
        return $this->hasMany(JobQuestion::class);
    }
}
