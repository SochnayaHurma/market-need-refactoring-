<?php

namespace app\controllers\admin;


use dopler_core\App;
use dopler_core\Pagination;


class UserController extends AppController
{
    public function indexAction()
    {
        $page = get('page');
        $perpage = App::$app->getProperty('pagination');
        $total = $this->model->countUsers();
        $pagination = new Pagination($page, $perpage, $total);
        $start_record = $pagination->getStart();

        $users = $this->model->getUsers($start_record, $perpage);
        $title = 'Пользователи';
        $this->set(compact('total', 'users', 'pagination'));
        $this->setMeta($title);
    }

    public function viewAction()
    {
        $user_id = get('id');
        $user = $this->model->getUser($user_id);
        if (!$user) {
            throw new \Exception('Not found user', 404);
        }
        $page = get('page');
        $perpage = App::$app->getProperty('pagination');
        $total = $this->model->get_count_orders($user_id);
        $pagination = new Pagination($page, $perpage, $total);
        $start_record = $pagination->getStart();

        $orders = $this->model->get_user_orders($start_record, $perpage, $user_id);

        $title = 'Профиль пользователя';
        $this->set(compact('pagination', 'total', 'user', 'orders'));
        $this->setMeta($title);
    }

    public function addAction()
    {
        if (!empty($_POST)) {
            $this->model->load();
            if (!$this->model->validate($this->model->attributes) 
                || $this->model->checkUnique('Этот E-mail занят')) {
                $this->model->getErrors();
                $_SESSION['form_data'] = $_POST;
                
            } else {
                $this->model->passwordHash();
                if ($this->model->save('user')) {
                    $_SESSION['success'] = 'Пользователь добавлен';
                } else {
                    $_SESSION['errors'] = 'Ошибка добавления пользователя';
                }
            }
            redirect();
        }
        $title = 'Новый пользователь';
        $this->setMeta($title);
    }

    public function editAction()
    {
        $user_id = get('id');
        $user = $this->model->getUser($user_id);
        if (!$user) {
            throw new \Exception('Not found user', 404);
        }
        if (!empty($_POST)) {
            $this->model->load();
            if (empty($this->model->attributes['password'])) {
                unset($this->model->attributes['password']);
            }
            if (!$this->model->validate($user)) {
                $this->model->getErrors();
            } else {
                if (!empty($this->model->attributes['password'])) {
                    $this->model->passwordHash();
                }
                
                if ($this->model->update('user', $user_id)) {
                    
                    $_SESSION['success'] = 'Данные пользователя обновлены';
                    if ($_SESSION['user']['id'] == $user_id) {
                        unset($this->attributes['password']);
                        foreach ($this->model->attributes as $field => $value) {
                            $_SESSION['user'][$field] = $value;
                        }
                    } 
                } else {
                    $_SESSION['errors'] = '<hr>Ошибка обновления профиля';
                }
            }
            redirect();
        }
        $title = 'Редактирование пользователя';
        $this->setMeta($title);
        $this->set(compact('user'));

    }

    public function loginAdminAction()
    {
        if ($this->model::isAdmin()) {
            redirect(ADMIN);
        }
        $this->layout = 'login';

        if (!empty($_POST)) {
            if ($this->model->login(true)) {
                $_SESSION['success'] = 'Вы успешно авторизованы';
                redirect(ADMIN);
            } else {
                $_SESSION['errors'] = 'Логин/пароль введены неверно';
                redirect();
            }
        }
    }

    public function logoutAction()
    {
        if ($this->model->isAdmin()) {
            unset($_SESSION['user']);
            redirect(ADMIN.'/user/login-admin/');
        }
    }
}

?>