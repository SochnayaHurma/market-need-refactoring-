<?php 

namespace app\models;


use RedBeanPHP\R;


class Category extends AppModel
{
    public function get_category(string $slug, array $lang): array
    {
        return R::getRow('SELECT c.*, cd.* 
                FROM category AS c 
                JOIN category_description AS cd ON c.id = cd.category_id 
                WHERE cd.language_id = ? AND c.slug = ?', [$lang['id'], $slug]);
    }

    public function get_ids(string $current_id, ?array $categories): string
    {
        $ids = $current_id;
        foreach ($categories as $id => $category) {
            if ($category['parent_id'] == $current_id) {
                $ids .= ',' . $this->get_ids($id, $categories);
            }
        }
        return $ids;
    }

    public function get_products(string $ids, array $lang, int $offset, int $limit): array
    {
        $sort_values = [
            "title_asc" => "ORDER BY pd.title ASC",
            "title_desc" => "ORDER BY pd.title DESC",
            "price_asc" => "ORDER BY p.price ASC",
            "price_desc" => "ORDER BY p.price DESC",
        ];
        $order_by = '';
        if (isset($_GET['sort']) && key_exists($_GET['sort'], $sort_values)) {
            $order_by = $sort_values[$_GET['sort']];
        }
        return R::getAll(
            "SELECT p.*, pd.*
            FROM product AS p
            JOIN product_description AS pd ON p.id = pd.product_id
            WHERE p.status = 1 AND p.category_id IN ($ids) AND pd.language_id = ? 
            $order_by
            LIMIT ?,?
            ", [$lang['id'], $offset, $limit]
        );
    }

    public function getCountProducts(string $ids): ?int
    {  
        return R::count('product', "category_id IN ($ids) AND status = 1");
    }
}

?>