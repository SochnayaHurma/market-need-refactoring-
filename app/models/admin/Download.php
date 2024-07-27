<?php 


namespace app\models\admin;


use app\models\AppModel;
use RedBeanPHP\R;


class Download extends AppModel
{
    public function getListDownloads(int $lang_id, int $offset, int $limit): array
    {
        return R::getAll(
            'SELECT d.*, dd.* 
            FROM download AS d
            INNER JOIN download_description AS dd ON d.id = dd.download_id
            WHERE dd.language_id = ?
            LIMIT ?, ?', [$lang_id, $offset, $limit]
        );
    }

    public function getCountDownloads(): int
    {
        return R::count('download');
    }

    public function getCountOrderIsDownload(int $id): int
    {
        return R::count('order_download', 'download_id = ?', [$id]);
    }

    public function getCountProductIsDownload(int $id): int
    {
        return R::count('product_download', 'download_id = ?', [$id]);
    }

    public function downloadValidate(): bool
    {
        $errors = '';
        foreach ($_POST['download_description'] as $lang_id => $item) {
            $item['name'] = trim($item['name']);

            if (empty($item['name'])) {
                $errors .= 'Не заполнено наименование '.$lang_id.'<br>';
            }
        }
        if (empty($_FILES) || $_FILES['file']['error']) {
            $errors .= 'Ошибка загрузки файла<br>';
        } else {
            $extensions = ['jpg', 'jpeg', 'png', 'zip', 'txt', 'pdf'];
            $parts = explode('.', $_FILES['file']['name']);
            $ext = end($parts);
            if (!in_array($ext, $extensions)) {
                $errors .= 'Не допустимое для загрузки расширение';
            }
            if ($errors) {
                $_SESSION['errors'] = $errors;
                return false;
            }
        }
        return true;
    }

    public function uploadFile(): array|false
    {
        $file_name = $_FILES['file']['name'] . uniqid();
        $path = WWW . '/download/' . $file_name;
        if (move_uploaded_file($_FILES['file']['tmp_name'], $path)) {
            return [
                'original_name' => $_FILES['file']['name'],
                'file_name' => $file_name
            ];
        }
        return false;
    }

    public function saveDownload(array $data): bool
    {
        R::begin();
        try {
            $download = R::dispense('download');
            $download->filename = $data['file_name'];
            $download->original_name = $data['original_name'];
            $download_id = R::store($download);
            $sql = 'INSERT INTO download_description(`download_id`, `language_id`, `name`) VALUES ';
            $data_to_sql = [];
            foreach ($_POST['download_description'] as $lang_id => $item) {
                $sql .= '(?, ?, ?),';
                $data_to_sql[] = $download_id;
                $data_to_sql[] = $lang_id;
                $data_to_sql[] = $item['name'];
            }
            $sql = rtrim($sql, ',');
            R::exec($sql, $data_to_sql);
            R::commit();
            return true;
        } catch (\Exception $e) {
            R::rollback();
            return false;
        } 
    }

    public function deleteDownload(int $id): bool
    {
        if (self::_deleteDownloadDb($id)) {
            if (self::_deleteDownloadLocal($id)) {
                return true;
            }
        } 
        return false;
    }

    protected function _deleteDownloadDb(int $id): bool
    {
        R::begin();
        try {
            R::exec('DELETE FROM download_description WHERE download_id = ?', [$id]);
            R::exec('DELETE FROM download WHERE id = ?', [$id]);
            R::commit();
            return true;
        } catch (\Exception $e) {
            debug($e, 1);
            R::rollback();
            return false;
        }

    }

    protected function _deleteDownloadLocal(int $id): bool
    {
        $file_name = R::getCell('SELECT filename FROM download WHERE id = ?', [$id]);
        $file_path = WWW . "/downloads/{$file_name}";
        if (file_exists($file_path)) {
            return unlink($file_path);
        } else {
            return false;
        }
    }

}
?>