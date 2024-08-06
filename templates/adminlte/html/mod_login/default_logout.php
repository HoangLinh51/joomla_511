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
// $doc->addStyleSheet('/templates/aadminlte/dist/css/adminlte.min.css');
// $doc->addStyleSheet('/templates/aadminlte/plugins/fontawesome-free/css/all.min.css');
// $doc->addStyleSheet('/templates/aadminlte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css');
// $doc->addStyleSheet('/templates/aadminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css');
// $doc->addStyleSheet('/templates/aadminlte/plugins/jqvmap/jqvmap.min.css');
// $doc->addStyleSheet('/templates/aadminlte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css');

?>
<li class="dropdown user user-menu open">
	<a data-toggle="dropdown" href="#" class="dropdown-toggle" style="background: rgba(0, 0, 0, 0)">
	<?php
		// if ($user->hoso_id === null) {
			$db = Factory::getDbo();
			$query = 'SELECT b.url FROM core_user_hoso a INNER JOIN core_attachment b ON b.object_id = a.hoso_id AND b.type_id = 2 WHERE a.user_id ='.$db->quote($user->id);
			$db->setQuery($query);
			$image_url = $db->loadResult();
			if ($image_url == null) {
				?>
				<img class="user-image nav-user-photo" src="<?php echo Uri::root(true)?>/images/headers/user2-160x160.jpg" />
				<?php
			}else{
				?>
				<img class="nav-user-photo" src="<?php echo Uri::root(true)?>/timthumb.php?w=36&h=36&base64=1&src=<?php echo base64_encode($image_url)?>" />
				<?php 
			} 
		//} 
	?>
		
	<?php if ($params->get('greeting')) : ?>
	<?php if ($params->get('name') == 0) : { ?>
		<span class="user-info">
			<small><?php echo Text::sprintf('MOD_LOGIN_HINAME',''); ?></small>
			<?php echo htmlspecialchars($user->get('name')); ?>
		</span>
	
	<?php 	//echo JText::sprintf('MOD_LOGIN_HINAME', htmlspecialchars($user->get('name')));
		} else : { ?>
		<span class="user-info">
			<small><?php echo Text::sprintf('MOD_LOGIN_HINAME',''); ?>,</small>
			<?php echo htmlspecialchars($user->get('username')); ?>
		</span>
		<!-- <i class="icon-caret-down"></i> -->
	<?php 	//echo JText::sprintf('MOD_LOGIN_HINAME', htmlspecialchars($user->get('username')));
		} endif; ?>
	<?php endif; ?>
	</a>
	<ul class="dropdown-menu" style="position: absolute;right: 0;left: auto;">
		<li class="user-header">
			<img src="templates/adminlte/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
			<p>Alexander Pierce - Web Developer<small>Member since Nov. 2012</small></p>
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