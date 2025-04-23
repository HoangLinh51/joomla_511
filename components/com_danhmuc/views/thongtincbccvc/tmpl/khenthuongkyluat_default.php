<?php 
defined('_JEXEC') or die('Restricted access');
?>
<div class="ds_khenthuongkyluat">
	<h3 class="header blue">Quản lý Hình thức khen thưởng, kỷ luật
		<div class="pull-right">
			<span id="btn_frm_khenthuongkyluat" data-toggle="modal" data-target=".modal" class="btn btn-mini btn-success"><i class="icon-plus"></i> Thêm mới</span>
			<!-- <span class="btn btn-mini btn-danger" id="btn_xoaall_khenthuongkyluat"><i class="icon-remove"></i> Xóa</span> -->
		</div>
	</h3>
	<div id="danhsach_khenthuongkyluat"></div>
</div>
<script>
	var danhsachkhenthuongkyluat = function() {
		jQuery('#gritter-notice-wrapper').remove();
		jQuery('#danhsach_khenthuongkyluat').load('index.php?option=com_danhmuc&controller=thongtincbccvc&task=khenthuongkyluat_danhsach&format=raw');
	}
	jQuery(document).ready(function($) {
		danhsachkhenthuongkyluat();
		$('#btn_frm_khenthuongkyluat').on('click', function() {
			$('#gritter-notice-wrapper').remove();
			$.blockUI();
			$("#modal-form").load('index.php?option=com_danhmuc&controller=thongtincbccvc&task=khenthuongkyluat_frm&format=raw', function() {
				$.unblockUI();
			});
		})
	});
</script>