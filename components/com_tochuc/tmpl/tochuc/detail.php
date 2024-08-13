<?php

use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;

defined('_JEXEC') or die('Restricted access');
$user = Factory::getUser();
$user_id = $user->id;
?>

<div class="card-header">
	<h3 class="card-title" style="vertical-align: middle;padding-top: 10px;">Thông tin tổ chức</h3>
	<div class="card-tools">
    
        <?php if ($this->row->type == 1 || $this->row->type == 0 || $this->row->type == 3) { ?>
            <?php if (Core::_checkPerActionArr($user_id, 'com_tochuc', 'tochuc', array('task' => 'au_nghiepvu_tochuc', 'location' => 'site', 'non_action' => 'false'))) { ?>
					<div class="btn-group" id="div_sapxep">
						<button class="btn btn-small bigger btn-blue dropdown-toggle" data-toggle="dropdown">
							<i class="icon-cogs"></i> <b>Nghiệp vụ</b>
							<i class="icon-angle-down icon-on-right"></i>
						</button>
						<ul class="dropdown-menu pull-right dropdown-caret dropdown-close">
							<?php //if(Core::_checkPerAction($user->id, 'com_tochuc','tochuc','au_nghiepvu_doiten','site',$this->row->id)){ 
							?>
							<?php if (Core::_checkPerActionArr($user_id, 'com_tochuc', 'tochuc', array('task' => 'au_nghiepvu_doiten', 'location' => 'site', 'non_action' => 'false'))) { ?>
								<li>
									<a id="btn_nghiepvu_doiten" style="cursor:pointer;">
										<i class="icon-edit"></i> Đổi tên
									</a>
								</li>
							<?php } ?>
							<?php //if(Core::_checkPerAction($user->id, 'com_tochuc','tochuc','au_nghiepvu_sapnhap','site',$this->row->id)){ 
							?>
							<?php if (Core::_checkPerActionArr($user_id, 'com_tochuc', 'tochuc', array('task' => 'au_nghiepvu_sapnhap', 'location' => 'site', 'non_action' => 'false'))) { ?>
								<li>
									<a id="btn_nghiepvu_sapnhap" style="cursor:pointer;">
										<i class="icon-edit"></i> Sáp nhập
									</a>
								</li>
							<?php } ?>
							<?php // if(!Core::_checkPerAction($user->id, 'com_tochuc','tochuc','au_nghiepvu_hopnhat','site',$this->row->id)){ 
							?>
							<?php if (Core::_checkPerActionArr($user_id, 'com_tochuc', 'tochuc', array('task' => 'au_nghiepvu_hopnhat', 'location' => 'site', 'non_action' => 'false'))) { ?>
								<li>
									<a id="btn_nghiepvu_hopnhat" style="cursor:pointer;">
										<i class="icon-edit"></i> Hợp nhất
									</a>
								</li>
							<?php } ?>
							<?php // if(Core::_checkPerAction($user->id, 'com_tochuc','tochuc','au_nghiepvu_chiatach','site',$this->row->id)){ 
							?>
							<?php if (Core::_checkPerActionArr($user_id, 'com_tochuc', 'tochuc', array('task' => 'au_nghiepvu_chiatach', 'location' => 'site', 'non_action' => 'false'))) { ?>
								<li>
									<a id="btn_nghiepvu_chiatach" style="cursor:pointer;">
										<i class="icon-edit"></i> Chia tách
									</a>
								</li>
							<?php } ?>
							<?php //if(Core::_checkPerAction($user->id, 'com_tochuc','tochuc','au_nghiepvu_giaithe','site',$this->row->id)){ 
							?>
							<?php if (Core::_checkPerActionArr($user_id, 'com_tochuc', 'tochuc', array('task' => 'au_nghiepvu_giaithe', 'location' => 'site', 'non_action' => 'false'))) { ?>
								<li>
									<a id="btn_nghiepvu_giaithe" style="cursor:pointer;">
										<i class="icon-edit"></i> Giải thể
									</a>
								</li>
							<?php } ?>
							<?php if (Core::_checkPerActionArr($user_id, 'com_tochuc', 'tochuc', array('task' => 'au_nghiepvu_doichuquan', 'location' => 'site', 'non_action' => 'false')) && ($this->row->type == 1 || $this->row->type == 3)) { ?>
								<li>
									<a id="btn_nghiepvu_doichuquan" style="cursor:pointer;">
										<i class="icon-edit"></i> Thay đổi cơ quan chủ quản
									</a>
								</li>
							<?php } ?>
						</ul>
					</div>
				<?php } ?>
        <?php }?>
        <div class="btn-group">
            <button type="button" class="btn btn-warning">Sắp xếp</button>
            <button type="button" class="btn btn-warning dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                <span class="sr-only">Toggle Dropdown</span>
            </button>
            <div class="dropdown-menu" role="menu" style="">
                <a class="dropdown-item" href="index.php?option=com_tochuc&controller=tochuc&task=orderup&id=<?php echo $this->row->id; ?>"><i class="fa fa-chevron-up"></i> Lên</a>
                <a class="dropdown-item" href="index.php?option=com_tochuc&controller=tochuc&task=orderdown&id=<?php echo $this->row->id; ?>"><i class="fa fa-chevron-down"></i>  Xuống</a>
            </div>
        </div>
        <div class="btn-group" id="">
			<?php if (Core::_checkPerActionArr($user_id, 'com_tochuc', 'tochuc', array('task' => 'edit', 'location' => 'site', 'non_action' => 'false'))) { ?>
                <a href="<?php echo Uri::root(true);?>/index.php/component/tochuc/?view=tochuc&task=thanhlap&id=<?php echo $this->row->id; ?>" class="btn btn-primary btn-block"><i class="fa fa-edit"></i> Hiệu chỉnh</a>
			<?php } ?>
		</div>
        <?php if (Core::_checkPerActionArr($user_id, 'com_tochuc', 'tochuc', array('task' => 'deletedept', 'location' => 'site', 'non_action' => 'false'))) { ?>
            <span id="btnXoa" href="<?php echo Uri::root(true);?>/index.php/component/tochuc/?view=tochuc&task=thanhlap&id=<?php echo $this->row->id; ?>" class="btn btn-danger btn-delete"><i class="fa fa-trash"></i> Xóa tổ chức</span>
		<?php } ?>
    </div>
