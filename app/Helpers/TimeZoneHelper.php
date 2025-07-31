<?php

namespace App\Helpers;

use Carbon\Carbon;

class TimeZoneHelper
{
    /**
     * Get timezone abbreviation based on longitude
     */
    public static function getTimezoneAbbr($longitude = null)
    {
        if ($longitude === null) {
            // Default to WIB (Jakarta)
            return 'WIB';
        }

        // Indonesia timezone boundaries (approximate)
        if ($longitude >= 105) {
            return 'WIB'; // Western Indonesia Time (UTC+7)
        } elseif ($longitude >= 120) {
            return 'WITA'; // Central Indonesia Time (UTC+8)
        } else {
            return 'WIT'; // Eastern Indonesia Time (UTC+9)
        }
    }

    /**
     * Get timezone offset in hours
     */
    public static function getTimezoneOffset($timezoneAbbr)
    {
        switch ($timezoneAbbr) {
            case 'WIB':
                return 7;
            case 'WITA':
                return 8;
            case 'WIT':
                return 9;
            default:
                return 7; // Default to WIB
        }
    }

    /**
     * Format datetime with timezone
     */
    public static function formatWithTimezone($datetime, $longitude = null, $format = 'd/m/Y H:i')
    {
        if (!$datetime) {
            return '-';
        }

        $carbon = Carbon::parse($datetime);
        $timezoneAbbr = self::getTimezoneAbbr($longitude);
        $offset = self::getTimezoneOffset($timezoneAbbr);

        // Adjust time based on timezone
        $adjustedTime = $carbon->copy()->addHours($offset - 7); // Subtract WIB offset since we're already in WIB

        return $adjustedTime->format($format) . ' ' . $timezoneAbbr;
    }

    /**
     * Format time only with timezone
     */
    public static function formatTimeWithTimezone($datetime, $longitude = null)
    {
        return self::formatWithTimezone($datetime, $longitude, 'H:i');
    }

    /**
     * Format date only with timezone
     */
    public static function formatDateWithTimezone($datetime, $longitude = null)
    {
        return self::formatWithTimezone($datetime, $longitude, 'd/m/Y');
    }

    /**
     * Get current time in specified timezone
     */
    public static function getCurrentTimeInTimezone($timezoneAbbr = 'WIB')
    {
        $offset = self::getTimezoneOffset($timezoneAbbr);
        return now()->addHours($offset - 7)->format('H:i') . ' ' . $timezoneAbbr;
    }

    /**
     * Get timezone badge HTML
     */
    public static function getTimezoneBadge($timezoneAbbr)
    {
        $colors = [
            'WIB' => 'bg-blue-100 text-blue-800',
            'WITA' => 'bg-green-100 text-green-800',
            'WIT' => 'bg-purple-100 text-purple-800'
        ];

        $color = $colors[$timezoneAbbr] ?? 'bg-gray-100 text-gray-800';

        return '<span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium ' . $color . '">' . $timezoneAbbr . '</span>';
    }
} 