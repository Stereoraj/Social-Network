<?php
  include('classes/DB.php');

  if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];


    if(DB::query('SELECT username FROM users WHERE username=:username', array(':username'=>$username))){
            // authenticating the user credentials

            /* echo '<pre />';
            var_dump(DB::query('SELECT * FROM users WHERE username=:username', array(':username'=>$username)));
            echo '<pre />';

            echo DB::query('SELECT password FROM users WHERE username=:username', array(':username'=>$username))[0]['password'];
            */

            var_dump(password_verify($password,DB::query('SELECT password FROM users WHERE username=:username',array(':username'=>$username))[0]['password']));


            if(password_verify($password,DB::query('SELECT password FROM users WHERE username=:username',array(':username'=>$username))[0]['password'])){
                    echo 'valid password';

                    // generate the login token
                    $crypt_strong = True; // only variable can be passed to the below generation method
                    $token = bin2hex(openssl_random_pseudo_bytes(64, $crypt_strong));
                    var_dump($token);

                    // retrieve the id from the valid username to link the generated token with it
                    $user_id = DB::query('SELECT id FROM users WHERE username=:username', array(':username'=>$username))[0]['id'];

                    // storing the token with respective user_id to the table
                    DB::query('INSERT INTO login_tokens(token, user_id) VALUES(:token, :user_id)', array(':token'=>sha1($token), ':user_id'=>$user_id));

                    // create the cookie in the local system
                    setcookie('SNID', $token, time() + 10, '/', NULL, NULL, TRUE);


            }else{
                    echo 'invalid password';
            }

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
