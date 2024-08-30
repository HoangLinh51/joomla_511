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
						<button type="button" class="btn btn-default"><i class="fa fa-cogs"></i> Nghiệp vụ</button>
						<button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
							<span class="sr-only">Toggle Dropdown</span>
						</button>
						<div class="dropdown-menu" role="menu" style="">
							<?php if (Core::_checkPerActionArr($user_id, 'com_tochuc', 'tochuc', array('task' => 'au_nghiepvu_doiten', 'location' => 'site', 'non_action' => 'false'))) { ?>
							<a class="dropdown-item" id="btn_nghiepvu_doiten" href="#"><i class="fa fa-pencil-alt"></i> Đổi tên</a>
							<?php } ?>
							<?php if (Core::_checkPerActionArr($user_id, 'com_tochuc', 'tochuc', array('task' => 'au_nghiepvu_sapnhap', 'location' => 'site', 'non_action' => 'false'))) { ?>
							<a class="dropdown-item" id="btn_nghiepvu_sapnhap" href="#"><i class="fas fa-sign-in-alt"></i> Sáp nhập</a>
							<?php } ?>
							<?php if (Core::_checkPerActionArr($user_id, 'com_tochuc', 'tochuc', array('task' => 'au_nghiepvu_hopnhat', 'location' => 'site', 'non_action' => 'false'))) { ?>
							<a class="dropdown-item" id="btn_nghiepvu_hopnhat" href="#"><i class="fas fa-coins"></i> Hợp nhất</a>
							<?php } ?>
							<?php if (Core::_checkPerActionArr($user_id, 'com_tochuc', 'tochuc', array('task' => 'au_nghiepvu_chiatach', 'location' => 'site', 'non_action' => 'false'))) { ?>
							<a class="dropdown-item" id="btn_nghiepvu_chiatach" href="#"><i class="fas fa-columns"></i> Chia tách</a>
							<?php } ?>
							<?php if (Core::_checkPerActionArr($user_id, 'com_tochuc', 'tochuc', array('task' => 'au_nghiepvu_giaithe', 'location' => 'site', 'non_action' => 'false'))) { ?>
							<a class="dropdown-item" id="btn_nghiepvu_giaithe" href="#"><i class="fa fa-city"></i> Giải thể</a>
							<?php } ?>
							<?php if (Core::_checkPerActionArr($user_id, 'com_tochuc', 'tochuc', array('task' => 'au_nghiepvu_doichuquan', 'location' => 'site', 'non_action' => 'false'))) { ?>
							<a class="dropdown-item" id="btn_nghiepvu_doichuquan" href="#"><i class="fas fa-exchange-alt"></i> Thay đổi cơ quan chủ quản</a>
							<?php } ?>
						</div>
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
                    <li class="nav-item active"><a class="nav-link active" data-tab-url="#info"  href="#info" data-toggle="tab">Thông tin chung</a></li>
                    <?php if ($this->row->type == 1 || $this->row->type == 3 || $this->row->type == 0) : ?>
						<?php if (Core::_checkPerActionArr($user_id, 'com_tochuc', 'tochuc', array('task' => 'quatrinh', 'location' => 'site', 'non_action' => 'false'))) : ?>
							<li class="nav-item"><a class="nav-link" data-toggle="tab" data-tab-url="index.php?option=com_tochuc&view=tochuc&task=quatrinh&format=raw&id=<?php echo $this->row->id; ?>" href="#tochuc-quatrinh">Lịch sử tổ chức</a></li>
						<?php endif; ?>
							<li class="nav-item"><a class="nav-link" data-toggle="tab" data-tab-url="index.php?option=com_tochuc&view=tochuc&task=giaobienche&format=raw&id=<?php echo $this->row->id; ?>" href="#bienche-quatrinh">Biên chế</a></li>
							<li class="nav-item"><a class="nav-link" data-toggle="tab" data-tab-url="index.php?option=com_tochuc&view=tochuc&task=khenthuongkyluat&format=raw&id=<?php echo $this->row->id; ?>" href="#khenthuongkyluat-quatrinh">Khen thưởng - Kỷ luật</a></li>
							<li class="nav-item"><a class="nav-link" data-toggle="tab" data-tab-url="index.php?option=com_tochuc&view=tochuc&task=giaouocthidua&format=raw&id=<?php echo $this->row->id; ?>" href="#giaouocthidua-quatrinh">Giao ước thi đua</a></li>
							<li class="nav-item"><a class="nav-link" data-toggle="tab" data-tab-url="<?php echo Uri::root(true) ?>/index.php/component/tochuc?view=tochuc&task=phanhangdonvi&format=raw&id=<?php echo $this->row->id; ?>" href="#phanhangdonvi-quatrinh">Phân hạng đơn vị</a></li>
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
						<div id="tochuc-quatrinh" class="tab-pane loading"></div>
						<div id="bienche-quatrinh" class="tab-pane loading"></div>
						<div id="khenthuongkyluat-quatrinh" class="tab-pane loading"></div>
						<div id="giaouocthidua-quatrinh" class="tab-pane loading"></div>
						<div id="phanhangdonvi-quatrinh" class="tab-pane loading"></div>
						<div id="quydinhcappho-quatrinh" class="tab-pane loading"></div>
                    </div>
                </div>
            </div>
			
        </div>
    </div>
