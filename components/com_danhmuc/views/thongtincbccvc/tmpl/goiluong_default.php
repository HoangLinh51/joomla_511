<?php 
defined('_JEXEC') or die('Restricted access');
?>
<div class="ds_goiluong">
	<h3 class="header blue">Gói lương
		<div class="pull-right">
			<span id="btn_frm_goiluong" data-toggle="modal" data-target=".modal" class="btn btn-mini btn-success"><i class="icon-plus"></i> Thêm mới</span>
			<!-- <span class="btn btn-mini btn-danger" id="btn_xoaall_goiluong"><i class="icon-remove"></i> Xóa</span> -->
		</div>
	</h3>
	<div id="danhsach_goiluong"></div>
</div>
<script>
	var danhsachgoiluong = function() {
		jQuery('#gritter-notice-wrapper').remove();
		jQuery('#danhsach_goiluong').load('index.php?option=com_danhmuc&controller=thongtincbccvc&task=goiluong_danhsach&format=raw');
	}
	jQuery(document).ready(function($) {
		danhsachgoiluong();
		$('#btn_frm_goiluong').on('click', function() {
			$('#gritter-notice-wrapper').remove();
			$.blockUI();
			$("#modal-form").load('index.php?option=com_danhmuc&controller=thongtincbccvc&task=goiluong_frm&format=raw', function() {
				$.unblockUI();
			});
		})
	});
</script>