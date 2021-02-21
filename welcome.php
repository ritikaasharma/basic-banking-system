<?php
	// include "dbconnection.php";
	// include 'index.php';
	session_start();
	if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
	    header("location: login.php");
	    exit;
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
	<nav class="navbar navbar-dark navbar-custom navbar-expand-sm fixed-top justify-content-center">
		
		<div class="container-fluid">
			
    		<button id="navbarToggle" class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon" ></span>
			</button>
			
			<div class="collapse navbar-collapse" id="navbarSupportedContent" >
			    <ul class="navbar-nav">
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
			</div>
			<div class="dropdown my-menu ml-auto">
				<a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="images/profile.svg"><br>
					<?php
						echo ($_SESSION["username"]);
					?> 
				</a>
				<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
						  <a class="dropdown-item" href="viewprofile.php">View profile</a>
						    <!-- <a class="dropdown-item" href="resetpwd.php">Reset password</a> -->
						  <a class="dropdown-item btn btn-danger" href="logout.php">Log out</a>
					</div>
			</div>
		  
        </div>
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

