<?php 
	// Init session untuk memulai menyimpan nilai variable
	session_start();

	// Hubungkan ke DB
	$con = mysqli_connect("localhost", "root", "" , "social");

	// Check koneksi database
	if(mysqli_connect_errno()){
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
  		exit();
	} 

	// Declaring variables to prevent errors
	$fname = ""; //Firstname
	$lname = ""; //Lastname
	$em = ""; //Email
	$em2 = ""; //Email2
	$password = ""; //Password
	$password2 = ""; //Password2
	$date = ""; //Sign up Date
	$error_array = array(); //Holds error messages

	// Check apakah submit button sudah ditekan 
	// $_POST['name'(yang ada di input tag)]
	if(isset($_POST['reg_button'])){

		// Registration form values 
		// strip_tag untk trim semua html tag

		// Firstname
		$fname = strip_tags($_POST["reg_fname"]); //removes HTML tag
		$fname = str_replace(' ', '', $fname); //removes spaces
		$fname = ucfirst(strtolower($fname)); //capitalizes just the first later
		$_SESSION['reg_fname'] = $fname; //Simpan firstname di dalam session variable 

		// Lastname
		$lname = strip_tags($_POST["reg_lname"]); //removes HTML tag
		$lname = str_replace(' ', '', $lname); //removes spaces
		$lname = ucfirst(strtolower($lname)); //capitalizes just the first later
		$_SESSION['reg_lname'] = $lname; //Simpan lastname di dalam session variable 

		// Email 
		$em = strip_tags($_POST["reg_email"]); //removes HTML tag
		$em = str_replace(' ', '', $em); //removes spaces
		$em = ucfirst(strtolower($em)); //capitalizes just the first later
		$_SESSION['reg_email'] = $em; //Simpan email di dalam session variable 

		//Email 2 
		$em2 = strip_tags($_POST["reg_email2"]); //removes HTML tag
		$em2 = str_replace(' ', '', $em2); //removes spaces
		$em2 = ucfirst(strtolower($em2)); //capitalizes just the first later
		$_SESSION['reg_email2'] = $em2; //Simpan email2 di dalam session variable

		// Passwords 
		$password = strip_tags($_POST["reg_password"]); //removes HTML tag, password bisa ada spasi dan cap letters
		$password2 = strip_tags($_POST["reg_password2"]); //removes HTML tag, password bisa ada spasi dan cap letters	

		// Data
		$date = date('Y-m-d'); //Current date

		// EMAIL VALIDATION 
		if($em == $em2) {

			// Check if email is in valid format 
			if(filter_var($em, FILTER_VALIDATE_EMAIL)){
				$em = filter_var($em, FILTER_VALIDATE_EMAIL);

				//Check if email already exists
				// e_check akan mengambil semua baris yang sesuai dengan query
				$e_check = mysqli_query($con, "SELECT email FROM users WHERE email='$em'"); 

				//Hitung jumlah baris yang sesuai dengan query di atas
				$num_rows = mysqli_num_rows($e_check);

				//Kalau lebih besar dari nol berarti email sudah dipakai
				if($num_rows > 0){
					array_push($error_array, "Email is already in use<br>");
				}

			}else{
				array_push($error_array, "Invalid email<br>");
			}

		}else{
			array_push($error_array, "Emails don't match<br>");
		}

		//USERNAME VALIDATION 
		// FirstName
		if(strlen($fname) > 25 || strlen($fname) < 2 ){
			array_push($error_array, "Your firstname must be between 2 and 25 characters<br>");
		}

		// LastName
		if(strlen($lname) > 25 || strlen($lname) < 2 ){
			array_push($error_array, "Your lastname must be between 2 and 25 characters<br>");
		}

		// PASSWORD VALIDATIONS

		// Match and value
		if($password != $password2){
			array_push($error_array, "Your passwords do not match<br>");
		} else{
			// Regexp check for alphanumeric value
			if(preg_match('/[^A-Za-z0-9]/', $password)){
				array_push($error_array, "Your password can only be alphanumeric value<br>");
			}
		}

		// Length
		if(strlen($password) < 5 || strlen($password) > 30){
			array_push($error_array, "Your password must be between 5 and 30 characters<br>");
		}


		// If no error
		if(empty($error_array)){
			$password = md5($password); // Encrypt password

			// Generate unique username 
			$username = strtolower($fname . "_" . $lname) ; //Concatenate firstname and lastname
			$check_username_query = mysqli_query($con, "SELECT username FROM users WHERE username='$username'"); //Check username di DB

			$i = 0 ;

			while (mysqli_num_rows($check_username_query) != 0){
				$i++;
				$username = $username . "_" . $i;
				$check_username_query = mysqli_query($con, "SELECT username FROM users WHERE username='$username'"); //Check  LAGI username di DB
			}

			// Default profile pics
			$rand = rand(1,2);	 //1 or 2

			if($rand == 1 ){
				$profile_pic = "assets/profile_pics/defaults/head_deep_blue.png";
			} else {
				$profile_pic = "assets/profile_pics/defaults/head_emerald.png";
			}

			// Add values to database 
			$query = mysqli_query($con, "INSERT INTO users VALUES ('', '$fname', '$lname', '$username', '$em', '$password', '$date', '$profile_pic', 0, 0, 'no', ',')");

			// Add success message to error array
			array_push($error_array, "<span style='color:#8B1628;'>You're all set! Goahead and login </span><br>");

			// Kosongkan form jika success
			$_SESSION['reg_fname'] = "";
			$_SESSION['reg_lname'] = "";
			$_SESSION['reg_email'] = "";
			$_SESSION['reg_email2'] = "";
			$_SESSION['reg_password'] = "";
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Welcome to Socmed</title>
</head>
<body>
	<!--Action : file yang handle input  -->
	<!-- Session variable digunakan agar saat form disubmit maka value dari input field tidak hilang  -->
	<form action="register.php" method="POST">
		<input type="text" name="reg_fname" placeholder="Firstname" 
			value = "<?php 
				if(isset($_SESSION["reg_fname"])){
					echo $_SESSION["reg_fname"];
				}
			?>"
		required>
		<br>
		<?php if(in_array("Your firstname must be between 2 and 25 characters<br>", $error_array)) echo "Your firstname must be between 2 and 25 characters<br>"; ?>
		
		<input type="text" name="reg_lname" placeholder="Lastname" 
			value = "<?php 
				if(isset($_SESSION["reg_lname"])){
					echo $_SESSION["reg_lname"];
				}
			?>"
		required>
		<br>
		<?php if(in_array("Your lastname must be between 2 and 25 characters<br>", $error_array)) echo "Your lastname must be between 2 and 25 characters<br>"; ?>
		<input type="email" name="reg_email" placeholder="Email" 
			value = "<?php 
				if(isset($_SESSION["reg_email"])){
					echo $_SESSION["reg_email"];
				}
			?>"
		required>
		<br>
		<input type="email" name="reg_email2" placeholder="Confirm Email" 
			value = "<?php 
				if(isset($_SESSION["reg_email2"])){
					echo $_SESSION["reg_email2"];
				}
			?>"
		required>
		<br>
		<?php 
			if(in_array("Email is already in use<br>", $error_array)) echo "Email is already in use<br>";
			elseif(in_array("Invalid email<br>", $error_array)) echo "Invalid email<br>";
			elseif(in_array("Emails don't match<br>", $error_array)) echo "Emails don't match<br>";
		?>
		<input type="password" name="reg_password" placeholder="Password" required>
		<br>
		<input type="password" name="reg_password2" placeholder="Confirm Password" required>
		<br>
		<?php 
			if(in_array("Your passwords do not match<br>", $error_array)) echo "Your passwords do not match<br>";
			elseif(in_array("Your password can only be alphanumeric value<br>", $error_array)) echo "Your password can only be alphanumeric value<br>";
			elseif(in_array("Your password must be between 5 and 30 characters<br>", $error_array)) echo "Your password must be between 5 and 30 characters<br>";
		?>
		<input type="submit" name="reg_button">
		<br>
		<?php  
			if(in_array("<span style='color:#8B1628;'>You're all set! Goahead and login </span><br>", $error_array)) echo "<span style='color:#8B1628;'>You're all set! Goahead and login </span><br>";
		?>

	</form>
</body>
</html>