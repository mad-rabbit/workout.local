<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/model/InventoryModel.php';

$request_url = explode('/', $_SERVER['REQUEST_URI']);
$id = $request_url[2];

$exercise = new InventoryModel();

$data = $exercise->getInventoryInfo($id);

?>
