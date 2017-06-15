<?php

namespace App;

trait Favoritable
{

    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favored');
    }

    public function favorite($userId)
    {
        if (!$this->favorites()->where(['user_id' => $userId])->exists()) {
            return $this->favorites()->create(['user_id' => $userId]);
        }
    }

    public function isFavored(): bool
    {
        return (bool)$this->favorites->where('user_id', auth()->id())->count();
    }

    public function getFavoritesCountAttribute(): int
    {
        return $this->favorites->count();
    }
}