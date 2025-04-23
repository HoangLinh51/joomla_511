<?php
defined('_JEXEC') or die('Restricted access');
$user = JFactory::getUser();
$i4223 = Core::config('sync4223/is_use');
$t4223 = explode(',', Core::config('sync4223/tbl'));
$tinhthanh = Core::loadAssocListHasKey('city_code','*','code');
$tinhthanh_select = Core::loadAssocList('city_code','*','code>0 and daxoa=0','(code>0) asc, muctuongduong is null asc, name is null asc');
$quanhuyen = Core::loadAssocListHasKey('dist_code','*','code');
?>
<div id="div_danhsach">
	<div class="widget-box">
		<div class="widget-header header-color-blue">
			<h5>Bộ lọc danh sách</h5>
			<div class="widget-toolbar no-border">
				<span class="btn btn-mini btn-light" id="btn_flt_phuongxa"><i class="icon-flt"></i> Lọc danh sách</span>
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
							<input type="text" style="width: 100%" name="flt_ten_phuongxa" id="flt_ten_phuongxa">
						</div>
					</div>
					<div class="control-group span5" style="float:left">
						<label class="control-label">Trạng thái</label>
						<div class="controls">
							<div class="input-append">
								<select name="flt_trangthai_phuongxa" id="flt_trangthai_phuongxa">
									<option value="">--Tất cả--</option>
									<option value="1">Sử dụng</option>
									<option value="0">Không sử dụng</option>
								</select>
							</div>
						</div>
					</div>
				</div>
				<div class="row-fluid">
					<div class="control-group span10" style="float:left">
						<label class="control-label">Thuộc Tỉnh/thành</label>
						<div class="controls">
							<select name="flt_tinhthanh_phuongxa" id="flt_tinhthanh_phuongxa" multiple class="chosen" data-placeholder="-- Chọn Tỉnh thành --">
							<?php for($i=0; $n=count($tinhthanh_select), $i<$n; $i++){?>
								<option value="<?php echo $tinhthanh_select[$i]['code']?>"><?php echo $tinhthanh_select[$i]['name']?></option>
								<?php }?>
							</select>
						</div>
					</div>
				</div>
				<div class="row-fluid">
					<div class="control-group span10" style="float:left">
						<label class="control-label">Thuộc Quận/huyện</label>
						<div class="controls">
							<select name="flt_quanhuyen_phuongxa" id="flt_quanhuyen_phuongxa" multiple class="chosen" data-placeholder="-- Chọn Quận huyện --">
							</select>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="widget-box">
		<div class="widget-header">
			<h4>Danh sách Tỉnh thành</h4>
			<div class="widget-toolbar">
				<a id="btn_themmoi_phuongxa" href="#div_modal" data-toggle="modal"><i class="icon-plus"></i> Thêm mới</a>
			</div>
			<div class="widget-toolbar">
				<a id="btn_xoa_phuongxa" href="javascript:void(0);"><i class="icon-remove"></i> Xóa</a>
			</div>
			<div class="widget-toolbar">
				<a data-action="collapse" href="#"><i class="icon-chevron-up"></i> Thu gọn</a>
			</div>
		</div>
		<div class="widget-body">
			<div class="widget-main form-horizontal" id="div_ketqua_phuongxa">
			</div>
		</div>
	</div>
