<?php

$servername = "localhost";
$username = "root";
$password = "stingrays";
$db = "muse";
$conn = NULL;

try {
		$conn = mysqli_connect($servername, $username, $password, $db);
} catch (PDOException $e) { 
		echo "Connection failed: " . $e->getMessage();
}

if (isset($_POST['create_admin_user'], $_POST['create_admin_password'])) {
		$username = $_POST['create_admin_user'];
		$password = $_POST['create_admin_password'];

		if (trim($username, " ") == "" or trim($password, " ") == "") {
				$invalid_req = "One or more search parameters are empty - unable to create.";
		} else {
				$query = mysqli_query($conn, "SELECT * FROM login_data WHERE username = '$username'");

				if (mysqli_num_rows($query) > 0) {
						$invalid_req = "This username (" . $username . ") already exists - unable to create.";
				} else {
						$sql_cmd = "INSERT INTO login_data (username, password) VALUES ('$username', '$password')";
						if ($conn->query($sql_cmd) == TRUE) {
								$create_msg = "~ SUCCESSFUL CREATION ~";
						} else {
								$invalid_req = "Creation failed - unable to create.";
						}
				}
		}
}
else {
		header("Location: http://local.muse/");
		exit;
}	
$conn->close();

?>

<!DOCTYPE html>
<html>
<head>
		<link rel="icon" href="imgs/M_logo.png" type="image/icon type">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Muse MODS</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
		<header>
        <div class="container-h">
            <h1 class="logo">MUSE Demo - Create Admin</h1>
            <nav>
                <ul>
                    <li><a href="http://local.muse/demo.php">Return to Demo</a></li>
                </ul>
            </nav>
        </div>
        <div class="black-line"></div>
    </header>

    <br />
		<br />

		<div class="center-content-col">
        <?php echo (isset($invalid_req)) ? "<p>" . $invalid_req . "</p>" :
            "<h3 style=\"text-decoration:underline\">CREATING NEW ADMIN ACCOUNT</h3>" .
            "<h4>Username: " . $username . "</h4>" .
            "<h4>Password: " . $password . "</h4>" .
						"<p>" . $create_msg . "</p>"
        ; ?>
    </div>

		<br />
		<br />

		<div class="footer">
        <p>MUSE Team 2021</p>
    </div>
</body>
</html>

