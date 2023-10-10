<?php 

namespace app\models\admin;


use app\models\AppModel;
use RedBeanPHP\R;


class Main extends AppModel
{
    public function countOrders(): int
    {
        return R::count('orders');
    }

    public function countNewOrders(): int
    {
        return R::count('orders', 'status = 0');
    }

    public function countUsers(): int
    {
        return R::count('user');
    }

    public function countProducts(): int
    {
        return R::count('product');
    }
}

?>