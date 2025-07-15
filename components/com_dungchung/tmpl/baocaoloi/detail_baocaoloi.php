<?php

use Joomla\CMS\Factory;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;

$modelBaoCaoLoi = Core::model('DungChung/BaoCaoLoi');
$item = $this->item;
?>

<div class="container p-3">
	<div class="card">
		<div class="card-header">
			<h3>Chi tiết lỗi hệ thống</h3>
			<div>

				<?php if ($item->status === 1): ?>
					<button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#reasonModal" data-action="cancel">Hủy</button>
					<button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#reasonModal" data-action="complete">Hoàn thành</button>
				<?php endif; ?>
				<a href="<?= Route::_('index.php?option=com_dungchung&view=baocaoloi&task=ds_baocaoloi') ?>" class="btn btn-secondary">Quay lại</a>
			</div>
		</div>
		<div class="card-body">
			<!-- Thông tin lỗi -->
			<p>
				<strong class="label">Tên lỗi:</strong>
				<?php if ((int)$item->error_id !== 12): ?>
					<?= htmlspecialchars($item->name_error) ?>
				<?php else: ?>
					<?= htmlspecialchars($item->name_error) ?> (<?= htmlspecialchars($item->enter_error) ?>)
				<?php endif; ?>
			</p>

			<p>
				<strong class="label">Tên trang:</strong>
				<?= htmlspecialchars($item->name_module) ?>
			</p>

			<p>
				<strong class="label">Nội dung lỗi:</strong>
				<?= nl2br(htmlspecialchars($item->content)) ?>
			</p>
			<!-- Hình ảnh -->
			<?php if ($item->images): ?>
				<p><strong class="label">Hình ảnh:</strong></p>
				<div id="imagePreview">
					<?php foreach ($item->images as $image): ?>
						<img src="<?= Uri::root(true) . "/uploader/get_image.php?code=" . $image->code . "&folder=" . $image->folder ?>" alt="<?= $image->filename ?>" class="img-fluid">
					<?php endforeach; ?>
				</div>
				<div id="lightboxOverlay">
					<span class="lightbox-close">&times;</span>
					<img class="lightbox-content" id="lightboxImage" src="" alt="Preview lớn">
				</div>
			<?php endif ?>

			<p>
				<strong class="label">Trạng thái:</strong>
				<?php
				switch ((int)$item->status) {
					case 1:
						echo '<span class="text-warning">Chờ xử lý</span>';
						break;
					case 2:
						echo '<span class="text-success">Đã hoàn thành</span>';
						break;
					case 3:
						echo '<span class="text-danger">Đã hủy</span>';
						break;
					default:
						echo '<span class="text-muted">Không xác định</span>';
						break;
				}
				?>
			</p>

			<hr>

			<div class="infor-user">
				<!-- Thông tin người báo lỗi -->
				<h6 class="label mb-3"><strong>Thông tin người báo lỗi:</strong></h6>
				<p><span class="label">Thời Gian tạo:</span>
					<?php
					if (!empty($item->created_at)) {
						$date = new DateTime($item->created_at);
						echo $date->format('H:i:s d/m/Y ');
					}
					?>
				</p>
				<p><span class="label">Người tạo:</span></p>
				<ul class="pl-3">
					<li><strong>Họ tên:</strong> <?= htmlspecialchars($item->name_user) ?></li>
					<li><strong>Username:</strong> <?= htmlspecialchars($item->username) ?></li>
					<li><strong>Email:</strong> <?= htmlspecialchars($item->email) ?></li>
				</ul>
			</div>

			<?php if ($item->process_by): ?>
				<hr>

				<div class="content-process">
					<h6 class="label mb-3"><strong>Thông tin người xử lý:</strong></h6>
					<p><span class="label">Thời gian xử lý:</span>
						<?php
						if (!empty($item->process_at)) {
							$date = new DateTime($item->process_at);
							echo $date->format('H:i:s d/m/Y ');
						}
						?>
					</p>
					<p><span class="label">Người xử lý:</span></p>
					<ul class="pl-3">
						<li><strong>Họ tên:</strong> <?= htmlspecialchars($item->processor_name) ?></li>
						<li><strong>Email:</strong> <?= htmlspecialchars($item->processor_email) ?></li>
					</ul>
					<p>Nội dung xử lý: <?= htmlspecialchars($item->processing_content) ?></p>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>

