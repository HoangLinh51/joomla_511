<?php
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Session\Session as SessionSession;
use Joomla\CMS\Uri\Uri;
use Joomla\Component\Core\Administrator\View\Configs\RawView;
use Joomla\Session\Session;

/** @var Joomla\CMS\WebAsset\WebAssetManager $wa */
$wa = $this->document->getWebAssetManager();
$wa->useScript('keepalive')
    ->useScript('form.validate')
    ->useScript('bootstrap.modal');
/** @var RawView $this */
$items = $this->rows;
$user      = Factory::getUser();
for ($ii=0; $ii < count($items); $ii++) { 
            $link  = $items[$ii];
$link = 'index.php?option=com_core&client_id=0&task=config.edit&tmpl=component&view=config&layout=modal_value&id='.$link['id'];
echo HTMLHelper::_(
    'bootstrap.renderModal',
    'moduleEditValueModal',
    [
        'title'       => Text::_('Thiết lập giá trị'),
        'backdrop'    => 'static',
        'keyboard'    => false,
        'closeButton' => false,
        'bodyHeight'  => '40',
        'modalWidth'  => '60',
        'footer'      => '<button type="button" class="btn btn-danger" data-bs-dismiss="modal"'
        . ' onclick="Joomla.iframeButtonClick({iframeSelector: \'#moduleEditValueModal\', buttonSelector: \'#closeBtn\'})">'
        . Text::_('Đóng') . '</button>'
        . '<button type="button" class="btn btn-success" data-bs-dismiss="modal" onclick="Joomla.iframeButtonClick({iframeSelector: \'#moduleEditValueModal\', buttonSelector: \'#saveBtn\'});">'
        . Text::_("JSAVE") . '</button>'
    ]
);
}
echo HTMLHelper::_(
    'bootstrap.renderModal',
    'moduleEditModal',
    [
        'title'       => Text::_('Hiệu chỉnh'),
        'backdrop'    => 'static',
        'keyboard'    => false,
        'closeButton' => false,
        'bodyHeight'  => '55',
        'modalWidth'  => '60',
        'footer'      => '<button type="button" class="btn btn-danger" data-bs-dismiss="modal"'
        . ' onclick="Joomla.iframeButtonClick({iframeSelector: \'#moduleEditModal\', buttonSelector: \'#closeBtn\'})">'
        . Text::_('Đóng') . '</button>'
        . '<button type="button" class="btn btn-success" data-bs-dismiss="modal" onclick="Joomla.iframeButtonClick({iframeSelector: \'#moduleEditModal\', buttonSelector: \'#saveBtn\'});">'
        . Text::_("JSAVE") . '</button>'
    ]
);

?>

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

                    <button class="btn btn-app bg-success btnValue"  data-config-id="<?php echo $item['id']?>" data-bs-toggle="modal" data-bs-target="#moduleEditValueModal" style="color: white;padding: 10px;padding-bottom: 5px;padding-top: 5px;padding-left: 11px;padding-right: 11px;">
                        <i class="fas fa-edit"></i>
                    </button>
                    
                </div>
                <div class="" style="display: block;float: right">
                    <a class="btn btn-app bg-danger btnXoa" data-config-id="<?php echo $item['id']?>" style="color: white;padding: 10px;padding-bottom: 5px;padding-top: 5px;padding-left: 13px;padding-right: 13px;">
                        <i class="fas fa-trash"></i>
                    </a>
                </div>
            </td> 
        </tr>
        <?php }?>
    </tbody>
</table>

<script>
jQuery(document).ready(function($) {
    var baseLink    = 'index.php?option=com_core&client_id=0&task=config.edit&tmpl=component&view=config&layout=modal&id=';
    
    var valueLink   = 'index.php?option=com_core&client_id=0&task=config.edit&tmpl=component&view=config&layout=modal_value&id=';
    
    $('.btnEdit').on('click', function (_ref) {
        var target = _ref.target;
        var link = baseLink + target.getAttribute('data-config-id');
        var modal = document.getElementById('moduleEditModal');
        var body = modal.querySelector('.modal-body');
        var iFrame = document.createElement('iframe');
        iFrame.src = link;
        iFrame.setAttribute('class', 'class="iframe jviewport-height70"');
        body.innerHTML = '';
        body.appendChild(iFrame);
    });

    $('.btnValue').on('click', function (_ref) {
        var target = _ref.target;
        var link = valueLink + $(this).data('config-id');
        var modal = document.getElementById('moduleEditValueModal');
        var body = modal.querySelector('.modal-body');
        var iFrame = document.createElement('iframe');
        iFrame.src = link;
        iFrame.setAttribute('class', 'class="iframe jviewport-height70"');
        body.innerHTML = '';
        body.appendChild(iFrame);
    });

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

    $('.btnXoa').on('click', function (_ref) { 
        var id = $(this).data('config-id');
        var mytoken= Joomla.getOptions("csrf.token", ""); 
		var userToken = document.getElementsByTagName('input')[0].name;
		
        if (confirm("Bạn có chắc chắn muốn xóa không? Việc xác nhận sẽ xóa vĩnh viễn (các) mục đã chọn!") == true) {
			// $.ajax({
            //     type: "POST",
            //     url: 'index.php?option=com_core&controller=config&task=delete&id='+id +'&' +mytoken+ '=1',
            //     success: function(data){    
            //         $('#system-message-container').html('<div id="system-message-container" aria-live="polite"><noscript><div class="alert alert-success">Xử lý thành công</div></noscript><joomla-alert type="success" close-text="Close" dismiss="true" role="alert" style="animation-name: joomla-alert-fade-in;"><button type="button" class="joomla-alert--close" aria-label="Close"><span aria-hidden="true">×</span></button><div class="alert-heading"><span class="success"></span><span class="visually-hidden">success</span></div><div class="alert-wrapper"><div class="alert-message">Xử lý thành công</div></div></joomla-alert></div>');
            //         return true;
            //     }
            // });
            window.location.href = 'index.php?option=com_core&controller=config&task=delete&id='+id +'&' +mytoken+ '=1';	
        } else {
            return false;		
        }
    });
    var _initPage = function(){
		
	};
    Array.from(document.querySelectorAll('.modal')).forEach(function (modalEl) {
        modalEl.addEventListener('hidden.bs.modal', function () {
          setTimeout(function () {
            window.parent.location.href = 'index.php?option=com_core&view=configs';
          }, 1000);
        });
    });
	
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
</style>