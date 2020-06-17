<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Main content -->
	<section class="content">
		<div class="row">
			<div class="col-md-12">
				<!-- general form elements -->
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title">Edit User</h3>
					</div>
					<!-- /.box-header -->
					<!-- form start -->
					<form method="post" action="<?php echo $_SERVER['REQUEST_URI'];?>" enctype="multipart/form-data">
						<input type="hidden" name="user_id" value="<?= $user->user_id; ?>">
						<div class="box-body">
							<div class="col-md-6">
								
								<div class="form-group <?= isset($error['fullname']) ? 'has-error' : 'has-feedback' ?>">
									<input type="text" class="form-control" name="fullname" id="fullname" placeholder="Full name" value="<?= isset($user->user_fname) ? $user->user_fname.' '.$user->user_lname : '' ?>">
									<span class="glyphicon glyphicon-user form-control-feedback"></span>
									<?= isset($error['fullname']) ? '<span class="help-block">'.$error["fullname"].'</span>' : '' ?>
								</div>
								
								<div class="form-group <?= isset($error['user_email']) ? 'has-error' : 'has-feedback' ?>">
									<input type="text" class="form-control" name="user_email" id="user_email" placeholder="Email" value="<?= isset($user->user_email) ? $user->user_email : '' ?>">
									<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
									<?= isset($error['user_email']) ? '<span class="help-block">'.$error["user_email"].'</span>' : '' ?>
								</div>
								
								<div class="form-group <?= isset($error['user_mobile']) ? 'has-error' : 'has-feedback' ?>">
									<input type="text" class="form-control" name="user_mobile" id="user_mobile" placeholder="Mobile" value="<?= isset($user->user_mobile) ? $user->user_mobile : '' ?>">
									<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
									<?= isset($error['user_mobile']) ? '<span class="help-block">'.$error["user_mobile"].'</span>' : '' ?>
								</div>
								
								<div class="form-group <?= isset($error['user_password']) ? 'has-error' : 'has-feedback' ?>">
									<input type="password" class="form-control" name="user_password" id="user_password" placeholder="Password" value="">
									<span class="glyphicon glyphicon-lock form-control-feedback"></span>
									<?= isset($error['user_password']) ? '<span class="help-block">'.$error["user_password"].'</span>' : '' ?>
								</div>
								
								<div class="form-group <?= isset($error['confirm_pwd']) ? 'has-error' : 'has-feedback' ?>">
									<input type="password" class="form-control" name="confirm_pwd" id="confirm_pwd" placeholder="Retype password" value="">
									<span class="glyphicon glyphicon-log-in form-control-feedback"></span>
									<?= isset($error['confirm_pwd']) ? '<span class="help-block">'.$error["confirm_pwd"].'</span>' : '' ?>
								</div>
								<div class="form-group <?= isset($error['pincode']) ? 'has-error' : 'has-feedback' ?>">
									<input type="text" class="form-control" name="pincode" id="pincode" placeholder="Pincode" value="<?= isset($user->pincode) ? $user->pincode : '' ?>">
									<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
									<?= isset($error['pincode']) ? '<span class="help-block">'.$error["pincode"].'</span>' : '' ?>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group has-feedback">
									<select class="form-control" id="city" name="city">
										<option value="default" selected="selected">please select city</option>	
										<option value="indore" <?php if(isset($user->city)?$user->city == 'indore':'') echo 'selected="selected"' ?>>Indore</option>
										<option value="mumbai" <?php if(isset($user->city)?$user->city == 'mumbai':'') echo 'selected="selected"' ?>>Mumbai</option>
										<option value="chennai" <?php if(isset($user->city)?$user->city == 'chennai':'') echo 'selected="selected"' ?>>Chennai</option>
										<option value="kolkatta" <?php if(isset($user->city)?$user->city == 'kolkatta':'') echo 'selected="selected"' ?>>kolkatta</option>			  		  
										<option value="delhi" <?php if(isset($user->city)?$user->city == 'delhi':'') echo 'selected="selected"' ?>>Delhi</option>
										<option value="pune" <?php if(isset($user->city)?$user->city == 'pune':'') echo 'selected="selected"' ?>>pune</option>
										<option value="bengular" <?php if(isset($user->city)?$user->city == 'bengular':'') echo 'selected="selected"' ?>>bengular</option>
										<option value="kochi" <?php if(isset($user->city)?$user->city == 'kochi':'') echo 'selected="selected"' ?>>kochi</option>
									</select>
								</div>
								<div class="form-group has-feedback">
									<textarea class="form-control" name="address" id="address" rows="5" placeholder="Enter Address"><?= isset($user->address) ? $user->address : '' ?></textarea>
								</div>
								
								<div class="col-md-12">
									<div class="col-md-6">
										<div class="form-group <?= isset($error['user_img']) ? 'has-error' : 'has-feedback' ?>">
											<label for="exampleInputFile">File input</label>
											<input type="file" name="user_img" id="user_img">

											<?= isset($error['user_img']) ? '<p class="help-block">'.$error["user_img"].'</p>' : '' ?>
										</div>
									</div>
									<div class="col-md-6">
										<img id="userImg_thumb" onchange="readURL(this);" src="<?= base_url.$user->user_img; ?>" height="128" width="128" >
									</div>
								</div>
							</div>
						</div>
						<!-- /.box-body -->

						<div class="box-footer">
							<input type="submit" name="submit" value="update" class="btn btn-primary">
						</div>
					</form>
				</div>
				<!-- /.box -->
			</div>
		</div>
		<!-- /.row -->
	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->