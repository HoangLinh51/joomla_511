<?php 
	$ds_cb_bangluong = $this->ds_cb_bangluong;
	$root_id = 0;
	$model = Core::model('Danhmuchethong/Ngachbac');
	$jinput = JFactory::getApplication()->input;
    $id = $jinput->getInt('id',0);
    if($id>0){
    	$ngachbac = $this->ngachbac;
    	$ds_nhomngach_heso = $this->ds_nhomngach_heso;
    }
?>
<div id="themmoi_ngachbac">
	<h2 class="header">Danh mục ngạch bậc <?php echo ($id>0)?'[Hiệu chỉnh]':'[Thêm mới]' ?>
		<div class="pull-right">
			<span class="btn btn-small btn-success" id="btn_luu_ngachbac">Lưu và thoát</span>
			<span class="btn btn-small btn-danger" id="btn_cancel_ngachbac">Hủy bỏ</span>
		</div>
	</h2>
	<form id="form_ngachbac" class="form-horizontal">
		<?php echo JHtml::_( 'form.token' ); ?>
		<div class="control-group row-fluid">
			<label class="control-label span3">Bảng lương (<span style="color:red">*</span>)</label>
			<div class="span9">
				<select class="span12" name="frm[idbangluong]">
					<option value="">--Chọn--</option>
					<?php for($i=0;$i<count($ds_cb_bangluong);$i++){ ?>
					<option value="<?php echo $ds_cb_bangluong[$i]['id']; ?>" <?php if($id>0&&$ngachbac['idbangluong']==$ds_cb_bangluong[$i]['id']) echo 'selected'; ?>><?php echo $ds_cb_bangluong[$i]['name']; ?></option>
					<?php } ?>
				</select>
			</div>
		</div>
		<!-- <div class="control-group row-fluid">
			<label class="control-label span3">Tên nhóm ngạch</label>
			<div class="span9">
				<select class="span12"></select>
			</div>
		</div> -->
		<div class="control-group row-fluid">
			<label class="control-label span3">Tên ngạch (<span style="color:red">*</span>)</label>
			<div class="span9">
				<input type="text" class="span12" name="frm[name]" autocomplete="off" value="<?php if($id>0) echo $ngachbac['name']; ?>">
				<input type="hidden" name="frm[id]" id="id_ngachbac" value="<?php if($id>0) echo $ngachbac['id']; ?>">
			</div>
		</div>
		<div class="control-group row-fluid">
			<label class="control-label span3">Mã ngạch (<span style="color:red">*</span>)</label>
			<div class="span9">
				<input type="text" class="span12" name="frm[code]" autocomplete="off" value="<?php if($id>0) echo $ngachbac['code']; ?>">
			</div>
		</div>
		<div class="control-group row-fluid">
			<label class="control-label span3">Nhóm cấp trên (<span style="color:red">*</span>)</label>
			<div class="span9">
				<div id="caydonvi_quanly_ngachbac" style="overflow:auto; height:200px"> CÂY ĐƠN VỊ </div>
				<input type="hidden" name="frm[parentid]" id="input_parentid">
			</div>
		</div>
		<div class="control-group row-fluid">
			<label class="control-label span3">Cấp (<span style="color:red">*</span>)</label>
			<div class="span9">
				<select class="span12" name="frm[cap]">
					<option value="">--Chọn--</option>
					<?php for($i=1;$i<11;$i++){ ?>
					<option value="<?php echo $i; ?>" <?php if($id>0&&$ngachbac['cap']==$i) echo 'selected'; ?>><?php echo $i; ?></option>
					<?php } ?>
				</select>
			</div>
		</div>
		<div class="control-group row-fluid">
			<label class="control-label span3">Số năm lên lương (<span style="color:red">*</span>)</label>
			<div class="span9">
				<input type="text" class="span12" name="frm[sonamluong]" autocomplete="off" value="<?php if($id>0) echo $ngachbac['sonamluong']; ?>">
			</div>
		</div>
		<div class="control-group row-fluid">
			<label class="control-label span3">Sử dụng (<span style="color:red">*</span>)</label>
			<div class="span9">
				<label>
					<input type="radio" value="0" name="frm[status]" <?php if($id>0&&$ngachbac['status']==0) echo 'checked'; ?>>
					<span class="lbl">Không</span>
				</label>
				<label>
					<input type="radio" value="1" name="frm[status]" <?php if($id>0&&$ngachbac['status']==1) echo 'checked'; ?>>
					<span class="lbl">Có</span>
				</label>
			</div>
		</div>
		<div class="control-group row-fluid">
			<label class="control-label span3">Bậc hệ số</label>
			<div class="span9">
				<span class="btn btn-mini btn-success" id="btn_addrow_bacheso"><i class="icon-plus"></i></span>
				<table id="tbl_bac_heso" class="table table-bordered">
					<thead>
						<th class="center" style="width:42%">Bậc</th>
						<th class="center" style="width:42%">Hệ số</th>
						<th style="width:6%"></th>
					</thead>
					<tbody id="content_bacheso">
					<?php if($id>0&&count($ds_nhomngach_heso)>0){ ?>
						<?php for($i=0;$i<count($ds_nhomngach_heso);$i++){ ?>
						<?php $stt = $i+1; ?>
						<tr id="row_<?php echo $stt; ?>">
							<td>
								<input type="text" style="width:96%" name="idbac[]" value="<?php echo $ds_nhomngach_heso[$i]['idbac']; ?>">
								<input type="hidden" name="id_nhomngach_heso[]" value="<?php echo $ds_nhomngach_heso[$i]['id']; ?>">
							</td>
							<td>
								<input type="text" style="width:96%" name="heso[]" value="<?php echo $ds_nhomngach_heso[$i]['heso']; ?>">
							</td>
							<td class="center">
								<span class="btn btn-mini btn-danger btn_removerow_bacheso" data-stt="<?php echo $stt; ?>" data-id="<?php echo $ds_nhomngach_heso[$i]['id']; ?>"><i class="icon-trash"></i></span>
							</td>
						</tr>
						<?php } ?>
					<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</form>
</div>
<script>
	jQuery(document).ready(function($){
		var root_id = '<?php echo $root_id;?>';
		$("#caydonvi_quanly_ngachbac").jstree({
		  	"plugins" : ["themes","json_data","checkbox","types","ui","cookies"],
		   	"json_data" : {
		   		"data": <?php echo $model->getOneNodeJsTree(); ?>,
				"ajax" : {
					"url" : "<?php echo JURI::base(true);?>/index.php",
					"data" : function (n) {
						return {
				     			"option" : "com_danhmuc",   
				     			"view" : "luong",                         
				     			"task" : "tree_quanly_ngachbac",
				     			"format" : "raw",                            
				     			"root_id" :  root_id,
				     			"id" : n.attr ? n.attr("id").replace("node_","") : root_id
						};
					}
				}
			},
			"checkbox": {
		              	two_state: true,
		              	override_ui: false,
		              	real_checkboxes:true,
		        },
			"types" : {
				"valid_children" : [ "root" ],
				"types" : {
				"file" : {
				     	"icon" : { 
				      		"image" : "<?php echo JUri::root(true);?>/media/cbcc/js/jstree/file.png" 
				     	}                 
				},
				"folder" : {
				     	"icon" : { 
				      		"image" : "<?php echo JUri::root(true);?>/media/cbcc/js/jstree/folder.png" 
				     	}
				},
				"default" : {
			    	"check_node" : function (node) {
				        $('#caydonvi_quanly_ngachbac').jstree('uncheck_all');
				        // $('#caydonvi_quanly_ngachbac').jstree('check_node','#node_107');
				        return true;
					},
					"uncheck_node" : function (node) {
					    return true;
					}	
				}
			}
		}  
		}).bind("select_node.jstree", function (e, data) {
			id = data.rslt.obj.attr("id").replace("node_","");
			var id_ngachbac = $('#id_ngachbac').val();
			if(id_ngachbac>0){
				var ngachbac = '<?php echo json_encode($ngachbac); ?>';
				ngachbac = JSON.parse(ngachbac);
				$('#caydonvi_quanly_ngachbac').jstree('check_node','#node_'+ngachbac['parentid']);
			}
			
			// showlist = data.rslt.obj.attr('showlist');
			// if(showlist != '2'){
			// 	if(showlist == 1 || showlist == 3 || showlist == 0){
			// 		return false;
			// 	}else{
			// 			data.inst.toggle_node(data.rslt.obj);
			// 		}
			// }else data.inst.toggle_node(data.rslt.obj);
		});
		$('#caydonvi_quanly_ngachbac').on('loaded.jstree',function(){
			$('#caydonvi_quanly_ngachbac').jstree('select_node','#node_105');
		})
		$('#btn_addrow_bacheso').on('click',function(){
			var stt = $('#tbl_bac_heso >tbody >tr').length+1;
			var xhtml = '<tr id="row_'+stt+'">';
			xhtml += '<td><input type="text" style="width:96%" name="idbac[]"><input type="hidden" name="id_nhomngach_heso[]" value="0"></td>';
			xhtml += '<td><input type="text" style="width:96%" name="heso[]"></td>';
			xhtml += '<td class="center"><span class="btn btn-mini btn-danger btn_removerow_bacheso" data-stt="'+stt+'" data-id="0"><i class="icon-trash"></i></span></td>';
			xhtml += '</tr>';
			$('#content_bacheso').append(xhtml);
		});
		$('body').delegate('.btn_removerow_bacheso','click',function(){
			if(confirm('Bạn có muốn xóa không?')){
				$.blockUI();
				var id = $(this).data('id');
				var stt = $(this).data('stt');
				$('#row_'+stt).remove();
				if(id>0){
					$.ajax({
						type: 'post',
						url: 'index.php?option=com_danhmuc&controller=ngachbac&task=delete_cb_nhomngach_heso_by_id',
						data: {id:id},
						success:function(data){
							if(data==true){
								loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
								$.unblockUI();
							}
							else{
								loadNoticeBoardError('Thông báo','Xử lý thất bại, vui lòng liên hệ Quản trị viên.');
								$.unblockUI();
							}
						},
						error:function(){
							loadNoticeBoardError('Thông báo','Xử lý thất bại, vui lòng liên hệ Quản trị viên!');
							$.unblockUI();
						}
					});
				}
				else{
					loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
					$.unblockUI();
				}
				
			}
			else{
				return false;
			}
		});
		$('#form_ngachbac').validate({
            rules:{
                "frm[idbangluong]": {required: true},
                "frm[name]": {required: true},
                "frm[code]":{required:true},
                "frm[cap]":{required:true},
                "frm[sonamluong]":{required:true,digits:true},
                "frm[status]":{required:true},
                "idbac[]":{required:true,digits:true},
                "heso[]":{required:true,number:true}
            },
            messages:{
                "frm[idbangluong]": {required: 'Vui lòng chọn bảng lương'},
                "frm[name]": {required: 'Vui lòng nhập tên ngạch'},
                "frm[code]":{required:'Vui lòng nhập mã ngạch'},
                "frm[cap]":{required:'Vui lòng chọn cấp'},
                "frm[sonamluong]":
                {
                	required:'Vui lòng nhập số năm lên lương',
                	digits:'Vui lòng nhập số nguyên dương cho trường số năm lên lương'
                },
                "frm[status]":{required:'Vui lòng chọn sử dụng'},
                "idbac[]":
                {
                	required: 'Vui lòng nhập bậc',
                	digits:'Vui lòng nhập số nguyên dương cho trường bậc'
                },
                "heso[]":
                {
                	required: 'Vui lòng nhập hệ số',
                	number:'Vui lòng nhập số cho trường hệ số'
                }
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
        $('#btn_luu_ngachbac').on('click',function(){
        	var id = $("#caydonvi_quanly_ngachbac").jstree("get_checked", null, true);
        	var stt = $('#tbl_bac_heso >tbody >tr').length;
        	if(stt==0){
        		if(confirm('Nhóm ngạch này không có bậc hệ số, bạn có muốn tiếp tục lưu?')){
        			
        		}
        		else{
        			return false;
        		}
        	}	
        	if($('#form_ngachbac').valid()==true){       		
				if(id.length==0){
					loadNoticeBoardError('Thông báo','Vui lòng chọn nhóm cấp trên');
					return false;
				}
				else{
					$.blockUI();
					id = id.attr("id").replace("node_","");
					$('#input_parentid').val(id);
					$.ajax({
						type: 'post',
						url: 'index.php?option=com_danhmuc&controller=ngachbac&task=luu_ngachbac',
						data: $('#form_ngachbac').serialize(),
						success:function(data){
							if(data>0){
								loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
								$.unblockUI();
								$('#btn_cancel_ngachbac').click();
							}
							else{
								loadNoticeBoardError('Thông báo','Xử lý thất bại, vui lòng liên hệ Quản trị viên.');
								$.unblockUI();
							}
						},
						error:function(){
							loadNoticeBoardError('Thông báo','Xử lý thất bại, vui lòng liên hệ Quản trị viên!');
							$.unblockUI();
						}
					});
				}
        	}
        	else{
        		return false;
        	}
        });
        $('#btn_cancel_ngachbac').on('click',function(){
        	window.location.href= 'index.php?option=com_danhmuc&controller=luong&task=ds_quanly_ngachbac';
        });
	});
</script>