<?php
/**
 * Created by PhpStorm.
 * User: White_Rabbit
 * Date: 27.03.2019
 * Time: 9:55
 */

require_once '/base/Db.php';

class ForegroundModel extends Db
{
    var $table = 'address';

    public function construct(){}

    public function getForegroundById($id)
    {
        $data =[];
        $query = 'select address.id, address.title, concat (address,\', \',town.title) as address, image, is_foreground 
                  from '.$this->table.' inner join town on (town.id = address.id_town)  
                  where address.id ='.$id;
        $result = $this->query($query);

        if ($result) {
            $data = $result[0];
        }

        return $data;
    }
}
