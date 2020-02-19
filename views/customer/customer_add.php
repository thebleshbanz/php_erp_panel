<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Customer Add</h1>
		<ol class="breadcrumb">
			<li><a href="<?= base_url; ?>/dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="<?= base_url; ?>/customer.php">Customer</a></li>
			<li class="active">add</li>
		</ol>
	</section>
	<!-- Main content -->
	<section class="content">
		<div class="row">
			<div class="col-md-12">
				<!-- general form elements -->
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title">Add Customer</h3>
					</div>
					<!-- /.box-header -->
					<!-- form start -->
					<form method="post" action="<?php echo $_SERVER['REQUEST_URI'];?>" enctype="multipart/form-data">
						<div class="box-body">
							<div class="col-md-6">
								
								<div class="form-group <?= isset($error['customerName']) ? 'has-error' : 'has-feedback' ?>">
									<input type="text" class="form-control" name="customerName" id="customerName" placeholder="Full name" value="<?= isset($_POST['customerName']) ? $_POST['customerName'] : '' ?>">
									<span class="glyphicon glyphicon-user form-control-feedback"></span>
									<?= isset($error['customerName']) ? '<span class="help-block">'.$error["customerName"].'</span>' : '' ?>
								</div>
								
								<div class="form-group <?= isset($error['contactFullName']) ? 'has-error' : 'has-feedback' ?>">
									<input type="text" class="form-control" name="contactFullName" id="contactFullName" placeholder="Enter Contact Full Name with spance" value="<?= isset($_POST['contactFullName']) ? $_POST['contactFullName'] : '' ?>">
									<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
									<?= isset($error['contactFullName']) ? '<span class="help-block">'.$error["contactFullName"].'</span>' : '' ?>
								</div>
								
								<div class="form-group <?= isset($error['phone']) ? 'has-error' : 'has-feedback' ?>">
									<input type="text" class="form-control" name="phone" id="phone" placeholder="Mobile" value="<?= isset($_POST['phone']) ? $_POST['phone'] : '' ?>">
									<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
									<?= isset($error['phone']) ? '<span class="help-block">'.$error["phone"].'</span>' : '' ?>
								</div>

								<div class="form-group <?= isset($error['salesRepEmployeeNumber']) ? 'has-error' : 'has-feedback' ?>">
									<select class="form-control select2" id="salesRepEmployeeNumber" name="salesRepEmployeeNumber">
										<option value="" selected="selected">no employee</option>
										<?php
											$post_emp_id = isset($_POST['salesRepEmployeeNumber']) ? $_POST['salesRepEmployeeNumber'] : 0;
											if(!empty($employees)){
												foreach($employees as $employee){
											?>
												<option value="<?= $employee->employeeNumber ?>" <?php echo ($post_emp_id == $employee->employeeNumber) ? 'selected' : ''; ?> ><?= $employee->firstName.' '.$employee->lastName; ?></option>
											<?php
												}
											}
										?>
									</select>
									<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
									<?= isset($error['salesRepEmployeeNumber']) ? '<span class="help-block">'.$error["salesRepEmployeeNumber"].'</span>' : '' ?>
								</div>

								<div class="form-group <?= isset($error['country']) ? 'has-error' : 'has-feedback' ?>">
									<select class="form-control select2" id="country" name="country">
										<option value="" selected="selected">no country</option>
										<?php
											$post_country_id = isset($_POST['country']) ? $_POST['country'] : 0;
											if(!empty($countries)){
												foreach($countries as $country){
											?>
												<option value="<?= $country->country_id ?>" <?php echo ($post_country_id == $country->country_id) ? 'selected' : ''; ?> ><?= $country->country_name; ?></option>
											<?php
												}
											}
										?>
									</select>
									<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
									<?= isset($error['country']) ? '<span class="help-block">'.$error["country"].'</span>' : '' ?>
								</div>

								<div class="form-group <?= isset($error['state']) ? 'has-error' : 'has-feedback' ?>">
									<select class="form-control select2" id="state_id" name="state">
										<option value="" selected="selected">no state</option>
									</select>
									<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
									<?= isset($error['state']) ? '<span class="help-block">'.$error["state"].'</span>' : '' ?>
								</div>

								<div class="form-group <?= isset($error['creditLimit']) ? 'has-error' : 'has-feedback' ?>">
									<input type="text" class="form-control" name="creditLimit" id="creditLimit" placeholder="credit Limit" value="<?= isset($_POST['creditLimit']) ? $_POST['creditLimit'] : '' ?>">
									<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
									<?= isset($error['creditLimit']) ? '<span class="help-block">'.$error["creditLimit"].'</span>' : '' ?>
								</div>

							</div>

							<div class="col-md-6">
								<div class="form-group <?= isset($error['city']) ? 'has-error' : 'has-feedback' ?>">
									<input type="text" class="form-control" name="city" id="city" placeholder="Enter city" value="<?= isset($_POST['city']) ? $_POST['city'] : '' ?>">
									<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
									<?= isset($error['city']) ? '<span class="help-block">'.$error["city"].'</span>' : '' ?>
								</div>
								
								<div class="form-group <?= isset($error['postalCode']) ? 'has-error' : 'has-feedback' ?>">
									<input type="text" class="form-control" name="postalCode" id="postalCode" placeholder="postalCode" value="<?= isset($_POST['postalCode']) ? $_POST['postalCode'] : '';?>">
									<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
									<?= isset($error['postalCode']) ? '<span class="help-block">'.$error["postalCode"].'</span>' : '' ?>
								</div>

								<div class="form-group has-feedback">
									<textarea class="form-control" name="addressLine1" id="addressLine1" rows="5" placeholder="Enter address Line 1"><?= isset($_POST['addressLine1']) ? $_POST['addressLine1'] : '' ?></textarea>
								</div>

								<div class="form-group has-feedback">
									<textarea class="form-control" name="addressLine2" id="addressLine2" rows="5" placeholder="Enter address Line 2"><?= isset($_POST['addressLine2']) ? $_POST['addressLine2'] : '' ?></textarea>
								</div>
							</div>
						</div>
						<!-- /.box-body -->

						<div class="box-footer">
							<input type="submit" name="submit" value="add" class="btn btn-primary">
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