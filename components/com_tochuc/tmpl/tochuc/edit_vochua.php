
<?php
/**
 * @ Author: huenn.dnict@gmail.com
 * @ Create Time: 2024-08-07 10:46:39
 * @ Modified by: huenn.dnict@gmail.com
 * @ Modified time: 2024-08-07 10:57:51
 * @ Description:
 */
use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;

$user = Factory::getUser();
?>
<form class="form-horizontal row-fluid" name="frmThanhLap"	id="frmThanhLap" method="post"	action="<?php echo Route::_('index.php?option=com_tochuc&controller=tochuc&task=savethanhlap')?>" enctype="multipart/form-data">
<input type="hidden" value="<?php echo $this->row->id; ?>" name="id" id="id">
<input type="hidden" value="<?php echo $this->row->type; ?>" name="type" id="type">
<input type="hidden" value="<?php echo $this->row->parent_id; ?>" name="parent_id" id="parent_id">	
<div class="tabbable">
		<ul class="nav nav-tabs" id="myTab3">
			<li class="active"><a data-toggle="tab"	href="#COM_TOCHUC_THANHLAP_TAB1">Thông tin chung</a></li>
			<li><a data-toggle="tab" href="#COM_TOCHUC_THANHLAP_TAB3">Cấu hình báo cáo</a></li>
		</ul>
		<div class="tab-content">
			<div id="COM_TOCHUC_THANHLAP_TAB1" class="tab-pane active" style="min-width:1000px;">
				<fieldset>
					<legend>Thông tin chung</legend>
					<div class="row-fluid">
						<div class="control-group" style="width:450px;float:left;">
							<label class="control-label" for="name">Tên <span class="required">*</span></label>
							<div class="controls">
							
							<input type="text" value="<?php echo $this->row->name;?>"name="name" id="name" class="validNameVochua">
							</div>
						</div>
						<div class="control-group" style="width:450px;float:left;">
							<label class="control-label" for="s_name">Tên viết tắt <span
								class="required">*</span></label>
							<div class="controls">
								<input type="text" value="<?php echo $this->row->s_name; ?>" name="s_name" id="s_name">
							</div>
						</div>	
					</div>
					<div class="row-fluid">	
						<div class="control-group" style="width:450px;float:left;">
								<label class="control-label" for="ghichu">Ghi chú</label>
								<div class="controls">
									<textarea rows="5" cols="30" id="ghichu" name="ghichu"><?php echo $this->row->ghichu;?></textarea>
								</div>
							</div>	
					</div>					
</fieldset>					
</div>
			<div id="COM_TOCHUC_THANHLAP_TAB3" class="tab-pane" style="min-width:1000px;">
				<fieldset>
					<legend><?php echo $this->title;?></legend>
					<?php 
					$caybaocao = $this->caybaocao;
					for ($i = 0; $i < count($caybaocao); $i++) {
					?>
					<div class="row-fluid">	
						<div class="control-group">
							<div class="controls">
								<!-- <input type="hidden" name="chkrep_hc_name" value="0"> -->
								<label>
									<input type="checkbox" name="report_group_code[]" <?php echo $caybaocao[$i]['checked']; ?> class="report_group_code" value="<?php echo $caybaocao[$i]['report_group_code']?>"><span class="lbl">&nbsp;&nbsp; <?php echo $caybaocao[$i]['name']?></span>
								</label>
							</div>
						</div>
					</div>
					<?php } ?>
				</fieldset>
			</div>
