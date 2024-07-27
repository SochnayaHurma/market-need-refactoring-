<?php 

namespace app\controllers\admin;


use dopler_core\App;
use dopler_core\Controller;
use app\widgets\language\Language;
use app\models\AppModel;
use app\models\admin\User;
use app\models\Wishlist;
use app\models\Category;
use RedBeanPHP\R;


class AppController extends Controller
{
    public false|string $layout = 'admin';

    public function __construct(array $route = [])
    {
        parent::__construct($route);
        if (!User::isAdmin() && $route['action'] != 'login-admin') {
            redirect(ADMIN.'/user/login-admin/');
        }
        new AppModel();
        $languages = Language::getLanguages();
        App::$app->setProperty('languages', $languages);
        App::$app->setProperty('language', Language::getLanguage($languages));

        $lang = App::$app->getProperty('language');

        App::$app->setProperty("categories_{$lang['code']}", Category::getCacheCategory($lang));
        App::$app->setProperty("wishlist", Wishlist::get_wishlist_ids());
    }
}

?>