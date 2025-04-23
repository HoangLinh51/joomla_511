<?php
defined('_JEXEC') or die('Restricted access');
$user = JFactory::getUser();
$user_id = $user->id;
$debug = Core::config('core/system/debug');
$view = 'bienche';
$i=0;
$array = array(
    $i++ => array('tbl'=>'bc_loaihinh', 'href' => 'tab_' . $view . '_'.'loaihinhbienche', 'url' => 'index.php?option=com_danhmuc&controller=loaihinhbienche&task=default&format=raw', 'ten' => 'Loại hình biên chế'),
    $i++ => array('tbl'=>'bc_hinhthuc', 'href' => 'tab_' . $view . '_'.'bienchehinhthuc', 'url' => 'index.php?option=com_danhmuc&controller=bienchehinhthuc&task=default&format=raw', 'ten' => 'Hình thức biên chế, HĐ'),
    $i++ => array('tbl'=>'bc_hinhthuctuyendung', 'href' => 'tab_' . $view . '_'.'hinhthuctuyendung', 'url' => 'index.php?option=com_danhmuc&controller=hinhthuctuyendung&task=default&format=raw', 'ten' => 'Hình thức tuyển dụng'),
    $i++ => array('tbl'=>'bc_thoihanbienchehopdong', 'href' => 'tab_' . $view . '_'.'thoihanbienchehopdong', 'url' => 'index.php?option=com_danhmuc&controller=thoihanbienchehopdong&task=default&format=raw', 'ten' => 'Thời hạn biên chế hợp đồng'),
    $i++ => array('tbl'=>'bc_loaidoituong', 'href' => 'tab_' . $view . '_'.'loaidoituong', 'url' => 'index.php?option=com_danhmuc&controller=loaidoituong&task=default&format=raw', 'ten' => 'Loại đối tượng'),
);
?>
<div id="tabs" class="tabbable" style="width: 100%;">
    <ul class="nav nav-tabs" id="myTab">
        <?php for ($i = 0; $i < count($array); $i++) { ?>
            <li>
                <a data-toggle="tab" href="#<?php echo $array[$i]['href']?>" data-tab-url="<?php echo $array[$i]['url']?>">
                    <?php echo $array[$i]['ten']?> <?php echo $debug==1?$array[$i]['tbl']:'';?>
                </a>
            </li>
        <?php } ?>
    </ul>
    <div class="tab-content">
        <?php for ($i = 0; $i < count($array); $i++) { ?>
            <div class="tab-pane" id="<?php echo $array[$i]['href']?>"></div>
        <?php } ?>
    </div>
</div>
</div>
<div id="div_modal" class="modal fade" style="display: none;">
</div>
<script>
    jQuery(document).ready(function($) {
        if (!$('a[data-toggle="tab"]').parent().hasClass('active')) {
            $('#myTab a:first').tab('show');
        }

    });
</script>