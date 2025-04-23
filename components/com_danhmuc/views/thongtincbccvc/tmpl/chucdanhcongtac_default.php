<?php 
defined('_JEXEC') or die('Restricted access');
?>
<div class="ds_chucdanhcongtac">
	<h3 class="header blue">Quản lý Cấp đề tài nghiên cứu khoa học
		<div class="pull-right">
			<span id="btn_frm_chucdanhcongtac" data-toggle="modal" data-target=".modal" class="btn btn-mini btn-success"><i class="icon-plus"></i> Thêm mới</span>
			<!-- <span class="btn btn-mini btn-danger" id="btn_xoaall_chucdanhcongtac"><i class="icon-remove"></i> Xóa</span> -->
		</div>
	</h3>
	<div id="danhsach_chucdanhcongtac"></div>
</div>
<script>
	var danhsachchucdanhcongtac = function() {
		jQuery('#gritter-notice-wrapper').remove();
		jQuery('#danhsach_chucdanhcongtac').load('index.php?option=com_danhmuc&controller=thongtincbccvc&task=chucdanhcongtac_danhsach&format=raw');
	}
	jQuery(document).ready(function($) {
		danhsachchucdanhcongtac();
		$('#btn_frm_chucdanhcongtac').on('click', function() {
			$('#gritter-notice-wrapper').remove();
			$.blockUI();
			$("#modal-form").load('index.php?option=com_danhmuc&controller=thongtincbccvc&task=chucdanhcongtac_frm&format=raw', function() {
				$.unblockUI();
			});
		})
	});
</script>