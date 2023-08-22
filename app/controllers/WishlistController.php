<?php 

namespace app\controllers;

use dopler_core\App;


class WishlistController extends AppController
{
    public function addAction()
    {
        $id = get('id', 'int');
        if (!$id) {
            $answer = ['result' => 'error', 'text' => ___('tpl_wishlist_add_error')];
            exit(json_encode($answer));
        }
        if ($product = $this->model->get_product($id)) {
            $this->model->add_to_wishlist($id);
            $answer = ['result' => ___('tpl_success'), 'text' => ___('tpl_wishlist_add_success')];
        } else {
            $answer = ['result' => ___('tpl_error'), 'text' => ___('tpl_wishlist_add_error')];
        }
        exit(json_encode($answer));
    }
}

?>