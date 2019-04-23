<?php
/**
 * Created by PhpStorm.
 * User: White_Rabbit
 * Date: 27.03.2019
 * Time: 14:32
 */

//require_once $_SERVER['DOCUMENT_ROOT'].'/base/Db.php';
$request_url = explode('/', $_SERVER['REQUEST_URI']);
$requestPage = $request_url[3];

$table = $requestPage;

switch ($requestPage){
    case 'exercise' :
        $type = $request_url[4];
        $query = 'Select id, title, image from exercise where id_exercise_type = '.$type.' and title like "%'.$_POST['search'].'%"';

        $check_hard_level = 1;
        break;

    case 'combo' :
        $query = 'Select id, title, image from combo where title like "%'.$_POST['search'].'%"';
        $check_hard_level = 1;

        break;

    case 'workout' :
        $query = 'Select id, title, image from workout where title like "%'.$_POST['search'].'%"';
        $check_hard_level = 1;
        break;

    case 'user' :
        $add=0;
        $query = 'Select id, login as title, image from users where login like "%'.$_POST['search'].'%"';
        break;

    case 'inventory' :
        $add=0;
        $query = 'Select id, title, image from inventory where title like "%'.$_POST['search'].'%"';
        break;

    case 'muscles' :
        $add=0;
        $query = 'Select id, title, image from muscles where title like "%'.$_POST['search'].'%"';
        break;

    case 'foreground' :
        $add=0;
        $query = 'Select id, CONCAT(title,\' (\', address,\', \', id_town,\')\') as title, image from address 
where is_foreground = 1 and title like "%'.$_POST['search'].'%" order by id_town';
        break;
}

$_SESSION['search']= $query;

header('Location: /list/search/'.$requestPage );
