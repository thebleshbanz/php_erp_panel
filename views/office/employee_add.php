<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Employee Add</h1>
		<ol class="breadcrumb">
			<li><a href="<?= base_url; ?>/dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="<?= base_url; ?>/employee.php">Employee</a></li>
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
						<h3 class="box-title">Add Employee</h3>
					</div>
					<!-- /.box-header -->
					<!-- form start -->
					<form method="post" action="<?php echo $_SERVER['REQUEST_URI'];?>" enctype="multipart/form-data">
						<div class="box-body">
							<div class="col-md-6">
								
								<div class="form-group <?= isset($error['employeeName']) ? 'has-error' : 'has-feedback' ?>">
									<input type="text" class="form-control" name="employeeName" id="employeeName" placeholder="Employee Full name" value="<?= isset($_POST['employeeName']) ? $_POST['employeeName'] : '' ?>">
									<span class="glyphicon glyphicon-user form-control-feedback"></span>
									<?= isset($error['employeeName']) ? '<span class="help-block">'.$error["employeeName"].'</span>' : '' ?>
								</div>
								
								<div class="form-group <?= isset($error['extension']) ? 'has-error' : 'has-feedback' ?>">
									<input type="text" class="form-control" name="extension" id="extension" placeholder="Extension" value="<?= isset($_POST['extension']) ? $_POST['extension'] : '' ?>">
									<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
									<?= isset($error['extension']) ? '<span class="help-block">'.$error["extension"].'</span>' : '' ?>
								</div>
								
								<div class="form-group <?= isset($error['email']) ? 'has-error' : 'has-feedback' ?>">
									<input type="text" class="form-control" name="email" id="email" placeholder="Email" value="<?= isset($_POST['email']) ? $_POST['email'] : '' ?>">
									<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
									<?= isset($error['email']) ? '<span class="help-block">'.$error["email"].'</span>' : '' ?>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group <?= isset($error['officeCode']) ? 'has-error' : 'has-feedback' ?>">
									<select class="form-control select2" id="officeCode" name="officeCode">
										<option value="" selected="selected">Select Office Code</option>
										<?php
											$post_office_code = isset($_POST['officeCode']) ? $_POST['officeCode'] : 0;
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
									<?= isset($error['officeCode']) ? '<span class="help-block">'.$error["officeCode"].'</span>' : '' ?>
								</div>

								<div class="form-group <?= isset($error['jobTitle']) ? 'has-error' : 'has-feedback' ?>">
									<select class="form-control" id="jobTitle" name="jobTitle">
										<option value="">Select Job Title</option>
										<option disabled value="President">President</option>
										<option value="Sale Manager (EMEA)">Sale Manager (EMEA)</option>
										<option value="Sales Manager (APAC)">Sales Manager (APAC)</option>
										<option value="Sales Manager (NA)">Sales Manager (NA)</option>
										<option value="Sales Rep">Sales Rep</option>
									</select>
									<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
									<?= isset($error['jobTitle']) ? '<span class="help-block">'.$error["jobTitle"].'</span>' : '' ?>
								</div>

								<div class="form-group <?= isset($error['reportsTo']) ? 'has-error' : 'has-feedback' ?>">
									<select class="form-control select2" id="reportsTo" name="reportsTo">
										<option value="">Select Report To</option>
									</select>
									<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
									<?= isset($error['reportsTo']) ? '<span class="help-block">'.$error["reportsTo"].'</span>' : '' ?>
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
<script type="text/javascript">
	$(function(){
		$(document).on('change', '#jobTitle', function(){
			if($(this).val() != ''){
				$('#reportsTo').html("<option value=''>Select Report To</option>");
				var jobTitle = $(this).val();
				$.ajax({
					url  : base_url+"ajax/server.php",
					type :"post",
					data : {'jobTitle' : jobTitle, 'action': 'onChangeJobTitle'},
					success : function(response){
						var obj = JSON.parse(response);
	    				if(obj.status){
	    					var reportTolist = obj.res;
	    					var html = '';
	    					reportTolist.forEach(function(item, index){
	    						// console.log('state_name -'+item.state_name+', index -'+index);
	    						html = html+`<option value="`+item.employeeNumber+`">`+item.firstName+` `+item.lastName+`(`+item.jobTitle+`)</option>`;
	    					});
	    					$('#reportsTo').append(html);
	    				}
					}
				});
			}
		})
	})
</script>