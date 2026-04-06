<html>
	<head>
		<title>
			Homepage
		</title>
	</head>
	<body>
		<?php
		session_start();
		
		if (!isset($_SESSION['id'])) {
		    header("Location: login.php");
		    exit();
		}
		?>
		
		<h1>Welcome, 
			<?php echo $_SESSION['full_name']; ?>!</h1>
		
		<a href="logout.php">Logout</a>	
	</body>
</html>
