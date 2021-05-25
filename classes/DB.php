<?php

class DB{
   private static $instance = null;
   private $_pdo,
           $_query,
           $_error,
           $_results,
           $_count = 0;


    private  function __construct() // conncetion
    {
        try{
            $this->_pdo= new PDO( "mysql:host=".Config::get('mysql/host').";dbname=".Config::get('mysql/db') , Config::get('mysql/username'), Config::get('mysql/password') );

        }catch (PDOException $e){
            die($e->getMessage());
        }

    }

    public static  function  getInstance (){
        if (!isset(self::$instance)){
            self::$instance = new DB();
        }

        return self::$instance;
    }


    public function executeQuery ($sql,$params = array()){
        $this->_error=false;

        if ($this->_query = $this->_pdo->prepare($sql) ){
            $x=1;
            if(count($params)){
                foreach($params as $param){
                    $this->_query->bindValue($x,$param);
                    $x++;
                }
            }

        }
        if($this->_query->execute()){
            $this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
            $this->_count = $this->_query->rowCount();
        }else{
            $this->_error=true;
        }

        return $this;
    }

    private function get_delete ($action ,$table , $where = array()){
        if (count($where)===3){
            $allowedOperators = array('>','<' , '=' , '>=' , '<=');
            $field = $where[0];
            $operator = $where[1];
            $value = $where[2];
            if(in_array($operator,$allowedOperators)){
                $sql = "{$action} FROM {$table} WHERE {$field} {$operator} ? " ; //temporary we use where
                if (!$this->executeQuery($sql,array($value))->error()){
                    return $this;

                }
            }
        }
        return false;
    }

    public function get($table,$where = array()){
        return $this->get_delete('SELECT*' , $table , $where);

    }


    public function delete($table,$where = array()){
        return $this->get_delete('DELETE' , $table , $where);

    }
    public function insert($table ,$fields ){
        $keys = array_keys($fields);
        $values = "" ;
        $lenOfValues = 0;
        foreach ($fields as $field){
            $values.= "?,";
            $lenOfValues++;
        } //faster in execution time
        $values = rtrim($values, $values[($lenOfValues*2)-1]);

        $sql = "INSERT INTO {$table}(" . implode(',',$keys) . ")VALUES({$values}) ";
        if(!$this->executeQuery($sql , $fields)->error()){
            return true;
        }



        return false;
    }
    public function update($table , $fields  ,$id ){
        //UPDATE CUSTOMERS SET USER_NAME =  KAZA , PASSWORD = KAZA WHERE ID = KAZA;
        $keys = array();
        foreach ($fields as $field => $field_value){
           $keys[] = $field . " = ?";
        } //faster in execution time
        $fields['id'] = $id;
        $sql = "UPDATE {$table} SET " . implode(', ' , $keys). "WHERE ID = ? ";
        if (!$this->executeQuery($sql , $fields)->error()){
            return true;
        }
            return  false;

    }


    //getallwithout where
    //get specific columns with and without where
    // if no where so there's no need to call array of modes
    //do queries with (and or)  array of modes
    //insert values
    //update values






    public function error(){
        return $this->_error;
    }



    public function getRes(){
        return $this->_results;
}








}
