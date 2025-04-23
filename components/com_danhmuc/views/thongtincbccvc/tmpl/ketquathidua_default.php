<?php 
defined('_JEXEC') or die('Restricted access');
?>
<div class="ds_ketquathidua">
	<h3 class="header blue">Quản lý Kết quả thi đua, đánh giá
		<div class="pull-right">
			<span id="btn_frm_ketquathidua" data-toggle="modal" data-target=".modal" class="btn btn-mini btn-success"><i class="icon-plus"></i> Thêm mới</span>
			<!-- <span class="btn btn-mini btn-danger" id="btn_xoaall_ketquathidua"><i class="icon-remove"></i> Xóa</span> -->
		</div>
	</h3>
	<div id="danhsach_ketquathidua"></div>
</div>
<script>
	var danhsachketquathidua = function() {
		jQuery('#gritter-notice-wrapper').remove();
		jQuery('#danhsach_ketquathidua').load('index.php?option=com_danhmuc&controller=thongtincbccvc&task=ketquathidua_danhsach&format=raw');
	}
	jQuery(document).ready(function($) {
		danhsachketquathidua();
		$('#btn_frm_ketquathidua').on('click', function() {
			$('#gritter-notice-wrapper').remove();
			$.blockUI();
			$("#modal-form").load('index.php?option=com_danhmuc&controller=thongtincbccvc&task=ketquathidua_frm&format=raw', function() {
				$.unblockUI();
			});
		})
	});
</script>