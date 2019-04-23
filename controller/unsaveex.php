<?php
/**
 * Created by PhpStorm.
 * User: White_Rabbit
 * Date: 27.03.2019
 * Time: 11:02
 */

require_once '/model/ExerciseModel.php';

unsave();

function unsave() {

    $request_url = explode('/', $_SERVER['REQUEST_URI']);

    $id_user = $_SESSION['id_user'];
    $id_exercise = $request_url[3];

    $user = new ExerciseModel();

    $result = $user->unsave($id_exercise, $id_user);

    if (!$result){
        $_SESSION['message']='Что-то пошло не так..(';
    }

    header('Location: /exercise/'.$id_exercise);

}
