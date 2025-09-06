<?php

use Illuminate\Http\Request;
use Illuminate\Support\HtmlString;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

if (!function_exists('trustedproxy_config')) {
    /**
     * Get Trusted Proxy value
     *
     * @param string $key
     * @param string $env_value
     *
     * @return mixed
     */
    function trustedproxy_config($key, $env_value)
    {
        if ($key === 'proxies') {
            if ($env_value === '*' || $env_value === '**') {
                return $env_value;
            }

            return $env_value ? explode(',', $env_value) : null;
        } elseif ($key === 'headers') {
            if ($env_value === 'HEADER_X_FORWARDED_AWS_ELB') {
                return Request::HEADER_X_FORWARDED_AWS_ELB;
            } elseif ($env_value === 'HEADER_FORWARDED') {
                return Request::HEADER_FORWARDED;
            }

            return Request::HEADER_X_FORWARDED_ALL;
        }

        return null;
    }
}

if (!function_exists('redirect_back_field')) {
    /**
     * Generate a redirect back url form field.
     *
     * @return \Illuminate\Support\HtmlString
     */
    function redirect_back_field()
    {
        return new HtmlString('<input type="hidden" name="_redirect_back" value="' . old('_redirect_back', back()->getTargetUrl()) . '">');
    }
}

if (!function_exists('currency_format')) {
    /**
     * Get the settings.
     *
     * @param string $price
     * @param string $unit
     * @return string
     */
    function currency_format($price, $unit = null)
    {
        if (is_numeric($price)) {
            $symbol = $unit ? ' đ' : '';
            $symbol_thousand = '.';
            $decimal_place = 0;
            $price = number_format($price, $decimal_place, '', $symbol_thousand);
            return $unit == 1 ? $price . $symbol : $symbol . $price;
        }
        return $price;
    }
}

if (!function_exists('phone_format')) {
    /**
     * Get the settings.
     *
     * @param string $phone
     * @param string $sep
     * @return string
     */
    function phone_format($phone, $sep = '-')
    {
        if ($phone) {
            $phone = substr_replace($phone, $sep, -6, 0);
            $phone = substr_replace($phone, $sep, -3, 0);
        }
        return $phone;
    }
}

if (!function_exists('get_interval')) {
    /**
     * Get the interval.
     *
     * @param datetime $datetime
     * @param string $unit [i, H, d, m, Y]
     * @return string
     */
    function get_interval($datetime, $unit = 'i')
    {
        $units = ['giây', 'phút', 'giờ', 'ngày', 'tuần', 'tháng', 'năm'];
        //
        $offsets = [1, 60, 3600, 86400, 604800, 2419200, 29030400];
        //
        $interval = $datetime->diffInSeconds(Carbon::now());
        for ($x = 1; $x < count($units); $x++) {
            if (($interval / $offsets[$x]) < 1) {
                return (int) ($interval / $offsets[$x - 1]) . ' ' . $units[$x - 1] . ' trước';
                break;
            } else if ($x == count($units) - 1) return (int) ($interval / $offsets[$x - 1]) . ' ' . $units[$x] . ' trước';
        }
        //
        return (int) ($interval / $offsets[$x - 1]) . ' ' . $units[0] . ' trước';
    }
}

if (!function_exists('split_name')) {
    /**
     * Get the lastname and firstname.
     *
     * @param string $name
     * @return string
     */
    function split_name($name, $with = 1)
    {
        $arr = explode(' ', $name);
        $num = count($arr);
        $first_name = $middle_name = $last_name = null;
        //
        if ($num == 2) {
            list($first_name, $last_name) = $arr;
        } else {
            list($first_name, $middle_name, $last_name) = $arr;
        }
        // output
        if ($with == 1) return $last_name;
        if ($with == 2) return ($middle_name ? $middle_name : $first_name) . ' ' . $last_name;
        return array($first_name, $middle_name, $last_name);
    }
}

if (!function_exists('default_index')) {
    /**
     * Get the default index.
     *
     * @return string
     */
    function default_index()
    {
        return 1;
    }
}

if (!function_exists('vice_branch_role')) {
    /**
     * Get the vice branch role.
     *
     * @return string
     */
    function vice_branch_role()
    {
        return 1;
    }
}

if (!function_exists('branch_manager_role')) {
    /**
     * Get thebranch manager role.
     *
     * @return string
     */
    function branch_manager_role()
    {
        return 2;
    }
}

if (!function_exists('assistant_role')) {
    /**
     * Get the assistant role.
     *
     * @return string
     */
    function assistant_role()
    {
        return 3;
    }
}

if (!function_exists('administrator_role')) {
    /**
     * Get the administrator role.
     *
     * @return string
     */
    function administrator_role()
    {
        return 4;
    }
}

if (!function_exists('base_member')) {
    /**
     * Get the base member.
     *
     * @return string
     */
    function base_member()
    {
        return 1;
    }
}

if (!function_exists('paginate')) {
    /**
     * Gera a pagination dos itens de um array ou collection.
     *
     * @param array|Collection      $items
     * @param int   $perPage
     * @param int  $page
     * @param array $options
     *
     * @return LengthAwarePaginator
     */
    function paginate($items, $perPage = 15, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $page = $page > 0 ? $page : ceil($items->count() / $perPage);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}
