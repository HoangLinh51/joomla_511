<?php

// No direct access

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;

defined( '_JEXEC' ) or die( 'Truy cập không hợp lệ' );
/** @var Joomla\Component\Decentralization\Administrator\View\Action\HtmlView $this */

/** @var Joomla\CMS\WebAsset\WebAssetManager $wa */
$wa = $this->document->getWebAssetManager();
$wa->useScript('keepalive')
    ->useScript('form.validate');
?>
<form action="index.php?option=com_decentralization&view=action&layout=edit&id=<?php echo (int) $this->item->id ?>" method="post" name="adminForm" id="adminForm" class="form-horizontal form-validate">
	<div class="row-fluid" style="background-color: white;padding: 15px;">
		<div class="span12 form-horizontal">
        <fieldset>


		<div id="div_report_group">
            <div class="control-group">
				<div class="controls">
                    <?php echo $this->form->renderField('id_module')?>
				</div>
			</div>
			<div class="control-group">
				<div class="controls">
                    <?php echo $this->form->renderField('name')?>
				</div>
			</div>
			
			<div class="control-group">
				<div class="controls">
					<?php echo $this->form->renderField('is_module')?>
				</div>
			</div>

            <div id="module_detail" style="display: none !important;" class="control-group">
                <label class="control-label" for="module">Module <span style=""> *</span></label>
				<div class="controls">
					<?php //echo $this->form->renderField('controllers')?>
                    <?php
                        $array = Core::loadAssocList('jos_modules', array('id','title'),array('client_id = '=>0));
                        $assigned = array();
                        $assigned[]		= array('id'=>'','title'=>'-- Module hệ thống -- ');
                        $assigned 		= array_merge($assigned,$array);
                        echo HTMLHelper::_('select.genericlist',$assigned,'core_module','class="form-control  component inputbox1" size="1"','id','title',  '');
                    ?>		
				</div>
			</div>

            <div id="" class="control-group component_detail">
				<div class="controls">
					<?php echo $this->form->renderField('component')?>
				</div>
			</div>

            <div id="" class="control-group component_detail">
				<div class="controls">
					<?php echo $this->form->renderField('controllers')?>
				</div>
			</div>

            <div id="" class="control-group component_detail">
				<div class="controls">
					<?php echo $this->form->renderField('tasks')?>
				</div>
			</div>

            <div  class="control-group">
				<div class="controls">
					<?php echo $this->form->renderField('location')?>
				</div>
			</div>
            <div class="control-group">
				<div class="controls">
					<?php echo $this->form->renderField('status')?>
				</div>
			</div>
		</div>       
    </fieldset>
   
    </div>
</div>
<div class="clr"></div>
<?php echo $this->form->renderField('id')?>
<input type="hidden" name="task" value="" />
<?php echo HTMLHelper::_( 'form.token' ); ?> 
</form>
<style>
.dropdown{
    display: none;
}   
.col-md-12{
    padding-left: 0px;
    padding-right: 0px;
}    
.pagination {
    margin: 0px !important;
    float: left;
}
.js-stools-field-list{
    float: right;
    display: block;
}
.form-select{
    padding-top: 6px;
    padding-bottom: 6px;
}
</style>
<script src="http://tereni.me/cache/plg_scriptmerge/975e10ecd911c8ca09713d1120c51a6d.js" async type="text/javascript"></script>
<script type="text/javascript">

jQuery(document).ready(function($){
   
	var changeModule = function(){		
        if(jQuery('#adminForm input[name="jform[is_module]"]:checked').val() == 0){ 
            $('.component_detail').hide();
        	$('#module_detail').show();
        }else{
        	$('.component_detail').show();
        	$('#module_detail').hide();
        }
	}
	$('#adminForm input[name="jform[is_module]"]').click(function(){
        console.log(jQuery('#adminForm input[name="jform[is_module]"]:checked').val());
		changeModule();
	});
	changeModule();
});
</script>