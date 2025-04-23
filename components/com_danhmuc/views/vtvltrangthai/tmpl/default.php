<?php 
defined('_JEXEC') or die('Restricted access');
$user = JFactory::getUser();
$loaicongviec = $this->loaicongviec;
?>
<div id="div_danhsach">
<!-- <h3 class="header smaller lighter blue">Quản lý Loại phụ cấp

</h3> -->
	<div class="widget-box">
		<div class="widget-header header-color-blue">
			<h5>Bộ lọc danh sách</h5>
			<div class="widget-toolbar no-border">
				<span class="btn btn-mini btn-light" id="btn_flt_trangthai"><i class="icon-flt"></i> Lọc danh sách</span>
			</div>
			<div class="widget-toolbar">
				<a data-action="reload" id="btn-reload" href="#"><i class="icon-refresh"></i> Làm mới</a>
			</div>
			<div class="widget-toolbar">
				<a data-action="collapse" href="#"><i class="icon-chevron-up"></i> Thu gọn</a>
			</div>
		</div>
		<div class="widget-body">
			<div class="widget-main form-horizontal">
				<div class="row-fluid">
					<div class="control-group span5" style="float:left">
						<label class="control-label">Tên</label>
						<div class="controls">
							<input type="text" name="flt_ten_trangthai" id="flt_ten_trangthai">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="widget-box">
		<div class="widget-header">
			<h4>Danh sách Mức độ năng lực</h4>
			<div class="widget-toolbar">
				<a id="btn_themmoi_vtvltrangthai" href="#div_modal" data-toggle="modal" ><i class="icon-plus"></i> Thêm mới</a>
			</div>
			<div class="widget-toolbar">
				<a id="btn_xoa_vtvltrangthai" href="javascript:void(0);"><i class="icon-remove"></i> Xóa</a>
			</div>
			<div class="widget-toolbar">
				<a data-action="collapse" href="#"><i class="icon-chevron-up"></i> Thu gọn</a>
			</div>
		</div>
		<div class="widget-body">
			<div class="widget-main form-horizontal" id="div_ketqua_vtvltrangthai">
			</div>
		</div>
	</div>
