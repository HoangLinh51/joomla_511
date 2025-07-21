<?php

/**
 * @package     Joomla.Site
 * @subpackage  mod_login
 *
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;

defined('_JEXEC') or die;
HTMLHelper::_('behavior.keepalive');
HTMLHelper::_('bootstrap.framework'); // JS
HTMLHelper::_('stylesheet', 'media/jui/css/bootstrap.min.css', array('version' => 'auto'));
$user = Factory::getUser();
$app = Factory::getApplication();
$doc = Factory::getDocument();
$coreTemplate = new CoreTemplate();
$modelThongbao = Core::model('DungChung/Thongbao');
$listThongBao = $modelThongbao->getListThongBao('today', '', 1, 10);
$countThongBao =  $modelThongbao->countThongBao($user->id, 'unread');
$submitThongbao = $modelThongbao->submitTrangThaiThongBao();

?>

<div class="dropdown mr-2">
	<a class="mr-2 ml-2" href="/index.php/component/dungchung/?view=hdsd&task=default">
		<i class="fas fa-download"></i>
	</a>

	<!-- <a type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
		<i class="far fa-bell" style="font-size: 20px"></i>
		<?php if ($countThongBao > 0): ?>
			<span class="badge bg-danger navbar-badge" id="unread-badge"></span>
		<?php endif; ?>
	</a>
	<ul class="dropdown-menu menu-thongbao" aria-labelledby="dropdownMenuButton" id="notificationList">
		<?php if (!empty($listThongBao['data'])) { ?>
			<?php foreach ($listThongBao['data'] as $index => $item): ?>
				<?php $isRead = $modelThongbao->getTrangThaiThongBao($user->id, $item->id); ?>
				<li class="notification-item">
					<div class="dropdown-item">
						<a class=" <?php echo $isRead ? 'text-muted' : 'fw-bold'; ?> text-title"
							href="<?= Route::_('index.php?option=com_thongbao&view=thongbao&task=edit_thongbao&id=' . $item->id); ?>"
							onclick="markAsRead(<?= $item->id; ?>, <?= $user->id; ?>)">
							<?= htmlspecialchars($item->tieude); ?>
						</a>
						<?php if (!$isRead): ?>
							<span class="badge bg-info ms-2 mb-2">Mới</span>
						<?php endif; ?>
					</div>
				</li>
			<?php endforeach; ?>
			<?php if (count($listThongBao) < $totalThongBao): ?>
				<li class="text-center mt-1">
					<button class="btn btn-sm btn-outline-primary" id="loadMoreNotifications">Hiển thị thêm</button>
				</li>
			<?php endif; ?>
		<?php } else { ?>
			<span class="dropdown-item text-muted">Không có thông báo mới.</span>
		<?php } ?>
	</ul> -->
</div>

<li class="dropdown user user-menu open">
	<button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
		<img src="<?php echo $coreTemplate->getAvatarUrl($user) ?>"
			alt="Avatar" class="" style="width: 45px; height: 45px;">


		<?php if ($params->get('greeting')) : ?>
			<?php if ($params->get('name') == 0) : { ?>
					<span class="user-info">
						<?php echo htmlspecialchars($user->get('name')); ?>
					</span>
				<?php
				}
			else : { ?>
					<span class="user-info">
						<?php echo htmlspecialchars($user->get('username')); ?>
					</span>
			<?php
				}
			endif; ?>
		<?php endif; ?>
	</button>
	<ul class="dropdown-menu" style="position: absolute;right: 0;left: auto;">
		<li class="">
			<div class="d-flex align-items-center p-3">
				<img src="<?php echo $coreTemplate->getAvatarUrl($user) ?>" style="width: 65px; height: 65px" alt="User Image">
				<div>
					<p class="m-0"><?php echo $user->name ?></p>
					<p class="m-0"><?php echo $user->email ?></p>
				</div>
			</div>
		</li>
		<li class="">
			<div class="d-flex flex-column align-items-start border-top">
				<button class="btn-editprofile text-left" href="<?php echo Route::_('index.php?option=com_users&view=profile&layout=edit'); ?>">
					<i class="fas fa-user" style="font-size: 20px;"></i>
					<?php echo Route::_('Thay đổi mật khẩu'); ?>
				</button>
				<button class="btn-logout text-left" type="button" onclick="document.getElementById('login-form').submit();">
					<i class="fas fa-power-off" style="font-size: 20px;"></i>
					<?php echo Text::_('JLOGOUT'); ?>
				</button>
			</div>
		</li>
	</ul>
</li>

<form action="<?php echo Route::_('index.php', true, $params->get('usesecure')); ?>" method="post" id="login-form" class="form-vertical" style="margin-bottom: 0px;">
	<input type="hidden" name="option" value="com_users" />
	<input type="hidden" name="task" value="user.logout" />
	<input type="hidden" name="return" value="<?php echo $return; ?>" />
	<?php echo HTMLHelper::_('form.token'); ?>
</form>
<script>
	function markAsRead(thongbao_id, user_id) {
		// Gửi yêu cầu cập nhật trạng thái đến server
		fetch('', {
			method: 'POST',
			headers: {
				'Content-Type': 'application/x-www-form-urlencoded'
			},
			body: `thongbao_id=${thongbao_id}&user_id=${user_id}`
		}).catch(() => {
			console.warn("Lỗi khi cập nhật trạng thái đã đọc.");
		});

		// Cập nhật giao diện ngay lập tức
		const link = document.querySelector(`a[data-id="${thongbao_id}"]`);
		if (link) {
			link.classList.remove('fw-bold');
			link.classList.add('text-muted');

			const badge = link.querySelector('.bg-info');
			if (badge) {
				// Thêm hiệu ứng mờ dần rồi xóa
				badge.style.transition = "opacity 0.3s ease";
				badge.style.opacity = 0;
				setTimeout(() => badge.remove(), 300);
			}
		}
	}
	$(document).ready(function() {
		$('body').delegate('.btn-editprofile', 'click', function() {
			window.location.href = '/index.php?option=com_users&view=profile&layout=edit';
		});
	})
</script>

<style>
	.navbar-badge {
		display: inline-block !important;
		width: 10px;
		height: 10px;
		bottom: 15px !important;
		left: 10px !important;
		right: inherit !important;
		top: inherit !important;
	}

	.dropdown-item {
		display: flex !important;
		align-items: center;
		justify-content: space-between;
	}

	.dropdown-menu.menu-thongbao {
		right: 0;
		min-width: 12rem;
	}

	.text-title {
		width: 160px;
		white-space: nowrap;
		overflow: hidden;
		text-overflow: ellipsis;
	}

	.dropdown-menu::after {
		content: "";
		position: absolute;
		top: -10px;
		right: 20px;
		width: 0;
		height: 0;
		border-left: 10px solid transparent;
		border-right: 10px solid transparent;
		border-bottom: 10px solid #0000004d ;
		z-index: 9;
	}

	.btn-editprofile,
	.btn-logout {
		border: none;
		background-color: #fff;
		color: #0c9984;
		padding: 15px 25px;
		width: 100%
	}

	.btn-editprofile:hover,
	.btn-logout:hover {
		border: none;
		background-color: #0c9984;
		color: #fff
	}

	.btn-editprofile i.fa,
	.btn-logout i.fa {
		color: #0c9984;
	}

	.btn-editprofile:hover i.fa,
	.btn-logout:hover i.fa {
		color: #fff
	}

	button.dropdown-toggle {
		border: none;
		background-color: #fff;
	}
</style>