<?php
/**
 * Created by PhpStorm.
 * User: White_Rabbit
 * Date: 26.03.2019
 * Time: 1:29
 */

require_once '/base/Db.php';

class MusclesModel extends Db
{
    var $table = 'inventory';

    public function construct(){}

    function  getMuscleInfo($id){

        $query = 'select muscles.*, part_body.title as part_body 
                  from muscles inner join part_body on (muscles.id_partbody = part_body.id) 
                  where muscles.id = '.$id;
        $result = $this->query($query);
        $data =[];

        if ($result){
            $data = $result[0];

            $query = 'select exercise.id, exercise.image 
                      from exercise inner join exercise_muscles on (exercise.id = exercise_muscles.id_exercise) 
                      where exercise_muscles.id_muscle ='.$id.' limit 10';
            $result = $this->query($query);

            if ($result){
                $data['exercises']=$result;
            }

            $query = 'select id, image 
                      from muscles 
                      where id_partbody='.$id.' and not id = '.$id.' limit 10';
            $result = $this->query($query);

            if ($result){
                $data['muscles']=$result;
            }

        }

        return $data;
    }
}
