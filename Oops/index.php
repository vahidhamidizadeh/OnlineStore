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


<!--/* my code */ -->

 <form id="catpost" name="catpost" method="post" action="<?php echo $_SERVER['PHP_SELF']?>">

    <label for="l4name_s" required="required">Select Category Name</label>

    <select name="l4name_s" id="l4name_s" onchange="categoryselection(this)">
            
     <?php 

      $db = connect_db();

      $query = "SELECT * FROM l4_cat ";
      $result = mysqli_query($db, $query);
      $num_rows = mysqli_num_rows($result);

      for ($i = 0; $i <= $num_rows; ++$i)
        {
          if ($i==0)
          {

            echo '<option value="0" > --select-- </option>';
          }
          else
          {  
            $row = mysqli_fetch_row($result);

              if (isset($_GET['category']) && $_GET['category'] == $row[0] )

                echo '<option value="'.$row[0].'" selected="selected">'.$row[2] .'</option>';

              else

                echo '<option value="'.$row[0].'">'.$row[2] .'</option>'; 
          }  
        }
      
      close_db($db);
                  
      ?>
             
    </select>

 </form>
 
 <?php

  if( isset($_GET['category']) && $_GET['category']>0)

   { $db = connect_db();
  
     $query = "SELECT * FROM product WHERE l4_id = '".$_GET['category']."'";
              
     $result = mysqli_query($db, $query);
     $num_rows = mysqli_num_rows($result);

      if ($num_rows>0) 
      {  
        for ($i = 0; $i < $num_rows; ++$i)
              {
                  $row[$i] = mysqli_fetch_row($result);
                  
                   echo '<form id="prdpost'.$i.'" name="prdpost'.$i.'" method="post" action="">';

                   

                   echo '<div class="col-sm-4">';
                   echo '<div class="panel panel-primary">';

                   
                   echo '<div class="panel-heading">Name :'.$row[$i][3].'</div>';
                   echo '<div class="panel-body"><img src="'.$row[$i][8].'" class="img-responsive" style="width:100%" alt="Image"></div>';
                   echo '<div class="panel-footer">';
                             
                   echo 'Type :'.$row[$i][4].'<br/>';
                   echo 'Brand:'.$row[$i][5].'<br/>';
                   echo 'Model:'.$row[$i][6].'<br/>';
                   echo 'Price:'.$row[$i][7].'$ <br/>';
                   echo 'Order Qty :<br/>';
                   echo '<input  name="qty" id="qty" type="number" min="1" max="'.$row[$i][9].'" >';
                 

                    if ($row[$i][9]>0)
                       {
                        echo '<br>';

                        echo '<input type="text" name="prdid" value="'.$row[$i][0].'" style="display:none;">';
                        echo '<input type="text" name="clrid" value="'.$row[$i][1].'" style="display:none;">';
                        echo '<button type="submit" name="addcartbtn'.$i.'" form="prdpost'.$i.'" >Add to Cart</button>';
                                                    
                       }
                    else
                       {echo '<h5> Not Available! </h5>';}

                   echo '</div>';

                   echo '</div>';
                   echo '</div>';
            
                 
                  echo '</form>';
              }
      
     }
     else
      {echo "<h1>Welcomto Oops online store!</h1>";}

    close_db($db);

   }
   else
   {echo "<h1>Welcomto Oops online store!</h1>";}    
          
 ?>

    
 


</body>
</html>
