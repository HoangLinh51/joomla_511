<?php

/**
 * @package     Joomla.Administrator
 * @subpackage  COM_DECENTRALIZATION
 *
 * @copyright   (C) 2008 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;

/** @var Joomla\Component\Decentralization\Administrator\View\User\HtmlView $this */

/** @var Joomla\CMS\WebAsset\WebAssetManager $wa */
$wa = $this->document->getWebAssetManager();
$wa->useScript('keepalive')
    ->useScript('form.validate');

$input = Factory::getApplication()->getInput();

// Get the form fieldsets.
$fieldsets = $this->form->getFieldsets();
$settings  = [];

$this->useCoreUI = true;
?>
<form action="<?php echo Route::_('index.php?option=com_decentralization&layout=edit&id=' . (int) $this->item->id); ?>" method="post" name="adminForm" id="user-form" enctype="multipart/form-data" aria-label="<?php echo Text::_('COM_DECENTRALIZATION_USER_FORM_' . ((int) $this->item->id === 0 ? 'NEW' : 'EDIT'), true); ?>" class="form-validate">

    <h2><?php echo $this->escape($this->form->getValue('name', null, Text::_('COM_DECENTRALIZATION_USER_NEW_USER_TITLE'))); ?></h2>

    <div class="main-card">
        <?php echo HTMLHelper::_('uitab.startTabSet', 'myTab', ['active' => 'details', 'recall' => true, 'breakpoint' => 768]); ?>

        <?php echo HTMLHelper::_('uitab.addTab', 'myTab', 'details', Text::_('COM_DECENTRALIZATION_USER_ACCOUNT_DETAILS')); ?>
            <fieldset class="options-form">
                <legend><?php echo Text::_('COM_DECENTRALIZATION_USER_ACCOUNT_DETAILS'); ?></legend>
                <div class="form-grid">
                    <?php echo $this->form->renderFieldset('user_details'); ?>
                </div>
            </fieldset>

        <?php echo HTMLHelper::_('uitab.endTab'); ?>

        <?php if ($this->grouplist) : ?>
            <?php echo HTMLHelper::_('uitab.addTab', 'myTab', 'groups', Text::_('COM_DECENTRALIZATION_ASSIGNED_GROUPS')); ?>
                <fieldset id="fieldset-groups" class="options-form">
                    <legend><?php echo Text::_('COM_DECENTRALIZATION_ASSIGNED_GROUPS'); ?></legend>
                    <div>
                    <?php echo $this->loadTemplate('groups'); ?>
                    </div>
                </fieldset>
            <?php echo HTMLHelper::_('uitab.endTab'); ?>
        <?php endif; ?>
       
    </div>
    <input type="hidden" name="task" value="">
    <input type="hidden" name="return" value="<?php echo $input->getBase64('return'); ?>">
    <?php echo HTMLHelper::_('form.token'); ?>
</form>
<script type="text/javascript">
jQuery(document).ready(function($) {
    var code,tree_donvi = <?php echo json_encode($this->donvi); ?>;
    var Ids  = '<?php echo $this->donvi_id; ?>'; 
    var IdQl = '<?php echo $this->donviquanly_id; ?>'; 
    $('#jform_id_donvi').comboTree({
	    source : tree_donvi,
        selected: [Ids],
	    isMultiple: false,
        cascadeSelect: false,
		collapse:true,
        selectableLastNode: true,
	})
    .onChange(function(element){
        let selectedNames = this.getSelectedNames(); 
        let selectedIds = this.getSelectedIds();     
        $('#jform_id_donvi').val(selectedNames);
        $('#jform_id_donvi_hidden').val(selectedIds);
    });
    $('#jform_id_donvi_hidden').prop('value', Ids);
   
    $('#jform_id_donviquanly').comboTree({
	    source : tree_donvi,
        selected: [IdQl],
	    isMultiple: false,
        cascadeSelect: false,
		collapse:true,
        selectableLastNode: true,
	}).onChange(function(){
        let selectedNames = this.getSelectedNames(); 
        let selectedIds = this.getSelectedIds();     
        $('#jform_id_donviquanly').val(selectedNames);
        $('#jform_id_donviquanly_hidden').val(selectedIds);
    });
    $('#jform_id_donviquanly_hidden').prop('value', IdQl);
 


});


</script>
<style>
    /*!
 * jQuery ComboTree Plugin 
 * Author:  Erhan FIRAT
 * Mail:    erhanfirat@gmail.com
 * Licensed under the MIT license
 * Version: 1.2.1
 */
.hidden_bullet{background: red;}  
.mdi-chevron-right-circle-outline.hidden_bullet_1{ color: white !important;background: none !important;} 
.mdi-chevron-down-circle-outline.hidden_bullet_1{ color: white !important;background: none !important;} 
.file > span > span{display: none !important;}
.hidden_bullet_1 > span > span{color: white !important;background: none !important;}
.mdi-chevron-down-circle-outline{
    background: url('<?php echo Uri::root(true) ?>/media/cbcc/js/combotree/images/tree_icons.png') no-repeat -22px 1px;
    width: 10px;
    display: block;
    color: white !important;
}

.mdi-chevron-right-circle-outline{
    background: url('<?php echo Uri::root(true) ?>/media/cbcc/js/combotree/images/tree_icons.png') no-repeat -5px 0px;
    width: 10px;
    display: block;
    color: white !important;
}

</style>