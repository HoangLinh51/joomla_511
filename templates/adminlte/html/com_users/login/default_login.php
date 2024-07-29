<?php

/**
 * @package     Joomla.Site
 * @subpackage  com_users
 *
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\CMS\Router\Route;

defined('_JEXEC') or die;

	$captcha_length = 6; //$session['captcha_length']; //1 ký tự = 8
	$captcha_content = '0123456789';

	$im = imagecreatetruecolor(8 * $captcha_length + 30, 25); //fix size
	$c1 = mt_rand(50, 200); //r(ed)
	$c2 = mt_rand(50, 200); //g(reen)
	$c3 = mt_rand(50, 200); //b(lue)
	$white = imagecolorallocate($im, 255, 255, 255);
	imagefilledrectangle($im, 0, 0, 150, 25, $white);
	$text_color = imagecolorallocate($im, $c1, $c2, $c3); //màu chữ

	$img_val = substr(str_shuffle(str_repeat($captcha_content, 1)), 0, $captcha_length);
	imagestring($im, 5, 15, 5,  $img_val, $text_color);
	imagejpeg($im, 'uploader/files/login_captcha' . date('Ymd') . '.jpg', 100);
	imagedestroy($im);
	$_SESSION['valid_captcha'] = $img_val;

	$app = Factory::getApplication();
	$doc = Factory::getDocument();

	// Add Stylesheet
	// $doc->addStyleSheet($this->baseurl. '/templates/aadminlte/dist/css/adminlte.min.css');
	// $doc->addStyleSheet($this->baseurl. '/templates/aadminlte/plugins/fontawesome-free/css/all.min.css');
	// $doc->addStyleSheet($this->baseurl. '/templates/aadminlte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css');
	// $doc->addStyleSheet($this->baseurl. '/templates/aadminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css');
	// $doc->addStyleSheet($this->baseurl. '/templates/aadminlte/plugins/jqvmap/jqvmap.min.css');
	// $doc->addStyleSheet($this->baseurl. '/templates/aadminlte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css');
	// $doc->addScript($this->baseurl. '/templates/aadminlte/plugins/jquery/jquery.min.js');
	// $doc->addScript($this->baseurl. '/templates/aadminlte/plugins/bootstrap/js/bootstrap.bundle.min.js');
	// $doc->addScript($this->baseurl. '/templates/aadminlte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js');
	// $doc->addScript($this->baseurl. '/templates/aadminlte/plugins/jquery-mousewheel/jquery.mousewheel.js');
	// $doc->addScript($this->baseurl. '/templates/aadminlte/dist/js/adminlte.js');
	// $doc->addScript($this->baseurl. '/templates/aadminlte/plugins/raphael/raphael.min.js');
	// $doc->addScript($this->baseurl. '/templates/aadminlte/plugins/jquery-mapael/jquery.mapael.min.js');
	// $doc->addScript($this->baseurl. '/templates/aadminlte/plugins/jquery-mapael/maps/usa_states.min.js');
	// $doc->addScript($this->baseurl. '/templates/aadminlte/plugins/chart.js/Chart.min.js');
	// $doc->addScript($this->baseurl. '/templates/aadminlte/dist/js/demo.js');

?>
<div class="login-box-body <?php echo $this->pageclass_sfx ?>">
	<?php if ($this->params->get('show_page_heading')) : ?>
		<div class="page-header">
			<h1>
				<?php //echo $this->escape($this->params->get('page_heading')); ?>
			</h1>
		</div>
	<?php endif; ?>

	<?php if (($this->params->get('logindescription_show') == 1 && str_replace(' ', '', $this->params->get('login_description')) != '') || $this->params->get('login_image') != '') : ?>
		<div class="login-description">
		<?php endif; ?>

		<?php if ($this->params->get('logindescription_show') == 1) : ?>
			<?php echo $this->params->get('login_description'); ?>
		<?php endif; ?>

		<?php if (($this->params->get('login_image') != '')) : ?>
			<img src="<?php echo $this->escape($this->params->get('login_image')); ?>" class="login-image" alt="<?php echo Text::_('COM_USER_LOGIN_IMAGE_ALT') ?>" />
		<?php endif; ?>

		<?php if (($this->params->get('logindescription_show') == 1 && str_replace(' ', '', $this->params->get('login_description')) != '') || $this->params->get('login_image') != '') : ?>
		</div>
	<?php endif; ?>

	<form action="<?php echo Route::_('index.php?option=com_users&task=user.login'); ?>" method="post" class="form-horizontal">
		<fieldset>
			<div class="input-group mb-3">
				<input type="text" id="username" name="username" class="form-control validate-username required" required placeholder="Tên đăng nhập">
				<div class="input-group-append">
					<div class="input-group-text">
					<span class="fas fa-envelope"></span>
					</div>
				</div>
			</div>
			<div class="input-group mb-3">
				<input type="password" name="password" class="form-control required" required placeholder="Password">
				<div class="input-group-append">
					<div class="input-group-text">
					<span class="fas fa-lock"></span>
					</div>
				</div>
			</div>

			<?php $tfa = PluginHelper::getPlugin('twofactorauth'); ?>

			<?php if (!is_null($tfa) && $tfa != array()) : ?>
				<div class="control-group">
					<?php echo $this->form->getField('secretkey')->input; ?>
				</div>
			<?php endif; ?>
		
				<div class="control-group input-append">
					<input class="form-control" autocomplete="off" type="text" placeholder="Nhập mã xác thực" style="height:38px!important;width:253px;font-size:16px;display: block;float: left;" size="25" name="captcha" id="captcha">
					<img src="uploader/files/login_captcha<?php echo date('Ymd'); ?>.jpg" style="border: 1px solid #629b58!important;height:38px;width:130px;">
				</div>
		
			<?php if (PluginHelper::isEnabled('system', 'remember')) : ?>
				<div class="control-group" style="font-size:20px;padding-top:20px;padding-bottom:20px;">
					<input id="remember" type="checkbox" name="remember" class="inputbox" value="yes" />
					<span class="lbl"></span> Ghi nhớ
				</div>
			<?php endif; ?>
			<div class="controls-group">
				<button type="submit" id="btn_submit_login" class="btn btn-info" style="width:384px;font-size:20px;">
					<i class="icon-key"></i> <?php echo Text::_('JLOGIN'); ?>
				</button>
			</div>
			<input type="hidden" name="return" value="<?php echo base64_encode($this->params->get('login_redirect_url', $this->form->getValue('return'))); ?>" />
			<?php echo HTMLHelper::_('form.token'); ?>
		</fieldset>
	</form>
</div>
<style>
	.login-box{width: 384px;}
	.form-control{border-radius: 0px;}
	.form-control-feedback {
		position: absolute;
		top: 0;
		right: 0;
		z-index: 2;
		display: block;
		width: 34px;
		height: 34px;
		line-height: 34px;
		text-align: center;
		pointer-events: none;
	}
	.input-group-text{border-radius: 0px;}
	.visually-hidden, .sr-only, .visually-hidden-focusable:not(:focus):not(:focus-within) {
		position: absolute !important;
		width: 1px !important;
		height: 1px !important;
		padding: 0 !important;
		margin: -1px !important;
		overflow: hidden !important;
		clip: rect(0, 0, 0, 0) !important;
		white-space: nowrap !important;
		border: 0 !important;
	}
</style>