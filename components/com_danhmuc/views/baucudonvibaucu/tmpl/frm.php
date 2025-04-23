<?php
defined('_JEXEC') or die('Restricted access');
$info = $this->info;
$i4223 = Core::config('sync4223/is_use');
$t4223 = explode(',', Core::config('sync4223/tbl'));
$dotbaucu = Core::loadAssocList('baucu_dotbaucu', '*', 'daxoa=0 and trangthai=1');
$capbaucu = Core::loadAssocList('baucu_capbaucu', '*', 'daxoa=0 and trangthai=1');
$diadiemhanhchinh = Core::loadAssocList('baucu_diadiemhanhchinh', '*', 'daxoa=0 and trangthai =1', 'cap asc, parent_id asc, ten asc');
$diadiembaucu = Core::loadAssocList('baucu_diadiemhanhchinh', '*', 'daxoa=0 and trangthai =1 and cap=4', 'cap asc, parent_id asc, ten asc');
$nguoiungcu = Core::loadAssocList('baucu_nguoiungcu', '*', 'daxoa=0 and trangthai=1');
$tobaucu = Core::loadAssocList('baucu_tobaucu', '*', 'daxoa=0 and trangthai=1');
$loaiphieubau = Core::loadAssocList('baucu_loaiphieubau', '*', 'daxoa=0 and trangthai=1');
$diadiemhanhchinh_key = Core::loadAssocListHasKey('baucu_diadiemhanhchinh', '*', 'id');
?>
<style>
	.form-horizontal .controls {
		margin-left: 180px;
		margin-top: 6px;
	}