</div>


<div class="modal fade" id="modal_tochuc" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
	<div id="div_modal" class="modal-dialog modal-xl">
	</div>
</div>
<script>
	jQuery(document).ready(function($) {
		/* $('#bntGiaobienche').click(function() {
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
		}); */
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
		/* $('#bntKhenthuongkyluat').click(function() {
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
		}); */
		// $('#btn_export_lichsu').on('click',function(){
		//  		document.location.assign(this.href);
		// 	return false;
		// });	
		$('#myTab4 li').on('click', function() {
			/* var div_load = $(this).find('a').attr('href');
			var url = $(this).find('a').data('tab-url'); */
			/* jQuery.ajax({
                type: "GET",
                url: url,
                beforeSend: function() {  
                    $('.loading').html('<div class="overlay"><i class="fas fa-sync-alt fa-spin"></i></div>'); 
                },
                success: function() {
                    $(div_load).load(url, function() {});
                },
                error: function() {
					Pace.stop();
                }
            }); */
			
			
			Pace.start();
			var div_load = $(this).find('a').attr('href');
			var url = $(this).find('a').data('tab-url');
			if(url == '#info') {
				$('.loading').html('<div class="container_overlay overlay"></div>');
				/* $('.loading').html('<div class="overlay"><i class="fas fa-sync-alt fa-spin"></i></div>');  */
				Pace.stop();
			}else{
				$.blockUI();
				if (!$(this).hasClass('active')) {
					
					$('.loading').html('<div class="container_overlay overlay"></div>');
					// $('.loading').html('<div class="overlay"><i class="fas fa-sync-alt fa-spin"></i></div>'); 
					$(div_load).load(url, function() {
						$('.overlay').remove();
						$.unblockUI();
					});
					Pace.stop();
				}
				Pace.stop();
			}
			
		});
		$('#btn_nghiepvu_doiten').on('click', function() {
			$.blockUI();
			$('#com_tochuc_viewdetail').hide();
			$('#com_tochuc_nghiepvu').show();
			$('#com_tochuc_nghiepvu').load("<?php echo Uri::root(true) ?>/index.php/component/tochuc?view=tochuc&format=raw&task=nghiepvu_doiten&id=<?php echo $this->row->id; ?>&type=<?php echo $this->row->type ?>", function() {
				$.unblockUI();
			});
		});
		 
		$('#btn_nghiepvu_sapnhap').on('click', function() {
			$.blockUI();
			$('#com_tochuc_viewdetail').hide();
			$('#com_tochuc_nghiepvu').show();
			$('#com_tochuc_nghiepvu').load("<?php echo Uri::root(true) ?>/index.php/component/tochuc?view=tochuc&format=raw&task=nghiepvu_sapnhap&id=<?php echo $this->row->id; ?>&type=<?php echo $this->row->type ?>", function() {
				$.unblockUI();
			});
		});
		
		$('#btn_nghiepvu_hopnhat').on('click', function() {
			$.blockUI();
			$('#com_tochuc_viewdetail').hide();
			$('#com_tochuc_nghiepvu').show();
			$('#com_tochuc_nghiepvu').load("<?php echo Uri::root(true) ?>/index.php/component/tochuc?view=tochuc&format=raw&task=nghiepvu_hopnhat&id=<?php echo $this->row->id; ?>&type=<?php echo $this->row->type ?>", function() {
				$.unblockUI();
			});
		});

		$('#btn_nghiepvu_chiatach').on('click', function() {
			$.blockUI();
			$('#com_tochuc_viewdetail').hide();
			$('#com_tochuc_nghiepvu').show();
			$('#com_tochuc_nghiepvu').load("<?php echo Uri::root(true) ?>/index.php/component/tochuc?view=tochuc&format=raw&task=nghiepvu_chiatach&id=<?php echo $this->row->id; ?>&type=<?php echo $this->row->type ?>", function() {
				$.unblockUI();
			});
		});
		$('#btn_nghiepvu_giaithe').on('click', function() {
			$.blockUI();
			$('#com_tochuc_viewdetail').hide();
			$('#com_tochuc_nghiepvu').show();
			$('#com_tochuc_nghiepvu').load("<?php echo Uri::root(true) ?>/index.php/component/tochuc?view=tochuc&format=raw&task=nghiepvu_giaithe&id=<?php echo $this->row->id; ?>&type=<?php echo $this->row->type ?>", function() {
				$.unblockUI();
			});
		});
		$('#btn_nghiepvu_doichuquan').on('click', function() {
			$.blockUI();
			$('#com_tochuc_viewdetail').hide();
			$('#com_tochuc_nghiepvu').show();
			$('#com_tochuc_nghiepvu').load("<?php echo Uri::root(true) ?>/index.php/component/tochuc?view=tochuc&format=raw&task=nghiepvu_doichuquan&id=<?php echo $this->row->id; ?>&type=<?php echo $this->row->type ?>", function() {
				$.unblockUI();
			});
		});

	});
