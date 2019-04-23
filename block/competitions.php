<?php

require_once '/model/CompetitionsModel.php';

$news = new CompetitionsModel();

$list = $news->getAllCompetitions();

?>

