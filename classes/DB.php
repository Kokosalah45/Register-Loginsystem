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
    public function query ($sql,$params = array()){
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
    public function error(){
        return 'de7k';
    }

    //add user
    //view user
    //delete user
    //





}
