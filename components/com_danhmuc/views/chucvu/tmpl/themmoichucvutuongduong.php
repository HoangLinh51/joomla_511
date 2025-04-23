<?php 
	$id_cvtd = JRequest::getVar('id');
	if($id_cvtd){
		$cvtd = $this->cvtd;
	}
?>
<form id="form_chucvutuongduong" class="form-horizontal">
	<?php echo JHtml::_( 'form.token' ); ?>
	<div class="control-group">
		<label class="control-label" style="width:20%">Tên chức vụ tương đương <span style="color:red">*</span></label>
		<div class="span6">
			<input type="text" name="position" id="position" value="<?php if($id_cvtd) echo $cvtd['position']; ?>" class="span5">
			<input type="hidden" name="id" id="id" value="<?php if($id_cvtd) echo $cvtd['id']; ?>">
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" style="width:20%">Tên chức vụ tương đương 2 <span style="color:red">*</span></label>
		<div class="span6">
			<input type="text" name="position2" id="position2" value="<?php if($id_cvtd) echo $cvtd['position2']; ?>" class="span5">
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" style="width:20%">Tên chức vụ tương đương 3 <span style="color:red">*</span></label>
		<div class="span6">
			<input type="text" name="position3" id="position3" value="<?php if($id_cvtd) echo $cvtd['position3']; ?>" class="span5">
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" style="width:20%">Mức tương đương <span style="color:red">*</span></label>
		<div class="span6">
			<input type="text" name="level" id="level" value="<?php if($id_cvtd) echo $cvtd['level']; ?>" class="span5">
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" style="width:20%">Cấp bậc <span style="color:red">*</span></label>
		<div class="span6">
			<select name="type_org" class="span5">
				<option value="">Chọn cấp bậc chức vụ</option>
				<option value="1" <?php if($id_cvtd&&$cvtd['type_org']==1) echo 'selected'; ?>>Sở ban ngành</option>
				<option value="2" <?php if($id_cvtd&&$cvtd['type_org']==2) echo 'selected'; ?>>Quận huyện</option>
				<option value="3" <?php if($id_cvtd&&$cvtd['type_org']==3) echo 'selected'; ?>>Phường xã</option>
			</select>
		</div>
	</div>
	<div class="control-group" >
		<label class="control-label" style="width:20%">Trạng thái <span style="color:red">*</span></label>
		<div class="span6">
			<label>
				<input type="radio" name="active" value="1" <?php if($id_cvtd&&$cvtd['active']==1) echo 'checked'; ?> ><span class="lbl">Đang hoạt động</span>
			</label>
			<label>
				<input type="radio" name="active" value="0" <?php if($id_cvtd&&$cvtd['active']==0) echo 'checked'; ?>><span class="lbl">Không hoạt động</span>
			</label>
		</div>
	</div>
</form>
<script>
	jQuery(document).ready(function($){
		$('#form_chucvutuongduong').validate({
            rules:{
                position: {required: true},
                position2: {required: true},
                position3: {required: true},
                level: {required: true},
                type_org:{required:true},
                active:{required:true}
            },
            messages:{
               	position: {required:"Vui lòng nhập tên chức vụ tương đương"},
                position2: {required:"Vui lòng nhập tên chức vụ tương đương 2"},
                position3: {required:"Vui lòng nhập tên chức vụ tương đương 3"},
                level: {required:"Vui lòng nhập mức tương đương"},
                type_org:{required:"Vui lòng chọn cấp bậc"},
                active:{required:"Vui lòng chọn trạng thái"}
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