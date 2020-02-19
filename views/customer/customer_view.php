<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Customer View</h1>
		<ol class="breadcrumb">
			<li><a href="<?= base_url; ?>/dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="<?= base_url; ?>/customer.php">Customer</a></li>
			<li class="active">view</li>
		</ol>
	</section>
	<!-- Main content -->
	<section class="content">
		<div class="row">
			<div class="col-md-12">
				<!-- general form elements -->
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title">View Customer</h3>
					</div>
					<!-- /.box-header -->
					<!-- form start -->
					<form method="post" action="<?php echo $_SERVER['REQUEST_URI'];?>" enctype="multipart/form-data">
						<input type="hidden" name="customerNumber" value="<?= $customer->customerNumber; ?>">
						<div class="box-body">
							<div class="col-md-6">
								
								<div class="form-group has-feedback">
									<input disabled type="text" class="form-control" name="customerName" id="customerName" placeholder="Full name" value="<?= isset($customer->customerName) ? $customer->customerName : '' ?>">
									<span class="glyphicon glyphicon-user form-control-feedback"></span>
								</div>
								
								<div class="form-group has-feedback">
									<input disabled type="text" class="form-control" name="contactFullName" id="contactFullName" placeholder="Enter Contact Full Name with spance" value="<?= (isset($customer->contactFirstName) && isset($customer->contactLastName) ) ? $customer->contactFirstName.' '.$customer->contactLastName : '' ?>">
									<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
								</div>
								
								<div class="form-group has-feedback">
									<input disabled type="text" class="form-control" name="phone" id="phone" placeholder="Mobile" value="<?= isset($customer->phone) ? $customer->phone : '' ?>">
									<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
								</div>

								<div class="form-group has-feedback">
									<select disabled class="form-control select2" id="salesRepEmployeeNumber" name="salesRepEmployeeNumber">
										<option value="" selected="selected">no employee</option>
										<?php
											$post_emp_id = isset($customer->salesRepEmployeeNumber) ? $customer->salesRepEmployeeNumber : 0;
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
								</div>

								<div class="form-group has-feedback">
									<select disabled class="form-control select2" id="country" name="country">
										<option value="" selected="selected">no country</option>
										<?php
											$post_country_id = isset($customer->country) ? $customer->country : 0;
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
								</div>

								<div class="form-group has-feedback">
									<select disabled class="form-control select2" id="state_id" name="state">
										<option value="" selected="selected">no state</option>
										<?php 
											$states =  $customer_db->getStateListByCountryID($post_country_id);
											$post_state_id = isset($customer->state) ? $customer->state : 0;
											if(!empty($states)){
												foreach($states as $state){
											?>
												<option value="<?= $state->state_id ?>" <?php echo ($post_state_id == $state->state_id) ? 'selected' : ''; ?> ><?= $state->state_name; ?></option>
											<?php
												}
											}
										?>
									</select>
									<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
								</div>

								<div class="form-group has-feedback">
									<input disabled type="text" class="form-control" name="creditLimit" id="creditLimit" placeholder="credit Limit" value="<?= isset($customer->creditLimit) ? $customer->creditLimit : '' ?>">
									<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
								</div>

							</div>

							<div class="col-md-6">
								<div class="form-group has-feedback">
									<input disabled type="text" class="form-control" name="city" id="city" placeholder="Enter city" value="<?= isset($customer->city) ? $customer->city : '' ?>">
									<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
								</div>
								
								<div class="form-group has-feedback">
									<input disabled type="text" class="form-control" name="postalCode" id="postalCode" placeholder="postalCode" value="<?= isset($customer->postalCode) ? $customer->postalCode : '';?>">
									<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
								</div>

								<div class="form-group has-feedback">
									<textarea disabled class="form-control" name="addressLine1" id="addressLine1" rows="5" placeholder="Enter address Line 1"><?= isset($customer->addressLine1) ? $customer->addressLine1 : '' ?></textarea>
								</div>

								<div class="form-group has-feedback">
									<textarea disabled class="form-control" name="addressLine2" id="addressLine2" rows="5" placeholder="Enter address Line 2"><?= isset($customer->addressLine2) ? $customer->addressLine2 : '' ?></textarea>
								</div>
							</div>
						</div>
						<!-- /.box-body -->

						<!-- <div class="box-footer">
							<input type="submit" name="submit" value="delete" class="btn btn-primary">
						</div> -->
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