</div>
<div class="card-body">
    <div class="">
        <div class="card card-primary card-outline card-outline-tabs">
            <div class="card-header p-0 border-bottom-0">
                <ul class="nav nav-tabs" id="myTab4">
                    <li class="nav-item active"><a class="nav-link active" data-tab-url="" href="#info" data-toggle="tab">Thông tin chung</a></li>
                    <?php if ($this->row->type == 1 || $this->row->type == 3 || $this->row->type == 0) : ?>
						<?php if (Core::_checkPerActionArr($user_id, 'com_tochuc', 'tochuc', array('task' => 'quatrinh', 'location' => 'site', 'non_action' => 'false'))) : ?>
							<li class="nav-item"><a class="nav-link" data-toggle="tab" data-tab-url="index.php?option=com_tochuc&view=tochuc&task=quatrinh&format=raw&id=<?php echo $this->row->id; ?>" href="#tochuc-quatrinh">Lịch sử tổ chức</a></li>
						<?php endif; ?>
							<li class="nav-item"><a class="nav-link" data-toggle="tab" data-tab-url="index.php?option=com_tochuc&view=tochuc&task=giaobienche&format=raw&id=<?php echo $this->row->id; ?>" href="#bienche-quatrinh">Biên chế</a></li>
							<li class="nav-item"><a class="nav-link" data-toggle="tab" data-tab-url="index.php?option=com_tochuc&view=tochuc&task=khenthuongkyluat&format=raw&id=<?php echo $this->row->id; ?>" href="#tochuc-quatrinh">Khen thưởng - Kỷ luật</a></li>
							<li class="nav-item"><a class="nav-link" data-toggle="tab" data-tab-url="index.php?option=com_tochuc&view=tochuc&task=giaouocthidua&format=raw&id=<?php echo $this->row->id; ?>" href="#giaouocthidua-quatrinh">Giao ước thi đua</a></li>
							<li class="nav-item"><a class="nav-link" data-toggle="tab" data-tab-url="index.php?option=com_tochuc&view=tochuc&task=phanhangdonvi&format=raw&id=<?php echo $this->row->id; ?>" href="#phanhangdonvi-quatrinh">Phân hạng đơn vị</a></li>
							<li class="nav-item"><a class="nav-link" data-toggle="tab" data-tab-url="index.php?option=com_tochuc&view=tochuc&task=quydinhcappho&format=raw&id=<?php echo $this->row->id; ?>" href="#quydinhcappho-quatrinh">Quy định cấp phó</a></li>
					<?php endif; ?>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="custom-tabs-four-tabContent">
                    <div class="tab-pane" id="tab_danhsachnangngachcc"></div>
                        <div id="info" class="tab-pane active">
							<div class="row">
								<!-- Bắt đầu HTML Thông tin vỏ chứa -->
								<?php if ($this->row->type == 2) { ?>
								<div class="col-md-6">
									<strong><i class="fas fa-sitemap mr-1"></i> Thuộc cây đơn vị</strong>
									<p class="text-muted">
										<?php echo Core::loadResult('ins_dept', array('name'), array('id=' => (int) $this->row->parent_id)) == ''? "Đơn vị cấp cha" : Core::loadResult('ins_dept', array('name'), array('id=' => (int) $this->row->parent_id)) ?>
									</p>
									<hr style="border-top: 1px solid rgba(0,0,0,.1);">
									
									<strong><i class="fas fa-book mr-1"></i> Tên</strong>
									<p class="text-muted">
										<?php echo $this->row->name; ?>
									</p>
									<hr style="border-top: 1px solid rgba(0,0,0,.1);">
									<strong><i class="fas fa-lock-open mr-1"></i> Trạng thái</strong>
									<p class="text-muted">
										<?php echo Core::loadResult('ins_status', array('name'), array('id=' => (int) $this->row->active)). " "; ?> <i class="fas fa-check-circle text-success"></i>
									</p>
									<hr style="border-top: 1px solid rgba(0,0,0,.1);">
								</div>
								<div class="col-md-6">
									<strong><i class="fas fa-folder-open mr-1"></i> Loại</strong>
									<p class="text-muted">
										<?php echo Core::loadResult('ins_type', array('name'), array('id=' => (int) $this->row->type)). " "; ?> <i class="fas fa-folder-open text-warning"></i>
									</p>
									<hr style="border-top: 1px solid rgba(0,0,0,.1);">
									<strong><i class="fas fa-file-alt mr-1"></i> Tên viết tắt</strong>
									<p class="text-muted">
										<?php echo $this->row->s_name; ?>
									</p>
									<hr style="border-top: 1px solid rgba(0,0,0,.1);">
									<strong><i class="fas fa-comment mr-1"></i> Ghi chú</strong>
									<p class="text-muted">
									<?php echo  $this->row->ghichu == '' ? 'Không có ghi chú':  nl2br($this->row->ghichu)?>
									</p>
									<hr style="border-top: 1px solid rgba(0,0,0,.1);">
									
								</div>

								<?php if ($this->vanban_active != null) {?>
									<div class="col-md-6">
										<strong><i class="fas fa-file-signature mr-1"></i> Số Quyết định</strong>
										<p class="text-muted"><?php echo $this->vanban_active['mahieu']; ?></p>
										<hr style="border-top: 1px solid rgba(0,0,0,.1);">
										<strong><i class="fas fa-kaaba mr-1"></i> Cơ quan ban hanh</strong>
										<p class="text-muted"><?php echo $this->vanban_active['coquan_banhanh']; ?></p>
									</div>
									<hr style="border-top: 1px solid rgba(0,0,0,.1);">
									<div class="col-md-6">
										<strong><i class="fas fa-calendar-alt mr-1"></i> Ngày ban hành</strong>
										<p class="text-muted"><?php echo $this->vanban_active['ngaybanhanh']; ?></p>
										<hr style="border-top: 1px solid rgba(0,0,0,.1);">
									</div>
								<?php } ?>
							<?php }?>
							<!-- Kết thúc HTML Thông tin vỏ chứa -->
							<!-- Bắt đầu HTML Thông tin Đơn vị/ Phòng ban -->
							<?php if($this->row->type == 1 || $this->row->type == 3){  ?>
								<div class="col-md-6">
									<strong><i class="fas fa-sitemap mr-1"></i> Thuộc cây đơn vị</strong>
									<p class="text-muted">
										<?php echo Core::loadResult('ins_dept', array('name'), array('id=' => (int) $this->row->parent_id)) == ''? "Đơn vị cấp cha" : Core::loadResult('ins_dept', array('name'), array('id=' => (int) $this->row->parent_id)) ?>
									</p>
									<hr style="border-top: 1px solid rgba(0,0,0,.1);">
									
									<strong><i class="fas fa-book mr-1"></i> Tên</strong>
									<p class="text-muted">
										<?php echo $this->row->name; ?>
									</p>
									<hr style="border-top: 1px solid rgba(0,0,0,.1);">
									<strong><i class="fas fa-lock-open mr-1"></i> Mã đơn vị</strong>
									<p class="text-muted">
										<?php echo $this->row->code; ?>
									</p>
									<hr style="border-top: 1px solid rgba(0,0,0,.1);">
								</div>
								<div class="col-md-6">
									<strong><i class="fas fa-folder-open mr-1"></i> Loại</strong>
									<p class="text-muted">
										<?php echo Core::loadResult('ins_type', array('name'), array('id=' => (int) $this->row->type)). " "; ?> <i class="fas fa-folder text-primary"></i>
									</p>
									<hr style="border-top: 1px solid rgba(0,0,0,.1);">
									<strong><i class="fas fa-file-alt mr-1"></i> Tên viết tắt</strong>
									<p class="text-muted">
										<?php echo $this->row->s_name; ?>
									</p>
									<hr style="border-top: 1px solid rgba(0,0,0,.1);">
									<strong><i class="fas fa-comment mr-1"></i> Tên tiếng anh</strong>
									<p class="text-muted">
									<?php echo $this->row->eng_name == ''? "Chưa có dữ liệu":$this->row->eng_name; ?>
									</p>
									<hr style="border-top: 1px solid rgba(0,0,0,.1);">
									
								</div>								
							<?php }?>
							<!-- Kết thúc HTML Thông tin Đơn vị/ Phòng ban -->
							</div>
                        </div>
						<div id="tochuc-quatrinh" class="tab-pane"></div>
						<div id="bienche-quatrinh" class="tab-pane"></div>
						<div id="khenthuongkyluat-quatrinh" class="tab-pane"></div>
						<div id="giaouocthidua-quatrinh" class="tab-pane"></div>
						<div id="phanhangdonvi-quatrinh" class="tab-pane"></div>
						<div id="quydinhcappho-quatrinh" class="tab-pane"></div>
                    </div>
                </div>
            </div>
			
        </div>
    </div>
