<?php


function translate(string $string): string
{
    return \App\Engine\Libraries\Languages::translate($string);
}