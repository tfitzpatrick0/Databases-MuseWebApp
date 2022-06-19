
<?php
	$servername = "localhost";
	$username = "root";
	$password = "stingrays";
	$db = "muse";
	$conn = NULL;
	
	try {
		$conn = mysqli_connect($servername, $username, $password, $db);
		//echo "Connected successfully";
	} catch(PDOException $e) {
		echo "Connection failed: " . $e->getMessage();
	}
		
// TODO: Logout
// TODO: Delete account option once logged in
// TODO: Maintaining a separate db for each individual user preferences (aka liked songs) and accessing/inserting/updating/deleting from that preferences list
	$error = "";
	if (isset($_POST['Username'], $_POST['Password'])) { // check if both fields filled in
		$_SESSION['loggedon'] = '0';
		$username_entered = mysqli_real_escape_string($conn, $_POST['Username']);
		$password_entered = mysqli_real_escape_string($conn, $_POST['Password']);
		//echo "$username_entered, $password_entered";
		// mysql
		$query = mysqli_query($conn, "SELECT * FROM login_data WHERE username = '$username_entered' and password = '$password_entered'");
		$count = mysqli_num_rows($query);
		// if username_entered and password_entered pair available in login_data
		//TempData["LoggedIn"]='False';
		session_start();
		if ($count == 1) {
			$_SESSION['loggedon'] = '1';
			if ($username_entered == 'admin') {
				//TODO: admin, admin2, admin3, admin4 etc
				//echo "You are now on the Admin page";
				header('Location: http://local.muse/demo.php');
				//echo file_get_contents('http://local.muse/demo.php');
				//TempData["LoggedIn"]='True';
			} else {
				//echo "Howdy $username_entered! Thanks for visiting Muse again!";
				header('Location: http://local.muse/demo.php');
			}
		} else { // if pair not found
			$_SESSION['loggedon'] = '0';
			$error = "Incorrect username or password";
			//echo "<br/>";
			//echo "<a href = 'http://local.muse/login.php'>Back to login.php</a>";
		}
		//unset($_SESSION['loggedon']);
		//session_destroy();
		//$_SESSION['loggedon'] = false;
	}
	//$_SESSION['loggedon'] = '0';
	//session_destroy();
?>

<!DOCTYPE html>
<html>
<head>
		<link rel="icon" href="bkgs/M_logo.png" type="image/icon type">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MUSE Admin</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
  	<header>
        <div class="container-h">
            <h1 class="logo">MUSE Admin</h1>
            <nav>
                <ul>
                    <li><a href="http://local.muse/">Home</a></li>
                    <li><a href="http://local.muse/devplan.html">DevPlan</a></li>
                    <li><a href="http://local.muse/project.html">About</a></li>
                    <li><a style="font-weight:bold" href="http://local.muse/login.php">Admin</a></li>
                    <li><a href="http://local.muse/oauth.php">Spotify</a></li>
                </ul>
            </nav>
        </div>
        <div class="black-line"></div>
    </header>

		<br />
		<br />

		<div class="admin-login-container">
				<div class="al-form-container al-col">
						<div class="al-form-padding">
								<div class="al-form-h">
										<img src="bkgs/M_logo.png" style="width: 185px;" alt="logo">
										<h2>MUSE ADMIN LOGIN</h4>
								</div>
								<form method="POST">
										<div class="al-form-body">
												<label for="Username">USERNAME:</label>
												<input class="input-text-field" type="text" name="Username">
										</div>
										<div class="al-form-body">
												<label for="Password">PASSWORD:</label>
												<input class="input-text-field" type="password" name="Password">
												<p style="color:red;"><?php echo $error; ?></p>
										</div>
										<div class="al-form-submit">
												<button class="button standard-button" type="submit">LOG IN</button>
										</div>
								</form>
						</div>
				</div>
				<div class="al-message-container al-col">
						<div class="text-white px-3 py-4 p-md-5 mx-md-4">
								<h4 class="mb-4">Music statistics with Spotify integration</h4>
								<p class="small mb-0">Have you ever wanted to know more about the songs you see on Spotify? Create an account or login to get started!</p>
						</div>
				</div>
		</div>

		<br />
    <br />

    <div class="footer">
        <p>MUSE Team 2021</p>
    </div>
</body>
</html>
