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
$user = Factory::getUser();
$app = Factory::getApplication();
$doc = Factory::getDocument();

?>
<?php
$db = Factory::getDbo();
$base_url = Uri::root(true);
$avatar_id = $user->avatar_id;
$avatarUrl = $base_url . "/uploader/defaultImage.png";

if (!empty($avatar_id)) {
	$query = $db->getQuery(true)
		->select($db->quoteName('code'))
		->from($db->quoteName('core_attachment'))
		->where($db->quoteName('object_id') . ' = ' . $db->quote($avatar_id))
		->order($db->quoteName('created_at') . ' DESC');
	$db->setQuery($query);
	$result = $db->loadObject();

	if (!empty($result) && !empty($result->code)) {
		$avatarUrl = $base_url . "/uploader/get_image.php?code=" . $result->code;
	}
}
?>
<li class="nav-item dropdown">
	<a class="nav-link" data-toggle="dropdown" href="#">
		<i class="far fa-bell" style="font-size: 20px"></i>
		<span class="badge badge-warning navbar-badge">15</span>
	</a>
	<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
		<span class="dropdown-header">15 Notifications</span>
		<div class="dropdown-divider"></div>
		<a href="#" class="dropdown-item">
			<i class="fas fa-envelope mr-2"></i> 4 new messages
			<span class="float-right text-muted text-sm">3 mins</span>
		</a>
		<div class="dropdown-divider"></div>
		<a href="#" class="dropdown-item">
			<i class="fas fa-users mr-2"></i> 8 friend requests
			<span class="float-right text-muted text-sm">12 hours</span>
		</a>
		<div class="dropdown-divider"></div>
		<a href="#" class="dropdown-item">
			<i class="fas fa-file mr-2"></i> 3 new reports
			<span class="float-right text-muted text-sm">2 days</span>
		</a>
		<div class="dropdown-divider"></div>
		<a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
	</div>
</li>

<li class="dropdown user user-menu open">
	<a data-toggle="dropdown" href="#" class="dropdown-toggle" style="background: rgba(0, 0, 0, 0)">
		<img src="<?php echo htmlspecialchars($avatarUrl, ENT_QUOTES, 'UTF-8'); ?>"
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
			<img src="<?php echo htmlspecialchars($avatarUrl, ENT_QUOTES, 'UTF-8'); ?>" class="img-circle" alt="User Image">
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

<style>
	.navbar-badge {
		top: 3px;
	}
</style>