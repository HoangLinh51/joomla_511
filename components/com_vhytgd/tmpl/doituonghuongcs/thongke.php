<?php
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Uri\Uri;


$idUser = Factory::getApplication()->getIdentity()->id;
?>
<meta>
<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/bootstrap-datepicker/locales/bootstrap-datepicker.vi.min.js" type="text/javascript"></script>
<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/jquery/jquery-validation/jquery.validate.js" type="text/javascript"></script>
<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/jquery/jquery-validation/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/jquery/jquery-validation/additional-methods.min.js" type="text/javascript"></script>
<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/jquery/jquery.toast.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
</meta>
<form action="index.php" method="post" id="frmThongKe" name="frmThongKe" class="form-horizontal" style="font-size:16px;">
    <div class="container-fluid" style="padding-left:20px; padding-right:20px;">
        <div class="content-header">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h3 class="m-0 text-primary"><i class="fas fa-chart-bar"></i> Thống kê đối tượng hưởng chính sách</h3>
                </div>
            </div>
        </div>
        <!-- <h2 class="header smaller lighter text-primary"><i class="fas fa-chart-bar"></i> Thống kê</h2> -->
        <div id="main-right">
            <div class="card card-primary">

                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-search"></i> Tiêu chí thống kê</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-action="reload"><i class="fas fa-sync-alt"></i></button>
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-chevron-up"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <table class="w-100">
                        <tr>
                            <td style="width:5%;padding:10px;" nowrap><b class="text-primary" style="font-size:18px;">Phường xã</b></td>
                            <td style="width:45%;">
                                <select id="phuongxa_id" name="phuongxa_id" class="custom-select" data-placeholder="Chọn phường xã">
                                    <option value=""></option>
                                    <?php foreach ($this->phuongxa as $px) { ?>
                                        <option value="<?php echo $px['id']; ?>"><?php echo $px['tenkhuvuc']; ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                            <td style="width:5%;padding:10px;" nowrap><b class="text-primary" style="font-size:18px;">Thôn tổ</b></td>
                            <td style="width:45%;">
                                <select id="thonto_id" name="thonto_id" class="custom-select" data-placeholder="Chọn thôn/tổ" multiple>
                                    <option value=""></option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td style="width:5%;padding:10px;" nowrap><b class="text-primary" style="font-size:17px;line-height:2.5">Từ năm</b></td>
                            <td style="width:45%;">
                                <input type="text" name="nam_from" id="nam_from" class="form-control yearpicker" style="font-size:16px;" placeholder="Chọn năm" />
                            </td>
                            <td style="width:5%;padding:10px;" nowrap><b class="text-primary" style="font-size:17px;line-height:2.5">Đến năm</b></td>
                            <td style="width:45%;">
                                <input type="text" name="nam_to" id="nam_to" class="form-control yearpicker" style="font-size:16px;" placeholder="Chọn năm" />
                            </td>
                        </tr>
                        <tr>
                            <td style="width:5%;padding:10px;" nowrap><b class="text-primary" style="font-size:18px;">Từ tháng</b></td>
                            <td style="width:45%;">
                                <select id="thang_from" name="thang_from" class="custom-select" data-placeholder="Chọn tháng">
                                    <option value=""></option>
                                    <option value=""></option>
                                    <option value="1">Tháng 1</option>
                                    <option value="2">Tháng 2</option>
                                    <option value="3">Tháng 3</option>
                                    <option value="4">Tháng 4</option>
                                    <option value="5">Tháng 5</option>
                                    <option value="6">Tháng 6</option>
                                    <option value="7">Tháng 7</option>
                                    <option value="8">Tháng 8</option>
                                    <option value="9">Tháng 9</option>
                                    <option value="10">Tháng 10</option>
                                    <option value="11">Tháng 11</option>
                                    <option value="12">Tháng 12</option>
                                </select>
                            </td>
                            <td style="width:5%;padding:10px;" nowrap><b class="text-primary" style="font-size:18px;">Đến tháng</b></td>
                            <td style="width:45%;">
                                <select id="thang_to" name="thang_to" class="custom-select" data-placeholder="Chọn tháng">
                                    <option value=""></option>
                                    <option value=""></option>
                                    <option value="1">Tháng 1</option>
                                    <option value="2">Tháng 2</option>
                                    <option value="3">Tháng 3</option>
                                    <option value="4">Tháng 4</option>
                                    <option value="5">Tháng 5</option>
                                    <option value="6">Tháng 6</option>
                                    <option value="7">Tháng 7</option>
                                    <option value="8">Tháng 8</option>
                                    <option value="9">Tháng 9</option>
                                    <option value="10">Tháng 10</option>
                                    <option value="11">Tháng 11</option>
                                    <option value="12">Tháng 12</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td style="width:5%;padding:10px;" nowrap><b class="text-primary" style="font-size:18px;">Loại đối tượng</b></td>
                            <td colspan="4" style="width:45%;">
                                <select id="loaidoituong_id" name="loaidoituong_id" class="custom-select" data-placeholder="Chọn loại đối tượng">
                                    <option value=""></option>
                                    <?php foreach ($this->loaidoituong as $ldt) { ?>
                                        <option value="<?php echo $ldt['id']; ?>"><?php echo $ldt['ten']; ?></option>
                                    <?php } ?>
                                </select>
                            </td>

                        </tr>
                        <tr>
                            <td colspan="4" class="text-center" style="padding-top:10px;">
                                <button class="btn btn-primary" id="btn_filter"><i class="fas fa-search"></i>Thống kê</button>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div id="div_danhsach"></div>
        </div>
        <?php echo HTMLHelper::_('form.token'); ?>
    </div>
</form>

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

    .form-select {
        height: 38px;
        font-size: 15px;
    }

    .select2-container .select2-choice {
        height: 34px !important;
    }

    .select2-container .select2-choice .select2-chosen {
        height: 34px !important;
        padding: 5px 0 0 5px !important;
    }

    .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background-color: #007b8b;
        color: #fff
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        border-radius: 4px;
        cursor: default;
        float: left;
        padding: 0 10px;
        color: #181616;
    }

    .select2-container .select2-selection--single {
        height: 38px;
    }
