<?php

namespace SpidPHP\Helpers;

class PathHelper
{
    public static function fixPathSlashes($path)
    {
        if (substr($path, -1) != DIRECTORY_SEPARATOR) 
        {
            $path .= DIRECTORY_SEPARATOR;
        }
        if (substr($path, 0, 1) == DIRECTORY_SEPARATOR) 
        {
            $path = substr($path, 1);
        }
        return $path;
    }
}