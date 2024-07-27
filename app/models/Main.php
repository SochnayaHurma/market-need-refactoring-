<?php 

namespace app\models;


use RedBeanPHP\R; 
use app\models\AppModel;
use dopler_core\Cache;

class Main extends AppModel
{
    public function get_hits(string $lang, int $limit): array
    {
        return R::getAll("
        SELECT `p`.*, `pd`.* 
        FROM `product` as p 
        JOIN `product_description` as `pd` on `p`.`id` = `pd`.`product_id`
        WHERE `p`.`status` = 1 AND `p`.`hit` = 1 AND `pd`.`language_id` = ?
        limit {$limit} 
        ", [$lang]);
    }

    public function get_slider()
    {
        $cache = Cache::getInstance();
        if ($data = $cache->get('slider')) {
            return $data;
        } else {
            $slider = R::findAll('slider');
            $cache->set('slider', $slider);
            return $slider;
        }
    }
}

?>