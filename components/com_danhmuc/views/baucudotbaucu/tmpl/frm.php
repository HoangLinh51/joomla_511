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
			<h3 class="smaller lighter blue no-margin"><?php echo ($info['id'])>0?"Hiệu chỉnh":"Thêm mới"?> Đợt bầu cử - Nhiệm kỳ</h3>
		</div>
		<div class="modal-body">
			<form class="form-horizontal" method="POST" name="frm_baucudotbaucu" id="frm_baucudotbaucu">
				<input type="hidden" name="id" id="id" style="width:80%;" value="<?php echo $info['id']?>"/>
				<div class="row-fluid">
					<div class="control-group">
						<label class="control-label" for="ten">Tên <span style="color:red;">*</span></label>
						<div class="controls">
							<input type="text" name="ten" id="ten" style="width:80%;" value="<?php echo $info['ten']?>"/>
						</div>
					</div>
				</div>
				<div class="row-fluid">
					<div class="control-group">
						<label class="control-label" for="khoa">Khóa <span style="color:red;">*</span></label>
						<div class="controls">
							<input type="text" name="khoa" id="khoa" style="width:80%;" value="<?php echo $info['khoa']?>"/>
						</div>
					</div>
				</div>
				<div class="row-fluid">
					<div class="control-group">
						<label class="control-label" for="capbaucu_id">Cấp bầu cử</label>
						<div class="controls">
							<?php $capbaucu = Core::loadAssocList('baucu_capbaucu','*',null, 'sapxep asc');?>
							<?php $fk = Core::loadColumn('baucu_cauhinh_dotbaucu2capbaucu','capbaucu_id','dotbaucu_id='.(int)$info['id']);?>
							<select name="capbaucu_id[]" id="capbaucu_id" class="chosen" multiple data-placeholder="Chọn các cấp bầu cử...">
							<?php for($i=0; $i<count($capbaucu); $i++){?>
							<option value="<?php echo $capbaucu[$i]['id'];?>" <?php if(in_array($capbaucu[$i]['id'],$fk)) echo 'selected';?>><?php echo $capbaucu[$i]['ten'];?></option>
							<?php }?>
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
						<label class="control-label" for="ngaybatdau">Bắt đầu <span style="color:red;">*</span></label>
						<div class="controls">
							<input type="text" class="dp" name="ngaybatdau" id="ngaybatdau" value="<?php echo date('d/m/Y', strtotime($info['ngaybatdau']))?>"/>
						</div>
					</div>
				</div>
				<div class="row-fluid">
					<div class="control-group">
						<label class="control-label" for="ngayketthuc">Kết thúc <span style="color:red;">*</span></label>
						<div class="controls">
							<input type="text" class="dp" name="ngayketthuc" id="ngayketthuc" value="<?php echo date('d/m/Y', strtotime($info['ngayketthuc']))?>"/>
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
			<span class="btn btn-sm btn-primary pull-right" id="btn_submit_baucudotbaucu">
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
	$('#frm_baucudotbaucu').validate({
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
	$('#btn_submit_baucudotbaucu').click(function(){
		$('.gritter-item-wrapper').remove();
		var flag = $('#frm_baucudotbaucu').valid();
		if(flag == true){
			$.blockUI();
			formData = $('#frm_baucudotbaucu').serialize();
			$.ajax({
				type: 'post',
				data: formData,
				url: 'index.php?option=com_danhmuc&controller=baucudotbaucu&task=save&format=raw&',
				success:function(data){
					if(data == true || data !=null || data != ''){
						loadNoticeBoardSuccess('Thông báo', 'Lưu thông tin thành công');
						$('#div_modal').modal('hide');
						$('#btn_flt_baucudotbaucu').click();
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