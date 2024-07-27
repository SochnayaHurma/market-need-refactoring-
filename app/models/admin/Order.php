<?php 

namespace app\models\admin;


use app\models\AppModel;
use RedBeanPHP\R;

class Order extends AppModel
{
    public function countOrders(string $status): int
    {
        return R::count('orders', $status);
    }

    public function getOrders(int $offset, int $limit, string $status): array
    {
        if ($status) {
            return R::getAll(
                "SELECT * 
                FROM `orders` 
                WHERE {$status}
                ORDER BY id DESC
                LIMIT {$offset}, {$limit}
                ");
        } else {
            return R::getAll(
                "SELECT *
                FROM `orders`
                ORDER BY id DESC
                LIMIT {$offset}, {$limit}"
            );
        }
    }

    public function getOrder(int $id): array
    {
        return R::getAll('
            SELECT o.*, op.*
            FROM orders AS o
            JOIN order_product AS op ON o.id = op.order_id
            WHERE o.id = ?
        ', [$id]);
    }

    public function changeStatus(int $id, int $status): bool
    {
        $status = ($status == 1) ? 1 : 0;
        R::begin();
        try {
            R::exec('UPDATE `orders` SET `status` = ? WHERE id = ?', [$status, $id]);
            R::exec('UPDATE `order_download` SET `status` = ? WHERE order_id = ?', [$status, $id]);
            R::commit();
            return true;
        } catch (\Exception $e) {
            debug($e, 1);
            R::rollback();
            return false;
        }
    }
}

?>