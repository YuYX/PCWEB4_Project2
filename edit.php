<?php
	require "dbconfig/config.php";
?>


<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>blog</title>
		<link rel="stylesheet" href="style.css" type="text/css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
		<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
		<script src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>
		<style>
			.div_center {
				width: 100%; 
				display: flex;
				align-items: center;
				justify-content: center; 
			}
		</style>
	</head>
	<body>
		<?php include("navbar.php"); ?>
		
		<?php
          // fill in the blanks	- Update sql for the restaurant name, description, image
		  $restaurant = $desc = $oldrestaurant = "";
		  if(isset($_POST["edit"])){
			  $oldrestaurant = $_GET["name"];
			  $restaurant = $_POST["restaurant"];
			  $desc = $_POST["description"];
			  $file = addslashes(file_get_contents($_FILES["image"]["tmp_name"]));

			  $query = "UPDATE restaurants SET title = '$restaurant',
			  description = '$desc', Image = '$file' WHERE title = '$oldrestaurant' ";
			  $query_run = mysqli_query($con, $query);

			  if($query_run){
				  echo "<script> alert('Restaurant updated');
				  location.href = 'edit.php';
				  </script>";
			  }else {
				  echo "<script> alert('Restaurant was NOT updated!')</script>";
			  }
		  }

		?>

		<div class = "container">
			<div class = "row">
				<div class = "col-3" id="pname">
					<div>Restaurant Title</div>
					<br>
					<?php
						// fill in the blanks - select hyperlink of restaurant
						$query = "SELECT title FROM restaurants";
						$result = mysqli_query($con, $query);
						while($row = mysqli_fetch_array($result)){
							$name = $row['title'];
							echo "<h4> <a href='edit.php?name=$name'> $name <br> </a> </h4>";
						}	
					?>
				</div>
				
				<div class = "col-9">
					<?php
					// fill in the blanks - select to display restaurant to be edited 
					if(isset($_GET["name"])){
						$name = $_GET["name"]; 
						$query = "SELECT * FROM restaurants WHERE title = '$name' ";
						$query_run = mysqli_query($con, $query);
						$row = mysqli_fetch_array($query_run);

						$restaurantname = $row["title"];
						$restaurantdesc = $row["description"];  

						echo '<form method="post" enctype="multipart/form-data" action="';
						echo htmlspecialchars("edit.php?name=$name");
						echo '">';
						echo '
						<h2> Restaurant </h2>
						<input style="width:200px;" class="restaurant" name="restaurant" value="'.$restaurantname.'"> 
						<h2> Description </h2>
						<textarea class="desc" name="description">"'.$restaurantdesc.'"</textarea>
						<input type="file" name="image"><br>
						<input type="submit" class="div_center" name="edit" value="Submit"><br>
						<img id="hide" src="data:image/jpeg;base64,'.base64_encode($row['photo'] ).'" height="200" />
						</form>';
					} else {
						echo '<h2> Choose a Restaurant to edit! </h2>';
					}
					?>					
				</div>
			</div>
		</div>

	</body>
</html>