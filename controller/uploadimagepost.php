<?php
/**
 * Created by PhpStorm.
 * User: White_Rabbit
 * Date: 27.03.2019
 * Time: 12:31
 */

require_once '/model/NewsModel.php';

$target_dir = "./media/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check == false) {
        $_SESSION['message']= "Файл - не изображение.";
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    $_SESSION['message']= "Файл уже существует:)";
    $uploadOk = 0;
}
// Check file size
/*if ($_FILES["fileToUpload"]["size"] > 500000) {
    $_SESSION['message']= "Sorry, your file is too large.";
    $uploadOk = 0;
}*/
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
    $_SESSION['message']= "Допустимы файлы форматов: JPG, JPEG, PNG и GIF.";
    $uploadOk = 0;
}

if($uploadOk!=0) {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        $new = new NewsModel();
        $target_file = substr($target_file,1);
        $id_post = $new->setImage($_SESSION['id_user'], $target_file);
        if($id_post){
            $_SESSION['message']= "Файл ". basename( $_FILES["fileToUpload"]["name"]). " был загружен.";
        }
    } else {
        $_SESSION['message']= "Что-то пошло не так:(";
    }
}

$location = "Location: /addpost/".$id_post;
header($location);

?>