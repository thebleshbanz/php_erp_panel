<style type="text/css">	
.error{
	color:#a94442;
}
.form-error{
	border: 1px solid #F44336;
}
</style>
<script type="text/javascript">
	var office_arr = ["addressLine1","addressLine2","phone","city","country","state_id","postalCode","territory"];
</script>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Office Tables</h1>
		<ol class="breadcrumb">
			<li><a href="<?= base_url; ?>/dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="<?= base_url; ?>/office.php">Office</a></li>
			<li class="active">views</li>
		</ol>
	</section>

	<!-- Main content -->
	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">Office Data Table</h3>
						<a class="btn btn-info btn-xs" href="javascript:;" id="addOffice" >Add</a>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						<table id="office_table" class="table table-bordered table-hover">
							<thead>
								<tr>
									<th>Office Code</th>
									<th>City</th>
									<th>Phone</th>
									<th>AddressLine 1</th>
									<th>AddressLine 2</th>
									<th>State</th>
									<th>Country</th>
									<th>PostalCode</th>
									<th>Territory</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php
									if(!empty($offices)){
										foreach($offices as $office){
								?>
									<tr>
										<td><?= $office->officeCode; ?></td>
										<td><?= $office->city; ?></td>
										<td><?= $office->phone; ?></td>
										<td><?= $office->addressLine1; ?></td>
										<td><?= $office->addressLine2; ?></td>
										<td><?= $office->state; ?></td>
										<td><?= $office->country; ?></td>
										<td><?= $office->postalCode; ?></td>
										<td><?= $office->territory; ?></td>
										<td><a style="color:blue;" href="javascript:;" class="viewOffice" data-officecode="<?= $office->officeCode; ?>">View</a> | 
											<a style="color:red;" href="javascript:;" class="deleteOffice" data-officecode="<?= $office->officeCode; ?>">Delete</a>
										</td>
									</tr>
								<?php
										}
									}
								?>
							</tbody>
						</table>
					</div>
					<!-- /.box-body -->
				</div>
				<!-- /.box -->
			</div>
			<!-- /.col -->
		</div>
		<!-- /.row -->
	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<!-- page script -->
<script type="text/javascript">	
	$(document).ready(function(){
		
		var table = $('#office_table').DataTable();
		
		$('#addOffice').click(function(){
			$("#addOfficeModal").modal({backdrop: false});
		});
		
		$('.viewOffice').click(function(){
			$("#viewOfficeModal").modal({backdrop: false});
			// console.log($(this).data('officecode'));
			var officeCode = $(this).data('officecode');
			$.ajax({
				type : 'POST',
				url : base_url+'ajax/server.php',
				data : {'action' : 'onClickOfficeView', 'officeCode' : officeCode},
				success : function(res){
					var view_obj = JSON.parse(res); // conver json string into object
					var office_row = view_obj.data;
					const entries = Object.entries(office_row); // conver obj into associative array 
					entries.forEach((entry) =>{ //loop on assoc array
						var input = $('#viewOfficeModal').find('.form-control');
						if(entry[0] == input.attr('name')){
							input.val(entry[1]);
						}
						/*console.log(entry[0]);
						console.log(entry[1]);*/
					});
				}
			});
			return false;
		});

		$(document).on('click', '#submitOfficeForm', function(e){
			e.preventDefault();
			if(formValidation()){
				var form_data = $('#addOfficeForm').serialize();
				$.ajax({
					type : 'POST',
					url  : base_url+'ajax/server.php',
					data : form_data + "&action=onSubmitOfficeForm",
					success : function(res){
						var obj = JSON.parse(res);
						if(obj.status){
							alert('Office add Successfuly');
							$("#addOfficeModal").modal('hide');
						}else{
							alert('please try again');
							$("#addOfficeModal").modal({backdrop: false});
						}
					},
				});
			}else{
				return false;
			}
		});
		
		$('.deleteOffice').on('click', function(){
			var officeCode = $(this).data('officecode');
			$.ajax({
				type : 'POST',
				url : base_url+'ajax/server.php',
				data : {'action' : 'onClickOfficeDelete', 'officeCode' : officeCode},
				success : function(res){
					var del_obj = JSON.parse(res); // conver json string into object
					if(del_obj.status == 1){
						alert('Office Delete Successfuly');
						Location.reload();
					}else{
						alert('please try again');
						Location.reload();
					}
				}
			});
		});

	});
</script>


