<?php

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
$idUser = Factory::getUser()->id;
?>

<div class="container my-5">
	<div class="content-box">
		<h3><?php echo $this->item->tieude ?></h3>
		<hr>
		<div class="mb-4">
			<h6 class="text-muted">Nội dung:</h6>
			<p><?php echo $this->item->noidung ?></p>
		</div>

		<?php if (!empty($this->item->vanbandinhkem)): ?>
			<div class="mb-4">
				<h6 class="text-muted">Văn bản đính kèm:</h6>
				<a href="/uploads/<?php echo $this->item->vanbandinhkem ?>" target="_blank">
					<?php echo $this->item->vanbandinhkem ?>
				</a>
			</div>
		<?php endif; ?>

		<div class="mt-4 border-top pt-3 border-bottom pb-3">
			<h6 class="text-muted">Thông tin hệ thống:</h6>
			<p class="mb-1 info-text">Người tạo: <?php echo $this->item->name ?></p>
			<p class="mb-1 info-text">Ngày tạo: <?php echo $this->item->ngay_tao ?></p>
			<p class="mb-1 info-text">Email người tạo: <?php echo $this->item->email ?></p>
			<?php if ($this->item->daxoa): ?>
				<p class="mb-1 info-text text-danger">Đã xóa bởi: <?php echo $this->item->deleted_by ?> lúc <?php echo$this->item->deleted_at ?></p>
			<?php endif; ?>
		</div>

		<div class="float-right mt-4">
			<a href="edit_notification.php?id=<?php echo $this->item->id ?>" class="btn btn-danger">Xóa</a>
			<a href="edit_notification.php?id=<?php echo $this->item->id ?>" class="btn btn-primary">Sửa</a>
		</div>
	</div>
</div>

<style>
	.content-box{
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
