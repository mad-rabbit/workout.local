<?php
/**
 * Created by PhpStorm.
 * User: White_Rabbit
 * Date: 27.03.2019
 * Time: 9:55
 */

require_once '/base/Db.php';

class CompetitionsModel extends Db
{
    var $table = 'competition';

    public function construct(){}

    public function getAllCompetitions()
    {
        $query = 'select id, image 
                  from '.$this->table.' order by date desc';

        $result = $this->query($query);
        return $result;
    }

    public function getCompetitionById($id)
    {
        $data =[];
        $query = 'select *
                  from '.$this->table.' 
                  where id ='.$id;
        $result = $this->query($query);

        if ($result){
            $data = $result[0];

            if(!is_null($data['id_address'])){
                $query = 'select concat(title,\', \',address) as title, image
                  from address 
                  where id ='.$data['id_address'];
                $result = $this->query($query);

                if($result){
                    $data['address']= $result[0];
                }
            }
        }

        return $data;
    }
}