</div>
<script>
	var resetPhuongxa = function() {
		let tinhthanh = <?php echo json_encode($tinhthanh)?>;
		let quanhuyen = <?php echo json_encode($quanhuyen)?>;
		let flt_ten = jQuery('#flt_ten_phuongxa').val();
		let flt_trangthai = jQuery('#flt_trangthai_phuongxa option:selected').val();
		let flt_tinhthanh = jQuery('#flt_tinhthanh_phuongxa').val();
		let flt_quanhuyen = jQuery('#flt_quanhuyen_phuongxa').val();
		let oTable1 = jQuery('#table_thongtinchung_phuongxa').DataTable({
			"ajax": {
				"url": "index.php?option=com_danhmuc&controller=phuongxa&format=raw&task=dataFilter&flt_ten=" + flt_ten 
				+ "&flt_trangthai=" + flt_trangthai
				+ "&flt_tinhthanh=" + flt_tinhthanh
				+ "&flt_quanhuyen=" + flt_quanhuyen
				,
				"type": "POST"
			},
			"oLanguage": {
				"sUrl": "media/cbcc/js/dataTables.vietnam.txt"
			},
			"sDom": "<'dataTables_wrapper'C<'clear'><'row-fluid'<'span3'><'span3'<'pull-right'r>><'span6'p>t<'row-fluid'<'span2'l><'span4'i><'span6'p>>>",
			"columnDefs": [{
					"targets": 0,
					"searchable": false,
					"orderable": false,
					"render": function(data, type, full, meta) {
						if(data>0)
						return '<input type="checkbox" class="ace-checkbox-2 id" name="id[]" value="' + data + '" /><span class="lbl"></span>';
						else return '';
					}
				},
				{
					"targets": 1,
					"searchable": true,
					"orderable": false,
					"render": function(data, type, full, meta) {
						return '<a class="btn_edit_phuongxa" href="#div_modal" data-toggle="modal" data-id="' + full[0] + '">' + full[1] + '</a>';
					}
				},
				{
					"targets": 2,
					"searchable": true,
					"orderable": false,
					"render": function(data, type, full, meta) {
						return tinhthanh[data].name;
					}
				},
				{
					"targets": 3,
					"searchable": true,
					"orderable": false,
					"render": function(data, type, full, meta) {
						return quanhuyen[data].name;
					}
				},
				{
					"targets": 4,
					"searchable": true,
					"visible": <?php echo ($i4223 == 1 && in_array($this->tbl, $t4223)) == true ? 'true' : 'false'; ?>,
					"orderable": false,
					"render": function(data, type, full, meta) {
						return data;
					}
				},
				{
					"targets": 5,
					"searchable": true,
					"orderable": false,
					"render": function(data, type, full, meta) {
						if (data == 1)
							return '<i class="icon-ok blue"></i>';
						else
							return '<i class="icon-remove red"></i>';
					}
				},
				{
					"targets": 6,
					"searchable": true,
					"orderable": false,
					"render": function(data, type, full, meta) {
						return '<span class="btn btn-mini btn-success btn_edit_phuongxa" href="#div_modal" data-toggle="modal" data-id=' + full[0] + '><i class="icon-pencil"></i> Hiệu chỉnh</span>';
					}
				},
				{
					"targets": [0, 3, 4,5,6],
					"createdCell": function(td, cellData, rowData, row, col) {
						jQuery(td).attr('style', 'vertical-align:middle;text-align:center;');
					}
				},
				{
					"targets": [1, 2],
					"createdCell": function(td, cellData, rowData, row, col) {
						jQuery(td).attr('style', 'vertical-align:middle;');
					}
				},

			],
			// "order": [[ 3, "desc" ]],
			"searchDelay": "1000",
			"serverSide": true,
			// "stateSave": true
		}).on('processing.dt', function(e, settings, processing) {
			jQuery('.DTTT_button_text').removeClass('DTTT_disabled');
			if (processing) {
				jQuery.blockUI();
			} else {
				jQuery.unblockUI();
			}
		});

	}
	jQuery(document).ready(function($) {
		$('#flt_tinhthanh_phuongxa').on('change', function(){
			let flt_tinhthanh_phuongxa = $(this).val();
			$.blockUI();
			$.ajax({
				type: 'get',
				url: 'index.php?option=com_danhmuc&controller=phuongxa&task=getQuanhuyenByTinhthanh&format=raw&tinhthanh_id='+flt_tinhthanh_phuongxa,
				success:function(data){
					let xhtml = '';
					// if(data.length>0){
						for(i=0; i<data.length; i++)
							xhtml += '<option value="'+data[i].code+'">'+data[i].name+'</option>';
					// }
					$('#flt_quanhuyen_phuongxa').html(xhtml);
					$('#flt_quanhuyen_phuongxa').trigger("chosen:updated");
					$.unblockUI();
				}
			});
		})
		$('body').delegate('.btn_edit_phuongxa', 'click', function() {
			let id = $(this).data('id');
			$.blockUI();
			$('#div_modal').load('index.php?option=com_danhmuc&view=phuongxa&format=raw&task=frm&id=' + id, function() {
				$.unblockUI();
			});
		})
		$('body').delegate('#btn_themmoi_phuongxa', 'click', function() {
			$.blockUI();
			$('#div_modal').load('index.php?option=com_danhmuc&view=phuongxa&format=raw&task=frm', function() {
				$.unblockUI();
			});
		})
		$('.chosen').chosen({
			search_contains: true,
			width: '100%'
		});
		$('.date-picker').datepicker({
			format: 'dd/mm/yyyy',
			allowInputToggle: true
		}).on('changeDate', function(ev) {
			$(this).datepicker('hide');
		});
		$('.input-mask-date').mask('99/99/9999');
		$('#btn_flt_phuongxa').on('click', function() {
			$('#div_ketqua_phuongxa').html('');
			$('#div_ketqua_phuongxa').load('index.php?option=com_danhmuc&view=phuongxa&format=raw&task=danhsach', function() {
				$.unblockUI();
			});
		});
		$('#btn_flt_phuongxa').click();
		$('#btn_xoa_phuongxa').on('click', function() {
			var id = [];
			$(".id:checked").each(function() {
				id.push($(this).val());
			});
			if (id.length > 0) {
				if (confirm('BẠN CÓ CHẮC CHẮN XÓA?')) {
					$.ajax({
						type: "POST",
						url: "index.php?option=com_danhmuc&controller=phuongxa&task=xoa&format=raw",
						data: {
							id: id
						},
						beforeSend: function() {
							$.blockUI();
						},
						success: function(data) {
							if (data == true) {
								$('.gritter-item-wrapper').remove();
								loadNoticeBoardSuccess('Thông báo', 'Xử lý thành công.');
								$('#btn_flt_phuongxa').trigger('click');
							} else {
								$('.gritter-item-wrapper').remove();
								loadNoticeBoardError('Thông báo', 'Xử lý không thành công. Vui lòng liên hệ quản trị viên!');
							}
							$.unblockUI();
						},
						error: function() {
							$.unblockUI();
							$('.gritter-item-wrapper').remove();
							loadNoticeBoardError('Thông báo', 'Xử lý không thành công. Vui lòng liên hệ quản trị viên!');
						}
					});
				}
			} else {
				$('.gritter-item-wrapper').remove();
				loadNoticeBoardError("Thông báo", "Vui lòng chọn dữ liệu cần xóa!!");
			}
		})
		// $('body').delegate('.btn_remove_donvi_tmp', 'click', function() {
		// 	$(this).closest('tr').remove();
		// })
	});
</script>