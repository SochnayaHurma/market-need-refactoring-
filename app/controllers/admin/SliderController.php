<?php 

namespace app\controllers\admin;


class SliderController extends AppController
{
    public function indexAction()
    {
        $gallery = $this->model->getSlides();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->model->updateSlider($gallery);
            $_SESSION['success'] = 'Слайдер обновлен';
            redirect();
        }
        $title = 'Слайдер';
        $this->setMeta($title);
        $this->set(compact('gallery'));
    }
}

?>