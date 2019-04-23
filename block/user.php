<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/model/UserModel.php';

$request_url = explode('/', $_SERVER['REQUEST_URI']);
$id = 0;
$isMainUser = 0;
$id_main = $_SESSION['id_user'];


if (array_key_exists(2,$request_url)){
    $id = $request_url[2];
} else {
    $id = $id_main;
    $isMainUser = 1;
}

$user = new UserModel();

$data = $user->getUserInfo($id, $isMainUser, $id_main);


?>