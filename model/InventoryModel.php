<?php

require_once '/base/Db.php';

class InventoryModel extends Db
{
    var $table = 'inventory';

    public function construct(){}

    function  getInventoryInfo($id){

        $query = 'select * from inventory where id = '.$id;
        $result = $this->query($query);
        $data =[];

        if ($result){
            $data = $result[0];

            if ($data['is_portable']){
                $data['is_portable'] = '(переносной)';
            } else {
                $data['is_portable'] = '(не переносной)';
            }

            $query = 'select exercise.id, exercise.image 
                      from exercise inner join exercise_inventory on (exercise.id = exercise_inventory.id_exercise) 
                      where exercise_inventory.id_inventory ='.$id.' limit 10';
            $result = $this->query($query);

            if ($result){
                $data['exercises']=$result;
            }
        }

        return $data;
    }
}
