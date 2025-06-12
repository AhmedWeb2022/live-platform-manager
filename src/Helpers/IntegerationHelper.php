<?php

use ahmedWeb\LivePlatformManager\Exceptions\MissingZoomConfigurationException;

if (!function_exists('getValueOrFail')) {
    function getValueOrFail($value, string $key)
    {
        if (empty($value)) {
            throw new MissingZoomConfigurationException($key);
        }
        return $value;
    }
}

if (!function_exists('getConfigOrFail')) {
    function getConfigOrFail(string $configKey)
    {
        $value = config($configKey);
        if (empty($value)) {
            throw new MissingZoomConfigurationException($configKey);
        }
        return $value;
    }
}
