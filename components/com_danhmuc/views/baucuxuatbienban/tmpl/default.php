<?php
defined('_JEXEC') or die('Restricted access');
$user = JFactory::getUser();
$bieumau = array(
	'bm21' => array('ten' => 'Biểu mẫu số 21-HĐBC-QH', 'is_quochoi' => 1),
	'bm22' => array('ten' => 'Biểu mẫu số 22-HĐBC-QH'),
	'bm26' => array('ten' => 'Biểu mẫu số 26-HĐBC-HĐND', 'is_quochoi' => 2),
	'bm27' => array('ten' => 'Biểu mẫu số 27-HĐBC-HĐND', 'is_quochoi' => 2),
	'bm30' => array('ten' => 'Biểu mẫu số 30-HĐBC'),
	'bm32' => array('ten' => 'Biểu mẫu số 32-HĐBC'),
);
$capbaucu = Core::loadAssocList('baucu_capbaucu', '*', 'daxoa=0 and trangthai=1');
$dotbaucu = Core::loadAssocList('baucu_dotbaucu', '*', 'daxoa=0 and trangthai=1');
?>
<div id="div_danhsach">
	<div class="widget-box">
		<div class="widget-header header-color-blue">
			<h5>Bộ lọc danh sách</h5>
			<div class="widget-toolbar no-border">
				<span class="btn btn-mini btn-light" id="btn_flt_baucuxuatbienban"><i class="icon-flt"></i> Xem trước mẫu</span>
			</div>
			<div class="widget-toolbar">
				<a data-action="collapse" href="#"><i class="icon-chevron-up"></i> Thu gọn</a>
			</div>
		</div>
		<div class="widget-body">
			<div class="widget-main form-horizontal">
				<div class="row-fluid">
					<div class="control-group span10" style="float:left">
						<label class="control-label">Đợt/Nhiệm kỳ</label>
						<div class="controls">
							<select id="flt_dotbaucu_baucuxuatbienban" style="width: 100%">
								<?php for($i=0; $i<count($dotbaucu);$i++) { ?>
									<option value="<?php echo $dotbaucu[$i]['id'] ?>"><?php echo $dotbaucu[$i]['ten'] ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
				</div>
				<div class="row-fluid">
					<div class="control-group span5" style="float:left">
						<label class="control-label">Chọn mẫu</label>
						<div class="controls">
							<select id="flt_bieumau_baucuxuatbienban">
								<?php foreach ($bieumau as $key => $value) { ?>
									<option data-is_quochoi="<?php echo $value['is_quochoi'] ?>" value="<?php echo $key ?>"><?php echo $value['ten'] ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="control-group span5 tonghop" style="float:left">
						<label class="control-label">Cấp bầu cử</label>
						<div class="controls">
							<div class="input-append">
								<select name="flt_capbaucu_baucuxuatbienban" id="flt_capbaucu_baucuxuatbienban">
									<option value="0">-- Chọn Cấp bầu cử --</option>
									<?php for ($i = 0; $i < count($capbaucu); $i++) { ?>
										<option class="all <?php echo $capbaucu[$i]['id'] == 1 ? "is_quochoi1" : ($capbaucu[$i]['id'] >= 2 ? "is_quochoi2" : ""); ?>" value="<?php echo $capbaucu[$i]['id'] ?>"><?php echo $capbaucu[$i]['ten'] ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
					</div>
				</div>
				<div class="row-fluid tonghop">
					<div class="control-group span10" style="float:left">
						<label class="control-label">Chọn đơn vị bầu cử</label>
						<div class="controls">
							<select id="flt_donvibaucu_baucuxuatbienban" class="chosen" style="width: 100%" data-placeholder="Chọn đơn vị bầu cử">
							</select>
						</div>
					</div>
				</div>
				<div class="row-fluid">
					<div class="control-group span10 center" style="float:left">
						<span class="btn btn-primary" id="btn_taimauxuat">Tải mẫu xuất</span>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="widget-box">
		<div class="widget-body" style="min-height: 500px">
			<div class="widget-main form-horizontal" id="div_ketqua_baucuxuatbienban" >
			</div>
		</div>
	</div>
</div>
<script>
	jQuery(document).ready(function($) {
		$('#btn_taimauxuat').on('click', function() {
			let donvibaucu_id = $('#flt_donvibaucu_baucuxuatbienban').val();
			let dotbaucu_id = $('#flt_dotbaucu_baucuxuatbienban').val();
			let capbaucu_id = $('#flt_capbaucu_baucuxuatbienban option:selected').val();
			let bieumau = $('#flt_bieumau_baucuxuatbienban option:selected').val();
			window.location.assign('index.php?option=com_danhmuc&controller=baucuxuatbienban&task=taimau&format=raw&donvibaucu_id=' + donvibaucu_id + '&bieumau=' + bieumau + '&capbaucu_id' + capbaucu_id + '&dotbaucu_id='+dotbaucu_id);
		})
		$('#flt_capbaucu_baucuxuatbienban, #flt_dotbaucu_baucuxuatbienban').on('change', function() {
			let capbaucu_id = $('#flt_capbaucu_baucuxuatbienban option:selected').val();
			let dotbaucu_id = $('#flt_dotbaucu_baucuxuatbienban option:selected').val();
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
					$('#flt_donvibaucu_baucuxuatbienban').html(xhtml);
					$('#flt_donvibaucu_baucuxuatbienban').trigger("chosen:updated");
					$.unblockUI();
				}
			});
		})
		$('#flt_bieumau_baucuxuatbienban').on('change', function() {
			let is_quochoi = $('#flt_bieumau_baucuxuatbienban option:selected').data('is_quochoi');
			if (is_quochoi != undefined && is_quochoi > 0) {
				$('.all').css('display', 'none');
				$('.tonghop').css('display', '');
				$('.is_quochoi' + is_quochoi).css('display', '');
			} else {
				$('.tonghop').css('display', 'none');
			}
			$('#flt_capbaucu_baucuxuatbienban').val(0);
			$('#flt_capbaucu_baucuxuatbienban').change();
		});
		$('#flt_bieumau_baucuxuatbienban').change();
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
		$('#btn_flt_baucuxuatbienban').on('click', function() {
			let donvibaucu_id = $('#flt_donvibaucu_baucuxuatbienban').val();
			let dotbaucu_id = $('#flt_dotbaucu_baucuxuatbienban').val();
			let capbaucu_id = $('#flt_capbaucu_baucuxuatbienban option:selected').val();
			let flt_bieumau_baucuxuatbienban = $('#flt_bieumau_baucuxuatbienban option:selected').val();
			$('#div_ketqua_baucuxuatbienban').html('');
			$('#div_ketqua_baucuxuatbienban').load('index.php?option=com_danhmuc&view=baucuxuatbienban&format=raw&task=danhsach&bieumau=' + flt_bieumau_baucuxuatbienban + '&capbaucu_id=' + capbaucu_id + '&donvibaucu_id=' + donvibaucu_id +'&dotbaucu_id='+dotbaucu_id, function() {
				$.unblockUI();
			});
		});
		// $('#btn_flt_baucuxuatbienban').click();
		$('#loaicongviec_id').on('change', function() {
			$('#btn_flt_baucuxuatbienban').click();
		})
	});
</script>