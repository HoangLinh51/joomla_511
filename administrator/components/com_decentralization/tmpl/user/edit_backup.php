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
var code,tree_donvi = <?php echo json_encode($this->donvi); ?>;
jQuery(document).ready(function($) {
   
	$('#jform_id_donvi').comboTree({
	 source : tree_donvi,
	 isMultiple: false

	 });
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


:root {
    --ct-bg: #fff;
    --ct-btn-hover: #e8e8e8;
    --ct-btn-active: #ddd;
    --ct-btn-color: #555;
    --ct-border-color: #e1e1e1;
    --ct-border-radius: 5px;
    --ct-tree-hover: #efefef;
    --ct-selection: #418EFF;
    --ct-padding: 8px;
}


.comboTreeWrapper{
	position: relative;
	text-align: left !important;
}

.comboTreeInputWrapper{
	position: relative;
}

.comboTreeArrowBtn {
	position: absolute;
    right: 0px;
    bottom: 0px;
    top: 0px;
    box-sizing: border-box;
    border: 1px solid var(--ct-border-color);
    border-radius: 0 var(--ct-border-radius) var(--ct-border-radius) 0;
    background: var(--ct-border-color);
    cursor: pointer;
    -webkit-user-select: none; /* Safari */
    -moz-user-select: none; /* Firefox */
    -ms-user-select: none; /* IE10+/Edge */
    user-select: none; /* Standard */
}
.comboTreeArrowBtn:hover {
    background: var(--ct-btn-hover);
}
.comboTreeArrowBtn:active {
    background: var(--ct-btn-active);
}
.comboTreeInputBox:focus + .comboTreeArrowBtn {
    color: var(--ct-btn-color);
    border-top: 1px solid var(--ct-selection);
    border-right: 1px solid var(--ct-selection);
    border-bottom: 1px solid var(--ct-selection);
}

.comboTreeArrowBtnImg{
    font-size: 1.25rem;
}

.comboTreeDropDownContainer {
	display: none;
	background: var(--ct-bg);
	border: 1px solid var(--ct-border-color);
	position: absolute;
  width: 100%;
  box-sizing: border-box;
  z-index: 999;
	max-height: 250px;
	overflow-y: auto;
}

.comboTreeDropDownContainer ul{
	padding: 0px;
	margin: 0;
}

.comboTreeDropDownContainer li{
	list-style-type: none;
	padding-left: 15px;
}

.comboTreeDropDownContainer li .selectable{
	cursor: pointer;
}

.comboTreeDropDownContainer li .not-selectable{
	cursor: not-allowed;
}


.comboTreeDropDownContainer li:hover{
	background-color: var(--ct-tree-hover);}
.comboTreeDropDownContainer li:hover ul{
	background-color: var(--ct-bg)}
.comboTreeDropDownContainer li span.comboTreeItemTitle.comboTreeItemHover,
.comboTreeDropDownContainer label.comboTreeItemHover
{
	background-color: var(--ct-selection);
	color: var(--ct-bg);
    border-radius: 2px;
}

span.comboTreeItemTitle, .comboTreeDropDownContainer .selectAll{
	display: block;
    padding: 3px var(--ct-padding);
}
.comboTreeDropDownContainer label{
    cursor: pointer;
	width: 100%;
    display: block;
}
.comboTreeDropDownContainer .comboTreeItemTitle input,
.comboTreeDropDownContainer .selectAll input {
	position: relative;
    top: 2px;
	margin: 0px 4px 0px 0px;
}
.comboTreeParentPlus{
    position: relative;
    left: -12px;
    top: 4px;
    width: 4px;
    float: left;
		cursor: pointer;
}


.comboTreeInputBox {
	padding: var(--ct-padding);
    border-radius: var(--ct-border-radius);
    border: 1px solid var(--ct-border-color);
    width: 100%;
    box-sizing: border-box;
    padding-right: 24px;
}
.comboTreeInputBox:focus {
    border: 1px solid var(--ct-selection);
    outline-width: 0;
}


.multiplesFilter{
	width: 100%;
	padding: 5px;
	box-sizing: border-box;
	border-top: none;
	border-left: none;
	border-right: none;
	border-bottom: 1px solid var(--ct-border-color);
}

</style>