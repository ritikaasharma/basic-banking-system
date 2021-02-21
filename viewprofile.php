<?php
	require_once "dbconnection.php";
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
	<title>View Customer</title>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


	<link rel="stylesheet" type="text/css" href="bootstrap-4.5.2-dist/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="bootstrap-4.5.2-dist/css/style.css">

</head>
<body>
	<?php
	// session_start();
	// $viewid = $_GET['id'];

	$sql = "SELECT * From account WHERE Name='".$_SESSION["username"]."'";

	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_array($result);
	?>
	<div class="modal-content container1">
		<h2 ><b>Your profile</b></h2><br>
				<div class="viewprofile">
					<img src="images/profile.svg" class="profieimage">
					<br>
						ID: <b><?php echo $row['ID'];?></b><br>
						Name: <b><?php echo $row['Name'];?></b><br>
						Email Id: <b><?php echo $row['Email'];?> </b><br>
						Balance: <b><?php echo $row['Balance'];?> </b>
				   </div> <br><br><br>
		<button type="logout" class="formbtn" style="background-color: red;"><a href="logout.php" style="color: white;"> Log out</a></button>
	</div>
	
	</div>
	<script type="text/javascript" src="bootstrap-4.5.2-dist/js/jquery-3.5.1.min.js"></script>
	<script type="text/javascript" src="bootstrap-4.5.2-dist/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="bootstrap-4.5.2-dist/js/script.js"></script>
</body>