<?php 
	// Hubungkan dengan database
	// mysql_connect("port/server", username(def:root), password(def : ""), nama database)
	$con = mysqli_connect("localhost", "root", "" , "social");

	// Check koneksi database
	if(mysqli_connect_errno()){
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
  		exit();
	}

	// Query untuk menambahkan data ke dalam tabel 
	// mysqli_query(koneksi, query)
	// $query = mysqli_query($con, "INSERT INTO test VALUES(NULL, 'Arnold')");

?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Socmed</title>
</head>
<body>
	Halo halo 
</body>
</html>