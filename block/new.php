<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/model/NewsModel.php';

$request_url = explode('/', $_SERVER['REQUEST_URI']);
$id = $request_url[2];

$news = new NewsModel();

$new = $news->getNewById($id);

?>

