<?php 

namespace app\models;


use dopler_core\App;


class BreadCrumbs extends AppModel 
{
    public static function getBreadCrumbs(int $categoryId, string $name = ''): string
    {
        $lang = App::$app->getProperty('language')['code'];
        $categories = App::$app->getProperty("categories_{$lang}");
        $breadcrumbs_array = self::getParts($categories, $categoryId);
        $breadcrumbs_html = '<li class="breadcrumb-item"><a href="' . baseUrl() . '"><i>' . ___('tpl_home_breadcrumbs') . '</a></li>';

        if ($breadcrumbs_array) {
            foreach($breadcrumbs_array as $slug => $title) {
                $breadcrumbs_html .= '<li class="breadcrumb-item"><a href="category/' . $slug . '">' . $title . '</a></li>';
            }
            if ($name) {
                $breadcrumbs_html .= '<li class="breadcrumb-item active">' . $name . '</li>';
            }
        }
        return $breadcrumbs_html;
    }

    public static function getParts(array $categories, int $id): array|false
    {
        if (!$id) return false;
        $breadcrumbs = [];
        foreach ($categories as $k => $v){
            if (isset($categories[$id])) {
                $breadcrumbs[$categories[$id]['slug']] = $categories[$id]['title'];
                $id = $categories[$id]['parent_id'];
            } else {
                break;
            }
        }
        return array_reverse($breadcrumbs, true);
    }
}

?>