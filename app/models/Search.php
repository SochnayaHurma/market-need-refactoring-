<?php 

namespace app\models;


use RedBeanPHP\R;

class Search extends AppModel
{
    public function getCountSearchProduct(string $s, array $lang): int
    {
        return R::getCell("SELECT COUNT(p.id) 
                FROM product AS p 
                JOIN product_description AS pd ON p.id = pd.product_id 
                WHERE p.status = 1 AND pd.language_id = ? AND pd.title LIKE ?", [$lang['id'], "%{$s}%"]);
    }

    public function getFindedProduct(string $s, array $lang, int $start, int $perpage): array
    {
        return R::getAll("SELECT p.*, pd.* 
                FROM product AS p
                JOIN product_description AS pd ON p.id = pd.product_id
                WHERE p.status = 1 AND pd.language_id = ? AND pd.title LIKE ?
                LIMIT {$start},{$perpage}", [$lang['id'], "%{$s}%"]);
    }
}

?>