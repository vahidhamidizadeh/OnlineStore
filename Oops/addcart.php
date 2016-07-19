

<?php
	


 
    
            // The following code will drop a cookie expiring in 30 days
            // 86400 is the number of seconds in a day
            // To delete a cookie, just set the expiration in the past (eg: time() - 1)
    
            // Display session variables set in the previous page
    
                

                  $prd_cookie ="oopscart|".$_POST['prdid']."|".$_POST['clrid'];
                  $qty_cookie ="oopscart|".$_POST['prdid']."|".$_POST['clrid']."|".$_POST['qty'];
                  setcookie($prd_cookie, $qty_cookie, time() + 8640*30, "/");
                  
           
      
    
 
?>



