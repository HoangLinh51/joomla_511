<?php 
	defined('_JEXEC') or die('Restricted Access');
	$quanhegiadinh_id = JRequest::getVar('id');
	if($quanhegiadinh_id){
		$quanhegiadinh = $this->quanhegiadinh;
	}
?>
<form id="form_quanhegiadinh" method="post">
	<?php echo JHtml::_( 'form.token' ); ?>
	<table>
		<!-- <tr>
			<td>Mã</td>
			<td><input type="text" name="ma" id="ma" value="<?php if($quanhegiadinh_id) echo $quanhegiadinh['ma'] ?>">
				</td>
		</tr> -->
		<tr>
			<td>Tên <span style="color:red">*</span></td>
			<td><input type="text" name="name" id="name" value="<?php if($quanhegiadinh_id) echo $quanhegiadinh['name'] ?>">
                <input type="hidden" name="id" id="id" value="<?php if($quanhegiadinh_id) echo $quanhegiadinh['id'] ?>">
            	<input type="hidden" name="type" id="type" value="1"></td>
		</tr>
		<tr>
			<td>Trạng thái <span style="color:red">*</span></td>
			<td>
                <label>
                    <input type="radio" name="status" value="1" <?php echo ($quanhegiadinh_id && $quanhegiadinh['status']==1)?'checked':''?>>
                    <span class="lbl"> Đang hoạt động</span>
                </label>
                <label>
                    <input type="radio" name="status" value="0" <?php echo ($quanhegiadinh_id && $quanhegiadinh['status']==0)?'checked':''?>>
                    <span class="lbl">Không hoạt động</span>
                </label>
            </td>
		</tr>
	</table>
</form>
<script>
	jQuery(document).ready(function($){
		$('#form_quanhegiadinh').validate({
            rules:{
                name: {required: true},
                status:{required:true},
            },
            messages:{
                name: {required:"Vui lòng nhập tên"},
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