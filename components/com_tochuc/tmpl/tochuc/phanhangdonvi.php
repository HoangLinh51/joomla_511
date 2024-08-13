<?php

use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;
use Joomla\Component\Tochuc\Site\Helper\TochucHelper;

$user = Factory::getUser();
?>

<section class="content">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Quá trình phân hạng đơn vị</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-success btn-excel">
                    <i class="fa fa-file-excel"></i>
                </button>
                <button type="button" class="btn btn-primary btn-themmoi">
                    <i class="fa fa-plus"></i>
                </button>
            </div>
        </div>
        <div class="card-body p-0">
            <table class="table table-striped projects">
                <thead>
                    <tr>
                       
                        <th style="width: 10%; padding-left: 0.75rem;">
                            Ngày bắt đầu -
                            <br>
                            Ngày kết thúc
                        </th>
                        <th style="width: 10%">
                            Hình thức phân hạng
                        </th>
                        <th style="width: 5%">
                            Hạng đơn vị
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
                
                </tbody>
            </table>
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