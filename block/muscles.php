<?php
/**
 * Created by PhpStorm.
 * User: White_Rabbit
 * Date: 26.03.2019
 * Time: 1:27
 */

require_once $_SERVER['DOCUMENT_ROOT'].'/model/MusclesModel.php';

$request_url = explode('/', $_SERVER['REQUEST_URI']);
$id = $request_url[2];

$exercise = new MusclesModel();

$data = $exercise->getMuscleInfo($id);

?>