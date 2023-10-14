<?php 

namespace app\controllers\admin;

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