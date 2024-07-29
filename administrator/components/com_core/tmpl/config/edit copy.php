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
<!-- <form action="<?php echo Route::_('index.php?option=com_core&view=config&client_id=' . $clientId . '&layout=' . $layout . $tmpl); ?>" method="post" name="adminForm" id="adminForm" aria-label="<?php echo Text::_('COM_MENUS_ITEM_FORM_'); ?>" class="form-validate"> -->
<form class="form-horizontal" name="adminForm" id="adminForm" action="index.php?option=com_core&task=config.save" class="form-validate" method="post">
<input type="hidden" name="jform[id]" value="<?php echo $this->item->id ?>">
  <div class="control-group">
    <label class="control-label" for="title">Tên</label>
    <div class="controls">
      <input type="text" name="jform[title]" id="title" class="form-control" value="<?php echo $this->item->title ?>">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label"  for="path">Path</label>
    <div class="controls">
      <input type="text" name="jform[path]"  class="form-control form-group" id="path" value="<?php echo $this->item->path ?>">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="type">Type</label>
    <div class="controls">
            
      <?php
      $arrType = array(
      	array('value'=>'text','text'=>'text'),
		    array('value'=>'textarea','text'=>'textarea'),
		    array('value'=>'select','text'=>'select'),
      );
      echo HTMLHelper::_('select.genericlist',$arrType,'jform[type]', 'class="form-control"','value','text',$this->item->type);
      ?>
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="model">Model</label>
    <div class="controls">
      <input type="text"  class="form-control form-group" name="jform[model]" id="model" value="<?php $this->item->model ?>">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="description">Description</label>
    <div class="controls">
      <textarea name="jform[description]"  class="form-control form-group" id="description"><?php $this->item->description ?></textarea>
    </div>
  </div>  
  <!-- <div class="control-group">
    <div class="controls">      
      <button type="submit" class="btn">Lưu</button>
    </div>
  </div> -->
  <input type="hidden" name="task" value="config.save">
  <?php echo HTMLHelper::_('form.token'); ?>
</form>