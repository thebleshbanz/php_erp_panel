<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Main content -->
	<section class="content">
		<div class="row">
			<div class="col-md-12">
				<!-- general form elements -->
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title">Delete User</h3>
					</div>
					<!-- /.box-header -->
					<!-- form start -->
					<form method="post" action="<?php echo $_SERVER['REQUEST_URI'];?>" enctype="multipart/form-data">
						<input type="hidden" name="user_id" value="<?= $user->user_id; ?>">
						<div class="box-body">
							<div class="col-md-6">
								
								<div class="form-group has-feedback">
									<input disabled type="text" class="form-control" name="fullname" id="fullname" placeholder="Full name" value="<?= isset($user->user_fname) ? $user->user_fname.' '.$user->user_lname : '' ?>">
									<span class="glyphicon glyphicon-user form-control-feedback"></span>
								</div>
								
								<div class="form-group has-feedback">
									<input disabled type="text" class="form-control" name="user_email" id="user_email" placeholder="Email" value="<?= isset($user->user_email) ? $user->user_email : '' ?>">
									<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
								</div>
								
								<div class="form-group has-feedback">
									<input disabled type="text" class="form-control" name="user_mobile" id="user_mobile" placeholder="Mobile" value="<?= isset($user->user_mobile) ? $user->user_mobile : '' ?>">
									<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
								</div>
								
								<div class="form-group has-feedback">
									<input disabled type="text" class="form-control" name="pincode" id="pincode" placeholder="Pincode" value="<?= isset($user->pincode) ? $user->pincode : '' ?>">
									<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group has-feedback">
									<select disabled class="form-control" id="city" name="city">
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
									<textarea disabled class="form-control" name="address" id="address" rows="5" placeholder="Enter Address"><?= isset($user->address) ? $user->address : '' ?></textarea>
								</div>
								
								<div class="col-md-12">
									<div class="col-md-6">
										<img id="userImg_thumb" onchange="readURL(this);" src="<?= base_url.$user->user_img; ?>" height="128" width="128" >
									</div>
								</div>
							</div>
						</div>
						<!-- /.box-body -->

						<div class="box-footer">
							<input type="submit" name="submit" value="delete" class="btn btn-danger">
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