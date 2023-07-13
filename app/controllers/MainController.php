<?php 

namespace app\controllers;

use RedBeanPHP\R;
use dopler_core\App;


class MainController extends AppController
{
    public function indexAction()
    {
        __("tpl_search");
        $current_language = App::$app->getProperty('language');
        $slides = R::findAll('slider');
        $products = $this->model->get_hits($current_language['id'], 6); 
        $this->set(compact('slides', 'products'));
        $this->setMeta(___("main_index_meta_title"), ___("main_index_meta_description"), ___("main_index_meta_keywords"));

    }
}
?>