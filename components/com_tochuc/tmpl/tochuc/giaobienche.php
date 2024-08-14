<?php

use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;
use Joomla\Component\Tochuc\Site\Helper\TochucHelper;

$user = Factory::getUser();
?>

<section class="content">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Quá trình giao biên chế</h3>
            <div class="card-tools">
                <!-- <button type="button" class="btn btn-success btn-excel">
                    <i class="fa fa-file-excel"></i>
                </button> -->
                <button type="button" id="btn_add_giaobienche" data-toggle="modal" data-target=".modal" class="btn btn-primary btn-themmoi">
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
                                Nghiệp vụ
                            </th>
                            <th style="width: 10%">
                                Nghị quyết
                            </th>
                            <th style="width: 30%" class="text-center">
                                Chi tiết
                            </th>
                            <th style="width: 30%" class="text-center">
                                Ghi chú
                            </th>
                            <th style="width: 10%" class="text-right">
                                #
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php

                        // Retrieve the total count of quatrinh_bienche only once
                        $totalItems = count($this->quatrinh_bienche);

                        for ($i = 0; $i < $totalItems; $i++) {
                            // Retrieve the row data
                            $row = $this->quatrinh_bienche[$i];
                            
                            // Fetch the document details by ID
                            $vanban = TochucHelper::getVanBanById($row['vanban_id']);
                            
                            if ($vanban !== null) {
                                // Check if there are attachments for this document
                                $hasAttachment = Core::loadResult('core_attachment', 'COUNT(*)', [
                                    'object_id' => $vanban['id'],
                                    'type_id'   => 1
                                ]) > 0;
                                
                                if ($hasAttachment) {
                                    // Set default label if 'mahieu' is empty
                                    $vanban['mahieu'] = $vanban['mahieu'] ?: 'Tập tin đính kèm';
                                    
                                    // Create a download link for the document
                                    $vanban['mahieu'] = sprintf(
                                        '<a href="%s/uploader/index.php?download=1&type_id=1&object_id=%d" target="_blank">%s</a>',
                                        Uri::root(true),
                                        $vanban['id'],
                                        htmlspecialchars($vanban['mahieu'])
                                    );
                                }
                            } else {
                                // Clear the vanban variable if not found
                                $vanban = [];
                            }
                            
                            // Continue with your logic to use $vanban...
                        ?>
                        <?php
                            // Fetch necessary data before rendering the HTML
                            $nghiepvuName = TochucHelper::getNameById($row['nghiepvu_id'], 'ins_nghiepvu_bienche', 'nghiepvubienche', 'id');
                            $biencheDetails = TochucHelper::getQuatrinhBiencheChiTietByQuatrinhId($row['id']);
                            $canEdit = Core::_checkPerActionArr($user->id, 'com_tochuc', 'tochuc', ['task' => 'au_edit_giaobienche', 'location' => 'site', 'non_action' => 'false']);
                            $canDelete = Core::_checkPerActionArr($user->id, 'com_tochuc', 'tochuc', ['task' => 'au_del_giaobienche', 'location' => 'site', 'non_action' => 'false']);
                        ?>

                            <tr>
                                <td nowrap="nowrap"><?php echo htmlspecialchars($row['nam'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td nowrap="nowrap"><?php echo htmlspecialchars($nghiepvuName, ENT_QUOTES, 'UTF-8'); ?></td>
                                <td nowrap="nowrap"><?php echo htmlspecialchars($vanban['mahieu'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td nowrap="nowrap">
                                    <ol>
                                        <?php foreach ($biencheDetails as $detail): ?>
                                            <li><?php echo htmlspecialchars($detail['name'], ENT_QUOTES, 'UTF-8'); ?>: <?php echo htmlspecialchars($detail['bienche'], ENT_QUOTES, 'UTF-8'); ?></li>
                                        <?php endforeach; ?>
                                    </ol>
                                    <!-- Commented-out details removed -->
                                </td>
                                <td><?php echo htmlspecialchars($row['ghichu'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td nowrap="nowrap">
                                    <?php if ($canEdit): ?>
                                        <a class="btn btn-mini btn-info btnEditQuatrinh" data-toggle="modal" data-target=".modal" href="index.php?option=com_tochuc&controller=tochuc&task=editgiaobienche&format=raw&id=<?php echo urlencode($row['id']); ?>">
                                            <i class="icon-pencil"></i>
                                        </a>
                                    <?php endif; ?>
                                    <?php if ($canDelete): ?>
                                        <span class="btn btn-mini btn-danger btnDeleteQuatrinh" href="index.php?option=com_tochuc&controller=tochuc&task=delgiaobienche&id=<?php echo urlencode($row['id']); ?>">
                                            <i class="icon-trash"></i>
                                        </span>
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