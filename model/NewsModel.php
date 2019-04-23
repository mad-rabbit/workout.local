<?php

require_once '/base/Db.php';

class NewsModel extends Db
{
    var $table = 'user_news';

    public function construct(){}

    public function getAll($id)
    {
        $query = 'select user_news.* , login, users.image as u_image 
from user_news inner join users on (user_news.id_user = users.id) 
where user_news.id_user in (select user_subscribe.id_user from user_subscribe where id_follower ='.$id.') order by date_time desc limit 25 ';

        $result = $this->query($query);
        return $result;
    }

    public function getNewById($id)
    {
        $query = 'select user_news.*, login, users.image as u_image 
from user_news inner join users on (user_news.id_user = users.id) 
where user_news.id_user in (select user_subscribe.id_user from user_subscribe where user_news.id ='.$id.')';
        $result = $this->query($query);

        if ($result){
            return $result[0];
        }

        return $result;
    }

    public function setImage($id_user,$img){
        $query = 'insert into user_news(image, id_user) values ("'.$img.'","'.$id_user.'")';
        $id_post = false;
        $result = $this->query($query);
        if($result){
            $id_post = mysqli_insert_id($this->connection);
        }
        return $id_post;
    }

    public function getImage($id){
        $image=false;
        $query = "select image from user_news where id=$id";
        $result = $this->query($query);

        if($result){
            $image = $result[0]['image'];
        }
        return $image;
    }
}
