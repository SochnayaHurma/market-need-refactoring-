<?php 

namespace app\controllers\admin;


use dopler_core\App;
use dopler_core\Pagination;


class OrderController extends AppController
{
    public function indexAction()
    {
        $status = get('status', 'str');
        $status = ($status == 'new') ? 'status = 0' : '';
        $page = get('page');
        $perpage = App::$app->getProperty('pagination');
        $total = $this->model->countOrders($status);
        $pagination = new Pagination($page, $perpage, $total);
        $start_record = $pagination->getStart();
        $orders = $this->model->getOrders($start_record, $perpage, $status);
        $this->set(compact('orders', 'pagination', 'total'));
        $this->setMeta('Заказы');
    }

    public function editAction()
    {
        $id = get('id');
        if (isset($_GET['status'])) {
            $status = get('status', 'int');
            if ($this->model->changeStatus($id, $status)) {
                $_SESSION['success'] = 'Статус заказа изменен';
            } else {
                $_SESSION['errors'] = 'Ошибка изменения статус заказа';
            }
        }
        $order = $this->model->getOrder($id);
        if (!$order) {
            throw new \Exception('Not found order', 404);
        } 
        $title = "Заказ номер: {$id}";
        $this->set(compact('title', 'order'));
        $this->setMeta($title);
    }
}

?>