<?php
require_once 'core/init.php';
 $DB0 = DB::getInstance()->query('SELECT USERNAME FROM USERS ');
 $DB1 = DB::getInstance()->query('SELECT USERNAME FROM USERS ');
 $DB2 = DB::getInstance()->query('SELECT USERNAME FROM USERS ');
echo  $DB0->error();
echo  $DB1->error();
echo  $DB2->error();





