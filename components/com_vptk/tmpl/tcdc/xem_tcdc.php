<?php
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Uri\Uri;


$item = $this->item;
// var_dump($item);

?>

<form id="frmTCDC" name="frmTCDC">
    <div class="card-body">
        <div class="d-flex align-items-center justify-content-between border-bottom mb-3">
            <h2 class="text-primary mb-3">
                Thông tin chi tiết nhân khẩu
            </h2>
            <span>
                <button type="button" id="btn_quaylai" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Quay lại</button>
            </span>
        </div>
        <div class="card card-outline card-primary mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Thông tin hộ khẩu</h5>
            </div>
            <div class="card-body">
                <table class="">
                    <tbody>
                        <tr>
                            <th class="text-nowrap" style="width: 15%;">Số hộ khẩu:</th>
                            <td style="width: 30%;"><?php echo htmlspecialchars($item['hokhau_so']); ?></td>
                            <th class="text-nowrap" style="width: 15%;">Ngày hộ khẩu:</th>
                            <td style="width: 18%;"><?php echo htmlspecialchars($item['hokhau_ngaycap']); ?></td>
                            <th class="text-nowrap" style="width: 15%;">Cơ quan cấp:</th>
                            <td style="width: 19%;"><?php echo htmlspecialchars($item['hokhau_coquancap']); ?></td>
                        </tr>
                        <tr>
                            <th class="text-nowrap">Phường/Xã:</th>
                            <td><?php echo htmlspecialchars($item['tenkhuvuc']); ?></td>
                            <th class="text-nowrap">Thôn/Tổ:</th>
                            <td><?php echo htmlspecialchars($item['tenthonto']); ?></td>
                            <th class="text-nowrap">Số nhà:</th>
                            <td style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                <?php echo htmlspecialchars($item['diachi']); ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="card-header">
                <h5 class="card-title mb-0">Thông tin nhân khẩu</h5>
            </div>
            <div class="card-body">
                <table class="">
                    <tbody>
                        <tr>
                            <th class="text-nowrap" style="width: 15%;">Họ tên:</th>
                            <td style="width: 29.7%;"><?php echo htmlspecialchars($item['hoten']); ?></td>
                            <th class="text-nowrap" style="width: 15%;">Ngày sinh:</th>
                            <td style="width: 17.8%;"><?php echo htmlspecialchars($item['ngaysinh']); ?></td>
                            <th class="text-nowrap" style="width: 15%;">Giới tính:</th>
                            <td style="width: 19%;"><?php echo htmlspecialchars($item['tengioitinh']); ?></td>
                        </tr>
                        <tr>
                            <th class="text-nowrap">Số CCCD/CMND:</th>
                            <td><?php echo htmlspecialchars($item['cccd_so']); ?></td>
                            <th class="text-nowrap">Ngày cấp CCCD/CMND:</th>
                            <td><?php echo htmlspecialchars($item['cccd_ngaycap']); ?></td>
                            <th class="text-nowrap">Nơi cấp CCCD/CMND:</th>
                            <td><?php echo htmlspecialchars($item['cccd_coquancap']); ?></td>
                        </tr>
                        <tr>
                            <th class="text-nowrap">Quan hệ với chủ hộ:</th>
                            <td><?php echo htmlspecialchars($item['tenquanhenhanthan']); ?></td>
                            <th class="text-nowrap">Điện thoại:</th>
                            <td><?php echo htmlspecialchars($item['dienthoai']); ?></td>
                            <th class="text-nowrap">Trình độ học vấn:</th>
                            <td><?php echo htmlspecialchars($item['tentrinhdohocvan']); ?></td>
                        </tr>
                        <tr>
                            <th class="text-nowrap">Dân tộc:</th>
                            <td><?php echo htmlspecialchars($item['tendantoc']); ?></td>
                            <th class="text-nowrap">Tôn giáo:</th>
                            <td><?php echo htmlspecialchars($item['tentongiao']); ?></td>
                            <th class="text-nowrap">Nghề nghiệp:</th>
                            <td><?php echo htmlspecialchars($item['nghenghiep']); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-12">
                <div class="card card-outline card-primary mb-4 collapsed-card">
                    <div class="card-header" data-card-widget="collapse" style="background-color: #688fb112">
                        <h5 class="card-title mb-0">Thông tin nhân thân</h5>
                        <div class="card-tools">
                            <span class="badge badge-primary mr-2"><?php echo count($this->nhanthan); ?></span>
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-chevron-down"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body" style="display: none;">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr class="bg-primary">
                                        <th class="text-center" style="width: 5%;">STT</th>
                                        <th class="text-center">Quan hệ</th>
                                        <th class="text-center" style="width: 20%;">Họ và tên</th>
                                        <th class="text-center" style="width: 15%;">Năm sinh</th>
                                        <th class="text-center" style="width: 20%;">Nghề nghiệp</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($this->nhanthan)) : ?>
                                        <tr>
                                            <td colspan="5" class="text-center">Không có dữ liệu</td>
                                        </tr>
                                    <?php else : ?>
                                        <?php foreach ($this->nhanthan as $index => $nt) : ?>
                                            <tr>
                                                <td class="text-center"><?php echo $index + 1; ?></td>
                                                <td class="text-center"><?php echo htmlspecialchars($nt['tenquanhenhanthan'] ?? ''); ?></td>
                                                <td class="text-center"><?php echo htmlspecialchars($nt['hoten'] ?? ''); ?></td>
                                                <td class="text-center"><?php echo htmlspecialchars($nt['ngaysinh'] ?? ''); ?></td>
                                                <td class="text-center"><?php echo htmlspecialchars($nt['nghenghiep'] ?? ''); ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">

                <div class="card card-outline card-primary mb-4 collapsed-card ">
                    <div class="card-header" data-card-widget="collapse" style="background-color: #688fb112">
                        <h5 class="card-title mb-0">Thông tin Ban điều hành tổ dân phố</h5>
                        <div class="card-tools">
                            <span class="badge badge-primary mr-2"><?php echo count($this->bandieuhanh); ?></span>

                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-chevron-up"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body" style="display: none;">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr class="bg-primary">
                                        <th class="text-center" style="width: 5%;">STT</th>
                                        <th class="text-center">Nhiệm kỳ</th>
                                        <th class="text-center" style="width: 20%;">Chức danh</th>
                                        <th class="text-center" style="width: 15%;">Ngày bắt đầu</th>
                                        <th class="text-center" style="width: 20%;">Ngày kết thúc</th>
                                        <th class="text-center" style="width: 10%;">Tình trạng</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($this->bandieuhanh)) : ?>
                                        <tr>
                                            <td colspan="6" class="text-center">Không có dữ liệu</td>
                                        </tr>
                                    <?php else : ?>
                                        <?php foreach ($this->bandieuhanh as $index => $bdh) : ?>
                                            <tr>
                                                <td class="text-center"><?php echo $index + 1; ?></td>
                                                <td class="text-center"><?php echo htmlspecialchars($bdh['tennhiemky']); ?></td>
                                                <td class="text-center"><?php echo htmlspecialchars($bdh['tenchucdanh']); ?></td>
                                                <td class="text-center"><?php echo htmlspecialchars($bdh['ngaybatdau']); ?></td>
                                                <td class="text-center"><?php echo htmlspecialchars($bdh['ngayketthuc']); ?></td>
                                                <td class="text-center"><?php echo htmlspecialchars($bdh['tentinhtrang']); ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">

                <div class="card card-outline card-primary mb-4 collapsed-card">
                    <div class="card-header" data-card-widget="collapse" style="background-color: #688fb112">
                        <h5 class="card-title mb-0">Thông tin Đối tượng bảo trợ xã hội</h5>
                        <div class="card-tools">
                            <span class="badge badge-primary mr-2"><?php echo count($this->chinhsach); ?></span>
                            
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-chevron-up"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body" style="display: none;">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr class="bg-primary">
                                        <th class="text-center" style="width: 5%;">STT</th>
                                        <th class="text-center">Mã hỗ trợ</th>
                                        <th class="text-center" style="width: 20%;">Biến động</th>
                                        <th class="text-center" style="width: 15%;">Loại đối tượng</th>
                                        <th class="text-center" style="width: 20%;">Thực nhận</th>
                                        <th class="text-center" style="width: 10%;">Ngày hưởng</th>
                                        <th class="text-center" style="width: 10%;">Trạng thái</th>


                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($this->chinhsach)) : ?>
                                        <tr>
                                            <td colspan="7" class="text-center">Không có dữ liệu</td>
                                        </tr>
                                    <?php else : ?>
                                        <?php foreach ($this->chinhsach as $index => $bdh) : ?>
                                            <tr>
                                                <td class="text-center"><?php echo $index + 1; ?></td>
                                                <td class="text-center"><?php echo htmlspecialchars($bdh['tenbiendong']); ?></td>
                                                <td class="text-center"><?php echo htmlspecialchars($bdh['tenloaidoituong']); ?></td>
                                                <td class="text-center"><?php echo htmlspecialchars($bdh['sotien']); ?></td>
                                                <td class="text-center"><?php echo htmlspecialchars($bdh['huongtungay']); ?></td>
                                                <td class="text-center"><?php echo htmlspecialchars($bdh['tenchinhsach']); ?></td>
                                                <td class="text-center"><?php echo htmlspecialchars($bdh['tentrangthai']); ?></td>

                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">

                <div class="card card-outline card-primary mb-4 collapsed-card">
                    <div class="card-header" data-card-widget="collapse" style="background-color: #688fb112">
                        <h5 class="card-title mb-0">Thông tin Vay vốn</h5>
                        <div class="card-tools">
                            <span class="badge badge-primary mr-2"><?php echo count($this->vayvon); ?></span>
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-chevron-up"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body" style="display: none;">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr class="bg-primary">
                                        <th class="text-center" style="width: 5%;">STT</th>
                                        <th class="text-center">Chương trình vay</th>
                                        <th class="text-center" style="width: 20%;">Nguồn vốn</th>
                                        <th class="text-center" style="width: 15%;">Ngày giải ngân</th>
                                        <th class="text-center" style="width: 20%;">Ngày đến hạn cuối</th>
                                        <th class="text-center" style="width: 10%;">Giải ngân</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($this->vayvon)) : ?>
                                        <tr>
                                            <td colspan="5" class="text-center">Không có dữ liệu</td>
                                        </tr>
                                    <?php else : ?>
                                        <?php foreach ($this->vayvon as $index => $vv) : ?>
                                            <tr>
                                                <td class="text-center"><?php echo $index + 1; ?></td>
                                                <td class="text-center"><?php echo htmlspecialchars($vv['tenchuongtrinhvay']); ?></td>
                                                <td class="text-center"><?php echo htmlspecialchars($vv['tennguonvon']); ?></td>
                                                <td class="text-center"><?php echo htmlspecialchars($vv['ngaygiaingan']); ?></td>
                                                <td class="text-center"><?php echo htmlspecialchars($vv['ngaydenhan']); ?></td>
                                                <td class="text-center"><?php echo number_format($vv['tiengiaingan']); ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">

                <div class="card card-outline card-primary mb-4 collapsed-card">
                    <div class="card-header" data-card-widget="collapse" style="background-color: #688fb112">
                        <h5 class="card-title mb-0">Thông tin Người có công</h5>
                        <div class="card-tools">
                            <span class="badge badge-primary mr-2"><?php echo count($this->nguoicocong); ?></span>
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-chevron-up"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body" style="display: none;">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr class="bg-primary">
                                        <th class="text-center" style="width: 5%;">STT</th>
                                        <th class="text-center">Hình thức hưởng</th>
                                        <th class="text-center" style="width: 20%;">Đối tượng hưởng</th>
                                        <th class="text-center" style="width: 15%;">Trợ cấp</th>
                                        <th class="text-center" style="width: 20%;">Ngày hưởng</th>
                                        <th class="text-center" style="width: 10%;">Trạng thái</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($this->nguoicocong)) : ?>
                                        <tr>
                                            <td colspan="6" class="text-center">Không có dữ liệu</td>
                                        </tr>
                                    <?php else : ?>
                                        <?php foreach ($this->nguoicocong as $index => $ncc) : ?>
                                            <tr>
                                                <td class="text-center"><?php echo $index + 1; ?></td>
                                                <td class="text-center">
                                                    <?php
                                                    switch ($ncc['is_hinhthuc']) {
                                                        case 1:
                                                            echo 'Hàng tháng';
                                                            break;
                                                        case 2:
                                                            echo 'Một lần';
                                                            break;
                                                        default:
                                                            echo 'Không xác định';
                                                            break;
                                                    }
                                                    ?>
                                                </td>
                                                <td class="text-center"><?php echo htmlspecialchars($ncc['tenncc']); ?></td>
                                                <td class="text-center"><?php echo htmlspecialchars($ncc['trocap']) ?? ''; ?></td>
                                                <td class="text-center"><?php echo htmlspecialchars($ncc['ngayhuong2']); ?></td>
                                                <td class="text-center"><?php echo htmlspecialchars($ncc['trangthai']); ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Thông tin gia đình văn hóa -->
            <div class="col-md-12">

                <div class="card card-outline card-primary mb-4 collapsed-card">
                    <div class="card-header" data-card-widget="collapse" style="background-color: #688fb112">
                        <h5 class="card-title mb-0">Thông tin Gia đình văn hóa</h5>
                        <div class="card-tools">
                            <span class="badge badge-primary mr-2"><?php echo count($this->giadinhvanhoa); ?></span>

                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-chevron-up"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body" style="display: none;">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr class="bg-primary">
                                        <th class="text-center" style="width: 5%;">STT</th>
                                        <th class="text-center">Năm</th>
                                        <th class="text-center" style="width: 20%;">Đạt/Không</th>
                                        <th class="text-center" style="width: 15%;">Gia đình tiêu biểu</th>
                                        <th class="text-center" style="width: 20%;">Lý do không đạt</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($this->giadinhvanhoa)) : ?>
                                        <tr>
                                            <td colspan="5" class="text-center">Không có dữ liệu</td>
                                        </tr>
                                    <?php else : ?>
                                        <?php foreach ($this->giadinhvanhoa as $index => $gdvh) : ?>
                                            <tr>
                                                <td class="text-center"><?php echo $index + 1; ?></td>
                                                <td class="text-center"><?php echo htmlspecialchars($gdvh['nam']); ?></td>

                                                <td class="text-center">
                                                    <?php
                                                    switch ($gdvh['is_dat']) {
                                                        case 1:
                                                            echo 'Đạt';
                                                            break;
                                                        case 2:
                                                            echo 'Không đạt';
                                                            break;
                                                    }
                                                    ?>
                                                </td>
                                                <td class="text-center">
                                                    <?php
                                                    switch ($gdvh['is_giadinhvanhoatieubieu']) {
                                                        case 1:
                                                            echo 'Đạt';
                                                            break;
                                                        case 2:
                                                            echo '';
                                                            break;
                                                    }
                                                    ?>
                                                </td>
                                                <td class="text-center"><?php echo htmlspecialchars($gdvh['lydokhongdat']) ?? ''; ?></td>

                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- tHông tin đoàn hội -->
            <div class="col-md-12">

                <div class="card card-outline card-primary mb-4 collapsed-card">
                    <div class="card-header" data-card-widget="collapse" style="background-color: #688fb112">
                        <h5 class="card-title mb-0">Thông tin Đoàn hội</h5>
                        <div class="card-tools">
                            <span class="badge badge-primary mr-2"><?php echo count($this->doanhoi); ?></span>
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-chevron-up"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body" style="display: none;">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr class="bg-primary">
                                        <th class="text-center" style="width: 5%;">STT</th>
                                        <th class="text-center">Đoàn/Hội</th>
                                        <th class="text-center" style="width: 20%;">Chức vụ</th>
                                        <th class="text-center" style="width: 15%;">Thời điểm tham gia</th>
                                        <th class="text-center" style="width: 20%;">Thời điểm kết thúc</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($this->doanhoi)) : ?>
                                        <tr>
                                            <td colspan="5" class="text-center">Không có dữ liệu</td>
                                        </tr>
                                    <?php else : ?>
                                        <?php foreach ($this->doanhoi as $index => $dh) : ?>
                                            <tr>
                                                <td class="text-center"><?php echo $index + 1; ?></td>
                                                <td class="text-center"><?php echo htmlspecialchars($dh['tendoanhoi']); ?></td>
                                                <td class="text-center"><?php echo htmlspecialchars($dh['tenchucdanh']); ?></td>
                                                <td class="text-center"><?php echo htmlspecialchars($dh['thoidiem_batdau']); ?></td>
                                                <td class="text-center"><?php echo htmlspecialchars($dh['thoidiem_ketthuc']) ?? ''; ?></td>

                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- thông tin số nhà -->
            <div class="col-md-12">

                <div class="card card-outline card-primary mb-4 collapsed-card">
                    <div class="card-header" data-card-widget="collapse" style="background-color: #688fb112">
                        <h5 class="card-title mb-0">Thông tin Số nhà</h5>
                        <div class="card-tools">
                            <span class="badge badge-primary mr-2"><?php echo count($this->sonha); ?></span>
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-chevron-up"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body" style="display: none;">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr class="bg-primary">
                                        <th class="text-center" style="width: 5%;">STT</th>
                                        <th class="text-center">Số nhà</th>
                                        <th class="text-center" style="width: 20%;">Đường</th>
                                        <th class="text-center" style="width: 15%;">Thửa đất</th>
                                        <th class="text-center" style="width: 20%;">Tờ bản đồ số</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($this->sonha)) : ?>
                                        <tr>
                                            <td colspan="5" class="text-center">Không có dữ liệu</td>
                                        </tr>
                                    <?php else : ?>
                                        <?php foreach ($this->sonha as $index => $dh) : ?>
                                            <tr>
                                                <td class="text-center"><?php echo $index + 1; ?></td>
                                                <td class="text-center"><?php echo htmlspecialchars($dh['sonha']); ?></td>
                                                <td class="text-center"><?php echo htmlspecialchars($dh['tenduong']); ?></td>
                                                <td class="text-center"><?php echo htmlspecialchars($dh['thuadatso']); ?></td>
                                                <td class="text-center"><?php echo htmlspecialchars($dh['tobandoso']) ?? ''; ?></td>

                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- thông tin nộp thuế sử dụng đất -->
            <div class="col-md-12">

                <div class="card card-outline card-primary mb-4 collapsed-card">
                    <div class="card-header" data-card-widget="collapse" style="background-color: #688fb112">
                        <h5 class="card-title mb-0">Thông tin Nộp thuế sử dụng đất</h5>
                        <div class="card-tools">
                            <span class="badge badge-primary mr-2"><?php echo count($this->nopthue); ?></span>
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-chevron-up"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body" style="display: none;">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr class="bg-primary">
                                        <th class="text-center" style="width: 5%;">STT</th>
                                        <th class="text-center">Mã phi nông nghiệp</th>
                                        <th class="text-center" style="width: 20%;">Số giấy CN</th>
                                        <th class="text-center" style="width: 15%;">Địa chỉ</th>
                                        <th class="text-center" style="width: 20%;">Tờ bản đồ</th>
                                        <th class="text-center" style="width: 20%;">Tổng tiền phải nộp</th>
                                        <th class="text-center" style="width: 20%;">Tình trạng</th>


                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($this->nopthue)) : ?>
                                        <tr>
                                            <td colspan="7" class="text-center">Không có dữ liệu</td>
                                        </tr>
                                    <?php else : ?>
                                        <?php foreach ($this->nopthue as $index => $dh) : ?>
                                            <tr>
                                                <td class="text-center"><?php echo $index + 1; ?></td>
                                                <td class="text-center"><?php echo htmlspecialchars($dh['maphinongnghiep']); ?></td>
                                                <td class="text-center"><?php echo htmlspecialchars($dh['sogcn']); ?></td>
                                                <td class="text-center"><?php echo htmlspecialchars($dh['diachi']) ?? ''; ?></td>
                                                <td class="text-center"><?php echo htmlspecialchars($dh['tobando']); ?></td>
                                                <td class="text-center"><?php echo htmlspecialchars($dh['tongtiennop']); ?></td>
                                                <td class="text-center">
                                                    <?php
                                                    switch ($dh['tinhtrang']) {
                                                        case 1:
                                                            echo 'Chưa nộp';
                                                            break;
                                                        case 2:
                                                            echo 'Đã nộp';
                                                            break;
                                                    }
                                                    ?>
                                                </td>

                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- thông tin bạo lực gia đình -->
            <div class="col-md-12">

                <div class="card card-outline card-primary mb-4 collapsed-card">
                    <div class="card-header" data-card-widget="collapse" style="background-color: #688fb112">
                        <h5 class="card-title mb-0">Thông tin bạo lực gia đình</h5>
                        <div class="card-tools">
                            <span class="badge badge-primary mr-2"><?php echo count($this->baoluc); ?></span>

                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-chevron-up"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body" style="display: none;">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr class="bg-primary">
                                        <th style="width: 50px; text-align: center;" rowspan="2">STT</th>
                                        <th style="width: 175px; text-align: center;" colspan="3">Người gây bạo lực</th>
                                        <th style="width: 200px; text-align: center;" colspan="3">Nạn nhân</th>
                                        <th style="width: 150px; text-align: center;" rowspan="2">Biện pháp hỗ trợ và xử lý</th>
                                        <th style="width: 150px; text-align: center;" rowspan="2">Thông tin xử lí</th>
                                    </tr>
                                    <tr class="bg-primary">
                                        <th style="width: 150px; text-align: center;">Họ tên</th>
                                        <th style="width: 55px; text-align: center;">Giới tính</th>
                                        <th style="width: 55px; text-align: center;">Năm sinh</th>
                                        <th style="width: 150px; text-align: center;">Họ tên</th>
                                        <th style="width: 55px; text-align: center;">Giới tính</th>
                                        <th style="width: 55px; text-align: center;">Năm sinh</th>
                                    </tr>

                                </thead>
                                <tbody>
                                    <?php if (empty($this->baoluc)) : ?>
                                        <tr>
                                            <td colspan="9" class="align-middle text-center">Không có dữ liệu</td>
                                        </tr>
                                    <?php else : ?>
                                        <?php foreach ($this->baoluc as $index => $dh) : ?>
                                            <tr>
                                                <td class="align-middle text-center"><?php echo $index + 1; ?></td>
                                                <td class="align-middle text-center"><?php echo htmlspecialchars($dh['hoten_nguoigay']); ?></td>
                                                <td class="align-middle text-center"><?php echo htmlspecialchars($dh['gioitinh_nguoigay']); ?></td>
                                                <td class="align-middle text-center"><?php echo htmlspecialchars($dh['namsinh_nguoigay']) ?? ''; ?></td>
                                                <td class="align-middle text-center"><?php echo htmlspecialchars($dh['hoten_nannhan']); ?></td>
                                                <td class="align-middle text-center"><?php echo htmlspecialchars($dh['gioitinh_nannhan']); ?></td>
                                                <td class="align-middle text-center"><?php echo htmlspecialchars($dh['namsinh_nannhan']); ?></td>
                                                <td class="align-middle text-center"><strong>Biện pháp:</strong> <?php echo htmlspecialchars($dh['bienphap_text']); ?>
                                                    <br><strong>Hỗ trợ:</strong><?php echo htmlspecialchars($dh['hotro_text']); ?>
                                                </td>
                                                <td class="align-middle text-center"><strong>Cơ quan xử lý:</strong><?php echo htmlspecialchars($dh['coquanxuly']); ?>
                                                    <br><strong>Mã vụ việc:</strong><?php echo htmlspecialchars($dh['mavuviec']); ?>
                                                    <br><strong>Ngày xử lý:</strong><?php echo htmlspecialchars($dh['ngayxuly2']); ?>
                                                    <br><strong>Tình trạng:</strong> <?php
                                                                                        switch ($dh['tinhtrang']) {
                                                                                            case 0:
                                                                                                echo 'Chưa xử lý';
                                                                                                break;
                                                                                            case 1:
                                                                                                echo 'Đã xử lý';
                                                                                                break;
                                                                                            case 2:
                                                                                                echo 'Đang xử lý';
                                                                                                break;
                                                                                        }
                                                                                        ?>
                                                </td>



                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Thông tin hỗ trợ trẻ em -->
            <div class="col-md-12">

                <div class="card card-outline card-primary mb-4 collapsed-card">
                    <div class="card-header" data-card-widget="collapse" style="background-color: #688fb112">
                        <h5 class="card-title mb-0">Thông tin hỗ trợ trẻ em</h5>
                        <div class="card-tools">
                            <span class="badge badge-primary mr-2"><?php echo count($this->treem); ?></span>

                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-chevron-up"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body" style="display: none;">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr class="bg-primary">
                                        <th style="width: 50px; text-align: center;" rowspan="2">STT</th>
                                        <th style="width: 175px; text-align: center;" colspan="3">Thông tin trẻ em</th>
                                        <th style="width: 150px; text-align: center;" rowspan="2">Trình trạng học tập</th>
                                        <th style="width: 150px; text-align: center;" rowspan="2">Trình trạng sức khỏe</th>
                                        <th style="width: 150px; text-align: center;" rowspan="2">Nhóm hoàn cảnh</th>
                                        <th style="width: 150px; text-align: center;" rowspan="2">Nội dung</th>
                                        <th style="width: 150px; text-align: center;" rowspan="2">Trợ giúp</th>
                                    </tr>
                                    <tr class="bg-primary">
                                        <th style="width: 300px; text-align: center;">Họ tên</th>
                                        <th style="width: 55px; text-align: center;">Giới tính</th>
                                        <th style="width: 55px; text-align: center;">Năm sinh</th>
                                    </tr>

                                </thead>
                                <tbody>
                                    <?php if (empty($this->treem)) : ?>
                                        <tr>
                                            <td colspan="9" class="align-middle text-center">Không có dữ liệu</td>
                                        </tr>
                                    <?php else : ?>
                                        <?php foreach ($this->treem as $index => $dh) : ?>
                                            <tr>
                                                <td class="align-middle text-center"><?php echo $index + 1; ?></td>
                                                <td class="align-middle text-center"><?php echo htmlspecialchars($dh['hoten']); ?></td>
                                                <td class="align-middle text-center"><?php echo htmlspecialchars($dh['tengioitinh']); ?></td>
                                                <td class="align-middle text-center"><?php echo htmlspecialchars($dh['namsinh']) ?? ''; ?></td>
                                                <td class="align-middle text-center"><?php echo htmlspecialchars($dh['tinhtranghoctap']) ?? ''; ?></td>
                                                <td class="align-middle text-center"><?php echo htmlspecialchars($dh['tinhtrangsuckhoe']) ?? ''; ?></td>

                                                <td class="align-middle text-center"><?php echo htmlspecialchars($dh['tennhom']); ?></td>
                                                <td class="align-middle text-center"><?php echo htmlspecialchars($dh['noidunghotro']); ?></td>
                                                <td class="align-middle text-center"><?php echo htmlspecialchars($dh['tenhotro']); ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- đồng bào dân tộc -->
            <div class="col-md-12">

                <div class="card card-outline card-primary mb-4 collapsed-card">
                    <div class="card-header" data-card-widget="collapse" style="background-color: #688fb112">
                        <h5 class="card-title mb-0">Thông tin đồng bào dân tộc</h5>
                        <div class="card-tools">
                            <span class="badge badge-primary mr-2"><?php echo count($this->dongbao); ?></span>

                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-chevron-up"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body" style="display: none;">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr class="bg-primary">
                                        <th class="text-center" style="width: 5%;">STT</th>
                                        <th class="text-center">Chính sách</th>
                                        <th class="text-center" style="width: 20%;">Loại hỗ trợ</th>
                                        <th class="text-center" style="width: 15%;">Nội dung</th>
                                        <th class="text-center" style="width: 20%;">Ngày hỗ trợ</th>
                                        <th class="text-center" style="width: 10%;">Tình trạng</th>


                                    </tr>

                                </thead>
                                <tbody>
                                    <?php if (empty($this->dongbao)) : ?>
                                        <tr>
                                            <td colspan="5" class="align-middle text-center">Không có dữ liệu</td>
                                        </tr>
                                    <?php else : ?>
                                        <?php foreach ($this->dongbao as $index => $dh) : ?>
                                            <tr>
                                                <td class="align-middle text-center"><?php echo $index + 1; ?></td>
                                                <td class="align-middle text-center"><?php echo htmlspecialchars($dh['csdongbao']); ?></td>
                                                <td class="align-middle text-center"><?php echo htmlspecialchars($dh['loaihotro']); ?></td>
                                                <td class="align-middle text-center"><?php echo htmlspecialchars($dh['noidung']) ?? ''; ?></td>
                                                <td class="align-middle text-center"><?php echo htmlspecialchars($dh['ngayhotro2']) ?? ''; ?></td>
                                                <td class="align-middle text-center"><?php echo htmlspecialchars($dh['tentrangthai']) ?? ''; ?></td>


                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" name="id" value="<?php echo (int)$item['id']; ?>">
    <?php echo HTMLHelper::_('form.token'); ?>
    </div>
</form>




<script type="text/javascript">
    jQuery(document).ready(function($) {

        $('#btn_quaylai').on('click', function() {
            window.location.href = '/index.php/component/vptk/?view=tcdc&task=default';
        });

    });
</script>
<style>
    .col-md-12 {
        margin-bottom: -22px;
    }

    .col-md-12 .card-primary.card-outline {
        border-top: 3px solid #087fff;
    }
</style>