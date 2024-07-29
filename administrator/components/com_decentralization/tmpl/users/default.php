<?php

use Joomla\CMS\Access\Access;
use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Router\Route;
use Joomla\Component\Decentralization\Administrator\Helper\DecentralizationHelper;

defined('_JEXEC') or die('Restricted access');
/** @var \Joomla\Component\Decentralization\Administrator\View\Users\HtmlView $this */


/** @var \Joomla\CMS\WebAsset\WebAssetManager $wa */
$wa = $this->document->getWebAssetManager();
$wa->useScript('table.columns')
    ->useScript('multiselect');
$listOrder  = $this->escape($this->state->get('list.ordering'));
$listDirn   = $this->escape($this->state->get('list.direction'));
$loggeduser = Factory::getUser();
?>
<form action="<?php echo Route::_('index.php?option=com_decentralization&view=users'); ?>" method="post" name="adminForm" id="adminForm">
    <div class="row">
        <div class="col-md-12">
            <div id="j-main-container" class="j-main-container">
                <?php
                // Search tools bar
                echo LayoutHelper::render('joomla.searchtools.default', ['view' => $this]);
                ?>
                <?php if (empty($this->items)) : ?>
                    <div class="alert alert-info">
                        <span class="icon-info-circle" aria-hidden="true"></span><span class="visually-hidden"><?php echo Text::_('INFO'); ?></span>
                        <?php echo Text::_('JGLOBAL_NO_MATCHING_RESULTS'); ?>
                    </div>
                <?php else : ?>
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
                                    <?php echo HTMLHelper::_('searchtools.sort', 'COM_DECENTRALIZATION_HEADING_NAME', 'a.name', $listDirn, $listOrder); ?>
                                </th>
                                <th scope="col" class="w-5 text-center d-md-table-cell">
                                    <?php echo HTMLHelper::_('searchtools.sort', 'COM_DECENTRALIZATION_HEADING_USERNAME', 'a.username', $listDirn, $listOrder); ?>
                                </th>
                                <th scope="col" class="">
                                    <?php echo Text::_('COM_DECENTRALIZATION_HEADING_INDEPT'); ?>
                                </th>
                                <th scope="col" class="">
                                    <?php echo Text::_('COM_DECENTRALIZATION_HEADING_DEPT'); ?>
                                </th>
                                <th scope="col" class="w-5 text-center d-md-table-cell">
                                    <?php echo HTMLHelper::_('searchtools.sort', 'COM_DECENTRALIZATION_HEADING_ACTIVATED', 'a.activation', $listDirn, $listOrder); ?>
                                </th>
                                <th scope="col" class="">
                                    <?php echo HTMLHelper::_('searchtools.sort', 'JGLOBAL_EMAIL', 'a.email', $listDirn, $listOrder); ?>
                                </th>
                                <th scope="col" class="w-12 d-none d-xl-table-cell">
                                    <?php echo HTMLHelper::_('searchtools.sort', 'COM_DECENTRALIZATION_HEADING_LAST_VISIT_DATE', 'a.lastvisitDate', $listDirn, $listOrder); ?>
                                </th>
                                <th scope="col" class="w-5 d-none d-md-table-cell">
                                    <?php echo HTMLHelper::_('searchtools.sort', 'JGRID_HEADING_ID', 'a.id', $listDirn, $listOrder); ?>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($this->items as $i => $item) :
                            $canEdit   = $this->canDo->get('core.edit');
                            $canChange = $loggeduser->authorise('core.edit.state', 'com_decentralization');

                            // If this group is super admin and this user is not super admin, $canEdit is false
                            if ((!$loggeduser->authorise('core.admin')) && Access::check($item->id, 'core.admin')) {
                                $canEdit   = false;
                                $canChange = false;
                            }
                            ?>
                            <tr class="row<?php echo $i % 2; ?>">
                                <td class="text-center">
                                    <?php if ($canEdit || $canChange) : ?>
                                        <?php echo HTMLHelper::_('grid.id', $i, $item->id, false, 'cid', 'cb', $item->name); ?>
                                    <?php endif; ?>
                                </td>
                                <th scope="row">
                                    <div class="name break-word">
                                    <?php if ($canEdit) : ?>
                                        <a href="<?php echo Route::_('index.php?option=com_decentralization&task=user.edit&id=' . (int) $item->id); ?>" title="<?php echo Text::sprintf('COM_USERS_EDIT_USER', $this->escape($item->name)); ?>">
                                            <?php echo $this->escape($item->name); ?></a>
                                    <?php else : ?>
                                        <?php echo $this->escape($item->name); ?>
                                    <?php endif; ?>
                                    </div>   
                                    <?php if ($item->requireReset == '1') : ?>
                                        <span class="badge bg-warning text-dark"><?php echo Text::_('COM_DECENTRALIZATION_PASSWORD_RESET_REQUIRED'); ?></span>
                                    <?php endif; ?>
                                </th>
                                <td class="break-word d-none d-md-table-cell">
                                    <?php echo $this->escape($item->username); ?>
                                </td>
                                <td class="break-word d-none d-md-table-cell">
                                    <?php echo $this->escape($item->donvithuocve); ?>
                                </td>
                                <td class="break-word d-none d-md-table-cell">
                                    <?php echo $this->escape($item->donviquanly); ?>
                                </td>
                                <td class="text-center d-md-table-cell">
                                    <?php $self = $loggeduser->id == $item->id; ?>
                                    <?php if ($canChange) : ?>
                                        <?php echo HTMLHelper::_('jgrid.state', HTMLHelper::_('dec.blockStates', $self), $item->block, $i, 'users.', !$self); ?>
                                    <?php else : ?>
                                        <?php echo HTMLHelper::_('jgrid.state', HTMLHelper::_('dec.blockStates', $self), $item->block, $i, 'users.', false); ?>
                                    <?php endif; ?>
                                </td>
                                <td class="break-word d-none d-md-table-cell">
                                    <?php echo $this->escape($item->email); ?>
                                </td>
                                <td class="break-word d-none d-md-table-cell">
                                    <?php echo $this->escape($item->lantruycaptruoc); ?>
                                </td>
                                <td class="break-word d-none d-md-table-cell">
                                    <?php echo $this->escape($item->id); ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?php // load the pagination. ?>
                    <?php echo $this->pagination->getListFooter(); ?>
                    <input type="hidden" name="task" value="">
                    <input type="hidden" name="boxchecked" value="0">
                    <?php echo HTMLHelper::_('form.token'); ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</form>

<style>
.pagination{
    margin: 0 !important;
}

</style>
