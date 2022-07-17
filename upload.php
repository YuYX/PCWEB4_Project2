<?php
	require "dbconfig/config.php";
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>blog</title>
		<link rel="stylesheet" href="style.css" type="text/css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
		<script src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>

	</head>
	<body>
		<?php include("navbar.php"); ?>
		<?php
			// fill in the blanks - upload
			$restaurant = $desc = "";
			if(isset($_POST["upload"])){
				
				$restaurant = $_POST["restaurant"];
				$desc = $_POST["description"];
				$file = addslashes(file_get_contents($_FILES["image"]["tmp_name"]));

				$query = "INSERT INTO restaurants (title, description, photo)
				 VALUES('$restaurant','$desc','$file')";
				$query_run = mysqli_query($con, $query);

				if($query_run){
					echo "<script> alert('Restaurant added.')</script>";
				}else{
					//echo "<script> alert('Restaurant NOT added.')</script>"; 
					printf("Error: %s\n", mysqli_error($con)); 
				}
		}

		?>
		<div class="container-fluid">
			<div class="row">
				<div class="col-2"></div>
				<div class="col-8">
					<form method = "post" enctype="multipart/form-data" 
					action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
						<h2>Restaurant</h2>
						<input style="width:400px;" class="restaurant" type="text" name="restaurant">
						<h2>Description</h2>
						<textarea class="desc" name="description"></textarea>
						<input type="file" name="image" accept="image/png, image/jpeg">
						<input type="submit" value="Submit" name="upload">
					</form>
				</div>
				<div class="col-2"></div>
			</div>
		</div>

	</body>
</html>