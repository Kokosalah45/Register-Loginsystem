<?php
class Session{
    //general Session methods
    public static function put($sessionKey , $item) : String {
        return $_SESSION[$sessionKey] = $item;
    }
    public static function exists($sessionKey)  {
        return isset($_SESSION[$sessionKey]);
    }
    public static function get($sessionKey)  {
        return $_SESSION[$sessionKey];
    }

    public static function delete($sessionKey){
        if (self::exists($sessionKey)){
            unset($_SESSION[$sessionKey]);
        }
    }
    //methods for specific use
    public static function flashMessage ($messageKey , $message = '') {
        if (self::exists($messageKey)){
            $message = self::get($messageKey);
            self::delete($messageKey);
            return $message;
        }
        self::put($messageKey,$message);

    }
    public static function putToken ($tokenName ,$token) {
        self::put($tokenName,$token);

    }

}
