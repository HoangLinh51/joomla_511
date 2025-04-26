<?php
defined('_JEXEC') or die('Restricted access');
$idUser = JFactory::getUser()->id;

// Lấy giá trị is_quyen từ bảng jos_users
$db = JFactory::getDbo();
$query = $db->getQuery(true)
	->select('is_quyen')
	->from($db->quoteName('jos_users'))
	->where($db->quoteName('id') . ' = ' . (int) $idUser);
$db->setQuery($query);
$is_quyen = $db->loadResult();

?>

<form action="index.php" method="post" id="frmNhanhokhau" name="frmNhanhokhau" class="form-horizontal" style="font-size:16px;background:white">
	<div class="container-fluid" style="padding-left:20px; padding-right:20px;">
		<div class="content-header">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h3 class="m-0 text-primary"><i class="fas fa-users"></i> Quản lý thông tin nhân hộ khẩu</h3>
				</div>
				<div class="col-sm-6 text-right" style="padding:0;">
					<?php if ($is_quyen == 0) { ?>
						<a href="index.php?option=com_vptk&view=nhk&task=chonfile" class="btn btn-success" style="font-size:16px;">
							<i class="fas fa-file-download"></i> Import Excel
						</a>
						<a href="index.php?option=com_vptk&view=nhk&task=addnhk" class="btn btn-primary" style="font-size:16px;width:136px">
							<i class="fas fa-plus"></i> Thêm mới
						</a>
					<?php } ?>
				</div>
			</div>
		</div>

		<div id="main-right">
			<div class="card card-primary collapsed-card">
				<div class="card-header">
					<h3 class="card-title"><i class="fas fa-search"></i> Tìm kiếm</h3>
					<div class="card-tools">
						<button type="button" class="btn btn-tool" data-action="reload"><i class="fas fa-sync-alt"></i></button>
						<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-chevron-up"></i></button>
					</div>
				</div>
				<div class="card-body">
					<table class="table table-borderless">
						<tr>
							<td style="width:5%;padding:10px;" nowrap><b class="text-primary" style="font-size:17px;line-height:2.5">Số hộ khẩu</b></td>
							<td style="width:45%;">
								<input type="text" name="hokhau_so" id="hokhau_so" class="form-control" style="font-size:16px;" placeholder="Nhập số hộ khẩu" />
							</td>
							<td style="width:5%;padding:10px;" nowrap><b class="text-primary" style="font-size:17px;line-height:2.5">Họ tên chủ hộ</b></td>
							<td style="width:45%;">
								<input type="text" name="hoten" id="hoten" class="form-control" style="font-size:16px;" placeholder="Nhập họ tên chủ hộ" />
							</td>
						</tr>
						<tr>
							<td style="padding:10px;" nowrap><b class="text-primary" style="font-size:17px;line-height:2.5">Giới tính</b></td>
							<td>
								<select id="gioitinh_id" name="gioitinh_id" class="custom-select" data-placeholder="Chọn giới tính">
									<option value=""></option>
									<?php foreach ($this->gioitinh as $gt) { ?>
										<option value="<?php echo $gt['id']; ?>"><?php echo $gt['tengioitinh']; ?></option>
									<?php } ?>
								</select>
							</td>
							<td style="padding:10px;" nowrap><b class="text-primary" style="font-size:17px;line-height:2.5">Thường trú/Tạm trú</b></td>
							<td>
								<select id="is_tamtru" name="is_tamtru" class="custom-select" data-placeholder="Chọn thường trú/tạm trú">
									<option value=""></option>
									<option value="0">Thường trú</option>
									<option value="1">Tạm trú</option>
								</select>
							</td>
						</tr>
						<tr>
							<td style="padding:10px;" nowrap><b class="text-primary" style="font-size:17px;line-height:2.5">Xã/Phường</b></td>
							<td>
								<select id="phuongxa_id" name="phuongxa_id" class="custom-select" data-placeholder="Chọn xã/phường">
									<option value=""></option>
									<?php foreach ($this->phuongxa as $px) { ?>
										<option value="<?php echo $px['id']; ?>"><?php echo $px['tenkhuvuc']; ?></option>
									<?php } ?>
								</select>
							</td>
							<td style="padding:10px;" nowrap><b class="text-primary" style="font-size:17px;line-height:2.5">Thôn/Tổ</b></td>
							<td>
								<select id="thonto_id" name="thonto_id" class="custom-select" data-placeholder="Chọn thôn/tổ">
									<option value=""></option>
								</select>
							</td>
						</tr>
						<tr>
							<td colspan="4" class="text-center" style="padding-top:10px;">
								<button class="btn btn-primary" id="btn_filter"><i class="fas fa-search"></i> Tìm kiếm</button>
								<button class="btn btn-success" id="btn_xuatexcel"><i class="fas fa-file-excel"></i> Xuất excel</button>
							</td>
						</tr>
					</table>
				</div>
			</div>
			<div id="div_danhsach">
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover" id="tblDanhsach">
						<thead>
							<tr style="background-color: #FBFBFB !important;" class="bg-primary text-white">
								<th style="vertical-align:middle;color:#4F4F4F!important;" class="text-center">STT</th>
								<th style="vertical-align:middle;color:#4F4F4F!important;" class="text-center">Số hộ khẩu</th>
								<th style="vertical-align:middle;color:#4F4F4F!important;" class="text-center">Tên chủ hộ</th>
								<th style="vertical-align:middle;color:#4F4F4F!important;" class="text-center">Giới tính</th>
								<th style="vertical-align:middle;color:#4F4F4F!important;" class="text-center">Năm sinh</th>
								<th style="vertical-align:middle;color:#4F4F4F!important;" class="text-center">Chỗ ở hiện nay</th>
								<th style="vertical-align:middle;color:#4F4F4F!important;" class="text-center">Số điện thoại</th>
								<th style="vertical-align:middle;color:#4F4F4F!important;" class="text-center" style="width:131px;">Chức năng</th>
							</tr>
						</thead>
						<tbody id="tbody_danhsach"></tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<?php echo JHTML::_('form.token'); ?>
