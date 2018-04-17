<?php

if (! function_exists('ddd')) {
    /**
     *  ddd
     *
     *  dump don't die
     */
    function ddd()
    {
        array_map(function ($x) {
            (new Illuminate\Support\Debug\Dumper)->dump($x);
        }, func_get_args());
    }
}