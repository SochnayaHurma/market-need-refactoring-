<?php 

namespace app\controllers;


use dopler_core\Controller;
use dopler_core\App;
use app\widgets\language\Language;
use app\models\AppModel;
use app\models\Category;
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

        $categories = Category::getCacheCategory($lang);
        App::$app->setProperty("categories_{$lang['code']}", $categories);
        App::$app->setProperty("wishlist", Wishlist::get_wishlist_ids());
    }
}


?>