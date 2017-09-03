<?php
include('./classes/DB.php');

function isLoggedIn(){

        if(isset($_COOKIE['SNID'])){
                if(DB::query('SELECT user_id FROM login_tokens WHERE token=:token',array(':token'=>sha1($_COOKIE['SNID'])))){
                        return true;
                }


        }

        return false;
}

if(isLoggedIn()){
        echo "Logged in ";
}else{
        echo "Not logged in";
}
?>
