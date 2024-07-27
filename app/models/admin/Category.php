<?php 

namespace app\models\admin;

use app\models\AppModel;
use RedBeanPHP\R;


class Category extends AppModel
{
    public function get_category(int $id): array
    {
        return R::getAssoc("SELECT cd.language_id, cd.*, c.* 
                            FROM category_description AS cd
                            JOIN category AS c ON c.id = cd.category_id
                            WHERE c.id = ?", [$id]);
    }

    public function category_validate(): bool
    {
        $errors = '';
        foreach ($_POST['category_description'] as $lang_id => $item) {
            $item['title'] = trim($item['title']);
            if (empty($item['title'])) {
                $errors .= "Не заполнено наименование во вкладке {$lang_id}";
            }
        }

        if ($errors) {
            $_SESSION['errors'] = $errors;
            $_SESSION['form_data'] = $_POST;
            return false;
        }
        return true;
    }

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

    public function update_category(int $id): bool
    {
        R::begin();
        try {
            $category = R::load('category', $id);
            if (!$category) {
                return false;
            }

            $category->parent_id = post('parent_id', 'int');


            R::store($category);

            foreach ($_POST['category_description'] as $lang => $post_data) {
                 R::exec("
                    UPDATE category_description
                    SET title = ?, description = ?, keywords = ?, content = ?
                    WHERE category_description.category_id = ?
                        AND category_description.language_id = ?
                 ", [
                    $post_data['title'], 
                    $post_data['description'],
                    $post_data['keywords'],
                    $post_data['content'],
                    $id,
                    $lang
                ]);
            }
            R::commit();
            return true;
        } catch (\Exception $e) {
            R::rollback();
            if (DEBUG) {
                debug($e, 1);
            }
            return false;
        }
    }

    public function save_category(): bool
    {
        R::begin();
        try {
            $category = R::dispense('category');
            $category->parent_id = post('parent_id', 'int');
            $category_id = R::store($category);
            $category->slug = self::create_slug(
                'category', 
                'slug',
                $_POST['category_description'][1]['title'],
                $category_id
            );
            R::store($category);

            foreach ($_POST['category_description'] as $lang => $post_data) {
                 R::exec("
                    INSERT INTO category_description
                    VALUES
                    (?, ?, ?, ?, ?, ?)
                 ", [$category_id, $lang, 
                    $post_data['title'], 
                    $post_data['description'],
                    $post_data['keywords'],
                    $post_data['content']]);
            }
            R::commit();
            return true;
        } catch (\Exception $e) {
            R::rollback();
            if (DEBUG) {
                debug($e, 1);
            }
            return false;
        }
    }


}

?>