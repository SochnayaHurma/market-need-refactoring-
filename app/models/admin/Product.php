<?php 

namespace app\models\admin;

use dopler_core\App;
use app\models\AppModel;
use RedBeanPHP\R;


class Product extends AppModel
{
    public function getCountProducts()
    {
        return R::count('product');
    }

    public function getProducts(array $lang, int $start_page, int $end_page): array
    {
        return R::getAll("
            SELECT p.*, pd.title
            FROM product AS p
            INNER JOIN product_description AS pd ON p.id = pd.product_id
            WHERE pd.language_id = ?
            LIMIT $start_page, $end_page
        ", [$lang['id']]);
    }

    public function getDownloads(string $q)
    {
        $data = [];
        $downloads = R::getAssoc('
            SELECT download_description.download_id, download_description.name
            FROM download_description
            WHERE name LIKE ?
            LIMIT 10
        ', ["%$q%"]);

        if ($downloads) {
            $count = 0;
            foreach ($downloads as $id => $name) {
                $data['items'][$count]['id'] = $id;
                $data['items'][$count]['text'] = $name;
                $count++;
            }
        }
        return $data;
    }

    public function productValidate(): bool
    {
        $errors = '';
        if (!is_numeric(post('price'))) {
            $errors .= 'Прежняя цена должна быть числовым значением<br>';
        }
        if (!is_numeric(post('old_price'))) {
            $errors .= 'Цена должна быть числовым значением<br>';
        }
        foreach ($_POST['product_description'] as $lang_id => $item) {
            $item['title'] = trim($item['title']);
            $item['exerpt'] = trim($item['exerpt']);
            if (empty($item['title'])) {
                $errors .= "Не заполнено наименование во вкладке $lang_id<br>";
            }
            if (empty($item['exerpt'])) {
                $errors .= "Не заполнено краткое описание во вкладке $lang_id<br>";
            }
        }
        if ($errors) {
            $_SESSION['errors'] = $errors;
            $_SESSION['form_data'] = $_POST;
            return false;
        }
        return true;
    }

    public function saveProduct()
    {
        R::begin();
        try {
            // product
            $product = R::dispense('product');
            $product->category_id = post('category_id', 'int');
            $product->price = post('price', 'f');
            $product->old_price = post('old_price', 'f');
            $product->status = post('status') ? 1 : 0;
            $product->hit = post('hit') ? 1 : 0;
            $product->img = post('img') ?: NO_IMAGE;
            $product->is_download = post('is_download') ? 1 : 0;


            $product_id = R::store($product);
            $product->slug = self::create_slug(
                'product',
                'slug',
                $_POST['product_description'][1]['title'],
                $product_id
            );
            R::store($product);
            // product_description
            foreach ($_POST['product_description'] as $lang => $post_data) {
                R::exec("
                    INSERT INTO product_description
                    (product_id, language_id, title, description, content, keywords, exerpt)
                    VALUES
                    (?, ?, ?, ?, ?, ?, ?)
                ", [
                    $product_id, $lang,
                    $post_data['title'],
                    $post_data['description'],
                    $post_data['content'],
                    $post_data['keywords'],
                    $post_data['exerpt']
                ]);
            }
            // product_gallery 
            if (isset($_POST['gallery']) && is_array($_POST['gallery'])) {
                $sql = "INSERT INTO product_gallery (product_id, img) VALUES ";
                foreach ($_POST['gallery'] as $item) {
                    $sql .= "({$product_id}, ?),";
                }
                $sql = rtrim($sql, ',');
                $gallery = $_POST['gallery'];
                R::exec($sql, $_POST['gallery']);
            }
            // product_download
            if ($product->is_download) {
                $download_id = post('is_download', 'int');
                R::exec(
                    'INSERT INTO product_download(product_id, download_id) VALUES (?, ?)',
                    [$product_id, $download_id]
                );
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

    public function editProduct(int $id)
    {
        R::begin();
        try {
            // product
            $product = R::load('product', $id);
            if (!$product) {
                return false;
            }

            $product->category_id = post('category_id', 'int');
            $product->price = post('price', 'f');
            $product->old_price = post('old_price', 'f');
            $product->status = post('status') ? 1 : 0;
            $product->hit = post('hit') ? 1 : 0;
            $product->img = post('img') ?: NO_IMAGE;
            $product->is_download = post('is_download') ? 1 : 0;


            $product_id = R::store($product);
            $product->slug = self::create_slug(
                'product',
                'slug',
                $_POST['product_description'][1]['title'],
                $product_id
            );
            R::store($product);
            // product_description
            
            foreach ($_POST['product_description'] as $lang => $post_data) {
                R::exec("
                    UPDATE product_description
                    SET title = ?, 
                        description = ?, 
                        content = ?, 
                        keywords = ?, 
                        exerpt = ?
                    WHERE product_id = ? AND language_id = ?
                ", [$post_data['title'],
                    $post_data['description'],
                    $post_data['content'],
                    $post_data['keywords'],
                    $post_data['exerpt'],
                    $id, $lang
                ]);
            }
            // product_gallery 
            if (empty($_POST['gallery'])) {
                R::exec('DELETE FROM product_gallery WHERE product_id = ?', [$id]);
            }
            if (isset($_POST['gallery']) && is_array($_POST['gallery'])) {
                $gallery = static::getProductGallery($id);
                if (count($gallery) != count($_POST['gallery']) 
                    || array_diff($gallery, $_POST['gallery'])) {
                    
                    R::exec('DELETE FROM product_gallery WHERE product_id = ?', [$id]);
                    $sql = 'INSERT INTO product_gallery(product_id, img) VALUES ';
                    foreach ($_POST['gallery'] as $item) {
                        $sql .= "({$product_id}, ?),";
                    }
                    $sql = rtrim($sql, ',');
                    R::exec($sql, $_POST['gallery']);
                }
            }
            // product_download
            $product_download = R::getRow(
                'SELECT product_id, download_id 
                FROM product_download 
                WHERE product_id = ?', [$id]
            );
            // debug($product_download, 1);
            if ($product->is_download) {
                $download_id = post('is_download', 'int');
                if ($product_download && $download_id != $product_download['download_id']) {
                    R::exec(
                        'UPDATE product_download SET download_id = ? WHERE product_id = ?',
                        [$download_id, $product_id]
                    );
                }
                if (!$product_download) {
                    R::exec(
                        'INSERT INTO product_download(product_id, download_id) VALUES (?, ?)',
                        [$product_id, $download_id]
                    );
                }
            } else {
                if ($product_download) {
                    R::exec(
                        'DELETE FROM product_download WHERE product_id = ?',
                        [$id]
                    );
                }
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

    public function getProduct(int $id, int $current_lang): array|false
    {
        $product = R::getAssoc(
            'SELECT pd.language_id, pd.*, p.* 
            FROM product AS p
            INNER JOIN product_description AS pd ON p.id = pd.product_id
            WHERE p.id = ?
            ', [$id]
        );
        if (!$product) return false;
        if ($product[$current_lang]['is_download']) {
            $download_info = self::getProductDownload($id, $current_lang);
            if ($download_info) {
                $product[$current_lang]['download_id'] = $download_info['download_id'];
                $product[$current_lang]['download_name'] = $download_info['name'];
            }
        }
        $product[$current_lang]['gallery'] = self::getProductGallery($id);
        return $product;
        
    }

    public function getProductDownload(int $product_id, int $lang_id): array
    {
        return R::getRow(
            'SELECT pd.download_id, dd.name
            FROM product_download AS pd
            INNER JOIN download_description AS dd USING(download_id)
            WHERE pd.product_id = ? AND dd.language_id = ?', 
            [$product_id, $lang_id]
        );
    }

    public function getProductGallery(int $product_id): array
    {
        return R::getCol(
            'SELECT img
            FROM product_gallery
            WHERE product_id = ?
            ', [$product_id]
        );
    }

}

?>