<?php
	include "dbconnection.php";
	session_start();
	if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
	    header("location: login.php");
	    exit;
	}
	
?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="bootstrap-4.5.2-dist/css/bootstrap.min.css" >
	<link rel="stylesheet" type="text/css" href="bootstrap-4.5.2-dist/css/style.css">
	<title>All customers</title>
	
</head>
<body>

	<nav class="navbar navbar-dark navbar-custom navbar-expand-sm  fixed-top">
		<div class="container-fluid">

			<button id="navbarToggle" class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon" ></span>
			</button>
		    	

			<div class="collapse navbar-collapse" id="navbarSupportedContent">
			    <ul class="navbar-nav mr-auto">
			      <li >
			        <a class="nav-link nav-text" href="welcome.php">Home</a></li>
			      <li>
			      	<a class="nav-link nav-text" href="about.html">About</a>
			      </li>
			      <li class="nav-item active">
			      	<a class="nav-link nav-text" href="#">All customers<span class="sr-only">(current)</span></a>
			      </li>
			      	
			    </ul>
			</div><!--end of buttons-->
			
		  
        </div><!--end of container fluid-->

	</nav><br>
	
	</div>

	<div class="container">
		<table>
			<th>ID</th>
			<th>Userame</th>
			<th>Email ID</th>
			<th>Balance</th>
			<th></th>

					
			<?php
				
			$sql = "SELECT * From account";
			$result = mysqli_query($conn, $sql);
			$resultCheck = mysqli_num_rows($result);

			if ($resultCheck > 0 ) {
				while ($row = mysqli_fetch_assoc($result)) {
								
					?>
					<tr>
						<td><?php echo $row['ID'];?></td>
						<td><?php echo $row['Name'];?></td>
						<td> <?php echo $row['Email'];?></td>  
						<td><?php echo $row['Balance']; ?></td> 
						<?php 
						if ($row['Name'] != $_SESSION["username"]){?>
							<td><button class="pay-btn" name = "<?php echo $viewid?>"><a href = 'viewcustomer.php?id=<?php echo $row['ID'] ;?>' >Pay</a></button></td>
							<?php
						}
						else {?>
							<td><button class="pay-btn" name = "<?php echo $viewid?>"><a href = 'viewprofile.php' >View</a></button></td>
						<?php
					}?>
					</tr>
				<?php 
				}
			}
			else{
				echo '<script>alert("No customers available.");
						window.location.href="welcome.php";</script>';
			}
		    ?>

		  
		</table>
		
	</div>
	
	<script type="text/javascript" src="bootstrap-4.5.2-dist/js/jquery-3.5.1.min.js"></script>
	<script type="text/javascript" src="bootstrap-4.5.2-dist/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="bootstrap-4.5.2-dist/js/script.js"></script>
</body>
</html>

