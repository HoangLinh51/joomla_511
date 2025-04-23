<?php 
defined('_JEXEC') or die('Restricted access');
?>
<div class="ds_hinhthucchucdanhcongtac">
	<h3 class="header blue">Quản lý Hình thức bổ nhiệm chức danh
		<div class="pull-right">
			<span id="btn_frm_hinhthucchucdanhcongtac" data-toggle="modal" data-target=".modal" class="btn btn-mini btn-success"><i class="icon-plus"></i> Thêm mới</span>
			<!-- <span class="btn btn-mini btn-danger" id="btn_xoaall_hinhthucchucdanhcongtac"><i class="icon-remove"></i> Xóa</span> -->
		</div>
	</h3>
	<div id="danhsach_hinhthucchucdanhcongtac"></div>
</div>
<script>
	var danhsachhinhthucchucdanhcongtac = function() {
		jQuery('#gritter-notice-wrapper').remove();
		jQuery('#danhsach_hinhthucchucdanhcongtac').load('index.php?option=com_danhmuc&controller=thongtincbccvc&task=hinhthucchucdanhcongtac_danhsach&format=raw');
	}
	jQuery(document).ready(function($) {
		danhsachhinhthucchucdanhcongtac();
		$('#btn_frm_hinhthucchucdanhcongtac').on('click', function() {
			$('#gritter-notice-wrapper').remove();
			$.blockUI();
			$("#modal-form").load('index.php?option=com_danhmuc&controller=thongtincbccvc&task=hinhthucchucdanhcongtac_frm&format=raw', function() {
				$.unblockUI();
			});
		})
	});
</script>