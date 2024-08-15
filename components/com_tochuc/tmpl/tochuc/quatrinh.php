<?php

use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;
use Joomla\Component\Tochuc\Site\Helper\TochucHelper;

$user = Factory::getUser();
?>

<section class="content">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Lịch sử tổ chức</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-success btn-excel">
                    <i class="fa fa-file-excel"></i>
                </button>
                <button type="button" id="btn_add_quatrinh" data-toggle="modal" data-target=".modal" class="btn btn-primary btn-themmoi">
                    <i class="fa fa-plus"></i>
                </button>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped projects" style="margin-bottom: 0px;">
                    <thead>
                        <tr>
                            <th style="width: 15%; padding-left: 0.75rem;">
                                Ngày hiệu lực
                            </th>
                            <th style="width: 20%">
                                Cách thức
                            </th>
                            <!-- <th style="width: 20%">
                                Quyết định
                            </th> -->
                            <th style="width: 30%" class="text-center">
                                Chi tiết
                            </th>
                            <th style="width: 10%">
                                Ghi chú
                            </th>
                            <th style="width: 15%" class="text-right">
                                #
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        for ($i = 0; $i < count($this->rows); $i++) {
                            $row = $this->rows[$i];
                            $vanban = TochucHelper::getVanBanById($row['vanban_id']);
                            if ($vanban != null) {
                                if (Core::loadResult('core_attachment', 'COUNT(*)', array('object_id=' => $vanban['id'], 'type_id=' => 1)) > 0) {
                                    $vanban['mahieu'] = '<a href="' . Uri::root(true) . '/uploader/index.php?download=1&type_id=1&object_id=' . $vanban['id'] . '" target="_blank">' . $vanban['mahieu'] . '</a>';
                                }
                            } else {
                                $vanban = array();
                            }
                        ?>
                            <tr>

                                <td style="padding-left: 0.75rem;">
                                    <?php echo ($row['hieuluc_ngay'] == '0000-00-00' ? "" : date('d/m/Y', strtotime($row['hieuluc_ngay']))); ?>
                                </td>
                                <td>
                                    <?php echo TochucHelper::getNameById($row['cachthuc_id'], 'ins_dept_cachthuc'); ?>
                                    <br style="<?php echo $vanban['mahieu'] == '' ? "display:none;" : ""  ?>">
                                    <small style="<?php echo $vanban['mahieu'] == '' ? "display:none;" : ""  ?>">
                                        Số quyết định: <?php echo $vanban['mahieu']; ?>
                                    </small>
                                    <br>
                                    <small>
                                        Ngày quyết định: <?php echo date('d/m/Y', strtotime($row['quyetdinh_ngay'])); ?>
                                    </small>

                                </td>
                                <!-- <td class="">
                                <?php echo $vanban['mahieu']; ?>
                                <br>
                                <small style="<?php echo $vanban['mahieu'] == '' ? "display:none;" : ""  ?>" >
                                    Ngày quyết định  <?php echo date('d/m/Y', strtotime($row['quyetdinh_ngay'])); ?>
                                </small>
                            </td> -->
                                <td class="">
                                    <?php echo $row['chitiet']; ?>
                                </td>
                                <td class="">
                                    <?php echo $row['ghichu']; ?>
                                </td>
                                <td class="project-actions text-right">
                                    <a class="btn btn-info btn-sm" href="#"><i class="fas fa-pencil-alt"></i> Sửa</a>
                                    <a class="btn btn-danger btn-sm" href="#"><i class="fas fa-trash"></i> Xóa</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>


    </div>

</section>
<script type="text/javascript">
    jQuery(document).ready(function($) {
        $('.datepicker_qd').datepicker({
            autoclose: true
        })
        $('#btn_export_lichsu').on('click', function() {
            document.location.assign(this.href);
            return false;
        });
        $('#btn_add_quatrinh').on('click', function() {
            $('#div_modal').load('?view=tochuc&task=modal_quatrinh&format=raw&dept_id=<?php echo $this->item->id; ?>', function() {});
        });
        $('.btnEditQuatrinh').on('click', function() {
            $('#div_modal').load(this.href, function() {});
        });
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