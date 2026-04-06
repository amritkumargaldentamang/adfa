<?php
	include 'connection.php';
	session_start();

	// handle registration
	if(isset($_POST['register'])){
		$full_name = $_POST['full_name'];
		$email = $_POST['email'];
		$password = $_POST['password'];
		$phone_number = isset($_POST['phone_number']) ? $_POST['phone_number'] : null;
		
		$sql = "INSERT INTO users (full_name, email, password, role, phone_number) VALUES ('$full_name', '$email', '$password', 'customer', " . ($phone_number ? "'$phone_number'" : "NULL") . ")";
		
		if($conn->query($sql)){
			echo 'registration_successful';
		}else{
			echo "error: " . $conn->error;
		}
	}

	// handle login
	if(isset($_POST['login'])){
		$email = $_POST['email'];
		$password = $_POST['password'];
		
		$sql = "SELECT * FROM users WHERE email='$email'";
		$result = $conn->query($sql);
		
		if($result->num_rows > 0){
			$user = $result->fetch_assoc();
			
			if($password === $user['password']){
				$_SESSION['user_id'] = $user['id'];
				$_SESSION['username'] = $user['full_name'];
				echo 'login_success';
			}else{
				echo 'invalid_password';
			}
		}else{
			echo 'user_not_found';
		}
	}
?>