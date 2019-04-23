<?php

require_once '/base/Db.php';

class UserModel extends Db
{
    var $table = 'users';

    public function construct(){}

    public function getLoginData($email)
    {
        $email = '"'.$email.'"';
        $select = 'SELECT id, email, login, password FROM '.$this->table.' WHERE email = '.$email.' or login = '.$email;
        $result = $this->query($select);
        $result = $result[0];
        return $result;
    }

    public function register(array $data){
        $result = $this->insert($data, $this->table);
        if ($result){
            $id_user = mysqli_insert_id($this->connection);
        } else {
            $id_user=0;
        }

        return $id_user;
    }

    public function checkUser($data)
    {
        $result=false;

        $login = '"'.$data['login'].'"';
        $email = '"'.$data['email'].'"';

        $select = 'SELECT id FROM '.$this->table.' WHERE email = '.$email;
        if($this->query($select))
        {
            $result = "Пользователь с данным email уже существует.";
        }

        $select = 'SELECT id FROM '.$this->table.' WHERE login = '.$login;
        if($this->query($select))
        {
            if (!$result){
                $result='';
            }
            $result = "Данный login уже используется.";
        }

        return $result;
    }

    function  getUser($id){
        $result = $this->getById($id, $this->table);

        return $result;
    }

    function  getUserInfo($id, $isMainUser = 0, $id_main){

        $query = 'select users.id, login, image, CONCAT(name,\' \', l_name) as full_name , id_town,
                  DATEDIFF(NOW(),date_birthday) as db,DATEDIFF(NOW(),date_workout) as dw, 
                  info 
                  from users  
                  where users.id= '.$id;

        $result = $this->query($query);
        $userData = $result[0];

        $query = 'select title,is_viewer, is_manager, occupid_place from competition inner join participation on (id_competition = competition.id) where id_user= '.$id;
        $result = $this->query($query);
        $dostigeniya = [];
        if ($result){
            foreach ($result as $key => $value){
                $row = $value['title'].' - ';
                if ($value['is_viewer']== 0){
                    $row .= $value['occupid_place'].' место';
                    $dostigeniya[] = $row;
                }elseif ($value['is_manager']== 1){
                    $row .= 'организатор';
                    $dostigeniya[] = $row;
                }
            }
            $userData['dostigeniya']=$dostigeniya;
        }

        $query = 'select link, title from social_user inner join social on (social_user.id_social = social.id) where id_user = '.$id;
        $result = $this->query($query);
        if ($result){
            foreach ($result as $key => $value)
            {
                $userData['social'][$value['title']] = $value['link'];
            }
        }

        $query = 'select id,image from user_news where id_user='.$id.' order by date_time desc';
        $result = $this->query($query);
        if ($result){
            $userData['news']=$result;
        }

        if (!is_null($userData['id_town'])){
            $query = 'select concat(town.title,", ",country.title) as title
                      from town inner join country on (town.id_country = country.id) 
                      where town.id='.$userData["id_town"];
            $result = $this->query($query);
            $userData['town']=$result[0]['title'];
        }

        $userData['db']= (int)($userData['db']/ 365); //intdiv($userData['db'], 365); php7

        if (!$isMainUser){
            $query = 'select * from user_subscribe where id_user = '.$id.' and id_follower = '.$id_main;

            $result = $this->query($query);
            if ($result){
                $userData['followed']=1;
            } else {
                $userData['followed']=0;
            }
        }


        return $userData;
    }

    function followUser($id_main, $id_user){
        $data = [
            'id_user' => $id_user,
            'id_follower' => $id_main,
        ];

        $result = $this->insert($data,'user_subscribe');

        return $result;
    }

    function unfollowUser($id_main, $id_user){

        $query= 'delete from user_subscribe where id_user = '.$id_user.' and id_follower = '.$id_main;

        $result = $this->query($query);

        return $result;
    }

    public function checkPassword($id, $password)
    {
        $select = 'SELECT password FROM '.$this->table.' WHERE id = '.$id;

        $result = $this->query($select);

        if($result) {
            $result = $result[0];

            if (password_verify($password, $result['password'])) {
                $result = true;
            } else {
                $result = false;
            }
        } else {
            $_SESSION['message']='Что-то пошло не так..(';
        }

        return $result;
    }

    public function checkLogin($id, $login)
    {
        $select = 'SELECT id FROM '.$this->table.' WHERE login = "'.$login.'"';
        $result = $this->query($select);

        if($result) {
            $result = $result[0];

            if ($id != $result['id']) {
                $result = true;
            } else {
                $result = false;
            }
        }

        return $result;
    }

    public function setImage($id, $image)
    {
        $image = substr ($image,1);
        $image = $image;
        $query= 'update '.$this->table.' set image = "'.$image.'" where id='.$id ;
        $result = $this->query($query);

        return $result;
    }

}
