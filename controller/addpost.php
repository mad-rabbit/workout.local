<?php

require_once '/model/NewsModel.php';

$request_url = explode('/', $_SERVER['REQUEST_URI']);
$new = new NewsModel();
$data = [];

foreach ($_POST as $key => $value) {
    if ($value!=''){
        $data[$key] = $value;
    }
}
$id = $request_url[3];

$new = $new->update($id,$data, 'user_news');

if ($new){
    header('Location: /user' );
} else {
    header("Location: /addpost/".$id );
}
?>