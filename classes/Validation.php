
<?php

class Validation{
    private $_db=null,
            $_errors = array(),
            $pass = false;


    public function __construct(){
        $this->_db = DB::getInstance();
    }

    public function check ($type) : boolean{
        if ( $this->userNameValidate()){
            $this->pass = true;
        }

    }

    private function userNameValidate()  {
        $username = Input::get('username');
        if($username == ''){
            $this->addErrors("This field is required");
            return  false;
        }
        $username = $_POST['username'];
        $this->userNameFormat($username);
        $this->userNameLength($username);
        $this->userNameUnique($username);

            return count($this->_errors) == 0;
    }
    private function userNameFormat($username){
        if (!preg_match("/^[a-zA-Z0-9]*$/",$username)){
            $this->addErrors("username is not properly formatted");
            return false;

        }
        return true;

    }
    private function userNameLength($username){
        $usernameLength = strlen($username);
        if ( $usernameLength < 5 ){
            $this->addErrors("user name must be at least 5 characters ");
        }else if ($usernameLength > 20){
            $this->addErrors("user name must be at most 20 characters ");
        }else{
            return true;
        }
        return false;

    }


    public function userNameUnique($username){

        $row = $this->_db->get('users',array('user_name' , '=' , $username ))->getRes();
       /* echo " <pre> ";
        print_r($row);
        echo " </pre> ";*/
        if(!empty($row)){
            $this->addErrors("This username is taken");
            return false;
        }
        return true;




    }

    private function addErrors($error) {
        $this->_errors[] = $error;
    }
    public function printErrors() {
        print_r($this->_errors);

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
