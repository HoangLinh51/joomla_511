<?php 
	$jinput = JFactory::getApplication()->input;
	$format = $jinput->getString('format','');
?>
<div id="ds_dgcbcc_errorsql">
	<h2 class="header">Danh sách lỗi của đánh giá cán bộ công chức
		<!-- <div class="pull-right">
			<span class="btn btn-small btn-success" id="btn_them_dgcbcc_errorsql" href="#modal-form" data-toggle="modal">Thêm mới</span>
			<span class="btn btn-small btn-danger" id="btn_xoanhieu_dgcbcc_errorsql">Xóa</span>
		</div> -->
	</h2>
	<div class="accordion-group">
		<div class="accordion-heading">
			<a href="#collapseFour" data-toggle="collapse" class="accordion-toggle collapsed">Tìm kiếm</a>
		</div>
		<div class="accordion-body collapse" id="collapseFour">
			<div class="accordion-inner">
				<form class="form-horizontal">
					<div class="row-fluid">
						<div class="span12">
							<label class="span3 control-label">Tên lỗi:</label>
							<div class="span5">
								<input type="text" class="span12" id="tk_dgcbcc_errorsql_name">
							</div>
						</div>
						<div class="span12 center">
							<span class="btn btn-small btn-info" id="btn_tk_dgcbcc_errorsql">Tìm kiếm</span>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div id="table_dgcbcc_errorsql" style="margin-top:1%"></div>
</div>
<!-- <?php if($format==''){ ?>
<div id="content"></div>
<div id="modal-form" class="modal hide" tabindex="-1" style="width:900px;left:35%;"></div>
<?php }?> -->
<script>
	var reset_dgcbcc_errorsql = function(){
		var tk_dgcbcc_errorsql_name 			= jQuery('#tk_dgcbcc_errorsql_name').val();
		var oTable2				= jQuery('#tbl_dgcbcc_errorsql').DataTable({
			"ajax": {
				"url":"<?php echo JUri::base(true);?>/index.php?option=com_danhmuc&controller=danhgia&task=loadTable&format=raw&tk_dgcbcc_errorsql_name="+tk_dgcbcc_errorsql_name,
				"type":"POST"
			},
			"oLanguage": {
	           	"sUrl": "<?php echo JUri::base(true);?>/media/cbcc/js/dataTables.vietnam.txt"
	        },
	        "sDom": "<'dataTables_wrapper'C<'clear'><'row-fluid'<'span3'f><'span3'<'pull-right'rT>><'span6'p>t<'row-fluid'<'span2'l><'span4'i><'span6'p>>>",
	 		"oTableTools": {
	 			"sSwfPath": "<?php echo JUri::base(true);?>/media/cbcc/js/dataTables-1.10.0/swf/copy_csv_xls_pdf.swf",		
	          	"aButtons": [
					{
						"sExtends": "xls",
						"sButtonText": "Excel",
						"mColumns": [ 1,2,3],
						"sFileName": "dot.xls"
					},
				]
	 		},
	  	  	"columnDefs": [
				{
					"targets": 0,
					"searchable": false,
					"orderable": false,
					"render": function(data, type, full, meta){
						return full[0];
					}
				},
				{
					"targets": 1,
					"searchable": true,
					"orderable": false,
					"render": function(data, type, full, meta){
						return full[1];
						
						
					}
				},
				{
					"targets": 2,
					"searchable": true,
					"orderable":false,
					// "orderData": false,
					"render": function(data, type, full, meta){
						return full[2];
					}
				},
				{
					"targets": 3,
					"searchable": true,
					"orderable": true,
					"render": function(data, type, full, meta){
						return full[3];					
					}
				},
				{
					"targets": [0,1,3],
				    "createdCell": function(td, cellData, rowData, row, col){
						jQuery(td).attr('style', 'vertical-align:middle;text-align:center;');
					}
				},
				// {
				// 	"targets": [1,2],
				//     "createdCell": function(td, cellData, rowData, row, col){
				//     	jQuery(td).attr('style', 'vertical-align:middle;');
				// 	}
				// },
				
			],
			"order": [[1, "asc" ]],
			"searchDelay": "1000",
	    	"serverSide": true,
			"stateSave": true
		});
	}
	jQuery(document).ready(function($){
		$('#btn_tk_dgcbcc_errorsql').on('click',function(){
			$.blockUI();
			$('#table_dgcbcc_errorsql').load('index.php?option=com_danhmuc&controller=danhgia&task=table_dgcbcc_errorsql&format=raw',function(){
				$.unblockUI();
			})
		});
		$('#btn_tk_dgcbcc_errorsql').click();
	});
</script>