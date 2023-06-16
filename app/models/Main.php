<?php 

namespace app\models;


use RedBeanPHP\R; 

class Main extends \dopler_core\Model
{
    public function get_names(): array
    {
        return R::findAll('name');
    }
}

?>