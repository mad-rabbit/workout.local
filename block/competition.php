<?php
/**
 * Created by PhpStorm.
 * User: White_Rabbit
 * Date: 27.03.2019
 * Time: 10:03
 */

require_once '/model/CompetitionsModel.php';

$request_url = explode('/', $_SERVER['REQUEST_URI']);
$id = $request_url[2];

$competition = new CompetitionsModel();

$data = $competition->getCompetitionById($id);


?>
