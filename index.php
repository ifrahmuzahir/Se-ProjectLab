<?php
require_once("admin/inc/config.php");

$fetchingElections = mysqli_query($db, "SELECT * FROM electiontable") or die(mysqli_error($db));
while ($data = mysqli_fetch_assoc($fetchingElections)) {
	$starting_date = $data['StartingDate'];
	$ending_date = $data['EndingDate'];
	$curr_date = date('Y-m-d');
	$election_Id = $data['ElectionID'];
	$status = $data['Status'];

	if ($status == 'Active')
	{
		$date1 = date_create($curr_date);
		$date2 = date_create($ending_date);
		$diff = date_diff($date1, $date2);
		//echo var_dump((int)$diff->format("%R%a"));
		if ((int)$diff->format("%R%a") < 0) 
		{
			//echo "Expired";
			//Update Status In DATABASE
			mysqli_query($db,"UPDATE electiontable SET Status = 'Expired' WHERE ElectionID = '".$election_Id."'") or die(mysqli_error($db));
		} 
	} 
	else if ($status == 'Inactive') 
	{
		$date1 = date_create($curr_date);
		$date2 = date_create($starting_date);
		$diff = date_diff($date1, $date2);
		//echo $diff->format("%R%a");
		if ((int)$diff->format("%R%a") <= 0) 
		{
			//echo "Active";
			// UPDATE STATUS IN DATABSE
			mysqli_query($db,"UPDATE electiontable SET Status = 'Active' WHERE ElectionID = '".$election_Id."'") or die(mysqli_error($db));
		} 
	}
}
?>

<!DOCTYPE html>
<html>

<head>
	<title>Login - Online Voting System</title>
	<link rel="stylesheet" href="assets\css\bootstrap.min.css">
	<link rel="stylesheet" href="assets\css\login.css">
	<link rel="stylesheet" href="assets\css\style.css">
</head>

<body>
	<div class="container h-100">
		<div class="d-flex justify-content-center h-100">
			<div class="user_card">
				<div class="d-flex justify-content-center">
					<div class="brand_logo_container">
						<img src="assets/images/logo.gif" class="brand_logo" alt="Logo">
					</div>
				</div>

				<?php
				if (isset($_GET['sign-up'])) { ?>
					<div class="d-flex justify-content-center form_container">
						<form method="POST">
							<div class="input-group mb-3">
								<div class="input-group-append">
									<span class="input-group-text"><i class="fas fa-user"></i></span>
								</div>
								<input type="text" name="su_username" class="form-control input_user" placeholder="Username"
									required />
							</div>
							<div class="input-group mb-2">
								<div class="input-group-append">
									<span class="input-group-text"><i class="fas fa-key"></i></span>
								</div>
								<input type="password" name="su_password" class="form-control input_pass"
									placeholder="Password" required />
							</div>
							<div class="input-group mb-2">
								<div class="input-group-append">
									<span class="input-group-text"><i class="fas fa-key"></i></span>
								</div>
								<input type="text" name="su_email" class="form-control input_pass" placeholder="Email"
									required />
							</div>
							<div class="input-group mb-2">
								<div class="input-group-append">
									<span class="input-group-text"><i class="fas fa-key"></i></span>
								</div>
								<input type="text" name="su_role" class="form-control input_pass" placeholder="Role"
									required />
							</div>
							<div class="input-group mb-2">
								<div class="input-group-append">
									<span class="input-group-text"><i class="fas fa-key"></i></span>
								</div>
								<input type="text" name="su_age" class="form-control input_pass" placeholder="Age"
									required />
							</div>
							<div class="d-flex justify-content-center mt-3 login_container">
								<button type="submit" name="sign_up_btn" class="btn login_btn">Sign Up</button>
							</div>
						</form>
					</div>

					<div class="mt-4">
						<div class="d-flex justify-content-center links text-white">
							Already have an account? <a href="?index.php" class="ml-2 text-white">Sign In</a>
						</div>
					</div>
					<?php
				} else {
					?>
					<div class="d-flex justify-content-center form_container">
						<form method="POST">
							<div class="input-group mb-3">
								<div class="input-group-append">
									<span class="input-group-text"><i class="fas fa-user"></i></span>
								</div>
								<input type="text" name="email" class="form-control input_user" placeholder="email"
									required />
							</div>
							<div class="input-group mb-2">
								<div class="input-group-append">
									<span class="input-group-text"><i class="fas fa-key"></i></span>
								</div>
								<input type="password" name="password" class="form-control input_pass"
									placeholder="password" required />
							</div>
							<div class="form-group">
								<div class="custom-control custom-checkbox">
									<input type="checkbox" class="custom-control-input" id="customControlInline">
									<label class="custom-control-label text-white" for="customControlInline">Remember
										me</label>
								</div>
							</div>
							<div class="d-flex justify-content-center mt-3 login_container">
								<button type="submit" name="lgn_btn" class="btn login_btn">Login</button>
							</div>
						</form>
					</div>

					<div class="mt-4">
						<div class="d-flex justify-content-center links text-white">
							Don't have an account? <a href="?sign-up=1" class="ml-2 text-white">Sign Up</a>
						</div>
						<div class="d-flex justify-content-center links">
							<a href="#" class="text-white">Forgot your password?</a>
						</div>
					</div>
					<?php
				}
				?>
				<?php
				if (isset($_GET['registered'])) {
					?>
					<span class="text-success text-center my-3"> Account has been created Successfully! </span>
					<?php
				} elseif (isset($_GET['invalid'])) {
					?>
					<span class="text-danger text-center my-3"> Invalid Credentials </span>
					<?php
				} elseif (isset($_GET['notregistered'])) {
					?>
					<span class="text-warning text-center my-3"> Sorry! You are not registered </span>
					<?php
				} elseif (isset($_GET['Invalid_Access'])) {
					?>
					<span class="text-danger text-center my-3"> Invalid Username or Password </span>
					<?php
				}
				?>


			</div>
		</div>
	</div>

	<script src="assets\js\jquery.min.js"></script>
	<script src="assets\js\bootstrap.min.js"></script>

