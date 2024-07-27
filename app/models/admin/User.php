<?php 

namespace app\models\admin;


use RedBeanPHP\R;


use app\models\User as DefaultUser;

class User extends DefaultUser
{
    public array $attributes = [
        'email' => '',
        'password' => '',
        'name' => '',
        'address' => '',
        'role' => ''
    ];
    public array $rules = [
        'required' => ['email', 'password', 'name', 'address', 'role'],
        'email' => ['email',],
        'lengthMin' => [
            ['password', 6],
        ],
        'optional' => ['password']
    ];
    public array $labels = [
        'email' => 'E-mail',
        'password' => 'Пароль',
        'name' => 'Имя',
        'address' => 'Адрес',
        'role' => 'Роль'
    ];

    public static function isAdmin(): bool
    {
        return (isset($_SESSION['user']) && $_SESSION['user']['role'] == 'admin');
    }

    public function countUsers(): int
    {
        return R::count('user');
    }

    public function getUsers(int $skip, int $limit): array
    {
        return R::getAll("SELECT * FROM `user` LIMIT {$skip}, {$limit}");
    }

    public function getUser(int $id): array
    {
        return R::getRow('SELECT * FROM user WHERE id = ?', [$id]);
    }

    public function checkEmail($user_data): bool
    {
        if ($user_data['email'] == $this->attributes['email']) {
            return true;  
        }
        $user = R::findOne('user', 'email = ?', [$this->attributes['email']]);
        if ($user) {
            $this->errors['unique'][] = 'Этот email уже используется';
            return false;
        }
        return true;
    }

    public function validate(array|string|null $data, bool $is_create = false): bool
    {
        if ($is_create) {
            return parent::validate($this->attributes);
        }
        if (parent::validate($this->attributes) && $this->checkEmail($data)) {
            return true;
        }
        return false;
    }
}

?>