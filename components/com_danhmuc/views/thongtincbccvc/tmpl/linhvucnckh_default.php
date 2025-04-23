<?php 
defined('_JEXEC') or die('Restricted access');
?>
<div class="ds_linhvucnckh">
	<h3 class="header blue">Quản lý Lĩnh vực nghiên cứu khoa học
		<div class="pull-right">
			<span id="btn_frm_linhvucnckh" data-toggle="modal" data-target=".modal" class="btn btn-mini btn-success"><i class="icon-plus"></i> Thêm mới</span>
			<!-- <span class="btn btn-mini btn-danger" id="btn_xoaall_linhvucnckh"><i class="icon-remove"></i> Xóa</span> -->
		</div>
	</h3>
	<div id="danhsach_linhvucnckh"></div>
</div>
<script>
	var danhsachlinhvucnckh = function() {
		jQuery('#gritter-notice-wrapper').remove();
		jQuery('#danhsach_linhvucnckh').load('index.php?option=com_danhmuc&controller=thongtincbccvc&task=linhvucnckh_danhsach&format=raw');
	}
	jQuery(document).ready(function($) {
		danhsachlinhvucnckh();
		$('#btn_frm_linhvucnckh').on('click', function() {
			$('#gritter-notice-wrapper').remove();
			$.blockUI();
			$("#modal-form").load('index.php?option=com_danhmuc&controller=thongtincbccvc&task=linhvucnckh_frm&format=raw', function() {
				$.unblockUI();
			});
		})
	});
</script>