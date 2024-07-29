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
$isModal  = $input->get('layout') === 'modal_value';
$layout   = $isModal ? 'modal_value' : 'edit_value';
$tmpl     = $isModal || $input->get('tmpl', '', 'cmd') === 'component' ? '&tmpl=component' : '';
$clientId = 0;
$main_url = 'index.php?option=com_core&view=config';
?>
<form action="index.php?option=com_core&view=config&layout=edit_value&id=<?php echo (int) $this->item->id ?>" method="post" name="adminForm" id="adminForm" class="form-horizontal form-validate">
<input type="hidden" name="jform[id]" value="<?php echo $this->value->id?>">
<input type="hidden" name="jform[config_field_id]" value="<?php echo $this->item->id?>">
  <div class="control-group">
    <label class="control-label" for="value">Value</label>
    <div class="controls">
    <?php 
      $type = strtolower($this->item->type);
     
      switch ($type) {
        case 'text' :
          if ($this->item->model != null) {
            $model = Core::model($this->item->model);	
            ?>
            <input type="text" value="<?php echo (!isset($this->value->value)?$model->buildValue():$this->value->value);?>" name="jform[value]" class="form-control" />
            <?php
          }else{
            ?>
            <input type="text" value="<?php echo $this->value->value ?>" name="jform[value]" class="form-control" />
            <?php
          }
        break;  
        case 'textarea' :
          if ($this->item->model != null) {
            $model = Core::model($this->item->model);	
            
            ?>
            <textarea type="text" name="jform[value]" class="form-control" ><?php echo (!isset($this->value->value)?$model->buildValue():$this->value->value);?></textarea>
            <?php
          }else{
            ?>
            <textarea type="text" value="" name="jform[value]" class="form-control" ><?php echo $this->value->value ?></textarea>
            <?php
          }
        break;  
        case 'select' :
          if ($this->item->model != null) {
              $model = Core::model($this->item->model);		
              echo HTMLHelper::_('select.genericlist',$model->buildValue(),'jform[value]', 'class="form-control"','value','text',$this->value->value);
              ?>
            <?php
          }else{
            ?>
            <select type="text" value="<?php echo $this->value->path ?>" name="jform[value]" class="form-control" ></select>
            <?php
          }
        break; 
        default :
				{
          if ($this->item->model != null) {
            $model = Core::model($this->item->model);		
            ?>
            <input type="text" class="form-control" value="<?php echo (!isset($this->value->value)?$model->buildValue():$this->value->value);?>" name="jform[value]" class="form-control" />
            <?php
          }else{
            ?>
            <input type="text" class="form-control" value="<?php echo $this->value->value;?>" name="jform[value]"  />
            <?php
          }
				}
				break;
      }
    ?>
     
    </div>
  </div> 
  <div class="control-group">
    <label class="control-label" for="path">Path</label>
    <div class="controls">
      <input class="form-control" type="text" name="jform[path]" filter="raw" readonly="readonly" id="path" value="<?php echo $this->item->path?>">
    </div>
  </div>  
  <input type="hidden" name="task" value="">
  <?php echo HTMLHelper::_('form.token'); ?>  
</form>
