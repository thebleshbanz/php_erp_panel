<footer class="main-footer">
	<div class="pull-right hidden-xs">
		<b>Version</b> 2.4.0
	</div>
	<strong>Copyright &copy; 2020 <a href="javascript:;">Blesh Banz</a>.</strong> All rights
	reserved.
</footer>

<!-- Add the sidebar's background. This div must be placed
	immediately after the control sidebar -->
	<div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->


<!-- DataTables -->
<script src="<?= base_url; ?>assets/adminLTE/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url; ?>assets/adminLTE/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?= base_url; ?>assets/adminLTE/bower_components/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
	$.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="<?= base_url; ?>assets/adminLTE/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Morris.js charts -->
<script src="<?= base_url; ?>assets/adminLTE/bower_components/raphael/raphael.min.js"></script>
<script src="<?= base_url; ?>assets/adminLTE/bower_components/morris.js/morris.min.js"></script>
<!-- Sparkline -->
<script src="<?= base_url; ?>assets/adminLTE/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="<?= base_url; ?>assets/adminLTE/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?= base_url; ?>assets/adminLTE/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="<?= base_url; ?>assets/adminLTE/bower_components/jquery-knob/dist/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="<?= base_url; ?>assets/adminLTE/bower_components/moment/min/moment.min.js"></script>
<script src="<?= base_url; ?>assets/adminLTE/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="<?= base_url; ?>assets/adminLTE/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="<?= base_url; ?>assets/adminLTE/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="<?= base_url; ?>assets/adminLTE/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?= base_url; ?>assets/adminLTE/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?= base_url; ?>assets/adminLTE/dist/js/adminlte.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?= base_url; ?>assets/adminLTE/dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?= base_url; ?>assets/adminLTE/dist/js/demo.js"></script>
<!-- Select2 -->
<script src="<?= base_url; ?>assets/adminLTE/bower_components/select2/dist/js/select2.full.min.js"></script>
</body>
</html>
<script type="text/javascript">
$(function(){
	//Initialize Select2 Elements
    $('.select2').select2()

    $(document).on('change', '#country', function(){
    	if($(this).val() != ''){
    		$('#state_id').html("<option value=''>No State Selected</option>");
    		var country_id = $(this).val();
    		$.ajax({
    			url : base_url+'ajax/server.php',
    			type : 'post',
    			data : {'country_id':country_id, 'action': 'onChangeCountry'},
    			success : function(response){
    				var obj = JSON.parse(response);
    				if(obj.status){
    					var state_list = obj.res;
    					var html = '';
    					state_list.forEach(function(item, index){
    						// console.log('state_name -'+item.state_name+', index -'+index);
    						html = html+`<option value="`+item.state_id+`">`+item.state_name+`</option>`;
    					});
    					$('#state_id').append(html);
    				}
    			}
    		});
    	}
    });

});

function readURL(input) {
 	alert('change');
 	// console.log(input); return falses;
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#userImg_thumb')
                .attr('src', e.target.result)
                .width(128)
                .height(128);
        };

        reader.readAsDataURL(input.files[0]);
    }
}
</script>