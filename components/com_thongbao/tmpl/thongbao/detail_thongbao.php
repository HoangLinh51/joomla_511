<?php

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
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

		<?php if (!empty($item->vanbandinhkem)): ?>
			<div class="mb-4">
				<h6 class="text-muted">Văn bản đính kèm:</h6>
				<div class="d-flex flex-column">
					<?php foreach ($modelThongbao->getVanBan($item->vanbandinhkem) as $vanban) : ?>
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

<!-- <div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title text-danger" id="confirmDeleteModalLabel">Xác nhận xóa</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Đóng">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>

			<div class="modal-body">
				Bạn có chắc chắn muốn xóa mục này không?
			</div>
			<input type="hidden" name="idUser" value="<?= $idUser ?>">
			<input type="hidden" name="idThongbao" value="<?= $item->id ?>">

			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
				<button type="submit" class="btn btn-danger btn-xoa" data-thongbao="<?= $item->id ?>">Xóa</button>
			</div>
		</div>
	</div>
</div> -->

<!-- <script>
	$(document).ready(function() {
		$('#formThongBao').on('submit', function(e) {
			e.preventDefault();
			let formData = new FormData(this);

			$.ajax({
				url: $(this).attr('action'),
				type: 'POST',
				data: formData,
				contentType: false,
				processData: false,
				success: function(response) {
					console.log('AJAX Success:', response);
					var res = typeof response === 'string' ? JSON.parse(response) : response;
					var message = res.success ? res.message : 'Xóa thất bại!';
					var icon = res.success ?
						'<svg class="success-icon" width="20" height="20" viewBox="0 0 20 20" fill="green"><path d="M10 0C4.48 0 0 4.48 0 10s4.48 10 10 10 10-4.48 10-10S15.52 0 10 0zm-1 15.59L4.41 11l1.42-1.42L9 12.17l5.59-5.58L16 8l-7 7z"/></svg>' :
						'';
					bootbox.alert({
						title: icon + "<span style='font-weight:bold;font-size:20px;'>Thông báo</span>",
						// message: '<span style="font-size:20px;">' + message + '</span>',
						backdrop: true,
						className: 'small-alert',
						buttons: {
							ok: {
								label: 'OK',
								className: 'hidden' // Ẩn nút OK
							}
						},
						onShown: function() {
							// Tự động đóng sau 2 giây
							setTimeout(function() {
								bootbox.hideAll();
								if (res.success) {
									window.location.href = '/index.php';
								}
							}, 1500);
						}
					});
				},
				error: function(xhr, status, error) {
					// Xử lý lỗi
					// console.log(xhr.responseText);
				}
			});
		})
	});
</script> -->

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
						setTimeout(() => window.location.href = '/index.php/component/thongbao/?view=thongbao&task=ds_thongbao', 1000);
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

			setTimeout(() => toast.fadeOut(500, () => toast.remove()), 2000);
		}
	});
</script>

<style>
	.content-box {
		padding: 0px 20px;
	}

	.section {
		background: #fff;
		padding: 24px;
		border-radius: 12px;
		box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
	}

	.label {
		font-weight: 600;
		color: #555;
	}

	.value {
		color: #333;
	}

	.deleted-note {
		background-color: #ffeaea;
		color: #c00;
		padding: 12px;
		border-radius: 8px;
		margin-top: 20px;
	}

	.file-link {
		text-decoration: none;
		color: #0d6efd;
	}
</style>