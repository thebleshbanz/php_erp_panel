<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Customer Tables</h1>
		<ol class="breadcrumb">
			<li><a href="<?= base_url; ?>/dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="<?= base_url; ?>/customer.php">Customer</a></li>
			<li class="active">views</li>
		</ol>
	</section>

	<!-- Main content -->
	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">Customer Data Table</h3>
						<a class="btn btn-info btn-xs" href="<?= base_url.'customer.php?action=add' ?>" >Add</a>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						<table id="customer_table" class="table table-bordered table-hover">
							<thead>
								<tr>
									<th>Customer No.</th>
									<th>Customer Name</th>
									<th>Contact Full Name</th>
									<th>Phone</th>
									<th>Sales Rep Employee</th>
									<th>Credit Limit</th>
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
		var dataTable = $('#customer_table').dataTable(
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
			"dom"			: 'Blfrtip',
			"buttons" : [ 
				'copy', 'excel', 'print'
			],
			"ajax"	: {
				url	:	base_url+"customer.php",
				type:	"POST",
				data:	{'ajaxType':'customerList'}
			},
			"columns":[
				{"name" : "customerNumber"},
				{"name" : "customerName"},
				{"name" : "contactFullName"},
				{"name" : "phone"},
				{"name" : "salesRepEmployeeNumber"},
				{"name" : "creditLimit"},
				{"name" : "action" }
			]
		});
	});
</script>