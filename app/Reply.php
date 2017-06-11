<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    protected $guarded = [];

    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favored');
    }

    public function favorite($userId)
    {
        if (! $this->favorites()->where(['user_id' => $userId])->exists() ) {
            return $this->favorites()->create(['user_id' => $userId]);
        }
    }
}
