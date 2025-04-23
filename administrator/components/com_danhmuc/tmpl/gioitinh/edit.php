<?php

// No direct access

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;

defined('_JEXEC') or die('Truy cập không hợp lệ');
/** @var Joomla\Component\Danhmuc\Administrator\View\Gioitinh\HtmlView $this */

/** @var Joomla\CMS\WebAsset\WebAssetManager $wa */
$wa = $this->document->getWebAssetManager();
$wa->useScript('keepalive')
    ->useScript('form.validate');

?>
<form action="index.php?option=com_danhmuc&view=gioitinh&layout=edit&code=<?php echo (int) $this->item->code ?>" method="post" name="adminForm" id="adminForm" class="form-horizontal form-validate">
    <div class="row-fluid" style="background-color: white;padding: 15px;">
        <div class="span12 form-horizontal">
            <fieldset>


                <div id="div_report_group">
                    <div class="control-group">
                        <div class="controls">
                            <?php echo $this->form->renderField('name') ?>
                        </div>
                    </div>

                    <div class="control-group">
                        <div class="controls">
                            <?php echo $this->form->renderField('level') ?>
                        </div>
                    </div>

                    <div class="control-group">
                        <div class="controls">
                            <?php echo $this->form->renderField('status') ?>
                        </div>
                    </div>
                </div>
            </fieldset>
        </div>
    </div>
    <div class="clr"></div>
    <?php echo $this->form->renderField('code') ?>
    <input type="hidden" name="task" value="" />
    <?php echo HTMLHelper::_('form.token'); ?>
</form>
<style>
    .dropdown {
        display: none;
    }

    .col-md-12 {
        padding-left: 0px;
        padding-right: 0px;
    }

    .pagination {
        margin: 0px !important;
        float: left;
    }

    .js-stools-field-list {
        float: right;
        display: block;
    }

    .form-select {
        padding-top: 6px;
        padding-bottom: 6px;
    }
</style>