</div>
<script>
var resetVtvltrangthai = function(){
    let flt_ten = jQuery('#flt_ten_trangthai').val();
	let oTable1 = jQuery('#table_thongtinchung_vtvltrangthai').DataTable( {
		"ajax": {
			"url":"index.php?option=com_danhmuc&controller=vtvltrangthai&format=raw&task=dataFilter&flt_ten="+flt_ten,
			"type":"POST"
		},
		"oLanguage": {
            "sUrl": "media/cbcc/js/dataTables.vietnam.txt"
        },
        "sDom": "<'dataTables_wrapper'C<'clear'><'row-fluid'<'span3'><'span3'<'pull-right'r>><'span6'p>t<'row-fluid'<'span2'l><'span4'i><'span6'p>>>",
  	  	"columnDefs": [
			{
				"targets": 0,
				"searchable": false,
				"orderable": false,
				"render": function(data, type, full, meta){
					return '<input type="checkbox" class="ace-checkbox-2 id" name="id[]" value="' + data +'" /><span class="lbl"></span>';
				}
			},
			{
				"targets": 1,
				"searchable": true,
				"orderable": false,
				"render": function(data, type, full, meta){
					return '<a class="btn_edit_vtvltrangthai" href="#div_modal" data-toggle="modal" data-id="' + full[0] + '">' + full[1] + '</a>';
					
					
				}
			},
			{
				"targets": 2,
				"searchable": true,
				"orderable": false,	
				"render": function(data, type, full, meta){
					return data
				}
			},
			{
				"targets": 3,
				"searchable": true,
				"orderable": false,
				"render": function(data, type, full, meta){
					return data;
				}
			},
			{
				"targets": 4,
				"searchable": true,
				"orderable": false,
				"render": function(data, type, full, meta){
					return 	'<span class="btn btn-mini btn-success btn_edit_vtvltrangthai" href="#div_modal" data-toggle="modal" data-id=' + full[0] + '><i class="icon-pencil"></i> Hiệu chỉnh</span>';
				}
			},
			{
				"targets": [0,2,3,4],
			    "createdCell": function(td, cellData, rowData, row, col){
					jQuery(td).attr('style', 'vertical-align:middle;text-align:center;');
				}
			},
			{
				"targets": [1,2],
			    "createdCell": function(td, cellData, rowData, row, col){
			    	jQuery(td).attr('style', 'vertical-align:middle;');
				}
			},
			
		],
		// "order": [[ 3, "desc" ]],
		"searchDelay": "1000",
    	"serverSide": true,
	    // "stateSave": true
	}).on( 'processing.dt', function ( e, settings, processing ) {		
		jQuery('.DTTT_button_text').removeClass('DTTT_disabled');
        if(processing){
        	jQuery.blockUI();    
        }else{
        	jQuery.unblockUI();
        }
    });
    
}
jQuery(document).ready(function($){
	$('body').delegate('.btn_edit_vtvltrangthai','click', function(){
		let id = $(this).data('id');
		$('#div_modal').load('index.php?option=com_danhmuc&view=vtvltrangthai&format=raw&task=frm&id='+id, function(){

		});
	})
	$('body').delegate('#btn_themmoi_vtvltrangthai','click', function(){
		$('#div_modal').load('index.php?option=com_danhmuc&view=vtvltrangthai&format=raw&task=frm', function(){

		});
	})
	$('.chosen').chosen({search_contains: true});
	$('.date-picker').datepicker( {format: 'dd/mm/yyyy', allowInputToggle: true}).on('changeDate', function (ev) {
	    $(this).datepicker('hide');
	});
	$('.input-mask-date').mask('99/99/9999');
	$('#btn-reload').on('click', function(){
		$('#dot_id option:first-child').attr("selected", "selected");
		$('#dot_id').trigger('chosen:updated');
		$('#donvi_id').val('');
		$('#donvi_id').trigger('chosen:updated');
		$('#capdonvi_id').val('');
		$('#capdonvi_id').trigger('chosen:updated');
		$('#flt_ngaybatdau').val('');
		$('#flt_ngayketthuc').val('');
	});
	$('#btn_flt_trangthai').on('click', function(){
		$('#div_ketqua_vtvltrangthai').html('');
		$('#div_ketqua_vtvltrangthai').load('index.php?option=com_danhmuc&view=vtvltrangthai&format=raw&task=danhsach',function(){
			$.unblockUI();
		});
	});
	$('#btn_flt_trangthai').click();
	$('#loaicongviec_id').on('change', function(){
		$('#btn_flt_trangthai').click();
	})
	$('#btn_xoa_vtvltrangthai').on('click', function(){
		var id = [];
		$(".id:checked").each(function() {
			id.push($(this).val());
		});
		if (id.length>0){
			if(confirm('BẠN CÓ CHẮC CHẮN XÓA?')){
				$.ajax({
	            type: "POST",
	            url: "index.php?option=com_danhmuc&controller=vtvltrangthai&task=xoa&format=raw",			  
	            data:{id:id},
	            beforeSend: function(){
	            	$.blockUI();	
	            },
	            success: function (data){
	                if(data == true){
	                	$('.gritter-item-wrapper').remove();
	                	loadNoticeBoardSuccess('Thông báo','Xử lý thành công.');
	                	$('#btn_flt_trangthai').trigger('click');
	                }else{
	                	$('.gritter-item-wrapper').remove();
	                	loadNoticeBoardError('Thông báo','Xử lý không thành công. Vui lòng liên hệ quản trị viên!');
	                }
	            	$.unblockUI();
	            },
	            error: function(){
	            	$.unblockUI();
	            	$('.gritter-item-wrapper').remove();
                	loadNoticeBoardError('Thông báo','Xử lý không thành công. Vui lòng liên hệ quản trị viên!');
	            }
			});
			}
		}
		else {
			$('.gritter-item-wrapper').remove();
			loadNoticeBoardError("Thông báo","Vui lòng chọn dữ liệu cần xóa!!");
		}
	})
	$('body').delegate('.btn_remove_donvi_tmp','click', function(){
		$(this).closest ('tr').remove ();
	})
});
</script>