<?php 
defined('_JEXEC') or die('Restricted access');
$info = $this->info;
$i4223 = Core::config('sync4223/is_use');
$t4223 = explode(',' ,Core::config('sync4223/tbl'));
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
			<h3 class="smaller lighter blue no-margin"><?php echo mb_strlen($info['code'])>0?"Hiệu chỉnh":"Thêm mới"?> Tỉnh thành</h3>
		</div>
		<div class="modal-body">
			<form class="form-horizontal" method="POST" name="frm_tinhthanh" id="frm_tinhthanh">
				<input type="hidden" name="code" id="code" style="width:80%;" value="<?php echo $info['code']?>"/>
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
						<label class="control-label" for="muctuongduong">Là đơn vị hành chính <span style="color:red;">*</span></label>
						<div class="controls">
							<select name="muctuongduong" id="muctuongduong">
								<option value="">-- Chọn mức tương đương --</option>
								<option value="1" <?php echo $info['muctuongduong']==1?'selected':'';?>>Thủ đô</option>
								<option value="2" <?php echo $info['muctuongduong']==2?'selected':'';?>>Thành phố trực thuộc TW</option>
								<option value="3" <?php echo $info['muctuongduong']==3?'selected':'';?>>Tỉnh</option>
							</select>
						</div>
					</div>
				</div>
				<?php if($i4223==1 && in_array($this->tbl, $t4223)){?>
				<div class="row-fluid">
					<div class="control-group">
						<label class="control-label" for="code_bnv">Mã Bộ nội vụ</label>
						<div class="controls">
							<div class="input-append">
								<input type="text" name="code_bnv" id="code_bnv" style="width:80%;" value="<?php echo $info['code_bnv']?>"/>
							</span>
						</div>
						</div>
					</div>
				</div>
				<?php }?>
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
			</form>
		</div>

		<div class="modal-footer">
			<button class="btn btn-sm btn-danger pull-right" data-dismiss="modal">
				<i class="ace-icon fa fa-times"></i>
				Đóng
			</button>
			<span class="btn btn-sm btn-primary pull-right" id="btn_submit_tinhthanh">
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
	$('#frm_tinhthanh').validate({
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
		  	"muctuongduong": {	    
			  	required: true
	      	},
		  },
		messages:{
			"name": {	    
			  	required: 'Vui lòng nhập <b>Tên</b>',
	      	},
			"muctuongduong": {	    
			  	required: 'Vui lòng chọn <b>Là đơn vị hành chính</b>',
	      	},
		}
	});	
	$('#btn_submit_tinhthanh').click(function(){
		$('.gritter-item-wrapper').remove();
		var flag = $('#frm_tinhthanh').valid();
		if(flag == true){
			$.blockUI();
			formData = $('#frm_tinhthanh').serialize();
			$.ajax({
				type: 'post',
				data: formData,
				url: 'index.php?option=com_danhmuc&controller=tinhthanh&task=save&format=raw&',
				success:function(data){
					if(data == true || data !=null || data != ''){
						loadNoticeBoardSuccess('Thông báo', 'Lưu thông tin thành công');
						$('#div_modal').modal('hide');
						$('#btn_flt_tinhthanh').click();
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