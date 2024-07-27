<?php 

namespace app\controllers\admin;


use dopler_core\App;
use dopler_core\Pagination;


class PageController extends AppController
{
    public function indexAction()
    {
        $lang = App::$app->getProperty('language');
        $page = get('page');
        $perpage = App::$app->getProperty('pagination');
        $total = $this->model->countPages();
        $pagination = new Pagination($page, $perpage, $total);
        $start_record = $pagination->getStart();
        $pages = $this->model->getPages($lang, $start_record, $perpage);
        $title = 'Список страниц';
        $this->set(compact('pages', 'total', 'pagination'));
        $this->setMeta($title);
    }

    public function addAction()
    {
        if (!empty($_POST)) {
            if ($this->model->pageValidate()) {
                if ($this->model->savePage()) {
                    $_SESSION['success'] = 'Страница добавлена';
                } else {
                    $_SESSION['errors'] = 'Ошибка добавления страницы';
                }
            }  
            redirect();
        }
        $title = 'Новая страница';
        $this->setMeta($title);
    }

    public function deleteAction()
    {
        $id = get('id', 'int');
        $clear_cache = get('cache');
        if (!empty($id) && $this->model->deletePage($id, $clear_cache)) {

            $_SESSION['success'] = 'Страница удалена';
        } else {
            $_SESSION['errors'] = 'Ошибка удаления страницы';
        }
        redirect();
    }

    public function editAction()
    {
        $id = get('id', 'int');
        $page = $this->model->getPage($id);
        if (!$page) {
            throw new \Exception('Not found page', 404);
        }


        if (!empty($_POST)) {
            if ($this->model->pageValidate()) {
                if ($this->model->updatePage($id)) {
                    $_SESSION['success'] = 'Страница успешно обновлена';
                } else {
                    $_SESSION['errors'] = 'Произошла ошибка обновления';
                }
            }
            redirect();
        }
        $title = 'Редактирование страницы';
        $this->setMeta($title);
        $this->set(compact('page'));
    }
}

?>