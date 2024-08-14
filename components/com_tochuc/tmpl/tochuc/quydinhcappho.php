<?php

use Joomla\CMS\Factory;
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

                            <th style="width: 10%; padding-left: 0.75rem;">
                                Năm
                            </th>
                            <th style="width: 10%">
                                Hình thức
                            </th>
                            <th style="width: 5%">
                                Số lượng
                            </th>
                            <th style="width: 20%" class="text-center">
                                Ghi chú
                            </th>
                            <th style="width: 10%" class="text-right">
                                #
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
                                <td><?php echo $i+1?></td>
                                <td><?php echo $row['nam'];?></td>
                                <td><?php echo $hinhthuc[$row['hinhthuc_id']]['ten'];?></td>
                                <td><?php echo $row['soluong'];?></td>
                                <td><?php echo $row['ghichu'];?></td>
                                <td nowrap="nowrap">
                                    <?php if ($canEdit): ?>
                                        <a href="index.php?option=com_tochuc&controller=tochuc&task=editquydinhcappho&format=raw&id=<?php echo $row['id'] ?>&donvi_id=<?php echo $this->donvi_id?>" data-toggle="modal" data-target=".modal" class="btn btn-mini btn-info btnEditQuatrinh" data-quatrinh-id="<?php echo $row['id'] ?>"><i class="icon-pencil"></i></a>
                                        <?php endif; ?>
                                    <?php if ($canEdit): ?>
                                        <span class="btn btn-mini btn-danger btnXoaQuydinhcappho" href="index.php?option=com_tochuc&controller=tochuc&format=raw&task=delquydinhcappho&id=<?php echo $row['id'] ?>&donvi_id=<?php echo $this->donvi_id;?>"><i class="icon-trash"></i></span>
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
        $('#btn_add_quatrinh').on('click', function() {
            $('#div_modal').load('index.php?option=com_tochuc&controller=tochuc&task=editquatrinh&format=raw&dept_id=<?php echo $this->item->id; ?>', function() {});
        });
        $('.btnEditQuatrinh').on('click', function() {
            $('#div_modal').load(this.href, function() {});
        });

        // $('.input-mask-date').mask('99/99/9999');
        // $('#frmQuaTrinh').validate({
        //     ignore: [],
        //     rules: {
        //         cachthuc_id: {
        //             required: true,
        //         },
        //         quyetdinh_ngay: {
        //             required: true,
        //             dateVN: true
        //         }
        //     }
        // });
        $('.btnDeleteQuatrinh').click(function() {
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
                                url: 'index.php?option=com_tochuc&task=quatrinh&format=raw&Itemid=<?php echo $this->Itemid; ?>&id=<?php echo $this->item->id; ?>',
                                success: function(data, textStatus, jqXHR) {
                                    $.unblockUI();
                                    $('#tochuc-quatrinh').html(data);
                                }
                            });
                        } else {
                            loadNoticeBoardError('Thông báo', 'Có lỗi xảy ra, vui lòng liên hệ quản trị viên!');
                            console.log(data);
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