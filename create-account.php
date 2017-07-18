<?php
	
	include('classes/DB.php');

	if(isset($_POST["submit"])){

		$username = $_POST["username"];
		$password = $_POST["password"];
		$email = $_POST["email"];

		if(!DB::query("SELECT username FROM users WHERE username=:username",array(':username'=>$username))){
			
			if(strlen($username)>=3 && strlen($username)<=32){
				DB::query("INSERT INTO users(username,password,email) VALUES(:username,:password,:email)",array(':username'=>$username,':password'=>$password,':email'=>$email));

				echo "successfully stored in the database !!";
			}else{
				echo "Invalid username";	
			}

		}else{

			echo "username already exists !!";
		}

	
	}

?>

<h1>Register</h1>

<form action="create-account.php" method="Post">
	<table>
		<tr>
			<td>Name</td> 
			<td><input type="text" name="username"></td>
		</tr>

		<tr>
			<td>Password</td> 
			<td><input type="password" name="password"></td>
		</tr>

		<tr>
			<td>Email</td> 
			<td><input type="email" name="email"></td>
		</tr>
		
		<tr>
			<td><input type="submit" name="submit" value="sign up"></td>
		</tr>
	</table>
	
</form>
