<?php 
defined('_JEXEC') or die('Restricted access');
$diadiemhanhchinh_id = $this->diadiemhanhchinh_id;
$capbaucu = Core::loadAssocList('baucu_capbaucu', '*', 'daxoa=0 and trangthai=1');
$db = JFactory::getDbo();
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
			<h3 class="smaller lighter blue no-margin">Cấu hình email nhận kết quả bầu cử của đơn vị <?php echo Core::loadResult('ins_dept','name','id='.(int)$diadiemhanhchinh_id);?> </h3>
		</div>
		<div class="modal-body">
			<form class="form-horizontal" method="POST" name="frm_baucucauhinhemail" id="frm_baucucauhinhemail">
				<input type="hidden" name="diadiemhanhchinh_id" id="diadiemhanhchinh_id" style="width:80%;" value="<?php echo $diadiemhanhchinh_id?>"/>
				<div class="row-fluid">
					<div class="control-group">
						<label class="control-label" for="ten">Đơn vị hành chính <span style="color:red;">*</span></label>
						<div class="controls">
							<b><?php echo Core::loadResult('ins_dept','name','id='.(int)$diadiemhanhchinh_id);?></b>
						</div>
					</div>
				</div>
				<?php for($i=0; $i<count($capbaucu); $i++){?>
				<?php 
					$tmp_capbaucunhanemail = Core::loadAssoc('baucu_cauhinh_capbaucunhanemail','*','diadiemhanhchinh_id='.$db->quote($diadiemhanhchinh_id).' AND capbaucu_id='.$db->quote($capbaucu[$i]['id']));
					$fk = Core::loadAssoc('baucu_cauhinh_capbaucu2email','*','capbaucunhanemail_id in ('.(int)$tmp_capbaucunhanemail['id'].')');?>
				<div class="row-fluid">
					<div class="control-group">
						<label class="control-label" for="ten"><?php echo $capbaucu[$i]['ten']?> <span style="color:red;">*</span></label>
						<div class="controls">
							<input type="hidden" name="fk_id[]" style="width:80%;" value="<?php echo $fk['id']?>"></input>
							<input type="hidden" name="capbaucu_id[]" style="width:80%;" value="<?php echo $capbaucu[$i]['id']?>"></input>
							<textarea type="text" name="email[]" style="width:80%;"><?php echo $fk['email']?></textarea>
						</div>
					</div>
				</div>
				<?php }?>
				<?php echo JHtml::_( 'form.token' ); ?>
			</form>
		</div>

		<div class="modal-footer">
			<button class="btn btn-sm btn-danger pull-right" data-dismiss="modal">
				<i class="ace-icon fa fa-times"></i>
				Đóng
			</button>
			<span class="btn btn-sm btn-primary pull-right" id="btn_submit_baucucauhinhemail">
				<i class="ace-icon fa fa-times"></i>
				Lưu
			</span>
		</div>
	</div>
</div>
<script type="text/javascript">
jQuery(document).ready(function($){
	$('.chosen').chosen({search_contains: true, width:"80%"});
	$('.dp').datepicker( {format: 'dd/mm/yyyy', allowInputToggle: true}).on('changeDate', function (ev) {
	    $(this).datepicker('hide');
	});
	$('.dp').mask('99/99/9999');
	$('#frm_baucucauhinhemail').validate({
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
		  	"ten": {	    
			  	required: true
	      	},
		  },
		messages:{
			"ten": {	    
			  	required: 'Vui lòng nhập <b>Tên</b>',
	      	},
		}
	});	
	$('#btn_submit_baucucauhinhemail').click(function(){
		$('.gritter-item-wrapper').remove();
		var flag = $('#frm_baucucauhinhemail').valid();
		if(flag == true){
			$.blockUI();
			formData = $('#frm_baucucauhinhemail').serialize();
			$.ajax({
				type: 'post',
				data: formData,
				url: 'index.php?option=com_danhmuc&controller=baucucauhinhemail&task=save&format=raw&',
				success:function(data){
					if(data == true || data >0){
						loadNoticeBoardSuccess('Thông báo', 'Lưu thông tin thành công');
						$('#div_modal').modal('hide');
						$('#btn_flt_baucucauhinhemail').click();
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