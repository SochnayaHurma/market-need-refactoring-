<?php 

namespace app\models;

use RedBeanPHP\R;


class Cart extends AppModel
{
    public function get_product($id, $lang): array
    {
        return R::getRow(
            "SELECT p.*, pd.*
            FROM `product` AS p
            JOIN `product_description` AS pd ON p.id = pd.product_id
            WHERE p.status = 1 AND p.id = ? AND pd.language_id = ?",
            [$id, $lang['id']]
        );
    }

    public function add_to_cart(array $product, int $qty = 1): bool
    {
        $qty = abs($qty);
        
        if (isset($_SESSION['cart'][$product['id']])) {
            if ($product['is_download']) return false;
            $_SESSION['cart'][$product['id']]['qty'] += $qty;
        } else {
            $_SESSION['cart'][$product['id']] = [
                'qty' => $product['is_download'] ? 1 : $qty,
                'title' => $product['title'],
                'slug' => $product['slug'],
                'price' => $product['price'],
                'img' => $product['img'],
                'is_download' => $product['is_download'],
            ];
        }

        $cart_sum = $qty * $product['price'];
        $_SESSION['cart.qty'] = !empty($_SESSION['cart.qty']) ? $_SESSION['cart.qty'] + $qty : $qty;
        $_SESSION['cart.sum'] = !empty($_SESSION['cart.sum']) ? $_SESSION['cart.sum'] + $cart_sum : $cart_sum;
        return true;
    }

    public function delete_item(int $id): bool
    {
        $product = $_SESSION['cart'][$id];
        $_SESSION['cart.qty'] = $_SESSION['cart.qty'] - $product['qty'];
        $_SESSION['cart.sum'] = $_SESSION['cart.sum'] - $product['qty'] * $product['price'];
        unset($_SESSION['cart'][$id]);
        return true;
    }

    public static function translate_cart(array $lang): bool
    {
        if (empty($_SESSION['cart'])) return false;
        $ids = implode(',', array_keys($_SESSION['cart']));
        $products = R::getAll("SELECT p.id, pd.title 
                                FROM product AS p 
                                INNER JOIN product_description AS pd 
                                    ON p.id = pd.product_id
                                WHERE p.id IN ({$ids}) AND pd.language_id = ?", 
                                [$lang['id']]);
        foreach ($products as $product) {
            $_SESSION['cart'][$product['id']]['title'] = $product['title'];
        }
        return true;
    }
}
?>