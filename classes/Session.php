<?php
class Session{
    public static function put($name , $generatedToken) : String {
        return $_SESSION[$name] = $generatedToken;
    }
    public static function exists($tokenName)  {
        return isset($_SESSION[$tokenName]);
    }
    public static function get($tokenName)  {
        return $_SESSION[$tokenName];
    }

    public static function delete($tokenName){
        if (self::exists($tokenName)){
            unset($_SESSION[$tokenName]);
        }
    }
}
