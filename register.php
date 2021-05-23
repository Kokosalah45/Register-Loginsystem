<?php

require_once 'core/init.php';

if (Input::exists()){
    $v = new Validation();
    $v->check('post');
    $v->printErrors();


}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<form action="" method="post">
    <div class="username">
        <label for="username">Username : </label>
        <input type="text" name="username" id="username" value="" autocomplete="off">
    </div>
    <div>
        <label for="password">password : </label>
        <input type="password" name="password" id="password" value="" autocomplete="off">
    </div>
    <div>
        <label for="password_again">Type your password again :  </label>
        <input type="password" name="password_again" id="password_again" value="" autocomplete="off">
    </div>
    <button type="submit" VALUE="register">SUBMIT</button>
</form>


</body>
</html>
