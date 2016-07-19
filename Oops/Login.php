<!DOCTYPE html>
<html lang="en">
<head>
  <title>Login</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <style>
    /* Remove the navbar's default rounded borders and increase the bottom margin */ 
    .navbar {
      margin-bottom: 50px;
      border-radius: 0;
    }
    
    /* Remove the jumbotron's default bottom margin */ 
     .jumbotron {
      margin-bottom: 0;
    }
   
    /* Add a gray background color and some padding to the footer */
    footer {
      background-color: #f2f2f2;
      padding: 25px;
    }
  </style>
 <!--/* my code */ -->
  <script type="text/javascript">

        function categoryselection(obj)
         {
          var selectionlistValue = document.getElementById("l4name_s").value;

           window.location.href = "index.php?category="+selectionlistValue;

         }
   
  </script>

</head>
<body>
<!--/* my code */ -->
<header>
 <?php

	$errorMsg="" ;
    
   if ( isset($_GET['logout']) && $_GET['logout']==1 )

   {   	  		
		//session_destroy();
		session_start();
		$_SESSION['user'] = "";
	    $_SESSION['logged_in'] =0;
	    echo "<h2> Successfully loged out!? </h2>";
   }




	// Validate Username/Password when User submitted the Data

	if ( isset($_POST['user']) && isset($_POST['password']) )
	{
		require_once("db.php");
        
		if (validate_user($_POST['user'], $_POST['password']))
		{   
			session_start();
			$_SESSION['user'] = $_POST['user'];
			$_SESSION['logged_in'] = 1;
            header("Refresh:1;url=index.php");
				
		}
		else
		{
			// TODO - Prevent user from trying to login after 5 unsuccessful attempts
			session_start();
			$_SESSION['user'] = "";
	        $_SESSION['logged_in'] =0;
			$errorMsg = "Invalid User and/or Password, try again...";
		}
	}


?>
</header>          
<div class="jumbotron">
  <div class="container text-center">
    <h1>Oops! Online Store</h1>      
    <p>Rapid, Safe & Cheap</p>
  </div>
</div>

<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="#">Logo</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li class="active"><a href="index.php">Home</a></li>
        <?php

           if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']==1 && isset($_SESSION['user']) && $_SESSION['user']=="admin" )
             {echo '<li><a href="./product/product.php">Products</a></li>';}
           
        ?>
        
        <li><a href="contact.php">Contact</a></li>
        <li><a href="aboutus.php">About Us</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <!--/* my code */ -->
        <?php
        
         if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']==1 )
         {
          echo '<li><a href="#"><span class="glyphicon glyphicon-user"></span> Welcom "'.$_SESSION['user'].'" </a></li>';
          echo '<li><a href="login.php ? logout=1"><span class="glyphicon glyphicon-user"></span> Logout </a></li>';
           }
         else
         {
          echo '<li><a href="login.php? logout=0 "><span class="glyphicon glyphicon-user"></span> Login </a></li>';
          }
        ?>
        <li><a href="cart.php"><span class="glyphicon glyphicon-shopping-cart"></span> Cart</a></li>
      </ul>
    </div>
  </div>
</nav>


<?php
	// Create the User/Login Form (Make sure you use the POST action, GET wouldn't be safe)
	


   echo '<form name="login id="login method="post" action="' . $_SERVER["PHP_SELF"] .'" >';

	if ( !isset($_SESSION['logged_in']) || $_SESSION['logged_in']==0)
	{
		
		echo  $errorMsg;
        echo '<br>';
	 	echo '<input type="text" name="user" class ="roundText" placeholder="User Name" required="required"/>';
 		echo '<input type="password" name="password" class ="roundText" placeholder="Password" autocomplete="off" required="required"/>';
		echo '<input type="submit" name="Signin" value="Sign In" />'; 
        

		/* TODO: Add user registration and password recovery
		<a href="register.php">Register</a>
		<a href="forgot_pw.php">Forgot Password</a>
		*/
	}
	else
	{  
	  header("Refresh:1;url=index.php"); 	
	}

	echo '</form>';
?>

	<form name="register" id ="register" method="post" action="./Register/Register.php">

		<h3> If you dont have account create a new one!</h3>

	<!-- TODO, execute javascript to make sure passwords are matching
		<label for="#repeatpassword">Repeat Password</label>
		<input type="text" placeholder="8-32 characters" required="required" name="repeatpassword" id="repeatpassword">
	-->
		<br/>
		<button type=submit>Create New Account</button>

	</form>


 </body>
</html>