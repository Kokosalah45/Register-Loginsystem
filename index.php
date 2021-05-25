<?php

require_once 'core/init.php';

if (Session::exists('success')){
    echo  Session::flashMessage('success');
}

















