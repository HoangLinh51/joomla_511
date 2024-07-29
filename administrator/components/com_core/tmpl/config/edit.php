<?php

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Associations;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;

/** @var Joomla\CMS\WebAsset\WebAssetManager $wa */
$wa = $this->document->getWebAssetManager();
$wa->useScript('keepalive')
    ->useScript('form.validate')
    ->useScript('bootstrap.modal');
$assoc = Associations::isEnabled();
$input = Factory::getApplication()->getInput();

// // In case of modal
$isModal  = $input->get('layout') === 'modal';
$layout   = $isModal ? 'modal' : 'edit';
$tmpl     = $isModal || $input->get('tmpl', '', 'cmd') === 'component' ? '&tmpl=component' : '';
$clientId = 0;
$task = 'saveConfig';
// $lang     = Factory::getLanguage()->getTag();
// $main_url = 'index.php?option=com_core&view=config';


?>
<form action="index.php?option=com_core&view=config&layout=edit&id=<?php echo (int) $this->item->id ?>" method="post" name="adminForm" id="adminForm" class="form-horizontal form-validate">
  <div class="">
    <?php echo $this->form->renderField('id')?>
    <?php echo $this->form->renderField('title')?>
  </div>
  <div class="">
    <?php echo $this->form->renderField('path')?>
  </div>
  <div class="">
    <?php echo $this->form->renderField('type')?>  
  </div>
  <div class="">
    <?php echo $this->form->renderField('model')?>
  </div>
  <div class="">
    <?php echo $this->form->renderField('description')?> 
  </div>  
  <input type="hidden" name="task" value="config.save">
  <?php echo HTMLHelper::_('form.token'); ?>
</form>