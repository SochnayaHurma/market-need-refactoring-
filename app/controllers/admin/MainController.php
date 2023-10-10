<?php 

namespace app\controllers\admin;


class MainController extends AppController
{
    public function indexAction()
    {
        $orders = $this->model->countOrders();
        $new_orders = $this->model->countNewOrders();
        $users = $this->model->countUsers();
        $products = $this->model->countProducts();
        $title = 'Главная страница';
        $this->setMeta('Админ панель :: Главная');
        $this->set(compact('title', 'orders', 'new_orders', 'users', 'products'));
    }
}

?>