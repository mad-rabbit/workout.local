<?php

require_once '/model/UserModel.php';

login();

function login()
{
    $email = $_POST['email'];
    $password = $_POST['password'];

    $user = new UserModel();
    $data = $user->getLoginData($email);
    if ($data && (password_verify($password, $data['password']))
        /*($password == $data['password'])*//*password_verify($password, $data['password'])*/)
    {
        $_SESSION['is_logged'] = 1;
        $_SESSION['id_user'] = $data['id'];
        header('Location: /training');
    } else{
        $_SESSION['is_logged'] = 0;
        $_SESSION['message'] = "Проверьте введенные данные:(";
        header('Location: /login' );
    }
}
