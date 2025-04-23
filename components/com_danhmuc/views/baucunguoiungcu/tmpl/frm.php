<?php
defined('_JEXEC') or die('Restricted access');
$info = $this->info;
$i4223 = Core::config('sync4223/is_use');
$t4223 = explode(',', Core::config('sync4223/tbl'));
$capbaucu = Core::loadAssocList('baucu_capbaucu', '*', 'daxoa=0 and trangthai=1');
$diadiemhanhchinh = Core::loadAssocList('baucu_diadiemhanhchinh', '*', 'daxoa=0 and trangthai =1', 'cap asc, parent_id asc, ten asc');
$donvibaucu = Core::loadAssocList('baucu_donvibaucu', '*', 'daxoa=0', 'ten asc');
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
			<h3 class="smaller lighter blue no-margin"><?php echo ($info['id']) > 0 ? "Hiệu chỉnh" : "Thêm mới" ?> Người ứng cử</h3>
		</div>
		<div class="modal-body" style="min-height: 500px">
			<form class="form-horizontal" method="POST" name="frm_baucunguoiungcu" id="frm_baucunguoiungcu">
				<input type="hidden" name="id" id="id" style="width:80%;" value="<?php echo $info['id'] ?>" />
				<div class="row-fluid">
					<div class="control-group">
						<label class="control-label" for="hoten">Họ và tên <span style="color:red;">*</span></label>
						<div class="controls">
							<input type="text" name="hoten" id="hoten" style="width:80%;" value="<?php echo $info['hoten'] ?>" />
						</div>
					</div>
				</div>
				<div class="row-fluid">
					<div class="control-group">
						<label class="control-label" for="ngaysinh">Ngày sinh <span style="color:red;">*</span></label>
						<div class="controls">
							<input class="is_chiconamsinh dp" style="width:80%; display: <?php echo $info['is_chiconamsinh']==1?'none':'';?>" type="text" name="ngaysinh" id="ngaysinh" value="<?php if($info['ngaysinh']!=null && $info['ngaysinh']!='0000-00-00' && $info['ngaysinh']!= '') echo date('d/m/Y', strtotime($info['ngaysinh'])); ?>" />
							<input class="is_chiconamsinh" style="display: <?php echo $info['is_chiconamsinh']!=1?'none':'';?>; width:80%;" type="text" name="namsinh" id="namsinh" value="<?php if($info['ngaysinh']!=null && $info['ngaysinh']!='0000-00-00' && $info['ngaysinh']!= '') echo date('Y', strtotime($info['ngaysinh'])); ?>" />
							<label><input class="checkbox" type="checkbox" <?php echo $info['is_chiconamsinh']==1?'checked':'';?> value="1" style="opacity:1" name="is_chiconamsinh" id="is_chiconamsinh"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Chỉ có năm sinh</label>
						</div>
					</div>
				</div>
				<div class="row-fluid">
					<div class="control-group">
						<label class="control-label" for="hoten">Giới tính <span style="color:red;">*</span></label>
						<div class="controls">
							<select name="gioitinh">
								<option value="">-- Chọn giới tính --</option>
								<option value="1" <?php echo $info['gioitinh'] == 1 ? 'selected' : ''; ?>>Nam</option>
								<option value="0" <?php echo $info['gioitinh'] == 0 ? 'selected' : ''; ?>>Nữ</option>
							</select>
						</div>
					</div>
				</div>
				<!-- <div class="row-fluid">
					<div class="control-group">
						<label class="control-label" for="capbaucu_id">Cấp bầu cử <span style="color:red;">*</span></label>
						<div class="controls">
							<select name="capbaucu_id" id="capbaucu_id" class='chosen'>
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
								<?php for ($i = 0; $i < count($diadiemhanhchinh); $i++) { ?>
									<option value="<?php echo $diadiemhanhchinh[$i]['id'] ?>" <?php echo $diadiemhanhchinh[$i]['id'] == $info['diaphuongbaucu_id'] ? 'selected' : ''; ?>><?php echo $diadiemhanhchinh[$i]['ten'] ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
				</div>
				<div class="row-fluid">
					<div class="control-group">
						<label class="control-label" for="donvibaucu_id">Đơn vị bầu cử <span style="color:red;">*</span></label>
						<div class="controls">
							<select name="donvibaucu_id" id="donvibaucu_id" class='chosen'>
								<?php for ($i = 0; $i < count($donvibaucu); $i++) { ?>
									<option value="<?php echo $donvibaucu[$i]['id'] ?>" <?php echo $donvibaucu[$i]['id'] == $info['donvibaucu_id'] ? 'selected' : ''; ?>>
									<?php echo $donvibaucu[$i]['ten'] ?> (<?php echo $diadiemhanhchinh_key[$donvibaucu[$i]['diaphuongbaucu_id']]['ten']?>)
								</option>
								<?php } ?>
							</select>
						</div>
					</div>
				</div> -->
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
						<label class="control-label" for="trangthai">Trạng thái <span style="color:red;">*</span></label>
						<div class="controls">
							<input value="0" type="hidden" name="trangthai">
							<input value="1" <?php echo $info['trangthai'] == 1 ? "checked" : ""; ?> type="checkbox" name="trangthai" id="trangthai" class="ace-switch"><span class="lbl"></span>
						</div>
					</div>
				</div>
				<div class="row-fluid">
					<div class="control-group">
						<label class="control-label" for="quoctich">Quốc tịch</label>
						<div class="controls">
							<input type="text" name="quoctich" id="quoctich" value="<?php echo $info['quoctich'] ?>"/>
						</div>
					</div>
				</div>
				<div class="row-fluid">
					<div class="control-group">
						<label class="control-label" for="dantoc">Dân tộc</label>
						<div class="controls">
							<input type="text" name="dantoc" id="dantoc" value="<?php echo $info['dantoc'] ?>"/>
						</div>
					</div>
				</div>
				<div class="row-fluid">
					<div class="control-group">
						<label class="control-label" for="tongiao">Tôn giáo</label>
						<div class="controls">
							<input type="text" name="tongiao" id="tongiao" value="<?php echo $info['tongiao'] ?>"/>
						</div>
					</div>
				</div>
				<div class="row-fluid">
					<div class="control-group">
						<label class="control-label" for="quequan">Quê quán</label>
						<div class="controls">
							<textarea name="quequan" id="quequan" cols="60" rows="4"><?php echo $info['quequan'] ?></textarea>
						</div>
					</div>
				</div>
				<div class="row-fluid">
					<div class="control-group">
						<label class="control-label" for="noiohiennay">Nơi ở hiện nay</label>
						<div class="controls">
							<textarea name="noiohiennay" id="noiohiennay" cols="60" rows="4"><?php echo $info['noiohiennay'] ?></textarea>
						</div>
					</div>
				</div>
				<div class="row-fluid">
					<div class="control-group">
						<label class="control-label" for="trinhdo_gdpt">Trình độ giáo dục phổ thông</label>
						<div class="controls">
							<input type="text" name="trinhdo_gdpt" id="trinhdo_gdpt" value="<?php echo $info['trinhdo_gdpt'] ?>"/>
						</div>
					</div>
				</div>
				<div class="row-fluid">
					<div class="control-group">
						<label class="control-label" for="trinhdo_chuyenmon">Trình độ chuyên môn, nghiệp vụ</label>
						<div class="controls">
							<input type="text" name="trinhdo_chuyenmon" id="trinhdo_chuyenmon" value="<?php echo $info['trinhdo_chuyenmon'] ?>"/>
						</div>
					</div>
				</div>
				<div class="row-fluid">
					<div class="control-group">
						<label class="control-label" for="trinhdo_hocham">Học hàm, học vị</label>
						<div class="controls">
							<input type="text" name="trinhdo_hocham" id="trinhdo_hocham" value="<?php echo $info['trinhdo_hocham'] ?>"/>
						</div>
					</div>
				</div>
				<div class="row-fluid">
					<div class="control-group">
						<label class="control-label" for="trinhdo_lltt">Lý luận chính trị</label>
						<div class="controls">
							<input type="text" name="trinhdo_lltt" id="trinhdo_lltt" value="<?php echo $info['trinhdo_lltt'] ?>"/>
						</div>
					</div>
				</div>
				<div class="row-fluid">
					<div class="control-group">
						<label class="control-label" for="trinhdo_ngoaingu">Ngoại ngữ</label>
						<div class="controls">
							<input type="text" name="trinhdo_ngoaingu" id="trinhdo_ngoaingu" value="<?php echo $info['trinhdo_ngoaingu'] ?>"/>
						</div>
					</div>
				</div>
				<div class="row-fluid">
					<div class="control-group">
						<label class="control-label" for="nghenghiep">Nghề nghiệp, chức vụ</label>
						<div class="controls">
							<input type="text" name="nghenghiep" id="nghenghiep" value="<?php echo $info['nghenghiep'] ?>"/>
						</div>
					</div>
				</div>
				<div class="row-fluid">
					<div class="control-group">
						<label class="control-label" for="noicongtac">Nơi công tác</label>
						<div class="controls">
							<input type="text" name="noicongtac" id="noicongtac" value="<?php echo $info['noicongtac'] ?>"/>
						</div>
					</div>
				</div>
				<div class="row-fluid">
					<div class="control-group">
						<label class="control-label" for="ngayvaodang">Ngày vào Đảng</label>
						<div class="controls">
							<input class="dp" style="width:80%;" type="text" name="ngayvaodang" id="ngayvaodang" value="<?php if($info['ngayvaodang']!=null && $info['ngayvaodang']!='0000-00-00' && $info['ngayvaodang']!= '') echo date('d/m/Y', strtotime($info['ngayvaodang'])); ?>" />
						</div>
					</div>
				</div>
				<div class="row-fluid">
					<div class="control-group">
						<label class="control-label" for="daibieuqh">Đại biểu Quốc hội</label>
						<div class="controls">
							<input value="0" type="hidden" name="daibieuqh">
							<input value="1" <?php echo $info['daibieuqh'] == 1 ? "checked" : ""; ?> type="checkbox" name="daibieuqh" id="daibieuqh" class="ace-switch"><span class="lbl"></span>
						</div>
					</div>
				</div>
				<div class="row-fluid">
					<div class="control-group">
						<label class="control-label" for="daibieuhdnd">Đại biểu HĐND </label>
						<div class="controls">
							<input value="0" type="hidden" name="daibieuhdnd">
							<input value="1" <?php echo $info['daibieuhdnd'] == 1 ? "checked" : ""; ?> type="checkbox" name="daibieuhdnd" id="daibieuhdnd" class="ace-switch"><span class="lbl"></span>
						</div>
					</div>
				</div>
				<div class="row-fluid">
					<div class="control-group">
						<label class="control-label" for="ghichu">Ghi chú</label>
						<div class="controls">
							<textarea name="ghichu" id="ghichu" cols="60" rows="4"><?php echo $info['ghichu'] ?></textarea>
						</div>
					</div>
				</div>
				<?php echo JHtml::_('form.token'); ?>
			</form>
		</div>

		<div class="modal-footer">
			<button class="btn btn-sm btn-danger pull-right" data-dismiss="modal">
				<i class="ace-icon fa fa-times"></i>
				Đóng
			</button>
			<span class="btn btn-sm btn-primary pull-right" id="btn_submit_baucunguoiungcu">
				<i class="ace-icon fa fa-times"></i>
				Lưu
			</span>
		</div>
	</div>
</div>
<script type="text/javascript">
	jQuery(document).ready(function($) {
		$('#is_chiconamsinh').on('click', function(){
			$('.is_chiconamsinh').toggle();
		})
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
		$('#frm_baucunguoiungcu #capbaucu_id').on('change', function(){
			let i = $('#frm_baucunguoiungcu #capbaucu_id option:selected').val();
			// console.log(i);
		})
		$('#frm_baucunguoiungcu').validate({
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
				"hoten": {
					required: true
				},
				"ngaysinh": {
					required: true
				},
				"namsinh": {
					required: true
				},
				"gioitinh": {
					required: true
				},
				"capbaucu_id": {
					required: true
				},
				"diaphuongbaucu_id": {
					required: true
				},
				"donvibaucu_id": {
					required: true
				},
			},
			messages: {
				"ten": {
					required: 'Vui lòng nhập <b>Tên</b>',
				},
			}
		});
		$('#btn_submit_baucunguoiungcu').click(function() {
			$('.gritter-item-wrapper').remove();
			var flag = $('#frm_baucunguoiungcu').valid();
			if (flag == true) {
				$.blockUI();
				formData = $('#frm_baucunguoiungcu').serialize();
				$.ajax({
					type: 'post',
					data: formData,
					url: 'index.php?option=com_danhmuc&controller=baucunguoiungcu&task=save&format=raw&',
					success: function(data) {
						if (data == true || data >0) {
							loadNoticeBoardSuccess('Thông báo', 'Lưu thông tin thành công');
							$('#div_modal').modal('hide');
							$('#btn_flt_baucunguoiungcu').click();
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