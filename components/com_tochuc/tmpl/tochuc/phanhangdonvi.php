<?php

use Joomla\CMS\Factory;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;
use Joomla\Component\Tochuc\Site\Helper\TochucHelper;

$user = Factory::getUser();
$data = $this->data;
$donvi_id = $this->donvi_id;
$hinhthucphanhang = Core::loadAssocListHasKey('danhmuc_hinhthucphanhangdonvi','*','id','trangthai =1 and daxoa=0');
$hang = Core::loadAssocListHasKey('danhmuc_hangdonvisunghiep','*','id','trangthai=1');
$canNew = Core::_checkPerActionArr($user->id, 'com_tochuc', 'tochuc', array('task' => 'au_add_phanhangdonvi', 'location' => 'site', 'non_action' => 'false'))
?>

<section class="content">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Quá trình phân hạng đơn vị</h3>
            <div class="card-tools">
                <!-- <button type="button" class="btn btn-success btn-excel">
                    <i class="fa fa-file-excel"></i>
                </button> -->
                <?php if ($canNew): ?>
                    <button type="button" id="btn_add_quatrinhphanhang" data-toggle="modal" data-target=".modal" class="btn btn-primary btn-themmoi">
                        <i class="fa fa-plus"></i>
                    </button>
                <?php endif; ?>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped projects" style="margin-bottom: 0px;">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 1%;padding-left: 0.75rem;">
                                #
                            </th>
                            <th class="text-center" style="width: 10%;">
                                Ngày bắt đầu
                            </th>
                            <th class="text-center" style="width: 10%">
                                Ngày kết thúc
                            </th>
                            <th style="width: 12%">
                                Hình thức phân hạng
                            </th>
                            <th style="width: 10%">
                                Hạng đơn vị
                            </th>
                            <th style="width: 10%">
                                Số quyết định
                            </th>
                            <th style="width: 20%">
                                Ghi chú
                            </th>
                            <th style="width: 1%;padding-right: 0.75rem;" class="text-center">
                                Hành động
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        for ($i = 0; $i < count($data); $i++) {
                            $row = $data[$i];
                            $canEdit = Core::_checkPerActionArr($user->id, 'com_tochuc', 'tochuc', ['task' => 'au_edit_phanhangdonvi', 'location' => 'site', 'non_action' => 'false']);
                            $canDelete = Core::_checkPerActionArr($user->id, 'com_tochuc', 'tochuc', ['task' => 'au_del_phanhangdonvi', 'location' => 'site', 'non_action' => 'false']);
                        ?>
                            <tr>
                                <td class="text-center" style="padding-left: 0.75rem;"><?php echo $i + 1 ?></td>
                                <td class="text-center"><?php echo date('d/m/Y', strtotime($row['ngaybatdau'])); ?></td>
                                <td class="text-center"><?php echo date('d/m/Y', strtotime($row['ngayketthuc'])); ?></td>
                                <td><?php echo $hinhthucphanhang[$row['hinhthucphanhang_id']]['ten']; ?></td>
                                <td><?php echo $hang[$row['hangdonvisunghiep_id']]['ten']; ?></td>
                                
                                <td><?php echo $row['soqd']; ?></td>
                                <td><?php echo $row['ghichu']; ?></td>
                                <td class="text-center" style="padding-right: 0.75rem;" nowrap="nowrap">
                                    <?php if ($canEdit): ?>
                                        <a href="<?php echo Route::_('index.php'); ?>?view=tochuc&task=modal_phanhang&format=raw&id=<?php echo $row['id'] ?>&donvi_id=<?php echo $this->donvi_id ?>" data-toggle="modal" data-target=".modal" class="btn btn-mini btn-info btnEditQuatrinh" data-quatrinh-id="<?php echo $row['id'] ?>"><i class="fas fa-pencil-alt"></i> Sửa</a>
                                    <?php endif; ?>
                                    <?php if ($canDelete): ?>
                                        <span class="btn btn-mini btn-danger" id="btnXoaQuaTrinhPhanHang" href="index.php?option=com_tochuc&controller=tochuc&format=raw&task=delphanhangdonvi&id=<?php echo $row['id'] ?>&donvi_id=<?php echo $this->donvi_id; ?>"><i class="fas fa-trash"></i> Xóa</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</section>
<script type="text/javascript">
    jQuery(document).ready(function($) {
        $('#btn_export_lichsu').on('click', function() {
            document.location.assign(this.href);
            return false;
        });
        $('#btn_add_quatrinhphanhang').on('click', function() {
            Pace.start();
            $('#div_modal').load('<?php echo Route::_('index.php') ?>?view=tochuc&task=modal_phanhang&format=raw&donvi_id=<?php echo $this->donvi_id; ?>', function() {
                Pace.stop();
            });
        });
        $('#btn_add_quatrinh').on('click', function() {
            $('#div_modal').load('index.php?option=com_tochuc&controller=tochuc&task=editquatrinh&format=raw&dept_id=<?php echo $this->item->id; ?>', function() {});
        });
        $('.btnEditQuatrinh').on('click', function() {
            $('#div_modal').load(this.href, function() {});
        });

        
        $('#btnXoaQuaTrinhPhanHang').click(function() {
            if (confirm('Bạn có muốn xóa không?')) {
                $.ajax({
                    url: '<?php echo Uri::base(true); ?>' + $(this).attr('href'),
                    type: "POST",
                    success: function(data) {
                        if (data == true) {
                            loadNoticeBoardSuccess('Thông báo', 'Thao tác thành công!');
                            $.blockUI();
                            jQuery.ajax({
                                type: "GET",
                                url: '<?php echo Route::_('index.php'); ?>?view=tochuc&task=phanhangdonvi&format=raw&Itemid=<?php echo $this->Itemid; ?>&id=<?php echo $this->item->id; ?>',
                                success: function(data, textStatus, jqXHR) {
                                    $.unblockUI();
                                    $('#modal_tochuc').modal('hide');
                                    $(this).closest('tr').remove();
                                    $('#phanhangdonvi-quatrinh').html(data);
                                }
                            });
                        } else {
                            loadNoticeBoardError('Thông báo', 'Có lỗi xảy ra, vui lòng liên hệ quản trị viên!');
                        }
                    }
                });
            }
            return false;
        });
    });

    
</script>