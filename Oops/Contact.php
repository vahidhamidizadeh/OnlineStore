<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
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
  require_once("db.php");
  session_start();
  if(isset($_POST['prdid']) && isset ($_POST['clrid']) && isset ($_POST['qty']))
   {
     include "addcart.php";
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

<h2> Head Office Address</h2>
<address>No#6550 <br>
         sherbrook west <br>
         Postal code:2n4xxx <br> 
         Phone:514-566-0066 <br>
         Fax:514-566-0077</address>
 <h2>Email Address:</h2>
 <a href="mailto:info@example.com?Subject=Customer%20Requexst" target="_top">Send Mail</a>
 <h2>Google map</h2>

 

 


</body>
</html>























