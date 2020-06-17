<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>User Tables</h1>
		<ol class="breadcrumb">
			<li><a href="<?= base_url; ?>/dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="<?= base_url; ?>/user.php">User</a></li>
			<li class="active">views</li>
		</ol>
	</section>

	<!-- Main content -->
	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">User Data Table</h3>
						<a class="btn btn-info btn-xs" href="<?= base_url.'user.php?action=add' ?>" >Add</a>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						<table id="user_table" class="table table-bordered table-hover">
							<thead>
								<tr>
									<th>Sr.No.</th>
									<th>Full Name</th>
									<th>Email</th>
									<th>Mobile</th>
									<th>City</th>
									<th>Pincode</th>
									<th>Status</th>
									<th>Date</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								
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
	$(document).ready(function()
	{
		var dataTable = $('#user_table').dataTable(
		{
			"processing"	: true,
			"serverSide"	: true,
			"paging"		: true,
			"searching"		: true,
			"responsive"	: true, 
			"ordering"		: true,
			"order"			: [[1,"asc"]],
			'lengthChange'	: false,
			'info'        	: true,
			'autoWidth'   	: false,
			// "ajax"			: base_url+"user.php",
			"dom"			: 'Blfrtip',
			"buttons" : [ 
				'copy', 'excel', 'print'
			],
			"ajax"	: {
				url	:	base_url+"user.php",
				type:	"POST",
				data:	{'ajaxType':'userList'}
			},
			"columns":[
				{"name" : "user_id"},
				{"name" : "user_fname"},
				{"name" : "user_email"},
				{"name" : "user_mobile"},
				{"name" : "city"},
				{"name" : "pincode"},
				{"name" : "user_status"},
				{"name" : "created_at"},
				{"name" : "action" }
			]
		});
	});
</script>
<!-- 
"processing": true,
"serverSide": true,
"lengthChange": true,
"info":false,
"paging":   true,
"searching":true,
"language": {
		searchPlaceholder: "AadharCardNo, Licence, weapon No."
	},
"ordering": true,
"responsive": true, 
"order": [[ 0, "asc" ]],
"dom": 'Blfrtip',
"buttons": [ 
			'copy', 'excel', 'print'
			],
"ajax":{
		url	:	"../ajax/datatable_server.php",
		type:	"POST",
		data:	{'action':'individual_reports'}
},
 -->