</body>

</html>


<?php
require_once('admin/inc/config.php');
if (isset($_POST['sign_up_btn'])) {
	$su_username = mysqli_real_escape_string($db, $_POST['su_username']);
	$su_password = mysqli_real_escape_string($db, sha1($_POST['su_password']));
	$su_email = mysqli_real_escape_string($db, $_POST['su_email']);
	$su_role = mysqli_real_escape_string($db, $_POST['su_role']);
	$su_age = mysqli_real_escape_string($db, $_POST['su_age']);
	$su_active = true;

	//mysqli_query($db, "INSERT INTO user(Username, Password, Email,Role, Age, Active) VALUES('" . $su_username . "', '" . $su_password . "', '" . $su_email . "', '" . $su_role . "', '" . $su_age . "', '" . $su_active . "')") or die(mysqli_error($db));

	//su_username su_password su_email su_role su_age
	//
	if ($su_username != null & $su_password != null & $su_role == "Voter") {
		//echo"Hello Data";
		//mysqli_query($db,"INSERT INTO voter(VoterID,Name, Age, Active) VALUES((select VoterID,Name, Age, Active from user where Role = 'Voter'))") or die(mysqli_error($db));
		$insert_user_query = "INSERT INTO user (Username, Password, Email, Role, Age, Active)
			VALUES ('$su_username', '$su_password', '$su_email', '$su_role', '$su_age', '$su_active')";
		mysqli_query($db, $insert_user_query) or die(mysqli_error($db));

		// Get the last inserted user ID
		$last_user_id = mysqli_insert_id($db);

		// Insert data into voter table using the last inserted user ID
		$insert_voter_query = "INSERT INTO voter (VoterID, Name, Age, Active)
			 VALUES ('$last_user_id', '$su_username', '$su_age', '$su_active')";
		mysqli_query($db, $insert_voter_query) or die(mysqli_error($db));

		?>
		<script>location.assign("index.php?sign-up=1&registered=1");</script>
		<?php

	} else if ($su_username != null & $su_password != null & $su_role == "Admin") {
		//echo"Hello Data";
		//mysqli_query($db, "INSERT INTO admintable(Username, Password, Email,Role, Age, Active) VALUES('" . $su_username . "', '" . $su_password . "', '" . $su_email . "', '" . $su_role . "', '" . $su_age . "', '" . $su_active . "')") or die(mysqli_error($db));
		$insert_user_query = "INSERT INTO user (Username, Password, Email, Role, Age, Active)
			VALUES ('$su_username', '$su_password', '$su_email', '$su_role', '$su_age', '$su_active')";
		mysqli_query($db, $insert_user_query) or die(mysqli_error($db));

		// Get the last inserted user ID
		$last_user_id = mysqli_insert_id($db);

		// Insert data into voter table using the last inserted user ID
		$insert_voter_query = "INSERT INTO admintable (AdminID, Username,Email, Age, Active)
			 VALUES ('$last_user_id', '$su_username', '$su_email','$su_age', '$su_active')";
		mysqli_query($db, $insert_voter_query) or die(mysqli_error($db));


		?>
			<script>location.assign("index.php?sign-up=1&registered=1");</script>
		<?php

	} else {
		?>
			<script>location.assign("index.php?sign-up=1&invalid=1");</script>
		<?php
	}
} elseif (isset($_POST['lgn_btn'])) {
	$password = mysqli_real_escape_string($db, $_POST['password']);
	$email = mysqli_real_escape_string($db, $_POST['email']);

	// Fetch user data based on the email
	$fetchingData = mysqli_query($db, "SELECT * FROM user WHERE Email = '$email'") or die(mysqli_error($db));

	if (mysqli_num_rows($fetchingData) > 0) {
		$data = mysqli_fetch_assoc($fetchingData);

		// Compare hashed password
		if (sha1($password) == $data['Password']) {
			session_start();
			$_SESSION['user_role'] = $data['Role'];
			$_SESSION['email'] = $data['Email'];
			$_SESSION['username'] = $data['Username'];
			$_SESSION['user_id'] = $data['ID'];

			if ($data['Role'] == "Admin") {
				$_SESSION['key'] = "AdminKey";
				header("Location: admin/index.php?addHomePage=1");
				exit();
			} else if ($data['Role'] == "Voter") {
				$_SESSION['key'] = "VotersKey";
				header("Location: voters/index.php?HomePage=1");
				exit();
			}
		} else {
			?>
			<script>location.assign("index.php?Invalid_Access=1");</script>
			<?php
		}
	} else {
		?>
		<script>location.assign("index.php?sign-up=1&notregistered=1");</script>
		<?php
	}
}


?>