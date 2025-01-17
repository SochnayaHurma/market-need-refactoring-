<?php 

namespace app\models\admin;


use app\models\AppModel;
use dopler_core\Cache;
use RedBeanPHP\R;

class Slider extends AppModel
{
    public function getSlides(): array
    {
        return R::getAssoc("SELECT * FROM slider");
    }

    public function updateSlider(array|null $gallery): void
    {
        if (!isset($_POST['gallery'])) {
            R::exec('DELETE FROM slider');
        } 
        if (isset($_POST['gallery']) && is_array($_POST['gallery'])) {
            if (count($gallery) !== count($_POST['gallery'])
            || array_diff($gallery, $_POST['gallery'])
            || array_diff($_POST['gallery'], $gallery)) {
                R::exec('DELETE FROM slider');
                $sql = 'INSERT INTO slider(img) VALUES ';
                foreach ($_POST['gallery'] as $item ) {
                    $sql .= '(?),';
                }
                $sql = rtrim($sql, ',');
                R::exec($sql, $_POST['gallery']);
            }
        }
        $cache = Cache::getInstance();
        $cache->delete('slider');
    }
}

?>