</script>
<style>
.required {
	color: red;
}	
.dropdown-item:focus, .dropdown-item:hover {
    color: #16181b;
    text-decoration: none;
    background-color: #e2f1ff;
}    

</style>


<div class="container"></div>

<style>
  .container_overlay {
    --uib-size: 80px;
    --uib-color: #0593FF;
    --uib-speed: 1.75s;
    --uib-stroke: 5px;
    --uib-bg-opacity: .1;
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    height: var(--uib-stroke);
    width: var(--uib-size);
    border-radius: calc(var(--uib-stroke) / 2);
    overflow: hidden;
    transform: translate3d(0, 0, 0);
  }

  .container_overlay::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    height: 100%;
    width: 100%;
    background-color: var(--uib-color);
    opacity: var(--uib-bg-opacity);
    transition: background-color 0.3s ease;
  }

  .container_overlay::after {
    content: '';
    height: 100%;
    width: 100%;
    border-radius: calc(var(--uib-stroke) / 2);
    animation: wobble var(--uib-speed) ease-in-out infinite;
    transform: translateX(-95%);
    background-color: var(--uib-color);
    transition: background-color 0.3s ease;
  }

  @keyframes wobble {
    0%,
    100% {
      transform: translateX(-95%);
    }
    50% {
      transform: translateX(95%);
    }
  }
</style>
