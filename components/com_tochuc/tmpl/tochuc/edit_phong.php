<?php

/**
 * @ Author: huenn.dnict@gmail.com
 * @ Create Time: 2024-08-07 09:14:13
 * @ Modified by: huenn.dnict@gmail.com
 * @ Modified time: 2024-08-16 15:00:15
 * @ Description:
 */

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;
use Joomla\Component\Tochuc\Site\Helper\TochucHelper;

$user = Factory::getUser();
?>
<form class="form-horizontal row-fluid" name="frmThanhLap" id="frmThanhLap" method="post" action="<?php echo Route::_('index.php?option=com_tochuc&controller=tochuc&task=savethanhlap') ?>" enctype="multipart/form-data">
    <input type="hidden" value="<?php echo $this->row->id; ?>" name="id" id="id">
    <input type="hidden" value="<?php echo $this->row->parent_id; ?>" name="parent_id" id="parent_id">
    <input type="hidden" value="<?php echo $this->row->type; ?>" name="type" id="type">
    <div class="card card-primary card-outline card-outline-tabs">
        <div class="card-header p-0 border-bottom-0">
            <ul class="nav nav-tabs" id="myTab3">
                <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#COM_TOCHUC_THANHLAP_TAB1">Thông tin chung</a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#COM_TOCHUC_THANHLAP_TAB2">Thông tin thêm</a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#COM_TOCHUC_THANHLAP_TAB3">Cấu hình báo cáo</a></li>
            </ul>
        </div>

        <div class="tab-content card-body">
            <div id="COM_TOCHUC_THANHLAP_TAB1" class="tab-pane active" style="min-width:1000px;">
                <fieldset>
                    <div>
                        <p class="lead mb-0">Thông tin chung</p>
                    </div>
                    <div class="tab-custom-content">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label class="control-label" for="name">Tên phòng <span class="required">*</span></label>
                                <div class="controls">
                                    <input type="text" value="<?php echo $this->row->name; ?>" name="name" id="name" class="form-control rounded-0 validNamePhong">
                                </div>
                            </div>

                            <div class="col-md-6 form-group">
                                <label class="control-label" for="s_name">Tên viết tắt <span class="required">*</span></label>
                                <div class="controls">
                                    <input type="text" value="<?php echo $this->row->s_name; ?>" name="s_name" id="s_name" class="form-control rounded-0">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label class="control-label" for="s_name">Mã hiệu <span id="lbMahieu" class="required">*</span></label>
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" type="checkbox" id="is_checkmadonvi" checked="">
                                    <label for="is_checkmadonvi" id="label_madonvi" class="custom-control-label">Có/ Không cấp mã số tổ chứ</label>
                                </div>
                            </div>
                        </div>
                </fieldset>

                <fieldset>
                    <div>
                        <p class="lead mb-0">Thông tin thành lập</p>
                    </div>
                    <div class="tab-custom-content">
                        <div class="row">
                            <div class="col-md-6" data-select2-id="30">
                                <div class="form-group" data-select2-id="29">
                                    <label for="type_created">Cách thức thành lập <span class="required">*</span></label>
                                    <?php
                                    $tableInsDeptCachthuc = Core::table('Tochuc/InsDeptCachthuc');
                                    $type_created = $tableInsDeptCachthuc->findAllCachThucThanhLap();
                                    $options = array();
                                    $option[] = array('id' => '', 'name' => '');
                                    $options = array_merge($option, $type_created);
                                    echo HTMLHelper::_('select.genericlist', $options, 'type_created', array('class' => 'form-control select2 select2-hidden-accessible', 'style' => 'width: 100%;'), 'id', 'name', '');
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Cơ quan ban hành</label>
                                    <?php echo HTMLHelper::_('select.genericlist', $this->arr_ins_created, 'vanban_created[coquan_banhanh_id]', array('class' => 'form-control select2 select2-hidden-accessible', 'data-placeholder' => "Hãy chọn..."), 'value', 'text', $this->vanban_created['coquan_banhanh_id']); ?>
                                    <input type="hidden" name="vanban_created[id]" id="vanban_created_id" value="<?php echo $this->vanban_created['id']; ?>">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6" data-select2-id="30">
                                <div class="form-group" data-select2-id="29">
                                    <label for="type_created" for="vanban_created_mahieu">Số quyết định</label>
                                    <div class="controls">
                                        <input type="text" value="<?php echo $this->row->s_name; ?>" name="vanban_created[mahieu]" id="vanban_created_mahieu" class="form-control rounded-0">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Ngày ban hành</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text rounded-0"><i class="far fa-calendar-alt"></i></span>
                                        </div>
                                        <input type="text" class="form-control rounded-0" id="ngaybanhanh" name="vanban_created[ngaybanhanh]" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6" data-select2-id="30">
                                <div class="form-group" data-select2-id="29">
                                    <?php echo Core::inputAttachment('attactment_phong', null, 1, date('Y'), -1); ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Cơ quan chủ quản <span class="required">*</span></label>
                                    <?php echo HTMLHelper::_('select.genericlist', $this->arr_ins_created, 'ins_created', array('class' => 'form-control select2 select2-hidden-accessible', 'data-placeholder' => "Hãy chọn..."), 'value', 'text', $this->row->ins_created); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>

            <!-- Thẻ 2 -->
            <div id="COM_TOCHUC_THANHLAP_TAB2" class="tab-pane">
                <fieldset class="input-tochuc">
                    <div class="">
                        <p class="lead mb-0">Thông tin thêm</p>
                    </div>
                    <div class="tab-custom-content">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="control-label" for="ins_linhvuc">Lĩnh vực</label>
                                <div class="controls" style="display: grid;">
                                    <input type="hidden" id="ins_linhvuc" name="ins_linhvuc" />
                                    <div id="tree_linhvuc">
                                        <?php
                                        $inArray = Core::loadAssocList('cb_type_linhvuc', array('id', 'name', 'level', 'parent_id'), array('type=' => 1), 'lft');
                                        $tree = TochucHelper::buildTree($inArray);
                                        $jsTreeData = json_encode(TochucHelper::convertToJsTreeFormat($tree));
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
            <!-- Đóng Thẻ 2 -->

            <!-- Thẻ 3 -->
            <div id="COM_TOCHUC_THANHLAP_TAB3" class="tab-pane">
                <fieldset class="input-tochuc">
                    <div class="">
                        <p class="lead mb-0">Bổ sung đơn vị vừa tạo vào cấu hình báo cáo</p>
                    </div>
                    <div class="tab-custom-content">
                        <?php
                        $caybaocao = $this->caybaocao;
                        for ($i = 0; $i < count($caybaocao); $i++) {

                        ?>
                            <div class="form-group">
                                <div class="checkbox icheck-primary">
                                    <input name="report_group_code[]" type="checkbox" <?php echo $caybaocao[$i]['checked']; ?> value="<?php echo $caybaocao[$i]['report_group_code'] ?>" id="primary_<?php echo $i + 1 ?>" />
                                    <label for="primary_<?php echo $i + 1 ?>"><span class="lbl">&nbsp;&nbsp; <?php echo $caybaocao[$i]['name'] ?></span></label>
                                </div>
                            </div>
                        <?php }
                        ?>
                    </div>
                </fieldset>
            </div>
            <!-- Đóng Thẻ 3 -->
        </div>

    </div>


    <input type="hidden" name="action_name" id="action_name" value="">
    <input type="hidden" name="is_valid_name" id="is_valid_name" value="">
    <input type="hidden" id="is_valid_code">
    <?php echo HtmlHelper::_('form.token'); ?>
