<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Employee Delete</h1>
		<ol class="breadcrumb">
			<li><a href="<?= base_url; ?>/dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="<?= base_url; ?>/employee.php">Employee</a></li>
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
						<h3 class="box-title">Delete Employee</h3>
					</div>
					<!-- /.box-header -->
					<!-- form start -->
					<form method="post" action="<?php echo $_SERVER['REQUEST_URI'];?>" enctype="multipart/form-data">
						<input type="hidden" name="employeeNumber" value="<?= $employee->employeeNumber; ?>">
						<div class="box-body">
							<div class="col-md-6">
								<div class="form-group has-feedback">
									<input disabled type="text" class="form-control" name="employeeName" id="employeeName" placeholder="Employee Full name" value="<?= isset($employee->firstName) ? $employee->firstName." ".$employee->lastName : '' ?>">
									<span class="glyphicon glyphicon-user form-control-feedback"></span>
								</div>
								
								<div class="form-group has-feedback">
									<input disabled type="text" class="form-control" name="extension" id="extension" placeholder="Extension" value="<?= isset($employee->extension) ? $employee->extension : '' ?>">
									<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
								</div>
								
								<div class="form-group has-feedback">
									<input disabled type="text" class="form-control" name="email" id="email" placeholder="Email" value="<?= isset($employee->email) ? $employee->email : '' ?>">
									<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group has-feedback">
									<select disabled class="form-control select2" id="officeCode" name="officeCode">
										<option value="" selected="selected">Select Office Code</option>
										<?php
											$post_office_code = isset($employee->officeCode) ? $employee->officeCode : 0;
											if(!empty($offices)){
												foreach($offices as $office){
											?>
												<option value="<?= $office->officeCode ?>" <?php echo ($post_office_code == $office->officeCode) ? 'selected' : ''; ?> ><?= "(".$office->addressLine1." - ".$office->city."-".$office->state."-".$office->country.")"; ?></option>
											<?php
												}
											}
										?>
									</select>
									<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
								</div>

								<div class="form-group has-feedback">
									<select disabled class="form-control" id="jobTitle" name="jobTitle">
										<option value="">Select Job Title</option>
										<option disabled value="President">President</option>
										<option <?= ($employee->jobTitle == 'Sale Manager (EMEA)') ? " selected" : ''; ?>value="Sale Manager (EMEA)">Sale Manager (EMEA)</option>
										<option <?= ($employee->jobTitle == 'Sales Manager (APAC)')  ? " selected" : ''; ?>value="Sales Manager (APAC)">Sales Manager (APAC)</option>
										<option <?= ($employee->jobTitle == 'Sales Manager (NA)')  ? " selected" : ''; ?>value="Sales Manager (NA)">Sales Manager (NA)</option>
										<option <?= ($employee->jobTitle == 'Sales Rep')  ? " selected" : ''; ?>value="Sales Rep">Sales Rep</option>
									</select>
									<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
								</div>

								<div class="form-group has-feedback">
									<select disabled class="form-control select2" id="reportsTo" name="reportsTo">
										<option value="">Select Report To</option>
										<?php
											$post_report_to = isset($employee->reportsTo) ? $employee->reportsTo : 0;
											if(!empty($reportTo_res)){
												foreach($reportTo_res as $value){
											?>
												<option value="<?= $value->employeeNumber ?>" <?php echo ($post_report_to == $value->employeeNumber) ? 'selected' : ''; ?> ><?= $value->firstName.' '.$value->lastName; ?></option>
											<?php
												}
											}
										?>
									</select>
									<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
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