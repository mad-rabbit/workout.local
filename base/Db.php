<?php

require_once '/base/Config.php';

class Db
{
    var $connection;

    public function __construct()
    {
        $this->connection = mysqli_connect(
            Config::DB_HOST,
            Config::DB_USR,
            Config::DB_PWD,
            Config::DB_NAME);
    }

    public function insert(array $data, $table='')
    {
        $attributes ='';
        $dataItems ='';
        foreach ($data as $key=>$value){
            $attributes.=$key.', ';
            $dataItems.='"'.$value.'", ';
        }
        $attributes = substr($attributes,0,-2);
        $dataItems = substr($dataItems,0,-2);

        $query = 'INSERT INTO '.$table.' ('.$attributes.') VALUES ( '.$dataItems.')';
        $result = mysqli_query($this->connection, $query);

        return $result;
    }

    public function delete($id, $table='')
    {
        $query = 'DELETE * FROM '.$table.' WHERE id_value = '.$id;
        $result = mysqli_query($this->connection, $query);

        return $result;
    }

    public function update($id, array $data, $table='')
    {
        $setData='';
        foreach ($data as $key=>$value){
            $value = '"'.$value.'"';
            $setData.= $key.'='.$value.', ';
        }
        $setData = substr($setData,0,-2);

        $query = 'UPDATE '.$table.' SET '.$setData.' WHERE id ='.$id;

        $result = mysqli_query($this->connection, $query);

        return $result;
    }

    public function getAll($table, $orderBy='', $desc=0)
    {
        $result = false;
        $query = 'SELECT * FROM '.$table;
        if ($orderBy!=''){
            if ($desc){
                $query.=' ORDER BY'.$orderBy.' DESC';
            } else {
                $query.=' ORDER BY'.$orderBy;
            }
        };

        $resultSelect = mysqli_query($this->connection, $query);

        if (mysqli_num_rows($resultSelect)!=0){
            $result = [];
            while ($row = mysqli_fetch_assoc($resultSelect)) {
                $result[]=$row;
            }
        }
        mysqli_free_result($resultSelect);

        return $result;
    }

    public function getById($id, $table='')
    {
        $result =false;

        $query = 'SELECT * FROM '.$table.' WHERE id = '.$id;
        $resultSelect = mysqli_query($this->connection, $query);

        if (mysqli_num_rows($resultSelect)!=0) {
            $result = mysqli_fetch_assoc($resultSelect);
        }
        mysqli_free_result($resultSelect);

        return $result;
    }

    public function query($query){
        $result = false;

        $resultSelect = mysqli_query($this->connection, $query);

        if (($resultSelect !== true)&&($resultSelect !== false)){
            if (mysqli_num_rows($resultSelect)!=0){
                $result = [];
                while ($row = mysqli_fetch_assoc($resultSelect)) {
                    $result[]=$row;
                }
                mysqli_free_result($resultSelect);
            }
        } else {
            $result = $resultSelect;
        }

        return $result;
    }

    public function getData(array $attributes =[], $from, array $where=[], $orderBy='', $desc=0)
    {
        $result = false;
        $data = '';

        if (!empty($attributes)){
            foreach ($attributes as $key=>$value){
                $data.= $value.', ';
            }
            $data = substr($data,0,-2);
        } else {
            $data='*';
        }

        $query = 'SELECT '.$data.' FROM '.$from;

        $wherePart = '';
        if (!empty($where)){
            foreach ($where as $key=>$value){
                $wherePart.=$key.' = '.$value.' and ';
            }
        }
        if($wherePart!=''){
            $wherePart = ' WHERE ';
        }


        if ($orderBy!=''){
            if ($desc){
                $query.=' ORDER BY'.$orderBy.' DESC';
            } else {
                $query.=' ORDER BY'.$orderBy;
            }
        };

        $resultSelect = mysqli_query($this->connection, $query);

        if (mysqli_num_rows($resultSelect)!=0) {
            while ($row = mysqli_fetch_assoc($resultSelect)){
                $result[] = $row;
            }
        }

        return $result;
    }
}
