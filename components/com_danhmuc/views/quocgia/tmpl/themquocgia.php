<?php 
	defined('_JEXEC') or die('Restricted Access');
	$quocgia_id = JRequest::getVar('id');
	if($quocgia_id){
		$quocgia = $this->quocgia;
	}
?>
<form id="form_quocgia" method="post">
	<?php echo JHtml::_( 'form.token' ); ?>
	<table>
		<tr>
			<td>Tên Quốc gia <span style="color:red">*</span></td>
			<td><input type="text" name="name" id="name" value="<?php if($quocgia_id) echo $quocgia['name'] ?>">
                <input type="hidden" name="code" id="code" value="<?php if($quocgia_id) echo $quocgia['code'] ?>">
		</tr>
	</table>
</form>
<script>
	jQuery(document).ready(function($){
		$('#form_quocgia').validate({
            rules:{
                name: {required: true},
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