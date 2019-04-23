<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/model/NewsModel.php';

$request_url = explode('/', $_SERVER['REQUEST_URI']);
$image=false;
$id=false;

if (array_key_exists(2,$request_url)){
    $id = $request_url[2];

    $news = new NewsModel();

    $image = $news->getImage($id);

}

?>
