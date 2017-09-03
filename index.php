<?php
include('./classes/DB.php');

function isLoggedIn(){

        if(isset($_COOKIE['SNID'])){
                if(DB::query('SELECT user_id FROM login_tokens WHERE token=:token',array(':token'=>sha1($_COOKIE['SNID'])))){

                        //var_dump(DB::query('SELECT user_id FROM login_tokens WHERE token=:token',array(':token'=>sha1($_COOKIE['SNID']))));

                        $user_id = DB::query('SELECT user_id FROM login_tokens WHERE token=:token',array(':token'=>sha1($_COOKIE['SNID'])))[0]['user_id'];

                        if(isset($_COOKIE['SNID_2'])){

                                return $user_id;
                        }else{
                                $crypt_strong = True; // only variable can be passed to the below generation method
                                $token = bin2hex(openssl_random_pseudo_bytes(64, $crypt_strong));

                                DB::query('INSERT INTO login_tokens(token, user_id) VALUES(:token, :user_id)',array(':token'=>sha1($token),':user_id'=>$user_id));
                                DB::query('DELETE FROM login_tokens WHERE token = :token', array(':token'=>sha1($_COOKIE['SNID'])));


                                // create the cookie in the local system
                                setcookie('SNID', $token, time() + 7 * 24 * 60 * 60, '/', NULL, NULL, TRUE);

                                // setting the second cookie to keep the user logged in by preventing
                                // the first cookie to expire while logged in

                                setcookie('SNID_2', '123', time() + 3 * 24 * 60 * 60, '/', NULL, NULL, TRUE);

                                echo $user_id;
                                return $user_id;
                        }

                }


        }

        return false;
}


if(isLoggedIn()){
        echo "Logged in ";
        echo isLoggedIn();
}else{
        echo "Not logged in";
}
?>
