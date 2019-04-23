<?php
/**
 * Created by PhpStorm.
 * User: White_Rabbit
 * Date: 27.03.2019
 * Time: 14:17
 */

$_SESSION['is_logged']=0;
unset ($_SESSION['id_user'], $_SESSION);

header('Location: /login' );
?>