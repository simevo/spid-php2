<?php

namespace SpidPHP\Helpers;

class Constants {
    // Project root folder, assuming the package has been installed with composer. 
    const APP_PATH = __DIR__ . '/../../../';

    public static function getAppPath()
    {
        return self::APP_PATH;
    }
}