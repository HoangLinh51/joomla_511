<?php
defined('_JEXEC') or die('Restricted access');
$user = JFactory::getUser();
$user_id = $user->id;
$debug = Core::config('core/system/debug');
?>
<div id="info_container"></div>
<div id="tabs" class="tabbable" style="width: 100%;">
	<ul class="nav nav-tabs" id="myTab">
		<?php if (Core::_checkPerActionArr($user_id, 'com_danhmuc', 'thongtincbccvc', array('task' => 'goiluong_default', 'location' => 'site', 'non_action' => 'false')) || $debug == 1) { ?>
			<li>
				<a data-toggle="tab" href="#tab_default_goiluong" data-tab-url="<?php echo JUri::root(true); ?>/index.php?option=com_danhmuc&controller=thongtincbccvc&task=goiluong_default&format=raw">
					Gói lương
				</a>
			</li>
		<?php } ?>
		<?php if (Core::_checkPerActionArr($user_id, 'com_danhmuc', 'thongtincbccvc', array('task' => 'hinhthucthidua_default', 'location' => 'site', 'non_action' => 'false')) || $debug == 1) { ?>
			<li>
				<a data-toggle="tab" href="#tab_default_hinhthucthidua" data-tab-url="<?php echo JUri::root(true); ?>/index.php?option=com_danhmuc&controller=thongtincbccvc&task=hinhthucthidua_default&format=raw">
					Hình thức thi đua khen thưởng
				</a>
			</li>
		<?php } ?>
		<?php if (Core::_checkPerActionArr($user_id, 'com_danhmuc', 'thongtincbccvc', array('task' => 'ketquathidua_default', 'location' => 'site', 'non_action' => 'false')) || $debug == 1) { ?>
			<li>
				<a data-toggle="tab" href="#tab_default_ketquathidua" data-tab-url="<?php echo JUri::root(true); ?>/index.php?option=com_danhmuc&controller=thongtincbccvc&task=ketquathidua_default&format=raw">
					Kết quả thi đua, đánh giá
				</a>
			</li>
		<?php } ?>
		<?php if (Core::_checkPerActionArr($user_id, 'com_danhmuc', 'thongtincbccvc', array('task' => 'khenthuongkyluat_default', 'location' => 'site', 'non_action' => 'false')) || $debug == 1) { ?>
			<li>
				<a data-toggle="tab" href="#tab_default_khenthuongkyluat" data-tab-url="<?php echo JUri::root(true); ?>/index.php?option=com_danhmuc&controller=thongtincbccvc&task=khenthuongkyluat_default&format=raw">
					Thi đua, khen thưởng, kỷ luật
				</a>
			</li>
		<?php } ?>
		<?php if (Core::_checkPerActionArr($user_id, 'com_danhmuc', 'thongtincbccvc', array('task' => 'chucdanhcongtac_default', 'location' => 'site', 'non_action' => 'false')) || $debug == 1) { ?>
			<li>
				<a data-toggle="tab" href="#tab_default_chucdanhcongtac" data-tab-url="<?php echo JUri::root(true); ?>/index.php?option=com_danhmuc&controller=thongtincbccvc&task=chucdanhcongtac_default&format=raw">
					Chức danh công tác
				</a>
			</li>
		<?php } ?>
		<?php if (Core::_checkPerActionArr($user_id, 'com_danhmuc', 'thongtincbccvc', array('task' => 'hinhthucchucdanhcongtac_default', 'location' => 'site', 'non_action' => 'false')) || $debug == 1) { ?>
			<li>
				<a data-toggle="tab" href="#tab_default_hinhthucchucdanhcongtac" data-tab-url="<?php echo JUri::root(true); ?>/index.php?option=com_danhmuc&controller=thongtincbccvc&task=hinhthucchucdanhcongtac_default&format=raw">
					Hình thức bổ nhiệm Chức danh
				</a>
			</li>
		<?php } ?>
		<?php if (Core::_checkPerActionArr($user_id, 'com_danhmuc', 'thongtincbccvc', array('task' => 'detainckh_default', 'location' => 'site', 'non_action' => 'false')) || $debug == 1) { ?>
			<li>
				<a data-toggle="tab" href="#tab_default_detainckh" data-tab-url="<?php echo JUri::root(true); ?>/index.php?option=com_danhmuc&controller=thongtincbccvc&task=detainckh_default&format=raw">
					Cấp đề tài nghiên cứu khoa học
				</a>
			</li>
		<?php } ?>
		<?php if (Core::_checkPerActionArr($user_id, 'com_danhmuc', 'thongtincbccvc', array('task' => 'linhvucnckh_default', 'location' => 'site', 'non_action' => 'false')) || $debug == 1) { ?>
			<li>
				<a data-toggle="tab" href="#tab_default_linhvucnckh" data-tab-url="<?php echo JUri::root(true); ?>/index.php?option=com_danhmuc&controller=thongtincbccvc&task=linhvucnckh_default&format=raw">
					Lĩnh vực nghiên cứu khoa học
				</a>
			</li>
		<?php } ?>
		<?php if (Core::_checkPerActionArr($user_id, 'com_danhmuc', 'thongtincbccvc', array('task' => 'ds_ability', 'location' => 'site', 'non_action' => 'false')) || $debug == 1) { ?>
			<li>
				<a data-toggle="tab" href="#tab_default_ability" data-tab-url="<?php echo JUri::root(true); ?>/index.php?option=com_danhmuc&controller=thongtincbccvc&task=ds_ability&format=raw">
					Năng lực sở trường
				</a>
			</li>
		<?php } ?>
		<?php if (Core::_checkPerActionArr($user_id, 'com_danhmuc', 'thongtincbccvc', array('task' => 'ds_awa', 'location' => 'site', 'non_action' => 'false')) || $debug == 1) { ?>
			<li>
				<a data-toggle="tab" href="#tab_default_awa" data-tab-url="<?php echo JUri::root(true); ?>/index.php?option=com_danhmuc&controller=thongtincbccvc&task=ds_awa&format=raw">
					Danh hiệu phong tặng
				</a>
			</li>
		<?php } ?>
		<?php if (Core::_checkPerActionArr($user_id, 'com_danhmuc', 'thongtincbccvc', array('task' => 'ds_blood', 'location' => 'site', 'non_action' => 'false')) || $debug == 1) { ?>
			<li>
				<a data-toggle="tab" href="#tab_default_blood" data-tab-url="<?php echo JUri::root(true); ?>/index.php?option=com_danhmuc&controller=thongtincbccvc&task=ds_blood&format=raw">
					Nhóm máu
				</a>
			</li>
		<?php } ?>
		<?php if (Core::_checkPerActionArr($user_id, 'com_danhmuc', 'thongtincbccvc', array('task' => 'ds_cost', 'location' => 'site', 'non_action' => 'false')) || $debug == 1) { ?>
			<li>
				<a data-toggle="tab" href="#tab_default_cost" data-tab-url="<?php echo JUri::root(true); ?>/index.php?option=com_danhmuc&controller=thongtincbccvc&task=ds_cost&format=raw">
					Nguồn kinh phí
				</a>
			</li>
		<?php } ?>
		<?php if (Core::_checkPerActionArr($user_id, 'com_danhmuc', 'thongtincbccvc', array('task' => 'ds_cyu', 'location' => 'site', 'non_action' => 'false')) || $debug == 1) { ?>
			<li>
				<a data-toggle="tab" href="#tab_default_cyu" data-tab-url="<?php echo JUri::root(true); ?>/index.php?option=com_danhmuc&controller=thongtincbccvc&task=ds_cyu&format=raw">
					Chức vụ Đoàn
				</a>
			</li>
		<?php } ?>
		<?php if (Core::_checkPerActionArr($user_id, 'com_danhmuc', 'thongtincbccvc', array('task' => 'ds_defect', 'location' => 'site', 'non_action' => 'false')) || $debug == 1) { ?>
			<li>
				<a data-toggle="tab" href="#tab_default_defect" data-tab-url="<?php echo JUri::root(true); ?>/index.php?option=com_danhmuc&controller=thongtincbccvc&task=ds_defect&format=raw">
					Khuyết tật
				</a>
			</li>
		<?php } ?>
		<?php if (Core::_checkPerActionArr($user_id, 'com_danhmuc', 'thongtincbccvc', array('task' => 'ds_hea', 'location' => 'site', 'non_action' => 'false')) || $debug == 1) { ?>
			<li>
				<a data-toggle="tab" href="#tab_default_hea" data-tab-url="<?php echo JUri::root(true); ?>/index.php?option=com_danhmuc&controller=thongtincbccvc&task=ds_hea&format=raw">
					Sức khỏe
				</a>
			</li>
		<?php } ?>
		<?php if (Core::_checkPerActionArr($user_id, 'com_danhmuc', 'thongtincbccvc', array('task' => 'ds_maried', 'location' => 'site', 'non_action' => 'false')) || $debug == 1) { ?>
			<li>
				<a data-toggle="tab" href="#tab_default_maried" data-tab-url="<?php echo JUri::root(true); ?>/index.php?option=com_danhmuc&controller=thongtincbccvc&task=ds_maried&format=raw">
					Tình trạng hôn nhân
				</a>
			</li>
		<?php } ?>
		<?php if (Core::_checkPerActionArr($user_id, 'com_danhmuc', 'thongtincbccvc', array('task' => 'ds_mil', 'location' => 'site', 'non_action' => 'false')) || $debug == 1) { ?>
			<li>
				<a data-toggle="tab" href="#tab_default_mil" data-tab-url="<?php echo JUri::root(true); ?>/index.php?option=com_danhmuc&controller=thongtincbccvc&task=ds_mil&format=raw">
					Chức vụ lực lượng vũ trang
				</a>
			</li>
		<?php } ?>
		<?php if (Core::_checkPerActionArr($user_id, 'com_danhmuc', 'thongtincbccvc', array('task' => 'ds_nat', 'location' => 'site', 'non_action' => 'false')) || $debug == 1) { ?>
			<li>
				<a data-toggle="tab" href="#tab_default_nat" data-tab-url="<?php echo JUri::root(true); ?>/index.php?option=com_danhmuc&controller=thongtincbccvc&task=ds_nat&format=raw">
					Dân tộc
				</a>
			</li>
		<?php } ?>
		<?php if (Core::_checkPerActionArr($user_id, 'com_danhmuc', 'thongtincbccvc', array('task' => 'ds_ous', 'location' => 'site', 'non_action' => 'false')) || $debug == 1) { ?>
			<li>
				<a data-toggle="tab" href="#tab_default_ous" data-tab-url="<?php echo JUri::root(true); ?>/index.php?option=com_danhmuc&controller=thongtincbccvc&task=ds_ous&format=raw">
					Đối tượng chính sách
				</a>
			</li>
		<?php } ?>
		<?php if (Core::_checkPerActionArr($user_id, 'com_danhmuc', 'thongtincbccvc', array('task' => 'ds_party_pos', 'location' => 'site', 'non_action' => 'false')) || $debug == 1) { ?>
			<li>
				<a data-toggle="tab" href="#tab_default_party_pos" data-tab-url="<?php echo JUri::root(true); ?>/index.php?option=com_danhmuc&controller=thongtincbccvc&task=ds_party_pos&format=raw">
					Chức vụ Đảng
				</a>
			</li>
		<?php } ?>
		<?php if (Core::_checkPerActionArr($user_id, 'com_danhmuc', 'thongtincbccvc', array('task' => 'ds_ran', 'location' => 'site', 'non_action' => 'false')) || $debug == 1) { ?>
			<li>
				<a data-toggle="tab" href="#tab_default_ran" data-tab-url="<?php echo JUri::root(true); ?>/index.php?option=com_danhmuc&controller=thongtincbccvc&task=ds_ran&format=raw">
					Thành phần xuất thân
				</a>
			</li>
		<?php } ?>
		<?php if (Core::_checkPerActionArr($user_id, 'com_danhmuc', 'thongtincbccvc', array('task' => 'ds_rank', 'location' => 'site', 'non_action' => 'false')) || $debug == 1) { ?>
			<li>
				<a data-toggle="tab" href="#tab_default_rank" data-tab-url="<?php echo JUri::root(true); ?>/index.php?option=com_danhmuc&controller=thongtincbccvc&task=ds_rank&format=raw">
					Cấp bậc lực lượng vũ trang
				</a>
			</li>
		<?php } ?>
		<?php if (Core::_checkPerActionArr($user_id, 'com_danhmuc', 'thongtincbccvc', array('task' => 'ds_rel', 'location' => 'site', 'non_action' => 'false')) || $debug == 1) { ?>
			<li>
				<a data-toggle="tab" href="#tab_default_rel" data-tab-url="<?php echo JUri::root(true); ?>/index.php?option=com_danhmuc&controller=thongtincbccvc&task=ds_rel&format=raw">
					Tôn giáo
				</a>
			</li>
		<?php } ?>
		<?php if (Core::_checkPerActionArr($user_id, 'com_danhmuc', 'thongtincbccvc', array('task' => 'ds_relative', 'location' => 'site', 'non_action' => 'false')) || $debug == 1) { ?>
			<li>
				<a data-toggle="tab" href="#tab_default_relative" data-tab-url="<?php echo JUri::root(true); ?>/index.php?option=com_danhmuc&controller=thongtincbccvc&task=ds_relative&format=raw">
					Quan hệ gia đình
				</a>
			</li>
		<?php } ?>
		<?php if (Core::_checkPerActionArr($user_id, 'com_danhmuc', 'thongtincbccvc', array('task' => 'ds_sex', 'location' => 'site', 'non_action' => 'false')) || $debug == 1) { ?>
			<li>
				<a data-toggle="tab" href="#tab_default_sex" data-tab-url="<?php echo JUri::root(true); ?>/index.php?option=com_danhmuc&controller=thongtincbccvc&task=ds_sex&format=raw">
					Giới tính
				</a>
			</li>
		<?php } ?>
		<?php if (Core::_checkPerActionArr($user_id, 'com_danhmuc', 'thongtincbccvc', array('task' => 'ds_country', 'location' => 'site', 'non_action' => 'false')) || $debug == 1) { ?>
			<li>
				<a data-toggle="tab" href="#tab_default_country" data-tab-url="<?php echo JUri::root(true); ?>/index.php?option=com_danhmuc&controller=thongtincbccvc&task=ds_country&format=raw">
					Quốc gia
				</a>
			</li>
		<?php } ?>
		<?php if (Core::_checkPerActionArr($user_id, 'com_danhmuc', 'thanhpho', array('task' => 'ds_thanhpho', 'location' => 'site', 'non_action' => 'false')) || $debug == 1) { ?>
			<li>
				<a data-toggle="tab" href="#tab_default_thanhpho" data-tab-url="<?php echo JUri::root(true); ?>/index.php?option=com_danhmuc&controller=thanhpho&task=ds_thanhpho&format=raw">
					Tỉnh thành
				</a>
			</li>
		<?php } ?>
		<?php if (Core::_checkPerActionArr($user_id, 'com_danhmuc', 'quanhuyen', array('task' => 'ds_quanhuyen', 'location' => 'site', 'non_action' => 'false')) || $debug == 1) { ?>
			<li>
				<a data-toggle="tab" href="#tab_default_quanhuyen" data-tab-url="<?php echo JUri::root(true); ?>/index.php?option=com_danhmuc&controller=quanhuyen&task=ds_quanhuyen&format=raw">
					Quận huyện
				</a>
			</li>
		<?php } ?>
		<?php if (Core::_checkPerActionArr($user_id, 'com_danhmuc', 'phuongxa', array('task' => 'ds_phuongxa', 'location' => 'site', 'non_action' => 'false')) || $debug == 1) { ?>
			<li>
				<a data-toggle="tab" href="#tab_default_phuongxa" data-tab-url="<?php echo JUri::root(true); ?>/index.php?option=com_danhmuc&controller=phuongxa&task=ds_phuongxa&format=raw">
					Phường xã
				</a>
			</li>
		<?php } ?>
	</ul>
	<div class="tab-content">
		<div class="tab-pane" id="tab_default_thanhpho"></div>
		<div class="tab-pane" id="tab_default_quanhuyen"></div>
		<div class="tab-pane" id="tab_default_phuongxa"></div>
		<div class="tab-pane" id="tab_default_ability"></div>
		<div class="tab-pane" id="tab_default_detainckh"></div>
		<div class="tab-pane" id="tab_default_linhvucnckh"></div>
		<div class="tab-pane" id="tab_default_awa"></div>
		<div class="tab-pane" id="tab_default_blood"></div>
		<div class="tab-pane" id="tab_default_cost"></div>
		<div class="tab-pane" id="tab_default_country"></div>
		<div class="tab-pane" id="tab_default_cyu"></div>
		<div class="tab-pane" id="tab_default_defect"></div>
		<div class="tab-pane" id="tab_default_hea"></div>
		<div class="tab-pane" id="tab_default_maried"></div>
		<div class="tab-pane" id="tab_default_mil"></div>
		<div class="tab-pane" id="tab_default_nat"></div>
		<div class="tab-pane" id="tab_default_ous"></div>
		<div class="tab-pane" id="tab_default_party_pos"></div>
		<div class="tab-pane" id="tab_default_ran"></div>
		<div class="tab-pane" id="tab_default_rank"></div>
		<div class="tab-pane" id="tab_default_rel"></div>
		<div class="tab-pane" id="tab_default_relative"></div>
		<div class="tab-pane" id="tab_default_sex"></div>
		<div class="tab-pane" id="tab_default_chucdanhcongtac"></div>
		<div class="tab-pane" id="tab_default_hinhthucchucdanhcongtac"></div>
		<div class="tab-pane" id="tab_default_khenthuongkyluat"></div>
		<div class="tab-pane" id="tab_default_ketquathidua"></div>
		<div class="tab-pane" id="tab_default_hinhthucthidua"></div>
		<div class="tab-pane" id="tab_default_goiluong"></div>
	</div>
</div>
<div id="content"></div>
<div id="modal-form" class="modal hide" tabindex="-1" style="width:900px;left:35%;">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<h4 class="blue bigger" id="modal-title"></h4>
	</div>
	<div class="modal-body overflow-visible">
		<div id="modal-content" class="slim-scroll">

		</div>
	</div>
	<div class="modal-footer">

	</div>
</div>
<!-- <div class="phuc_modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="width: 900px; left: 35%; display: block;">
	<div id="div_modal" class="modal-dialog modal-lg">
	</div>
</div> -->
<script>
	jQuery(document).ready(function($) {
		if (!$('a[data-toggle="tab"]').parent().hasClass('active')) {
			$('#myTab a:first').tab('show');
		}
	});
</script>