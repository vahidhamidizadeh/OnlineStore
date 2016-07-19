<!DOCTYPE html>
<html>

   <head>
 
      <meta charset="UTF-8" />
      <title>New user Registeration</title>
      <script src="modernizr-1.5.js"></script>
      <link href="sb.css" rel="stylesheet" type="text/css" />
      <link rel="stylesheet" type="text/css" href="Register.css">

   </head>


   <body>
    
      <?php
       
       session_start();
     
       require_once("../db.php"); 

     
      if (isset($_POST['loginname']) && isset($_POST['password']) && isset($_POST['email']))
        {
          $crdid=insert_new_user($_POST['loginname'], $_POST['password'],$_POST['email']);
        }
       
       if (isset($_POST['stnum']) && isset($_POST['street']) && isset($_POST['unum']) && isset($_POST['city']) && isset($_POST['state']) && isset($_POST['zip'])&& isset($_POST['country']) && isset($_POST['phone']) && isset($crdid))
        {
          $addid=insert_new_address($_POST['stnum'], $_POST['street'],$_POST['unum'],$_POST['city'], $_POST['state'],$_POST['zip'], $_POST['country'],$_POST['phone']);
           
        } 


       if (isset($_POST['fname']) && isset($_POST['mname']) && isset($_POST['lname']) && isset($addid) && isset($crdid))
        { 
          insert_new_customer($_POST['fname'], $_POST['mname'],$_POST['lname'],$addid,$crdid);
          header("Refresh:3;url=../login.php");
        }

      ?>

      <section>

         <h1>Registration Form</h1>

         
         <form id="post" name="post" method="post" action="<?php echo $_SERVER['PHP_SELF']?>">
         
         <fieldset id="Logininfo">
         <legend>Login Information (required)</legend>

         <label for="loginname">Login Name</label> 
         <input name="loginname" id="loginname" type="text" required="required"></input>
         <br/>
         <label for="password">Password</label> 
         <input name="password" id="password" type="password" required="required"></input>
         <br/>
         <label for="email">Contact Email</label> 
         <input name="email" id="email" type="email" required="required" ></input>

         </fieldset>


         <fieldset id="Personalinfo">
         <legend>Personal Information (required)</legend>

         <label for="fname">First Name</label> 
         <input name="fname" id="fname" type="text" required="required"></input>
         <br/>
         <label for="mname">Middle Name</label> 
         <input name="mname" id="mname" type="text" required="required"></input>
         <br/>
         <label for="lname">Last Name</label> 
         <input name="lname" id="lname" type="text" required="required"></input>
         <br/>

         </fieldset>

         <fieldset id="Address">
         <legend>Address Information (required)</legend>

         <label for="stnum">Street Number</label> 
         <input name="stnum" id="stnum" type="text" required="required"></input>
         <br/>
         <label for="street">Street</label> 
         <input name="street" id="street" type="text" required="required"></input>
         <br/>
         <label for="unum">Unit Number</label> 
         <input name="unum" id="unum" type="text" required="required"></input>
         <br/>
         <label for="city">City</label> 
         <input name="city" id="city" type="text" required="required"></input>
         <br/>
         <label for="state" required="required">State</label> 
         <select name="state">
         <option value="ON">Ontario</option>
         <option value="QC">Quebec</option>
         <option value="NS">Nova Scotia</option>
         <option value="NB">New Brunswick</option>
         <option value="MB">Manitoba</option>
         <option value="BC">British Columbia</option>
         <option value="PE">Prince Edward</option>
         <option value="SK">Saskatchewan</option>
         <option value="AB">Alberta</option>
         <option value="NL">Newfoundland</option>
         </select>
         <br/>
         <label for="zip">ZIP/Postal Code</label> 
         <input name="zip" id="zip" type="text" pattern="^\d{5}(\-\d{4})?$" required="regex"></input>
         <br/>
         <label for="country">Country</label> 
         <input name="country" id="country" type="text" value="Canada" required="required"></input>
         <br/>
         <label for="phone">Phone</label> 
         <input name="phone" id="phone" type="text" pattern="^\d{10}$|^(\(\d{3}\)\s*)?\d{3}[\s-]?\d{4}$" required="regex"></input>
         <br/>

         </fieldset>

         <button type="submit">Register</button>  
         </form>
        
      </section>

   </body>

</html>