</style>



<script>
    jQuery(document).ready(function($) {
        // Xử lý sự kiện click trên card-header
        $('.card-header').on('click', function(e) {
            if (!$(e.target).closest('.card-tools').length) {
                $(this).find('[data-card-widget="collapse"]').trigger('click');
            }
        });
        $('.yearpicker').datepicker({
            format: 'yyyy',
            viewMode: 'years',
            minViewMode: 'years',
            language: 'vi',
            autoclose: true
        });
        // Khởi tạo Select2
        $('#phuongxa_id, #thonto_id, #thang_from, #thang_to, #loaidoituong_id').select2({
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
            const phuongxaId = $('#phuongxa_id').val();
            const thontoIds = $('#thonto_id').val() || []; // Mảng hoặc rỗng
            const thontoValue = Array.isArray(thontoIds) ? thontoIds.join(',') : '';
            if (namFrom === null || namTo === null) {
                alert('Vui lòng chọn năm trước khi Thống kê');
                return; // Ngừng thực hiện nếu không có năm
            }

            var namFrom = $('#nam_from').val() ? parseInt($('#nam_from').val()) : null;
            var namTo = $('#nam_to').val() ? parseInt($('#nam_to').val()) : null;
            var thangFrom = $('#thang_from').val() ? parseInt($('#thang_from').val()) : null;
            var thangTo = $('#thang_to').val() ? parseInt($('#thang_to').val()) : null;
            if (namFrom > namTo) {
                alert('Vui lòng chọn năm hợp lệ: "Đến năm" phải lớn hơn hoặc bằng "Từ năm".');
                return; // Ngừng thực hiện nếu điều kiện không thỏa mãn
            }

            // Kiểm tra điều kiện tháng
            if (thangFrom !== null && thangTo !== null && thangFrom > thangTo) {
                alert('Vui lòng chọn tháng hợp lệ: "Từ tháng" phải nhỏ hơn hoặc bằng "Đến tháng".');
                return; // Ngừng thực hiện nếu điều kiện không thỏa mãn
            }

            if (!phuongxaId) {
                showToast('Vui lòng chọn phường xã!', false);
                return; // Dừng thực hiện nếu không chọn
            }

            $("#overlay").fadeIn(300);
            $('#div_danhsach').load('index.php', {
                option: 'com_vhytgd',
                view: 'doituonghuongcs',
                format: 'raw',
                task: 'DS_THONGKE',
                phuongxa_id: phuongxaId,
                thonto_id: thontoValue,
                nam_from: namFrom,
                nam_to: namTo,
                thang_from: thangFrom,
                thang_to: thangTo,
                loaidoituong_id: $('#loaidoituong_id').val(),
                start: start
            }, function(response, status, xhr) {
                $("#overlay").fadeOut(300);
                if (status === "error") {
                    console.error('Error loading danh sach: ', xhr.status, xhr.statusText);
                }
            });
        }

        // Xử lý nút Thống kê
        $('#btn_filter').on('click', function(e) {
            e.preventDefault();
            loadDanhSach();
        });

        // Hàm hiển thị thông báo
        function showToast(message, isSuccess = true) {
            const toast = jQuery('<div></div>').text(message).css({
                position: 'fixed',
                top: '20px',
                right: '20px',
                background: isSuccess ? '#28a745' : '#dc3545',
                color: '#fff',
                padding: '10px 20px',
                borderRadius: '5px',
                boxShadow: '0 0 10px rgba(0,0,0,0.3)',
                zIndex: 9999,
                transition: 'opacity 0.5s'
            }).appendTo('body');
            setTimeout(() => toast.fadeOut(500, () => toast.remove()), 2000);
        }

        $('body').delegate('.btn_hieuchinh', 'click', function() {
            window.location.href = 'index.php?option=com_vptk&view=nhk&task=edit_nhk&id=' + $(this).data('hokhau');
        });
        $('#btn_xuatexcel').on('click', function() {
            let params = {
                option: 'com_vptk',
                controller: 'vptk',
                task: 'exportExcel',
                phuongxa_id: $('#phuongxa_id').val() || '',
                hoten: $('#hoten').val() || '',
                gioitinh_id: $('#gioitinh_id').val() || '',
                is_tamtru: $('#is_tamtru').val() || '',
                thonto_id: $('#thonto_id').val() || '',
                hokhau_so: $('#hokhau_so').val() || '',
                cccd_so: $('#cccd_so').val() || '',
                diachi: $('#diachi').val() || '',
                daxoa: 0,
                [Joomla.getOptions('csrf.token')]: 1 // Thêm CSRF token
            };

            // Tạo URL đúng
            let url = Joomla.getOptions('system.paths').base + '/index.php?' + $.param(params);
            window.location.href = url;
        });
    });
</script>