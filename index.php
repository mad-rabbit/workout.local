<?php

if (empty($_SESSION)){
    session_start();
}


$request = $_SERVER['REDIRECT_URL'];
$request_url = explode('/', $_SERVER['REQUEST_URI']);

if(!empty($request_url) && array_key_exists(1,$request_url)){
    if ($request_url[1] == 'controller'){
        $resultUrl = __DIR__ . '/controller/'.$request_url[2].'.php';
    } else {
        $path = __DIR__ . '/views/';

        if ( ($request!='/login' && $request!='/registration') &&
            (!array_key_exists('is_logged',$_SESSION) || ($_SESSION['is_logged'] == 0)) ){
            $request = '/login.phtml';
        } elseif ($request!='' && $request!="/") {
            $request =$request_url[1].'.phtml';
        } else {
            $request = 'training.phtml';
        }

        $resultUrl = $path.$request;
    }
}

if (file_exists($resultUrl)) {
    require_once $resultUrl;
} else {
    require_once __DIR__ .'/views/404.phtml';
}



