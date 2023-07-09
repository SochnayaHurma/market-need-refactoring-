<?php 

namespace app\controllers;


use dopler_core\Controller;
use dopler_core\App;
use app\widgets\language\Language;
use app\models\AppModel;


class AppController extends Controller
{
    public function __construct(array $route)
    {
        parent::__construct($route);
        new AppModel();
        App::$app->setProperty('languages', Language::getLanguages());
        App::$app->setProperty(
            'language', 
            Language::getLanguage(App::$app->getProperty('languages'))
        );
    }
}


?>