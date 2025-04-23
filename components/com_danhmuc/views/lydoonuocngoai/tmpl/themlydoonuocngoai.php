<?php 
	defined('_JEXEC') or die('Restricted Access');
	$lydoonuocngoai_id = JRequest::getVar('id');
	if($lydoonuocngoai_id){
		$lydoonuocngoai = $this->lydoonuocngoai;
	}
?>
<form id="form_lydoonuocngoai" method="post">
	<?php echo JHtml::_( 'form.token' ); ?>
	<table>
		<tr>
			<td>Mã <span style="color:red">*</span></td>
			<td><input type="text" name="ma" id="ma" value="<?php if($lydoonuocngoai_id) echo $lydoonuocngoai['ma'] ?>">
				<input type="hidden" name="id" id="id" value="<?php if($lydoonuocngoai_id) echo $lydoonuocngoai['id'] ?>"></td>
		</tr>
		<tr>
			<td>Tên <span style="color:red">*</span></td>
			<td><input type="text" name="ten" id="ten" value="<?php if($lydoonuocngoai_id) echo $lydoonuocngoai['ten'] ?>"></td>
		</tr>
		<tr>
			<td>Trạng thái <span style="color:red">*</span></td>
			<td>
                <label>
                    <input type="radio" name="trangthai" value="1" <?php echo ($lydoonuocngoai_id && $lydoonuocngoai['trangthai']==1)?'checked':''?>>
                    <span class="lbl"> Đang hoạt động</span>
                </label>
                <label>
                    <input type="radio" name="trangthai" value="0" <?php echo ($lydoonuocngoai_id && $lydoonuocngoai['trangthai']==0)?'checked':''?>>
                    <span class="lbl">Không hoạt động</span>
                </label>
            </td>
		</tr>
	</table>
</form>
<script>
	jQuery(document).ready(function($){
		$('#form_lydoonuocngoai').validate({
            rules:{
                ma: {required: true},
                ten: {required: true},
                trangthai:{required:true}
            },
            messages:{
                ma: {required:"Vui lòng nhập mã"},
                ten: {required:"Vui lòng nhập tên"},
            },
            invalidHandler: function (event, validator) {
                var errors = validator.numberOfInvalids();
                if (errors) {
                        var message = errors == 1
                        ? 'Kiểm tra lỗi sau:<br/>'
                        : 'Phát hiện ' + errors + ' lỗi sau:<br/>';
                        var errors = "";
                        if (validator.errorList.length > 0) {
                            for (x=0;x<validator.errorList.length;x++) {
                                    errors += "<br/>\u25CF " + validator.errorList[x].message;
                            }
                        }
                        loadNoticeBoardError('Thông báo',message + errors);
                }
                validator.focusInvalid();
            },
            errorPlacement: function(error, element) {
            }
        });
	});
</script>