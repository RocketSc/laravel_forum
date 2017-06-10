<?php

namespace App\Filters;

use Illuminate\Http\Request;

abstract class Filters
{
    protected $request, $builder;

    protected $filters = [];

    /**
     * Filters constructor.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply($builder)
    {
        $this->builder = $builder;

        foreach ($this->getFilters() as $filter => $value) {
            if ($this->hasFilter($filter)) {
                $this->$filter($value);
            }
        }

        return $this->builder;
    }

    /**
     * @param $filter
     * @return bool
     */
    private function hasFilter($filter): bool
    {
        return method_exists($this, $filter);
    }

    /**
     * @return array
     */
    private function getFilters(): array
    {
        return $this->request->intersect($this->filters);
    }
}