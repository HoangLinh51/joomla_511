<?php

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Router\Route;

defined('_JEXEC') or die('Restricted access');
?>
<div class="danhsach" style="background-color:#fff">
	<div class="content-header">
		<div class="row mb-2">
			<div class="col-sm-10">
				<h3 class="m-0 text-primary"><i class="fas fa-users"></i> Quản lý thông tin cấp phép sử dụng tạm thời một phần vỉa hè</h3>
			</div>
			<div class="col-sm-2 text-right" style="padding:0;">
				<a href="<?php echo Route::_('/index.php?option=com_dcxddt&view=viahe&task=addviahe') ?>" class="btn btn-primary" style="font-size:16px;width:136px">
					<i class="fas fa-plus"></i> Thêm mới
				</a>
			</div>
		</div>
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
	jQuery(document).ready(function($) {
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