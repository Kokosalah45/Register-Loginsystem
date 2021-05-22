<?php
require_once 'core/init.php';
 $DB0 = DB::getInstance()->executeQuery('SELECT * FROM USERS ');
 $res = $DB0->getRes();
 print_r($res);
 foreach ($res as $x){
     echo $x->user_name . "<br>";
 }















