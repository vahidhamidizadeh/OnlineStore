<header>
<?php
	$errorMsg = "";

	// Clear the session when User Logouts
	if ( isset($_POST['logout']))
	{
		session_destroy();
		session_start();
	}

	// Validate Username/Password when User submitted the Data
	if ( isset($_POST['user']) && isset($_POST['password']) )
	{
		require_once("db.php");

		if (validate_user($_POST['user'], $_POST['password']))
		{
			$_SESSION['user'] = $_POST['user'];
			$_SESSION['logged_in'] = 1;
		}
		else
		{
			// TODO - Prevent user from trying to login after 5 unsuccessful attempts
			$errorMsg = "Invalid User and/or Password, try again...";
		}
	}

	// Create the User/Login Form (Make sure you use the POST action, GET wouldn't be safe)
	echo '<form method="post" action="' . $_SERVER["PHP_SELF"] .'" >';

	if (!isset($_SESSION['logged_in']))
	{
		echo $errorMsg . "<br />";
	

		echo <<<_END
	 	<span class="login_form_input"><input type="text" name="user" class ='roundText' placeholder='User Name' required="required"/></span> 
 		<span class="login_form_input"><input type="password" name="password" class ='roundText' placeholder='Password' autocomplete='off' required="required"/></span> 
		<input type="submit" name="Signin" value="Sign In" /> 
_END;

		/* TODO: Add user registration and password recovery
		<a href="register.php">Register</a>
		<a href="forgot_pw.php">Forgot Password</a>
		*/
	}
	else
	{
		echo "<br />Welcome " . $_SESSION['user'];
		echo <<<_END
		<input type="submit" name="logout" value="Logout" > 
_END;
	}

	echo '</form>';
?>
</header>