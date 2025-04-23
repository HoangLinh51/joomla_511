<?php
defined('_JEXEC') or die('Restricted access');
$user = JFactory::getUser();
$user_id = $user->id;
// $debug = Core::config('core/system/debug');
$view = 'baucu';
$i=0;
$array = array(
    $i++ => array('tbl'=>'baucu_dotbaucu', 'href' => 'tab_' . $view . '_'.'dotbaucu', 'url' => 'index.php?option=com_danhmuc&controller=baucudotbaucu&task=default&format=raw', 'ten' => 'Đợt bầu cử'),
    $i++ => array('tbl'=>'baucu_capbaucu', 'href' => 'tab_' . $view . '_'.'capbaucu', 'url' => 'index.php?option=com_danhmuc&controller=baucucapbaucu&task=default&format=raw', 'ten' => 'Cấp bầu cử'),
    $i++ => array('tbl'=>'baucu_loaiphieubau', 'href' => 'tab_' . $view . '_'.'loaiphieubau', 'url' => 'index.php?option=com_danhmuc&controller=bauculoaiphieubau&task=default&format=raw', 'ten' => 'Loại phiếu bầu'),
    $i++ => array('tbl'=>'baucu_mocthoigian', 'href' => 'tab_' . $view . '_'.'mocthoigian', 'url' => 'index.php?option=com_danhmuc&controller=baucumocthoigian&task=default&format=raw', 'ten' => 'Mốc thời gian'),
    $i++ => array('tbl'=>'baucu_tobaucu', 'href' => 'tab_' . $view . '_'.'tobaucu', 'url' => 'index.php?option=com_danhmuc&controller=baucutobaucu&task=default&format=raw', 'ten' => 'Tổ bầu cử'),
    $i++ => array('tbl'=>'baucu_donvibaucu', 'href' => 'tab_' . $view . '_'.'donvibaucu', 'url' => 'index.php?option=com_danhmuc&controller=baucudonvibaucu&task=default&format=raw', 'ten' => 'Đơn vị bầu cử'),
    $i++ => array('tbl'=>'baucu_nguoiungcu', 'href' => 'tab_' . $view . '_'.'nguoiungcu', 'url' => 'index.php?option=com_danhmuc&controller=baucunguoiungcu&task=default&format=raw', 'ten' => 'Người ứng cử'),
    // $i++ => array('tbl'=>'baucu_cauhinh_capbaucunhanemail', 'href' => 'tab_' . $view . '_'.'cauhinhemail', 'url' => 'index.php?option=com_danhmuc&controller=baucucauhinhemail&task=default&format=raw', 'ten' => 'Cấu hình email'),
    // $i++ => array('tbl'=>'baucu_null', 'href' => 'tab_' . $view . '_'.'xuatbienban', 'url' => 'index.php?option=com_danhmuc&controller=baucuxuatbienban&task=default&format=raw', 'ten' => 'Xuất biên bản'),
    // $i++ => array('tbl'=>'baucu_null', 'href' => 'tab_' . $view . '_'.'xuatbienbanbm21', 'url' => 'index.php?option=com_danhmuc&controller=baucuxuatbienban&task=default_bm21&format=raw', 'ten' => 'Biểu mẫu số 21-HĐBC-QH'),
    // $i++ => array('tbl'=>'baucu_null', 'href' => 'tab_' . $view . '_'.'xuatbienbanbm22', 'url' => 'index.php?option=com_danhmuc&controller=baucuxuatbienban&task=default_bm22&format=raw', 'ten' => 'Biểu mẫu số 22-HĐBC-QH'),
    // $i++ => array('tbl'=>'baucu_null', 'href' => 'tab_' . $view . '_'.'xuatbienbanbm26', 'url' => 'index.php?option=com_danhmuc&controller=baucuxuatbienban&task=default_bm26&format=raw', 'ten' => 'Biểu mẫu số 26-HĐBC-HĐND'),
    // $i++ => array('tbl'=>'baucu_null', 'href' => 'tab_' . $view . '_'.'xuatbienbanbm27', 'url' => 'index.php?option=com_danhmuc&controller=baucuxuatbienban&task=default_bm27&format=raw', 'ten' => 'Biểu mẫu số 27-HĐBC-HĐND'),
    // $i++ => array('tbl'=>'baucu_null', 'href' => 'tab_' . $view . '_'.'xuatbienbanbm30', 'url' => 'index.php?option=com_danhmuc&controller=baucuxuatbienban&task=default_bm30&format=raw', 'ten' => 'Biểu mẫu số 30-HĐBC'),
    // $i++ => array('tbl'=>'baucu_null', 'href' => 'tab_' . $view . '_'.'xuatbienbanbm32', 'url' => 'index.php?option=com_danhmuc&controller=baucuxuatbienban&task=default_bm32&format=raw', 'ten' => 'Biểu mẫu số 32-HĐBC'),
    // $i++ => array('tbl'=>'baucu_diadiemhanhchinh', 'href' => 'tab_' . $view . '_'.'diadiemhanhchinh', 'url' => 'index.php?option=com_danhmuc&controller=baucudiadiemhanhchinh&task=default&format=raw', 'ten' => 'Địa điểm hành chính'),
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