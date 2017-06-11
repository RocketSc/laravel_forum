<?php

function create($class, array $attributes = [], $times = null)
{
    return factory($class, $times)->create($attributes);
}

function make($class, array $attributes = [], $times = null)
{
    return factory($class, $times)->make($attributes);
}
