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
use Joomla\CMS\Uri\Uri;

defined('_JEXEC') or die;
HTMLHelper::_('behavior.keepalive');
HTMLHelper::_('bootstrap.framework'); // JS
HTMLHelper::_('stylesheet', 'media/jui/css/bootstrap.min.css', array('version' => 'auto'));
$user = Factory::getUser();
$app = Factory::getApplication();
$doc = Factory::getDocument();
$coreTemplate = new CoreTemplate();
$itemThongBao = $coreTemplate->getThongBao();
$countThongBao =  $coreTemplate->getThongBaoCount($user->id);
$submitThongbao = $coreTemplate->submitThongbao()
?>


<div class="dropdown">
	<a type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
		<i class="far fa-bell" style="font-size: 20px"></i>
		<?php if ($countThongBao > 0) : ?>
			<span class="badge bg-danger navbar-badge" id="unread-badge"></span>
		<?php endif; ?>
	</a>
	<ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
		<?php if (!empty($itemThongBao)) { ?>
			<?php foreach ($itemThongBao as $item) : ?>
				<?php $isRead = $coreTemplate->getTrangThaiThongBao($user->id, $item->id); ?>
				<li>
					<a class="dropdown-item <?php echo $isRead ? 'text-muted' : 'fw-bold'; ?>"
						data-id="<?php echo $item->id; ?>" data-bs-toggle="modal"
						data-bs-target="#thongBaoModal" onclick="markAsRead(<?php echo $item->id; ?>, <?php echo $user->id; ?>)">
						<?php echo $item->tieude; ?>
						<?php if (!$isRead): ?>
							<span class="badge bg-info ms-2">Mới</span>
						<?php endif; ?>
					</a>
				</li>
			<?php endforeach; ?>
		<?php } else { ?>
			<div class="notification-item" style="font-size: 14px;">Không có thông báo mới.</div>
		<?php } ?>
	</ul>
</div>


<li class="dropdown user user-menu open">
	<a class="dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
		<img src="<?php echo $coreTemplate->getAvatarUrl($user) ?>"
			alt="Avatar" class="img-circle" style="width: 35px; height: 35px;">

		<?php if ($params->get('greeting')) : ?>
			<?php if ($params->get('name') == 0) : { ?>
					<span class="user-info">
						<small><?php echo Text::sprintf('MOD_LOGIN_HINAME', ''); ?></small>
						<?php echo htmlspecialchars($user->get('name')); ?>
					</span>
				<?php
				}
			else : { ?>
					<span class="user-info">
						<small><?php echo Text::sprintf('MOD_LOGIN_HINAME', ''); ?>,</small>
						<?php echo htmlspecialchars($user->get('username')); ?>
					</span>
			<?php
				}
			endif; ?>
		<?php endif; ?>
	</a>
	<ul class="dropdown-menu" style="position: absolute;right: 0;left: auto;">
		<li class="user-header">
			<img src="<?php echo $coreTemplate->getAvatarUrl($user) ?>" class="img-circle" alt="User Image">
			<p><?php echo $user->name ?></p>
			<p>Tham gia từ
				<?php
				$date = new DateTime($user->registerDate);
				echo $date->format('d-m-Y');
				?>
			</p>

		</li>
		<li class="user-footer">
			<div class="pull-left" style="float: left;">
				<a href="<?php echo Route::_('index.php?option=com_users&view=profile&layout=edit'); ?>">
					<i class="icon-key"></i>
					<?php echo Route::_('Thay đổi mật khẩu'); ?>
				</a>
			</div>

			<div class="pull-right" style="float: right;">
				<a href="#" onclick="document.getElementById('login-form').submit();">
					<i class="icon-off"></i>
					<?php echo Text::_('JLOGOUT'); ?>
				</a>
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
		console.log(link);
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
		<?php $countThongBao =  $coreTemplate->getThongBaoCount($user->id); ?>
		<?php if ($countThongBao <= 0)

		?>
	}
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


	.dropdown-menu {
		left: auto !important;
		right: 0;
	}

	.dropdown-item {
		display: flex !important;
		align-items: center;
		justify-content: space-between;
	}
</style>