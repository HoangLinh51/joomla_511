<?php
defined('_JEXEC') or die('Restricted access');
$user = JFactory::getUser();
$dotbaucu = Core::loadAssocList('baucu_dotbaucu', '*', 'daxoa=0 and trangthai=1','ngaybatdau desc');
?>
<div id="div_danhsach">
	<div class="widget-box">
		<div class="widget-header header-color-blue">
			<h5>Thống kê khu vực bỏ phiếu</h5>
			<div class="widget-toolbar no-border">
				<span class="btn btn-mini btn-light" id="btn_flt_baucuxuatbienban_khuvucbophieu"><i class="icon-flt"></i> Xem trước mẫu</span>
			</div>
			<div class="widget-toolbar">
				<a data-action="collapse" href="#"><i class="icon-chevron-up"></i> Thu gọn</a>
			</div>
		</div>
		<div class="widget-body">
			<div class="widget-main form-horizontal">
				<div class="row-fluid">
					<div class="control-group span5" style="float:left">
						<label class="control-label">Đợt/Nhiệm kỳ</label>
						<div class="controls">
							<input type="hidden" id="flt_bieumau_baucuxuatbienban_khuvucbophieu" value="bmkhuvucbophieu">
							<select id="flt_dotbaucu_baucuxuatbienban_khuvucbophieu" style="width: 100%">
								<?php for($i=0; $i<count($dotbaucu);$i++) { ?>
									<option value="<?php echo $dotbaucu[$i]['id'] ?>"><?php echo $dotbaucu[$i]['ten'] ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
				</div>
				<div class="row-fluid">
					<div class="control-group span10 center" style="float:left">
						<!-- <span class="btn btn-primary" id="btn_taimauxuat_khuvucbophieu">Tải mẫu xuất</span> -->
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="widget-box">
		<div class="widget-body" style="min-height: 500px">
			<div class="widget-main form-horizontal" id="div_ketqua_baucuxuatbienban_khuvucbophieu" >
			</div>
		</div>
	</div>
</div>
<script>
	jQuery(document).ready(function($) {
		$('#btn_taimauxuat_khuvucbophieu').on('click', function() {
			let donvibaucu_id = $('#flt_donvibaucu_baucuxuatbienban_khuvucbophieu').val();
			let dotbaucu_id = $('#flt_dotbaucu_baucuxuatbienban_khuvucbophieu').val();
			let capbaucu_id = $('#flt_capbaucu_baucuxuatbienban_khuvucbophieu option:selected').val();
			let bieumau = $('#flt_bieumau_baucuxuatbienban_khuvucbophieu').val();
			window.location.assign('index.php?option=com_danhmuc&controller=baucuxuatbienban&task=taimau_khuvucbophieu&format=raw&dotbaucu_id='+dotbaucu_id);
		})
		$('#flt_capbaucu_baucuxuatbienban_khuvucbophieu, #flt_dotbaucu_baucuxuatbienban_khuvucbophieu').on('change', function() {
			let capbaucu_id = $('#flt_capbaucu_baucuxuatbienban_khuvucbophieu option:selected').val();
			let dotbaucu_id = $('#flt_dotbaucu_baucuxuatbienban_khuvucbophieu option:selected').val();
			let xhtml = '';
			$.ajax({
				type: 'get',
				url: 'index.php?option=com_danhmuc&controller=baucuxuatbienban&task=getDonvibaucu&format=raw&capbaucu_id=' + capbaucu_id+'&dotbaucu_id='+dotbaucu_id,
				success: function(data) {
					if (data.length > 0) {
						data.forEach(element => {
							xhtml += '<option value="' + element.id + '">' + element.ten + ' (' + element.diaphuongbaucu + ')</option>';
						});
					}
					$('#flt_donvibaucu_baucuxuatbienban_khuvucbophieu').html(xhtml);
					$('#flt_donvibaucu_baucuxuatbienban_khuvucbophieu').trigger("chosen:updated");
					$.unblockUI();
				}
			});
		})
		$('#flt_dotbaucu_baucuxuatbienban_khuvucbophieu').change();
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
		$('#btn_flt_baucuxuatbienban_khuvucbophieu').on('click', function() {
			$.blockUI();
			let donvibaucu_id = $('#flt_donvibaucu_baucuxuatbienban_khuvucbophieu').val();
			let dotbaucu_id = $('#flt_dotbaucu_baucuxuatbienban_khuvucbophieu').val();
			let capbaucu_id = $('#flt_capbaucu_baucuxuatbienban_khuvucbophieu option:selected').val();
			let flt_bieumau_baucuxuatbienban = $('#flt_bieumau_baucuxuatbienban_khuvucbophieu').val();
			$('#div_ketqua_baucuxuatbienban_khuvucbophieu').html('');
			$('#div_ketqua_baucuxuatbienban_khuvucbophieu').load('index.php?option=com_danhmuc&view=baucuxuatbienban&format=raw&task=danhsach&bieumau=' + flt_bieumau_baucuxuatbienban + '&capbaucu_id=' + capbaucu_id + '&donvibaucu_id=' + donvibaucu_id +'&dotbaucu_id='+dotbaucu_id, function() {
				$.unblockUI();
			});
		});
		// $('#btn_flt_baucuxuatbienban').click();
		// $('#loaicongviec_id').on('change', function() {
		// 	$('#btn_flt_baucuxuatbienban').click();
		// })
	});
</script>