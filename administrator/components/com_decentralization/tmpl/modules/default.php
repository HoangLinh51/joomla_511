<?php

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\CMS\Router\Route;

defined('_JEXEC') or die('Restricted access');
/** @var \Joomla\Component\Decentralization\Administrator\View\Modules\HtmlView $this */


/** @var \Joomla\CMS\WebAsset\WebAssetManager $wa */
$wa = $this->document->getWebAssetManager();
$wa->useScript('table.columns')
    ->useScript('multiselect');
$user       = Factory::getUser();
$listOrder  = $this->escape($this->state->get('list.ordering'));
$listDirn   = $this->escape($this->state->get('list.direction'));
$loggeduser = Factory::getUser();
$saveOrder  = $listOrder == 'a.id';
$mfa        = PluginHelper::isEnabled('multifactorauth');
?>
<form action="<?php echo Route::_('index.php?option=com_decentralization&view=modules'); ?>" method="post" name="adminForm" id="adminForm">
    <div class="row">
        <div class="col-md-12">
            <div id="j-main-container" class="j-main-container">
                <?php
                    // Search tools bar

                    echo LayoutHelper::render('joomla.searchtools.default', ['view' => $this]);
                ?>

                    <table class="table" id="userList">
                        <caption class="visually-hidden">
                            <?php echo Text::_('COM_USERS_USERS_TABLE_CAPTION'); ?>,
                            <span id="orderedBy"><?php echo Text::_('JGLOBAL_SORTED_BY'); ?> </span>,
                            <span id="filteredBy"><?php echo Text::_('JGLOBAL_FILTERED_BY'); ?></span>
                        </caption>
                        <thead>
                            <tr>
                                <td class="w-1 text-center">
                                    <?php echo HTMLHelper::_('grid.checkall'); ?>
                                </td>
                                <th scope="col">
                                    <?php echo HTMLHelper::_('searchtools.sort', 'COM_DECENTRALIZATION_HEADING_MOUDULES_NAME', 'a.name', $listDirn, $listOrder); ?>
                                </th>
                                <th scope="col">
                                    <?php echo HTMLHelper::_('searchtools.sort', 'COM_DECENTRALIZATION_HEADING_MOUDULES_CODE', 'a.code', $listDirn, $listOrder); ?>
                                </th>
                                <th scope="col" class="d-none d-md-table-cell">
                                    <?php echo Text::_('COM_DECENTRALIZATION_HEADING_MOUDULES_DESC'); ?>
                                </th>
                                <th scope="col" class="w-5 text-center d-md-table-cell">
                                    <?php echo HTMLHelper::_('searchtools.sort', 'COM_DECENTRALIZATION_HEADING_MOUDULES_STATUS', 'a.status', $listDirn, $listOrder); ?>
                                </th>
                            </tr>
                        </thead>
                        <tbody<?php if ($saveOrder) :
                            ?> class="js-draggable" data-url="<?php echo $saveOrderingUrl; ?>" data-direction="<?php echo strtolower($listDirn); ?>"<?php
                              endif; ?>>
                        <?php $count = count($this->items); ?>
                        <?php foreach ($this->items as $i => $item) :
                            $canCreate = $user->authorise('core.create', 'com_decentralization');
                            $canEdit   = $user->authorise('core.edit', 'com_decentralization');
                            //$canChange = $user->authorise('core.edit.state', 'com_decentralization');
                            $canChange  = $user->authorise('core.edit.state', 'com_decentralization' . '.module.' . $item->id);
   

                            // If this group is super admin and this user is not super admin, $canEdit is false
                            if (!Factory::getUser()->authorise('core.admin')) {
                                $canEdit   = false;
                                $canChange = false;
                            }
                            ?>
                            <tr class="row<?php echo $i % 2; ?>">
                                <td class="text-center">
                                    <?php if ($canEdit) : ?>
                                        <?php echo HTMLHelper::_('grid.id', $i, $item->id, false, 'cid', 'cb'); ?>
                                    <?php endif; ?>
                                </td>
                                <th scope="row">
                                    <?php if ($canEdit) : ?>
                                    <a href="<?php echo Route::_('index.php?option=com_decentralization&task=module.edit&id=' . $item->id); ?>" title="<?php echo Text::_('JACTION_EDIT'); ?> <?php echo $this->escape($item->title); ?>">
                                        <?php echo $this->escape($item->name); ?></a>
                                    <?php else : ?>
                                        <?php echo $this->escape($item->name); ?>
                                    <?php endif; ?>
                                </th>
                                <td class="d-none d-md-table-cell">
                                    <?php echo $this->escape($item->code); ?>
                                </td>
                                <td class="d-none d-md-table-cell">
                                    <?php echo $this->escape($item->description); ?>
                                </td>
                                <td class="text-center d-md-table-cell">
                                    <?php
                                    // $activated = empty($item->status) ? 1 : 0;
                                    // echo HTMLHelper::_('jgrid.state', HTMLHelper::_('dec.activateStates'), $activated, $i, 'modules.', (bool) $activated);
                                    
                                    ?>

                                        <?php echo HTMLHelper::_('jgrid.published', $item->status, $i, 'modules.', $canChange); ?>

                                </td>
                               
                            </tr>
                        <?php endforeach;?>    
                        </tbody>
                    </table>
                    <?php // load the pagination. ?>
                    <?php // echo $this->pagination->getListFooter(); ?>
                    <input type="hidden" name="task" value="">
                    <input type="hidden" name="boxchecked" value="0">
                    <?php echo HTMLHelper::_('form.token'); ?>
        
            </div>
        </div>
    </div>
</form>

<style>
.pagination{
    margin: 0 !important;
}

</style>
