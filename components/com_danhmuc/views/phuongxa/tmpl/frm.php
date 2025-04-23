<?php 
defined('_JEXEC') or die('Restricted access');
$info = $this->info;
$i4223 = Core::config('sync4223/is_use');
$t4223 = explode(',' ,Core::config('sync4223/tbl'));
$tinhthanh = Core::loadAssocList('city_code','*','daxoa=0 and code>0','(code>0) asc, muctuongduong is null asc, name is null asc');
$quanhuyen = Core::loadAssocList('dist_code','*','cadc_code = '.(int)$info['dc_cadc_code'].' AND daxoa=0','(code>0) asc, muctuongduong is null asc, name is null asc');
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
		<div class="modal-body" style="height: 500px;">
			<form class="form-horizontal" method="POST" name="frm_phuongxa" id="frm_phuongxa">
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
						<label class="control-label" for="dc_cadc_code">Thuộc tỉnh/thành <span style="color:red;">*</span></label>
						<div class="controls">
							<select name="dc_cadc_code" id="dc_cadc_code" class="chosen">
								<option value="">-- Chọn tỉnh/thành --</option>
								<?php for($i=0; $n=count($tinhthanh), $i<$n; $i++){?>
								<option value="<?php echo $tinhthanh[$i]['code']?>" <?php echo $tinhthanh[$i]['code']==$info['dc_cadc_code']?'selected':'';?>><?php echo $tinhthanh[$i]['name']?></option>
								<?php }?>
							</select>
						</div>
					</div>
				</div>
				<div class="row-fluid">
					<div class="control-group">
						<label class="control-label" for="dc_code">Thuộc quận/huyện <span style="color:red;">*</span></label>
						<div class="controls">
							<select name="dc_code" id="dc_code" class="chosen">
								<option value="">-- Chọn quận/huyện --</option>
								<?php for($i=0; $n=count($quanhuyen), $i<$n; $i++){?>
								<option value="<?php echo $quanhuyen[$i]['code']?>" <?php echo $quanhuyen[$i]['code']==$info['dc_code']?'selected':'';?>><?php echo $quanhuyen[$i]['name']?></option>
								<?php }?>
							</select>
						</div>
					</div>
				</div>
				<div class="row-fluid">
					<div class="control-group">
						<label class="control-label" for="muctuongduong">Là đơn vị hành chính <span style="color:red;">*</span></label>
						<div class="controls">
							<select name="muctuongduong" id="muctuongduong">
								<option value="">-- Chọn mức tương đương --</option>
								<option value="1" <?php echo $info['muctuongduong']==1?'selected':'';?>>Thị trấn</option>
								<option value="2" <?php echo $info['muctuongduong']==2?'selected':'';?>>Phường</option>
								<option value="3" <?php echo $info['muctuongduong']==3?'selected':'';?>>Xã</option>
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
			<span class="btn btn-sm btn-primary pull-right" id="btn_submit_phuongxa">
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
	$.validator.setDefaults({ ignore: ":hidden:not(.chosen)" })
	$('#frm_phuongxa #dc_cadc_code').on('change', function(){
		$.blockUI();
		let tinhthanh  = $(this).val();
		if(tinhthanh>0){
			$.ajax({
				type: 'get',
				url: 'index.php?option=com_danhmuc&controller=phuongxa&task=getQuanhuyenByTinhthanh&format=raw&tinhthanh_id='+tinhthanh,
				success:function(data){
					let xhtml = '<option value="">-- Chọn Quận/huyện --</option>';
					// if(data.length>0){
						for(i=0; i<data.length; i++)
							xhtml += '<option value="'+data[i].code+'">'+data[i].name+'</option>';
					// }
					$('#frm_phuongxa #dc_code').html(xhtml);
					$('#frm_phuongxa #dc_code').trigger("chosen:updated");
					$.unblockUI();
				}
			});
		}
	})
	$('#frm_phuongxa').validate({
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
		  	"cadc_code": {	    
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
			"cadc_code": {	    
			  	required: 'Vui lòng chọn <b>thuộc Tỉnh/thành</b>',
	      	},
		}
	});	
	$('#btn_submit_phuongxa').click(function(){
		$('.gritter-item-wrapper').remove();
		var flag = $('#frm_phuongxa').valid();
		if(flag == true){
			$.blockUI();
			formData = $('#frm_phuongxa').serialize();
			$.ajax({
				type: 'post',
				data: formData,
				url: 'index.php?option=com_danhmuc&controller=phuongxa&task=save&format=raw&',
				success:function(data){
					if(data == true || data !=null || data != ''){
						loadNoticeBoardSuccess('Thông báo', 'Lưu thông tin thành công');
						$('#div_modal').modal('hide');
						$('#btn_flt_phuongxa').click();
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