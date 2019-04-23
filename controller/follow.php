<?php
/**
 * Created by PhpStorm.
 * User: White_Rabbit
 * Date: 26.03.2019
 * Time: 2:26
 */

require_once '/model/UserModel.php';

follow();

function follow() {
    $request_url = explode('/', $_SERVER['REQUEST_URI']);

    $id_main = $_SESSION['id_user'];
    $id_user = $request_url[3];

    $user = new UserModel();

    $result = $user->followUser($id_main, $id_user);

    if (!$result){
        $_SESSION['message']='Что-то пошло не так..(';
    }

    header('Location: /user/'.$id_user);

}
