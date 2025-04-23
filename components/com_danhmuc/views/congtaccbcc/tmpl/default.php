<div class="row-fluid">
	<div class="tabbable">
		<ul class="nav nav-tabs" id="myTab">
			<li class="active">
				<a data-toggle="tab" id="function_button" href="#function">
					Lĩnh vực
				</a>
			</li>
			<li>
				<a data-toggle="tab" id="thuhut_button" href="#thuhut">

					Thu hút
				</a>
			</li>
			<li>
				<a data-toggle="tab" href="#capbonhiembanhanh" id="capbonhiembanhanh_button">
					Cấp bổ nhiệm / ban hành
				</a>
			</li>
			<li>
				<a data-toggle="tab" id="khoicoquan_button" href="#khoicoquan">

					Khối cơ quan
				</a>
			</li>
			<li>
				<a data-toggle="tab" id="nhiemvuduocgiao_button" href="#nhiemvuduocgiao">

					Nhiệm vụ được giao
				</a>
			</li>
			<li>
				<a data-toggle="tab" id="binhbaudonvi_button" href="#binhbaudonvi">

					Bình bầu đơn vị
				</a>
			</li>
			<li>
				<a data-toggle="tab" id="vitrituyendung_button" href="#vitrituyendung">

					Vị trí tuyển dụng
				</a>
			</li>
			<li>
				<a data-toggle="tab" id="doituongquanly_button" href="#doituongquanly">

					Đối tượng quản lý
				</a>
			</li>
			<li>
				<a data-toggle="tab" id="trangthaihoso_button" href="#trangthaihoso">

					Trạng thái hồ sơ
				</a>
			</li>
			<li>
				<a data-toggle="tab" id="hinhthucnghihuu_button" href="#hinhthucnghihuu">

					Hình thức nghỉ hưu
				</a>
			</li>
			<li>
				<a data-toggle="tab" id="trangthaidonvi_button" href="#trangthaidonvi">

					Trạng thái đơn vị
				</a>
			</li>
			<li>
				<a data-toggle="tab" id="nguontuyendung_button" href="#nguontuyendung">

					Nguồn tuyển dụng
				</a>
			</li>
			<li>
				<a data-toggle="tab" id="congviecchuyenmon_button" href="#congviecchuyenmon">

					Công việc chuyên môn
				</a>
			</li>
			<li>
				<a data-toggle="tab" id="binhbauphanloaicbcc_button" href="#binhbauphanloaicbcc">

					Bình bầu phân loại CBCC
				</a>
			</li>
			<li>
				<a data-toggle="tab" id="phanloaidonvisunghiep_button" href="#phanloaidonvisunghiep">

					Phân loại đơn vị sự nghiệp
				</a>
			</li>
			<li>
				<a data-toggle="tab" id="cacloaiquyetdinh_button" href="#cacloaiquyetdinh">

					Các loại quyết định
				</a>
			</li>
			<li>
				<a data-toggle="tab" id="lydodinuocngoai_button" href="#lydodinuocngoai">

					Lý do đi nước ngoài
				</a>
			</li>
			<li>
				<a data-toggle="tab" id="hinhthucthoiviecnghihuu_button" href="#hinhthucthoiviecnghihuu">

					Hình thức thôi việc nghỉ hưu
				</a>
			</li>
			<li>
				<a data-toggle="tab" id="thuocdienquanly_button" href="#thuocdienquanly">

					Thuộc diện quản lý
				</a>
			</li>
		</ul>
		<div class="tab-content">
			<div id="function" class="tab-pane in active"></div>
			<div id="thuhut" class="tab-pane"></div>
			<div id="khoicoquan" class="tab-pane"></div>
			<div id="nhiemvuduocgiao" class="tab-pane"></div>
			<div id="binhbaudonvi" class="tab-pane"></div>
			<div id="vitrituyendung" class="tab-pane"></div>
			<div id="doituongquanly" class="tab-pane"></div>
			<div id="trangthaihoso" class="tab-pane"></div>
			<div id="hinhthucnghihuu" class="tab-pane"></div>
			<div id="trangthaidonvi" class="tab-pane"></div>
			<div id="nguontuyendung" class="tab-pane"></div>
			<div id="congviecchuyenmon" class="tab-pane"></div>
			<div id="binhbauphanloaicbcc" class="tab-pane"></div>
			<div id="phanloaidonvisunghiep" class="tab-pane"></div>
			<div id="cacloaiquyetdinh" class="tab-pane"></div>
			<div id="lydodinuocngoai" class="tab-pane"></div>
			<div id="hinhthucthoiviecnghihuu" class="tab-pane"></div>
			<div id="thuocdienquanly" class="tab-pane"></div>
			<div id="capbonhiembanhanh"></div>
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
	jQuery(document).ready(function($) {
		$('#capbonhiembanhanh_button').on('click',function(){
			$('#capbonhiembanhanh').load('index.php?option=com_danhmuc&view=congtac&task=ds_capbonhiembanhanh&format=raw');
		});
		$('#function_button').on('click', function() {
			$('#function').load('index.php?option=com_danhmuc&view=congtaccbcc&task=ds_linhvuc&format=raw');
		});
		$('#function_button').click();
		$('#thuhut_button').on('click', function() {
			$('#thuhut').load('index.php?option=com_danhmuc&view=congtaccbcc&task=ds_thuhut&format=raw');
		});
		$('#khoicoquan_button').on('click', function() {
			$('#khoicoquan').load('index.php?option=com_danhmuc&view=congtaccbcc&task=ds_khoicoquan&format=raw');
		});
		$('#nhiemvuduocgiao_button').on('click', function() {
			$('#nhiemvuduocgiao').load('index.php?option=com_danhmuc&view=congtaccbcc&task=ds_nhiemvuduocgiao&format=raw');
		});
		$('#binhbaudonvi_button').on('click', function() {
			$('#binhbaudonvi').load('index.php?option=com_danhmuc&view=congtaccbcc&task=ds_binhbaudonvi&format=raw');
		});
		$('#vitrituyendung_button').on('click', function() {
			$('#vitrituyendung').load('index.php?option=com_danhmuc&view=congtaccbcc&task=ds_vitrituyendung&format=raw');
		});
		$('#doituongquanly_button').on('click', function() {
			$('#doituongquanly').load('index.php?option=com_danhmuc&view=congtaccbcc&task=ds_doituongquanly&format=raw');
		});
		$('#trangthaihoso_button').on('click', function() {
			$('#trangthaihoso').load('index.php?option=com_danhmuc&view=congtaccbcc&task=ds_trangthaihoso&format=raw');
		});
		$('#hinhthucnghihuu_button').on('click', function() {
			$('#hinhthucnghihuu').load('index.php?option=com_danhmuc&view=congtaccbcc&task=ds_hinhthucnghihuu&format=raw');
		});
		$('#trangthaidonvi_button').on('click', function() {
			$('#trangthaidonvi').load('index.php?option=com_danhmuc&view=congtaccbcc&task=ds_trangthaidonvi&format=raw');
		});
		$('#nguontuyendung_button').on('click', function() {
			$('#nguontuyendung').load('index.php?option=com_danhmuc&view=congtaccbcc&task=ds_nguontuyendung&format=raw');
		});
		$('#congviecchuyenmon_button').on('click', function() {
			$('#congviecchuyenmon').load('index.php?option=com_danhmuc&view=congtaccbcc&task=ds_congviecchuyenmon&format=raw');
		});
		$('#binhbauphanloaicbcc_button').on('click', function() {
			$('#binhbauphanloaicbcc').load('index.php?option=com_danhmuc&view=congtaccbcc&task=ds_binhbauphanloaicbcc&format=raw');
		});
		$('#phanloaidonvisunghiep_button').on('click', function() {
			$('#phanloaidonvisunghiep').load('index.php?option=com_danhmuc&view=congtaccbcc&task=ds_phanloaidonvisunghiep&format=raw');
		});
		$('#cacloaiquyetdinh_button').on('click', function() {
			$('#cacloaiquyetdinh').load('index.php?option=com_danhmuc&view=congtaccbcc&task=ds_cacloaiquyetdinh&format=raw');
		});
		$('#lydodinuocngoai_button').on('click', function() {
			$('#lydodinuocngoai').load('index.php?option=com_danhmuc&view=congtaccbcc&task=ds_lydodinuocngoai&format=raw');
		});
		$('#hinhthucthoiviecnghihuu_button').on('click', function() {
			$('#hinhthucthoiviecnghihuu').load('index.php?option=com_danhmuc&view=congtaccbcc&task=ds_hinhthucthoiviecnghihuu&format=raw');
		});
		$('#thuocdienquanly_button').on('click', function() {
			$('#thuocdienquanly').load('index.php?option=com_danhmuc&view=congtaccbcc&task=ds_thuocdienquanly&format=raw');
		});
	});
</script>