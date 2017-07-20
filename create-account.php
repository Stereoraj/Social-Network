<?php
	
	include('classes/DB.php');

	if(isset($_POST["submit"])){

		$username = $_POST["username"];
		$password = $_POST["password"];
		$email = $_POST["email"];

		if(!DB::query("SELECT username FROM users WHERE username=:username",array(':username'=>$username))){
			
			if(strlen($username)>=3 && strlen($username)<=32){

				// TO-DO : not able to validate the username with the pattern ...
				// have to check it again
				if(preg_match("/[a-z]+/",$username)){

					if(strlen($password)>=6 && strlen($password)<=60){

						if(filter_var($email, FILTER_VALIDATE_EMAIL)){

							DB::query("INSERT INTO users(username,password,email) VALUES(:username,:password,:email)",array(':username'=>$username,':password'=>password_hash($password, PASSWORD_BCRYPT),':email'=>$email));

							echo "successfully stored in the database !!";

						}else{

							echo "Invalid Email ID";
						}
					}else{

						echo "Invalid password";
					}
				}else{

					echo "Invalid pregmatic form";
				}
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
