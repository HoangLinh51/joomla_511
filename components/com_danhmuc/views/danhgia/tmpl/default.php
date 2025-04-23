<?php 
	$jinput = JFactory::getApplication()->input;
	$task = $jinput->getString('task','');
	// if($task=='ds_tieuchi'){
	// 	echo '123';die;
	// }
?>
<div class="row-fluid">
	<div class="tabbable">
		<ul class="nav nav-tabs">
			<li class="<?php echo ($task=='ds_nhomtieuchi'||$task=='default')?'active':''; ?>">
				<a data-toggle="tab" href="#nhomtieuchi" id="nhomtieuchi_button" data-task="ds_nhomtieuchi">
					Nhóm tiêu chí
				</a>
			</li>
			<li class="<?php echo ($task=='ds_tieuchi')?'active':''; ?>">
				<a data-toggle="tab" href="#nhomtieuchi" class="danhgia_button" data-task="ds_tieuchi">
					Tiêu chí
				</a>
			</li>
			<li class="<?php echo ($task=='ds_loaicongviec')?'active':''; ?>">
				<a data-toggle="tab" href="#tieuchi" class="danhgia_button" data-task="ds_loaicongviec">
					Loại công việc
				</a>
			</li>
			<li class="<?php echo ($task=='ds_errorsql')?'active':''; ?>">
				<a data-toggle="tab" href="#tieuchi" class="danhgia_button" data-task="ds_errorsql">
					Danh sách lỗi sql các chức năng
				</a>
			</li>
			<li class="<?php echo ($task=='ds_loaingaynghi')?'active':''; ?>">
				<a data-toggle="tab" href="#tieuchi" class="danhgia_button" data-task="ds_loaingaynghi">
					Loại ngày nghỉ
				</a>
			</li>
			<li class="<?php echo ($task=='ds_dieukienlamviec')?'active':''; ?>">
				<a data-toggle="tab" href="#tieuchi" class="danhgia_button" data-task="ds_dieukienlamviec">
					Điều kiện làm việc
				</a>
			</li>
			<li class="<?php echo ($task=='ds_lydocongviecfail')?'active':''; ?>">
				<a data-toggle="tab" href="#tieuchi" class="danhgia_button" data-task="ds_lydocongviecfail">
					Lý do chưa hoàn thành công việc
				</a>
			</li>
			<li class="<?php echo ($task=='ds_mucdothuongxuyen')?'active':''; ?>">
				<a data-toggle="tab" href="#tieuchi" class="danhgia_button" data-task="ds_mucdothuongxuyen">
					Mức độ thường xuyên
				</a>
			</li>
			<li class="<?php echo ($task=='ds_tinhchat')?'active':''; ?>">
				<a data-toggle="tab" href="#tieuchi" class="danhgia_button" data-task="ds_tinhchat">
					Tính chất
				</a>
			</li>
			<li class="<?php echo ($task=='ds_xeploaicongviec')?'active':''; ?>">
				<a data-toggle="tab" href="#tieuchi" class="danhgia_button" data-task="ds_xeploaicongviec">
					Xếp loại công việc
				</a>
			</li>
			<li class="<?php echo ($task=='ds_xeploaichatluong')?'active':''; ?>">
				<a data-toggle="tab" href="#tieuchi" class="danhgia_button" data-task="ds_xeploaichatluong">
					Xếp loại chất lượng
				</a>
			</li>
			<li class="<?php echo ($task=='ds_theonhiemvu')?'active':''; ?>">
				<a data-toggle="tab" href="#tieuchi" class="danhgia_button" data-task="ds_theonhiemvu">
					Nhiệm vụ
				</a>
			</li>
			<li class="<?php echo ($task=='ds_theotieuchuan')?'active':''; ?>">
				<a data-toggle="tab" href="#tieuchi" class="danhgia_button" data-task="ds_theotieuchuan">
					Tiêu chuẩn
				</a>
			</li>
			<li class="<?php echo ($task=='ds_botieuchi')?'active':''; ?>">
				<a data-toggle="tab" href="#tieuchi" class="danhgia_button" data-task="ds_botieuchi">
					Bộ tiêu chí
				</a>
			</li>
			<li class="<?php echo ($task=='ds_tieuchi_donvi')?'active':''; ?>">
				<a data-toggle="tab" href="#tieuchi" class="danhgia_button" data-task="ds_tieuchi_donvi">
					Cấu hình tiêu chí của đơn vị
				</a>
			</li>
			<li class="<?php echo ($task=='ds_dotdanhgia')?'active':''; ?>">
				<a data-toggle="tab" href="#tieuchi" class="danhgia_button" data-task="ds_dotdanhgia">
					Đợt đánh giá
				</a>
			</li>
			<li class="<?php echo ($task=='ds_mucdophuctap_xeploai')?'active':''; ?>">
				<a data-toggle="tab" href="#tieuchi" class="danhgia_button" data-task="ds_mucdophuctap_xeploai">
					Mức độ phức tạp
				</a>
			</li>
			<li class="<?php echo ($task=='ds_mucdothamgia')?'active':''; ?>">
				<a data-toggle="tab" href="#tieuchi" class="danhgia_button" data-task="ds_mucdothamgia">
					Mức độ tham gia
				</a>
			</li>
			<li class="<?php echo ($task=='ds_tiendo_xeploai')?'active':''; ?>">
				<a data-toggle="tab" href="#tieuchi" class="danhgia_button" data-task="ds_tiendo_xeploai">
					Tiến độ
				</a>
			</li>
			<li class="<?php echo ($task=='ds_xeploai')?'active':''; ?>">
				<a data-toggle="tab" href="#tieuchi" class="danhgia_button" data-task="ds_xeploai">
					Xếp loại
				</a>
			</li>
			<li class="<?php echo ($task=='ds_partitions')?'active':''; ?>">
				<a data-toggle="tab" href="#tieuchi" class="danhgia_button" data-task="ds_partitions">
					Thiết lập Partition
				</a>
			</li>
			<li class="<?php echo ($task=='ds_tieuchi_liet')?'active':''; ?>">
				<a data-toggle="tab" href="#tieuchi" class="danhgia_button" data-task="ds_tieuchi_liet">
					Tiêu chí liệt
				</a>
			</li>
		</ul>
		<div class="tab-content">
			<div id="nhomtieuchi" class="tab-pane in active"></div>
			<!-- <div id="tieuchi" class="tab-pane"></div> -->
		</div>
	</div>
