<?php

if (!function_exists('classActivePath')) {

    function classActivePath($path)
    {
        return Request::is($path) ? ' class="active"' : '';
    }

}

if (!function_exists('classActiveSegment')) {

    function classActiveSegment($segment, $value)
    {
        if (!is_array($value)) {
            return Request::segment($segment) == $value ? ' class="active"' : '';
        }
        foreach ($value as $v) {
            if (Request::segment($segment) == $v) {
                return ' class="active"';
            }
        }
        return '';
    }

}

if (!function_exists('classActiveOnlyPath')) {

    function classActiveOnlyPath($path)
    {
        return Request::is($path) ? ' active' : '';
    }

}

if (!function_exists('classActiveOnlySegment')) {

    function classActiveOnlySegment($segment, $value)
    {
        if (!is_array($value)) {
            return Request::segment($segment) == $value ? ' active' : '';
        }
        foreach ($value as $v) {
            if (Request::segment($segment) == $v) {
                return ' active';
            }
        }
        return '';
    }

}

if (!function_exists('qs_url')) {

    function qs_url($path = null, $qs = [], $secure = null)
    {
        $url = app('url')->to($path, $secure);
        if (is_array($qs) && count($qs)) {
            foreach ($qs as $key => $value) {
                if (!is_array($value)) {
                    $qs[$key] = sprintf('%s=%s', $key, urlencode($value));
                    continue;
                }
                qs_url_array($qs, $key, $value);
            }
            $url = sprintf('%s?%s', $url, implode('&', $qs));
        }
        return $url;
    }

    function qs_url_array(&$qs, $key, $value)
    {
        foreach ($value as $subKey => $subValue) {
            $qs[$key . '[' . $subKey . ']'] = sprintf('%s=%s', $key . '[' . $subKey . ']', urlencode($subValue));
        }
        unset($qs[$key]);
    }

}

if (!function_exists('shift_array')) {

    function shift_array(&$arr)
    {
        reset($arr);
        $ret = each($arr);
        unset($arr[$ret[0]]);
        return $ret;
    }

}

if (!function_exists('getval')) {

    function getval(&$val, $default = null)
    {
        return isset($val)
            && (is_string($val) ? $val !== '' : true)
            && (is_array($val) ? count($val) : true) ? $val : $default;
    }

}

if (!function_exists('setval')) {

    function setval(&$item, $val, $default = null)
    {
        $item = isset($val) ? $val : $default;
    }

}

if (!function_exists('getJsonFromArray')) {

    function getJsonFromArray($value)
    {
        if (!is_array($value)) {
            return null;
        }
        $json = json_encode($value);
        if ($json !== json_encode(array_values($value))) {
            return null;
        }
        return $json;
    }
}

if (!function_exists('getArrayFromJson')) {

    function getArrayFromJson($value)
    {
        if (!is_string($value)) {
            return null;
        }
        $json = json_decode($value);
        if (!is_array($json) || $value !== json_encode($json)) {
            return null;
        }
        return $json;
    }
}

if (!function_exists('array_get')) {

    function array_get()
    {
        $args = func_get_args();
        if (count($args) == 0) {
            return null;
        }
        if (count($args) == 1) {
            return $args[0];
        }
        $arr = array_shift($args);
        $key = array_shift($args);
        if (!isset($arr[$key])) {
            return null;
        }
        array_unshift($args, $arr[$key]);
        return call_user_func_array('getval', $args);
    }

}

if (!function_exists('pdf_template_path')) {

    function pdf_template_path($f = '')
    {
        return resource_path('assets/pdf/template/' . $f);
    }

}

if (!function_exists('pdf_font')) {

    function pdf_font()
    {
        return ['Hgrsmp', 'Hgrsmp', 'Hgrsmp'];
    }

}

if (!function_exists('ub')) {

    function ub(&$u, $b)
    {
        foreach (getval($b, []) as $key => $value) {
            if (!is_array($value)) {
                $u[$key] = $b[$key];
                continue;
            }
            if (!isset($u[$key]) || !is_array($u[$key])) {
                $u[$key] = [];
            }
            ub($u[$key], $b[$key]);
        }
        return $u;
    }

}

if (!function_exists('packingQuery')) {

    function packingQuery($query, $name = 'sub')
    {
        return DB::table(DB::raw("({$query->toSql()}) as " . $name))->mergeBindings($query->getQuery());
    }

}

if (!function_exists('zip_seven')) {

    // 郵便番号変換 123-4567 → 1234567
    function zip_seven($value)
    {
        return implode('', explode('-', $value));
    }

}

if (!function_exists('zip_normalize')) {

    // 郵便番号変換 1234567 → 123-4567
    function zip_normalize($value)
    {
        $value = zip_seven($value);
        if (!$value) {
            return '';
        }
        return substr($value, 0, 3) . '-' . substr($value, 3, 4);
    }

}

if (!function_exists('getQueryBuilder')) {

    function getQueryBuilder(
        Illuminate\Database\ConnectionInterface $connection,
        Illuminate\Database\Grammar $grammar = null,
        Illuminate\Database\Query\Processors\Processor $processor = null)
    {
        return new App\Services\QueryBuilder(
            $connection, $grammar, $processor
        );
    }

}

if (!function_exists('setting')) {

    function setting($id)
    {
        $setting = request()->cookie('common-setting');
        $value = getval($setting[$id]);
        if (in_array($id, ['per-page']) && ($value < 5 || $value > 1000)) {
            return config('app.per_page');
        }
        return $value;
    }

}

if (!function_exists('name_dot')) {

    function name_dot($name)
    {
        return preg_replace('/\]/', '', preg_replace('/\[/', '.', $name));
    }

}

if (!function_exists('butifleImplode')) {

    function butifleImplode(array $pieces, $glue = '-')
    {
        foreach ($pieces as $key => $piece) {
            if ($piece) {
                continue;
            }
            unset($pieces[$key]);
        }
        return implode($glue, $pieces);
    }

}

if (!function_exists('call')) {

    function call()
    {
        $args = func_get_args();
        $callback = array_shift($args);
        return $callback($args);
    }

}

if (!function_exists('log_path')) {

    function log_path($path)
    {
        return config('app.storage_path', storage_path()) . '/logs/' . $path;
    }
}


if (!function_exists('get_cols')) {

    function get_cols(array $items, $cols)
    {
        $result = [];
        foreach ($items as $item) {
            foreach ($cols as $col) {
                $result[$col][] = $item[$col];
            }
        }
        return $result;
    }

}

if (!function_exists('create_date')) {

    function create_date($date)
    {
        return (new App\Services\DateTimeServices($date))->format('Y年 n月 j日');
    }

}

if (!function_exists('create_ym')) {

    function create_ym($date)
    {
        return (new App\Services\DateTimeServices($date))->format('Y年 n月');
    }

}

if (!function_exists('get_floatval')) {

    function get_floatval($value)
    {
        return is_string($value) ? floatval(preg_replace('/,/', '', $value)) : 0.0;
    }

}
