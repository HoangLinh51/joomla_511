<?php

use Joomla\CMS\Factory;
use Joomla\CMS\Router\Route;

$modelThongbao = Core::model('Thongbao/Thongbao');
$idUser = Factory::getUser()->id;
$item = $this->item
?>

<div class="container my-5">
	<div class="content-box">
		<h3><?php echo $item->tieude ?></h3>
		<hr>
		<div class="mb-4">
			<h6 class="text-muted">Nội dung:</h6>
			<p><?php echo $item->noidung ?></p>
		</div>

		<?php if (!empty($item->vanban)): ?>
			<div class="mb-4">
				<h6 class="text-muted">Văn bản đính kèm:</h6>
				<div class="d-flex flex-column">
					<?php foreach ($item->vanban as $vanban) : ?>
						<a href="<?php echo '/index.php?option=com_core&controller=attachment&format=raw&task=download&year=' . $vanban->nam . '&code=' . $vanban->code; ?>">
							<?php echo $vanban->filename ?>
						</a>
					<?php endforeach ?>
				</div>
			</div>
		<?php endif; ?>

		<div class="mt-4 border-top pt-3 border-bottom pb-3">
			<h6 class="text-muted">Thông tin hệ thống:</h6>
			<p class="mb-1 info-text">Người tạo: <?php echo $item->name ?></p>
			<p class="mb-1 info-text">Ngày tạo: <?php echo $item->ngay_tao ?></p>
			<p class="mb-1 info-text">Email người tạo: <?php echo $item->email ?></p>
			<?php if ($item->daxoa): ?>
				<p class="mb-1 info-text text-danger">Đã xóa bởi: <?php echo $item->deleted_by ?> lúc <?php echo $item->deleted_at ?></p>
			<?php endif; ?>
		</div>

		<div class="float-right mt-4">
			<a href="#" class="btn btn-danger btn_xoa" data-thongbao="<?php echo $item->id; ?>">Xóa</a>
			<a href="<?php echo Route::_('index.php?option=com_thongbao&view=thongbao&task=edit_thongbao&id=' . $item->id); ?>" class="btn btn-primary">Sửa</a>
		</div>
	</div>
</div>

<script>
	$(document).ready(function() {
		const idUser = <?= (int)Factory::getUser()->id ?>;
		const idThongbao = <?= (int)$item->id ?>;

		$('body').on('click', '.btn_xoa', function() {
			const confirmed = confirm('Bạn có chắc chắn muốn xóa dữ liệu này?');
			if (!confirmed) return;

			const url = "<?= Route::_('index.php?option=com_thongbao&task=thongbao.xoa_thongbao') ?>";

			fetch(url, {
					method: 'POST',
					headers: {
						'Content-Type': 'application/json'
					},
					body: JSON.stringify({
						idUser: idUser,
						idThongbao: $(this).data('thongbao'),
						[Joomla.getOptions('csrf.token')]: 1
					})
				})
				.then(response => response.json())
				.then(data => {
					const isSuccess = data.success ?? true;
					showToast(data.message || 'Xóa thành công', isSuccess);
					if (isSuccess) {
						setTimeout(() => window.location.href = '/index.php/component/thongbao/?view=thongbao&task=ds_thongbao', 500);
					}
				})
				.catch(error => {
					console.error('Lỗi:', error);
					showToast('Đã xảy ra lỗi khi xóa dữ liệu', false);
				});
		});

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
	});
</script>

<style>
	.content-wrapper {
		background-color: #fff;
	}

	.content-box {
		padding: 0px 20px;
	}
</style>