</div>
<div id="content"></div>
<div id="modal-form" class="modal hide" tabindex="-1" style="width:900px;left:35%;">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="blue bigger" id="modal-title"></h4>
    </div>
    <div class="modal-body overflow-visible">
        <div id="modal-content" class="slim-scroll" data-height="350">

        </div>
    </div>
    <div class="modal-footer">

    </div>
</div>
<script>
	jQuery(document).ready(function($){
		$('#nhomtieuchi_button').on('click',function(){
			var task = $(this).data('task');
			window.location.href = 'index.php?option=com_danhmuc&view=danhgia&task='+task;
		});
		var loadContent = function(){
			// $.blockUI();
			var task = '<?php echo $task; ?>';
			// console.log(task);
			if(task=='default'){
				task = 'ds_nhomtieuchi';
			}
			$('#nhomtieuchi').load('index.php?option=com_danhmuc&view=danhgia&task='+task+'&format=raw',function(){
				// $.unblockUI();
			});
		}
		loadContent();
		// $('#nhomtieuchi_button').click();
		// $('#tieuchi_button').on('click',function(){
		// 	$('#tieuchi').load('index.php?option=com_danhmuc&view=danhgia&task=ds_tieuchi&format=raw');
		// });
		$('.danhgia_button').on('click',function(){
			var task = $(this).data('task');
			window.location.href = 'index.php?option=com_danhmuc&view=danhgia&task='+task;
		});
	});
</script>