<?php

namespace ahmedWeb\LivePlatformManager\Enums;

enum PlatformTypeEnum: int
{
    // Enum cases representing different live streaming platforms
    case ZOOM = 1; // Represents the Zoom platform
    case LIVE100MS = 2; // Represents the Live100MS platform
    case LiveLink = 3; // Represents the LiveLink platform

    /**
     * Returns the label associated with each platform type.
     * This method is used to get the human-readable name of the platform.
     *
     * @return string The label corresponding to the platform type.
     */
    public function lable()
    {
        // Match the enum case and return the corresponding platform label
        return match ($this) {
            self::LIVE100MS => 'Live100MS', // Label for Live100MS platform
            self::ZOOM => 'Zoom', // Label for Zoom platform
            self::LiveLink => 'LiveLink', // Label for LiveLink platform
        };
    }

    public function view()
    {
        return match ($this) {
            self::LIVE100MS => '100ms', // Label for Live100MS platform
            self::ZOOM => 'zoom', // Label for Zoom platform
            self::LiveLink => 'link', // Label for LiveLink platform
        };
    }
}
