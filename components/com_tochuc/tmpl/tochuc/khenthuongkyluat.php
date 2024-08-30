<?php

use Joomla\CMS\Factory;
use Joomla\CMS\Router\Route;
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
                            <th style="width: 20%">
                                Hình thức
                            </th>
                            <th style="width: 20%">
                                Lý do
                            </th>
                            <th style="width: 5%">
                                Số QĐ
                            </th>
                            <th style="width: 15%">
                                Cơ quan QĐ
                            </th>
                            <th style="width: 10%">
                                Người ký
                            </th>
                            <th style="width: 10%">
                                Ngày ký
                            </th>
                            <th style="width: 10%; padding-right: 0.75rem;">
                                Hành động
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
                                <td style="padding-left: 0.75rem;"><?php echo date('d/m/Y', strtotime($row->start_date_kt)); ?></td>
                                <td><?php if ((isset($row->end_date_kt)) && ($row->end_date_kt != null) && ($row->end_date_kt != '0000-00-00')) echo date('d/m/Y', strtotime($row->end_date_kt)); ?></td>
                                <td><?php echo $row->hinhthuc; ?></td>
                                <td><?php echo $row->reason_kt; ?></td>
                                <td><?php echo $row->approv_number_kt; ?></td>
                                <td><?php echo $row->approv_unit_kt; ?></td>
                                <td><?php echo $row->approv_per_kt; ?></td>
                                <td><?php if ((isset($row->approv_date_kt)) && ($row->approv_date_kt != null)) echo date('d/m/Y', strtotime($row->approv_date_kt)); ?></td>
                                <td style="padding-right: 0.75rem;" nowrap="nowrap">
                                    <?php if ($canEdit): ?>
                                        <a href="<?php echo Uri::base(true); ?>/index.php/component/tochuc?view=tochuc&task=modal_khenthuong&format=raw&id=<?php echo $row->id_kt ?>" data-toggle="modal" data-target=".modal" class="btn btn-mini btn-info btnEditKhenthuong"><i class="fas fa-pencil-alt"></i> Sửa</a>
                                    <?php endif; ?>
                                    <?php if ($canDelete): ?>
                                        <span class="btn btn-mini btn-danger btnDeleteQuatrinh" task="removekhenthuong" id_qt="<?php echo $row->id_kt ?>"><i class="fas fa-trash"></i> Xóa</span>
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
                            <th style="width: 20%">
                                Hình thức
                            </th>
                            <th style="width: 20%">
                                Lý do
                            </th>
                            <th style="width: 5%">
                                Số QĐ
                            </th>
                            <th style="width: 15%">
                                Cơ quan QĐ
                            </th>
                            <th style="width: 10%">
                                Người ký
                            </th>
                            <th style="width: 10%">
                                Ngày ký
                            </th>
                            <th style="width: 10%; padding-right: 0.75rem;">
                                Hành động
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $totalKyluat = count($this->quatrinh_kyluat);
                        for ($i = 0; $i < $totalKyluat; $i++) {
                            $row = $this->quatrinh_kyluat[$i];
                            $canEdit = Core::_checkPerActionArr($user->id, 'com_tochuc', 'tochuc', ['task' => 'au_edit_kyluat', 'location' => 'site', 'non_action' => 'false']);
                            $canDelete = Core::_checkPerActionArr($user->id, 'com_tochuc', 'tochuc', ['task' => 'au_del_kyluat', 'location' => 'site', 'non_action' => 'false']);

                        ?>
                            <tr>
                                <td style="padding-left: 0.75rem;"><?php echo date('d/m/Y', strtotime($row->start_date_kl)); ?></td>
                                <td><?php if ((isset($row->end_date_kl)) && ($row->end_date_kl != null) && ($row->end_date_kl != '0000-00-00')) echo date('d/m/Y', strtotime($row->end_date_kl)); ?></td>
                                <td><?php echo $row->hinhthuc; ?></td>
                                <td><?php echo $row->reason_kl; ?></td>
                                <td><?php echo $row->approv_number_kl; ?></td>
                                <td><?php echo $row->approv_unit_kl; ?></td>
                                <td><?php echo $row->approv_per_kl; ?></td>
                                <td><?php if ((isset($row->approv_date_kl)) && ($row->approv_date_kl != null)) echo date('d/m/Y', strtotime($row->approv_date_kl)); ?></td>
                                <td style="padding-right: 0.75rem;" nowrap="nowrap">
                                    <?php if ($canEdit): ?>
                                        <a href="<?php echo Uri::base(true); ?>/index.php/component/tochuc?view=tochuc&task=modal_kyluat&format=raw&id=<?php echo $row->id_kl ?>" data-toggle="modal" data-target=".modal" class="btn btn-mini btn-info btnEditKyluat"><i class="fas fa-pencil-alt"></i> Sửa</a>
                                    <?php endif; ?>
                                    <?php if ($canDelete): ?>
                                        <span class="btn btn-mini btn-danger btnDeleteQuatrinh" task="removekyluat" id_qt="<?php echo $row->id_kl ?>"><i class="fas fa-trash"></i> Xóa</span>
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
        $('#btnAddKhenthuong').click(function() {
            Pace.start();
            $.blockUI();
			$("#div_modal").load('index.php?option=com_tochuc&view=tochuc&task=modal_khenthuong&format=raw&dept_id=<?php echo $this->item->id; ?>&time=<?php echo time(); ?>', function(){
                Pace.stop();
                $.unblockUI();
            });
		});

        $('#btnAddKyluat').click(function() {
            Pace.start();
			$("#div_modal").load('index.php?option=com_tochuc&view=tochuc&task=modal_kyluat&format=raw&dept_id=<?php echo $this->item->id; ?>&time=<?php echo time(); ?>', function(){
                Pace.stop();
            });
		});

       
        $('.btnEditKhenthuong').on('click', function() {
            $.blockUI();
            $('#div_modal').load(this.href, function() {
                $.unblockUI();
            });
        });

        $('.btnEditKyluat').on('click', function() {
            $.blockUI();
            $('#div_modal').load(this.href, function() {
                $.unblockUI();
            });
        });

        
        $('.btnDeleteQuatrinh').click(function() {
            if (confirm('Bạn có muốn xóa không?')) {
                var id_qt = $(this).attr('id_qt');
				var task = $(this).attr('task');
                $.ajax({
                    url: '<?php echo Uri::base(true); ?>/index.php?option=com_tochuc&controller=tochuc&format=raw&task=' + task,
                    type: "POST",
					data: {
						id: id_qt
					},
                    success: function(data) {
                        if (data == true) {
                            
                            $.blockUI();
                            jQuery.ajax({
                                type: "GET",
                                url: 'index.php?option=com_tochuc&view=tochuc&task=khenthuongkyluat&format=raw&Itemid=<?php echo $this->Itemid; ?>&id=<?php echo $this->item->id; ?>',
                                success: function(data, textStatus, jqXHR) {
                                    $.unblockUI();
                                    loadNoticeBoardSuccess('Thông báo', 'Thao tác thành công!');
                                    $('#khenthuongkyluat-quatrinh').html(data);
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