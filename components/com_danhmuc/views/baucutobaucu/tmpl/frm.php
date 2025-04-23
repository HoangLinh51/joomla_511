<?php 
defined('_JEXEC') or die('Restricted access');
$info = $this->info;
$i4223 = Core::config('sync4223/is_use');
$t4223 = explode(',' ,Core::config('sync4223/tbl'));
$dotbaucu = Core::loadAssocList('baucu_dotbaucu', '*');
$phuongxa = Core::loadAssocList('baucu_diadiemhanhchinh', '*', 'cap=4');
$quanhuyen = Core::loadAssocList('baucu_diadiemhanhchinh', '*', 'cap=3');
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
			<h3 class="smaller lighter blue no-margin"><?php echo ($info['id'])>0?"Hiệu chỉnh":"Thêm mới"?> Tổ bầu cử</h3>
		</div>
		<div class="modal-body" style="min-height: 500px;">
			<form class="form-horizontal" method="POST" name="frm_baucutobaucu" id="frm_baucutobaucu">
				<input type="hidden" name="id" id="id" style="width:80%;" value="<?php echo $info['id']?>"/>
				<div class="row-fluid">
					<div class="control-group">
						<label class="control-label" for="ten">Tên <span style="color:red;">*</span></label>
						<div class="controls">
							<input type="text" name="ten" id="ten" style="width:80%;" value="<?php echo $info['ten']?>"/>
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
						<label class="control-label" for="dotbaucu_id">Đợt bầu cử <span style="color:red;">*</span></label>
						<div class="controls">
							<select name="dotbaucu_id" class='chosen'>
								<option value="">--Chọn--</option>
								<?php for($i=0; $i<count($dotbaucu); $i++){?>
									<option value="<?php echo $dotbaucu[$i]['id']?>"<?php echo $dotbaucu[$i]['id']==$info['dotbaucu_id']?'selected':'';?>><?php echo $dotbaucu[$i]['ten']?></option>
								<?php }?>
							</select>
						</div>
					</div>
				</div>
				<div class="row-fluid">
					<div class="control-group">
						<label class="control-label" for="quanhuyen_id">Quận/Huyện <span style="color:red;">*</span></label>
						<div class="controls">
							<select name="quanhuyen_id" class='chosen'>
								<option value="">--Chọn--</option>
								<?php for($i=0; $i<count($quanhuyen); $i++){?>
									<option value="<?php echo $quanhuyen[$i]['id']?>"<?php echo $quanhuyen[$i]['id']==$info['quanhuyen_id']?'selected':'';?>><?php echo $quanhuyen[$i]['ten']?></option>
								<?php }?>
							</select>
						</div>
					</div>
				</div>
				<div class="row-fluid">
					<div class="control-group">
						<label class="control-label" for="phuongxa_id">Phường/Xã <span style="color:red;">*</span></label>
						<div class="controls">
							<select name="phuongxa_id" class='chosen'>
								<option value="">--Chọn--</option>
								<?php for($i=0; $i<count($phuongxa); $i++){?>
									<option value="<?php echo $phuongxa[$i]['id']?>"<?php echo $phuongxa[$i]['id']==$info['phuongxa_id']?'selected':'';?>><?php echo $phuongxa[$i]['ten']?></option>
								<?php }?>
							</select>
						</div>
					</div>
				</div>
				<div class="row-fluid">
					<div class="control-group">
						<label class="control-label" for="trangthai">Trạng thái <span style="color:red;">*</span></label>
						<div class="controls">
							<input value="0" type="hidden" name="trangthai">
							<input value="1" <?php echo $info['trangthai']==1?"checked":""; ?> type="checkbox" name="trangthai" id="trangthai" class="ace-switch"><span class="lbl"></span>
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
			<span class="btn btn-sm btn-primary pull-right" id="btn_submit_baucutobaucu">
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
	$('#frm_baucutobaucu').validate({
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
	$('#btn_submit_baucutobaucu').click(function(){
		$('.gritter-item-wrapper').remove();
		var flag = $('#frm_baucutobaucu').valid();
		if(flag == true){
			$.blockUI();
			formData = $('#frm_baucutobaucu').serialize();
			$.ajax({
				type: 'post',
				data: formData,
				url: 'index.php?option=com_danhmuc&controller=baucutobaucu&task=save&format=raw&',
				success:function(data){
					if(data == true || data !=null || data != ''){
						loadNoticeBoardSuccess('Thông báo', 'Lưu thông tin thành công');
						$('#div_modal').modal('hide');
						$('#btn_flt_baucutobaucu').click();
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