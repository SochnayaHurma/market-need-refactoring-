<?php 

namespace app\controllers;


use dopler_core\Controller;
use dopler_core\App;
use app\widgets\language\Language;
use app\models\AppModel;
use app\models\Wishlist;
use RedBeanPHP\R;


class AppController extends Controller
{
    public function __construct(array $route)
    {

        parent::__construct($route);
        new AppModel();
        App::$app->setProperty('languages', Language::getLanguages());
        App::$app->setProperty(
            'language', 
            Language::getLanguage(App::$app->getProperty('languages'))
        );
        $lang = App::$app->getProperty("language");
        \dopler_core\Language::load($lang['code'], $route);
        $query_categories = "SELECT c.*, cd.* 
                            FROM category AS c 
                            JOIN category_description AS cd ON c.id = cd.category_id
                            WHERE cd.language_id = ?";
        $categories = R::getAssoc($query_categories, [$lang['id']]);
        App::$app->setProperty("categories_{$lang['code']}", $categories);
        App::$app->setProperty("wishlist", Wishlist::get_wishlist_ids());
    }
}


?>