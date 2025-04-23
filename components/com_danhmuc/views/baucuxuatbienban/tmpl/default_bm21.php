<?php
defined('_JEXEC') or die('Restricted access');
$user = JFactory::getUser();
$capbaucu = Core::loadAssocList('baucu_capbaucu', '*', 'daxoa=0 and trangthai=1 and id=1');
$dotbaucu = Core::loadAssocList('baucu_dotbaucu', '*', 'daxoa=0 and trangthai=1','ngaybatdau desc');
?>
<div id="div_danhsach">
	<div class="widget-box">
		<div class="widget-header header-color-blue">
			<h5>Biểu mẫu số 21-HĐBC-QH</h5>
			<div class="widget-toolbar no-border">
				<span class="btn btn-mini btn-light" id="btn_flt_baucuxuatbienban_bm21"><i class="icon-flt"></i> Xem trước mẫu</span>
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
							<input type="hidden" id="flt_bieumau_baucuxuatbienban_bm21" value="bm21">
							<select id="flt_dotbaucu_baucuxuatbienban_bm21" style="width: 100%">
								<?php for($i=0; $i<count($dotbaucu);$i++) { ?>
									<option value="<?php echo $dotbaucu[$i]['id'] ?>"><?php echo $dotbaucu[$i]['ten'] ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="control-group span5" style="float:left">
						<label class="control-label">Cấp bầu cử</label>
						<div class="controls">
							<div class="input-append">
								<select id="flt_capbaucu_baucuxuatbienban_bm21">
									<?php for ($i = 0; $i < count($capbaucu); $i++) { ?>
										<option value="<?php echo $capbaucu[$i]['id'] ?>"><?php echo $capbaucu[$i]['ten'] ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
					</div>
				</div>
				<div class="row-fluid">
					<div class="control-group span10" style="float:left">
						<label class="control-label">Chọn đơn vị bầu cử</label>
						<div class="controls">
							<select id="flt_donvibaucu_baucuxuatbienban_bm21" class="chosen" style="width: 100%" data-placeholder="Chọn đơn vị bầu cử">
							</select>
						</div>
					</div>
				</div>
				<div class="row-fluid">
					<div class="control-group span10 center" style="float:left">
						<span class="btn btn-primary" id="btn_taimauxuat_bm21">Tải mẫu xuất</span>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="widget-box">
		<div class="widget-body" style="min-height: 500px">
			<div class="widget-main form-horizontal" id="div_ketqua_baucuxuatbienban_bm21" >
			</div>
		</div>
	</div>
</div>
<script>
	jQuery(document).ready(function($) {
		$('#btn_taimauxuat_bm21').on('click', function() {
			let donvibaucu_id = $('#flt_donvibaucu_baucuxuatbienban_bm21').val();
			let dotbaucu_id = $('#flt_dotbaucu_baucuxuatbienban_bm21').val();
			let capbaucu_id = $('#flt_capbaucu_baucuxuatbienban_bm21 option:selected').val();
			let bieumau = $('#flt_bieumau_baucuxuatbienban_bm21').val();
			window.location.assign('index.php?option=com_danhmuc&controller=baucuxuatbienban&task=taimau&format=raw&donvibaucu_id=' + donvibaucu_id + '&bieumau=' + bieumau + '&capbaucu_id=' + capbaucu_id + '&dotbaucu_id='+dotbaucu_id);
		})
		$('#flt_capbaucu_baucuxuatbienban_bm21, #flt_dotbaucu_baucuxuatbienban_bm21').on('change', function() {
			let capbaucu_id = $('#flt_capbaucu_baucuxuatbienban_bm21 option:selected').val();
			let dotbaucu_id = $('#flt_dotbaucu_baucuxuatbienban_bm21 option:selected').val();
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
					$('#flt_donvibaucu_baucuxuatbienban_bm21').html(xhtml);
					$('#flt_donvibaucu_baucuxuatbienban_bm21').trigger("chosen:updated");
					$.unblockUI();
				}
			});
		})
		// $('#flt_bieumau_baucuxuatbienban_bm21').on('change', function() {
		// 	let is_quochoi = $('#flt_bieumau_baucuxuatbienban_bm21 option:selected').data('is_quochoi');
		// 	if (is_quochoi != undefined && is_quochoi > 0) {
		// 		$('.all_bm21').css('display', 'none');
		// 		$('.tonghop_bm21').css('display', '');
		// 		$('.is_quochoi_bm21' + is_quochoi).css('display', '');
		// 	} else {
		// 		$('.tonghop_bm21').css('display', 'none');
		// 	}
		// 	$('#flt_capbaucu_baucuxuatbienban_bm21').val(0);
		// 	$('#flt_capbaucu_baucuxuatbienban_bm21').change();
		// });
		$('#flt_dotbaucu_baucuxuatbienban_bm21').change();
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
		$('#btn_flt_baucuxuatbienban_bm21').on('click', function() {
			$.blockUI();
			let donvibaucu_id = $('#flt_donvibaucu_baucuxuatbienban_bm21').val();
			let dotbaucu_id = $('#flt_dotbaucu_baucuxuatbienban_bm21').val();
			let capbaucu_id = $('#flt_capbaucu_baucuxuatbienban_bm21 option:selected').val();
			let flt_bieumau_baucuxuatbienban = $('#flt_bieumau_baucuxuatbienban_bm21').val();
			$('#div_ketqua_baucuxuatbienban_bm21').html('');
			$('#div_ketqua_baucuxuatbienban_bm21').load('index.php?option=com_danhmuc&view=baucuxuatbienban&format=raw&task=danhsach&bieumau=' + flt_bieumau_baucuxuatbienban + '&capbaucu_id=' + capbaucu_id + '&donvibaucu_id=' + donvibaucu_id +'&dotbaucu_id='+dotbaucu_id, function() {
				$.unblockUI();
			});
		});
		// $('#btn_flt_baucuxuatbienban').click();
		// $('#loaicongviec_id').on('change', function() {
		// 	$('#btn_flt_baucuxuatbienban').click();
		// })
	});
</script>