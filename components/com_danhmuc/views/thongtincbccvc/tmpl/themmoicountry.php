<?php 
	$country_id = JRequest::getVar('id');
	if($country_id){
		$country = $this->country;
	}
?>
<form id="form_country" class="form-horizontal">
	<?php echo JHtml::_( 'form.token' ); ?>
	<div class="control-group">
		<label class="control-label" style="width:20%">Tên quốc gia <span style="color:red">*</span></label>
		<div class="controls">
			<input type="text" name="name" value="<?php if($country_id) echo $country['name']; ?>"/>
			<input type="hidden" name="id" value="<?php if($country_id) echo $country['code']; ?>"/>
		</div>
	</div>
</form>
<script>
	jQuery(document).ready(function($){
		$('#form_country').validate({
			rules:{
				name:{required:true},
				status:{required:true},
			},
			messages:{
				name:{required:"Vui lòng nhập tên"},
				status:{required:"Vui lòng chọn trạng thái"},
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