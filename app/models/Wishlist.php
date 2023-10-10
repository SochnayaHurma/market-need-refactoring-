<?php 

namespace app\models;


use dopler_core\App;
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

    public function delete_from_wishlist(int $id): bool
    {
        $wishlist = self::get_wishlist_ids();
        $key = array_search($id, $wishlist);
        if (false !== $key) {
            unset($wishlist[$key]);
            if ($wishlist) {
                setcookie('wishlist', implode(',', $wishlist), time() + 60, '/');
            } else {
                setcookie('wishlist', '', time() - 3600, '/');
            }
            return true;
        }
        return false;
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

    public function get_wishlist_products(array $lang): array
    {
        $ids = self::get_wishlist_ids(); 
        if ($ids) {
            $ids = implode(',', $ids);
            return R::getAll("SELECT p.*, pd.* 
                    FROM product AS p 
                    JOIN product_description AS pd ON p.id = pd.product_id
                    WHERE p.status = 1 AND id IN ($ids) AND pd.language_id = ?
                    LIMIT 6", [$lang['id']]);
        }
        return [];
    }
}

?>