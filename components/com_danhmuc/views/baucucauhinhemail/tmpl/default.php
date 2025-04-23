<?php
defined('_JEXEC') or die('Restricted access');
$user = JFactory::getUser();
$i4223 = Core::config('sync4223/is_use');
$t4223 = explode(',', Core::config('sync4223/tbl'));
?>
<div id="div_danhsach">
	<div class="widget-box" style="display:none">
		<div class="widget-header header-color-blue">
			<h5>Bộ lọc danh sách</h5>
			<div class="widget-toolbar no-border">
				<span class="btn btn-mini btn-light" id="btn_flt_baucucauhinhemail"><i class="icon-flt"></i> Lọc danh sách</span>
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
							<input type="text" style="width: 100%" name="flt_ten_baucucauhinhemail" id="flt_ten_baucucauhinhemail">
						</div>
					</div>
					<div class="control-group span5" style="float:left">
						<label class="control-label">Trạng thái</label>
						<div class="controls">
							<div class="input-append">
								<select name="flt_trangthai_baucucauhinhemail" id="flt_trangthai_baucucauhinhemail">
									<option value="">--Tất cả--</option>
									<option value="1">Sử dụng</option>
									<option value="0">Không sử dụng</option>
								</select>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="widget-box">
		<!-- <div class="widget-header">
			<h4>Danh sách</h4>
			<div class="widget-toolbar">
				<a id="btn_themmoi_baucucauhinhemail" href="#div_modal" data-toggle="modal"><i class="icon-plus"></i> Thêm mới</a>
			</div>
			<div class="widget-toolbar">
				<a id="btn_xoa_baucucauhinhemail" href="javascript:void(0);"><i class="icon-remove"></i> Xóa</a>
			</div>
			<div class="widget-toolbar">
				<a data-action="collapse" href="#"><i class="icon-chevron-up"></i> Thu gọn</a>
			</div>
		</div> -->
		<div class="widget-body">
			<div class="widget-main form-horizontal" id="div_ketqua_baucucauhinhemail">
			</div>
		</div>
	</div>
</div>
<script>
	jQuery(document).ready(function($) {
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
		$('#btn_flt_baucucauhinhemail').on('click', function() {
			$('#div_ketqua_baucucauhinhemail').html('');
			$('#div_ketqua_baucucauhinhemail').load('index.php?option=com_danhmuc&view=baucucauhinhemail&format=raw&task=danhsach', function() {
				$.unblockUI();
			});
		});
		$('#btn_flt_baucucauhinhemail').click();
		$('#loaicongviec_id').on('change', function() {
			$('#btn_flt_baucucauhinhemail').click();
		})
	});
</script>