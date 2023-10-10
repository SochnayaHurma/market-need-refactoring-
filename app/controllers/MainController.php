<?php 

namespace app\controllers;

use RedBeanPHP\R;
use dopler_core\App;
use dopler_core\Cache;


class MainController extends AppController
{
    public function indexAction()
    {

        $current_language = App::$app->getProperty('language');
        $slides = $this->model->get_slider();
        $products = $this->model->get_hits($current_language['id'], 6); 
        $this->set(compact('slides', 'products'));
        $this->setMeta(___("main_index_meta_title"), ___("main_index_meta_description"), ___("main_index_meta_keywords"));
    }
}
?>