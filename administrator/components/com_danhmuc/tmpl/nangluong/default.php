<?php
ini_set('memory_limit', '-1');

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\CMS\Router\Route;

defined('_JEXEC') or die('Restricted access');
/** @var \Joomla\Component\Danhmuc\Administrator\View\Nangluong\HtmlView $this */


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
<form action="<?php echo Route::_('index.php?option=com_danhmuc&view=nangluong'); ?>" method="post" name="adminForm" id="adminForm">
    <div class="row">
        <div class="col-md-12">
            <div id="j-main-container" class="j-main-container">
                <?php //error 500 if uncomment line below 
                ?>
                <?php echo LayoutHelper::render('joomla.searchtools.default', array('view' => $this));
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
                                <?php echo HTMLHelper::_('searchtools.sort', 'COM_DANHMUC_HINHTHUCNANGLUONG_NAME', 'a.name', $listDirn, $listOrder); ?>
                            </th>
                            <th scope="col" class="d-none d-md-table-cell">
                                <?php echo Text::_('COM_DANHMUC_HINHTHUCNANGLUONG_NANGLUONG'); ?>
                            </th>
                            <th scope="col" class="d-none d-md-table-cell">
                                <?php echo Text::_('COM_DANHMUC_HINHTHUCNANGLUONG_NHAPTIEN'); ?>
                            </th>
                            <th scope="col" class="d-none d-md-table-cell">
                                <?php echo Text::_('COM_DANHMUC_HINHTHUCNANGLUONG_PERCENT'); ?>
                            </th>
                            <th scope="col" class="d-none d-md-table-cell">
                                <?php echo Text::_('COM_DANHMUC_HINHTHUCNANGLUONG_STATUS'); ?>
                            </th>
                            <th scope="col" class="w-5 text-center d-md-table-cell">
                                <?php echo HTMLHelper::_('searchtools.sort', 'COM_DANHMUC_HINHTHUCNANGLUONG_CODE', 'a.code', $listDirn, $listOrder); ?>
                            </th>
                        </tr>
                    </thead>
                    <tbody<?php if ($saveOrder) :
                            ?> class="js-draggable" data-url="<?php echo $saveOrderingUrl; ?>" data-direction="<?php echo strtolower($listDirn); ?>" <?php
                                                                                                                                                    endif; ?>>
                        <?php $count = count($this->items); ?>
                        <?php foreach ($this->items as $i => $item) :
                            $canCreate = $user->authorise('core.create', 'com_danhmuc');
                            $canEdit   = $user->authorise('core.edit', 'com_danhmuc');
                            $canChange  = $user->authorise('core.edit.state', 'com_danhmuc' . '.nangluong.' . $item->code);


                            // If this group is super admin and this user is not super admin, $canEdit is false
                            if (!Factory::getUser()->authorise('core.create')) {
                                $canEdit   = false;
                                $canChange = false;
                            }
                        ?>
                            <tr class="row<?php echo $i % 2; ?>">
                                <td class="text-center">
                                    <?php if ($canEdit) : ?>
                                        <?php echo HTMLHelper::_('grid.id', $i, $item->code, false, 'cid', 'cb'); ?>
                                    <?php endif; ?>
                                </td>
                                <th scope="row">
                                    <?php if ($canEdit) : ?>
                                        <a href="<?php echo Route::_('index.php?option=com_danhmuc&view=nangluong&layout=edit&code=' . $item->code); ?>" title="<?php echo Text::_('JACTION_EDIT'); ?> <?php echo $this->escape($item->name); ?>">
                                            <?php echo $this->escape($item->name); ?></a>
                                    <?php else : ?>
                                        <?php echo $this->escape($item->name); ?>
                                    <?php endif; ?>
                                </th>
                                <td class="d-none d-md-table-cell">
                                    <?php
                                    echo $item->raise_salary == 0 ? 'Không' : 'Có';
                                    ?>
                                </td>
                                <td class="d-none d-md-table-cell">
                                    <?php
                                    echo $item->receive_money == 0 ? 'Không' : 'Có';
                                    ?>
                                </td>

                                <td class="d-none d-md-table-cell">
                                    <?php echo $this->escape($item->percent) . '%'; ?>
                                </td>

                                <td class="text d-md-table-cell">

                                    <?php echo HTMLHelper::_('jgrid.published', $item->status, $i, 'nangluong.', $canChange); ?>

                                </td>
                                <td class="text-center d-md-table-cell">
                                    <?php echo $this->escape($item->code); ?>
                                </td>

                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                </table>


                <?php // load the pagination. 
                ?>
                <?php echo $this->pagination->getListFooter(); ?>
                <input type="hidden" name="task" value="">
                <input type="hidden" name="boxchecked" value="0">
                <?php echo HTMLHelper::_('form.token'); ?>

            </div>
        </div>
    </div>
</form>

<style>
    .pagination {
        margin: 0 !important;
    }
</style>