</form>
<script type="text/javascript">
    jQuery(document).ready(function($) {

        $('#type_created').select2({
            placeholder: "Hãy chọn...",
            allowClear: true,
            width: "100%"
        });

        $('#vanban_createdcoquan_banhanh_id').select2({
            placeholder: "Hãy chọn...",
            allowClear: true,
            width: "100%"
        });

        $('#ins_created').select2({
            placeholder: "Hãy chọn...",
            allowClear: true,
            width: "100%"
        });

        var toggleInputTrangthai = function(val){
            if(val == 1){			
                $(".trangthai").hide();
            }		
            else{
                $(".trangthai").show();
            }		
        };
        $('#active').change(function(){
            toggleInputTrangthai(this.value);
        });
        var initPage = function(){
            $('#type_created').val('<?php echo $this->row->type_created>0?$this->row->type_created:1;?>');
            toggleInputTrangthai($('#active').val());
            $('#btnThanhlapSubmitAndClose').unbind('click');
            $('#btnThanhlapSubmitAndNew').unbind('click');
        };
        initPage();	

        var treeData = <?php echo $jsTreeData; ?>;
        jQuery('#tree_linhvuc').jstree({
            "plugins" : [
                "checkbox",
                "contextmenu",
                "types",
                "conditionalselect"
            ],
            'core': {
                'data': treeData
            },
            "checkbox": {
                "override_ui": false,
                "three_state": false,
            },
        }).on('loaded.jstree', function(){
        }).on('changed.jstree', function (e, data) {
            var selectedNodes = data.selected.join(',');
            $('#ins_linhvuc').val(selectedNodes);
        });

        var getTextTab = function(elem){
			//$("#frmThanhLap .tab-pane");
			var el = $(elem).parents('.tab-pane');
			$('#frmThanhLap a[href="#'+el.attr("id")+'"]').css("color","red");
		};
		var getTextLabel = function(id){
			return $('#frmThanhLap label[for="'+id+'"]').text();
		};
		// $(".chzn-select").chosen().change(function() {
		// 	$('#frmThanhLap').validate().element(this);
	    // });
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
			// if(parent_id != '' && name_tc != '' && name_tc.length > 5){
			// 	var urlCheckTochuc = '<?php echo Uri::base(true);?>/index.php?option=com_tochuc&controller=tochuc&task=checkTochucTrung';
			// 	$.get(urlCheckTochuc, { name_tc : name_tc, parent_id : parent_id, id:id}, function(data){
			// 		if(data >= 1){
			// 			$('#is_valid_name').val(1);
			// 		}else{
			// 			$('#is_valid_name').val(0);
			// 		}
			// 	});
			// }
	    });
	    // $.validator.addMethod('validNamePhong', function(value, element){
		// 	if($('#is_valid_name').val() == '1'){
		// 		return false;
		// 	}else{
		// 		return true;
		// 	}
		// }, 'Tên phòng bạn nhập đã có trong nhánh cây đơn vị. Vui lòng nhập lại');
		
	    // $('body').delegate('#code','change', function(){
		//     code_tc = $.trim($(this).val());
		//     $(this).val(code_tc);
		// 	if( code_tc != ''){
		// 		var urlCheckCodeTochuc = '<?php echo Uri::base(true);?>/index.php?option=com_tochuc&controller=tochuc&task=checkMasoTrung';
		// 		$.get(urlCheckCodeTochuc, { code_tc : code_tc }, function(data){
		// 			if(data >= 1){
		// 				$('#is_valid_code').val(1);
		// 			}else{
		// 				$('#is_valid_code').val(0);
		// 			}
		// 		});
		// 	}
	    // });
		// $.validator.addMethod('validCodeTochuc', function(value, element){
		// 	if($('#is_valid_code').val() == '1'){
		// 		return false;
		// 	}else{
		// 		return true;
		// 	}
		// }, 'Mã hiệu đã tồn tại. Vui lòng nhập lại');
		// $.validator.setDefaults({ ignore: '' });
		// $.validator.addMethod("required2", function(value, element) {
		// 	var isTochuc = $("#active").val() !== "1";
		//     var val = value.replace(/^\s+|\s+$/g,"");//trim	 	
		//     if(isTochuc && (eval(val.length) == 0)){
		//     	 return false;
		// 	}else{
		// 		return true;
		// 	}
		// }, "Trường này là bắt buộc");
		
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
                     $.toast({
                        heading: 'Thông báo',
                        text: message + errors,
                        showHideTransition: 'fade',
                        position: 'top-right',
                        hideAfter: false,
                        bgColor: '#a94442',
                        class: 'thanhlap ngx-toastr'
                        // icon: 'error'
                    })
					//  loadNoticeBoardError('Thông báo',message + errors);		                 
	               }
	               validator.focusInvalid();
	        },		 
		  	errorPlacement: function(error, element) {		  		
		    },
			  rules: {
				  "name": {	    
					  required: true
			      },
			      "vanban_created[mahieu]": {	    
					  required : function(){
							if($('#vanban_createdmahieu').closest('div.controls').find('ul li').length > 0 || $('input[name="idFile-tochuc-attachment[]"]').length > 0){
								return true;
							}else{
								return false;
							}
						}
			      },
			      "s_name": {	    
					  required: true
			      },
			      "type":{
			    	  required: true
				  },
			      "parent_id": {	    
					  required: true
			      },
			      "type_created": {	    
					  required: true
			      },			        
				  "ins_created": {	    
					  required: true
			      },		
			      "trangthai[coquan_banhanh_id]": {	    
					  required2: true
			      },
			      "trangthai[ngaybanhanh]": {	    
					  required2: true
			      },
			      "trangthai[mahieu]": {	    
					  required2: true
			      }
			  },
			  messages:{
			  	  "name": {	    
					  required: "Vui lòng nhập"
			      },
			      "code": {	    
					  required: "Vui lòng nhập"
			      },
			      "s_name": {	    
					  required: "Vui lòng nhập"
			      },
			      "type":{
			    	  required: "Vui lòng nhập"
				  },
				  "vanban_created[mahieu]": {	    
					  required: "Vui lòng nhập <b>Số quyết định thành lập</b>"
			      },
			      "parent_id": {	    
					  required: "Vui lòng nhập"
			      },
			      "type_created": {	    
					  required: "Vui lòng nhập"
			      },	
			      "diachi":{
			    	  required: "Vui lòng nhập" 
				  },
			      "trangthai[coquan_banhanh_id]": {	    
					  required2: "Vui lòng nhập <b>Cơ quan ban hành quyết định</b>"
			      },
			      "trangthai[ngaybanhanh]": {	    
					  required2: "Vui lòng nhập <b>Ngày ban hành quyết định</b>"
			      },
			      "trangthai[mahieu]": {	    
					  required2: "Vui lòng nhập <b>Số quyết định</b>"
			      }
			  }
			 });
		 $('#btnThanhlapSubmitAndClose').click(function(){
            const element = document.querySelector('.q-toast-wrap');
            if (element) {
                element.remove();
            }
		 	$.blockUI();
		 	$('#action_name').val('SAVEANDCLOSE');
		 	$('#parent_id').val($('#parent_id_content').val());
			if($('#parent_id').val() == <?php echo (int)$this->row->id; ?>){
                $.toast({
                    heading: 'Thông báo',
                    text: "Vui lòng chọn đúng Cây đơn vị cha",
                    showHideTransition: 'fade',
                    position: 'top-right',
                    icon: 'error',
                    class: 'thanhlap ngx-toastr'

                })
                //return false;
	            // loadNoticeBoardError('Thông báo','Vui lòng chọn Cây đơn vị cha hợp lý');	
				$.unblockUI();
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
			const element = document.querySelector('.q-toast-wrap');
            if (element) {
                element.remove();
            }
			$.blockUI();
		 	$('#action_name').val('SAVEANDNEW');
		 	$('#parent_id').val($('#parent_id_content').val());
			if($('#parent_id').val() == <?php echo (int)$this->row->id; ?>){
	            // loadNoticeBoardError('Thông báo','Vui lòng chọn Cây đơn vị cha hợp lý');	
                $.toast({
                    heading: 'Thông báo',
                    text: "Vui lòng chọn đúng Cây đơn vị cha",
                    showHideTransition: 'fade',
                    position: 'top-right',
                    icon: 'error',
                    class: 'thanhlap ngx-toastr'

                })
                //return false;
				$.unblockUI();
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
			const element = document.querySelector('.thanhlap');
            if (element) {
                element.remove();
            }
			$.blockUI();
		 	$('#action_name').val('SAVEANDCONTINUE');
		 	$('#parent_id').val($('#parent_id_content').val());
			if($('#parent_id').val() == <?php echo (int)$this->row->id; ?>){
	            // loadNoticeBoardError('Thông báo','Vui lòng chọn Cây đơn vị cha hợp lý');	
                $.toast({
                    heading: 'Thông báo',
                    text: "Vui lòng chọn đúng Cây đơn vị cha",
                    showHideTransition: 'fade',
                    position: 'top-right',
                    icon: 'error',
                    class: 'thanhlap ngx-toastr'

                })
               // return false;
				$.unblockUI();
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

    }); // end document.ready
</script>
<style type="text/css">
	.required {
        color: red;
    }
</style>