</div>
</div>
<input type="hidden" name="action_name" id="action_name" value="">
<input type="hidden" name="active" id="active" value="<?php echo $this->row->active;?>">
<input type="hidden" name="is_valid_name" id="is_valid_name" value="">
<?php echo HTMLHelper::_( 'form.token' ); ?> 	
</form>
<script type="text/javascript">
jQuery(document).ready(function($){
	var initPage = function(){
		$('.chzn-select').chosen({allow_single_deselect: true});
		$('.input-mask-date').mask('99/99/9999');
		$('#btnThanhlapSubmitAndClose').unbind('click');
		$('#btnThanhlapSubmitAndNew').unbind('click');
	};
	initPage();
	var getTextTab = function(elem){
		//$("#frmThanhLap .tab-pane");
		var el = $(elem).parents('.tab-pane');
		$('#frmThanhLap a[href="#'+el.attr("id")+'"]').css("color","red");
	};
	var getTextLabel = function(id){
		return $('#frmThanhLap label[for="'+id+'"]').text();
	};
	$(".chzn-select").chosen().change(function() {
		$('#frmThanhLap').validate().element(this);
    });
    $('#name').on('blur', function(){
    	var dest = $(this);
    	name_tc = $.trim(dest.val());
    	if(parent_id != '' && name_tc != ''){
                    name_tc = name_tc.replace(/[ ]{2,}/g, ' ');
		    dest.val(name_tc);
                    var parent_id = $('#parent_id_content').val();
                    var id = $('#id').val();
                    if(($('#s_name').val()).length>0){
                    }else $('#s_name').val(name_tc);
		}else {
			$('#s_name').val('');
			dest.val('');
		}
		if(parent_id != '' && name_tc != '' && name_tc.length > 5){
			var urlCheckTochuc = '<?php echo Uri::base(true);?>/index.php?option=com_tochuc&controller=tochuc&task=checkTochucTrung';
			$.get(urlCheckTochuc, { name_tc : name_tc, parent_id : parent_id , id:id}, function(data){
				if(data >= 1){
					$('#is_valid_name').val(1);
				}else{
					$('#is_valid_name').val(0);
				}
			});
		}
    });
	$.validator.setDefaults({ ignore: '' });
	$.validator.addMethod("required2", function(value, element) {
	    var isTochuc = $("#type").val() === "1";
	    var val = value.replace(/^\s+|\s+$/g,"");//trim	 	
	    if(isTochuc && (eval(val.length) == 0)){
	    	 return false;
		}else{
			return true;
		}
	}, "Trường này là bắt buộc");
		$('#frmThanhLap').validate({
			invalidHandler: function(form, validator) {
				   var errors = validator.numberOfInvalids();
				  $('#frmThanhLap a[data-toggle="tab"]').css("color","");
	               if (errors) {
	                 var message = errors == 1
	                   ? 'Xin vui lòng hiệu chỉnh lỗi sau đây:\n'
	                   : 'Xin vui lòng hiệu chỉnh ' + errors + ' lỗi sau đây .\n';
	                 var errors = "";
	                 if (validator.errorList.length > 0) {		                 
	                     for (x=0;x<validator.errorList.length;x++) {
	                     	errors += "<br/>\u25CF " + validator.errorList[x].message +' <b> '+ getTextLabel($(validator.errorList[x].element).attr("name")).replace(/\*/g, '')+'</b>' ;
	                         getTextTab($(validator.errorList[x].element));
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
			      "s_name": {	    
					  required: true
			      },
			      "type":{
			    	  required: true
				  },
			      "parent_id": {	    
					  required: true
			      }
			  }
			 });
		 $('#btnThanhlapSubmitAndClose').click(function(){
		 	$('.gritter-item-wrapper').remove();
		 	$.blockUI();
			$('#action_name').val('SAVEANDCLOSE');
			$('#parent_id').val($('#parent_id_content').val());
			if($('#parent_id').val() == <?php echo (int)$this->row->id; ?>){
	        	$.unblockUI();
	            loadNoticeBoardError('Thông báo','Vui lòng chọn Cây đơn vị cha hợp lý');	
	        }
	        else{
	            var flag = $('#frmThanhLap').valid();
	            if(flag == true){
	                    document.frmThanhLap.submit();
	            }else{
					$.unblockUI();
				}
	        }
	 	});
		$('#btnThanhlapSubmitAndNew').click(function(){
			$('.gritter-item-wrapper').remove();
			$.blockUI();
		 	$('#action_name').val('SAVEANDNEW');
		 	$('#parent_id').val($('#parent_id_content').val());
		 	if($('#parent_id').val() == <?php echo (int)$this->row->id; ?>){
	        	$.unblockUI();
	            loadNoticeBoardError('Thông báo','Vui lòng chọn Cây đơn vị cha hợp lý');	
	        }
	        else{
	            var flag = $('#frmThanhLap').valid();
	            if(flag == true){
	                    document.frmThanhLap.submit();
	            }else{
					$.unblockUI();
				}
	        }
		});
		$('#btnThanhlapSubmitAndContinue').click(function(){
			$('.gritter-item-wrapper').remove();
			$.blockUI();
		 	$('#action_name').val('SAVEANDCONTINUE');
		 	$('#parent_id').val($('#parent_id_content').val());
			if($('#parent_id').val() == <?php echo (int)$this->row->id; ?>){
	        	$.unblockUI();
	            loadNoticeBoardError('Thông báo','Vui lòng chọn Cây đơn vị cha hợp lý');	
	        }
	        else{
	            var flag = $('#frmThanhLap').valid();
	            if(flag == true){
	                    document.frmThanhLap.submit();
	            }else{
					$.unblockUI();
				}
	        }
		});
		$.validator.addMethod('validNameVochua', function(value, element){
			if($('#is_valid_name').val() == '1'){
				return false;
			}else{
				return true;
			}
		}, 'Tên vỏ chứa bạn nhập đã có trong nhánh cây đơn vị. Vui lòng nhập lại');

}); // end document.ready
</script>