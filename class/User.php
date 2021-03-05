<?php

/*
 * User Class
 */

class User extends ConnectionDatabase
{
    private $message = [];

    /* Message Set Method */
    public function setMessage($key,$val)
    {
        $this->message[$key] = $val;
    }

    /* Message Get Method */
    public function getMessage()
    {
        return $this->message['msg'];
    }

    /* Add a new account */
    public function addAccount($name, $passwd, $role_id)
    {

        /* Check if the user name is valid */
        $this->validateUsername($name);

        /* Check if the password is valid */
        $this->validatePassword($passwd);

        if($this->checkExistUsername($name) == true)
        {
            /* Сlean data  */
            $name = mysqli_real_escape_string($this->connect(),$name);
            $passwd = mysqli_real_escape_string($this->connect(),$passwd);
            $role = mysqli_real_escape_string($this->connect(),$role_id);

            /* Password hash */
            $password_hash = password_hash($passwd, PASSWORD_DEFAULT);

            /* INSERT query */
            $sql = "INSERT INTO accounts (account_name, account_passwd, account_reg_time, account_enabled, account_role_id) 
            VALUES ('$name','$password_hash', now(), '1', '$role')";

            if($result = mysqli_query($this->connect(), $sql))
            {
                $this->setMessage('msg', '<div class="alert alert-success"> Регистрация прошла успешно. </div>');
            }
            else $this->setMessage('msg', '<div class="alert alert-danger"> Что-то пошло не так. </div>');
        }
    }

    /* A sanitization check for the account username */
    public function validateUsername($name)
    {
        if(empty($name))
        {
            $this->setMessage('msg', '<div class="alert alert-danger"> Имя пользователя не должно быть пустым.</div>');
        } else {
            if(!preg_match('/^[a-zA-Z0-9]{6,12}$/', $name)){
                $this->setMessage('msg', '<div class="alert alert-danger">Имя пользователя должно быть больше 6 символов.</div>');
            }
        }
    }

    /* A sanitization check for the account password */
    public function validatePassword($passwd)
    {
        if(empty($passwd))
        {
            $this->setMessage('msg', '<div class="alert alert-danger"> Пароль не должен быть пустым.</div>');
        } else {
            if(!preg_match('/^(?=.*\d)(?=.*[@#\-_$%^&+=§!\?])(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z@#\-_$%^&+=§!\?]{6,20}$/', $passwd)){
                $this->setMessage('msg', '<div class="alert alert-danger">Пароль должен быть больше 6 символов.</div>');
            }
        }
    }

    /* Check if an account having the same name already exists. */
    public function checkExistUsername($name)
    {
        $username_check_query = mysqli_query($this->connect(),"SELECT * FROM `accounts` WHERE account_name = '$name'");

        $rowCount = mysqli_num_rows($username_check_query);

        if($rowCount > 0)
        {
            $this->setMessage('msg', '<div class="alert alert-danger">Имя пользователя занято. Придумайте другое.</div>');
            return false;
        } else return true;
    }

    /* Login with username and password */
    public function login($name, $passwd)
    {
        /* Сlean data  */
        $name = mysqli_real_escape_string($this->connect(),$name);
        $passwd = mysqli_real_escape_string($this->connect(),$passwd);

        /* Check if the user name is valid */
        $this->validateUsername($name);

        /* Check if the password is valid */
        $this->validatePassword($passwd);

        $username_check_query = mysqli_query($this->connect(),"SELECT * FROM `accounts` WHERE account_name = '$name'");

        $rowCount = mysqli_num_rows($username_check_query);

        if($rowCount <= 0) {
            $this->setMessage('msg', '<div class="alert alert-danger">Учетная запись пользователя не существует.</div>');
        } else {
            /* Fetch user data and store in php session */
            while($row = mysqli_fetch_array($username_check_query)) {
                $id            = $row['account_id'];
                $username      = $row['account_name'];
                $pass_word     = $row['account_passwd'];
                $created       = $row['account_reg_time'];
                $is_active     = $row['account_enabled'];
                $role_id       = $row['account_role_id'];
            }
            // Verify password
            $password = password_verify($passwd, $pass_word);

            if($is_active == '1') {
                if($name == $username && $passwd == $password) {
                    header("Location: ./index.php");

                    $_SESSION['auth'] = TRUE;
                    $_SESSION['id'] = $id;
                    $_SESSION['username'] = $username;
                    $_SESSION['role_id'] = $role_id;
                    $_SESSION['created'] = $created;

                    $this->registerLoginSession();

                } else {
                    $this->setMessage('msg', '<div class="alert alert-danger">Не верное имя пользователя или пароль</div>');
                }
            } else {
                $this->setMessage('msg','<div class="alert alert-danger">Извините, ваша учетная запись деактивирована, свяжитесь с администратором!</div>');
            }
        }
    }

    /* Logout the current user */
    public function logout()
    {
        /* If there is an open Session, remove it from the account_sessions table */
        if (session_status() == PHP_SESSION_ACTIVE)
        {
            $sid = session_id();
            $query = "DELETE FROM account_sessions WHERE (session_id = '$sid')";
            $session_query = mysqli_query($this->connect(), $query);
        }
    }

    /* Select name role from table Roles */
    public function viewRoleName($role_id)
    {
        if($view_role_query = mysqli_query($this->connect(),"SELECT * FROM `roles` WHERE role_id = '$role_id'"))
        {
            while($row = mysqli_fetch_array($view_role_query)) {
                echo $row['role_name'];
            }
        }
    }

    /* Select all roles from table Roles */
    public function selectAllRoles()
    {
        $data = null;
        if($view_users_query = mysqli_query($this->connect(),"SELECT * FROM `roles`"))
        {
            while ($row = mysqli_fetch_assoc($view_users_query)) {
                $data[] = $row;
            }
        }
        return $data;
    }

    /* Select all users from procedure */
    public function selectAllUserData()
    {
        $data = null;
        if($view_users_query = mysqli_query($this->connect(),"CALL proc_select_users()"))
        {
            while ($row = mysqli_fetch_assoc($view_users_query)) {
                $data[] = $row;
            }
        }
        return $data;
    }

    public function viewLastTimeAuth($user_id)
    {
        if($view_role_query = mysqli_query($this->connect(),"SELECT `login_time` FROM `account_sessions` WHERE account_id = '$user_id'"))
        {
            while($row = mysqli_fetch_array($view_role_query)) {
                echo $row['login_time'];
            }
        }
    }

    /* Saves the current Session ID with the account ID */
    private function registerLoginSession()
    {
        /* Check that a Session has been started */
        if (session_status() == PHP_SESSION_ACTIVE)
        {
            $sid = session_id();
            $id = $_SESSION['id'];
            $query = "REPLACE INTO account_sessions (session_id, account_id, login_time) VALUES ('$sid', '$id', now())";
            $session_query = mysqli_query($this->connect(), $query);
        }
    }
}