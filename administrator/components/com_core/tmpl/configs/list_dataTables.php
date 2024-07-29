<?php
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Router\Route;
use Joomla\Component\Core\Administrator\View\Configs\RawView;
/** @var RawView $this */
$items = $this->items;

?>
<!-- <form action="<?php //echo Route::_('index.php?option=com_core&view=configs'); ?>" method="post" name="adminForm" id="adminForm"> -->
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
            // var_dump($item->id);exit;
        ?>
        <tr>
            <td style="vertical-align: middle;"><?php echo ($i+1)?></td>
            <td style="vertical-align: middle;"><?php echo $item->title?></td>
            <td style="vertical-align: middle;word-break: break-word;"><?php echo $item->path?></td>
            <td style="vertical-align: middle;text-align: center;"><span class="badge bg-danger"><?php echo $item->type ?></span></td>
            <td style="vertical-align: middle;"><span style="word-break: break-word;width: 170px; display: block;"><?php echo $item->value != "" ?  str_replace(",", "</br>", $item->value) : ""?></span></td>
            <td style="vertical-align: middle;"><span class="badge bg-success"><?php echo  $item->id?></span></td>
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
       
    </tbody>
</table>
<?php // Load the pagination. ?>
<?php // echo $this->pagination->getListFooter(); ?>
</form>
<link href="https://cdn.datatables.net/v/dt/dt-1.13.4/datatables.min.css" rel="stylesheet"/>
<script src="https://cdn.datatables.net/v/dt/dt-1.13.4/datatables.min.js"></script>
<script>
jQuery(document).ready(function($) {
	$('#tblConfig').DataTable({
        pagingType: 'full_numbers',
		lengthMenu: [ [20, 50, 100, -1], [20, 50, 100, "Tất cả"] ],
		ordering: false,
		searching: false,
		dom: 'rt<"modal-footer"flip><"clear">',
		language: {
            url: '//cdn.datatables.net/plug-ins/1.13.1/i18n/vi.json'
        }
		
		
    },);
	
});

</script>