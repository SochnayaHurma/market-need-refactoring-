<?php 

namespace app\models\admin;

use app\models\AppModel;
use RedBeanPHP\R;


class Category extends AppModel
{
    public function getCountChildrenCategory(int $id): ?int
    {
        return R::count('category', 'parent_id = ?', [$id]);
    }

    public function getCountCategoryProducts(int $id): ?int
    {
        return R::count('product', 'category_id = ?', [$id]);
    }

    public function deleteCategory(int $id): bool
    {
        R::begin();
        try {
            R::exec('DELETE FROM category WHERE id = ?', [$id]);
            R::exec('DELETE FROM category_description WHERE category_id = ?', [$id]);
            R::commit();
            $_SESSION['success'] = 'Категория удалена';
            return true;
        } catch (\Exception $e) {
            if (DEBUG) debug($e);
            R::rollback();
            return false;
        }
    }
}

?>