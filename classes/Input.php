<?php
class Input {
    static function exists ($type = 'post'){
        switch ($type){
            case 'post':
                return !empty($_POST);
            case 'Get' :
                return !empty($_GET);

            default : return false;
        }

    }


    public static function get ($item){
        if(isset($_POST[$item])){
            return $_POST[$item];
        }else if (isset($_GET[$item])){
            return $_GET[$item];
        }else
            return '';


}


}