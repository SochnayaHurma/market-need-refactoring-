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

    public function deleteAction()
    {
        $id = get('id', 'int');
        if (!$id) return false;
        if (isset($_SESSION['cart'][$id])) {
            $this->model->delete_item($id);
        }
        if ($this->isAjax()){
            $this->loadView('cart_modal');
        }
        redirect();
        
    }

    public function clearAction()
    {
        if (empty($_SESSION['cart'])) return false;
        unset($_SESSION['cart.sum']);
        unset($_SESSION['cart.qty']);
        unset($_SESSION['cart']);
        $this->loadView('cart_modal');
        return true;
    }
}


?>