</style>
<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 class="smaller lighter blue no-margin"><?php echo ($info['id']) > 0 ? "Hiệu chỉnh" : "Thêm mới" ?> Đơn vị bầu cử</h3>
		</div>
		<div class="modal-body" style="min-height: 500px;">
			<form class="form-horizontal" method="POST" name="frm_baucudonvibaucu" id="frm_baucudonvibaucu">
				<input type="hidden" name="id" id="id" style="width:80%;" value="<?php echo $info['id'] ?>" />
				<div class="row-fluid">
					<div class="control-group">
						<label class="control-label" for="ten">Tên <span style="color:red;">*</span></label>
						<div class="controls">
							<input type="text" name="ten" id="ten" style="width:80%;" value="<?php echo $info['ten'] ?>" />
						</div>
					</div>
				</div>
				<?php if ($i4223 == 1 && in_array($this->tbl, $t4223)) { ?>
					<div class="row-fluid">
						<div class="control-group">
							<label class="control-label" for="code_bnv">Mã Bộ nội vụ</label>
							<div class="controls">
								<div class="input-append">
									<input type="text" name="code_bnv" id="code_bnv" style="width:80%;" value="<?php echo $info['code_bnv'] ?>" />
									</span>
								</div>
							</div>
						</div>
					</div>
				<?php } ?>
				<div class="row-fluid">
					<div class="control-group">
						<label class="control-label" for="dotbaucu_id">Đợt bầu cử <span style="color:red;">*</span></label>
						<div class="controls">
							<select name="dotbaucu_id" class='chosen'>
								<option value="">--Chọn--</option>
								<?php for ($i = 0; $i < count($dotbaucu); $i++) { ?>
									<option value="<?php echo $dotbaucu[$i]['id'] ?>" <?php echo $dotbaucu[$i]['id'] == $info['dotbaucu_id'] ? 'selected' : ''; ?>><?php echo $dotbaucu[$i]['ten'] ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
				</div>
				<div class="row-fluid">
					<div class="control-group">
						<label class="control-label" for="capbaucu_id">Cấp bầu cử <span style="color:red;">*</span></label>
						<div class="controls">
							<select name="capbaucu_id" class='chosen'>
								<option value="">--Chọn--</option>
								<?php for ($i = 0; $i < count($capbaucu); $i++) { ?>
									<option value="<?php echo $capbaucu[$i]['id'] ?>" <?php echo $capbaucu[$i]['id'] == $info['capbaucu_id'] ? 'selected' : ''; ?>><?php echo $capbaucu[$i]['ten'] ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
				</div>
				<div class="row-fluid">
					<div class="control-group">
						<label class="control-label" for="diaphuongbaucu_id">Địa phương bầu cử <span style="color:red;">*</span></label>
						<div class="controls">
							<select name="diaphuongbaucu_id" class='chosen'>
								<option value="">--Chọn--</option>
								<?php for ($i = 0; $i < count($diadiemhanhchinh); $i++) { ?>
									<option value="<?php echo $diadiemhanhchinh[$i]['id'] ?>" <?php echo $diadiemhanhchinh[$i]['id'] == $info['diaphuongbaucu_id'] ? 'selected' : ''; ?>><?php echo $diadiemhanhchinh[$i]['ten'] ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
				</div>
				<div class="row-fluid">
					<div class="control-group">
						<label class="control-label" for="diadiembaucu_id">Địa điểm bầu cử <span style="color:red;">*</span></label>
						<div class="controls">
							<?php $fk_diadiem = Core::loadColumn('baucu_donvibaucu2diadiem','diadiem_id','donvibaucu_id='.(int)$info['id']);?>
							<select name="diadiembaucu_id[]" class='chosen' multiple data-placeholder="-- Chọn Địa điểm bầu cử --">
								<option value="">--Chọn--</option>
								<?php for ($i = 0; $i < count($diadiembaucu); $i++) { ?>
									<option value="<?php echo $diadiembaucu[$i]['id'] ?>" <?php if(in_array($diadiembaucu[$i]['id'], $fk_diadiem)) echo 'selected'; ?>><?php echo $diadiembaucu[$i]['ten'] ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
				</div>
				<div class="row-fluid">
					<div class="control-group">
						<label class="control-label" for="loaiphieubau_id">Loại phiếu bầu <span style="color:red;">*</span></label>
						<div class="controls">
						<?php $fk_loaiphieubau = Core::loadColumn('baucu_donvibaucu2loaiphieubau','loaiphieubau_id','donvibaucu_id='.(int)$info['id']);?>
							<select name="loaiphieubau_id[]" class='chosen' multiple data-placeholder="-- Chọn Loại phiếu bầu --">
								<?php for ($i = 0; $i < count($loaiphieubau); $i++) { ?>
									<option value="<?php echo $loaiphieubau[$i]['id'] ?>" <?php if(in_array($loaiphieubau[$i]['id'], $fk_loaiphieubau)) echo 'selected'; ?>><?php echo $loaiphieubau[$i]['ten'] ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
				</div>
				<div class="row-fluid">
					<div class="control-group">
						<label class="control-label" for="tobaucu_id">Tổ bầu cử <span style="color:red;">*</span></label>
						<div class="controls">
						<?php $fk_tobaucu = Core::loadColumn('baucu_donvibaucu2tobaucu','tobaucu_id','donvibaucu_id='.(int)$info['id']);?>
							<select name="tobaucu_id[]" class='chosen' multiple data-placeholder="-- Chọn Tổ bầu cử --">
								<?php for ($i = 0; $i < count($tobaucu); $i++) { ?>
									<option value="<?php echo $tobaucu[$i]['id'] ?>" <?php if(in_array($tobaucu[$i]['id'], $fk_tobaucu)) echo 'selected'; ?>>
										<?php echo $tobaucu[$i]['ten'] ?> (<?php echo $diadiemhanhchinh_key[$tobaucu[$i]['phuongxa_id']]['ten']?>)
									</option>
								<?php } ?>
							</select>
						</div>
					</div>
				</div>
				<div class="row-fluid">
					<div class="control-group">
						<label class="control-label" for="nguoiungcu_id">Người ứng cử <span style="color:red;">*</span></label>
						<div class="controls">
						<?php $fk_nguoiungcu = Core::loadColumn('baucu_donvibaucu2nguoiungcu','nguoiungcu_id','donvibaucu_id='.(int)$info['id']);?>
							<select name="nguoiungcu_id[]" class='chosen' multiple data-placeholder="-- Chọn Người ứng cử --">
								<?php for ($i = 0; $i < count($nguoiungcu); $i++) { ?>
									<option value="<?php echo $nguoiungcu[$i]['id'] ?>" <?php if(in_array($nguoiungcu[$i]['id'], $fk_nguoiungcu)) echo 'selected'; ?>><?php echo $nguoiungcu[$i]['hoten'] ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
				</div>
				<!-- <div class="row-fluid">
					<div class="control-group">
						<label class="control-label" for="trangthai">Trạng thái <span style="color:red;">*</span></label>
						<div class="controls">
							<input value="0" type="hidden" name="trangthai">
							<input value="1" <?php echo $info['trangthai'] == 1 ? "checked" : ""; ?> type="checkbox" name="trangthai" id="trangthai" class="ace-switch"><span class="lbl"></span>
						</div>
					</div>
				</div>				 -->
				<?php echo JHtml::_('form.token'); ?>
			</form>
		</div>

		<div class="modal-footer">
			<button class="btn btn-sm btn-danger pull-right" data-dismiss="modal">
				<i class="ace-icon fa fa-times"></i>
				Đóng
			</button>
			<span class="btn btn-sm btn-primary pull-right" id="btn_submit_baucudonvibaucu">
				<i class="ace-icon fa fa-times"></i>
				Lưu
			</span>
		</div>
	</div>
</div>
<script type="text/javascript">
	jQuery(document).ready(function($) {
		$('.chosen').chosen({
			search_contains: true,
			width: "80%"
		});
		$('.dp').datepicker({
			format: 'dd/mm/yyyy',
			allowInputToggle: true
		}).on('changeDate', function(ev) {
			$(this).datepicker('hide');
		});
		$('.dp').mask('99/99/9999');
		$('#frm_baucudonvibaucu').validate({
			invalidHandler: function(form, validator) {
				var errors = validator.numberOfInvalids();
				if (errors) {
					var a = [];
					var message = 'Xin vui lòng nhập đầy đủ các thông tin:\n';
					var errors = "";
					if (validator.errorList.length > 0) {
						for (x = 0; x < validator.errorList.length; x++) {
							errors += "<br/>\u25CF " + validator.errorList[x].message;
						}
					}
					loadNoticeBoardError('Thông báo', message + errors);
				}
				validator.focusInvalid();
			},
			errorPlacement: function(error, element) {

			},
			rules: {
				"ten": {
					required: true
				},
			},
			messages: {
				"ten": {
					required: 'Vui lòng nhập <b>Tên</b>',
				},
			}
		});
		$('#btn_submit_baucudonvibaucu').click(function() {
			$('.gritter-item-wrapper').remove();
			var flag = $('#frm_baucudonvibaucu').valid();
			if (flag == true) {
				$.blockUI();
				formData = $('#frm_baucudonvibaucu').serialize();
				$.ajax({
					type: 'post',
					data: formData,
					url: 'index.php?option=com_danhmuc&controller=baucudonvibaucu&task=save&format=raw&',
					success: function(data) {
						if (data == true || data != null || data != '') {
							loadNoticeBoardSuccess('Thông báo', 'Lưu thông tin thành công');
							$('#div_modal').modal('hide');
							$('#btn_flt_baucudonvibaucu').click();
						} else {
							loadNoticeBoardError('Thông báo', 'Có lỗi xảy ra, vui lòng liên hệ quản trị viên.');
						}
						$.unblockUI();
					}
				});
			}
			return false;
		});
	})
</script>