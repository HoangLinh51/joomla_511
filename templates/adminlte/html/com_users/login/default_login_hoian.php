<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_users
 *
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JHtml::_('behavior.keepalive');
$is_sso = Core::config('core/sso/is_sso');
if (Core::config('core/captcha/is_use') == 1) {
	$captcha_length = Core::config('core/captcha/length'); //$session['captcha_length']; //1 ký tự = 8
	$captcha_content = Core::config('core/captcha/content');
	session_start();

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
}
// JHtml::_('behavior.keepalive');
?>
<form action="<?php echo JRoute::_('index.php?option=com_users&task=user.login'); ?>" method="post" class="frmlogin">
		<?php foreach ($this->form->getFieldset('credentials') as $field) : ?>
			<?php if (!$field->hidden) : ?>
				<div class="controls input-row">
					<?php echo $field->label; ?>
					<?php echo $field->input; ?>
				</div>
			<?php endif; ?>
		<?php endforeach; ?>

		<?php $tfa = JPluginHelper::getPlugin('twofactorauth'); ?>

		<?php if (!is_null($tfa) && $tfa != array()): ?>
			<div class="controls input-row">
					<?php echo $this->form->getField('secretkey')->label; ?>
					<?php echo $this->form->getField('secretkey')->input; ?>
			</div>
		<?php endif; ?>

		<?php if (JPluginHelper::isEnabled('system', 'remember')) : ?>
		<div  class="controls input-row">
				<input id="remember" type="checkbox" name="remember" class="inputbox" value="yes"/>
				<span class="lbl"></span>
				<label for="remember"><?php echo JText::_('COM_USERS_LOGIN_REMEMBER_ME') ?></label>
		</div>
		<?php endif; ?>

		<div class="controls input-row">
			<button type="submit" class="btn-luu btn-luu-primary">
				<?php echo JText::_('JLOGIN'); ?>
			</button>
		</div>

		<input type="hidden" name="return" value="<?php echo base64_encode($this->params->get('login_redirect_url', $this->form->getValue('return'))); ?>" />
		<?php echo JHtml::_('form.token'); ?>
</form>
