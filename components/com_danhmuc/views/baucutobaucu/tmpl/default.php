<?php
defined('_JEXEC') or die('Restricted access');
$user = JFactory::getUser();
$i4223 = Core::config('sync4223/is_use');
$t4223 = explode(',', Core::config('sync4223/tbl'));
$phuongxa = Core::loadAssocListHasKey('baucu_diadiemhanhchinh', '*', 'id', array('cap=4'));
$quanhuyen = Core::loadAssocListHasKey('baucu_diadiemhanhchinh', '*', 'id', array('cap=3'));
$dotbaucu = Core::loadAssocListHasKey('baucu_dotbaucu', '*', 'id');
$dotbaucu_select = Core::loadAssocList('baucu_dotbaucu', '*');
$phuongxa_select = Core::loadAssocList('baucu_diadiemhanhchinh', '*', 'cap=4');
$quanhuyen_select = Core::loadAssocList('baucu_diadiemhanhchinh', '*', 'cap=3');
?>
<div id="div_danhsach">
	<div class="widget-box">
		<div class="widget-header header-color-blue">
			<h5>Bộ lọc danh sách</h5>
			<div class="widget-toolbar no-border">
				<span class="btn btn-mini btn-light" id="btn_flt_baucutobaucu"><i class="icon-flt"></i> Lọc danh sách</span>
			</div>
			<!-- <div class="widget-toolbar">
				<a data-action="reload" id="btn-reload" href="#"><i class="icon-refresh"></i> Làm mới</a>
			</div> -->
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
							<input type="text" style="width: 100%" name="flt_ten_baucutobaucu" id="flt_ten_baucutobaucu">
						</div>
					</div>
					<div class="control-group span5" style="float:left">
						<label class="control-label">Trạng thái</label>
						<div class="controls">
							<div class="input-append">
								<select name="flt_trangthai_baucutobaucu" id="flt_trangthai_baucutobaucu" multiple class="chosen" style="width: 100%" data-placeholder="Chọn tất cả...">
									<option value="1">Sử dụng</option>
									<option value="0">Không sử dụng</option>
								</select>
							</div>
						</div>
					</div>
				</div>
				<div class="row-fluid">
					<div class="control-group span10" style="float:left">
						<label class="control-label">Đợt bầu cử</label>
						<div class="controls">
							<select name="flt_dotbaucu_id_baucutobaucu" id="flt_dotbaucu_id_baucutobaucu" class="chosen" multiple style="width: 100%" data-placeholder="Chọn tất cả...">
								<?php for ($i = 0; $i < count($dotbaucu_select); $i++) { ?>
									<option value="<?php echo $dotbaucu_select[$i]['id'] ?>"><?php echo $dotbaucu_select[$i]['ten'] ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
				</div>
				<div class="row-fluid">
					<div class="control-group span10" style="float:left">
						<label class="control-label">Quận/Huyện</label>
						<div class="controls">
							<select name="flt_quanhuyen_id_baucutobaucu" id="flt_quanhuyen_id_baucutobaucu" class="chosen" multiple style="width: 100%" data-placeholder="Chọn tất cả...">
								<?php for ($i = 0; $i < count($quanhuyen_select); $i++) { ?>
									<option value="<?php echo $quanhuyen_select[$i]['id'] ?>"><?php echo $quanhuyen_select[$i]['ten'] ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
				</div>
				<div class="row-fluid">
					<div class="control-group span10" style="float:left">
						<label class="control-label">Phường/Xã</label>
						<div class="controls">
							<select name="flt_phuongxa_id_baucutobaucu" id="flt_phuongxa_id_baucutobaucu" class="chosen" multiple style="width: 100%" data-placeholder="Chọn tất cả...">
								<?php for ($i = 0; $i < count($phuongxa_select); $i++) { ?>
									<option value="<?php echo $phuongxa_select[$i]['id'] ?>"><?php echo $phuongxa_select[$i]['ten'] ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="widget-box">
		<div class="widget-header">
			<h4>Danh sách</h4>
			<div class="widget-toolbar">
				<a id="btn_themmoi_baucutobaucu" href="#div_modal" data-toggle="modal"><i class="icon-plus"></i> Thêm mới</a>
			</div>
			<div class="widget-toolbar">
				<a id="btn_xoa_baucutobaucu" href="javascript:void(0);"><i class="icon-remove"></i> Xóa</a>
			</div>
			<div class="widget-toolbar">
				<a data-action="collapse" href="#"><i class="icon-chevron-up"></i> Thu gọn</a>
			</div>
		</div>
		<div class="widget-body">
			<div class="widget-main form-horizontal" id="div_ketqua_baucutobaucu">
			</div>
		</div>
	</div>
</div>
<script>
	let dotbaucu = <?php echo json_encode($dotbaucu) ?>;
	let phuongxa = <?php echo json_encode($phuongxa) ?>;
	let quanhuyen = <?php echo json_encode($quanhuyen) ?>;
	var resetBaucutobaucu = function() {
		let flt_ten = jQuery('#flt_ten_baucutobaucu').val();
		let flt_trangthai = jQuery('#flt_trangthai_baucutobaucu').val();
		let flt_phuongxa_id = jQuery('#flt_phuongxa_id_baucutobaucu').val();
		let flt_quanhuyen_id = jQuery('#flt_quanhuyen_id_baucutobaucu').val();
		let flt_dotbaucu_id = jQuery('#flt_dotbaucu_id_baucutobaucu').val();
		let oTable1 = jQuery('#table_thongtinchung_baucutobaucu').DataTable({
			"ajax": {
				"url": "index.php?option=com_danhmuc&controller=baucutobaucu&format=raw&task=dataFilter&flt_ten=" + flt_ten +
					"&flt_trangthai=" + flt_trangthai
					+"&flt_phuongxa_id=" + flt_phuongxa_id
					+"&flt_quanhuyen_id=" + flt_quanhuyen_id
					+"&flt_dotbaucu_id=" + flt_dotbaucu_id
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
						return '<input type="checkbox" class="ace-checkbox-2 id" name="id[]" value="' + data + '" /><span class="lbl"></span>';
					}
				},
				{
					"targets": 1,
					"searchable": true,
					"orderable": false,
					"render": function(data, type, full, meta) {
						return '<a class="btn_edit_baucutobaucu" href="#div_modal" data-toggle="modal" data-id="' + full[0] + '">' + full[1] + '</a>';
					}
				},
				{
					"targets": 2,
					"searchable": true,
					"orderable": false,
					"render": function(data, type, full, meta) {
						if (phuongxa[data] != undefined)
							return phuongxa[data].ten;
						else return '';
					}
				},
				{
					"targets": 3,
					"searchable": true,
					"orderable": false,
					"render": function(data, type, full, meta) {
						if (quanhuyen[data] != undefined)
							return quanhuyen[data].ten;
						else return '';
					}
				},
				{
					"targets": 4,
					"searchable": true,
					"orderable": false,
					"render": function(data, type, full, meta) {
						if (dotbaucu[data] != undefined)
							return dotbaucu[data].ten;
						else return '';
					}
				},
				{
					"targets": 5,
					"searchable": true,
					"visible": <?php echo ($i4223 == 1 && in_array($this->tbl, $t4223)) == true ? 'true' : 'false'; ?>,
					"orderable": false,
					"render": function(data, type, full, meta) {
						return data;
					}
				},
				{
					"targets": 6,
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
					"targets": 7,
					"searchable": true,
					"orderable": false,
					"render": function(data, type, full, meta) {
						return '<span class="btn btn-mini btn-success btn_edit_baucutobaucu" href="#div_modal" data-toggle="modal" data-id=' + full[0] + '><i class="icon-pencil"></i> Hiệu chỉnh</span>';
					}
				},
				{
					"targets": [0, 3, 4, 5, 6, 7],
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
		$('body').delegate('.btn_edit_baucutobaucu', 'click', function() {
			let id = $(this).data('id');
			$.blockUI();
			$('#div_modal').load('index.php?option=com_danhmuc&view=baucutobaucu&format=raw&task=frm&id=' + id, function() {
				$.unblockUI();
			});
		})
		$('body').delegate('#btn_themmoi_baucutobaucu', 'click', function() {
			$.blockUI();
			$('#div_modal').load('index.php?option=com_danhmuc&view=baucutobaucu&format=raw&task=frm', function() {
				$.unblockUI();
			});
		})
		$('.chosen').chosen({
			search_contains: true
		});
		$('.date-picker').datepicker({
			format: 'dd/mm/yyyy',
			allowInputToggle: true
		}).on('changeDate', function(ev) {
			$(this).datepicker('hide');
		});
		$('.input-mask-date').mask('99/99/9999');
		$('#btn-reload').on('click', function() {
			$('#dot_id option:first-child').attr("selected", "selected");
			$('#dot_id').trigger('chosen:updated');
			$('#donvi_id').val('');
			$('#donvi_id').trigger('chosen:updated');
			$('#capdonvi_id').val('');
			$('#capdonvi_id').trigger('chosen:updated');
			$('#flt_ngaybatdau').val('');
			$('#flt_ngayketthuc').val('');
		});
		$('#btn_flt_baucutobaucu').on('click', function() {
			$('#div_ketqua_baucutobaucu').html('');
			$('#div_ketqua_baucutobaucu').load('index.php?option=com_danhmuc&view=baucutobaucu&format=raw&task=danhsach', function() {
				$.unblockUI();
			});
		});
		$('#btn_flt_baucutobaucu').click();
		$('#loaicongviec_id').on('change', function() {
			$('#btn_flt_baucutobaucu').click();
		})
		$('#btn_xoa_baucutobaucu').on('click', function() {
			var id = [];
			$(".id:checked").each(function() {
				id.push($(this).val());
			});
			if (id.length > 0) {
				if (confirm('BẠN CÓ CHẮC CHẮN XÓA?')) {
					$.ajax({
						type: "POST",
						url: "index.php?option=com_danhmuc&controller=baucutobaucu&task=xoa&format=raw",
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
								$('#btn_flt_baucutobaucu').trigger('click');
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
		$('body').delegate('.btn_remove_donvi_tmp', 'click', function() {
			$(this).closest('tr').remove();
		})
	});
</script>