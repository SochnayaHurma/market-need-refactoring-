<?php 

namespace app\models;

use dopler_core\Model;
use RedBeanPHP\R;


class AppModel extends Model {
    public static function rus2translit(string $value)
    {
        $converter = [
            'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'e',
            'ж' => 'zh', 'з' => 'z', 'и' => 'i', 'й' => 'y', 'к' => 'k', 'л' => 'l', 'м' => 'm', 
            'н' => 'n', 'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u',
            'ф' => 'f', 'х' => 'h', 'ц' => 'c','ч' => 'ch', 'ш' => 'sh', 'щ' => 'sch', 'ь' => '\'',
            'ы' => 'y', 'ъ' => '\'', 'э' => 'e', 'ю' => 'yu', 'я' => 'ya', 
            'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'E',
            'Ж' => 'ZH', 'З' => 'Z', 'И' => 'I', 'Й' => 'Y', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 
            'Н' => 'N', 'О' => 'O', 'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'У' => 'U',
            'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C','Ч' => 'CH', 'Ш' => 'SH', 'Щ' => 'SCH', 'Ь' => '\'',
            'Ы' => 'Y', 'Ъ' => '\'', 'Э' => 'E', 'Ю' => 'YU', 'Я' => 'YA', 
        ];
        return strtr($value, $converter);
    }

    public static function str2url(string $value)
    {
        $value = self::rus2translit($value);
        $value = strtolower($value);
        $value = preg_replace('~[^-a-z0-9_]+~u', '-', $value);
        return trim($value, '-');

    }

    public static function create_slug(string $table, string $field, string $value, int $id): string
    {
        $value = self::str2url($value);
        $query = R::findOne($table, "$field = ?", [$value]);

        if ($query) {
            $value = "{$value}-{$id}";
            $query = R::count($table, "$field = ?", [$value]);
            if ($query) {
                $value = self::create_slug($table, $field, $value, $id);
            }
        }
        return $value;
    }
}


?>