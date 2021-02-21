<?php
	require_once "dbconnection.php";
	// include 'index.php';
	session_start();
	if(isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] == true){
	    header("location: welcome.php");
	    exit;
	}
?>
<?php
	// Define variables and initialize with empty values
	$username = $email = $balance = $password = $confirm_password = "";
	$username_err = $email_err = $balance_err = $password_err = $confirm_password_err = "";

	function checkemail($str) {
         return (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? FALSE : TRUE;
   }

	// Processing form data when form is submitted
	if($_SERVER["REQUEST_METHOD"] == "POST"){


	    // Validate username
	    if(empty(trim($_POST["username"]))){
	        $username_err = "Please enter a username.";
	    } else{
	        // Prepare a select statement
	        $sql = "SELECT ID FROM account WHERE Name = ?";
	        
	        if($stmt = mysqli_prepare($conn, $sql)){
	            // Bind variables to the prepared statement as parameters
	            mysqli_stmt_bind_param($stmt, "s", $param_username);
	            
	            // Set parameters
	            $param_username = trim($_POST["username"]);
	            
	            // Attempt to execute the prepared statement
	            if(mysqli_stmt_execute($stmt)){
	                /* store result */
	                mysqli_stmt_store_result($stmt);
	                
	                if(mysqli_stmt_num_rows($stmt) == 1){
	                    $username_err = "This username is already taken.";
	                } else{
	                    $username = trim($_POST["username"]);
	                }
	            } else{
	                echo "Oops! Something went wrong. Please try again later.";
	            }

	            // Close statement
	            mysqli_stmt_close($stmt);
	        }
	    }

	    if(empty(trim($_POST["email"])) or (!checkemail(trim($_POST["email"])))){
	        $email_err = "Please enter a valid email id.";
	    } 
	    else {
	    	$email = trim($_POST["email"]);
	    }

	    if(empty(trim($_POST["balance"]))){
	        $balance_err = "Please enter a value.";
	    } 
	    else {
	    	$balance = trim($_POST["balance"]);
	    }
	 
	    
	    // Validate password
	    if(empty(trim($_POST["password"]))){
	        $password_err = "Please enter a password.";     
	    } elseif(strlen(trim($_POST["password"])) < 6){
	        $password_err = "Password must have atleast 6 characters.";
	    } else{
	        $password = trim($_POST["password"]);
	    }
	    
	    // Validate confirm password
	    if(empty(trim($_POST["confirm_password"]))){
	        $confirm_password_err = "Please confirm password.";     
	    } else{
	        $confirm_password = trim($_POST["confirm_password"]);
	        if(empty($password_err) && ($password != $confirm_password)){
	            $confirm_password_err = "Password did not match.";
	        }
	    }
	    
	    // Check input errors before inserting in database
	    if(empty($username_err) && empty($email_err) && empty($balance_err) && empty($password_err) && empty($confirm_password_err)){
	        
	        // Prepare an insert statement
	        $sql = "INSERT INTO account (Name, Email, Balance, password) VALUES (?, ?, ?, ?)";
	         
	        if($stmt = mysqli_prepare($conn, $sql)){

	        	// Set parameters
	            $param_username = $username;
	            $param_email = $email;
	            $param_balance = $balance;
	            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash

	            // Bind variables to the prepared statement as parameters
	            mysqli_stmt_bind_param($stmt, "ssss", $param_username, $param_email, $param_balance, $param_password);
	            
	            
	            
	            // Attempt to execute the prepared statement
	            if(mysqli_stmt_execute($stmt)){
	                // Redirect to login page
	                header("location: login.php");
	            } else{
	                echo "Something went wrong. Please try again later.";
	            }

	            // Close statement
	            mysqli_stmt_close($stmt);
	        }
	    }
	    
	    // Close connection
	    mysqli_close($conn);
	}	
?>


<!DOCTYPE html>
<html>
<head>
	<title>Banking system</title>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


	<link rel="stylesheet" type="text/css" href="bootstrap-4.5.2-dist/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="bootstrap-4.5.2-dist/css/style.css">
</head>
<body>
	<nav class="navbar navbar-dark navbar-custom navbar-expand-sm  fixed-top">
		<div class="container-fluid">

			<button id="navbarToggle" class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon" ></span>
			</button>
		    	

			<div class="collapse navbar-collapse" id="navbarSupportedContent">
			    <ul class="navbar-nav mr-auto">
			      <li class="nav-item active">
			        <a class="nav-link nav-text" href="#">Home<span class="sr-only">(current)</span></a>
			      </li>
			      <li>
			      	<a class="nav-link nav-text" href="about.html">About</a>
			      </li>
			      <li>
			      	<a class="nav-link nav-text" href="allcustomers.php">All customers</span></a>
			      </li>
			    </ul>
			</div><!--end of buttons-->
			    <button onclick="document.getElementById('id01').style.display='block'" class="btn btn-outline-success navbar-text my-menu" type="button">Login/ Sign Up</button>

					<div id="id01" class="modal container-fluid">
					  
					  <form class="modal-content animate1" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
					    <div class="imgcontainer">
					      <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close">&times;</span>
					      <div class="login-cred" style="text-align: center;"><b>Create your account</b></div>
					    </div>


					 	<div class="container">
						    <label for="username" class="login-cred form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>"><b>Userame</b></label>
						    <input type="text" placeholder="Enter Userame" name="username" value = "<?php echo $username; ?>">
						    <span class="help-block"><?php echo $username_err; ?></span>
            				

						    <label for="email" class="login-cred form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>"><b>Email ID</b></label>
						    <input type="text" placeholder="Enter Email ID" name="email" >
						    <span class="help-block"><?php echo $email_err; ?></span>
            				
						    <label for="balance" class="login-cred form-group <?php echo (!empty($balance_err)) ? 'has-error' : ''; ?>"><b>Balance</b></label>
						    <input type="text" placeholder="Enter Balance" name="balance">
						    <span class="help-block"><?php echo $balance_err; ?></span>
            				

	            			<div>
							    <label for="password" class="login-cred form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>"><b>Password</b></label>
							    <input type="password" placeholder="Enter Password" name="password">
							    <span class="help-block"><?php echo $password_err; ?></span>
						    </div>

						    <div> 
							    <label for="cpassword" class="login-cred form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>"><b>Confirm Password</b></label>
							    <input type="password" placeholder="Enter Confirm Password" name="confirm_password">
							    <span class="help-block"><?php echo $confirm_password_err; ?></span>
						   	</div>

						    <div>
						     <ul>
							      <input type="submit" class="formbtn submit" >
							      <input type="reset" class="formbtn reset">
							      <p>Already have an account? <a href="login.php">Login here</a>.</p>
							  </ul>
						    </div>
						</div>
					  </form>
					</div>
        </div><!--end of container fluid-->
	</nav>
	
	<div class="container-fluid">
		<div class="home-content ">
			<h1>The <br> Sparks <br> Foundation <br> Bank</h1>
		</div>
		<button class="home-btn"><a href="allcustomers.php"> Make a payment</a></button>
     
     <footer class="page-footer ">

		<div >&copy 2021. Made by <b>RITIKA SHARMA</b> <br> The Sparks Foundation</div>

	</footer>
	</div>


	<script type="text/javascript" src="bootstrap-4.5.2-dist/js/jquery-3.5.1.min.js"></script>
	<script type="text/javascript" src="bootstrap-4.5.2-dist/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="bootstrap-4.5.2-dist/js/script.js"></script>

</body>
</html>
