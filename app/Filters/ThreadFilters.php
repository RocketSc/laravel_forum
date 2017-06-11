<?php

namespace App\Filters;

use App\User;
use Illuminate\Http\Request;
use PhpParser\Builder;

class ThreadFilters extends Filters
{
    protected $filters = ['by', 'popular'];

    /**
     * Filter a query by given username
     *
     * @param string $username
     * @return Builder
     */
    public function by($username)
    {
        $user = User::where('name', $username)->firstOrFail();

        return $this->builder->where('user_id', $user->id);
    }

    /**
     * Filter a query by given username
     *
     * @return Builder
     */
    public function popular()
    {
        $this->builder->getQuery()->orders = [];

        return $this->builder->orderBy('replies_count', 'desc');
    }
}