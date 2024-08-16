<?php

use Joomla\CMS\Factory;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;
use Joomla\Component\Tochuc\Site\Helper\TochucHelper;

$user = Factory::getUser();
$data = $this->data;
$donvi_id = $this->donvi_id;
$hinhthuc = array(
	1=>array('id'=>1, 'ten'=>'Quy định cấp phó'),
	2=>array('id'=>2, 'ten'=>'Bổ sung cấp phó'),
);
?>

<section class="content">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Quy định số lượng cấp phó</h3>
            <div class="card-tools">
                <!-- <button type="button" class="btn btn-success btn-excel">
                    <i class="fa fa-file-excel"></i>
                </button> -->
                <button type="button" id="btn_add_quydinhcappho" data-toggle="modal" data-target=".modal" class="btn btn-primary btn-themmoi">
                    <i class="fa fa-plus"></i>
                </button>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped projects" style="margin-bottom: 0px;">
                    <thead>
                        <tr>

                            <th style="width: 2%; padding-left: 0.75rem;">#</th>
                            <th style="width: 5%;">
                                Năm
                            </th>
                            <th style="width: 10%">
                                Hình thức
                            </th>
                            <th style="width: 5%">
                                Số lượng
                            </th>
                            <th style="width: 20%">
                                Ghi chú
                            </th>
                            <th style="width: 0%" class="text-center">
                                Hành động
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php    
                        for ($i = 0; $i < count($data); $i++) {
                            $row = $data[$i];
                            $canEdit = Core::_checkPerActionArr($user->id, 'com_tochuc', 'tochuc', ['task' => 'au_edit_quydinhcappho', 'location' => 'site', 'non_action' => 'false']);
                            $canDelete = Core::_checkPerActionArr($user->id, 'com_tochuc', 'tochuc', ['task' => 'au_del_quydinhcappho', 'location' => 'site', 'non_action' => 'false']);
                            ?>
                            <tr>
                                <td style="padding-left: 0.75rem;"><?php echo $i+1?></td>
                                <td><?php echo $row['nam'];?></td>
                                <td><?php echo $hinhthuc[$row['hinhthuc_id']]['ten'];?></td>
                                <td><?php echo $row['soluong'];?></td>
                                <td><?php echo $row['ghichu'];?></td>
                                <td nowrap="nowrap" class="text-center">
                                    <?php //if ($canEdit): ?>
                                        <a href="<?php echo Route::_('index.php'); ?>?view=tochuc&task=modal_quydinhcappho&format=raw&id=<?php echo $row['id'] ?>&donvi_id=<?php echo $this->donvi_id ?>" data-toggle="modal" data-target=".modal" class="btn btn-mini btn-info btnEditQuatrinh" data-quatrinh-id="<?php echo $row['id'] ?>"><i class="fas fa-pencil-alt"></i> Sửa</a>
                                    <?php // endif; ?>
                                    <?php //if ($canDelete): ?>
                                        <span class="btn btn-mini btn-danger btnXoaQuydinhcappho" href="index.php?option=com_tochuc&controller=tochuc&format=raw&task=delquydinhcappho&id=<?php echo $row['id'] ?>&donvi_id=<?php echo $this->donvi_id; ?>"><i class="fas fa-trash"></i> Xóa</span>
                                    <?php //endif; ?>
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
        $('#btn_add_quydinhcappho').on('click', function() {
            Pace.start();
            $('#div_modal').load('index.php?option=com_tochuc&view=tochuc&task=modal_quydinhcappho&format=raw&donvi_id=<?php echo $this->donvi_id; ?>', function() {
                Pace.stop();
            });
        });
        $('#btn_add_quatrinh').on('click', function() {
            $('#div_modal').load('index.php?option=com_tochuc&controller=tochuc&task=editquatrinh&format=raw&dept_id=', function() {});
        });
        $('.btnEditQuatrinh').on('click', function() {
            $('#div_modal').load(this.href, function() {});
        });
        $('.btnXoaQuydinhcappho').click(function() {
            if (confirm('Bạn có muốn xóa không?')) {
                $.ajax({
                    url: '<?php echo Uri::base(true); ?>' + $(this).attr('href'),
                    type: "POST",
                    success: function(data) {
                        if (data == true) {
                            $.toast({
                                heading: 'Thông báo',
                                text: "Thao tác thành công!",
                                showHideTransition: 'fade',
                                position: 'top-right',
                                icon: 'success'
                            });
                            $.blockUI();
                            jQuery.ajax({
                                type: "GET",
                                url: '<?php echo Route::_('index.php'); ?>?view=tochuc&task=quydinhcappho&format=raw&Itemid=<?php echo $this->Itemid; ?>&id=<?php echo $this->item->id; ?>',
                                success: function(data, textStatus, jqXHR) {
                                    $.unblockUI();
                                    $('#modal_tochuc').modal('hide');
                                    $('#quydinhcappho-quatrinh').html(data);
                                }
                            });
                        } else {
                            $.toast({
                                heading: 'Thông báo',
                                text: "Có lỗi xảy ra, vui lòng liên hệ quản trị viên!",
                                showHideTransition: 'fade',
                                position: 'top-right',
                                icon: 'error'
                            });
                        }
                    }
                });
            }
            return false;
        });
    });

    function deleteFileById(id, url) {
        if (confirm('Bạn có muốn xóa không?')) {
            jQuery.ajax({
                type: "DELETE",
                url: url,
                success: function(data, textStatus, jqXHR) {
                    var element = document.getElementById('file_' + id);
                    element.parentNode.removeChild(element);
                    //console.log(data);
                }
            });
        }
        return false;
    }
</script>