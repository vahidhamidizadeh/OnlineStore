<!DOCTYPE html>
<html lang="en">
<head>
  <title>Cart</title>
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


<header>
 <?php 
  require_once("db.php");
  session_start();
  /*if(isset($_POST['prdid']) && isset ($_POST['clrid']) && isset ($_POST['qty']))
   {
     include "addcart.php";
   }
*/
 ?>
</header>
<!--/* my code */ -->
        
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
       
        $current_list=cookie_list_update();
        $found = false;
        for($i=0;$i<count($current_list);$i++)
       {
        if(isset($_POST['chk'.$i]))
         {  
            setcookie("oopscart|".$current_list[$i]['prdid']."|".$current_list[$i]['clrid'], "oopscart|".$current_list[$i]['prdid']."|".$current_list[$i]['clrid']."|".$current_list[$i]['invqty'], time() - 3600, "/");
            $found = true;
         } 


        }
        if ($found)
            echo '<script>window.location = window.location.href; </script>';


       $current_list=cookie_list_update();
       cookie_table_print($current_list);

       echo '<button type="submit" name="removecart" form="cartpost">Remove from Cart</button>';
       echo '<br>';
       echo '<br>';

       echo '<form  id="invoice" name="invoice" method="post" action="" >';
       echo '<input type="text" name="invoiceissue" value="1" style="display:none;">';
       echo '<button type=submit name="isuinvoice" form="invoice" > Issue Invoice </button>';
       echo '</form>';

       if (isset($_POST['invoiceissue']) && $_POST['invoiceissue']==1)
       
       { 


        if(isset($current_list))

             { // session_start();
               if ( isset($_SESSION['logged_in']) && $_SESSION['logged_in']==1 && isset($_SESSION['user']) )
                     {require_once("db.php"); 
                     $status="Regular"; 
                   //echo $status;
                     $invid=insert_new_invoice($status);
                     insert_new_invoice_list($invid,$current_list);
                     echo "your invoice sent to your email please confirm it!";     
                     /*$delayed_list=cookie_list_update();
                      cookie_table_print($delayed_list);
                       if(isset($delayed_list))
                           {$status="Delayed";
                            //echo $status;
                            $invid=insert_new_invoice($status);
                            insert_new_invoice_list($invid,$delayed_list);}*/}
                  else
                  {echo "Login to your account";}  

               
             }
             else
             {
              echo 'Add to cart first then try again!';
             } 
     

       }
       
?>
       
       </body>
</html>














   <?php

       function cookie_list_update()
       { $cookie_list=null;
         $i=0;
         foreach ($_COOKIE as $value)
         {   
             if (substr($value,0,8)=="oopscart")
              { 
                $value=substr($value,8);
                
                 $token=strtok($value,"|");
                 $cookie_list[$i]['prdid']= $token;
                
                 $token=strtok("|");
                 $cookie_list[$i]['clrid']=$token;
                 
                
                 $token=strtok("|");
                 $cookie_list[$i]['invqty']=$token;

                 $i++;          
                 
               } 

           }
          return $cookie_list;  
         
         }

        function cookie_table_print($cookie_list)
         {  
           
            require_once("db.php");
            echo '<form id="cartpost" name="cartpost" method="post" action="cart.php" >';
            echo '<table class="carttable" >';
            echo '<tr>';
            echo '<td>Name</td>';
            echo '<td>Brand</td>';
            echo '<td>Model</td>';
            echo '<td>Color</td>';
            echo '<td>Unit Price</td>';
            echo '<td>Quantity</td>';
            echo '<td>Total Price</td>';
            echo'</tr>';

            $index=0;

            $db = connect_db();

            if (count($cookie_list)>0)
            {
            foreach ($cookie_list as $value)
             { 
              
    
                 $query = "SELECT * FROM product WHERE prd_id='". $value['prdid'] ."' and clr_id='". $value['clrid'] ."'" ;
                 $result = mysqli_query($db, $query);
                 $num_rows = mysqli_num_rows($result);

                 $query1 = "SELECT * FROM color WHERE clr_id='". $value['clrid'] ."' " ;
                 $result1= mysqli_query($db, $query1);
                 $num_rows = mysqli_num_rows($result);

        
                 if ($num_rows == 0)
                 {
                   echo "this product dosn't exist any more!";  
            
                 } else if ($num_rows > 1) {
                    echo  "Duplication Error!"; }

                         else
                          {   
                
                             $row = mysqli_fetch_row($result);
                             $clr = mysqli_fetch_row($result1);
                              echo '<tr>';
                              echo '<td>'.$row[3].'</td>';
                              echo '<td>'.$row[5].'</td>';
                              echo '<td>'.$row[6].'</td>';
                              echo '<td>'.$clr[1].'</td>';
                              echo '<td>'.$row[7].'</td>';
                              echo '<td>'.$value['invqty'].'</td>';
                              echo '<td>'.$value['invqty']*$row[7].'</td>';
                              echo '<td> <input type="checkbox" name="chk'.$index.'" id="chk'.$index.'" value="1"> </input> </td>';
                              
                              echo'</tr>';
                              
                              $index++;              
                          }
                 
              }
             }
             close_db($db);
             echo'</table>';
             echo '</form>';
          }

        
?>