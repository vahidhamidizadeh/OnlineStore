<!DOCTYPE html>
<html>

   <head>

      <meta charset="UTF-8" />
      <title>Oops Store!</title>
      <script src="modernizr-1.5.js"></script>
      <link rel="stylesheet" type="text/css" href="oops.css">

      <script type="text/javascript">

        function categoryselection(obj)
         {
          var selectionlistValue = document.getElementById("l4name_s").value;

           window.location.href = "index.php?category="+selectionlistValue;

         }
   
      </script>

   </head>


   <body>
       <!--
        session_start();
        include 'header.php';
        ?>  -->
         
         <div id="container">
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

         <nav class="horizontal">
            <ul>
               <li><a href="cart.php">CART</a></li>
               <li><a href="Login.php">Login</a></li>
               <li><a href="Register/Register.php">Register</a></li>
               <li><a href="index1.php">Contact</a></li>
               <li><a href="Product/product.php">About Us</a></li>
            </ul>
         </nav>
        
         
       
         

         <section id="main">
            
             <form id="catpost" name="catpost" method="post" action="<?php echo $_SERVER['PHP_SELF']?>">

            
              
             <label for="l4name_s" required="required">Select Category Name</label>

             <select name="l4name_s" id="l4name_s" onchange="categoryselection(this)">
                    
             <?php 

              $db = connect_db();
  
              $query = "SELECT * FROM l4_cat ";
              $result = mysqli_query($db, $query);
              $num_rows = mysqli_num_rows($result);

              for ($i = 0; $i < $num_rows; ++$i)
                {
                  $row = mysqli_fetch_row($result);

                    if (isset($_GET["category"]) && $_GET["category"] == $row[0] )

                      echo '<option value="'.$row[0].'" selected="selected">'.$row[2] .'</option>';

                    else

                      echo '<option value="'.$row[0].'">'.$row[2] .'</option>'; 
                 }
              
              close_db($db);
                          
              ?>
             
              </select>

             </form>

              

              <?php

              if( isset($_GET["category"]) )

               { $db = connect_db();
              
                 $query = "SELECT * FROM product WHERE l4_id = '".$_GET["category"]."'";
                          
                 $result = mysqli_query($db, $query);
                 $num_rows = mysqli_num_rows($result);

                  if ($num_rows>0) 
                  {  
                    for ($i = 0; $i < $num_rows; ++$i)
                          {
                              $row[$i] = mysqli_fetch_row($result);
                              
                               echo '<form id="prdpost'.$i.'" name="prdpost'.$i.'" method="post" action="'.$_SERVER['PHP_SELF'].'">';

                               echo '<div class="product">';
                               echo '<h5> Name :'.$row[$i][3].'</h5>';
                               echo '<h5> Type :'.$row[$i][4].'</h5>';
                               echo '<h5>Brand :'.$row[$i][5].'</h5>';
                               echo '<h5>Model :'.$row[$i][6].'</h5>';
                               echo '<h5>Price :'.$row[$i][7].'$ </h5>';
                               echo '<h5>Order Qty :</h5>';
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
                      
         </section>

      </div>

   </body>

</html>




   