<?php
defined('_JEXEC') or die('Restricted access');
$user = JFactory::getUser();
$user_id = $user->id;
$debug = Core::config('core/system/debug');
?>
<div id="div_rs"></div>
<div id="info_container"></div>
<div id="tabs" class="tabbable" style="width: 100%;">
    <ul class="nav nav-tabs" id="myTab">
        <li>
            <a data-toggle="tab" href="#tab_vtvl_nhomvtvl" data-tab-url="index.php?option=com_danhmuc&controller=nhomvtvl&task=default&format=raw">
                Nhóm Vị trí việc làm
            </a>
        </li>
        <li>
            <a data-toggle="tab" href="#tab_vtvl_dieukienlamviec" data-tab-url="index.php?option=com_danhmuc&controller=dieukienlamviec&task=default&format=raw">
                Điều kiện làm việc
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" id="tab_vtvl_nhomvtvl"></div>
        <div class="tab-pane" id="tab_vtvl_dieukienlamviec"></div>
    </div>
</div>
</div>
<!-- <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="width: 900px; left: 35%; display: block;">
	<div id="div_modal" class="modal-dialog modal-lg">
	</div>
</div> -->
<script>
    jQuery(document).ready(function($) {
        if (!$('a[data-toggle="tab"]').parent().hasClass('active')) {
            // $('#tab_thongke').click();
            $('#myTab a:first').tab('show');
        }

    });
</script>