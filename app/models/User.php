<?php 

namespace app\models;


use RedBeanPHP\R;

class User extends AppModel
{
    private string $table_name = 'user';
    public array $attributes = [
        'email' => '',
        'password' => '',
        'name' => '',
        'address' => '',
    ];

    public array $rules = [
        'required' => ['email', 'password', 'name', 'address'],
        'email' => ['email',],
        'lengthMin' => [['password', 6]],
        'lengthMax' => [['email', 25], ['password', 20]],
        'optional' => ['email', 'password'],
    ];

    public array $labels = [
        'email' => 'tpl_signup_email_input',
        'password' => 'tpl_signup_password_input',
        'name' => 'tpl_signup_name_input',
        'address' => 'tpl_signup_address_input'
    ];

    public static function checkAuth(): bool
    {
        return isset($_SESSION['user']);
    }

    public function passwordHash()
    {
        $this->attributes['password'] = password_hash($this->attributes['password'], PASSWORD_DEFAULT);
    }

    public function checkUnique(string $error_message = ''): bool
    {
        $user_exist = (bool)R::findOne($this->table_name, "email = ?", [$this->attributes['email']]);
        if ($user_exist) {
            $this->errors['unique'][] = ___('user_signup_error_email_unique');
        }
        return $user_exist;
    }

    public function login($is_admin = false): bool
    {
        $email = post('email');
        $password = post('password');

        if ($email && $password) {
            if ($is_admin) {
                $user = R::findOne('user', "email = ? AND role = 'admin'", [$email]);
            } else {
                $user = R::findOne('user', "email = ?", [$email]);
            }
            if ($user && password_verify($password, $user->password)) {
                unset($user->password); 
                foreach ($user as $field => $value) {
                    $_SESSION['user'][$field] = $value;
                }
                return true;
            }   
        }
        return false;
    }
    public function get_user_order(int $order_id): array
    {
        return R::getAll("SELECT orders.*, order_product.* 
                          FROM orders 
                          INNER JOIN order_product ON orders.id = order_product.order_id
                          WHERE order_product.order_id = ?", [$order_id]);
    }

    public function get_count_orders(int $user_id): int
    {
        return R::count('orders', 'user_id = ?', [$user_id]);
    }

    public function get_user_orders(int $offset, int $perpage, int $user_id): array
    {
        return R::getAll("SELECT id, user_id, status, note, created_at, updated_at, total, qty
                          FROM orders
                          WHERE user_id = ?
                          ORDER BY id DESC
                          LIMIT $offset, $perpage", [$user_id]);
    }

    public function get_count_files()
    {
        return R::count('order_download', 'user_id = ?', [$_SESSION['user']['id']]);
    }

    public function get_user_files(int $start, int $perpage, int $lang)
    {
        return R::getAll("SELECT o.*, d.*, dd.* 
                          FROM order_download AS o
                          INNER JOIN download AS d ON o.download_id = d.id
                          INNER JOIN download_description AS dd ON o.download_id = dd.download_id
                          WHERE user_id = ? AND language_id = ?
                          LIMIT $start,$perpage", [$_SESSION["user"]["id"], $lang]);
    }

    public function get_user_file(int $id, int $lang)
    {
        return R::getRow('SELECT od.*, d.*, dd.* 
                          FROM order_download AS od
                          INNER JOIN download AS d ON d.id = od.download_id
                          INNER JOIN download_description AS dd ON dd.download_id = d.id
                          WHERE od.user_id = ? AND d.id = ? AND dd.language_id = ?', 
                          [$_SESSION["user"]["id"], $id, $lang]);
    }
}


?>