<?php 

namespace app\controllers;

use RedBeanPHP\R;
use dopler_core\Controller;

class MainController extends Controller
{
    public function indexAction()
    {
        $names = $this->model->get_names();

        $this->setMeta('Главная страница', 'Description', 'keywords..');
        $this->set(compact('names'));
    }
}
?>