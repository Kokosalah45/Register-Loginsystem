<?php
class Token {
    public static function generate () : String {
        return md5(uniqid());
    }

}
