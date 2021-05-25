
<?php

class Validation{
    private $_db=null,
            $_errorsMessages = array(
                "usernamerequired" =>"This field is required",
                "passwordrequired" =>"This field is required",
                "repeatedpasswordrequired" =>"This field is required",
                "usernameunique" => "This username is taken",
                "usernameshort" => "user name must be at least 5 characters",
                "usernamelong" => "user name must be at most 20 characters ",
                "usernameformat" => "username is not properly formatted",
                "passwordformat" => "Password should  include at least one upper case letter, one number, and one special character",
                "passwordshort" => "password must be at least 8 characters",
                "passwordlong" => "password must be at most 64 characters ",
                "password!match"=> "passwords must match"
            ),
        $_errors = array();



    public function __construct(){
        $this->_db = DB::getInstance();
    }

    public function check ($type) {
       $usernamePass = $this->userNameValidate();
       $passwordPass = $this->passwordValidate();

        if ( $usernamePass && $passwordPass ){
            return true;
        }
        return false;

    }

    ///////////////////////////////////////////////////

    private function userNameValidate()  {
        $username = Input::get('username');
        if($username == ''){
            $this->addErrors("usernamerequired");
            return  false;
        }
        $this->userNameFormat($username);
        $this->userNamePasswordLength('username',$username);
        $this->userNameUnique($username);

            return empty($this->_errors);
    }
    private function userNameFormat($username){
        if (!preg_match("/^[a-zA-Z0-9]*$/",$username)){
            $this->addErrors("usernameformat");
            return false;

        }
        return true;

    }



    public function userNameUnique($username){

        $row = $this->_db->get('users',array('user_name' , '=' , $username ))->getRes();
       /* echo " <pre> ";
        print_r($row);
        echo " </pre> ";*/
        if(!empty($row)){
            $this->addErrors("usernameunique");
            return false;
        }
        return true;




    }
    ///////////////////////////////////////////////////////////////////////////////////
    private function userNamePasswordLength($mode,$item){
        $itemLength = strlen($item);
        switch ($mode){
            case 'username' : $this->length($itemLength,5,20,array("usernameshort","usernamelong"));
                break;
            case 'password' : $this->length($itemLength,8,64,array("passwordshort","passwordlong"));
            break;
        }

    }

    private function length($itemLength,$lowerBound,$upperBound,$lengthErrors){
        switch ($itemLength){
            case $itemLength < $lowerBound :
                $this->addErrors($lengthErrors[0]);
                break;
            case $itemLength > $upperBound :
                $this->addErrors($lengthErrors[1]);
                break;
        }


    }



   ////////////////////////////////////////////////////////////////////////////////////

    private function passwordValidate()
    {

        $password = Input::get('password');
        if($password == ''){
            $this->addErrors("passwordrequired");
            $this->passwordMatches($password);
            return  false;
        }

        $this->passwordMatches($password);
        $this->passwordFormat($password);
        $this->usernamePasswordLength('password',$password);

        return empty($this->_errors);
    }
    private function passwordFormat($password)
    {
        $uppercase = preg_match('@[A-Z]@', $password);
        $lowercase = preg_match('@[a-z]@', $password);
        $number = preg_match('@[0-9]@', $password);
        $specialChars = preg_match('@[^\w]@', $password);

        if (!$uppercase || !$lowercase || !$number || !$specialChars) {
            $this->addErrors("passwordformat");

        }
    }
    private function passwordMatches($password)
    {
        $repeatedPass =  Input::get("password_again");
        if ($repeatedPass == ''){
            $this->addErrors("repeatedpasswordrequired");
        }
        if ($repeatedPass!=$password){
            $this->addErrors("password!match");
        }
    }

    ////////////////////////////////////////////////////////////////////////////////////

    private function addErrors($error) {
        $this->_errors[] = $error;
    }

    public function getErrors()
    {
        return $this->_errors;

    }





}
//username errors
//username is required
//user name already exists ?
//username is proprely formatted
//username is of proper length

//password stuff
//password is strong or weak? (properly formatted)
//password length is suitable
//the other password text field matches the other main field
//password is required




//preg_match("/^[a-zA-Z0-9]*$/") for checking a valid username
//filter_var($email,FILTER_VALIDATE_EMAIL)
/*
 * $uppercase = preg_match('@[A-Z]@', $password);
$lowercase = preg_match('@[a-z]@', $password);
$number    = preg_match('@[0-9]@', $password);
$specialChars = preg_match('@[^\w]@', $password);

if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
    echo 'Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.';
}else{
    echo 'Strong password.';
}

*/
