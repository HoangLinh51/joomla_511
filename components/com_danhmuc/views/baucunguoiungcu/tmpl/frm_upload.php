<h4 class="header lighter blue">Chức năng import Người ứng cử từ tập tin excel
    <span class="pull-right inline">
        <span id="btn_back_nguoiungcu" class="btn btn-danger">Quay lại</span>
    </span>
</h4>
<div id="divimport">
    <div>
        Chọn tệp tin để upload:
        <input type="file" id="fileupload" name="fileupload" />
        <a data-original-title="Import" class="btn btn-small btn-primary" id="btn_import_fileupload" style="margin-right: 5px;">
            <i class="icon-upload"></i> Import người ứng cử
        </a>
    </div>
    <div id="ketqua">
        <div class="alert alert-danger">
            <h4><u>Chú ý: </u></h4>
            <br> - Nếu chưa có mẫu chuẩn, vui lòng bấm vào đây để tải mẫu. <a style="cursor: pointer;" href="components\com_danhmuc\views\baucunguoiungcu\tmpl\import_nguoiungcu.xlsx" id="btn_export_mauexcel">Tải mẫu excel</a>
            <hr>
            <h4><u>Hướng dẫn nhập liệu vào mẫu:</u></h4>
            <br> - Nội dung file import phải đúng các định dạng có ghi chú trong file.
            <br> - Các cột, hàng không được thay đổi vị trí, cũng như số lượng.
            <br> - Thông tin import phải đảm bảo chính xác và mới nhất.
            <br> - Dữ liệu ngày tháng năm nhập theo định dạng: dd-mm-yyyy. VD: 25-12-1987.
            <br> - Chỉ nhập danh sách người ứng cử, không tự ý phân cách các dòng theo phòng/ban.
            <br> - Các mục màu đỏ yêu cầu bắt buộc nhập.
        </div>
    </div>
</div>
<script type="text/javascript">
    function getExtension(filename) {
        var parts = filename.split('.');
        return parts[parts.length - 1];
    }

    function isExcel(filename) {
        var ext = getExtension(filename);
        switch (ext.toLowerCase()) {
            case 'xls':
            case 'xlsx':
            case 'csv':
                return true;
        }
        return false;
    }
    jQuery(document).ready(function($) {
        $('#btn_back_nguoiungcu').on('click', function(){
            $('#div_danhsach_nguoiungcu').css('display','');
			$('#div_upload_nguoiungcu').css('display','none');
        })
        $('#btn_import_fileupload').on('click', function() {
            var filefullname = $('#fileupload').val();
            var file_data = $('#fileupload').prop('files')[0];
            var form_data = new FormData();
            form_data.append('file', file_data);
            console.log(form_data);
            if (filefullname == "") {
                alert('Vui lòng chọn tệp tin');
            } else {
                if ((isExcel(filefullname)) && ((filefullname.split(".").length - 1) == 1)) {
                    $.blockUI();
                    $.ajax({
                        type: 'POST',
                        url: 'index.php?option=com_danhmuc&controller=baucunguoiungcu&format=raw&task=upload_nguoiungcu',
                        data: form_data,
                        dataType: 'text',
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function(data) {
                            $.unblockUI();
                            $('#btn_back_nguoiungcu').click();
                            $('#btn_flt_baucunguoiungcu').click();

                            $('#fileupload').val('');
                            loadNoticeBoard('Thông báo', 'Upload thành công!');
                        },
                        error: function(data) {
                            loadNoticeBoardError('Thông báo', 'Có lỗi phát sinh, vui lòng thử lại sau!!!');
                            $.unblockUI();
                        }
                    });
                } else loadNoticeBoardError('Thông báo', 'Tập tin không hợp lệ!\n Các loại tập tin được hỗ trợ: xls, xlsx, csv.\n Vui lòng chọn lại file!!!');
            }
        });
        // $('#btn_export_mauexcel').on('click', function() {
        //     window.location.href = "index.php?option=com_danhmuc&controller=baucunguoiungcu&format=raw&task=export_mauexcel";
        //     return false;
        // })
    });
</script>