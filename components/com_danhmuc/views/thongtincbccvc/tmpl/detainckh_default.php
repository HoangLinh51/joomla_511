<?php 
defined('_JEXEC') or die('Restricted access');
?>
<div class="ds_detainckh">
	<h3 class="header blue">Quản lý Cấp đề tài nghiên cứu khoa học
		<div class="pull-right">
			<span id="btn_frm_detainckh" data-toggle="modal" data-target=".modal" class="btn btn-mini btn-success"><i class="icon-plus"></i> Thêm mới</span>
			<!-- <span class="btn btn-mini btn-danger" id="btn_xoaall_detainckh"><i class="icon-remove"></i> Xóa</span> -->
		</div>
	</h3>
	<div id="danhsach_detainckh"></div>
</div>
<script>
	var danhsachdetainckh = function() {
		jQuery('#gritter-notice-wrapper').remove();
		jQuery('#danhsach_detainckh').load('index.php?option=com_danhmuc&controller=thongtincbccvc&task=detainckh_danhsach&format=raw');
	}
	jQuery(document).ready(function($) {
		danhsachdetainckh();
		$('#btn_frm_detainckh').on('click', function() {
			$('#gritter-notice-wrapper').remove();
			$.blockUI();
			$("#modal-form").load('index.php?option=com_danhmuc&controller=thongtincbccvc&task=detainckh_frm&format=raw', function() {
				$.unblockUI();
			});
		})
	});
</script>