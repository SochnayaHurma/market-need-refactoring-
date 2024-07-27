<?php 

namespace dopler_core;

class Language
{
    // МАссив с переводными фразами страницы
    public static array $lang_data = [];
    // МАссив для переводных фраз шаблона
    public static array $lang_layout = [];
    // Массив с переводными фразами вида
    public static array $lang_view = [];

    public static function load(string $code, array $view): void
    {
        $lang_layout = APP . "/languages/{$code}.php";
        $lang_view = APP . "/languages/{$code}/{$view['controller']}/{$view['action']}.php";
        if (file_exists($lang_layout)){
            self::$lang_layout = require_once($lang_layout);
        }
        if (file_exists($lang_view)){
            self::$lang_view = require_once($lang_view);
        }
        self::$lang_data = array_merge(self::$lang_layout, self::$lang_view);
    } 

    public static function get(string $key): string
    {
        return self::$lang_data[$key] ?? $key;
    }
}


?>