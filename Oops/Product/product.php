<!DOCTYPE html>
<html lang="en">
<head>
  <title>New Product Insertion</title>
  <script src="modernizr-1.5.js"></script>
  <link href="sb.css" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" type="text/css" href="product.css">
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
 
</head>
<body>

<header>      


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
        <li class="active"><a href="../index.php">Home</a></li>
        <?php

           if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']==1 && isset($_SESSION['user']) && $_SESSION['user']=="admin" )
             {echo '<li><a href="./product/product.php">Products</a></li>';}
           
        ?>
        
        <li><a href="../contact.php">Contact</a></li>
        <li><a href="../aboutus.php">About Us</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <!--/* my code */ -->
        <?php
        
         if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']==1 )
         {
          echo '<li><a href="#"><span class="glyphicon glyphicon-user"></span> Welcom "'.$_SESSION['user'].'" </a></li>';
          echo '<li><a href="../login.php ? logout=1"><span class="glyphicon glyphicon-user"></span> Logout </a></li>';
           }
         else
         {
          echo '<li><a href="../login.php? logout=0 "><span class="glyphicon glyphicon-user"></span> Login </a></li>';
          }
        ?>
        <li><a href="../cart.php"><span class="glyphicon glyphicon-shopping-cart"></span> Cart</a></li>
      </ul>
    </div>
  </div>
</nav>

</header>
     <?php
          session_start();
          require_once("../db.php"); 
          if (isset($_POST['l4name']) && isset($_POST['addcatbtn']))
          { $l4id=insert_new_category($_POST['l4name']);
           }
          
          if (isset($_POST['clrname']) && isset($_POST['addclrbtn']))
          { $clrid=insert_new_color($_POST['clrname']);
            echo $clrid;
           }
         
          if (isset($_POST['clrname_s']) && isset($_POST['l4name_s']) && isset($_POST['prdname']) && isset($_POST['prdtype']) && isset($_POST['prdbrand']) && isset($_POST['prdmodel']) && isset($_POST['prdprice']) && isset($_POST['prdimage'])&& isset($_POST['prdqnty']) && isset($_POST['addprdbtn']))
           { $prdid=insert_new_product($_POST['clrname_s'],$_POST['l4name_s'],$_POST['prdname'],$_POST['prdtype'],$_POST['prdbrand'],$_POST['prdmodel'],$_POST['prdprice'],$_POST['prdimage'],$_POST['prdqnty']);
             
            } 

          if (isset($prdid) && isset($_POST['clrname_s']) && isset($_POST['addprdbtn']))
           { insert_new_color_list($prdid,$_POST['clrname_s']);
            }

             ?>
      

      <section>

         <h1>Category Insertion Form</h1>

         
         <form id="catpost" name="catpost" method="post" action="<?php echo $_SERVER['PHP_SELF']?>">
         
         <fieldset id="category">
         <legend>Category Information (required)</legend>
         <label for="l4name">Category Name</label> 
         <input name="l4name" id="l4name" type="text" required="required"></input>
         <br/>

         </fieldset>

        
         <button type="submit" name="addcatbtn">Add Category</button>
         </form>
         
         <form id="clrpost" name="clrpost" method="post" action="<?php echo $_SERVER['PHP_SELF']?>">
         
         <fieldset id="color">
         <legend>Color Information (required)</legend>
         <label for="clrname">Color Name</label> 
         <input name="clrname" id="clrname" type="text" required="required"></input>
         <br/>

         </fieldset>

        
         <button type="submit" name="addclrbtn">Add Color</button>
         </form>

         <form id="prdpost" name="prdpost" method="post" action="<?php echo $_SERVER['PHP_SELF']?>">


         <fieldset id="product">
         <legend>Product Information (required)</legend>


         <label for="l4name_s" required="required">Select Category Name</label>
         <select name="l4name_s">
         <?php 
              $db = connect_db();
  
              $query = "SELECT * FROM l4_cat ";
              $result = mysqli_query($db, $query);
              $num_rows = mysqli_num_rows($result);

              for ($i = 0; $i < $num_rows; ++$i)
              {
                $row = mysqli_fetch_row($result);
                echo '<option value="'.$row[0].'">'.$row[2] .'</option>'; 
               }

               close_db($db);
          ?>
         </select>


         <label for="clrname_s" required="required">Select Color </label>
         <select name="clrname_s">
         <?php 
              $db = connect_db();
  
              $query = "SELECT * FROM color ";
              $result = mysqli_query($db, $query);
              $num_rows = mysqli_num_rows($result);

              for ($i = 0; $i < $num_rows; ++$i)
              {
                $row = mysqli_fetch_row($result);
                echo '<option value="'.$row[0].'">'.$row[1] .'</option>'; 
               }

               close_db($db);
          ?>
         </select>

         <label for="prdname">Name</label> 
         <input name="prdname" id="prdname" type="text" required="required"></input>
         <br/>
        
         <label for="prdtype">Type</label> 
         <input name="prdtype" id="prdtype" type="text" required="required"></input>
         <br/>

         <label for="prdbrand">Brand</label> 
         <input name="prdbrand" id="prdbrand" type="text" required="required"></input>
         <br/>
         
         <label for="prdmodel">Model</label> 
         <input name="prdmodel" id="prdmodel" type="text" required="required"></input>
         <br/>
         
         <label for="prdprice">Price</label> 
         <input name="prdprice" id="prdprice" type="text" required="required"></input>
         <br/>
         
         <label for="prdimage">Image Path</label> 
         <input name="prdimage" id="prdimage" type="text" required="required"></input>
         <br/>

         <label for="prdqnty">Stock Quantity</label> 
         <input name="prdqnty" id="prdqnty" type="text" required="required"></input>
         <br/>

         </fieldset>

        

         <button type="submit" name="addprdbtn">Add Product</button> 

       </form>
        
      </section>

   </body>

</html>