</form>

<script>
	jQuery(document).ready(function($) {
		// Xử lý sự kiện click trên card-header
		$('.card-header').on('click', function(e) {
			if (!$(e.target).closest('.card-tools').length) {
				$(this).find('[data-card-widget="collapse"]').trigger('click');
			}
		});

		// Khởi tạo Select2
		$('#gioitinh_id, #is_tamtru, #phuongxa_id, #thonto_id').select2({
			width: '100%',
			allowClear: true,
			placeholder: function() {
				return $(this).data('placeholder');
			}
		});

		// Xử lý sự kiện change cho phuongxa_id
		$('#phuongxa_id').on('change', function() {
			if ($(this).val() == '') {
				$('#thonto_id').html('<option value=""></option>').trigger('change');
			} else {
				$.post('index.php', {
					option: 'com_vptk',
					controller: 'vptk',
					task: 'getKhuvucByIdCha',
					cha_id: $(this).val()
				}, function(data) {
					if (data.length > 0) {
						var str = '<option value=""></option>';
						$.each(data, function(i, v) {
							str += '<option value="' + v.id + '">' + v.tenkhuvuc + '</option>';
						});
						$('#thonto_id').html(str).trigger('change');
					}
				});
			}
		});

		function loadDanhSach(start = 0) {
			$("#overlay").fadeIn(300);
			$('#div_danhsach').load('index.php', {
				option: 'com_vptk',
				view: 'nhk',
				format: 'raw',
				task: 'DS_NHK',
				phuongxa_id: $('#phuongxa_id').val(),
				hoten: $('#hoten').val(),
				gioitinh_id: $('#gioitinh_id').val(),
				is_tamtru: $('#is_tamtru').val(),
				thonto_id: $('#thonto_id').val(),
				hokhau_so: $('#hokhau_so').val(),
				daxoa: 0,
				start: start
			}, function(response, status, xhr) {
				$("#overlay").fadeOut(300);
				if (status === "error") {
					console.error('Error loading danh sach: ', xhr.status, xhr.statusText);
				}
			});
		}

		// Load danh sách khi trang được tải
		loadDanhSach();

		// Xử lý nút Tìm kiếm
		$('#btn_filter').on('click', function(e) {
			e.preventDefault();
			loadDanhSach();
		});
	});
</script>

<style>
	.card.collapsed-card .card-body {
		display: none;
	}

	.card-header {
		cursor: pointer;
	}

	.card-header .card-tools .btn-tool i {
		transition: transform 0.3s ease;
	}

	.card.collapsed-card .btn-tool i.fa-chevron-up {
		transform: rotate(180deg);
	}

	.btn_hieuchinh,
	.btn_xoa {
		position: relative;
		transition: color 0.3s;
	}

	.btn_hieuchinh,
	.btn_xoa {
		cursor: pointer;
		pointer-events: auto;
		color: #999;
		padding: 10px;
	}

	.btn_hieuchinh:hover i,.btn_xoa:hover i {
		color: #0066ff;
	}

	.btn_hieuchinh::after,.btn_xoa::after {
		content: attr(data-title);
		position: absolute;
		bottom: 72%;
		left: 50%;
		transform: translateX(-50%);
		background-color: rgba(79, 89, 102, .08);
		color: #000000;
		padding: 6px 10px;
		font-size: 14px;
		white-space: nowrap;
		border-radius: 6px;
		opacity: 0;
		visibility: hidden;
		transition: opacity 0.3s;
		box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.2);
		border: 1px solid #ccc;
	}
	

	.btn_hieuchinh:hover::after,.btn_xoa:hover::after {
		opacity: 1;
		visibility: visible;
	}

	.content-header {
		padding: 20px .5rem 15px .5rem;
	}

	.text-primary {
		color: #478fca !important;
	}

	.form-control {
		height: 38px;
		font-size: 16px;
	}

	.select2-container .select2-choice {
		height: 34px !important;
	}

	.select2-container .select2-choice .select2-chosen {
		height: 34px !important;
		padding: 5px 0 0 5px !important;
	}

	

	.select2-container .select2-selection--single {
		height: 38px;
	}
</style>