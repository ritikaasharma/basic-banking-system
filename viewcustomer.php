<?php
	require_once "dbconnection.php";
	session_start();
	if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
	    header("location: login.php");
	    exit;
	}
?>

<?php

$sender_uname = trim($_SESSION["username"]);


// Define variables and initialize with empty values
$amount = $s_balance = $r_balance  = $password = "";
$sender_uname_err = $receiver_uname_err = $amount_err = $s_balance_err = $r_balance_err = $password_err = "";


 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
	$receiver_uname = $_POST["receiver_uname"];
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }

    if(empty(trim($_POST["amount"]))){
        $amount_err = "Please enter valid amount.";
    } 
    else{
    	$amount = trim($_POST["amount"]);
    }
    
    // Validate credentials
    if(empty($_POST["receiver_uname_err"]) && empty($_POST["$password_err"])){
        
      $s_sql = "SELECT Balance From account WHERE Name = '".$sender_uname."'";
       $sql = "SELECT id, name, password FROM account WHERE Name = ?";
      $sender_balance = mysqli_query($conn, $s_sql);
        
      if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $sender_uname;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $sender_uname, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
				      if(password_verify($password, $hashed_password)){
				      	if ($amount < $sender_balance){
					      	if ($amount > 0){
						        $sb_query = "UPDATE account SET Balance = Balance - '".$amount."'"."WHERE Name = '".$sender_uname."'";
						        mysqli_query($conn, $sb_query);
						        $rb_query = "UPDATE account SET Balance = Balance + '".$amount."'"."WHERE Name = '".$receiver_uname."'";
						        mysqli_query($conn, $rb_query);

						        echo '<script>';
						        echo 'alert("Payment done !");';
						        echo 'window.location.href="allcustomers.php";';
						        echo '</script>';
					    	}
					    	else {
					    		echo '<script>';
						        echo 'alert("Enter valid amount!");';
						        echo 'window.history.back();'; 
						        echo '</script>';
					    	}
					      }
					      else{
					        
					        echo '<script>';
					        echo 'alert("Insufficient balance.");';
					        echo 'window.history.back();'; 
					        echo '</script>';
					      }
					              
					    }
					    else{
					    	echo '<script>';
					        echo 'alert("Incorrect password.");';
					        echo 'window.history.back();'; 
					        echo '</script>';
					    }
					   }
				      }
				    }
				}
		}
      
    // Close connection
    mysqli_close($conn);
}
?>


<!DOCTYPE html>
<html>
<head>
	<title>View Customer</title>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


	<link rel="stylesheet" type="text/css" href="bootstrap-4.5.2-dist/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="bootstrap-4.5.2-dist/css/style.css">

</head>
<body>

	<?php
	$viewid = $_GET['id'];

	$sql = "SELECT * From account WHERE id='".$viewid."'";

	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_array($result);
	?>

                      
        <form class="modal-content container1" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="Post">
			<div class="form-group">
				<h2 style="text-align: center;"><b><?php echo $row['Name'];?>'s profile</b></h2>
				<div class="row content">
					
					<div class="column">
						
						<img src="images/profile.svg" class="profieimage">
					</div>
						
					<div class="column viewprofile">
						ID: <b><?php echo $viewid;?></b><br>
						Name: <b><?php echo $row['Name'];?></b><br>
						Email Id: <b><?php echo $row['Email'];?></b> 
				   </div> 
				</div>
				<hr>
				<div class="login-cred" style="text-align: center;"><b>Transfer Money</b></div>
                </div>
				<label class="login-cred" ><b>Receiver's name</b>
					<select class="form-control" name="receiver_uname"  style="width: 25vw; ">
					  	<option value="" disabled selected>Choose a name</option>
					  	<?php 
					  	$sql1 = "SELECT * From account WHERE Name !='".$sender_uname."'";
					  	$result = mysqli_query($conn, $sql1);
						$resultCheck = mysqli_num_rows($result);
						if ($resultCheck > 0 ) {
							while ($row = mysqli_fetch_assoc($result)) {
									
								?>
					    <option value="<?php echo $row['Name'];?>"><?php echo $row['Name'];
					    	}
					    }
					    ?>
					    </option>
					</select>
				</label><br>
				<label for="amount" class="login-cred form-group "><b>Amount</b>
                <input type="text" placeholder="Enter Amount" name="amount"></label><br>

                <label for="password" class="login-cred form-group"><b>Password</b>
                <input type="password" placeholder="Enter Password" name="password"></label><br>
     
                <input type="submit" class="formbtn submit">
                <input type="reset" class="formbtn reset">
			
			</form>
		</div>

	
	<script type="text/javascript" src="bootstrap-4.5.2-dist/js/jquery-3.5.1.min.js"></script>
	<script type="text/javascript" src="bootstrap-4.5.2-dist/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="bootstrap-4.5.2-dist/js/script.js"></script>
</body>
</html>