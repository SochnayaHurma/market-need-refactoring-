<?php 

namespace app\models\admin;


use app\models\User as DefaultUser;

class User extends DefaultUser
{
    public static function isAdmin(): bool
    {
        return (isset($_SESSION['user']) && $_SESSION['user']['role'] == 'admin');
    }
}

?>