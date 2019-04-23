<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/model/ExerciseModel.php';

$request_url = explode('/', $_SERVER['REQUEST_URI']);
$id = $request_url[3];

$exercise = new ExerciseModel();

$data = $exercise->getExerciseInfo($id);

?>
