<?php 
defined('_JEXEC') or die('Restricted access');
$info = $this->info;
?>
<style>
.form-horizontal .controls {
    margin-left: 180px;
    margin-top: 6px;
}
</style>
<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 class="smaller lighter blue no-margin"><?php echo $info['id']>0?"Hiệu chỉnh":"Thêm mới"?> Năng lực đáp ứng VTVL</h3>
		</div>
		<div class="modal-body">
			<form class="form-horizontal" method="POST" name="frm_vtvlnangluc" id="frm_vtvlnangluc">
				<div class="row-fluid">
					<div class="control-group">
						<label class="control-label" for="name">Tên <span style="color:red;">*</span></label>
						<div class="controls">
							<input type="text" name="name" id="name" style="width:80%;" value="<?php echo $info['name']?>"/>
						</div>
					</div>
				</div>
				<div class="row-fluid">
					<div class="control-group">
						<label class="control-label" for="type">Loại <span style="color:red;">*</span></label>
						<div class="controls">
							<select name="type" id="type">
								<option value="1" <?php echo $info['type']==1?'selected':"";?>>Năng lực chung</option>
								<option value="2" <?php echo $info['type']==2?'selected':"";?>>Năng lực lãnh đạo</option>
							</select>
						</div>
					</div>
				</div>		
				<div class="row-fluid">
					<div class="control-group">
						<label class="control-label" for="required">Bắt buộc</label>
						<div class="controls">
							<input value="0" type="hidden" name="required">
							<input value="1" <?php echo $info['required']==1?"checked":""; ?> type="checkbox" name="required" id="required" class="ace-switch"><span class="lbl"></span>
						</div>
					</div>
				</div>		
				<div class="row-fluid">
					<div class="control-group">
						<label class="control-label" for="temp_col">Cột xử lý <span style="color:red;">*</span></label>
						<div class="controls">
							<div class="input-append">
								<input type="text" name="temp_col" id="temp_col" style="width:80%;" value="<?php echo $info['temp_col']?>"/>
							</span>
						</div>
						</div>
					</div>
				</div>
				<div class="row-fluid">
					<div class="control-group">
						<label class="control-label" for="orders">Sắp xếp</label>
						<div class="controls">
							<div class="input-append">
								<input type="text" name="orders" id="orders" style="width:80%;" value="<?php echo $info['orders']?>"/>
							</span>
						</div>
						</div>
					</div>
				</div>
				<div class="row-fluid">
					<div class="control-group">
						<label class="control-label" for="status">Trạng thái <span style="color:red;">*</span></label>
						<div class="controls">
							<input value="0" type="hidden" name="status">
							<input value="1" <?php echo $info['status']==1?"checked":""; ?> type="checkbox" name="status" id="status" class="ace-switch"><span class="lbl"></span>
						</div>
					</div>
				</div>				
				<?php echo JHtml::_( 'form.token' ); ?>
				<input type="hidden" id="id" name="id" value="<?php echo $info['id'];?>">
			</form>
		</div>

		<div class="modal-footer">
			<button class="btn btn-sm btn-danger pull-right" data-dismiss="modal">
				<i class="ace-icon fa fa-times"></i>
				Đóng
			</button>
			<span class="btn btn-sm btn-primary pull-right" id="btn_submit_vtvlnangluc">
				<i class="ace-icon fa fa-times"></i>
				Lưu
			</span>
		</div>
	</div>
</div>
<script type="text/javascript">
jQuery(document).ready(function($){
	$('.chosen').chosen({search_contains: true, width:"80%"});
	// $('.date-picker').datepicker( {format: 'dd/mm/yyyy', allowInputToggle: true}).on('changeDate', function (ev) {
	    // $(this).datepicker('hide');
	// });
	// $('.input-mask-date').mask('99/99/9999');
	$('#frm_vtvlnangluc').validate({
		invalidHandler: function(form, validator) {
			   var errors = validator.numberOfInvalids();
               if (errors) {
               	var a=[];
                 var message = 'Xin vui lòng nhập đầy đủ các thông tin:\n';
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

	    },
		  rules: {
		  	"name": {	    
			  	required: true
	      	},
		  	"type": {	    
			  	required: true
	      	},
		  	"temp_col": {	    
			  	required: true
	      	},
		  },
		messages:{
			"name": {	    
			  	required: 'Vui lòng nhập <b>Tên</b>',
	      	},
			"type": {	    
			  	required: 'Vui lòng nhập <b>Loại</b>',
	      	},
			"temp_col": {	    
			  	required: 'Vui lòng nhập <b>Cột xử lý</b>',
	      	},
		}
	});	
	$('#btn_submit_vtvlnangluc').click(function(){
		$('.gritter-item-wrapper').remove();
		var flag = $('#frm_vtvlnangluc').valid();
		if(flag == true){
			$.blockUI();
			formData = $('#frm_vtvlnangluc').serialize();
			$.ajax({
				type: 'post',
				data: formData,
				url: 'index.php?option=com_danhmuc&controller=vtvlnangluc&task=save&format=raw&',
				success:function(data){
					if(data == true || data >0){
						loadNoticeBoardSuccess('Thông báo', 'Lưu thông tin thành công');
						$('#div_modal').modal('hide');
						$('#btn_flt_nangluc').click();
					}else{
						loadNoticeBoardError('Thông báo','Có lỗi xảy ra, vui lòng liên hệ quản trị viên.');
					}
					$.unblockUI();
				}
			});
		}
		return false;
	});
})
</script>