</div>


<div class="modal fade" id="modal_tochuc" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="width: 900px; left: 35%; display: none;">
	<div id="div_modal" class="modal-dialog modal-lg">
	</div>
</div>
<script>
	jQuery(document).ready(function($) {
		$('#bntGiaobienche').click(function() {
			var htmlLoading = '<i class="icon-spinner icon-spin blue bigger-125"></i>';
			jQuery.ajax({
				type: "GET",
				url: this.href,
				beforeSend: function() {
					$.blockUI();
					$('#com_tochuc_viewdetail').empty();
				},
				success: function(data, textStatus, jqXHR) {
					$.unblockUI();
					$('#com_tochuc_viewdetail').html(data);
				}
			});
			return false;
		});
		$('#btnXoa').click(function() {
			if (confirm("Bạn có muốn xóa Tổ chức này không?")) {
				if (confirm("Dữ liệu của tổ chức sẽ BỊ XÓA HOÀN TOÀN, và KHÔNG THỂ KHÔI PHỤC!\nBạn có chắc chắn xóa?")) {
					var urlCheckHoso = '<?php echo Uri::base(true); ?>/index.php?option=com_tochuc&controller=tochuc&task=checkSoluongHosoByDonvi&format=raw';
					$.get(urlCheckHoso, {
						id_donvi: '<?php echo $this->row->id; ?>'
					}, function(data) {
						if (data > 0) {
							alert('Tổ chức này còn tồn tại hồ sơ. Không thể xóa tổ chức!');
						} else {
							window.location.href = "index.php?option=com_tochuc&controller=tochuc&task=deletedept&id=<?php echo $this->row->id; ?>";
						}
					});
				}
			}
			return false;
		});
		// $('#bntQuaTrinh').click(function() {
		// 	jQuery.ajax({
		// 		type: "GET",
		// 		url: this.href,
		// 		beforeSend: function() {
		// 			$.blockUI();
		// 			$('#com_tochuc_viewdetail').empty();
		// 		},
		// 		success: function(data, textStatus, jqXHR) {
		// 			$.unblockUI();
		// 			$('#com_tochuc_viewdetail').html(data);
		// 		}
		// 	});
		// 	return false;
		// });
		$('#bntKhenthuongkyluat').click(function() {
			jQuery.ajax({
				type: "GET",
				url: this.href,
				beforeSend: function() {
					$.blockUI();
					$('#com_tochuc_viewdetail').empty();
				},
				success: function(data, textStatus, jqXHR) {
					$.unblockUI();
					$('#com_tochuc_viewdetail').html(data);
				}
			});
			return false;
		});
		// $('#btn_export_lichsu').on('click',function(){
		//  		document.location.assign(this.href);
		// 	return false;
		// });	
		$('#myTab4 li').on('click', function() {
			Pace.start()
			var div_load = $(this).find('a').attr('href');
			var url = $(this).find('a').data('tab-url');
			
			if (!$(this).hasClass('active')) {
				$(div_load).load(url, function() {});
				Pace.stop()
			}
			Pace.stop()
		});
		$('#btn_nghiepvu_doiten').on('click', function() {
			$('#com_tochuc_viewdetail').hide();
			$('#com_tochuc_nghiepvu').show();
			$('#com_tochuc_nghiepvu').load("index.php?option=com_tochuc&view=tochuc&format=raw&task=nghiepvu_doiten&id=<?php echo $this->row->id; ?>&type=<?php echo $this->row->type ?>", function() {});
		});
		$('#btn_nghiepvu_sapnhap').on('click', function() {
			$('#com_tochuc_viewdetail').hide();
			$('#com_tochuc_nghiepvu').show();
			$('#com_tochuc_nghiepvu').load("index.php?option=com_tochuc&view=tochuc&format=raw&task=nghiepvu_sapnhap&id=<?php echo $this->row->id; ?>&type=<?php echo $this->row->type ?>", function() {});
		});
		$('#btn_nghiepvu_hopnhat').on('click', function() {
			$('#com_tochuc_viewdetail').hide();
			$('#com_tochuc_nghiepvu').show();
			$('#com_tochuc_nghiepvu').load("index.php?option=com_tochuc&view=tochuc&format=raw&task=nghiepvu_hopnhat&id=<?php echo $this->row->id; ?>&type=<?php echo $this->row->type ?>", function() {});
		});
		$('#btn_nghiepvu_chiatach').on('click', function() {
			$('#com_tochuc_viewdetail').hide();
			$('#com_tochuc_nghiepvu').show();
			$('#com_tochuc_nghiepvu').load("index.php?option=com_tochuc&view=tochuc&format=raw&task=nghiepvu_chiatach&id=<?php echo $this->row->id; ?>&type=<?php echo $this->row->type ?>", function() {});
		});
		$('#btn_nghiepvu_giaithe').on('click', function() {
			$('#com_tochuc_viewdetail').hide();
			$('#com_tochuc_nghiepvu').show();
			$('#com_tochuc_nghiepvu').load("index.php?option=com_tochuc&view=tochuc&format=raw&task=nghiepvu_giaithe&id=<?php echo $this->row->id; ?>&type=<?php echo $this->row->type ?>", function() {});
		});
		$('#btn_nghiepvu_doichuquan').on('click', function() {
			$('#com_tochuc_viewdetail').hide();
			$('#com_tochuc_nghiepvu').show();
			$('#com_tochuc_nghiepvu').load("index.php?option=com_tochuc&view=tochuc&format=raw&task=nghiepvu_doichuquan&id=<?php echo $this->row->id; ?>&type=<?php echo $this->row->type ?>", function() {});
		});

	});
</script>
<style>
.dropdown-item:focus, .dropdown-item:hover {
    color: #16181b;
    text-decoration: none;
    background-color: #e2f1ff;
}    
</style>