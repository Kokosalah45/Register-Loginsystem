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

    private function action ($action ,$table , $where = array()){
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
        return $this->action('SELECT*' , $table , $where);

    }


    public function delete($table,$where = array()){
        return $this->action('DELETE' , $table , $where);

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
