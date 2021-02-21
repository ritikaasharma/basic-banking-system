<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him/her to welcome page
// if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
//     header("location: welcome.php");
//     exit;
// }
 
// Include config file
require_once "dbconnection.php";
 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT id, name, password FROM account WHERE name = ?";
        
        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username; 
                                                     
                            
                            // Redirect user to welcome page
                            header("location: welcome.php");
                        } else{
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $username_err = "No account found with that username.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
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
<body class="allcustomers-body">
    
                <<!-- button onclick="document.getElementById('id01').style.display='block'" class="btn btn-outline-success navbar-text" type="button">Login/ Sign Up</button> -->

                    <div class="container-fluid">
                      
                      <form class="modal-content" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="imgcontainer">
                          <a class="close" title="Close" href="index.php">&times;</a>
                          <div class="login-cred" style="text-align: center;"><b>Log-in</b></div>
                          <!-- <img src="img_avatar2.png" alt="Avatar" class="avatar"> -->
                        </div>

                        <div class="container">
                            <!-- <div>  -->
                              <label for="username" class="login-cred form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>"><b>Userame</b></label>
                              <input type="text" placeholder="Enter Userame" name="username" value = "<?php echo $username; ?>">
                              <span class="help-block"><?php echo $username_err; ?></span>
                            <!-- </div> -->


                              <label for="password" class="login-cred form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>"><b>Password</b></label>
                              <input type="password" placeholder="Enter Password" name="password">
                              <span class="help-block"><?php echo $password_err; ?></span>

                          <div>
                            <ul>
                                <input type="submit" class="formbtn submit" >
                                <!-- </button> -->
                                <input type="reset" class="formbtn reset">
                                <p>Don't have an account? <a href="index.php">Sign up here</a>.</p>
                            </ul>
                          </div>
                           
                           <!-- <label><input type="checkbox" checked="checked" name="remember" /> Remember me</label> -->
                        </div>
                        

                      </form>
                    </div>

            


    <script type="text/javascript" src="bootstrap-4.5.2-dist/js/jquery-3.5.1.min.js"></script>
    <script type="text/javascript" src="bootstrap-4.5.2-dist/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="bootstrap-4.5.2-dist/js/script.js"></script>

</body>
</html>