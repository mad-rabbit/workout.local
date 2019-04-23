<?php
/**
 * Created by PhpStorm.
 * User: White_Rabbit
 * Date: 27.03.2019
 * Time: 10:03
 */

require_once '/model/ForegroundModel.php';

$request_url = explode('/', $_SERVER['REQUEST_URI']);
$id = $request_url[2];

$competition = new ForegroundModel();

$data = $competition->getForegroundById($id);

?>
