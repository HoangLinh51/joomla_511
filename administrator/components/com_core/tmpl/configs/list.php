<?php
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Session\Session;
use Joomla\CMS\Uri\Uri;
use Joomla\Component\Core\Administrator\View\Configs\RawView;

/** @var Joomla\CMS\WebAsset\WebAssetManager $wa */
$wa = $this->document->getWebAssetManager();
$wa->useScript('keepalive')
    ->useScript('form.validate')
    ->useScript('bootstrap.modal');
/** @var RawView $this */
$items = $this->rows;
$user      = Factory::getUser();
// $token = Session::getFormToken();
?>
<form action="<?php echo Route::_('index.php?option=com_core&view=configs'); ?>" method="post" name="adminForm" id="adminForm">
<table id="tblConfig" class="table table-bordered">
    <thead>
        <tr>
            <th style="width: 10px">#</th>
            <th>Tên</th>
            <th>Đường dẫn</th>
            <th style="width: 40px">Kiểu</th>
            <th style="width: 40px">Giá trị</th>
            <th style="width: 40px">ID</th>
            <th style="width: 40px">Chức năng</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        for ($i=0; $i < count($items); $i++) { 
            $item  = $items[$i];
        ?>
        <tr>
            <td style="vertical-align: middle;"><?php echo ($i+1)?></td>
            <td style="vertical-align: middle;"><?php echo $item['title']?></td>
            <td style="vertical-align: middle;word-break: break-word;">
                <?php if ($user->authorise('core.edit', 'com_modules.module.' . (int) $item['id'])) { ?>
                <a class="btnEdit" data-config-id="<?php echo $item['id']?>" data-bs-toggle="modal" data-bs-target="#moduleEditModal" href="index.php?option=com_core&view=configs&layout=list&format=raw"><?php echo $item['path']?></a>
                <?php }?>
            </td>
            <td style="vertical-align: middle;text-align: center;"><span class="badge bg-danger"><?php echo $item['type']?></span></td>
            <td style="vertical-align: middle;"><span style="word-break: break-word;width: 170px; display: block;"><?php  echo $item['value'] != "" ?  str_replace(",", "</br>",$item['value']) : ""?></span></td>
            <td style="vertical-align: middle;"><span class="badge bg-success"><?php echo $item['id']?></span></td>
            <td style="padding: 8px;vertical-align: middle;">
                <div class="" style="display: block;float: left;">

                    <button class="btn btn-app bg-success" type="button"  data-config-id="<?php echo $item['id']?>"  style="color: white;padding: 10px;padding-bottom: 5px;padding-top: 5px;padding-left: 11px;padding-right: 11px;">
                        <a style="color: antiquewhite;" href="<?php echo Route::_('index.php?option=com_core&view=config&layout=edit_value&id=' . (int) $item['id']); ?>">
                        <i class="fas fa-edit"></i>
                        </a>
                    </button>
                    
                </div>
                <div class="" style="display: block;float: right">
                    <!-- <a class="btn btn-app bg-danger btnXoa" href="<?php echo Route::_('index.php?option=com_core&task=config.deletevalue&'.$token.'=1&id=' . (int) $item['id']); ?>" data-config-id="<?php echo $item['id']?>" style="color: white;padding: 10px;padding-bottom: 5px;padding-top: 5px;padding-left: 13px;padding-right: 13px;"> -->
                    <a class="btn btn-app bg-danger btnXoa" data-config-id="<?php echo $item['id']?>" href="#" style="color: white;padding: 10px;padding-bottom: 5px;padding-top: 5px;padding-left: 13px;padding-right: 13px;">
                        <i class="fas fa-trash"></i>
                    </a>
                </div>
            </td> 
        </tr>
        <?php }?>
    </tbody>
</table>
<input type="hidden" name="task" value="">
<?php echo HTMLHelper::_('form.token'); ?>
<?php HTMLHelper::_('jquery.framework'); ?>
</form>
<script>
jQuery(document).ready(function($) {

   

	$('#tblConfig').DataTable({
        pagingType: 'full_numbers',
		//lengthMenu: [ [20, 50, 100, -1], [20, 50, 100, "Tất cả"] ],
        bLengthChange : false, 
        ordering: false,
		searching: false,
		dom: 'rt<"modal-footer"flip><"clear">',
		language: {
            // url: '//cdn.datatables.net/plug-ins/1.13.1/i18n/vi.json'
        }
    },); 

	
});

</script>
<style>
#tblConfig_wrapper .modal-footer{display: block !important;} 
.dataTables_info{float: left;}
.paging_full_numbers{float: right;}    
.paging_full_numbers a{padding-right: 10px;padding-left: 10px;} 
.paginate_button.current{padding: 0;border: none !important;} 
a.paginate_button.current{
    position: relative;
    padding: var(--bs-pagination-padding-y) var(--bs-pagination-padding-x);
    font-size: var(--bs-pagination-font-size);
    color: var(--bs-pagination-color);
    text-decoration: none;
    background-color: #0d6efd;
    padding: 10px;
} 

.modal-header {
    border-bottom: 1px solid var(--border-color);
    justify-content: space-between;
    align-items: center;
    padding: 1rem;
    display: flex;
    position: relative;
}
.joomla-dialog-body{
    padding: 1rem;
    font-size: 16px;
}
.bootbox-close-button{display: none;}
.btn-outline-secondary:hover {
    color: var(--btn-hover-color);
    background-color: var(--btn-hover-bg);
    border-color: var(--btn-hover-border-color);
}
</style>