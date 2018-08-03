<?php

namespace SpidPHP\Helpers;

class Constants {
    const APP_PATH = __DIR__ . '/../../../';

    public static function getAppPath()
    {
        return self::APP_PATH;
    }
}