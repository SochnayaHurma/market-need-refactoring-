<?php 

namespace app\controllers;


class CartController extends AppController
{
    public function addAction()
    {
        $lang = \dopler_core\App::$app->getProperty('language');
        $id = get('id', 'int');
        $qty = get('qty', 'int');
        if (!$id) {
            return false;
        }
        $product = $this->model->get_product($id, $lang);
        if (!$product) return false;
        $this->model->add_to_cart($product, $qty);
        if ($this->isAjax()) {
            $this->loadView('cart_modal');
        } 
        redirect();
        return true;
    }

    public function showAction()
    {
        $this->loadView('cart_modal');
    }
}


?>