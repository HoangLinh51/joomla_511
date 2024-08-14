<?php

use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;
use Joomla\Component\Tochuc\Site\Helper\TochucHelper;

$user = Factory::getUser();
?>

<section class="content">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Quá trình khen thưởng</h3>
            <div class="card-tools">
                <!-- <button type="button" class="btn btn-success btn-excel">
                    <i class="fa fa-file-excel"></i>
                </button> -->
                <button type="button" id="btnAddKhenthuong" data-toggle="modal" data-target=".modal" class="btn btn-primary btn-themmoi">
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
                                Từ ngày
                            </th>
                            <th style="width: 10%">
                                Đến ngày
                            </th>
                            <th style="width: 5%">
                                Hình thức
                            </th>
                            <th style="width: 45%" class="text-center">
                                Lý do
                            </th>
                            <th style="width: 5%">
                                Số QĐ
                            </th>
                            <th style="width: 5%" class="text-right">
                                #
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $totalItems = count($this->quatrinh_khenthuong);
                        for ($i = 0; $i < $totalItems; $i++) {
                            $row = $this->quatrinh_khenthuong[$i];
                            $canEdit = Core::_checkPerActionArr($user->id, 'com_tochuc', 'tochuc', ['task' => 'au_edit_khenthuong', 'location' => 'site', 'non_action' => 'false']);
                            $canDelete = Core::_checkPerActionArr($user->id, 'com_tochuc', 'tochuc', ['task' => 'au_del_khenthuong', 'location' => 'site', 'non_action' => 'false']);

                        ?>
                            <tr>
                                <td><?php echo date('d/m/Y', strtotime($row->start_date_kt)); ?></td>
                                <td><?php if ((isset($row->end_date_kt)) && ($row->end_date_kt != null) && ($row->end_date_kt != '0000-00-00')) echo date('d/m/Y', strtotime($row->end_date_kt)); ?></td>
                                <td><?php echo $row->hinhthuc; ?></td>
                                <td><?php echo $row->reason_kt; ?></td>
                                <td><?php echo $row->approv_number_kt; ?></td>
                                <td><?php echo $row->approv_unit_kt; ?></td>
                                <td><?php echo $row->approv_per_kt; ?></td>
                                <td><?php if ((isset($row->approv_date_kt)) && ($row->approv_date_kt != null)) echo date('d/m/Y', strtotime($row->approv_date_kt)); ?></td>
                                <td nowrap="nowrap">
                                    <?php if ($canEdit): ?>
                                        <span class="btn btn-mini btn-info btnEditQuatrinh" data-toggle="modal" data-target=".modal" href="index.php?option=com_tochuc&controller=tochuc&task=editkhenthuong&format=raw&id=<?php echo $row->id_kt ?>"><i class="icon-pencil"></i></span>
                                    <?php endif; ?>
                                    <?php if ($canDelete): ?>
                                        <span class="btn btn-mini btn-danger btnDeleteQuatrinh" task="removekhenthuong" id_qt="<?php echo $row->id_kt ?>"><i class="icon-trash"></i></span>
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


<section class="content">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Quá trình kỷ luật</h3>
            <div class="card-tools">
                <button type="button" id="btnAddKyluat" data-toggle="modal" data-target=".modal" class="btn btn-primary btn-themmoi">
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
                                Từ ngày
                            </th>
                            <th style="width: 10%">
                                Đến ngày
                            </th>
                            <th style="width: 5%">
                                Hình thức
                            </th>
                            <th style="width: 45%" class="text-center">
                                Lý do
                            </th>
                            <th style="width: 5%">
                                Số QĐ
                            </th>
                            <th style="width: 5%" class="text-right">
                                #
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $totalItems = count($this->quatrinh_khenthuong);
                        for ($i = 0; $i < $totalItems; $i++) {
                            $row = $this->quatrinh_khenthuong[$i];
                            $canEdit = Core::_checkPerActionArr($user->id, 'com_tochuc', 'tochuc', ['task' => 'au_edit_kyluat', 'location' => 'site', 'non_action' => 'false']);
                            $canDelete = Core::_checkPerActionArr($user->id, 'com_tochuc', 'tochuc', ['task' => 'au_del_kyluat', 'location' => 'site', 'non_action' => 'false']);

                        ?>
                            <tr>
                                <td><?php echo date('d/m/Y', strtotime($row->start_date_kl)); ?></td>
                                <td><?php if ((isset($row->end_date_kl)) && ($row->end_date_kl != null) && ($row->end_date_kl != '0000-00-00')) echo date('d/m/Y', strtotime($row->end_date_kl)); ?></td>
                                <td><?php echo $row->hinhthuc; ?></td>
                                <td><?php echo $row->reason_kl; ?></td>
                                <td><?php echo $row->approv_number_kl; ?></td>
                                <td><?php echo $row->approv_unit_kl; ?></td>
                                <td><?php echo $row->approv_per_kl; ?></td>
                                <td><?php if ((isset($row->approv_date_kl)) && ($row->approv_date_kl != null)) echo date('d/m/Y', strtotime($row->approv_date_kl)); ?></td>
                                <td nowrap="nowrap">
                                    <?php if ($canEdit): ?>
                                        <span class="btn btn-mini btn-info btnEditQuatrinh" data-toggle="modal" data-target=".modal" href="index.php?option=com_tochuc&controller=tochuc&task=editkyluat&format=raw&ht=2&id=<?php echo $row->id_kl ?>"><i class="icon-pencil"></i></span>
                                    <?php endif; ?>
                                    <?php if ($canDelete): ?>
                                        <span class="btn btn-mini btn-danger btnDeleteQuatrinh" task="removekyluat" id_qt="<?php echo $row->id_kl ?>"><i class="icon-trash"></i></span>
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