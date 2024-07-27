<?php 

namespace app\controllers\admin;

use dopler_core\App;
use dopler_core\Pagination;

class ProductController extends AppController
{
    public function indexAction()
    {
        $lang = App::$app->getProperty('language');
        $page = get('page', 'int');
        $perpage = 5;
        $count_products = $this->model->getCountProducts();
        $pagination = new Pagination($page, $perpage, $count_products);
        $page_start = $pagination->getStart();

        $products = $this->model->getProducts($lang, $page_start, $perpage);
        $title = 'Список товаров';
        $this->setMeta($title);
        $this->set(compact('title', 'products', 'pagination', 'page', 'count_products'));
    }

    public function addAction()
    {
        if (!empty($_POST)) {
            if ($this->model->productValidate()) {
                if ($this->model->saveProduct()) {
                    $_SESSION['success'] = 'Товар был успешно добавлен';
                } else {
                    $_SESSION['errors'] = 'Что-то пошло не так...';
                }
            }
            redirect();
        }
        $title = 'Добавить товар';
        $this->setMeta($title);
        $this->set(compact('title'));
    }

    public function editAction()
    {
        $id = get('id', 'int');
        $current_lang = App::$app->getProperty('language')['id'];
        if (!empty($_POST)) {
            // debug($_POST, 1);
            if ($this->model->productValidate()) {
                if ($this->model->editProduct($id)) {
                    $_SESSION['success'] = 'Товар сохранен';
                } else {
                    $_SESSION['errors'] = 'Ошибка обновления товара';
                }
            }
            redirect();
        }
        $product = $this->model->getProduct($id, $current_lang);
        if (!$product) throw new \Exception("Not found product", 404);
        App::$app->setProperty('parent_id', $product[$current_lang]['category_id']);
        // debug($product, 1);
        $title = 'Редактирование товара';
        $this->setMeta($title);
        $this->set(compact('title', 'product', 'current_lang'));
    }

    public function getDownloadAction()
    {
        $q = get('q', 'str');
        $data = $this->model->getDownloads($q);
        echo json_encode($data);
        die;
    }
}


// $data = [
//     'items' => [
//         [
//             'id' => 1,
//             'text' => 'Файл 1'
//         ],

//         [
//             'id' => 2,
//             'text' => 'Файл 2'
//         ],

//         [
//             'id' => 3,
//             'text' => 'Файл 3'
//         ],

//         [
//             'id' => 4,
//             'text' => 'Файл 4'
//         ],
//     ]
// ];

?>