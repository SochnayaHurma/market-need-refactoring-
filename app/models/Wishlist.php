<?php 

namespace app\models;


use RedBeanPHP\R;


class Wishlist extends AppModel
{
    public function get_product(int $id):array|null|string
    {
        return R::getCell("SELECT p.id FROM product AS p WHERE p.status = 1 AND p.id = ?", [$id]);
    }

    public function add_to_wishlist(int $id)
    {
        $wishlist = self::get_wishlist_ids();
        if (!$wishlist) {
            setcookie('wishlist', $id, time() + 60, '/');
        } else {
            if (!in_array($id, $wishlist)) {
                if (count($wishlist) > 5) {
                    array_shift($wishlist);
                }
                $wishlist[] = $id;
                $wishlist_to_str = implode(',', $wishlist);
                setcookie('wishlist', $wishlist_to_str, time() + 60, '/');
            }
        }
    }

    public static function get_wishlist_ids(): array  
    {
        $wishlist = $_COOKIE['wishlist'] ?? '';
        if ($wishlist) {
            $wishlist = explode(',', $wishlist);
        }
        if (is_array($wishlist)) {
            $wishlist = array_slice($wishlist, 0, 6);
            $wishlist = array_map('intval', $wishlist,);
            return $wishlist;
        }
        return [];
    }
}

?>