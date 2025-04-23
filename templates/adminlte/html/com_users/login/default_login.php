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

	<?php foreach (Factory::getApplication()->getMessageQueue() as $message) : ?>
		<?php if ($message['type'] == 'error') : ?>
			<div class="alert alert-<?php echo $message['type']; ?>">
				<?php echo $message['message']; ?>
			</div>
		<?php endif; ?>
	<?php endforeach; ?>


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

			<div class="form-floating">
				<input type="text" id="username" name="username" class="form-control validate-username required" required placeholder=" ">
				<label for="username">Tài khoản</label>
			</div>

			<div class="form-floating">
				<input type="password" name="password" id="password" class="form-control required" required placeholder=" ">
				<label for="password">Mật khẩu</label>
			</div>

			<?php $tfa = PluginHelper::getPlugin('twofactorauth'); ?>
			<?php if (!is_null($tfa) && $tfa != array()) : ?>
				<div class="control-group">
					<?php echo $this->form->getField('secretkey')->input; ?>
				</div>
			<?php endif; ?>

			<div class="form-floating captcha-floating">
				<input class="form-control" autocomplete="off" type="text" placeholder=" " name="captcha" id="captcha" required>
				<label for="captcha">Mã xác thực</label>
				<img src="uploader/files/login_captcha<?php echo date('Ymd'); ?>.jpg" class="captcha-img" alt="captcha">
			</div>

			<div class="controls-group">
				<button type="submit" id="btn_submit_login" class="btn btn-info">
					<i class="icon-key"></i> Đăng Nhập
				</button>
			</div>

			<input type="hidden" name="return" value="<?php echo base64_encode($this->params->get('login_redirect_url', $this->form->getValue('return'))); ?>" />
			<?php echo HTMLHelper::_('form.token'); ?>

		</fieldset>
	</form>

	<button class="tax-button">Đăng Nhập Bằng EGOV</button>
</div>
<style>
	.alert {
		padding: 5px;
		margin-bottom: 10px;
		border: none;
		border-radius: 5px;
	}

	.alert-error {
		background-color: #f2dede;
		color: rgb(206, 113, 111);
		border-color: #ebccd1;
	}

	.alert-success {
		background-color: #dff0d8;
		color: #3c763d;
		border-color: #d6e9c6;
	}

	.form-floating {
		position: relative;
		margin-top: 20px;
	}

	.form-floating input {
		width: 100%;
		padding: 14px 10px 10px;
		font-size: 16px;
		border: 1px solid #ccc;
		border-radius: 6px;
		background: none;
		outline: none;
	}

	.form-floating label {
		position: absolute;
		top: 50%;
		left: 12px;
		transform: translateY(-50%);
		background: white;
		padding: 0 5px;
		color: #999;
		font-size: 16px;
		transition: 0.2s ease all;
		pointer-events: none;
	}

	.form-floating input:focus+label,
	.form-floating input:not(:placeholder-shown)+label {
		top: 0;
		font-size: 13px;
		color: #269bff;
	}

	.captcha-floating {
		display: flex;
		align-items: center;
		gap: 10px;
		margin-top: 20px;
	}

	.captcha-img {
		border: 1px solid #629b58 !important;
		height: 38px;
		width: 110px;
		border-radius: 6px;
	}

	button,
	.btn-info {
		width: 100%;
		padding: 12px;
		background-color: #269bff;
		color: white;
		border: none;
		border-radius: 6px;
		font-weight: bold;
		font-size: 16px;
		margin-top: 15px;
	}

	.tax-button {
		background-color: #7cc97c;
		margin-top: 10px;
	}
</style>