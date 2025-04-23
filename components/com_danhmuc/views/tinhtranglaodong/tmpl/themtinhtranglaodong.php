<?php 
	defined('_JEXEC') or die('Restricted Access');
	$ttld_id = JRequest::getVar('id');
	if($ttld_id){
		$ttld = $this->ttld;
	}
?>
<form id="form_ttld" method="post">
	<?php echo JHtml::_( 'form.token' ); ?>
	<table>
		<tr>
			<td>Mã <span style="color:red">*</span></td>
			<td><input type="text" name="ma" id="ma" value="<?php if($ttld_id) echo $ttld['ma'] ?>">
				<input type="hidden" name="id" id="id" value="<?php if($ttld_id) echo $ttld['id'] ?>"></td>
		</tr>
		<tr>
			<td>Tên <span style="color:red">*</span></td>
			<td><input type="text" name="ten" id="ten" value="<?php if($ttld_id) echo $ttld['ten'] ?>"></td>
		</tr>
		<tr>
			<td>Trạng thái <span style="color:red">*</span></td>
			<td>
                <label>
                  <input type="radio" name="trangthai" value="1" <?php echo ($ttld_id && $ttld['trangthai']==1)?'checked':''?>>
                  <span class="lbl"> Đang hoạt động</span>
                </label>
                <label>
                  <input type="radio" name="trangthai" value="0" <?php echo ($ttld_id && $ttld['trangthai']==0)?'checked':''?>>
                  <span class="lbl">Không hoạt động</span>
                </label>
            </td>
		</tr>
	</table>
</form>
<script>
	jQuery(document).ready(function($){
		$('#form_ttld').validate({
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