<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PostView extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'post_id',
        'user_id',
        'ip_address',
        'user_agent',
        'visitor_hash',
        'view_date',
        'viewed_at',
    ];


    protected $casts = [
        'viewed_at' => 'datetime',
        'view_date' => 'date',
    ];


    public function post()
    {
        return $this->belongsTo(Post::class);
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
