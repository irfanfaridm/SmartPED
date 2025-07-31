<?php

namespace App\Helpers;

use Carbon\Carbon;

class TimeZoneHelper
{
    /**
     * Get timezone abbreviation based on longitude
     * 
     * @param float|null $longitude
     * @return string
     */
    public static function getTimezoneAbbr($longitude)
    {
        if ($longitude === null) {
            return 'WIB'; // Default to WIB
        }
        
        // Indonesia timezone boundaries
        // WIB: 105°E to 127.5°E (Jakarta, Sumatra, Java, Kalimantan)
        // WITA: 127.5°E to 142.5°E (Sulawesi, Bali, Nusa Tenggara)
        // WIT: 142.5°E to 157.5°E (Maluku, Papua)
        
        if ($longitude >= 105 && $longitude < 127.5) {
            return 'WIB';
        } elseif ($longitude >= 127.5 && $longitude < 142.5) {
            return 'WITA';
        } elseif ($longitude >= 142.5 && $longitude <= 157.5) {
            return 'WIT';
        } else {
            return 'WIB'; // Default for coordinates outside Indonesia
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