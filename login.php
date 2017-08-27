<?php
  include('classes/DB.php');

  if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];


    if(DB::query('SELECT username FROM users WHERE username=:username', array(':username'=>$username))){

    }else{
      echo 'user not registered !!';
    }

  }

?>

<h1>LOGIN</h1>

<form class="" action="login.php" method="post">
      <input type="text" name="username" value="" placeholder="username">
      <input type="password" name="password" value="" placeholder="password">
      <input type="submit" name="login" value="submit">
</form>
