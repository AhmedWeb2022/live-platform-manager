<?php

namespace ahmedWeb\LivePlatformManager\Exceptions;


use Exception;

class MissingZoomConfigurationException extends Exception
{
    public function __construct(string $key)
    {
        parent::__construct("Zoom configuration error: `{$key}` is required but missing.");
    }
}