<!-- Modal confirm  -->
<div class="modal fade" id="reasonModal" tabindex="-1" aria-labelledby="reasonModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="reasonModalLabel">Xác nhận</h5>
			</div>

			<div class="modal-body">
				<p id="modalMessage">Bạn có chắc chắn muốn thực hiện hành động này?</p>
				<div class="mb-3">
					<label for="contentReason" class="form-label">Nội dung</label>
					<textarea type="text" class="form-control" id="contentReason" placeholder="Nhập lý do..."
						required minlength="20" maxlength="500"></textarea>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
				<button type="button" class="btn btn-primary btn-submit">Xác nhận</button>
			</div>
		</div>
	</div>
</div>

<script>
	document.addEventListener('DOMContentLoaded', function() {
		let currentAction = '';

		// Gán trạng thái khi mở modal và cập nhật thông điệp
		document.querySelectorAll('button[data-bs-toggle="modal"]').forEach(button => {
			button.addEventListener('click', function() {
				currentAction = this.getAttribute('data-action');

				const message = currentAction === 'cancel' ?
					'Bạn có chắc chắn muốn hủy không?' :
					'Bạn có chắc chắn muốn hoàn thành không?';

				const modalMessage = document.getElementById('modalMessage');
				if (modalMessage) modalMessage.textContent = message;
			});
		});

		// ===== Image Preview Lightbox =====
		const previewContainer = document.getElementById('imagePreview');
		const lightbox = document.getElementById('lightboxOverlay');
		const lightboxImg = document.getElementById('lightboxImage');
		const closeBtn = document.querySelector('.lightbox-close');

		// Áp dụng nếu có container
		if (previewContainer && lightbox && lightboxImg && closeBtn) {
			// Khi click vào bất kỳ ảnh nào trong #imagePreview
			previewContainer.addEventListener('click', function(e) {
				if (e.target.tagName.toLowerCase() === 'img') {
					e.preventDefault();
					lightboxImg.src = e.target.src;
					lightbox.style.display = 'flex';
				}
			});

			closeBtn.addEventListener('click', function() {
				lightbox.style.display = 'none';
				lightboxImg.src = '';
			});

			lightbox.addEventListener('click', function(e) {
				if (e.target === lightbox) {
					lightbox.style.display = 'none';
					lightboxImg.src = '';
				}
			});
		}

		// ===== Xử lý nút Submit =====
		$('body').on('click', '.btn-submit', function() {
			const idUser = <?= (int)Factory::getUser()->id ?>;
			const idItem = <?= (int)$item->id ?>;
			const contentReason = document.getElementById('contentReason')?.value || '';

			const url = "<?= Route::_('index.php?option=com_dungchung&task=baocaoloi.confirm_reason') ?>";

			fetch(url, {
					method: 'POST',
					headers: {
						'Content-Type': 'application/json'
					},
					body: JSON.stringify({
						idUser,
						idError: idItem,
						action: currentAction,
						contentReason,
						[Joomla.getOptions('csrf.token')]: 1
					})
				})
				.then(response => response.json())
				.then(data => {
					const isSuccess = data.success ?? true;
					showToast(data.message || 'Cập nhật dữ liệu thành công', isSuccess);

					if (isSuccess) {
						setTimeout(() => {
							window.location.href = '/index.php/component/dungchung/?view=baocaoloi&task=ds_baocaoloi';
						}, 500);
					}
				})
				.catch(error => {
					console.error('Lỗi:', error);
					showToast('Đã xảy ra lỗi khi cập nhật dữ liệu', false);
				});
		});

		// ===== Hiển thị Toast thông báo =====
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
	.card-header {
		display: flex;
		align-items: center;
		justify-content: space-between;
	}

	.card-body::after,
	.card-footer::after,
	.card-header::after {
		display: none
	}

	.content-wrapper {
		background-color: #fff;
	}

	.content-box {
		padding: 0px 20px;
	}

	.infor-more {
		display: flex;
		justify-content: space-between
	}

	#imagePreview {
		margin: 10px 0px;
	}

	.img-fluid {
		width: 100px;
		height: 100px;
		margin: 0px 5px;
	}

	#lightboxOverlay {
		position: fixed;
		z-index: 1050;
		width: 100%;
		height: 100%;
		display: none;
		justify-content: center;
		align-items: center;
		top: 0;
		left: 0;
		right: 0;
		bottom: 0;
		background-color: rgba(0, 0, 0, 0.8);
	}

	.lightbox-content {
		max-width: 90%;
		max-height: 90%;
		border-radius: 8px;
	}

	.lightbox-close {
		position: absolute;
		top: 15px;
		right: 25px;
		color: white;
		font-size: 32px;
		font-weight: bold;
		cursor: pointer;
	}

	.infor-user,
	.content-process {
		max-width: 45%;
	}
</style>