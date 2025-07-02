<?php
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;

// Get database object
$db = Factory::getDbo();

// Replace Core::loadAssocList with Joomla 5 database query
function loadAssocList($table, $columns, $where)
{
    $db = Factory::getDbo();
    $query = $db->getQuery(true)
        ->select($columns)
        ->from($db->quoteName($table))
        ->where($where);
    $db->setQuery($query);
    return $db->loadAssocList();
}

$items = $this->thongtinthietche;
$thongtinthietbi = $this->thongtinthietbi;
$loaithietbi = loadAssocList('danhmuc_loaithietbi', 'id,ten,ma', 'trangthai = 1 AND daxoa = 0');
$tenthietbi = loadAssocList('danhmuc_thietbi', 'id, id_loaithietbi, tenthietbi, donvitinh', 'trangthai = 1 AND daxoa = 0');

$id = $thongtinthietbi[0]['id_thietche'] ?? 0;

?>

<form id="frmThongTinThietChe" name="frmThongTinThietChe" method="post" action="index.php?option=com_vhytgd&task=thongtinthietche.saveThongTinThietChe" style="font-size:14px;">
    <input name="id" type="hidden" value="<?php echo $items[0]['id'] ?? ''; ?>" />
    <div class="container-fluid px-3">
        <h2 class="mb-3 text-primary" style="margin-bottom: 0 !important;line-height:2">
            <?php echo ((int)($items[0]['id'] ?? 0) > 0) ? "Hiệu chỉnh" : "Thêm mới"; ?> thông tin các thiết chế văn hóa, trung tâm văn hóa, các khu công viên, ...
            <span class="float-right">
                <button type="button" id="btn_quaylai" class="btn btn-secondary" style="font-size:18px;"><i class="fas fa-arrow-left"></i> Quay lại</button>
                <button type="submit" id="btn_luu" class="btn btn-primary"><i class="fas fa-save"></i> Lưu</button>

            </span>
        </h2>
        <table class="table w-100" style="margin-bottom: 15px;" id="tblThongtin">
            <tr>
                <td colspan="6">
                    <h3 class="mb-0 fw-bold">Thông tin thiết chế văn hóa</h3>
                </td>
            </tr>
            <tbody>
                <tr>
                    <td class="align-middle">
                        <div class="mb-3" style="margin-bottom: 0rem !important;">
                            <strong>Phường/Xã <span class="text-danger">*</span></strong>
                            <select id="phuongxa_id" name="phuongxa_id" class="custom-select" data-placeholder="Chọn phường/xã">
                                <option value="" data-quanhuyen="" data-tinhthanh=""></option>
                                <?php if (is_array($this->phuongxa) && count($this->phuongxa) == 1) { ?>
                                    <option value="<?php echo $this->phuongxa[0]['id']; ?>" selected data-quanhuyen="<?php echo $this->phuongxa[0]['quanhuyen_id']; ?>" data-tinhthanh="<?php echo $this->phuongxa[0]['tinhthanh_id']; ?>"><?php echo htmlspecialchars($this->phuongxa[0]['tenkhuvuc']); ?></option>
                                <?php } elseif (is_array($this->phuongxa)) { ?>
                                    <?php foreach ($this->phuongxa as $px) { ?>
                                        <option value="<?php echo $px['id']; ?>" <?php echo ($item[0]['phuongxa_id'] == $px['id']) ? 'selected' : ''; ?> data-quanhuyen="<?php echo $px['quanhuyen_id']; ?>" data-tinhthanh="<?php echo $px['tinhthanh_id']; ?>"><?php echo htmlspecialchars($px['tenkhuvuc']); ?></option>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                            <label class="error_modal" for="phuongxa_id"></label>
                        </div>
                    </td>
                    <td class="align-middle">
                        <div class="mb-3">
                            <strong>Tên thiết chế</strong>
                            <div class="input-group">
                                <input type="text" id="thietche_ten" autocomplete="off" name="thietche_ten" class="form-control" value="<?php echo htmlspecialchars($item['thietche_ten']); ?>" placeholder="Nhập tên thiết chế">
                            </div>
                        </div>
                    </td>
                    <td class="align-middle">
                        <div class="mb-3">
                            <strong>Diện tích</strong>
                            <div class="input-group">
                                <input type="number" id="thietche_dientich" autocomplete="off" name="thietche_dientich" class="form-control" value="<?php echo htmlspecialchars($item['thietche_dientich']); ?>" placeholder="Nhập tên thiết chế">
                            </div>
                        </div>
                    </td>

                </tr>
                <tr class="w-100">
                    <td style="vertical-align:middle;width:10.2%;"><strong>Vị trí:</strong></td>
                    <td style="width:27%;padding-left:0;padding-right:18px;">
                        <div class="mb-3">
                            <input type="text" id="thietche_vitri" name="thietche_vitri" value="<?php echo htmlspecialchars($items[0]['thietche_vitri'] ?? ''); ?>" class="form-control" />
                        </div>
                    </td>
                    <td style="vertical-align:middle;width:11%;"><strong>Loại hình thiết chế: <span class="text-danger">*</span></strong></td>
                    <td style="vertical-align:middle;padding-left:0;padding-right:11px;width:24.5%;">
                        <div class="mb-3">
                            <select id="loaihinhthietche_id" name="loaihinhthietche_id" class="form-select">
                                <option value="">-- Chọn loại hình --</option>
                                <?php foreach ($this->loaihinhthietche ?? [] as $gt): ?>
                                    <option value="<?php echo $gt['id']; ?>" <?php echo ($items[0]['loaihinhthietche_id'] ?? '') == $gt['id'] ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($gt['tenloaihinhthietche']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </td>
                    <td style="vertical-align:middle;width:8.9%;"><strong>Trạng thái: <span class="text-danger">*</span></strong></td>
                    <td style="vertical-align:middle;width:23%;">
                        <div class="mb-3">
                            <select id="trangthaihoatdong_id" name="trangthaihoatdong_id" class="form-select">
                                <option value="">-- Chọn trạng thái --</option>
                                <?php foreach ([1 => 'Đang xây dựng', 2 => 'Đang sửa chữa', 3 => 'Đang sử dụng'] as $value => $label): ?>
                                    <option value="<?php echo $value; ?>" <?php echo ($items[0]['trangthaihoatdong_id'] ?? '') == $value ? 'selected' : ''; ?>>
                                        <?php echo $label; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

        <h3 class="row lighter"><b>Thông tin thiết bị</b></h3>
        <div class="float-end mb-3">
            <button type="button" id="btn-themthongtinthietbi" class="btn btn-success btn-lg">Thêm mới thông tin thiết bị</button>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-bordered" id="tblDanhsachthietbi">
                <thead>
                    <tr class="table-primary">
                        <th style="min-width:70px;" class="text-center" rowspan="2">Loại thiết bị</th>
                        <th style="min-width:219px;" class="text-center" rowspan="2">Tên thiết bị</th>
                        <th style="min-width:86px;" class="text-center" rowspan="2">Đơn vị tính</th>
                        <th style="min-width:94px;" class="text-center" rowspan="2">Số lượng</th>
                        <th style="min-width:220px;" class="text-center" rowspan="2">Ghi chú</th>
                        <th class="text-center" rowspan="2">Chức năng</th>
                    </tr>
                </thead>
                <tbody id="dsThietbi">
                    <?php if (!empty($thongtinthietbi)): ?>
                        <?php foreach ($thongtinthietbi as $thietbi): ?>
                            <tr class="thietbi_<?php echo $thietbi['id']; ?>">
                                <td>
                                    <select name="loaithietbi[]" class="loaithietbi form-select">
                                        <?php foreach ($loaithietbi as $ltb): ?>
                                            <option value="<?php echo $ltb['id']; ?>" <?php echo $thietbi['id_loaithietbi'] == $ltb['id'] ? 'selected' : ''; ?>>
                                                <?php echo htmlspecialchars($ltb['ten']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                                <td>
                                    <select name="tenthietbi[]" class="tenthietbi form-select">
                                        <?php foreach ($tenthietbi as $ttb): ?>
                                            <option value="<?php echo $ttb['id']; ?>" <?php echo $thietbi['id_thietbi'] == $ttb['id'] ? 'selected' : ''; ?>>
                                                <?php echo htmlspecialchars($ttb['tenthietbi']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                                <td>
                                    <input type="text" value="<?php echo htmlspecialchars($thietbi['donvitinh']); ?>" class="form-control donvitinh" name="donvitinh[]" readonly>
                                </td>
                                <td>
                                    <input type="text" value="<?php echo htmlspecialchars($thietbi['soluong']); ?>" class="form-control soluong" name="soluong[]" />
                                </td>
                                <td>
                                    <input type="text" value="<?php echo htmlspecialchars($thietbi['ghichu']); ?>" class="form-control ghichu" name="ghichu_thietbi[]" />
                                </td>
                                <td class="text-center">
                                    <input type="hidden" name="id_thietbi[]" value="<?php echo $thietbi['id']; ?>" />
                                    <button type="button" class="btn btn-danger btn_xoa_thietbi" data-id="<?php echo $thietbi['id']; ?>"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr class="thietbi_0">
                            <td>
                                <select name="loaithietbi[]" class="loaithietbi form-select">
                                    <option value="0">-- Chọn loại thiết bị --</option>
                                    <?php foreach ($loaithietbi as $ltb): ?>
                                        <option value="<?php echo $ltb['id']; ?>"><?php echo htmlspecialchars($ltb['ten']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                            <td>
                                <select name="tenthietbi[]" class="tenthietbi form-select">
                                    <option value="0">-- Chọn tên thiết bị --</option>
                                </select>
                            </td>
                            <td>
                                <input type="text" class="form-control donvitinh" name="donvitinh[]" readonly>
                            </td>
                            <td>
                                <input type="text" class="form-control soluong" name="soluong[]" />
                            </td>
                            <td>
                                <input type="text" class="form-control ghichu" name="ghichu_thietbi[]" />
                            </td>
                            <td class="text-center">
                                <input type="hidden" name="id_thietbi[]" value="0" />
                                <button type="button" class="btn btn-danger btn_xoa_thietbi"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <h3 class="row lighter"><b>Thông tin hoạt động</b></h3>
        <div class="float-end mb-3">
            <button type="button" id="btn-themnamhoatdong" class="btn btn-success btn-lg">Thêm mới thông tin hoạt động</button>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-bordered" id="tblDanhsach">
                <thead>
                    <tr class="table-primary">
                        <th style="min-width:70px;" class="text-center" rowspan="2">Năm</th>
                        <th colspan="7">
                            <table class="w-100">
                                <tr class="table-primary">
                                    <th style="min-width:219px;" class="text-center" rowspan="2">Nội dung hoạt động</th>
                                    <th style="min-width:220px;" class="text-center" colspan="2">Thời gian diễn ra hoạt động</th>
                                    <th style="min-width:149px;" class="text-center" rowspan="2">Nguồn kinh phí</th>
                                    <th style="min-width:94px;" class="text-center" rowspan="2">Kinh phí</th>
                                    <th style="min-width:220px;" class="text-center" rowspan="2">Ghi chú</th>
                                    <th style="min-width:95px;" class="text-center" rowspan="2">Chức năng</th>
                                </tr>
                                <tr class="table-primary">
                                    <th style="min-width:110px;" class="text-center">Từ ngày</th>
                                    <th style="min-width:110px;" class="text-center">Đến ngày</th>
                                </tr>
                            </table>
                        </th>
                    </tr>
                </thead>
                <tbody id="dsHoatDong">
                    <?php
                    $thongtinhoatdong = $this->thongtinhoatdong ?? [];
                    $thongtinnamhoatdong = $this->thongtinnamhoatdong ?? [];

                    if (!empty($thongtinhoatdong)):
                        foreach ($thongtinnamhoatdong as $iss => $namhd):
                    ?>
                            <tr class="dshoatdong_<?php echo ($iss + 1); ?> dshoatdong_<?php echo $namhd['nam']; ?>">
                                <td class="text-center" rowspan="">
                                    <input disabled type="text" value="<?php echo htmlspecialchars($namhd['nam']); ?>" class="form-control yearpicker yearpicker_<?php echo ($iss + 1); ?>" name="nam_hoatdong[]" />
                                </td>
                                <?php foreach ($thongtinhoatdong as $hd): ?>
                                    <?php if ($namhd['nam'] == $hd['nam']): ?>
                                        <td class="td_hoatdong_<?php echo ($iss + 1); ?> td_hoatdong_<?php echo $hd['is_cha']; ?>" colspan="7" style="padding:0;">
                                            <table class="w-100">
                                                <tbody class="tbodyHoatDong">
                                                    <tr class="tr_hoatdong">
                                                        <input type="hidden" name="nam_hoatdong[]" value="<?php echo htmlspecialchars($hd['nam']); ?>" />
                                                        <td class="text-center">
                                                            <input type="text" value="<?php echo htmlspecialchars($hd['noidunghoatdong']); ?>" class="form-control" name="noidung_hoatdong[]" />
                                                        </td>
                                                        <td class="text-center">
                                                            <input type="text" value="<?php echo date('d/m/Y', strtotime($hd['thoigianhoatdong_tungay'])); ?>" class="form-control date-picker" name="tungay_hoatdong[]" data-date-format="dd/mm/yyyy" autocomplete="off" />
                                                        </td>
                                                        <td class="text-center">
                                                            <input type="text" value="<?php echo date('d/m/Y', strtotime($hd['thoigianhoatdong_denngay'])); ?>" class="form-control date-picker" name="denngay_hoatdong[]" data-date-format="dd/mm/yyyy" autocomplete="off" />
                                                        </td>
                                                        <td class="text-center">
                                                            <select name="nguonkinhphi[]" class="form-select">
                                                                <option value="0">-- Chọn nguồn kinh phí --</option>
                                                                <option value="1" <?php echo $hd['nguonkinhphi_id'] == 1 ? 'selected' : ''; ?>>Tự chủ</option>
                                                                <option value="2" <?php echo $hd['nguonkinhphi_id'] == 2 ? 'selected' : ''; ?>>Đầu tư</option>
                                                            </select>
                                                        </td>
                                                        <td class="text-center">
                                                            <input type="text" value="<?php echo number_format($hd['kinhphi']); ?>" class="form-control" name="kinhphi[]" />
                                                        </td>
                                                        <td class="text-center">
                                                            <input type="text" value="<?php echo htmlspecialchars($hd['ghichu']); ?>" class="form-control" name="ghichu_hoatdong[]" />
                                                        </td>
                                                        <td class="text-center">
                                                            <input type="hidden" value="<?php echo $hd['is_cha']; ?>" name="is_cha[]" />
                                                            <input type="hidden" name="hoatdong_id[]" value="<?php echo $hd['id']; ?>" />
                                                            <?php if ((int)$hd['is_cha'] == 1): ?>
                                                                <button type="button" data-to="31/12/<?php echo $hd['nam']; ?>" data-from="01/01/<?php echo $hd['nam']; ?>" data-level="<?php echo $hd['is_cha']; ?>" data-stt="<?php echo $iss + 1; ?>" data-class="year_" data-nam="<?php echo $hd['nam']; ?>" data-id="<?php echo $hd['id']; ?>" title="Thêm thông tin trong năm" class="btn btn-outline-secondary btn-themnoidunghoatdong btn-themnoidunghoatdong_<?php echo ($iss + 1); ?>"><i class="fas fa-plus"></i></button>
                                                                <button type="button" data-stt="<?php echo $iss + 1; ?>" data-level="<?php echo $hd['is_cha']; ?>" data-id="<?php echo $namhd['array_id']; ?>" class="btn btn-danger btn_xoanam"><i class="fas fa-trash"></i></button>
                                                            <?php else: ?>
                                                                <button type="button" data-stt="<?php echo $iss + 1; ?>" data-level="<?php echo $hd['is_cha']; ?>" data-id="<?php echo $hd['id']; ?>" class="btn btn-danger btn_xoanam"><i class="fas fa-trash"></i></button>
                                                            <?php endif; ?>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr class="dshoatdong_1">
                            <td class="text-center" rowspan="1">
                                <input type="text" class="form-control yearpicker yearpicker_1" name="nam_hoatdong[]" />
                            </td>
                            <td class="td_hoatdong" colspan="7" style="padding:0;">
                                <table class="w-100">
                                    <tbody class="tbodyHoatDong_1">
                                        <tr class="tr_hoatdong">
                                            <td class="text-center">
                                                <input type="text" class="form-control" name="noidung_hoatdong[]" />
                                            </td>
                                            <td class="text-center">
                                                <input type="text" class="form-control date-picker from_1" name="tungay_hoatdong[]" data-date-format="dd/mm/yyyy" autocomplete="off" />
                                            </td>
                                            <td class="text-center">
                                                <input type="text" class="form-control date-picker to_1" name="denngay_hoatdong[]" data-date-format="dd/mm/yyyy" autocomplete="off" />
                                            </td>
                                            <td class="text-center">
                                                <select name="nguonkinhphi[]" class="form-select">
                                                    <option value="0">-- Chọn nguồn kinh phí --</option>
                                                    <option value="1">Tự chủ</option>
                                                    <option value="2">Đầu tư</option>
                                                </select>
                                            </td>
                                            <td class="text-center">
                                                <input type="text" class="form-control" name="kinhphi[]" />
                                            </td>
                                            <td class="text-center">
                                                <input type="text" class="form-control" name="ghichu_hoatdong[]" />
                                            </td>
                                            <td class="text-center">
                                                <input type="hidden" value="1" name="is_cha[]" />
                                                <input type="hidden" name="hoatdong_id[]" value="" />
                                                <button type="button" data-to="" data-from="" data-stt="1" data-class="year_" data-nam="" title="Thêm thông tin trong năm" class="btn btn-outline-secondary btn-themnoidunghoatdong btn-themnoidunghoatdong_1"><i class="fas fa-plus"></i></button>
                                                <button type="button" data-stt="1" data-id="" data-level="1" class="btn btn-danger btn_xoanam"><i class="fas fa-trash"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <table class="w-100">
                <tr>
                    <td class="text-center">
                        <input type="hidden" name="id_thietche" value="<?php echo $items[0]['id'] ?? ''; ?>" />
                        <button type="button" id="btn_luu" class="btn btn-primary" style="width:110px;font-size:18px;"><i class="fas fa-save"></i> Lưu</button>
                    </td>
                </tr>
            </table>
        </div>
        <?php echo HTMLHelper::_('form.token'); ?>
</form>

<style>
    .error {
        outline: none;
        border: 1px solid #dc3545 !important;
        color: #dc3545 !important;
    }

    .select2-container--default .select2-selection--single {
        border: 1px solid #ced4da !important;
        height: 38px !important;
    }

    .select2-selection__rendered {
        line-height: 38px !important;
    }

    .select2-selection__arrow {
        height: 38px !important;
    }

    .table-responsive {
        overflow-x: auto;
    }

    .table {
        border-collapse: collapse;
    }

    .table th,
    .table td {
        vertical-align: middle;
    }

    .form-control,
    .form-select {
        height: 38px;
        border-radius: 0;
    }

    .date-picker {
        height: 38px !important;
    }

    .btn {
        line-height: 1.5 !important;
    }

    .yearpicker {
        width: 100px;
    }

    .control-group {
        margin-bottom: 0.5rem !important;
    }
</style>

<script>
    jQuery(document).ready(function($) {
        // Initialize Select2
        $('#phuongxa_id, #thonto_id, #gioitinh_id, #tinhtrang_id, #congviechientai_id, #phuongxagioithieu_id').select2({
            width: '100%',
            allowClear: true,
            placeholder: function() {
                return $(this).data('placeholder') || 'Chọn';
            }
        });

        // Initialize Datepicker
        $('.date-picker').datepicker({
            autoclose: true,
            todayHighlight: true,
            dateFormat: 'dd/mm/yy'
        });

        // Initialize Yearpicker
        $('.yearpicker').datepicker({
            format: 'yyyy',
            viewMode: 'years',
            minViewMode: 'years',
            autoclose: true
        });

        // Format currency
        function formatNumber(n) {
            return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }

        function formatCurrency(input, blur) {
            let input_val = input.val();
            if (input_val === "") return;
            let original_len = input_val.length;
            let caret_pos = input.prop("selectionStart");
            if (input_val.indexOf(".") >= 0) {
                let decimal_pos = input_val.indexOf(".");
                let left_side = input_val.substring(0, decimal_pos);
                let right_side = input_val.substring(decimal_pos);
                left_side = formatNumber(left_side);
                right_side = formatNumber(right_side).substring(0, 2);
                input_val = left_side + "." + right_side;
                if (blur === "blur") right_side += "";
            } else {
                input_val = formatNumber(input_val);
                if (blur === "blur") input_val += "";
            }
            input.val(input_val);
            let updated_len = input_val.length;
            caret_pos = updated_len - original_len + caret_pos;
            input[0].setSelectionRange(caret_pos, caret_pos);
        }

        $("input[data-type='currency_1']").on({
            keyup: function() {
                formatCurrency($(this));
            },
            blur: function() {
                formatCurrency($(this), "blur");
            }
        });

        // Handle loaithietbi change
        const thongtinthietbi = <?php echo json_encode($tenthietbi); ?>;
        $('#tblDanhsachthietbi').on('change', '.loaithietbi', function() {
            const selectedLoaiThietBi = $(this).val();
            const row = $(this).closest('tr');
            const tenthietbiSelect = row.find('.tenthietbi');
            const donvitinhInput = row.find('.donvitinh');
            tenthietbiSelect.empty().append('<option value="0">-- Chọn tên thiết bị --</option>');
            thongtinthietbi.forEach(item => {
                if (item.id_loaithietbi == selectedLoaiThietBi) {
                    tenthietbiSelect.append(`<option value="${item.id}">${item.tenthietbi}</option>`);
                    donvitinhInput.val(item.donvitinh);
                }
            });
        });

        // Handle phuongxa_id change
        $('#phuongxa_id').on('change', function() {
            $('#tinhthanh_id').val($(this).find('option:selected').data('tinhthanh'));
            $('#quanhuyen_id').val($(this).find('option:selected').data('quanhuyen'));
            if ($(this).val() == '') {
                $('#thonto_id').html('<option value=""></option>').trigger('change');
            } else {
                $.post('index.php?option=com_vhytgd&task=ajax.getKhuvucByIdCha', {
                    cha_id: $(this).val(),
                    '<?php echo HTMLHelper::_('form.token'); ?>': 1
                }, function(data) {
                    let str = '<option value=""></option>';
                    data.forEach(v => {
                        str += `<option value="${v.id}">${v.tenkhuvuc}</option>`;
                    });
                    $('#thonto_id').html(str).trigger('change');
                });
            }
        });

        // Handle btn_quaylai
        $('#btn_quaylai').on('click', function() {
            window.location.href = 'index.php?option=com_vhytgd&task=thongtinthietche.default';
        });

        // Add new equipment row
        $('#btn-themthongtinthietbi').on('click', function() {
            const stt = $('#tblDanhsachthietbi tbody tr').length + 1;
            const newRow = `
            <tr class="thietbi_${stt}">
                <td>
                    <select name="loaithietbi[]" class="loaithietbi form-select">
                        <option value="0">-- Chọn loại thiết bị --</option>
                        <?php foreach ($loaithietbi as $ltb): ?>
                            <option value="<?php echo $ltb['id']; ?>"><?php echo htmlspecialchars($ltb['ten']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
                <td>
                    <select name="tenthietbi[]" class="tenthietbi form-select">
                        <option value="0">-- Chọn tên thiết bị --</option>
                    </select>
                </td>
                <td><input type="text" class="form-control donvitinh" name="donvitinh[]" readonly></td>
                <td><input type="text" class="form-control soluong" name="soluong[]" /></td>
                <td><input type="text" class="form-control ghichu" name="ghichu_thietbi[]" /></td>
                <td class="text-center">
                    <input type="hidden" name="id_thietbi[]" value="0" />
                    <button type="button" class="btn btn-danger btn_xoa_thietbi" data-id="${stt}"><i class="fas fa-trash"></i></button>
                </td>
            </tr>`;
            $('#tblDanhsachthietbi tbody').append(newRow);
        });

        // Add new activity year
        $('#btn-themnamhoatdong').on('click', function() {
            const stt = $('#dsHoatDong tr').length + 1;
            const namHtml = `
            <tr class="dshoatdong_${stt}">
                <td class="text-center">
                    <input type="text" class="form-control yearpicker yearpicker_${stt}" name="nam_hoatdong[]" />
                </td>
                <td class="td_hoatdong td_hoatdong_1" colspan="7" style="padding:0;">
                    <table class="w-100">
                        <tbody class="tbodyHoatDong_${stt}">
                            <tr class="tr_hoatdong">
                                <td class="text-center">
                                    <input type="text" class="form-control" name="noidung_hoatdong[]" />
                                </td>
                                <td class="text-center">
                                    <input type="text" class="form-control date-picker from_${stt}" name="tungay_hoatdong[]" data-date-format="dd/mm/yyyy" autocomplete="off" />
                                </td>
                                <td class="text-center">
                                    <input type="text" class="form-control date-picker to_${stt}" name="denngay_hoatdong[]" data-date-format="dd/mm/yyyy" autocomplete="off" />
                                </td>
                                <td class="text-center">
                                    <select name="nguonkinhphi[]" class="form-select">
                                        <option value="0">-- Chọn nguồn kinh phí --</option>
                                        <option value="1">Tự chủ</option>
                                        <option value="2">Đầu tư</option>
                                    </select>
                                </td>
                                <td class="text-center">
                                    <input type="text" class="form-control" name="kinhphi[]" />
                                </td>
                                <td class="text-center">
                                    <input type="text" class="form-control" name="ghichu_hoatdong[]" />
                                </td>
                                <td class="text-center">
                                    <input type="hidden" name="hoatdong_id[]" value="" />
                                    <input type="hidden" value="1" name="is_cha[]" />
                                    <button type="button" data-to="" data-from="" data-stt="${stt}" data-class="year_" data-nam="" title="Thêm thông tin trong năm" class="btn btn-outline-secondary btn-themnoidunghoatdong btn-themnoidunghoatdong_${stt}"><i class="fas fa-plus"></i></button>
                                    <button type="button" data-stt="${stt}" data-id="" data-level="1" class="btn btn-danger btn_xoanam"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>`;
            $('#dsHoatDong').append(namHtml);
            $(`.yearpicker_${stt}`).datepicker({
                format: 'yyyy',
                viewMode: 'years',
                minViewMode: 'years',
                autoclose: true
            });
            $(`.date-picker`).datepicker({
                autoclose: true,
                todayHighlight: true,
                dateFormat: 'dd/mm/yy'
            });
            $(`.yearpicker_${stt}`).on('change', function() {
                const nam = $(this).val();
                const d = new Date();
                const month = ('0' + (d.getMonth() + 1)).slice(-2);
                const day = ('0' + d.getDate()).slice(-2);
                $(`.btn-themnoidunghoatdong_${stt}`).attr('data-nam', nam);
                $(`.dshoatdong_${stt} #nam_hoatdong`).val(nam);
                $(`.from_${stt}`).val(`${day}/${month}/${nam}`);
                $(`.to_${stt}`).val(`${new Date(nam, 11, 31).getDate()}/12/${nam}`);
                $(`.btn-themnoidunghoatdong_${stt}`).attr('data-from', `${day}/${month}/${nam}`);
                $(`.btn-themnoidunghoatdong_${stt}`).attr('data-to', `${new Date(nam, 11, 31).getDate()}/12/${nam}`);
            });
        });

        // Add new activity row
        $('body').on('click', '.btn-themnoidunghoatdong', function() {
            const stt = $(this).data('stt');
            const namHtml = `
            <td class="td_hoatdong_${stt} td_hoatdong_0" colspan="7" style="padding:0;">
                <table class="w-100">
                    <tbody class="tbodyHoatDong_${stt}">
                        <tr class="tr_hoatdong">
                            <td class="text-center">
                                <input type="hidden" value="${$(this).data('nam')}" name="nam_hoatdong[]" />
                                <input type="text" class="form-control" name="noidung_hoatdong[]" />
                            </td>
                            <td class="text-center">
                                <input type="text" value="${$(this).data('from')}" class="form-control date-picker from_${stt}" name="tungay_hoatdong[]" data-date-format="dd/mm/yyyy" autocomplete="off" />
                            </td>
                            <td class="text-center">
                                <input type="text" value="${$(this).data('to')}" class="form-control date-picker to_${stt}" name="denngay_hoatdong[]" data-date-format="dd/mm/yyyy" autocomplete="off" />
                            </td>
                            <td class="text-center">
                                <select name="nguonkinhphi[]" class="form-select">
                                    <option value="0">-- Chọn nguồn kinh phí --</option>
                                    <option value="1">Tự chủ</option>
                                    <option value="2">Đầu tư</option>
                                </select>
                            </td>
                            <td class="text-center">
                                <input type="text" class="form-control" name="kinhphi[]" />
                            </td>
                            <td class="text-center">
                                <input type="text" class="form-control" name="ghichu_hoatdong[]" />
                            </td>
                            <td class="text-center">
                                <input type="hidden" name="hoatdong_id[]" value="" />
                                <input type="hidden" value="0" name="is_cha[]" />
                                <button type="button" data-stt="${stt}" data-id="" data-level="0" class="btn btn-danger btn_xoanam"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>`;
            $(`.dshoatdong_${stt}`).append(namHtml);
            $(`.date-picker`).datepicker({
                autoclose: true,
                todayHighlight: true,
                dateFormat: 'dd/mm/yy'
            });
        });

        // Delete equipment
        $('#tblDanhsachthietbi').on('click', '.btn_xoa_thietbi', function() {
            const idThietBi = $(this).data('id');
            if (idThietBi) {
                bootbox.confirm({
                    title: "<span class='text-danger' style='font-weight:bold;font-size:20px;'>Thông báo</span>",
                    message: "<span style='font-size:24px;'>Bạn có chắc chắn muốn xóa thiết bị này?</span>",
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
                            $.ajax({
                                url: 'index.php?option=com_vhytgd&task=thongtinthietche.removeThongTinThietBi',
                                type: 'POST',
                                dataType: 'json',
                                data: {
                                    id_thietbi: idThietBi,
                                    '<?php echo HTMLHelper::_('form.token'); ?>': 1
                                },
                                success: function(response) {
                                    if (response.success) {
                                        $(`.thietbi_${idThietBi}`).remove();
                                        alert('Xóa thành công');
                                    } else {
                                        alert('Xóa không thành công');
                                    }
                                },
                                error: function(xhr, status, error) {
                                    alert('Lỗi khi gửi yêu cầu AJAX: ' + error);
                                }
                            });
                        }
                    }
                });
            } else {
                $(this).closest('tr').remove();
            }
        });

        // Delete activity
        $('body').on('click', '.btn_xoanam', function() {
            const stt = $(this).data('stt');
            const id = $(this).data('id');
            const level = $(this).data('level');
            if (id) {
                bootbox.confirm({
                    title: "<span class='text-danger' style='font-weight:bold;font-size:20px;'>Thông báo</span>",
                    message: "<span style='font-size:24px;'>Bạn có chắc chắn muốn xóa chương trình này?</span>",
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
                            $.ajax({
                                url: 'index.php?option=com_vhytgd&task=thongtinthietche.removeHoatDongThietChe',
                                type: 'POST',
                                dataType: 'json',
                                data: {
                                    hoatdong_id: id,
                                    '<?php echo HTMLHelper::_('form.token'); ?>': 1
                                },
                                success: function(response) {
                                    if (response.success) {
                                        if (level == 0) {
                                            $(`.td_hoatdong_${stt}.td_hoatdong_0`).remove();
                                        } else {
                                            $(`.dshoatdong_${stt}`).remove();
                                        }
                                        alert('Xóa thành công');
                                    } else {
                                        alert('Xóa không thành công');
                                    }
                                },
                                error: function(xhr, status, error) {
                                    alert('Lỗi khi gửi yêu cầu AJAX: ' + error);
                                }
                            });
                        }
                    }
                });
            } else {
                if (level == 0) {
                    $(`.td_hoatdong_${stt}.td_hoatdong_0`).remove();
                } else {
                    $(`.dshoatdong_${stt}`).remove();
                }
            }
        });

        // Form validation
        $('#frmThongTinThietChe').validate({
            ignore: [],
            errorPlacement: function(error, element) {
                if (element.is('select')) {
                    element.next('.select2-container').addClass('error');
                } else {
                    element.addClass('error');
                }
            },
            rules: {
                loaihinhthietche_id: {
                    required: true
                },
                phuongxa_id: {
                    required: true
                },
                thietche_ten: {
                    required: true
                },
                trangthaihoatdong_id: {
                    required: true
                },
                "nguoidaidien[]": {
                    required: function(element) {
                        const row_index = $('select[name="nguoidaidien[]"]').index($(element));
                        return !$('select[name="nguoidaidien[]"]').eq(row_index).val();
                    }
                },
                "chucvu_id[]": {
                    required: function(element) {
                        const row_index = $('select[name="chucvu_id[]"]').index($(element));
                        return !$('select[name="chucvu_id[]"]').eq(row_index).val();
                    }
                },
                "tinhtrangchucvu_id[]": {
                    required: function(element) {
                        const row_index = $('select[name="tinhtrangchucvu_id[]"]').index($(element));
                        return !$('select[name="tinhtrangchucvu_id[]"]').eq(row_index).val();
                    }
                },
                "nam_hoatdong[]": {
                    required: function(element) {
                        const row_index = $('input[name="nam_hoatdong[]"]').index($(element));
                        return !$('input[name="nam_hoatdong[]"]').eq(row_index).val();
                    }
                },
                "noidung_hoatdong[]": {
                    required: function(element) {
                        const row_index = $('input[name="noidung_hoatdong[]"]').index($(element));
                        return !$('input[name="noidung_hoatdong[]"]').eq(row_index).val();
                    }
                },
                "nguonkinhphi[]": {
                    required: true
                },
                "kinhphi[]": {
                    required: function(element) {
                        const row_index = $('input[name="kinhphi[]"]').index($(element));
                        return !$('input[name="kinhphi[]"]').eq(row_index).val();
                    }
                }
            },
            messages: {
                loaihinhthietche_id: "Chọn loại hình thiết chế",
                phuongxa_id: "Chọn phường xã",
                thietche_ten: "Nhập tên thiết chế",
                trangthaihoatdong_id: "Chọn trạng thái hoạt động",
                "nguoidaidien[]": "Chọn người đại diện",
                "chucvu_id[]": "Chọn chức vụ",
                "tinhtrangchucvu_id[]": "Chọn trạng thái chức vụ",
                "nam_hoatdong[]": "Chọn năm hoạt động",
                "noidung_hoatdong[]": "Nhập nội dung hoạt động",
                "nguonkinhphi[]": "Chọn nguồn kinh phí",
                "kinhphi[]": "Nhập kinh phí"
            },
            submitHandler: function(form) {
                form.submit();
            }
        });

        $('#btn_luu').on('click', function() {
            $('#frmThongTinThietChe').submit();
        });
    });
</script>