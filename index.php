<?php
	require "dbconfig/config.php";
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Restaurants Reviews</title>
		<link rel="stylesheet" href="style.css" type="text/css">
	    <link rel="stylesheet" href="style.css" type="text/css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" ></script>
        <script src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>

	</head>
	<body>
		<?php include("navbar.php"); ?>

		<div class = "container">
			<div class = "row">
				<div class = "col-3" id="pname">
					<div style="font-weight:bold;
							    display:inline-flex;
								color:blueviolet; 
								font-size:18px;">Restaurant List</div>	  
					
					<?php
					    // fill in the blanks	- Select SQL restaurant name
						$query = "SELECT title FROM restaurants";
		  				$result = mysqli_query($con, $query);

						while($row = mysqli_fetch_array($result)){
							$name = $row['title'];
							echo "<h4> <a href='index.php?name=$name'> $name <br> </a> </h4>";
						}
						if (!$result){
							printf("Error: %s\n", mysqli_error($con));
							exit();
						}
					?>
				</div>
				
				<div class = "col-6">
					<?php
					    // fill in the blanks	- restaurant is click, show the description
						if(isset($_GET["name"])){
							$name = $_GET["name"];
							$query = "SELECT description FROM restaurants WHERE title = '$name' ";
							$query_run = mysqli_query($con, $query);
							$row = mysqli_fetch_array($query_run);
							$desc = $row["description"]; 

							echo
								"<h2> $name </h2>
								<p> $desc <br> </p>";
						}else {
							$query = "SELECT * FROM restaurants";
		  					$result = mysqli_query($con, $query);
							if($row = mysqli_fetch_array($result))
							{
								$name = $row['title'];
								$desc = $row['description'];
								echo
								"<h2> $name </h2>
								<p> $desc <br> </p>";
							}
							//echo "<h2> Choose a restaurant, or add a restaurant! </h2>";
						}	 

						// fill in the blanks	-  delete restaurant
						$name = "";
						if(isset($_POST["delete"])){
							$name = $_GET["name"];

							$query = "DELETE FROM restaurants WHERE title = '$name' ";
							$query_run = mysqli_query($con, $query);

							if($query_run){
								echo "<script> alert('restaurant deleted.');
								location.href = 'index.php';
								</script>";
							}
						}
					
					    // fill in the blanks	- display the image
						if(isset($_GET["name"])){
							$name = $_GET["name"];
							$query = "SELECT photo FROM restaurants WHERE title = '$name' ";
							$query_run = mysqli_query($con, $query);
							$row = mysqli_fetch_array($query_run);     

							echo '
							<form method= "post" action ="index.php?name='.$name.'" >
							<div class="btns">
							<input type="button" value="Hide Restaurant Photo" id="hidebtn">
							<input type="submit" name="delete" value="Delete Restaurant">
							</div>
							<img id="hide" src="data:image/jpeg;base64,'.base64_encode($row['photo'] ).'" height="200" />
							</form>';
						}else{
							$query = "SELECT photo FROM restaurants";
		  					$result = mysqli_query($con, $query);
							if($row = mysqli_fetch_array($result))
							{
								echo '
								<form method= "post" action ="index.php?name='.$name.'" >
								<div class="btns">
								<input type="button" value="Hide Restaurant Photo" id="hidebtn">
								<input type="submit" name="delete" value="Delete Restaurant">
								</div>
								<img id="hide" src="data:image/jpeg;base64,'.base64_encode($row['photo'] ).'" height="200" />
								</form>';
							}
						}
					?>
				</div>
			</div>
		</div>

		<script>
			$("#hidebtn").click(function(){
			$("#hide").toggle(100);
			if($('#hidebtn').val() === 'Hide Restaurant Photo'){
				$('#hidebtn').val("Show Restaurant Photo");
			}else{
				$('#hidebtn').val("Hide Restaurant Photo");
			}
		});
		</script>
		
	</body>
</html>