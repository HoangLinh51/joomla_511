<?php

use Joomla\CMS\Router\Route;
use Joomla\CMS\Factory;

defined('_JEXEC') or die('Restricted access');
$onlyview = Factory::getUser()->onlyview_viahe
?>
<div class="danhsach" style="background-color:#fff">
	<div class="content-header">
		<?php if ($onlyview == 1) { ?>
			<div class="row mb-2">
				<div class="col-sm-12">
					<h3 class="m-0 text-primary"><i class="fas fa-users"></i> Xem chi tiết thông tin cấp phép sử dụng tạm thời một phần vỉa hè</h3>
				</div>
			</div>
		<?php } else { ?>
			<div class="row mb-2">
				<div class="col-sm-9">
					<h3 class="m-0 text-primary"><i class="fas fa-users"></i> Quản lý thông tin cấp phép sử dụng tạm thời một phần vỉa hè</h3>
				</div>
				<div class="col-sm-3 text-right" style="padding:0;">
					<a href="<?php echo Route::_('/index.php?option=com_dcxddt&view=viahe&task=addlogo') ?>" class="btn btn-primary" style="font-size:16px;width:136px">
						<i class="fas fa-plus"></i> Quản lý logo
					</a>
					<a href="<?php echo Route::_('/index.php?option=com_dcxddt&view=viahe&task=addviahe') ?>" class="btn btn-primary" style="font-size:16px;width:136px">
						<i class="fas fa-plus"></i> Thêm mới
					</a>
				</div>
			</div>
		<?php } ?>
	</div>

	<div class="card card-primary collapsed-card">
		<div class="card-header" data-card-widget="collapse">
			<h3 class="card-title"><i class="fas fa-search"></i> Tìm kiếm</h3>
			<div class="card-tools">
				<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-chevron-up"></i></button>
			</div>
		</div>
		<div class="card-body">
			<div class='d-flex mb-3'>
				<b class="text-primary" style="font-size:17px;line-height:2.5;text-wrap: nowrap; width: 20%">Địa chỉ</b>
				<input type="text" name="diachi" id="diachi" class="form-control" style="width: 80%; font-size:16px;" placeholder="Nhập địa chỉ" />
			</div>
			<div class="d-flex align-items-center justify-content-center" style="gap:10px;">
				<button class="btn btn-primary" id="btn_filter"><i class="fas fa-search"></i> Tìm kiếm</button>
				<button type="button" class="btn btn-success" id="btn_xuatexcel"><i class="fas fa-file-excel"></i> Xuất excel</button>
			</div>
		</div>
	</div>

	<div id="div_danhsach">
		<?php require_once 'ds_viahe.php'; ?>
	</div>
</div>
<script>
	function showToast(message, isSuccess = true) {
		const toast = $('<div></div>')
			.text(message)
			.css({
				position: 'fixed',
				top: '20px',
				right: '20px',
				background: isSuccess ? '#28a745' : '#dc3545',
				color: 'white',
				padding: '10px 20px',
				borderRadius: '5px',
				boxShadow: '0 0 10px rgba(0,0,0,0.3)',
				zIndex: 9999
			})
			.appendTo('body');

		setTimeout(() => toast.fadeOut(500, () => toast.remove()), 1000);
	}

	jQuery(document).ready(function($) {
		$('#btn_xuatexcel').on('click', function() {
			const params = {
				option: 'com_dcxddt',
				controller: 'viahe',
				task: 'exportExcel',
				diachi: $('#diachi').val(),
				[Joomla.getOptions('csrf.token')]: 1
			};

			const url = Joomla.getOptions('system.paths').baseFull + 'index.php?' + $.param(params);

			// Gọi thử trước bằng AJAX để kiểm tra lỗi
			$.ajax({
				url: url,
				method: 'GET',
				success: function(data, status, xhr) {
					const disposition = xhr.getResponseHeader('Content-Disposition');

					// Nếu có header file download thì tiến hành tải
					if (disposition && disposition.indexOf('attachment') !== -1) {
						window.location.href = url;
					} else {
						showToast('Không có dữ liệu để xuất file.', false);
					}
				},
				error: function(xhr) {
					console.error('Lỗi khi gọi export:', xhr);
					showToast('Xuất Excel thất bại. Vui lòng thử lại sau.', false);
				}
			});
		});
	})
</script>

<style>
	.danhsach {
		padding: 0px 20px;
	}

	.content-header {
		padding: 20px 8px 15px 8px
	}

	.select2-container .select2-choice {
		height: 34px !important;
	}

	.select2-container .select2-choice .select2-chosen {
		height: 34px !important;
		padding: 5px 0 0 5px !important;
	}

	.select2-container--default .select2-results__option--highlighted[aria-selected] {
		background-color: #007b8b;
		color: #fff
	}

	.select2-container .select2-selection--single {
		height: 38px;
	}
</style>