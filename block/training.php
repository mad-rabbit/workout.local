<?php
/**
 * Created by PhpStorm.
 * User: White_Rabbit
 * Date: 27.03.2019
 * Time: 10:35
 */

$request_url = explode('/', $_SERVER['REQUEST_URI']);

$titles = [
    '/list/exercise/2'=>[
        'link'=>'/list/exercise/2',
        'title'=>'Статические элементы'
    ],
    '/list/exercise/3'=>[
        'link'=>'/list/exercise/3',
        'title'=>'Динамические элементы'
    ],
    '/list/exercise/5'=>[
        'link'=>'/list/exercise/5',
        'title'=>'Парные элементы'
    ],
    '/list/exercise/1'=>[
        'link'=>'/list/exercise/1',
        'title'=>'Базовые упражнения'
    ],
    '/list/exercise/4'=>[
        'link'=>'/list/exercise/4',
        'title'=>'Кардио упражнения'
    ],
    '/list/workout'=>[
        'link'=>'/list/workout',
        'title'=>'Тренировки'
    ],
    '/list/combo'=>[
        'link'=>'/list/combo',
        'title'=>'Связки из элементов'
    ],
];

if (array_key_exists(2, $request_url)){
    foreach ($titles as $key=>$value) {
        $titles[$key] = [
            'link' => $value['link'].'/1',
            'title'=> '*'.$value['title'].'*'
        ];
    }
}

?>