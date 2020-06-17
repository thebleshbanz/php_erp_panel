<?php  //include_once('../config/app.php'); ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>ERP Panel | Registration Page</title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<!-- Bootstrap 3.3.7 -->
	<link rel="stylesheet" href="<?= base_url; ?>assets/adminLTE/bower_components/bootstrap/dist/css/bootstrap.min.css">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="<?= base_url; ?>assets/adminLTE/bower_components/font-awesome/css/font-awesome.min.css">
	<!-- Ionicons -->
	<link rel="stylesheet" href="<?= base_url; ?>assets/adminLTE/bower_components/Ionicons/css/ionicons.min.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="<?= base_url; ?>assets/adminLTE/dist/css/AdminLTE.min.css">
	<!-- iCheck -->
	<link rel="stylesheet" href="<?= base_url; ?>assets/adminLTE/plugins/iCheck/square/blue.css">

	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

<!-- Google Font -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition register-page">
	<div class="register-box">
		<div class="register-logo">
			<a href="<?= base_url; ?>assets/adminLTE/index2.html"><b>ERP</b>Panel</a>
		</div>

		<div class="register-box-body">
			<p class="login-box-msg">Register a new membership</p>

			<form action="" method="post">
				<div class="form-group <?= isset($error['fullname']) ? 'has-error' : 'has-feedback' ?>">
					<input type="text" class="form-control" name="fullname" id="fullname" placeholder="Full name" value="<?= isset($_POST['fullname']) ? $_POST['fullname'] : '' ?>">
					<span class="glyphicon glyphicon-user form-control-feedback"></span>
					<?= isset($error['fullname']) ? '<span class="help-block">'.$error["fullname"].'</span>' : '' ?>
				</div>
				<div class="form-group <?= isset($error['email']) ? 'has-error' : 'has-feedback' ?>">
					<input type="text" class="form-control" name="email" id="email" placeholder="Email" value="<?= isset($_POST['email']) ? $_POST['email'] : '' ?>">
					<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
					<?= isset($error['email']) ? '<span class="help-block">'.$error["email"].'</span>' : '' ?>
				</div>
				<div class="form-group <?= isset($error['mobile']) ? 'has-error' : 'has-feedback' ?>">
					<input type="text" class="form-control" name="mobile" id="mobile" placeholder="Mobile" value="<?= isset($_POST['mobile']) ? $_POST['mobile'] : '' ?>">
					<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
					<?= isset($error['mobile']) ? '<span class="help-block">'.$error["mobile"].'</span>' : '' ?>
				</div>
				<div class="form-group <?= isset($error['password']) ? 'has-error' : 'has-feedback' ?>">
					<input type="password" class="form-control" name="password" id="password" placeholder="Password" value="<?= isset($_POST['password']) ? $_POST['password'] : '' ?>">
					<span class="glyphicon glyphicon-lock form-control-feedback"></span>
					<?= isset($error['password']) ? '<span class="help-block">'.$error["password"].'</span>' : '' ?>
				</div>
				<div class="form-group <?= isset($error['confirm_pwd']) ? 'has-error' : 'has-feedback' ?>">
					<input type="password" class="form-control" name="confirm_pwd" id="confirm_pwd" placeholder="Retype password" value="<?= isset($_POST['confirm_pwd']) ? $_POST['confirm_pwd'] : '' ?>">
					<span class="glyphicon glyphicon-log-in form-control-feedback"></span>
					<?= isset($error['confirm_pwd']) ? '<span class="help-block">'.$error["confirm_pwd"].'</span>' : '' ?>
				</div>
				<div class="form-group <?= isset($error['pincode']) ? 'has-error' : 'has-feedback' ?>">
					<input type="text" class="form-control" name="pincode" id="pincode" placeholder="Pincode" value="<?= isset($_POST['pincode']) ? $_POST['pincode'] : '' ?>">
					<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
					<?= isset($error['pincode']) ? '<span class="help-block">'.$error["pincode"].'</span>' : '' ?>
				</div>

				<div class="form-group has-feedback">
					<select class="form-control" id="city" name="city">
						<option value="default" selected="selected">please select city</option>	
						<option value="indore" <?php if(isset($_POST['city'])?$_POST['city'] == 'indore':'') echo 'selected="selected"' ?>>Indore</option>
						<option value="mumbai" <?php if(isset($_POST['city'])?$_POST['city'] == 'mumbai':'') echo 'selected="selected"' ?>>Mumbai</option>
						<option value="chennai" <?php if(isset($_POST['city'])?$_POST['city'] == 'chennai':'') echo 'selected="selected"' ?>>Chennai</option>
						<option value="kolkatta" <?php if(isset($_POST['city'])?$_POST['city'] == 'kolkatta':'') echo 'selected="selected"' ?>>kolkatta</option>			  		  
						<option value="delhi" <?php if(isset($_POST['city'])?$_POST['city'] == 'delhi':'') echo 'selected="selected"' ?>>Delhi</option>
						<option value="pune" <?php if(isset($_POST['city'])?$_POST['city'] == 'pune':'') echo 'selected="selected"' ?>>pune</option>
						<option value="bengular" <?php if(isset($_POST['city'])?$_POST['city'] == 'bengular':'') echo 'selected="selected"' ?>>bengular</option>
						<option value="kochi" <?php if(isset($_POST['city'])?$_POST['city'] == 'kochi':'') echo 'selected="selected"' ?>>kochi</option>
					</select>
				</div>
				<div class="form-group has-feedback">
					<textarea class="form-control" name="address" id="address" rows="5" placeholder="Enter Address"><?= isset($_POST['address']) ? $_POST['address'] : '' ?></textarea>
					<!-- <span class="glyphicon glyphicon-envelope form-control-feedback"></span> -->
				</div>
				<div class="row">
					<div class="col-xs-8">
						<div class="checkbox icheck">
							<label>
								<input type="checkbox" name="terms" value="1"> I agree to the <a href="#">terms</a>
							</label>
						</div>
					</div>
					<!-- /.col -->
					<div class="col-xs-4">
						<input type="submit" class="btn btn-primary btn-block btn-flat" name="submit" value="Register" >
					</div>
					<!-- /.col -->
				</div>
			</form>

			<a href="<?= base_url.'login.php'; ?>" class="text-center">I already have a membership</a>
		</div>
		<!-- /.form-box -->
	</div>
	<!-- /.register-box -->

	<!-- jQuery 3 -->
	<script src="<?= base_url; ?>assets/adminLTE/bower_components/jquery/dist/jquery.min.js"></script>
	<!-- Bootstrap 3.3.7 -->
	<script src="<?= base_url; ?>assets/adminLTE/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
	<!-- iCheck -->
	<script src="<?= base_url; ?>assets/adminLTE/plugins/iCheck/icheck.min.js"></script>
	<script>
		$(function () {
			$('input').iCheck({
				checkboxClass: 'icheckbox_square-blue',
				radioClass: 'iradio_square-blue',
				increaseArea: '20%' /* optional */
			});
		});
	</script>
</body>
</html>