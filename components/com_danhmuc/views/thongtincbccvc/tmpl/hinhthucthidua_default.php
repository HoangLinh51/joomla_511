<?php 
defined('_JEXEC') or die('Restricted access');
?>
<div class="ds_hinhthucthidua">
	<h3 class="header blue">Quản lý Hình thức thi đua
		<div class="pull-right">
			<span id="btn_frm_hinhthucthidua" data-toggle="modal" data-target=".modal" class="btn btn-mini btn-success"><i class="icon-plus"></i> Thêm mới</span>
			<!-- <span class="btn btn-mini btn-danger" id="btn_xoaall_hinhthucthidua"><i class="icon-remove"></i> Xóa</span> -->
		</div>
	</h3>
	<div id="danhsach_hinhthucthidua"></div>
</div>
<script>
	var danhsachhinhthucthidua = function() {
		jQuery('#gritter-notice-wrapper').remove();
		jQuery('#danhsach_hinhthucthidua').load('index.php?option=com_danhmuc&controller=thongtincbccvc&task=hinhthucthidua_danhsach&format=raw');
	}
	jQuery(document).ready(function($) {
		danhsachhinhthucthidua();
		$('#btn_frm_hinhthucthidua').on('click', function() {
			$('#gritter-notice-wrapper').remove();
			$.blockUI();
			$("#modal-form").load('index.php?option=com_danhmuc&controller=thongtincbccvc&task=hinhthucthidua_frm&format=raw', function() {
				$.unblockUI();
			});
		})
	});
</script>