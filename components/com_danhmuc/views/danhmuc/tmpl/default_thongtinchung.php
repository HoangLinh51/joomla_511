<?php
defined('_JEXEC') or die('Restricted access');
$user = JFactory::getUser();
$user_id = $user->id;
$debug = Core::config('core/system/debug');
$view = 'thongtinchung';
$i=0;
$array = array(
    $i++ => array('tbl'=>'sex_code', 'href' => 'tab_' . $view . '_'.'gioitinh', 'url' => 'index.php?option=com_danhmuc&controller=gioitinh&task=default&format=raw', 'ten' => 'Giới tính'),
    $i++ => array('tbl'=>'danhmuc_noicap', 'href' => 'tab_' . $view . '_'.'noicap', 'url' => 'index.php?option=com_danhmuc&controller=noicap&task=default&format=raw', 'ten' => 'Nơi cấp'),
    $i++ => array('tbl'=>'nat_code', 'href' => 'tab_' . $view . '_'.'dantoc', 'url' => 'index.php?option=com_danhmuc&controller=dantoc&task=default&format=raw', 'ten' => 'Dân tộc'),
    $i++ => array('tbl'=>'rel_code', 'href' => 'tab_' . $view . '_'.'tongiao', 'url' => 'index.php?option=com_danhmuc&controller=tongiao&task=default&format=raw', 'ten' => 'Tôn giáo'),
    $i++ => array('tbl'=>'city_code', 'href' => 'tab_' . $view . '_'.'tinhthanh', 'url' => 'index.php?option=com_danhmuc&controller=tinhthanh&task=default&format=raw', 'ten' => 'Tỉnh thành'),
    $i++ => array('tbl'=>'dist_code', 'href' => 'tab_' . $view . '_'.'quanhuyen', 'url' => 'index.php?option=com_danhmuc&controller=quanhuyen&task=default&format=raw', 'ten' => 'Quận huyện'),
    $i++ => array('tbl'=>'comm_code', 'href' => 'tab_' . $view . '_'.'phuongxa', 'url' => 'index.php?option=com_danhmuc&controller=phuongxa&task=default&format=raw', 'ten' => 'Phường xã'),
    $i++ => array('tbl'=>'married_code', 'href' => 'tab_' . $view . '_'.'tinhtranghonnhan', 'url' => 'index.php?option=com_danhmuc&controller=tinhtranghonnhan&task=default&format=raw', 'ten' => 'Tình trạng hôn nhân'),
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