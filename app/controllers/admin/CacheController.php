<?php 

namespace app\controllers\admin;


use dopler_core\App;
use dopler_core\Cache;

class CacheController extends AppController
{
    public function indexAction()
    {
        $title = 'Управление кэшем';
        $this->setMeta($title);
    }

    public function deleteAction()
    {
        $langs = App::$app->getProperty('languages');
        $cache_key = get('cache', 'string');
        $cache = Cache::getInstance();
        if ($cache_key == 'category' || $cache_key == 'all') {

            foreach ($langs as $lang_id => $item ) {
                $cache->delete("categories_{$lang_id}");
                $cache->delete("dopler_menu_{$lang_id}");
            }
        }
        if ($cache_key == 'page' || $cache_key == 'all') {
            foreach ($langs as $lang_id => $item) {

                $cache->delete("dopler_page_menu_{$lang_id}");
            }
        }

        if ($cache_key == 'slider' || $cache_key == 'all') {
            $cache->delete("slider");
        }

        $_SESSION['success'] = 'Выбраный кэш удален';
        
        redirect();
    }
}

?>