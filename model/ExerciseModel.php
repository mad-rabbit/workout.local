<?php

require_once '/base/Db.php';

class ExerciseModel extends Db
{
    var $table = 'exercise';

    public function construct(){}

    function  getExerciseInfo($id){

        $query = 'select exercise.id, exercise.title, description, hard_level, image, video, id_group, 
                  exercise_type.title as type, id_exercise_type as id_type
                  from exercise_type inner join exercise on (id_exercise_type = exercise_type.id) 
                  where exercise.id ='.$id;
        $result = $this->query($query);
        $data =[];

        if ($result){
            $data = $result[0];

            if(!is_null($data['id_group'])){
                $query = 'select title from exercise_group where id='.$data['id_group'];
                $result = $this->query($query);
                $data['group'] = $result[0]['title'];

                $query = 'select id, image 
                          from exercise 
                          where id_group ='.$data['id_group'].' limit 10';

                $result = $this->query($query);
                if($result){
                    $data['exercises']=$result;
                }
            }

            $query = 'select muscles.id, muscles.image 
                      from muscles inner join exercise_muscles on exercise_muscles.id_muscle = muscles.id 
                      where id_exercise ='.$id.' limit 10';
            $result = $this->query($query);
            if ($result){
                $data['muscles']=$result;
            }

            $query = 'select id, image 
                      from inventory inner join exercise_inventory on (inventory.id=id_inventory) 
                      where id_exercise ='.$id.' limit 10';
            $result = $this->query($query);
            if ($result){
                $data['inventory']=$result;
            }

            $query = 'select *
                      from user_exercise_save  
                      where id_exercise ='.$id.' and id_user ='.$_SESSION['id_user'];
            $result = $this->query($query);
            if ($result){
                $data['is_saved']= true;
            } else {
                $data['is_saved']= false;
            }
        }

        return $data;
    }

    function save($id_exercise, $id_user){
        $data = [
            'id_user' => $id_user,
            'id_exercise' => $id_exercise,
        ];

        $result = $this->insert($data,'user_exercise_save');

        return $result;
    }

    function unsave($id_exercise, $id_user){

        $query= 'delete from user_exercise_save where id_user = '.$id_user.' and id_exercise = '.$id_exercise;

        $result = $this->query($query);

        return $result;
    }
}
