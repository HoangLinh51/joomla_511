<?php
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Uri\Uri;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Session\Session;

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
// var_dump($items);exit;
$thongtinthietbi = $this->thongtinthietbi;
$loaithietbi = loadAssocList('danhmuc_loaithietbi', 'id,ten,ma', 'trangthai = 1 AND daxoa = 0');
$tenthietbi = loadAssocList('danhmuc_thietbi', 'id, id_loaithietbi, tenthietbi, donvitinh', 'trangthai = 1 AND daxoa = 0');

$id = $thongtinthietbi[0]['id_thietche'] ?? 0;

?>
<meta>
<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/bootstrap-datepicker/locales/bootstrap-datepicker.vi.min.js" type="text/javascript"></script>
</meta>

<form id="frmThongTinThietChe" name="frmThongTinThietChe" method="post" action="index.php?option=com_vhytgd&controller=thietche&task=saveThongTinThietChe" style="font-size:14px;">
    <input name="id" type="hidden" value="<?php echo $items[0]['id'] ?? ''; ?>" />
    <div class="container-fluid px-3">
        <h2 class="mb-3 text-primary" style="margin-bottom: 0 !important;line-height:2">
            <?php echo ((int)($items[0]['id'] ?? 0) > 0) ? "Hiệu chỉnh" : "Thêm mới"; ?> thông tin các thiết chế
            <span class="float-right">
                <button type="button" id="btn_quaylai" class="btn btn-secondary" style="font-size:18px;"><i class="fas fa-arrow-left"></i> Quay lại</button>
                <input type="hidden" name="id_thietche" value="<?php echo $items[0]['id'] ?>" />

                <button type="submit" id="btn_luu" class="btn btn-primary"><i class="fas fa-save"></i> Lưu</button>

            </span>
        </h2>
        <table class="table w-100" style="margin-bottom: 15px;" id="tblThongtin">
            <tbody>
                <tr>
                    <td colspan="3">
                        <h3 class="mb-0 fw-bold">Thông tin thiết chế văn hóa</h3>
                    </td>
                </tr>
                <tr>
                    <td class="align-middle" style="width: 33.33%;">
                        <div class="mb-3">
                            <strong>Phường/Xã <span class="text-danger">*</span></strong>
                            <select id="phuongxa_id" name="phuongxa_id" class="custom-select" data-placeholder="Chọn phường/xã">
                                <option value="" data-quanhuyen="" data-tinhthanh=""></option>
                                <?php if (is_array($this->phuongxa) && count($this->phuongxa) == 1) { ?>
                                    <option value="<?php echo $this->phuongxa[0]['id']; ?>" selected data-quanhuyen="<?php echo $this->phuongxa[0]['quanhuyen_id']; ?>" data-tinhthanh="<?php echo $this->phuongxa[0]['tinhthanh_id']; ?>"><?php echo htmlspecialchars($this->phuongxa[0]['tenkhuvuc']); ?></option>
                                <?php } elseif (is_array($this->phuongxa)) { ?>
                                    <?php foreach ($this->phuongxa as $px) { ?>
                                        <option value="<?php echo $px['id']; ?>" <?php echo ($items[0]['phuongxa_id'] == $px['id']) ? 'selected' : ''; ?> data-quanhuyen="<?php echo $px['quanhuyen_id']; ?>" data-tinhthanh="<?php echo $px['tinhthanh_id']; ?>"><?php echo htmlspecialchars($px['tenkhuvuc']); ?></option>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                            <label class="error_modal" for="phuongxa_id"></label>
                        </div>
                    </td>
                    <td class="align-middle" style="width: 33.33%;">
                        <div class="mb-3">
                            <strong>Vị trí</strong>
                            <input type="text" id="thietche_vitri" name="thietche_vitri" value="<?php echo htmlspecialchars($items[0]['thietche_vitri']); ?>" class="form-control" placeholder="Nhập vị trí">
                            <label class="error_modal" for="thietche_vitri"></label>
                        </div>
                    </td>

                    <td class="align-middle" style="width: 33.33%;">
                        <div class="mb-3">
                            <strong>Diện tích</strong>
                            <input type="number"
                                id="thietche_dientich"
                                autocomplete="off"
                                name="thietche_dientich"
                                class="form-control"
                                value="<?php echo htmlspecialchars(number_format($items[0]['thietche_dientich'], 0, ',', '.')); ?>"
                                placeholder="Nhập diện tích">
                            <label class="error_modal" for="thietche_dientich"></label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="align-middle" style="width: 33.33%;">
                        <div class="mb-3">
                            <strong>Tên thiết chế <span class="text-danger">*</span></strong>
                            <input type="text" id="thietche_ten" name="thietche_ten" value="<?php echo htmlspecialchars($items[0]['thietche_ten']); ?>" class="form-control" placeholder="Nhập số nhà, tên đường">
                            <label class="error_modal" for="thietche_ten"></label>
                        </div>
                    </td>
                    <td class="align-middle" style="width: 33.33%;">
                        <div class="mb-3">
                            <strong>Loại hình thiết chế <span class="text-danger">*</span></strong>
                            <select id="loaihinhthietche_id" name="loaihinhthietche_id" class="custom-select">
                                <option value="">-- Chọn loại hình --</option>
                                <?php foreach ($this->loaihinhthietche ?? [] as $gt): ?>
                                    <option value="<?php echo $gt['id']; ?>" <?php echo ($items[0]['loaihinhthietche_id'] ?? '') == $gt['id'] ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($gt['tenloaihinhthietche']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <label class="error_modal" for="loaihinhthietche_id"></label>
                        </div>
                    </td>
                    <td class="align-middle" style="width: 33.33%;">
                        <div class="mb-3">
                            <strong>Trạng thái <span class="text-danger">*</span></strong>
                            <select id="trangthaihoatdong_id" name="trangthaihoatdong_id" class="custom-select">
                                <option value="">-- Chọn trạng thái --</option>
                                <?php foreach ([1 => 'Đang xây dựng', 2 => 'Đang sửa chữa', 3 => 'Đang sử dụng'] as $value => $label): ?>
                                    <option value="<?php echo $value; ?>" <?php echo ($items[0]['trangthaihoatdong_id'] ?? '') == $value ? 'selected' : ''; ?>>
                                        <?php echo $label; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <label class="error_modal" for="trangthaihoatdong_id"></label>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <h3 style="padding-left:15px ;" class="mb-0 fw-bold">Thông tin thiết bị

            <span class="float-right">
                <button type="button" class="btn btn-primary" id="btn-themthongtinthietbi"><i class="fas fa-plus"></i> Thêm mới thông tin thiết bị</button>
            </span>
        </h3>

        <div style="padding-left: 10px;" class="table-responsive">
            <table class="table table-striped table-bordered table-hover" id="tblDanhsachthietbi">
                <thead>
                    <tr class="bg-primary text-white">
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
                                    <select name="loaithietbi[]" class="loaithietbi custom-select">
                                        <?php foreach ($loaithietbi as $ltb): ?>
                                            <option value="<?php echo $ltb['id']; ?>" <?php echo $thietbi['id_loaithietbi'] == $ltb['id'] ? 'selected' : ''; ?>>
                                                <?php echo htmlspecialchars($ltb['ten']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                                <td>
                                    <select name="tenthietbi[]" class="tenthietbi custom-select">
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
                                    <button type="button" class="btn btn-danger btn_xoa_thietbi" data-id="<?php echo $thietbi['id']; ?>"><i class="fas fa-trash-alt"></i></button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr class="thietbi_0">
                            <td>
                                <select id="loaithietbi" name="loaithietbi[]" class="loaithietbi custom-select">
                                    <option value="0">-- Chọn loại thiết bị --</option>
                                    <?php foreach ($loaithietbi as $ltb): ?>
                                        <option value="<?php echo $ltb['id']; ?>"><?php echo htmlspecialchars($ltb['ten']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                            <td>
                                <select id="tenthietbi" name="tenthietbi[]" class="tenthietbi custom-select">
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
                                <button type="button" class="btn btn-danger btn_xoa_thietbi"><i class="fas fa-trash-alt"></i></button>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <h3 style="padding-left:15px;" class="mb-0 fw-bold">Thông tin hoạt động
            <span class="float-right">
                <button type="button" class="btn btn-primary" id="btn-themnamhoatdong"><i class="fas fa-plus"></i> Thêm năm hoạt động</button>
            </span>
        </h3>

        <div style="padding-left: 10px;" class="table-responsive">
            <table class="table table-striped table-bordered table-hover" id="tblHoatDong">
                <thead>
                    <tr class="bg-primary text-white">
                        <th style="min-width:70px;" class="text-center" rowspan="2">Năm</th>
                        <th style="min-width:219px;" class="text-center" rowspan="2">Nội dung hoạt động</th>
                        <th style="min-width:220px;" class="text-center" colspan="2">Thời gian diễn ra hoạt động</th>
                        <th style="min-width:149px;" class="text-center" rowspan="2">Nguồn kinh phí</th>
                        <th style="min-width:94px;" class="text-center" rowspan="2">Kinh phí</th>
                        <th style="min-width:220px;" class="text-center" rowspan="2">Ghi chú</th>
                        <th style="min-width:95px;" class="text-center" rowspan="2">Chức năng</th>
                    </tr>
                    <tr class="bg-primary text-white">
                        <th style="min-width:110px;" class="text-center">Từ ngày</th>
                        <th style="min-width:110px;" class="text-center">Đến ngày</th>
                    </tr>
                </thead>
                <tbody id="dsHoatDong">
                    <?php
                    $thongtinhoatdong = $this->thongtinhoatdong ?? [];
                    $thongtinnamhoatdong = $this->thongtinnamhoatdong ?? [];
                    $groupIndexCounter = 0;

                    if (!empty($thongtinnamhoatdong)):
                        foreach ($thongtinnamhoatdong as $namhd):
                            $groupIndexCounter++;
                            // Lọc ra các hoạt động chỉ thuộc năm hiện tại
                            $activitiesInYear = array_filter($thongtinhoatdong, function ($hd) use ($namhd) {
                                return $hd['nam'] == $namhd['nam'];
                            });
                            $rowspan = count($activitiesInYear);
                    ?>
                            <?php foreach ($activitiesInYear as $index => $hd): ?>
                                <tr class="year-group-<?php echo $groupIndexCounter; ?>">
                                    <?php if ($index === array_key_first($activitiesInYear)): // Chỉ hiển thị ô 'Năm' cho hàng đầu tiên của nhóm 
                                    ?>
                                        <td class="text-center year-cell" style="width:11%" rowspan="<?php echo $rowspan; ?>" data-group-index="<?php echo $groupIndexCounter; ?>">
                                            <input type="text" value="<?php echo htmlspecialchars($namhd['nam']); ?>" class="form-control yearpicker yearpicker_<?php echo $groupIndexCounter; ?>" name="nam_hoatdong[<?php echo $groupIndexCounter; ?>]" />
                                        </td>
                                    <?php endif; ?>

                                    <td class="text-center"><input type="text" value="<?php echo htmlspecialchars($hd['noidunghoatdong']); ?>" class="form-control" name="noidung_hoatdong[<?php echo $groupIndexCounter; ?>][]" /></td>
                                    <td class="text-center" style="width:11%"><input type="text" value="<?php echo date('d/m/Y', strtotime($hd['thoigianhoatdong_tungay'])); ?>" class="form-control date-picker" name="tungay_hoatdong[<?php echo $groupIndexCounter; ?>][]" autocomplete="off" /></td>
                                    <td class="text-center" style="width:11%"><input type="text" value="<?php echo date('d/m/Y', strtotime($hd['thoigianhoatdong_denngay'])); ?>" class="form-control date-picker" name="denngay_hoatdong[<?php echo $groupIndexCounter; ?>][]" autocomplete="off" /></td>
                                    <td class="text-center">
                                        <select id="nguonkinhphi" name="nguonkinhphi[<?php echo $groupIndexCounter; ?>][]" class="custom-select">
                                            <option value="0">-- Chọn --</option>
                                            <option value="1" <?php echo $hd['nguonkinhphi_id'] == 1 ? 'selected' : ''; ?>>Tự chủ</option>
                                            <option value="2" <?php echo $hd['nguonkinhphi_id'] == 2 ? 'selected' : ''; ?>>Đầu tư</option>
                                        </select>
                                    </td>
                                    <td class="text-center" style="width:15%">
                                        <input type="text"
                                            value="<?php echo htmlspecialchars($hd['kinhphi']); ?>"
                                            class="form-control"
                                            name="kinhphi[<?php echo $groupIndexCounter; ?>][]" />
                                    </td>
                                    <td class="text-center"><input type="text" value="<?php echo htmlspecialchars($hd['ghichu']); ?>" class="form-control" name="ghichu_hoatdong[<?php echo $groupIndexCounter; ?>][]" /></td>
                                    <td class="text-center">
                                        <input type="hidden" value="<?php echo $hd['id']; ?>" name="hoatdong_id[<?php echo $groupIndexCounter; ?>][]" />
                                        <button type="button" class="btn btn-danger btn_xoa_hoatdong" data-group-id="<?php echo $groupIndexCounter; ?>" data-id="<?php echo $hd['id']; ?>"><i class="fas fa-trash-alt"></i></button>
                                        <!-- <?php if ($index === array_key_first($activitiesInYear)): ?>
                                            <button type="button" data-group-id="<?php echo $groupIndexCounter; ?>" title="Thêm hoạt động" class="btn btn-outline-secondary btn-themnoidunghoatdong"><i class="fas fa-plus"></i></button>
                                        <?php endif; ?> -->
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php echo HTMLHelper::_('form.token'); ?>
</form>

<style>
    .error_modal {
        display: block;
        color: #dc3545;
        /* Màu đỏ cho thông báo lỗi */
        font-size: 0.875rem;
        /* Kích thước chữ nhỏ hơn */
        margin-top: 0.25rem;
        /* Khoảng cách phía trên */
        overflow-wrap: break-word;
        /* Ngắt từ nếu thông báo quá dài */
        max-width: 100%;
        /* Không vượt quá chiều rộng của div.mb-3 */
    }

    .custom-select {
        width: 100%;
        box-sizing: border-box;
    }

    /* Cố định chiều rộng cột trong bảng */
    table tbody tr td {
        vertical-align: middle;
        padding: 10px;
    }

    /* Tùy chọn: Cố định chiều rộng cột cụ thể */
    td:nth-child(1) {
        /* Cột Phường/Xã */
        width: 33.33%;
        /* Hoặc giá trị cụ thể như 300px */
    }

    td:nth-child(2) {
        /* Cột Tên thiết chế */
        width: 33.33%;
    }

    td:nth-child(3) {
        /* Cột Diện tích, Vị trí, Loại hình, Trạng thái */
        width: 33.33%;
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

    .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background-color: #007b8b;
        color: #fff
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
    .custom-select {
        height: 38px;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 28px !important;
        padding-left: 8px;
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
        $('#phuongxa_id, #thonto_id, #gioitinh_id, #trangthaihoatdong_id, #loaithietbi, #loaihinhthietche_id, #tenthietbi, #nguonkinhphi').select2({
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
            dateFormat: 'dd/mm/yy',
            language: 'vi'

        });

        // Initialize Yearpicker
        $('.yearpicker').datepicker({
            format: 'yyyy',
            viewMode: 'years',
            minViewMode: 'years',
            language: 'vi',
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
            window.location.href = '/index.php/component/vhytgd/?view=thongtinthietche&task=default';
        });

        // Add new equipment row
        $('#btn-themthongtinthietbi').on('click', function() {
            const stt = $('#tblDanhsachthietbi tbody tr').length + 1;
            const newRow = `
            <tr class="thietbi_${stt}">
                <td>
                    <select id="loaithietbi" name="loaithietbi[]" class="loaithietbi custom-select">
                        <option value="0">-- Chọn loại thiết bị --</option>
                        <?php foreach ($loaithietbi as $ltb): ?>
                            <option value="<?php echo $ltb['id']; ?>"><?php echo htmlspecialchars($ltb['ten']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
                <td>
                    <select name="tenthietbi[]" class="tenthietbi custom-select">
                        <option value="0">-- Chọn tên thiết bị --</option>
                    </select>
                </td>
                <td><input type="text" class="form-control donvitinh" name="donvitinh[]" readonly></td>
                <td><input type="text" class="form-control soluong" name="soluong[]" /></td>
                <td><input type="text" class="form-control ghichu" name="ghichu_thietbi[]" /></td>
                <td class="text-center">
                    <input type="hidden" name="id_thietbi[]" value="0" />
                    <button type="button" class="btn btn-danger btn_xoa_thietbi" data-id="${stt}"><i class="fas fa-trash-alt"></i></button>
                </td>
            </tr>`;
            $('#tblDanhsachthietbi tbody').append(newRow);
        });

        function initializeDatepickers(context) {
            // Year picker
            $('.yearpicker', context).not('.hasDatepicker').datepicker({
                format: 'yyyy',
                viewMode: 'years',
                minViewMode: 'years',
                autoclose: true,
                language: 'vi',
            }).addClass('hasDatepicker');

            // Date picker
            $('.date-picker', context).not('.hasDatepicker').datepicker({
                autoclose: true,
                todayHighlight: true,
                format: 'dd/mm/yyyy',
                language: 'vi',
            }).addClass('hasDatepicker');
        }

        // Khởi tạo cho các datepicker đã có sẵn khi tải trang
        initializeDatepickers($('#dsHoatDong'));

        // 1. THÊM NĂM HOẠT ĐỘNG MỚI
        $('#btn-themnamhoatdong').on('click', function() {
            let maxIndex = -1; // Bắt đầu từ -1 để chỉ số đầu tiên là 0
            $('#dsHoatDong .year-cell').each(function() {
                const currentIndex = parseInt($(this).data('group-index'), 10);
                if (currentIndex > maxIndex) {
                    maxIndex = currentIndex;
                }
            });
            const stt = maxIndex + 1; // Chỉ số bắt đầu từ 0
            const defaultYear = '';

            const namHtml = `
        <tr class="year-group-${stt}">
            <td class="text-center year-cell" rowspan="1" data-group-index="${stt}">
                <input type="text" value="${defaultYear}" class="form-control yearpicker yearpicker_${stt}" name="nam_hoatdong[${stt}]" />
            </td>
            <td class="text-center">
                <input type="text" class="form-control" name="noidung_hoatdong[${stt}][]" />
            </td>
            <td class="text-center">
                <input type="text" class="form-control date-picker" name="tungay_hoatdong[${stt}][]" autocomplete="off" />
            </td>
            <td class="text-center">
                <input type="text" class="form-control date-picker" name="denngay_hoatdong[${stt}][]" autocomplete="off" />
            </td>
            <td class="text-center">
                <select id="nguonkinhphi" name="nguonkinhphi[${stt}][]" class="custom-select">
                    <option value="0">-- Chọn --</option>
                    <option value="1">Tự chủ</option>
                    <option value="2">Đầu tư</option>
                </select>
            </td>
            <td class="text-center">
                <input type="text" class="form-control" name="kinhphi[${stt}][]" />
            </td>
            <td class="text-center">
                <input type="text" class="form-control" name="ghichu_hoatdong[${stt}][]" />
            </td>
           <td class="text-center">
                <input type="hidden" name="hoatdong_id[${stt}][]" value="0" />
                <button type="button" class="btn btn-danger btn_xoa_hoatdong" data-group-id="${stt}" data-id="0"><i class="fas fa-trash-alt"></i></button>
            </td>
        </tr>`;

            const newRow = $(namHtml);
            $('#dsHoatDong').append(newRow);
            initializeDatepickers(newRow);
        });

        // Delete activity
        $('body').on('click', '.btn_xoa_hoatdong', function() {
            const groupId = $(this).data('group-id');
            const id = $(this).data('id'); // ID của hoạt động trong cơ sở dữ liệu

            // Tìm hàng hiện tại
            const $row = $(this).closest('tr.year-group-' + groupId);

            if (id && id !== '0') {
                // Xóa hoạt động đã lưu trong cơ sở dữ liệu
                bootbox.confirm({
                    title: "<span class='text-danger' style='font-weight:bold;font-size:20px;'>Thông báo</span>",
                    message: "<span style='font-size:24px;'>Bạn có chắc chắn muốn xóa hoạt động này?</span>",
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
                                url: 'index.php?option=com_vhytgd&controller=thietche&task=removeHoatDongThietChe',
                                type: 'POST',
                                dataType: 'json',
                                data: {
                                    hoatdong_id: id,
                                    '<?php echo Session::getFormToken(); ?>': 1
                                },
                                success: function(response) {
                                    if (response.success) {
                                        // Xóa hàng khỏi giao diện
                                        $row.remove();

                                        // Cập nhật rowspan
                                        const rowCount = $(`#dsHoatDong .year-group-${groupId}`).length;
                                        if (rowCount === 0) {
                                            // Xóa toàn bộ nhóm nếu không còn hoạt động
                                            $(`#dsHoatDong .year-group-${groupId}`).remove();
                                            showToast('Xóa hoạt động thành công, năm đã được xóa do không còn hoạt động', true);
                                        } else {
                                            // Cập nhật rowspan của ô year-cell
                                            $(`#dsHoatDong .year-cell[data-group-index="${groupId}"]`).attr('rowspan', rowCount);
                                            showToast(response.message, true);
                                        }
                                    } else {
                                        showToast(response.message, false);
                                    }
                                },
                                error: function(xhr, status, error) {
                                    showToast('Lỗi khi gửi yêu cầu AJAX: ' + error, false);
                                }
                            });
                        }
                    }
                });
            } else {
                // Xóa hàng chưa lưu trong cơ sở dữ liệu (chỉ xóa trên giao diện)
                $row.remove();

                // Cập nhật rowspan
                const rowCount = $(`#dsHoatDong .year-group-${groupId}`).length;
                if (rowCount === 0) {
                    // Xóa toàn bộ nhóm nếu không còn hoạt động
                    $(`#dsHoatDong .year-group-${groupId}`).remove();
                    showToast('Xóa hoạt động thành công, năm đã được xóa do không còn hoạt động', true);
                } else {
                    // Cập nhật rowspan của ô year-cell
                    $(`#dsHoatDong .year-cell[data-group-index="${groupId}"]`).attr('rowspan', rowCount);
                    showToast('Xóa hoạt động thành công', true);
                }
            }
        });

        // Hàm showToast (giữ nguyên)
        function showToast(message, isSuccess = true) {
            const toast = $('<div></div>').text(message).css({
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

        // Form validation
        $('#frmThongTinThietChe').validate({
            ignore: [], // Không bỏ qua các trường ẩn
            errorPlacement: function(error, element) {
                error.addClass('error_modal');
                error.appendTo(element.closest('.mb-3'));
                // Đảm bảo div.mb-3 không bị mở rộng quá mức
                element.closest('.mb-3').css({
                    'max-width': '100%',
                    'overflow-wrap': 'break-word'
                });
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
                "nam_hoatdong[]": {
                    required: function(element) {
                        const row_index = $('input[name="nam_hoatdong[]"]').index($(element));
                        return !$('input[name="nam_hoatdong[]"]').eq(row_index).val();
                    }
                },
                "noidung_hoatdong[1][]": {
                    required: function(element) {
                        const row_index = $(element).closest('tbody').find('input[name="noidung_hoatdong[1][]"]').index($(element));
                        return !$('input[name="noidung_hoatdong[1][]"]').eq(row_index).val();
                    }
                },
                "nguonkinhphi[1][]": {
                    required: function(element) {
                        const row_index = $(element).closest('tbody').find('select[name="nguonkinhphi[1][]"]').index($(element));
                        return !$('select[name="nguonkinhphi[1][]"]').eq(row_index).val();
                    }
                },
                "kinhphi[1][]": {
                    required: function(element) {
                        const row_index = $(element).closest('tbody').find('input[name="kinhphi[1][]"]').index($(element));
                        return !$('input[name="kinhphi[1][]"]').eq(row_index).val();
                    }
                }
            },
            messages: {
                loaihinhthietche_id: "Vui lòng chọn loại hình thiết chế",
                phuongxa_id: "Vui lòng chọn phường/xã",
                thietche_ten: "Vui lòng nhập tên thiết chế",
                trangthaihoatdong_id: "Vui lòng chọn trạng thái hoạt động",
                "nam_hoatdong[]": "Vui lòng nhập năm hoạt động",
                "noidung_hoatdong[1][]": "Vui lòng nhập nội dung hoạt động",
                "nguonkinhphi[1][]": "Vui lòng chọn nguồn kinh phí",
                "kinhphi[1][]": "Vui lòng nhập kinh phí"
            },
            submitHandler: function(form) {
                $('.yearpicker').each(function() {
                    const stt = $(this).attr('class').match(/yearpicker_(\d+)/)[1];
                    if (!$(this).val()) {
                        const currentYear = new Date().getFullYear();
                        $(this).val(currentYear);
                        $(`.btn-themnoidunghoatdong_${stt}`).attr('data-nam', currentYear);
                        $(`.tbodyHoatDong_${stt} input[name="nam_hoatdong_child[${stt}][]"]`).val(currentYear);
                        $(`.from_${stt}`).val(`01/01/${currentYear}`);
                        $(`.to_${stt}`).val(`31/12/${currentYear}`);
                        $(`.btn-themnoidunghoatdong_${stt}`).attr('data-from', `01/01/${currentYear}`);
                        $(`.btn-themnoidunghoatdong_${stt}`).attr('data-to', `31/12/${currentYear}`);
                    }
                });
                form.submit();
            }
        });
        // Add new activity row


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
                                url: 'index.php?option=com_vhytgd&controller=thietche&task=removeThongTinThietBi',
                                type: 'POST',
                                dataType: 'json',
                                data: {
                                    id_thietbi: idThietBi,
                                    '<?php echo HTMLHelper::_('form.token'); ?>': 1
                                },
                                success: function(response) {
                                    if (response.success) {
                                        $(`.thietbi_${idThietBi}`).remove();
                                        showToast('Xóa thiết bị thành công', true);
                                    } else {
                                        showToast(response.message || 'Xóa thiết bị không thành công', false);
                                    }
                                },
                                error: function(xhr, status, error) {
                                    showToast('Lỗi khi gửi yêu cầu AJAX: ' + error, false);
                                }
                            });
                        }
                    }
                });
            } else {
                // Xóa thiết bị chưa lưu (chỉ trên giao diện)
                $(this).closest('tr').remove();
                showToast('Xóa thiết bị thành công', true);
            }
        });


        // Form validation


        $('#btn_luu').on('click', function() {
            $('#frmThongTinThietChe').submit();
        });
    });
</script>