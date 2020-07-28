<?php 
 	// File ini untuk koneksi ke database, atur timezone, dan konfigurasi lain pada saat page loading  

	// https://www.geeksforgeeks.org/php-ob_start-function/
    // Let’s take a quick recap. PHP is an interpreted language thus each statement is executed one after another, therefore PHP tends to send HTML to browsers in chunks thus reducing performance. Using output buffering the generated HTML gets stored in a buffer or a string variable and is sent to the buffer to render after the execution of the last statement in the PHP script.
	ob_start();

	// Init session untuk memulai menyimpan nilai variable
	// UNTUK $_SESSION variable 
	session_start();

	// Timezone 
	$timezone = date_default_timezone_set('Asia/Jakarta');

	// Hubungkan ke DB
	// mysql_connect("port/server", username(def:root), password(def : ""), nama database)
	$con = mysqli_connect("localhost", "root", "" , "social");

	// Check koneksi database
	if(mysqli_connect_errno()){
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
  		exit();
	} 
?>