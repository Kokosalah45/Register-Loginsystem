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
            echo 'Connected !';
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


}
