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
								<input type="text" name="su_username" class="form-control input_user" placeholder="Username" required />
							</div>
							<div class="input-group mb-2">
								<div class="input-group-append">
									<span class="input-group-text"><i class="fas fa-key"></i></span>
								</div>
								<input type="password" name="su_password" class="form-control input_pass" placeholder="Password" required/>
							</div>
							<div class="input-group mb-2">
								<div class="input-group-append">
									<span class="input-group-text"><i class="fas fa-key"></i></span>
								</div>
								<input type="text" name="su_email" class="form-control input_pass" placeholder="Email" required/>
							</div> 
							<div class="input-group mb-2">
								<div class="input-group-append">
									<span class="input-group-text"><i class="fas fa-key"></i></span>
								</div>
								<input type="text" name="su_role" class="form-control input_pass" placeholder="Role" required/>
							</div>
							<div class="input-group mb-2">
								<div class="input-group-append">
									<span class="input-group-text"><i class="fas fa-key"></i></span>
								</div>
								<input type="text" name="su_age" class="form-control input_pass" placeholder="Age" required/>
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
						<form>
							<div class="input-group mb-3">
								<div class="input-group-append">
									<span class="input-group-text"><i class="fas fa-user"></i></span>
								</div>
								<input type="text" name="" class="form-control input_user" value="" placeholder="username">
							</div>
							<div class="input-group mb-2">
								<div class="input-group-append">
									<span class="input-group-text"><i class="fas fa-key"></i></span>
								</div>
								<input type="password" name="" class="form-control input_pass" value=""
									placeholder="password">
							</div>
							<div class="form-group">
								<div class="custom-control custom-checkbox">
									<input type="checkbox" class="custom-control-input" id="customControlInline">
									<label class="custom-control-label text-white" for="customControlInline">Remember
										me</label>
								</div>
							</div>
							<div class="d-flex justify-content-center mt-3 login_container">
								<button type="button" name="button" class="btn login_btn">Login</button>
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
					if(isset($_GET['registered']))
					{	
				?>
				<span class="bg-white text-success text-center my-3"> Account has been created Successfully! </span>
				<?php
					}elseif(isset($_GET['invalid'])){
						?>
				<span class="bg-white text-danger text-center my-3"> Invalid Credentials </span>
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
 	if (isset($_POST['sign_up_btn'])) 
 	{
		$su_username = mysqli_real_escape_string($db, $_POST['su_username']);
		$su_password = mysqli_real_escape_string($db, $_POST['su_password']);
		$su_email = mysqli_real_escape_string($db, $_POST['su_email']);
		$su_role = mysqli_real_escape_string($db, $_POST['su_role']);
		$su_age = mysqli_real_escape_string($db, $_POST['su_age']);
		$su_active = true;
		//su_username su_password su_email su_role su_age
		if($su_username != null & $su_password != null & $su_role == "User")
		{
			//echo"Hello Data";
			mysqli_query($db,"INSERT INTO user(Username, Password, Email,Role, Age, Active) VALUES('". $su_username ."', '". $su_password ."', '". $su_email ."', '". $su_role ."', '". $su_age ."', '". $su_active ."')") or die(mysqli_error($db));
		?>
		<script>location.assign("index.php?sign-up=1&registered=1");</script>
		<?php
	
		}
		else{
			?>
			<script>location.assign("index.php?sign-up=1&notregistered=0");</script>
			<?php
		}
 	}
?>