<?php 

namespace app\models\admin;


use app\models\AppModel;
use dopler_core\App;
use dopler_core\Cache;
use RedBeanPHP\R;


class Page extends AppModel
{
    public function countPages()
    {
        return R::count('page');
    }

    public function getPage(int $id): array
    {
        return R::getAssoc('SELECT pd.language_id, pd.*, p.* 
            FROM page AS p
            INNER JOIN page_description AS pd ON pd.page_id = p.id
            WHERE p.id = ?', [$id]);
    }

    public function getPages(array $lang, int $offset, int $limit): array
    {
        return R::getAll('
            SELECT p.*, pd.title 
            FROM `page` AS p
            INNER JOIN page_description AS pd ON p.id = pd.page_id
            WHERE pd.language_id = ?
            LIMIT ?, ?', [$lang['id'], $offset, $limit]);
    }

    public function deletePage(int $id, bool $clear_cache): bool
    {
        $langs = App::$app->getProperty('languages');
        $cache = Cache::getInstance();
        R::begin();
        try {
            $page = R::load('page', $id);

            if (!$page) {
                return false;
            } 
            R::trash($page);
            R::exec('DELETE FROM page_description WHERE page_id = ?', [$id]);
            R::commit();
            if ($clear_cache) {
                foreach ($langs as $lang_id => $item) {
    
                    $cache->delete("dopler_page_menu_{$lang_id}");
                }
            }
            return true;
        } catch (\Exception $e) {
            R::rollback();
            return false;
        }

    }

    public function pageValidate(): bool
    {
        $errors = '';

        foreach ($_POST['page_description'] as $lang_id => $item) {
            $item['title'] = trim($item['title']);
            $item['content'] = trim($item['content']);
            if (empty($item['title'])) {
                $errors .= 'Не заполнено наименование во вкладке ' . $lang_id . '<br>';
            }
            if (empty($item['content'])) {
                $errors .= 'Не заполнен контент во вкладке ' . $lang_id . '<br>';
            }

            if ($errors) {
                $_SESSION['errors'] = $errors;
                $_SESSION['form_data'] = $_POST;
                return false;
            }
        }
        return true;
    }

    public function savePage(): bool
    {
        $language_id = App::$app->getProperty('language')['id'];
        R::begin();
        try {
            // page
            $page = R::dispense('page');
            $page_id = R::store($page);
            $page->slug = AppModel::create_slug(
                'page', 'slug', $_POST['page_description'][$language_id]['title'], $page_id);
            R::store($page);
            // page_description
            foreach ($_POST['page_description'] as $lang_id => $item) {
                R::exec('
                    INSERT INTO page_description
                        (page_id, language_id, title, content, keywords, description)
                    VALUES (?, ?, ?, ?, ?, ?)
                ', [$page_id, $lang_id, 
                    $item['title'], $item['content'], 
                    $item['keywords'], $item['description']]);
            }
            R::commit();
            return true;
        } catch (\Exception $e) {
            R::rollback();
            debug($e, 1);
            return false;
        }
    }

    public function updatePage(int $id): bool
    {
        $language_id = App::$app->getProperty('language')['id'];
        R::begin();
        try {
            // page_description
            foreach ($_POST['page_description'] as $lang_id => $item) {
                R::exec('
                    UPDATE page_description 
                    SET title = ?, content = ?, keywords = ?, description = ?
                    WHERE page_id = ? AND language_id = ?
                ', [$item['title'], $item['content'], 
                    $item['keywords'], $item['description'],
                    $id, $lang_id]);
            }
            R::commit();
            return true;
        } catch (\Exception $e) {
            R::rollback();
            debug($e, 1);
            return false;
        }
    }
}


?>