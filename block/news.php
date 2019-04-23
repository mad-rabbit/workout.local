<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/model/NewsModel.php';

$id= $_SESSION['id_user'];

$news = new NewsModel();

$list = $news->getAll($id);

?>

