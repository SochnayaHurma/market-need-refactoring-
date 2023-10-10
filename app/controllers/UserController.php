<?php 

namespace app\controllers;


use app\models\User;
use dopler_core\App;
use dopler_core\Pagination;

class UserController extends AppController
{
    public function signupAction()
    {
        if (User::checkAuth()) {
            redirect(baseUrl());
        }
        if (!empty($_POST)){
            $this->model->load();
            if ($this->model->checkUnique() || !$this->model->validate($this->model->attributes)) {
                $this->model->getErrors();
                $_SESSION['form_data'] = $this->model->attributes;
            } else {
                $this->model->passwordHash();
                if ($this->model->save('user')) {
                    $_SESSION['success'] = ___('user_signup_success_register');
                } else {
                    $_SESSION['errors'] = ___('user_signup_error_register');
                }
                redirect();

            }
        }
        $this->setMeta(___('tpl_signup'));
    }

    public function loginAction()
    {
        if (User::checkAuth()) {
            redirect();
        }

        if (!empty($_POST)) {
            if ($this->model->login()) {
                $_SESSION['success'] = ___('user_login_success_login');
                redirect(baseUrl());
            }else {
                $_SESSION['errors'] = ___('user_login_error_login');
            }
        } 
            
        $this->setMeta(___('tpl_login'));
    }

    public function logoutAction()
    {
        if (User::checkAuth()) {
            unset($_SESSION['user']);
        }
        redirect(baseUrl(), 'user/login/');
    }

    public function cabinetAction()
    {
        if (!User::checkAuth()) {
            redirect(baseUrl(), 'user/login');
        }
        $this->setMeta(___('tpl_cabinet'));
    }

    public function orderAction()
    {
        if (!User::checkAuth()) {
            redirect(baseUrl(), 'user/login');
        }
        $id = get('id');
        $order = $this->model->get_user_order($id);
        if (!$order) {
            throw new \Exception(___('tpl_not_found_order'), 404);
        }
        $this->setMeta(___('user_order_title'));
        $this->set(compact('order'));
    }

    public function ordersAction()
    {
        if (!User::checkAuth()) {
            redirect(baseUrl(), 'user/login');
        }
        $page = get('page');
        $perpage = App::$app->getProperty('pagination');
        $total = $this->model->get_count_orders($_SESSION['user']['id']);
        $pagination = new Pagination($page, $perpage, $total);
        $start = $pagination->getStart();
        $orders = $this->model->get_user_orders($start, $perpage, $_SESSION['user']['id']);

        $this->setMeta(___('user_orders_title'));
        $this->set(compact('orders', 'pagination', 'total'));
    }

    public function filesAction()
    {
        if (!User::checkAuth()) {
            redirect(baseUrl(), 'user/login');
        }
        $lang = App::$app->getProperty('language');
        $page = get('page');
        $total = $this->model->get_count_files();
        $perpage = App::$app->getProperty('pagination');
        $pagination = new Pagination($page, $perpage, $total);
        $files = $this->model->get_user_files($pagination->getStart(), $perpage, $lang["id"]);
        $this->setMeta(___('user_files_title'));
        $this->set(compact('pagination', 'files', 'total'));
    }

    public function downloadAction()
    {
        if(!User::checkAuth()) {
            redirect(baseUrl(), 'user/login');
        }
        $id = get('id');
        $lang = App::$app->getProperty('language');
        $file = $this->model->get_user_file($id, $lang['id']);
        if ($file){
            $path = WWW . "/download/{$file['filename']}";
            // debug(['path' => $path, $file], 1);

            if (file_exists($path)) {
                header('Content-Length: ' . filesize($path));
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename="'.basename($file['original_name']).'"');
                header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
                header('Pragma: public');
                header('Expires: 0');
                readfile($path);
                exit();
            } else {
                $_SESSION['errors'] = ___('user_download_error');
            }
        }
        redirect();
    }

    public function credentialsAction()
    {
        if (!User::checkAuth()) {
            redirect(baseUrl(), 'user/login');
        }
        if (!empty($_POST)) {
            $this->model->load();
            if ($this->model->attributes['password']) {
                unset($this->model->attributes['password']);
            }
            unset($this->model->attributes['email']);
            if (!$this->model->validate($_POST)) {
                $this->model->getErrors();
            } else {
                if (!empty($this->model->attributes['password'])) {
                    $this->model->passwordHash();
                }
                if ($this->model->update('user', $_SESSION['user']['id'])) {
                    $_SESSION['success'] = ___('user_credentials_success');
                    foreach($this->model->attributes as $k => $v) {
                        if ($k != 'password' && !empty($v)) {
                            $_SESSION['user'][$k] = $v;
                        }
                    }
                } else {
                    $_SESSION['errors'] = ___('user_credentials_error');
                }
            }
            redirect();
        }
        $this->setMeta(___('user_credentials_title'));

    }
}
?>