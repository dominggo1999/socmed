<?php 

	// Check jika login button sudah ditekan 
	if(isset($_POST['login_button'])){

		$email = filter_var($_POST['log_email'], FILTER_SANITIZE_EMAIL); //Sanitize email 

		// Biar jangan hilang kalau salah, dikasih session variable
		$_SESSION['log_email'] = $email;

		// Password di enkripsi dulu baru di cek 
		$password = md5($_POST['log_password']);//Get password from user input 

		// Query untuk check data di database
		$check_database_query = mysqli_query($con, "SELECT * FROM users WHERE email='$email' AND password='$password'");

		// Ada berapa user , TEORITIS PASTI 1 ATAU 0
		$check_login_query = mysqli_num_rows($check_database_query);

		//Jika user ada di database berarti user bisa login 
		if($check_login_query == 1){

			// Ambil data user dan simpan dalam varible(VARIABEL INI ADALAH ARRAY)
			$row = mysqli_fetch_array($check_database_query);
			$username = $row['username'];


			// JIKA USER TUTUP AKUN, LALU USER MASUK LAGI => password dan email nya masih tersimpan di database, tapi status user_closed nya jadi yes, kalau login lagi berarti harus ubah yes jadi no
			$user_closed_query = mysqli_query($con, "SELECT * FROM users WHERE email='$email' AND user_closed='yes'");

			// Jika akun masih tersimpan di database
			if(mysqli_num_rows($user_closed_query) == 1){

				// Reopen account
				$reopen_account = mysqli_query($con, "UPDATE users SET user_closed='no' WHERE email='$email'");

			}

			// Simpan username di dalam session variable
			$_SESSION['username'] = $username;

			echo 'Login is success';
			header("Location: index.php");
			exit();
		} else{
			array_push($error_array, "Email or password was incorrect!<br>"); 
		}
	}

?>