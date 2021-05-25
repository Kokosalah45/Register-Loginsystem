<?php
class Token {
    public static function generate () : String {
        return md5(uniqid());
    }
    public static function check ()   {
       $tokenName = Config::get('session/CSRF');
       $postTokenVal = Input::get($tokenName);
       $sessionTokenVal = Session::get($tokenName);


       if (Session::exists($tokenName) && ($postTokenVal == $sessionTokenVal)){ //does the $token sent from post equals that i generated at any instance?
           Session::delete($tokenName);
           return true;

       }
       return false;
    }



}
