<?php

function create($class, array $attributes = [])
{
    return factory($class)->create($attributes);
}

function make($class, array $attributes = [])
{
    return factory($class)->make($attributes);
}
