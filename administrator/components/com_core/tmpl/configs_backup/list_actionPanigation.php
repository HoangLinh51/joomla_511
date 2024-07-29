<?php
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Router\Route;
use Joomla\Component\Core\Administrator\View\Configs\RawView;
/** @var RawView $this */
/** @var Joomla\CMS\WebAsset\WebAssetManager $wa */
$wa = $this->document->getWebAssetManager();
$wa->useScript('keepalive')
    ->useScript('table.columns')
    ->useScript('multiselect');
// $items = $this->rows;
$items = $this->items;
?>
<form action="<?php echo Route::_('index.php?option=com_core&controller=configs'); ?>" method="post" name="adminForm" id="adminForm">
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
        $stt=1;
        $start= $this->state->get('list.start');
        // var_dump($this->state->get('list.start'));
        for ($i=0; $i < count($items); $i++) { 
            $item  = $items[$i];
            
        ?>
        <tr>
            <td style="vertical-align: middle;"><?php echo $i+$start?></td>
            <td style="vertical-align: middle;"><?php echo $item->title?></td>
            <td style="vertical-align: middle;word-break: break-word;"><?php echo $item->path?></td>
            <td style="vertical-align: middle;text-align: center;"><span class="badge bg-danger"><?php echo $item->type?></span></td>
            <td style="vertical-align: middle;"><span style="word-break: break-word;width: 170px; display: block;"><?php  echo $item->value != "" ?  str_replace(",", "</br>",$item->value) : ""?></span></td>
            <td style="vertical-align: middle;"><span class="badge bg-success"><?php echo $item->id?></span></td>
            <td style="padding: 8px;vertical-align: middle;">
                <div class="" style="display: block;float: left;">
                    <a class="btn btn-app bg-success" style="color: white;padding: 10px;padding-bottom: 5px;padding-top: 5px;padding-left: 11px;padding-right: 11px;">
                        <i class="fas fa-edit"></i>
                    </a>
                </div>
                <div class="" style="display: block;float: right">
                    <a class="btn btn-app bg-danger" style="color: white;padding: 10px;padding-bottom: 5px;padding-top: 5px;padding-left: 13px;padding-right: 13px;">
                        <i class="fas fa-trash"></i>
                    </a>
                </div>
            </td> 
        </tr>
        <?php }?>
        
        <!-- <input type="hidden" name="task" value="list" />
        <input type="hidden" name="boxchecked" value="0" /> -->
        <?php echo HTMLHelper::_('form.token'); ?>
    </tbody>
</table>
<?php echo $this->pagination->getListFooter(); ?>
</form>
<script>
// jQuery(document).ready(function($) {
// 	$('#tblConfig').DataTable({
//         pagingType: 'full_numbers',
// 		// lengthMenu: [ [20, 50, 100, -1], [20, 50, 100, "Tất cả"] ],
//         bLengthChange : false, 
//         ordering: false,
// 		searching: false,
// 		dom: 'rt<"modal-footer"flip><"clear">',
// 		language: {
//             url: '//cdn.datatables.net/plug-ins/1.13.1/i18n/vi.json'
//         }
		
		
//     },);
	
// });

</script>
<style>
/* .modal-footer{display: block !important;}
.dataTables_info{width: 40%; float: left;}
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
}  */
.pagination{margin: 0px !important;}
</style>