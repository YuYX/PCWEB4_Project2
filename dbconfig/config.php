<?php
$db_host = 'localhost';
$db_user = 'root';
$db_password = ''; // set to root for MAMP
$db_db = 'restaurant_reviews'; // check against your db name

$mysqli = @new mysqli(
    $db_host,
    $db_user,
    $db_password,
    $db_db
);

if ($mysqli->connect_error) {
    echo 'Errno: ' . $mysqli->connect_errno;
    echo '<br>';
    echo 'Error: ' . $mysqli->connect_error;
    exit();
}

$con = $mysqli; // we use $con in our code

?>