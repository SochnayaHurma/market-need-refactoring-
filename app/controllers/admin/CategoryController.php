<?php 

namespace app\controllers\admin;

class CategoryController extends AppController
{
    public function indexAction()
    {
        $title = 'Категории';
        $this->setMeta("Админка - {$title}");
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