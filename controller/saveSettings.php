<?php
/**
 * Created by PhpStorm.
 * User: White_Rabbit
 * Date: 26.03.2019
 * Time: 9:32
 */

require_once '/model/UserModel.php';

saveSettings();

function saveSettings() {
    $id = $_SESSION['id_user'];
    $user = new UserModel();
    $data=[];
    $location = "Location: /settings";

    foreach ($_POST as $key => $value) {
        if ($value!=''){
            $data[$key] = $value;
        }
    }

    $checkResult = $user->checkPassword($id, $data['confirm']);

    if ($checkResult){
        if( array_key_exists('login', $data) && $user->checkLogin($id, $data['login'])){
            $_SESSION['message']= 'Данный логин уже занят:(';
        } else {
            if (array_key_exists('password', $data)){
                $passHash = password_hash($data['password'], PASSWORD_BCRYPT, array('cost' => 14));
                $data['password']=$passHash;
            }

            unset($data['confirm']);
            $result = $user->update($id, $data, $user->table);

            if($result) {
                $location = 'Location: /user';
            } else {
                $_SESSION['message']= 'Что-то пошло не так..(';
            }
        }
    } else {
        $_SESSION['message']= 'Неверный пароль!';
    }

    header($location);
}

