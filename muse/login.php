
<?php
	$servername = "localhost";
	$username = "hjeon";
	$password = "na0103Yeh|";
	$db = "hjeon";
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
				header('Location: http://db.cse.nd.edu/cse30246/muse/demo.php');
	//echo file_get_contents('http://db.cse.nd.edu/cse30246/muse/demo.php');
	//TempData["LoggedIn"]='True';
			} else {
				//echo "Howdy $username_entered! Thanks for visiting Muse again!";
				header('Location: http://db.cse.nd.edu/cse30246/muse/demo.php');
			}
		} else { // if pair not found
			$_SESSION['loggedon'] = '0';
			$error = "Incorrect username or password";
			//echo "<br/>";
			//echo "<a href = 'http://db.cse.nd.edu/cse30246/muse/login.php'>Back to login.php</a>";
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
    <title>Muse Login</title>
    <link rel="stylesheet" href="css/sty.css">
	  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
</head>

<body class="bkg_im">
	<style>
		.gradient-custom-2 {
		/* fallback for old browsers */
		background: #fccb90;

		/* Chrome 10-25, Safari 5.1-6 */
		background: -webkit-linear-gradient(to right, #6efac8, #5df4bb, #31e799, #05df85);

		/* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
		background: linear-gradient(to right, #6efac8, #5df4bb, #31e799, #05df85);
		}

		@media (min-width: 768px) {
		.gradient-form {
			height: 100vh !important;
		}
		}
		@media (min-width: 769px) {
		.gradient-custom-2 {
			border-top-right-radius: .3rem;
			border-bottom-right-radius: .3rem;
		}
		}
	</style>
  <header>
      <div class="container_h">
      <h3 class="logo">MUSE Login</h3>

        <nav>
          <ul>
            <li><a href="http://db.cse.nd.edu/cse30246/muse/">Home</a></li>
            <li><a href="http://db.cse.nd.edu/cse30246/muse/devplan.html">DevPlan</a></li>
            <li><a href="http://db.cse.nd.edu/cse30246/muse/project.html">About</a></li>
            <li><a style="font-weight:bold" href="http://db.cse.nd.edu/cse30246/muse/login.php">Admin</a></li> <!-- CHANGE to login.php -->
            <li><a href="http://db.cse.nd.edu/cse30246/muse/oauth.php">Login</a></li> <!-- NEED TO CHANGE NAV links, login for oauth -->

          </ul>
        </nav>
      </div>
	</header>
	<section class="h-100 gradient-form" style="background-color: #eee;">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-xl-10">
        <div class="card rounded-3 text-black">
          <div class="row g-0">
            <div class="col-lg-6">
              <div class="card-body p-md-5 mx-md-4">

                <div class="text-center">
                  <img src="bkgs/M_logo.png" style="width: 185px;" alt="logo">
                  <h4 class="mt-1 mb-5 pb-1">MUSE Admin Login</h4>
                </div>

                <form method="POST">
                  <p>Please login to your account</p>

                  <div class="form-outline mb-4">
				  	<label for = "Username">Username</label>
                    <input type="text" name="Username" class="form-control">
                  </div>

                  <div class="form-outline mb-4">
				  	<label for = "Password">Password</label>
                    <input type="password" name="Password" class="form-control"  />
					<p style="color:red;"><?php echo $error; ?></p>
                  </div>

                  <div class="text-center pt-1 mb-5 pb-1">
                    <button class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3" type="submit" name="button" value="Log In">Log in</button>
                  </div>

                  <div class="d-flex align-items-center justify-content-center pb-4">
                    <p class="mb-0 me-2">Don't have an admin account?</p>
                    <a href="http://db.cse.nd.edu/cse30246/muse/add_admin.php" class = "btn btn-outline-success" role="button">Create New</a>
                  </div>

                </form>

              </div>
            </div>
            <div class="col-lg-6 d-flex align-items-center gradient-custom-2">
              <div class="text-white px-3 py-4 p-md-5 mx-md-4">
                <h4 class="mb-4">Music statistics with Spotify integration</h4>
                <p class="small mb-0">Have you ever wanted to know more about the songs you see on Spotify? Create an account or login to get started!</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
	<!--
    <h1>Enter Credentials to Edit Database</h1>

	

  <h2>Add a New Moderator</h2>
  <a href="http://db.cse.nd.edu/cse30246/muse/add_admin.php" class = "btn btn-outline-success" role="button">Create New Moderator</a>

	-->
</body>

</html>
