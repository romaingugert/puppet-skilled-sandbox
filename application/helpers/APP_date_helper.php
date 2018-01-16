<?php

if (!function_exists('timezone_list')) {
    function timezone_list()
    {
        $timezones = array();
        foreach (DateTimeZone::listIdentifiers() as $timezone) {
            $dt = new \Carbon\Carbon('now');
            $tz = new DateTimeZone($timezone);
            $dt->setTimezone($tz);
            $offset = $dt->getOffset();
            $offset_string = format_timezone_offset($offset, true);
            if (!isset($timezones[$offset_string])) {
                $timezones[$offset_string] = [];
            }
            $dateformat = $dt->format('d m Y H:i:s');
            $timezones['UTC ' . $offset_string . ' - ' . $dateformat][$timezone] = $timezone . ' - ' . $dateformat;
        }
        ksort($timezones);
        return $timezones;
    }

}

if (!function_exists('format_timezone_offset')) {
    function format_timezone_offset($tz_offset, $show_null = false)
    {
        $sign = ($tz_offset < 0) ? '-' : '+';
        $time_offset = abs($tz_offset);
        if ($time_offset == 0 && $show_null == false) {
            return '';
        }
        $offset_seconds = $time_offset % 3600;
        $offset_minutes = $offset_seconds / 60;
        $offset_hours   = ($time_offset - $offset_seconds) / 3600;
        $offset_string  = sprintf("%s%02d:%02d", $sign, $offset_hours, $offset_minutes);
        return $offset_string;
    }
}

if (!function_exists('date_format_list')) {
    function date_format_list()
    {
        $carbon = new \Carbon\Carbon('now');
        $return = [
            '%B %e, %Y, %I:%M %P' => user_date_format_localized($carbon, '%B %e, %Y, %I:%M %P'),
            '%d %B %Y, %H:%M'     => user_date_format_localized($carbon, '%d %B %Y, %H :%M'),
            '%d %b %Y, %H:%M'     => user_date_format_localized($carbon, '%d %b %Y, %H :%M'),
            '%e. %b %Y %H:%M'     => user_date_format_localized($carbon, '%e. %b %Y %H:%M')
        ];
        return $return;
    }
}

if (!function_exists('get_date_format_from_datetime_format')) {
    function get_date_format_from_datetime_format($value)
    {
        $format = [
            '%B %e, %Y, %I:%M %P' => '%B %e, %Y',
            '%d %B %Y, %H:%M' => '%d %B %Y',
            '%d %b %Y, %H:%M' => '%d %b %Y',
            '%e. %b %Y %H:%M' => '%e. %b %Y',
        ];
        return $format[$value] ?? null;
    }
}

if (!function_exists('get_input_date_format')) {
    function get_input_date_format()
    {
        return 'Y-m-d';
    }
}

if (!function_exists('is_valid_input_date')) {
    function is_valid_input_date($value)
    {
        return (boolean) preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $value);
    }
}

if (!function_exists('get_input_date')) {
    function get_input_date($value, $round_half_up = false)
    {
        if (!is_valid_input_date($value)) {
            return false;
        }
        $date =  Carbon\Carbon::createFromFormat(get_input_date_format(), $value, get_user_timezone());
        if ($round_half_up) {
            $date->hour = 24;
            $date->minute = 59;
            $date->second = 59;
        } else {
            $date->hour = 0;
            $date->minute = 0;
            $date->second = 0;
        }

        if (!$date->local) {
            $date->setTimezone(\date_default_timezone_get());
        }
        return $date;
    }
}

if (!function_exists('get_input_datetime_format')) {
    function get_input_datetime_format()
    {
        return 'Y-m-d H:i';
    }
}

if (!function_exists('is_valid_input_datetime')) {
    function is_valid_input_datetime($value)
    {
        return (boolean) preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])[\ ]([0-9]{2})[\:]([0-9]{2})?$/", $value);
    }
}

if (!function_exists('get_input_datetime')) {
    function get_input_datetime($value)
    {
        if (!is_valid_input_datetime($value)) {
            return false;
        }
        $date =  Carbon\Carbon::createFromFormat(get_input_datetime_format(), $value, get_user_timezone());

        if (!$date->local) {
            $date->setTimezone(\date_default_timezone_get());
        }
        return $date;
    }
}

if (!function_exists('get_user_timezone')) {
    function get_user_timezone()
    {
        $user = app()->authenticationService->user();
        return ($user && $user->timezone ? $user->timezone : date_default_timezone_get());
    }
}

if (!function_exists('get_user_date_format')) {
    function get_user_date_format()
    {
        $user = app()->authenticationService->user();
        return ($user && $user->date_format? $user->date_format : '%d %B %Y');
    }
}

if (!function_exists('get_user_datetime_format')) {
    function get_user_datetime_format()
    {
        $user = app()->authenticationService->user();
        return ($user && $user->datetime_format? $user->datetime_format : '%d %B %Y, %H:%M');
    }
}

if (!function_exists('date_format_localized')) {
    function user_date_format_localized(Carbon\Carbon $date, $format, $timezone = false)
    {
        $timezone = ($timezone?: get_user_timezone());
        setlocale(LC_TIME, config_item('language.local'));
        $return = $date->setTimezone($timezone)->formatLocalized($format);
        setlocale(LC_TIME, 0);
        return $return;
    }
}

if (!function_exists('user_date_format')) {
    function user_date_format(\Carbon\Carbon $date, $withHours = false)
    {
        if ($withHours) {
            $format = get_user_datetime_format();
        } else {
            $format = get_user_date_format();
        }
        $return = user_date_format_localized($date, $format);
        return $return;
    }
}
