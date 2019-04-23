<?php

require_once '/model/UserModel.php';

registration();

function registration(){
    $user = new UserModel();
    $data=[];

    foreach ($_POST as $key => $value) {
        if ($value!=''){
            $data[$key] = $value;
        }
    }

    $checkResult = $user->checkUser($data);

    if (!$checkResult){
        if ($data['password'] === $data['confirm']){
            $passHash = password_hash($data['password'], PASSWORD_BCRYPT, array('cost' => 14));
            $data['password']=$passHash;
            unset($data['confirm']);

            $id = $user->register($data);
            if ($id!=0){
                $_SESSION['is_logged'] = 1;
                $_SESSION['id_user'] = $id;
                header('Location: /training');
            } else {
                $_SESSION['message']= 'Что-то пошло не так:(';
                header('Location: registration' );
            }
        } else {
            $_SESSION['message']= 'Проверьте пароль.';
            header('Location: registration' );
        }
    } else {
        $_SESSION['message']= $checkResult;
        header('Location: registration' );
    }
}

