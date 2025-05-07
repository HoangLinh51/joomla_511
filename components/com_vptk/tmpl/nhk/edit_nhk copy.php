tôi vẫn chưa kiểm tra ra lỗi nút thêm nhân khẩu
<?php
defined('_JEXEC') or die('Restricted access');
$item = $this->item;
$nhankhau = $item['nhankhau'];

use Joomla\CMS\Uri\Uri;

use Joomla\CMS\Session\Session;
use Joomla\CMS\HTML\HTMLHelper;
// HTMLHelper::_('script', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js', ['version' => 'auto']);

?>
<meta>
<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/bootstrap-datepicker/locales/bootstrap-datepicker.vi.min.js" type="text/javascript"></script>

<!-- <script src="<?php echo Uri::root(true); ?>/templates/adminlte/plugins/select2/js/select2.min.js" type="text/javascript"></script> -->
<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/jquery/jquery-validation/jquery.validate.js" type="text/javascript"></script>
<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/jquery/jquery-validation/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/jquery/jquery-validation/additional-methods.min.js" type="text/javascript"></script>
<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/jquery/jquery.toast.js" type="text/javascript"></script>

</meta>
<form id="frmNhanhokhau" name="frmNhanhokhau" method="post" action="index.php?option=com_vptk&controller=nhk&task=saveNhanhokhau">
    <div class="container-fluid" style="padding-left:20px; padding-right:20px;">
        <h2 class="mb-3 text-primary">
            <?php echo ((int)$item['id'] > 0) ? "Hiệu chỉnh" : "Thêm mới"; ?> thông tin nhân, hộ khẩu
            <span class="float-right">
                <button type="button" id="btn_quaylai" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Quay lại</button>
            </span>
        </h2>
        <table class="table w-100" id="tblThongtin">
            <tbody>
                <tr>
                    <td colspan="6">
                        <h3 class="mb-0 fw-bold">Thông tin hộ khẩu</h3>
                    </td>
                </tr>
                <tr>
                    <td class="align-middle"><strong>Số hộ khẩu: <!--span class="text-danger">*</span--></strong></td>
                    <td class="align-middle">
                        <div class="mb-3">
                            <input type="text" id="hokhau_so" name="hokhau_so" value="<?php echo htmlspecialchars($item['hokhau_so']); ?>" class="form-control" placeholder="Nhập số hộ khẩu">
                        </div>
                    </td>
                    <td class="align-middle"><strong>Ngày cấp: <!--span class="text-danger">*</span--></strong></td>
                    <td class="align-middle">
                        <!-- <div class="col-md-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="text" autocomplete="off" class="form-control rounded-0" id="datepicker" name="name">
                                </div>
                            </div>
                        </div> -->
                        <div class="input-group mb-3">
                            
                            <input type="text" id="hokhau_ngaycap" autocomplete="off" name="hokhau_ngaycap" class="form-control rounded-0 " id="datepicker" data-date-format="dd/mm/yyyy" value="<?php echo htmlspecialchars($item['hokhau_ngaycap']); ?>" placeholder="dd/mm/yyyy">
                            <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                        </div>
                    </td>
                    <td class="align-middle"><strong>Cơ quan cấp: <!--span class="text-danger">*</span--></strong></td>
                    <td class="align-middle">
                        <div class="mb-3">
                            <input type="text" id="hokhau_coquancap" name="hokhau_coquancap" value="<?php echo htmlspecialchars($item['hokhau_coquancap']); ?>" class="form-control" placeholder="Nhập cơ quan cấp">
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="align-middle"><strong>Phường/Xã: <span class="text-danger">*</span></strong></td>
                    <td class="align-middle">
                        <div class="mb-3">
                            <input type="hidden" id="tinhthanh_id" name="tinhthanh_id" value="<?php echo htmlspecialchars($item['tinhthanh_id']); ?>" />
                            <input type="hidden" id="quanhuyen_id" name="quanhuyen_id" value="<?php echo htmlspecialchars($item['quanhuyen_id']); ?>" />
                            <select id="phuongxa_id" name="phuongxa_id" class="custom-select" data-placeholder="Chọn phường/xã">
                                <option value="" data-quanhuyen="" data-tinhthanh=""></option>
                                <?php if (is_array($this->phuongxa) && count($this->phuongxa) == 1) { ?>
                                    <option value="<?php echo $this->phuongxa[0]['id']; ?>" selected data-quanhuyen="<?php echo $this->phuongxa[0]['quanhuyen_id']; ?>" data-tinhthanh="<?php echo $this->phuongxa[0]['tinhthanh_id']; ?>"><?php echo htmlspecialchars($this->phuongxa[0]['tenkhuvuc']); ?></option>
                                <?php } elseif (is_array($this->phuongxa)) { ?>
                                    <?php foreach ($this->phuongxa as $px) { ?>
                                        <option value="<?php echo $px['id']; ?>" <?php echo ($item['phuongxa_id'] == $px['id']) ? 'selected' : ''; ?> data-quanhuyen="<?php echo $px['quanhuyen_id']; ?>" data-tinhthanh="<?php echo $px['tinhthanh_id']; ?>"><?php echo htmlspecialchars($px['tenkhuvuc']); ?></option>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                        </div>
                    </td>
                    <td class="align-middle"><strong>Thôn/Tổ: <span class="text-danger">*</span></strong></td>
                    <td class="align-middle">
                        <div class="mb-3">
                            <select id="thonto_id" name="thonto_id" class="custom-select" data-placeholder="Chọn thôn/tổ">
                                <option value=""></option>
                                <?php if (is_array($this->thonto) && count($this->thonto) > 0) { ?>
                                    <?php foreach ($this->thonto as $tt) { ?>
                                        <option value="<?php echo $tt['id']; ?>" <?php echo ($item['thonto_id'] == $tt['id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($tt['tenkhuvuc']); ?></option>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                        </div>
                    </td>
                    <td class="align-middle"><strong>Số nhà/Đường: <span class="text-danger">*</span></strong></td>
                    <td class="align-middle">
                        <div class="mb-3">
                            <input type="text" id="diachi" name="diachi" value="<?php echo htmlspecialchars($item['diachi']); ?>" class="form-control" placeholder="Nhập số nhà, tên đường">
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <h3 class="mb-0 fw-bold">Thông tin nhân khẩu
            <span class="float-right">
                <button type="button" class="btn btn-primary" id="btn_themnhankhau"><i class="fas fa-plus"></i> Thêm nhân khẩu</button>
            </span>
        </h3>
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover" id="tblDanhsach">
                <thead>
                    <tr class="bg-primary text-white">
                        <th class="align-middle text-center" rowspan="2" style="width: 50px;">STT</th>
                        <th class="align-middle text-center" rowspan="2">Quan hệ với<br>chủ hộ</th>
                        <th class="align-middle text-center" rowspan="2">Họ tên</th>
                        <th class="align-middle text-center" rowspan="2">Ngày sinh</th>
                        <th class="align-middle text-center" rowspan="2">Giới tính</th>
                        <th class="align-middle text-center" colspan="3">CMND/CCCD</th>
                        <th class="align-middle text-center" rowspan="2">Điện thoại</th>
                        <th class="align-middle text-center" rowspan="2">Dân tộc</th>
                        <th class="align-middle text-center" rowspan="2">Tôn giáo</th>
                        <th class="align-middle text-center" rowspan="2">Trình độ học vấn</th>
                        <th class="align-middle text-center" rowspan="2">Nghề nghiệp</th>
                        <th class="align-middle text-center" rowspan="2">Nơi ở hiện tại</th>
                        <th class="align-middle text-center" rowspan="2">Nơi thường trú trước khi chuyển đến</th>
                        <th class="align-middle text-center" rowspan="2">Lý do xóa đăng ký thường trú</th>
                        <th class="align-middle text-center" rowspan="2" style="width: 150px;">Chức năng</th>
                    </tr>
                    <tr class="bg-primary text-white">
                        <th class="align-middle text-center">Số</th>
                        <th class="align-middle text-center">Ngày cấp</th>
                        <th class="align-middle text-center">Nơi cấp</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (is_array($nhankhau) && count($nhankhau) > 0) { ?>
                        <?php foreach ($nhankhau as $index => $nk) { ?>
                            <tr>
                                <td class="align-middle text-center"><?php echo $index + 1; ?></td>
                                <td class="align-middle"><?php echo htmlspecialchars($nk['quanhe']); ?></td>
                                <td class="align-middle"><?php echo htmlspecialchars($nk['hoten']); ?></td>
                                <td class="align-middle"><?php echo htmlspecialchars($nk['ngaysinh']); ?></td>
                                <td class="align-middle"><?php echo htmlspecialchars($nk['gioitinh']); ?></td>
                                <td class="align-middle"><?php echo htmlspecialchars($nk['cccd_so']); ?></td>
                                <td class="align-middle"><?php echo htmlspecialchars($nk['cccd_ngaycap']); ?></td>
                                <td class="align-middle"><?php echo htmlspecialchars($nk['cccd_coquancap']); ?></td>
                                <td class="align-middle"><?php echo htmlspecialchars($nk['dienthoai']); ?></td>
                                <td class="align-middle"><?php echo htmlspecialchars($nk['dantoc']); ?></td>
                                <td class="align-middle"><?php echo htmlspecialchars($nk['tongiao']); ?></td>
                                <td class="align-middle"><?php echo htmlspecialchars($nk['trinhdo']); ?></td>
                                <td class="align-middle"><?php echo htmlspecialchars($nk['nghenghiep']); ?></td>
                                <td class="align-middle"><?php echo htmlspecialchars($nk['noihientai']); ?></td>
                                <td class="align-middle"><?php echo htmlspecialchars($nk['noithuongtru']); ?></td>
                                <td class="align-middle"><?php echo htmlspecialchars($nk['lydo']); ?></td>
                                <td class="align-middle text-center">
                                    <button type="button" class="btn btn-sm btn-warning btn_sua_nhankhau" data-id="<?php echo $nk['id']; ?>">Sửa</button>
                                    <button type="button" class="btn btn-sm btn-danger btn_xoa_nhankhau" data-id="<?php echo $nk['id']; ?>">Xóa</button>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } ?>
                </tbody>
            </table>
            <table class="w-100">
                <tr>
                    <td class="text-center">
                        <button type="submit" id="btn_luu" class="btn btn-primary"><i class="fas fa-save"></i> Lưu</button>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <input type="hidden" name="id" value="<?php echo (int)$item['id']; ?>">
    <input type="hidden" name="<?php echo Session::getFormToken(); ?>" value="1">
    <style>
        .hideOpt {
            display: none !important;
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

        table.tableFixHead {
            border-collapse: collapse;
            max-width: 800px;
            overflow-x: scroll;
            display: block;
        }

        table.tableFixHead thead {
            background-color: #027be3;
        }

        table.tableFixHead thead,
        table.tableFixHead tbody {
            display: block;
        }

        table.tableFixHead tbody {
            overflow-y: scroll;
            overflow-x: hidden;
            height: 250px;
        }

        td.stt,
        th.stt {
            min-width: 50px;
            height: 25px;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 50px;
        }

        td.quanhe,
        th.quanhe {
            min-width: 150px;
            height: 25px;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 150px;
        }

        td.hoten,
        th.hoten {
            min-width: 220px;
            height: 25px;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 220px;
        }

        td.ngaysinh,
        th.ngaysinh {
            min-width: 140px;
            height: 25px;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 140px;
        }

        td.gioitinh,
        th.gioitinh {
            min-width: 150px;
            height: 25px;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 150px;
        }

        td.socccd,
        th.socccd {
            min-width: 140px;
            height: 25px;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 140px;
        }

        td.ngaycccd,
        th.ngaycccd {
            min-width: 140px;
            height: 25px;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 140px;
        }

        td.coquancapcccd,
        th.coquancapcccd {
            min-width: 220px;
            height: 25px;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 220px;
        }

        td.dienthoai,
        th.dienthoai {
            min-width: 140px;
            height: 25px;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 140px;
        }

        td.dantoc,
        th.dantoc {
            min-width: 150px;
            height: 25px;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 150px;
        }

        td.tongiao,
        th.tongiao {
            min-width: 150px;
            height: 25px;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 150px;
        }

        td.trinhdo,
        th.trinhdo {
            min-width: 150px;
            height: 25px;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 150px;
        }

        td.nghenghiep,
        th.nghenghiep {
            min-width: 150px;
            height: 25px;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 150px;
        }

        td.noihientai,
        th.noihientai {
            min-width: 150px;
            height: 25px;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 150px;
        }

        td.noithuongtru,
        th.noithuongtru {
            min-width: 1100px;
            height: 25px;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 1100px;
        }

        td.lydo,
        th.lydo {
            min-width: 150px;
            height: 25px;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 150px;
        }

        td.chucnang,
        th.chucnang {
            min-width: 100px;
            height: 25px;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 100px;
        }
    </style>
    <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
    <?php echo JHTML::_('form.token'); ?>
</form>
<script type="text/javascript">
    jQuery(document).ready(function($) {
        // Khởi tạo Bootstrap Datepicker
        $('#hokhau_ngaycap').datepicker({
            autoclose: true,
            language: 'vi'
        });

        // Khởi tạo Select2
        // if ($.fn.select2) {
        //     $('#thonto_id, #phuongxa_id').select2({
        //         width: '100%',
        //         allowClear: true,
        //         placeholder: function() {
        //             return $(this).data('placeholder');
        //         }
        //     });
        //     // Các select động sẽ được khởi tạo trong #btn_themnhankhau
        // }

        // Xử lý select Phường/Xã để tải Thôn/Tổ
        $('#phuongxa_id').on('change', function() {
            $('#tinhthanh_id').val($(this).find('option:selected').data('tinhthanh'));
            $('#quanhuyen_id').val($(this).find('option:selected').data('quanhuyen'));
            if ($(this).val() === '') {
                $('#thonto_id').html('<option value=""></option>').trigger('change');
            } else {
                $.post('index.php', {
                    option: 'com_vptk',
                    controller: 'vptk',
                    task: 'getKhuvucByIdCha',
                    cha_id: $(this).val(),
                    [Joomla.getOptions('csrf.token')]: 1
                }, function(data) {
                    var str = '<option value=""></option>';
                    if (data.length > 0) {
                        $.each(data, function(i, v) {
                            str += '<option value="' + v.id + '">' + v.tenkhuvuc + '</option>';
                        });
                    }
                    $('#thonto_id').html(str).trigger('change');
                }).fail(function() {
                    alert('Lỗi khi tải danh sách Thôn/Tổ');
                });
            }
        });

        // Xử lý nút Thêm nhân khẩu
        $('#btn_themnhankhau').on('click', function() {
            var stt = $('.stt').length + 1;
            var str = `
            <tr>
                <td class="align-middle text-center stt">${stt}</td>
                <td class="align-middle quanhe">
                    <div class="mb-3 div_quanhe">
                        <select name="quanhenhanthan_id[]" class="form-select" data-placeholder="Chọn quan hệ">
                            <option value=""></option>
                        </select>
                    </div>
                </td>
                <td class="align-middle hoten">
                    <div class="mb-3">
                        <input type="text" name="hoten[]" class="form-control hoten" placeholder="Nhập họ tên">
                    </div>
                </td>
                <td class="align-middle ngaysinh">
                    <div class="input-group mb-3">
                        <input type="text" name="ngaysinh[]" class="form-control date-picker" data-date-format="dd/mm/yyyy" placeholder="dd/mm/yyyy">
                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                    </div>
                </td>
                <td class="align-middle gioitinh">
                    <div class="mb-3 div_gioitinh">
                        <select name="gioitinh_id[]" class="form-select" data-placeholder="Chọn giới tính">
                            <option value=""></option>
                        </select>
                    </div>
                </td>
                <td class="align-middle socccd">
                    <div class="mb-3">
                        <input type="text" name="cccd_so[]" class="form-control cccd_so" placeholder="Nhập CMND/CCCD">
                    </div>
                </td>
                <td class="align-middle ngaycccd">
                    <div class="input-group mb-3">
                        <input type="text" name="cccd_ngaycap[]" class="form-control date-picker" data-date-format="dd/mm/yyyy" placeholder="dd/mm/yyyy">
                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                    </div>
                </td>
                <td class="align-middle coquancapcccd">
                    <div class="mb-3">
                        <input type="text" name="cccd_coquancap[]" class="form-control cccd_coquancap" placeholder="Nhập nơi cấp">
                    </div>
                </td>
                <td class="align-middle dienthoai">
                    <div class="mb-3">
                        <input type="text" name="dienthoai[]" class="form-control dienthoai" placeholder="Nhập điện thoại">
                    </div>
                </td>
                <td class="align-middle dantoc">
                    <div class="mb-3 div_dantoc">
                        <select name="dantoc_id[]" class="form-select" data-placeholder="Chọn dân tộc">
                            <option value=""></option>
                        </select>
                    </div>
                </td>
                <td class="align-middle tongiao">
                    <div class="mb-3 div_tongiao">
                        <select name="tongiao_id[]" class="form-select" data-placeholder="Chọn tôn giáo">
                            <option value=""></option>
                        </select>
                    </div>
                </td>
                <td class="align-middle trinhdo">
                    <div class="mb-3 div_trinhdo">
                        <select name="trinhdohocvan_id[]" class="form-select" data-placeholder="Chọn trình độ">
                            <option value=""></option>
                        </select>
                    </div>
                </td>
                <td class="align-middle nghenghiep">
                    <div class="mb-3 div_nghenghiep">
                        <select name="nghenghiep_id[]" class="form-select" data-placeholder="Chọn nghề nghiệp">
                            <option value=""></option>
                        </select>
                    </div>
                </td>
                <td class="align-middle noihientai">
                    <div class="mb-3 div_tamtru">
                        <select name="is_tamtru[]" class="form-select" data-placeholder="Chọn trạng thái">
                            <option value="0">Thường trú</option>
                            <option value="1">Tạm trú</option>
                        </select>
                    </div>
                </td>
                <td class="align-middle noithuongtru">
                    <div class="mb-3 div_is_tamtru" style="display:none;">
                        <select name="thuongtrucu_tinhthanh_id[]" class="form-select" data-placeholder="Chọn tỉnh/thành">
                            <option value=""></option>
                        </select>
                        <select name="thuongtrucu_quanhuyen_id[]" class="form-select" data-placeholder="Chọn quận/huyện">
                            <option value=""></option>
                        </select>
                        <select name="thuongtrucu_phuongxa_id[]" class="form-select" data-placeholder="Chọn phường/xã">
                            <option value=""></option>
                        </select>
                        <input type="text" name="thuongtrucu_diachi[]" class="form-control" placeholder="Nhập số nhà, tên đường, thôn/tổ dân phố">
                    </div>
                </td>
                <td class="align-middle lydo">
                    <div class="mb-3 div_lydo">
                        <select name="lydoxoathuongtru_id[]" class="form-select" data-placeholder="Chọn lý do">
                            <option value=""></option>
                        </select>
                    </div>
                </td>
                <td class="align-middle text-center chucnang">
                    <input type="hidden" name="nhankhau_id[]" value="" />
                    <button type="button" class="btn btn-sm btn-danger btn_xoa" data-xuly=""><i class="fas fa-minus"></i></button>
                </td>
            </tr>`;
            $('#tbodyDanhsach').append(str);

            // Khởi tạo Select2 cho các select mới
            if ($.fn.select2) {
                ['quanhenhanthan_id[]', 'gioitinh_id[]', 'dantoc_id[]', 'tongiao_id[]', 'trinhdohocvan_id[]', 'nghenghiep_id[]', 'is_tamtru[]', 'lydoxoathuongtru_id[]'].forEach(function(name) {
                    $(`select[name="${name}"]`).last().select2({
                        width: '100%',
                        allowClear: name === 'lydoxoathuongtru_id[]',
                        placeholder: function() {
                            return $(this).data('placeholder');
                        }
                    });
                });
                ['thuongtrucu_tinhthanh_id[]', 'thuongtrucu_quanhuyen_id[]', 'thuongtrucu_phuongxa_id[]'].forEach(function(name) {
                    $(`select[name="${name}"]`).last().select2({
                        width: '20%',
                        allowClear: true,
                        placeholder: function() {
                            return $(this).data('placeholder');
                        }
                    });
                });
            }

            // Khởi tạo Datepicker cho các input mới
            if ($.fn.datepicker) {
                $('.date-picker').last().datepicker({
                    startDate: "01/01/1900",
                    endDate: "01/01/3000",
                    autoclose: true,
                    format: "dd/mm/yyyy"
                }).next().on('click', function() {
                    $(this).prev().focus();
                });
            }
        });

        // Xử lý xóa nhân khẩu
        $('body').on('click', '.btn_xoa', function() {
            var $row = $(this).closest('tr');
            var row_index = $('.btn_xoa').index($(this));
            var nhankhau_id = $(this).data('xuly');
            if (nhankhau_id) {
                bootbox.confirm({
                    title: "<span class='text-danger' style='font-weight:bold;font-size:20px;'>Thông báo</span>",
                    message: '<span class="text-danger" style="font-size:24px;">Bạn có chắc chắn muốn xóa nhân khẩu này?</span>',
                    buttons: {
                        confirm: {
                            label: '<i class="fas fa-check"></i> Đồng ý',
                            className: 'btn-success'
                        },
                        cancel: {
                            label: '<i class="fas fa-times"></i> Không',
                            className: 'btn-danger'
                        }
                    },
                    callback: function(result) {
                        if (result) {
                            $.post('index.php', {
                                option: 'com_vptk',
                                controller: 'nhk',
                                task: 'delNhankhau',
                                nhankhau_id: nhankhau_id,
                                [Joomla.getOptions('csrf.token')]: 1
                            }, function(data) {
                                if (data === '1') {
                                    $row.remove();
                                    $('.stt').each(function(i) {
                                        if (i > 0) $(this).html(i);
                                    });
                                    $.gritter.add({
                                        title: '<h3>Thông báo</h3>',
                                        text: '<span style="font-size:24px;">Đã xử lý xóa dữ liệu thành công!</span>',
                                        time: 1000,
                                        class_name: 'gritter-success gritter-center gritter-light'
                                    });
                                } else {
                                    $.gritter.add({
                                        title: '<h3>Thông báo</h3>',
                                        text: '<span style="font-size:24px;">Có lỗi xảy ra!!! Vui lòng liên hệ quản trị viên.</span>',
                                        time: 1000,
                                        class_name: 'gritter-error gritter-center gritter-light'
                                    });
                                }
                            }).fail(function() {
                                $.gritter.add({
                                    title: '<h3>Thông báo</h3>',
                                    text: '<span style="font-size:24px;">Lỗi kết nối server!</span>',
                                    time: 1000,
                                    class_name: 'gritter-error gritter-center gritter-light'
                                });
                            });
                        }
                    }
                });
            } else {
                $row.remove();
                $('.stt').each(function(i) {
                    if (i > 0) $(this).html(i);
                });
            }
        });

        // Xử lý select is_tamtru
        $('body').on('change', 'select[name="is_tamtru[]"]', function() {
            var row_index = $('select[name="is_tamtru[]"]').index($(this));
            $('.div_is_tamtru').eq(row_index).toggle($(this).val() === '1');
        });

        // Xử lý select thuongtrucu_tinhthanh_id
        $('body').on('change', 'select[name="thuongtrucu_tinhthanh_id[]"]', function() {
            var row_index = $('select[name="thuongtrucu_tinhthanh_id[]"]').index($(this));
            var $quanhuyen = $('select[name="thuongtrucu_quanhuyen_id[]"]').eq(row_index);
            var $phuongxa = $('select[name="thuongtrucu_phuongxa_id[]"]').eq(row_index);
            var $diachi = $('input[name="thuongtrucu_diachi[]"]').eq(row_index);
            if ($(this).val() === '') {
                $quanhuyen.html('<option value=""></option>').trigger('change').select2("container").show();
                $phuongxa.select2("container").show();
                $diachi.attr('placeholder', 'Nhập số nhà, tên đường, thôn/tổ dân phố');
            } else if ($(this).val() === '-1') {
                $quanhuyen.select2("container").hide();
                $phuongxa.select2("container").hide();
                $diachi.attr('placeholder', 'Nhập số nhà, tên đường, thôn/tổ dân phố, phường/xã, quận/huyện, tỉnh/thành');
            } else {
                $quanhuyen.select2("container").show();
                $phuongxa.select2("container").show();
                $diachi.attr('placeholder', 'Nhập số nhà, tên đường, thôn/tổ dân phố');
                $.post('index.php', {
                    option: 'com_vptk',
                    controller: 'ajax',
                    task: 'getQuanHuyenByTinhThanh',
                    tinhthanh_id: $(this).val(),
                    [Joomla.getOptions('csrf.token')]: 1
                }, function(data) {
                    var str = '<option value=""></option><option value="-1">Khác</option>';
                    if (data.length > 0) {
                        $.each(data, function(i, v) {
                            str += '<option value="' + v.id + '">' + v.tenquanhuyen + '</option>';
                        });
                    }
                    $quanhuyen.html(str).trigger('change');
                }).fail(function() {
                    alert('Lỗi khi tải danh sách Quận/Huyện');
                });
            }
        });

        // Xử lý select thuongtrucu_quanhuyen_id
        $('body').on('change', 'select[name="thuongtrucu_quanhuyen_id[]"]', function() {
            var row_index = $('select[name="thuongtrucu_quanhuyen_id[]"]').index($(this));
            var $phuongxa = $('select[name="thuongtrucu_phuongxa_id[]"]').eq(row_index);
            var $diachi = $('input[name="thuongtrucu_diachi[]"]').eq(row_index);
            if ($(this).val() === '') {
                $phuongxa.html('<option value=""></option>').trigger('change').select2("container").show();
                $diachi.attr('placeholder', 'Nhập số nhà, tên đường, thôn/tổ dân phố');
            } else if ($(this).val() === '-1') {
                $phuongxa.select2("container").hide();
                $diachi.attr('placeholder', 'Nhập số nhà, tên đường, thôn/tổ dân phố, phường/xã, quận/huyện');
            } else {
                $phuongxa.select2("container").show();
                $diachi.attr('placeholder', 'Nhập số nhà, tên đường, thôn/tổ dân phố');
                $.post('index.php', {
                    option: 'com_vptk',
                    controller: 'ajax',
                    task: 'getPhuongXaByQuanHuyen',
                    quanhuyen_id: $(this).val(),
                    [Joomla.getOptions('csrf.token')]: 1
                }, function(data) {
                    var str = '<option value=""></option><option value="-1">Khác</option>';
                    if (data.length > 0) {
                        $.each(data, function(i, v) {
                            str += '<option value="' + v.id + '">' + v.tenphuongxa + '</option>';
                        });
                    }
                    $phuongxa.html(str).trigger('change');
                }).fail(function() {
                    alert('Lỗi khi tải danh sách Phường/Xã');
                });
            }
        });

        // Xử lý select thuongtrucu_phuongxa_id
        $('body').on('change', 'select[name="thuongtrucu_phuongxa_id[]"]', function() {
            var row_index = $('select[name="thuongtrucu_phuongxa_id[]"]').index($(this));
            var $diachi = $('input[name="thuongtrucu_diachi[]"]').eq(row_index);
            $diachi.attr('placeholder', $(this).val() === '-1' ?
                'Nhập số nhà, tên đường, thôn/tổ dân phố, phường/xã' :
                'Nhập số nhà, tên đường, thôn/tổ dân phố');
        });

        // Xử lý nút Quay lại
        $('#btn_quaylai').on('click', function() {
            window.location.href = '/index.php/component/vptk/?view=nhk&task=default';
        });

        // Xử lý jQuery Validation
        if ($.fn.validate) {
            $('#frmNhanhokhau').validate({
                ignore: [],
                invalidHandler: function(form, validator) {
                    var errors = validator.numberOfInvalids();
                    if (errors) {
                        var message = errors === 1 ?
                            'Kiểm tra lỗi sau:<br/>' :
                            'Phát hiện ' + errors + ' lỗi sau:<br/>';
                        var errorsList = '';
                        if (validator.errorList.length > 0) {
                            for (var x = 0; x < validator.errorList.length; x++) {
                                errorsList += '<br/>\u25CF ' + validator.errorList[x].message;
                            }
                        }
                        $.gritter.add({
                            title: '<h3>Thông báo</h3>',
                            text: '<span style="font-size:24px;">' + message + errorsList + '</span>',
                            time: 2000,
                            class_name: 'gritter-error gritter-center gritter-light'
                        });
                    }
                    validator.focusInvalid();
                },
                errorPlacement: function(error, element) {
                    error.appendTo(element.closest('.mb-3'));
                },
                rules: {
                    phuongxa_id: {
                        required: true
                    },
                    thonto_id: {
                        required: true
                    },
                    diachi: {
                        required: true
                    },
                    'quanhenhanthan_id[]': {
                        required: true
                    },
                    'hoten[]': {
                        required: true,
                        regex: /^[^~`!@#$%\^&*()+=\-\[\]\\';,/{}|\\":<>\?]*$/
                    },
                    'gioitinh_id[]': {
                        required: true
                    },
                    'cccd_so[]': {
                        required: true
                    },
                    'cccd_coquancap[]': {
                        required: true
                    },
                    'dantoc_id[]': {
                        required: true
                    },
                    'thuongtrucu_tinhthanh_id[]': {
                        required: function(element) {
                            var row_index = $('select[name="thuongtrucu_tinhthanh_id[]"]').index($(element));
                            return $('select[name="is_tamtru[]"]').eq(row_index).val() === '1';
                        }
                    },
                    'thuongtrucu_diachi[]': {
                        required: function(element) {
                            var row_index = $('input[name="thuongtrucu_diachi[]"]').index($(element));
                            var is_tamtru = $('select[name="is_tamtru[]"]').eq(row_index).val() === '1';
                            var tinhthanh = $('select[name="thuongtrucu_tinhthanh_id[]"]').eq(row_index).val();
                            var quanhuyen = $('select[name="thuongtrucu_quanhuyen_id[]"]').eq(row_index).val();
                            var phuongxa = $('select[name="thuongtrucu_phuongxa_id[]"]').eq(row_index).val();
                            return is_tamtru && (tinhthanh === '-1' || quanhuyen === '-1' || phuongxa === '-1');
                        }
                    }
                },
                messages: {
                    phuongxa_id: 'Chọn Phường/Xã',
                    thonto_id: 'Chọn Thôn/Tổ',
                    diachi: 'Nhập địa chỉ',
                    'quanhenhanthan_id[]': 'Chọn quan hệ với chủ hộ',
                    'hoten[]': {
                        required: 'Nhập họ tên nhân khẩu',
                        regex: 'Họ tên không được chứa ký tự đặc biệt'
                    },
                    'gioitinh_id[]': 'Chọn giới tính nhân khẩu',
                    'cccd_so[]': 'Nhập số CMND/CCCD',
                    'cccd_coquancap[]': 'Nhập nơi cấp CMND/CCCD',
                    'dantoc_id[]': 'Chọn dân tộc',
                    'thuongtrucu_tinhthanh_id[]': 'Chọn Tỉnh/Thành nơi thường trú trước khi chuyển đến',
                    'thuongtrucu_diachi[]': 'Nhập số nhà, tên đường, thôn/tổ dân phố nơi thường trú trước khi chuyển đến'
                }
            });

            // Thêm phương thức regex
            $.validator.addMethod('regex', function(value, element, regexp) {
                return this.optional(element) || regexp.test(value);
            }, 'Họ tên không được chứa ký tự đặc biệt.');
        }

        // Xử lý nút Lưu
        $('#btn_luu').on('click', function(e) {
            e.preventDefault();
            if ($.fn.validate && $('#frmNhanhokhau').valid()) {
                document.frmNhanhokhau.submit();
            }
        });
    });
</script>