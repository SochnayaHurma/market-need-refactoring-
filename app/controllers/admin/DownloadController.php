<?php 

namespace app\controllers\admin;


use dopler_core\App;
use dopler_core\Pagination;


class DownloadController extends AppController
{
    public function indexAction()
    {
        $current_lang_id = App::$app->getProperty('language')['id'];
        $perpage = App::$app->getProperty('pagination');
        $current_page = get('page');
        $total = $this->model->getCountDownloads();
        $pagination = new Pagination($current_page, $perpage, $total);
        $start_record = $pagination->getStart();
        $downloads = $this->model->getListDownloads($current_lang_id, $start_record, $perpage);
        $this->set(compact('pagination', 'downloads', 'total'));
        $this->setMeta('Файлы');
    }

    public function addAction()
    {
        if (!empty($_POST)) {

            if ($this->model->downloadValidate()) {
                if ($data = $this->model->uploadFile()) {
                    if ($this->model->saveDownload($data)) {
                        $_SESSION['success'] = 'Файл добавлен';
                    } else {
                        $_SESSION['errors'] = 'Ошибка добавления файла';
                    }
                } else {
                    $_SESSION['errors'] = 'Ошибка перемещения файла';
                }
            }
            redirect();
        }
        $title = 'Добавление файла';

        $this->setMeta($title);
    }

    public function deleteAction()
    {
        $id = get('id');
        if ($this->model->getCountOrderIsDownload($id)) {
            $_SESSION['errors'] = 'Невозможно удалить преобретеный файл';
            redirect();
        }
        if ($this->model->getCountProductIsDownload($id)) {
            $_SESSION['errors'] = 'Файл привязан к продукту';
            redirect();
        }
        if ($this->model->deleteDownload($id)) {
            $_SESSION['success'] = 'Файл успешно удален';
        } else {
            $_SESSION['errors'] = 'Ошибка удаления файла';
        }
        redirect();

    }
}

?>