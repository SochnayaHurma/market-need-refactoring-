<?php 

namespace app\controllers;


use dopler_core\App;
use dopler_core\Pagination;

class SearchController extends AppController
{
    public function indexAction()
    {
        $s = get('s', 'str');
        $page = get('page', 'int');
        $perpage = App::$app->getProperty('pagination');
        $lang = App::$app->getProperty('language');
        $total_products = $this->model->getCountSearchProduct($s, $lang);
        $pagination = new Pagination($page, $perpage, $total_products);
        $start = $pagination->getStart();
        $product_query = $this->model->getFindedProduct($s, $lang, $start, $perpage);
        $this->setMeta(___('tpl_search_title'), );
        $this->set(compact('pagination', 'product_query', 's', 'total_products'));
    }
}

?>