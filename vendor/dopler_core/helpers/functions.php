<?php 

function debug($data, $die = false)
{
    echo '<pre>' . print_r($data, true) . '</pre>';
    if ($die) {die;}
}

function h(string $str)
{
    return htmlspecialchars($str);
}

function redirect($http = false)
{
    if ($http) {
        $redirect = $http;

    } else {
        $redirect = isset($_SERVER['HTTP_REFERER']) 
            ? $_SERVER['HTTP_REFERER']
            : PATH;
    }
    header("Location: $redirect");
    die;
}

function baseUrl()
{
    $lang = \dopler_core\App::$app->getProperty('lang');
    return PATH . '/' . ($lang ? $lang . '/' : '');
}

/**
 * @param string $key ключ по которому будем вынимать значение
 * @param string $type тип данных для приведения к определенному типу
 * @return string|int|float
 */
function get(string $key, $type = 'int') {
    $param = $key;
    $$param = $_GET[$param] ?? '';

    if ($type == 'int') {
        return (int)$$param;
    } else if ($type == 'float') {
        return (float)$$param;
    } else {
        return trim($$param);
    }
}

/**
 * @param string $key ключ по которому будем вынимать значение
 * @param string $type тип данных для приведения к определенному типу
 * @return string|int|float
 */
function post(string $key, $type = 'string') {
    $param = $key;
    $$param = $_POST[$param] ?? '';
    if ($type == 'int') {
        return (int)$$param;
    } else if ($type == 'float') {
        return (float)$$param;
    } else {
        return trim($$param);
    }
}

function __(string $key): void
{
    echo \dopler_core\Language::get($key);
}

function ___(string $key): string
{
    return \dopler_core\Language::get($key);
}

?>