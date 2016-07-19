<?php
	
	function connect_db()
	{
		$db_hostname = "localhost";
		$db_name     = "oops";
		$db_username = "root";
		$db_password = "";

		$db = mysqli_connect($db_hostname, $db_username, $db_password, $db_name);

		if($db->connect_errno > 0)
		{
    		die('Unable to connect to database [' . $db->connect_error . ']');
		}

		return $db;
	}

	function close_db($db)
	{
		$db->close();
	}

	function insert_new_user($username, $password,$email)
	{
		// 1 - Make sure the username is available
		// 2 - Generate a random salt to encode the password
		// 3 - Encrypt password
		// 4 - Insert user in database
		$db = connect_db();

		// Query Database to validate user
		$query = "SELECT * FROM credential WHERE crd_login_name='". $username ."'";
		$result = mysqli_query($db, $query);

		// 1 - If user doesn't exist in the database
		if (mysqli_num_rows($result) == 0)
		{
			// 2 - Random salt
			$salt = mcrypt_create_iv(32, MCRYPT_DEV_URANDOM);
			
			// 3 - Encrypt password with salt
			$encrypted_pw = crypt($password, $salt);

			// 4 - Insert user in database
			// TODO - DB Insertion Validation
			$query = "INSERT INTO credential (`CRD_ID`, `CRD_LOGIN_NAME`, `CRD_PASS`, `CRD_SALT`,`CRD_EMAIL`) VALUES (NULL, '". $username ."', '". $encrypted_pw."', '". $salt ."', '". $email ."');";
			mysqli_query($db, $query);
            $crdid = mysqli_insert_id($db);
            close_db($db);
            echo "<h1> Congratulation New User has created! </h1>";
			return $crdid;


		}
		else
		{
			echo "<h1> Failed to create user, username already taken! Please try another one! </h1>";
		}

		close_db($db);
	}




	function validate_user($username, $password)
	{
		
		$found = 0;
		$db = connect_db();
       
		
		$query = "SELECT * FROM credential WHERE crd_login_name='". $username."'";
		$result = mysqli_query($db, $query);
        
		
		if (mysqli_num_rows($result) == 1) 
		{  
		    $row = mysqli_fetch_array($result);
			$salt = $row[3];
			$encrypted_pw = crypt($password, $salt);
		   	if ($encrypted_pw == $row[2])
			{
				$found = 1;
			}
		}

		// Close connection with database
		close_db($db);

		return $found ;
	}



	function insert_new_address($stnum, $street,$unum,$city,$state,$zip,$country,$phone)
	{
		
		$db = connect_db();

		
			$query = "INSERT INTO address (`ADD_ID`, `ADD_STNO`, `ADD_ADDRESS`, `ADD_UNO`,`ADD_CITY`, `ADD_PROVINCE`, `ADD_PCODE`,`ADD_COUNTRY`,`ADD_PHONE`) VALUES (NULL, '". $stnum ."', '". $street."', '". $unum ."', '". $city ."', '". $state ."', '". $zip."', '". $country ."', '". $phone ."');";

			mysqli_query($db, $query);
			$addid = mysqli_insert_id($db);
			close_db($db);
			return $addid;
	
	}


	
	function insert_new_customer($fname,$mname,$lname,$addid,$crdid)
	{
		
		$db = connect_db();

		
			$query = "INSERT INTO customer (`CUS_ID`, `CUS_FNAME`, `CUS_MNAME`, `CUS_LNAME`,`ADD_ID`, `CRD_ID`) VALUES (NULL, '". $fname ."', '". $mname."', '". $lname ."', '". $addid ."', '". $crdid ."');";

			mysqli_query($db, $query);
	

		close_db($db);
	}


	function insert_new_category($l4name)
	{
		
		$db = connect_db();
	
		$query = "SELECT * FROM l4_cat WHERE l4_name='". $l4name ."'";
		$result = mysqli_query($db, $query);

		
		if (mysqli_num_rows($result) == 0)
		{
					
			$query = "INSERT INTO l4_cat (`L4_ID`, `L3_ID`, `L4_NAME`) VALUES (NULL,0,'". $l4name."');";
			mysqli_query($db, $query);
            $l4id = mysqli_insert_id($db);
            close_db($db);
			return $l4id;


		}
		else
		{
			echo "Failed to create category, category already exist!";
		}

		close_db($db);
	}

	function insert_new_color($clrname)
	{
		
		$db = connect_db();
	
		$query = "SELECT * FROM color WHERE clr_name='". $clrname ."'";
		$result = mysqli_query($db, $query);

		
		if (mysqli_num_rows($result) == 0)
		{
					
			$query = "INSERT INTO color (`CLR_ID`,`CLR_NAME`) VALUES (NULL,'". $clrname."');";
			mysqli_query($db, $query);
            $clrid = mysqli_insert_id($db);
            close_db($db);
			return $clrid;


		}
		else
		{
			echo "Failed to create color, color already exist!";
		}

		close_db($db);
	}

	

    function insert_new_product($clrname_s,$l4name_s,$prdname,$prdtype,$prdbrand,$prdmodel,$prdprice,$prdimage,$prdqnty)
	{
		
		$db = connect_db();
	
		$query = "SELECT * FROM product WHERE prd_name='". $prdname ."'";
		$result = mysqli_query($db, $query);

		
		if (mysqli_num_rows($result) == 0)
		{
					
			$query = "INSERT INTO product (`PRD_ID`,`CLR_ID`,`l4_ID`,`PRD_NAME`,`PRD_TYPE`,`PRD_BRAND`,`PRD_MODEL`,`PRD_PRICE`,`PRD_IMAGE`,`PRD_QNTY`) VALUES (NULL,'". $clrname_s."','". $l4name_s."','". $prdname."','". $prdtype."','". $prdbrand."','". $prdmodel."','". $prdprice."','". $prdimage."','". $prdqnty."');";
			mysqli_query($db, $query);
            $prdid = mysqli_insert_id($db);
            close_db($db);
            
			return $prdid;


		}
		else
		{
			echo "Failed to create product, product already exist!";
		}

		close_db($db);
	}


    function insert_new_color_list($prdid,$clrname_s)
	{
		
		$db = connect_db();
	
						
			$query = "INSERT INTO color_list (`PRD_ID`,`CLR_ID`) VALUES ('". $prdid."','". $clrname_s."');";
			mysqli_query($db, $query);
            
          
		close_db($db);
	}


    function insert_new_invoice($status)
     {  
     	$invid=0;
        
	       $db = connect_db();
		     
			$query = "SELECT * FROM credential WHERE crd_login_name='".$_SESSION['user']."'";
			$result = mysqli_query($db, $query);
	        $row = mysqli_fetch_array($result);	

			$query = "INSERT INTO invoice (`CRD_ID`,`INV_DATE`,`INV_STAT`) VALUES ('". $row[0]."',CURRENT_DATE,'". $status."');";
			mysqli_query($db, $query);

			$invid = mysqli_insert_id($db); 
	        close_db($db);
	     
        
        return $invid;
      }


	function insert_new_invoice_list($invid,$current)
     {
     	$db = connect_db();
	    foreach ($current as $value)
        { 
              
		$query = "SELECT * FROM product WHERE prd_id='". $value['prdid'] ."' AND  clr_id='". $value['clrid'] ."' ";
		$result = mysqli_query($db, $query);

		
		  if (mysqli_num_rows($result) == 1)
			{
				$row = mysqli_fetch_array($result);


				$query = "INSERT INTO invoice_list (`PRD_ID`,`CLR_ID`,`INV_ID`,`INV_LST_QNTY`,`INV_LST_PRICE`) VALUES ('".$value['prdid']."','".$value['clrid']."', '".$invid."' ,'".$value['invqty']."','".$value['invqty']*$row[7]."');";
				mysqli_query($db, $query);

				if ($value['invqty'] <= $row[9] )
				{
					setcookie("oopscart|".$value['prdid']."|".$value['clrid'], "oopscart|".$value['prdid']."|".$value['clrid']."|".$value['invqty'], time()-3600, "/");
					$newqty=$row[9]-$value['invqty'];
                    $query = "UPDATE product SET `PRD_QNTY`='".$newqty."' WHERE `PRD_ID`='".$row[0]."' AND `CLR_ID`='".$row[1]."'";
				    mysqli_query($db, $query);
		        }
		        else
		        {
                  	$newqty=$value['invqty']-$row[9];

                    $query = "UPDATE product SET `PRD_QNTY`=0 WHERE `PRD_ID`='".$row[0]."' AND `CLR_ID`='".$row[1]."'";
				    mysqli_query($db, $query);

				    setcookie("oopscart|".$value['prdid']."|".$value['clrid'], "oopscart|".$value['prdid']."|".$value['clrid']."|".$newqty, time()+3600, "/");
		        } 	

	        }

       }
       close_db($db);

       /*foreach ( $current as $value)
	      {    
	       setcookie("oopscart|".$value['prdid']."|".$value['clrid'], "oopscart|".$value['prdid']."|".$value['clrid']."|".$value['invqty'], time() - 3600, "/");
	      }*/
   }

?>