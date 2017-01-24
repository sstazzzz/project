<?php
require_once('module.php');
class CAuthUser
{
    public function authorization($login, $password)
    {
        $error = '';
        if (!$login) {
                $error = 'Не указан логин';
                return $error;
        } elseif (!$password) {
            $error = 'Не указан пароль';
            return $error;
        }

        $login = htmlspecialchars($login);
        $password = htmlspecialchars($password);

        $connection = new CConnectDataBase();
        $connection = $connection->Connection;

        $password = $this->hashPassword($password);
        $sql = "SELECT id ,password AS hash FROM `users` WHERE `login`='" . $login . "' AND `password`='" . $password . "'";
        $query = mysqli_query($connection, $sql);

        if (mysqli_num_rows($query) === 1)
        {
            $isAuth = 1;
            return true;
        }
        
        mysqli_close($connection);
    }

    public function confirmPassword($hash, $password)
    {
        return crypt($password, $hash) === $hash;
    }
 
    public function hashPassword($password)
    {
      $salt = "6c7dafw4b3456";
      $encoded = hash("sha256", $password.$salt);
      return $encoded;
    }

    public function registration($login, $password)
    {
        $error = '';
        if (!$login) 
        {
            $error = 'Не указан логин';
            return $error;
        } 
        elseif (!$password) 
        {
            $error = 'Не указан пароль';
            return $error;
        }
        $login = htmlspecialchars($login);
        $password = htmlspecialchars($password);

        $password = $this->hashPassword($password);
        $connection = new CConnectDataBase();
        $connection = $connection->Connection;

        $sql = "SELECT `id` FROM `users` WHERE `login`='" . $login . "'";
        $query = mysqli_query($connection, $sql);

        if (mysqli_num_rows($query) > 0) 
        {
            $error = 'Пользователь с указанным логином уже зарегистрирован';
            return $error;
        }
        $sql = "INSERT INTO `users` 
        (`id`,`login`,`password`) VALUES 
        (NULL, '" . $login . "','" . $password . "')";

        mysqli_query($connection, $sql);
        error_log('success registration');
        mysqli_close($connection);
        return true;
    }
}
?>