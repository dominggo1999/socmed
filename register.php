<?php 
	
	require 'config/config.php';
	require 'includes/form_handlers/register_handler.php';
	require 'includes/form_handlers/login_handler.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Welcome to Socmed</title>
</head>
<body>
	<!-- lOGIN FORM -->
	<form action="register.php" method="POST">
		<input type="email" name="log_email" placeholder="Email address"
			value = "<?php 
				if(isset($_SESSION["log_email"])){
					echo $_SESSION["log_email"];
				}
			?>"
		required>
		<br>
		<input type="password" name="log_password" placeholder="Password" required>
		<br>
		<input type="submit" name="login_button" value="Login">
		<br>
		<?php if(in_array("Email or password was incorrect!<br>", $error_array)) echo "Email or password was incorrect!<br>"?>
	</form>
	<br>

	<!-- REGISTRATION FORM -->
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
		<input type="submit" name="reg_button" value="Register">
		<br>
		<?php  
			if(in_array("<span style='color:#8B1628;'>You're all set! Goahead and login </span><br>", $error_array)) echo "<span style='color:#8B1628;'>You're all set! Goahead and login </span><br>";
		?>

	</form>
</body>
</html>