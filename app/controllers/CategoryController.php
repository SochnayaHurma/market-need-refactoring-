<?php 

namespace app\controllers;


use dopler_core\App;
use dopler_core\Pagination;
use app\models\BreadCrumbs;


/** @property Category $model */
class CategoryController extends AppController
{
    public function viewAction()
    {
        $lang = App::$app->getProperty('language');
        $category = $this->model->get_category($this->route['slug'], $lang);
        if (!$category) {
            return $this->error_404();
        }
        $breadcrumbs = Breadcrumbs::getBreadCrumbs($category['id']);
        $categories = App::$app->getProperty("categories_{$lang['code']}");
        $ids = $this->model->get_ids($category['id'], $categories);

        $page = get('page');
        $perPage = App::$app->getProperty('pagination');
        $total = $this->model->getCountProducts($ids);
        $pagination = new Pagination($page, $perPage, $total);
        $target_product = $pagination->getStart();

        $products = $this->model->get_products($ids, $lang, $target_product, $perPage);
        $countProducts = count($products);
        $this->setMeta($title=$category['title'], $description=$category['description'], $keywords=$category['keywords']);
        $this->set(compact('category', 'breadcrumbs', 'products', 'pagination', 'total', 'countProducts'));

    }
}

?>