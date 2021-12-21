<?php
	session_start();
	if($_SESSION['admin_loggedon'] != '1') {
		die(header('location:add_admin.php'));
		exit;
	}
?>

<!DOCTYPE html>

<!--  if (!isset($_SESSION['loggedIn'])){ FIGURE OUT HOW TO LOCK THIS IF NOT SET
//    header('Location: http://db.cse.nd.edu/cse30246/muse/add_admin.php');
//    exit; -->

<html>
<head>
	<link rel="icon" href="bkgs/M_logo.png" type="image/icon type">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Muse MODS</title>
    <link rel="stylesheet" href="css/sty.css">
	  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
</head>

<body class="bkg_im">
  <header>
      <div class="container_h">
      <h3 class="logo">MUSE Add Users</h3>

        <nav>
          <ul>
            <li><a href="http://db.cse.nd.edu/cse30246/muse/">Home</a></li>
            <li><a href="http://db.cse.nd.edu/cse30246/muse/devplan.html">DevPlan</a></li>
            <li><a href="http://db.cse.nd.edu/cse30246/muse/project.html">About</a></li>
            <li><a href="http://db.cse.nd.edu/cse30246/muse/login.php">Admin</a></li>
            <li><a href="http://db.cse.nd.edu/cse30246/muse/oauth.php">Login</a></li>
          </ul>
        </nav>
      </div>
    </header>

    <h1>Add a New Music Moderator</h1>

	<?php
		$servername = "localhost";
		$username = "hjeon";
		$password = "na0103Yeh|";
		$db = "hjeon";
		$conn = NULL;

		try { // try mysql -p hjeon
			$conn = mysqli_connect($servername, $username, $password, $db);
			//echo "Connected successfully";
    		} catch(PDOException $e) { // print connection error message
        		//echo "Connection failed: " . $e->getMessage();
    		}
        ?>

	<?php if ($_SERVER["REQUEST_METHOD"] == "GET"): ?>
		<form method = "POST">
			<div>
				<label for = "Username">Username</label>
				  <input class="form-control" type = "text" name = "Username" placeholder="Enter admin username..." required = "required"/>
        <br>
        <label for = "Password">Password</label>
				  <input class="form-control" type = "password" name = "Password" placeholder="Enter admin password..." required = "required"/>
      </div>
      <br>
			<button class = "btn btn-outline-success" type = "submit" name = "button" value = "Sign Up">Create User</button>
		</form>
	<?php else: ?>
	<?php
		// TODO: Logout
		// TODO: Delete account option once logged in
		// TODO: Maintaining a separate db for each individual user preferences (aka liked songs) and accessing/inserting/updating/deleting from that preferences list
    if ($_REQUEST["button"] == "Sign Up") {
			if (isset($_POST['Username'], $_POST['Password'])) { // check if both fields filled in
				$username_entered = mysqli_real_escape_string($conn, $_POST['Username']);
				$password_entered = mysqli_real_escape_string($conn, $_POST['Password']);
				$query = mysqli_query($conn, "SELECT * FROM login_data WHERE username = '$username_entered'");
				$count = mysqli_num_rows($query);
				if ($count == 0) { // check if username not in login_data / not already in use
					$sql_cmd = "INSERT INTO login_data (username, password) VALUES ('$username_entered', '$password_entered')";
					if ($conn->query($sql_cmd) == TRUE) {
						echo "Sign up successful";
					} else {
						echo "Error signing up";
					}
				} else { // if username is already in use
					echo "Existing username/account";
					echo "<br/>";
					echo "<a href = 'http://db.cse.nd.edu/cse30246/muse/mods.php'>Back to mods.php</a>";
				}
			}
		}
		?>
	<?php endif ?>
  <!--ADD EXISTING USERS IN A TABLE HERE -->
	<?php
	        echo "<br/>";
 	        $query = mysqli_query($conn, "SELECT * FROM login_data WHERE username LIKE 'admin%'");
 	        echo "<table border='1'><tr><th>Usernames</th><th>Passwords</th></tr>";
 	        while($row = mysqli_fetch_assoc($query)) {
 	                echo "<tr>";
 	                echo "<td>" . $row['username'] . "</td>";
 	                echo "<td>" . $row['password'] . "</td>";
	        	echo "</tr>";
 	        }
 	        echo "</table>";
		$conn->close();
	?>
</body>

</html>