<!-- Add Modal start -->
<div class="modal fade" id="addOfficeModal" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h4 class="modal-title">Add Office</h4>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" id="addOfficeForm" name="addOfficeForm" >
					<div class="row">
						<div class="col-md-12">
							
							<div class="form-group">
								<label class="control-label col-sm-3">Address Line 1<span class="text-danger">*</span></label>
								<div class="col-md-8 col-sm-8">
									<div class="input-group"> <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
										<textarea class="form-control" rows="3" name="addressLine1" id="addressLine1"></textarea>
									</div>
									<small class="error"></small>
							  	</div>
							</div>
							
							<div class="form-group">
								<label class="control-label col-sm-3">Address Line 2</label>
								<div class="col-md-8 col-sm-8">
									<div class="input-group"> <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
										<textarea class="form-control" rows="3" name="addressLine2" id="addressLine2"></textarea>
									</div>
							  	</div>
							</div>

							<div class="form-group"><!-- contact num. field start-->
							 	<label class="control-label col-sm-3">Phone <span class="text-danger">*</span></label>
							 	<div class="col-md-8 col-sm-8">
									<div class="input-group">
									  	<span class="input-group-addon"><i class="glyphicon glyphicon-phone"></i></span>
										<input type="text" class="form-control" name="phone" id="phone" placeholder="Enter your Primary contact no." value="">
									</div>
									<small class="error"></small>
							  	</div>
							</div><!-- contact num. field end-->

							<div class="form-group"><!-- city field start-->
								<label class="control-label col-sm-3">City<span class="text-danger">*</span></label>
								<div class="col-md-8 col-sm-8">
									<input type="text" class="form-control" name="city" id="city" placeholder="Enter your City " value="">
							  		<small class="error"></small>
							  	</div>
							</div><!-- city field end-->

							<div class="form-group">
								<label class="control-label col-sm-3">Country<span class="text-danger">*</span></label>
								<div class="col-md-8 col-sm-8">
									<div class="input-group">
										<span class="input-group-addon"><i class="glyphicon glyphicon-education"></i></span>
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
									</div>
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-sm-3">State<span class="text-danger">*</span></label>
								<div class="col-md-8 col-sm-8">
									<div class="input-group">
										<span class="input-group-addon"><i class="glyphicon glyphicon-education"></i></span>
										<select class="form-control select2" id="state_id" name="state">
											<option value="" selected="selected">no state</option>
										</select>
									</div>
								</div>
							</div>

							<div class="form-group"><!-- postal code field start-->
							 	<label class="control-label col-sm-3">Postal Code <span class="text-danger">*</span></label>
							 	<div class="col-md-8 col-sm-8">
									<div class="input-group">
									  	<span class="input-group-addon"><i class="glyphicon glyphicon-phone"></i></span>
										<input type="text" class="form-control" name="postalCode" id="postalCode" placeholder="Enter your Postal Code" value="">
									</div>
									<small class="error"></small>
							  	</div>
							</div><!-- postal code field end-->

							<div class="form-group"><!-- territory field start-->
								<label class="control-label col-sm-3">Territory</label>
								<div class="col-md-8 col-sm-8">
									<input type="text" class="form-control" name="territory" id="territory" placeholder="Enter your territory " value="">
							  	</div>
							</div><!-- territory field end-->
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<a src="javascript:;" class="btn btn-primary" id="submitOfficeForm">submit</a>
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>

	</div>
</div>
<!-- Add Modal End -->



<!-- View Modal start -->
<div class="modal fade" id="viewOfficeModal" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h4 class="modal-title">View Office</h4>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" id="viewOfficeForm" name="viewOfficeForm" >
					<div class="row">
						<div class="col-md-12">
							
							<div class="form-group">
								<label class="control-label col-sm-3">Address Line 1<span class="text-danger">*</span></label>
								<div class="col-md-8 col-sm-8">
									<div class="input-group"> <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
										<textarea class="form-control" rows="3" name="addressLine1" id="addressLine1"></textarea>
									</div>
									<small class="error"></small>
							  	</div>
							</div>
							
							<div class="form-group">
								<label class="control-label col-sm-3">Address Line 2</label>
								<div class="col-md-8 col-sm-8">
									<div class="input-group"> <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
										<textarea class="form-control" rows="3" name="addressLine2" id="addressLine2"></textarea>
									</div>
							  	</div>
							</div>

							<div class="form-group"><!-- contact num. field start-->
							 	<label class="control-label col-sm-3">Phone <span class="text-danger">*</span></label>
							 	<div class="col-md-8 col-sm-8">
									<div class="input-group">
									  	<span class="input-group-addon"><i class="glyphicon glyphicon-phone"></i></span>
										<input type="text" class="form-control" name="phone" id="phone" placeholder="Enter your Primary contact no." value="">
									</div>
									<small class="error"></small>
							  	</div>
							</div><!-- contact num. field end-->

							<div class="form-group"><!-- city field start-->
								<label class="control-label col-sm-3">City<span class="text-danger">*</span></label>
								<div class="col-md-8 col-sm-8">
									<input type="text" class="form-control" name="city" id="city" placeholder="Enter your City " value="">
							  		<small class="error"></small>
							  	</div>
							</div><!-- city field end-->

							<div class="form-group">
								<label class="control-label col-sm-3">Country<span class="text-danger">*</span></label>
								<div class="col-md-8 col-sm-8">
									<div class="input-group">
										<span class="input-group-addon"><i class="glyphicon glyphicon-education"></i></span>
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
									</div>
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-sm-3">State<span class="text-danger">*</span></label>
								<div class="col-md-8 col-sm-8">
									<div class="input-group">
										<span class="input-group-addon"><i class="glyphicon glyphicon-education"></i></span>
										<select class="form-control select2" id="state_id" name="state">
											<option value="" selected="selected">no state</option>
										</select>
									</div>
								</div>
							</div>

							<div class="form-group"><!-- postal code field start-->
							 	<label class="control-label col-sm-3">Postal Code <span class="text-danger">*</span></label>
							 	<div class="col-md-8 col-sm-8">
									<div class="input-group">
									  	<span class="input-group-addon"><i class="glyphicon glyphicon-phone"></i></span>
										<input type="text" class="form-control" name="postalCode" id="postalCode" placeholder="Enter your Postal Code" value="">
									</div>
									<small class="error"></small>
							  	</div>
							</div><!-- postal code field end-->

							<div class="form-group"><!-- territory field start-->
								<label class="control-label col-sm-3">Territory</label>
								<div class="col-md-8 col-sm-8">
									<input type="text" class="form-control" name="territory" id="territory" placeholder="Enter your territory " value="">
							  	</div>
							</div><!-- territory field end-->
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>

	</div>
</div>
<!-- View Modal End -->