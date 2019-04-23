<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/base/Db.php';
    $request_url = explode('/', $_SERVER['REQUEST_URI']);
    $requestPage = $request_url[2];
    $add =true;
    $is_search = false;

    $check_hard_level = 0;
    $query = '';

    switch ($requestPage){
        case 'exercise' :
            $type = $request_url[3];
            if (!array_key_exists(4,$request_url)){ //check if is saved values
                $query = 'Select id, title,  image from exercise where id_exercise_type = '.$type;
                $requestPage.='/'.$type;
            } else {
                $query = 'Select id, title,  image 
                          from exercise inner join user_exercise_save on (exercise.id = id_exercise) 
                          where id_exercise_type = '.$type.' and user_exercise_save.id_user = '.$_SESSION['id_user'];
            }

            $check_hard_level = 1;
        break;

        case 'combo' :
            $query = 'Select id, title, image from combo';
            $check_hard_level = 1;

        break;

        case 'workout' :
            $query = 'Select id, title, image from workout';
            $check_hard_level = 1;
        break;

        case 'user' :
            $add = false;
            $query = 'Select id, login as title, image from users';
        break;

        case 'inventory' :
            $add = false;
            $query = 'Select id, title, image from inventory';
        break;

        case 'muscles' :
            $add = false;
            $query = 'Select id, title, image from muscles';
        break;

        case 'foreground' :
            $add = false;
            $query = 'Select id, CONCAT(title,\' (\', address,\', \', id_town,\')\') as title, image from address where is_foreground = 1 order by id_town';
        break;

        case 'search' :
            $add = false;
            $query = $_SESSION['search'];
            unset ($_SESSION['search'], $_SESSION);
            break;
    }

    if($requestPage == 'search'){
        $is_search = true;
        $requestPage = $request_url[3];
    }

    $db = new Db();
    $list = false;

    if (!empty($query)){
        $list = $db->query($query);
    }

?>

