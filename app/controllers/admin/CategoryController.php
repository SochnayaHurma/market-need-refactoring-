<?php 

namespace app\controllers\admin;

use \dopler_core\App;

class CategoryController extends AppController
{
    public function indexAction()
    {
        $title = 'Категории';
        $this->setMeta("Админка - {$title}");
    }

    public function addAction()
    {
        $title = 'Добавление категории';
        if (!empty($_POST)) {
            if ($this->model->category_validate()) {
                if ($this->model->save_category()) {
                    $_SESSION['success'] = 'Категория создана';
                } else {
                    $_SESSION['errors'] = 'Что-то пошло не так...';
                }
            }
            redirect();
        }
        $this->setMeta($title);
        $this->set(compact('title'));
    }

    public function editAction()
    {
        $title = 'Редактирование категории';
        $id = get('id', 'int');

        if (!empty($_POST)) {
            if ($this->model->category_validate()) {
                if ($this->model->update_category($id)) {
                    $_SESSION['success'] = 'Категория обновлена';
                } else {
                    $_SESSION['errors'] = 'Ошибка добавления категории';
                }
            }
            redirect();
        }
        $category = $this->model->get_category($id);
        if (!$category) {
            throw new \Exception('Not found category', 404);
        }
        $lang_id = App::$app->getProperty('language')['id'];
        App::$app->setProperty('parent_id', $category[$lang_id]['parent_id']);
        $this->setMeta($title);
        $this->set(compact('title', 'category'));

    }

    public function deleteAction()
    {
        $id = get('id');
        $errors = '';
        if ($this->model->getCountChildrenCategory($id)) {
            $errors .= 'Ошибка! В категории есть вложенные категории';
        }
        if ($this->model->getCountCategoryProducts($id)) {
            $errors .= 'Ошибка! В категории есть товары!<br/>';
        }
        if ($errors) {
            $_SESSION['errors'] = $errors;
            redirect();
        }
        $this->model->deleteCategory($id);
        redirect();
    }
}
?>