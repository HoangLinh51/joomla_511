<?php 
	$root_id = 0;
	$model = Core::model('Danhmuchethong/Ngachbac');
?>
<div id="ds_quanly_ngachbac">
	<h3 class="header blue">Quản lý Ngạch bậc</h3>
	<div class="row-fluid">		
		<div class="span3">
			<span class="btn btn-small btn-success" id="btn_themmoi_ngachbac">Thêm mới</span>
			<span class="btn btn-small btn-primary" id="btn_edit_ngachbac">Hiệu chỉnh</span>
			<span class="btn btn-small btn-danger">Xóa</span>
			<div id="caydonvi_quanly_ngachbac" style="overflow:auto; height: 600px;margin-top:5%"> CÂY ĐƠN VỊ </div>
		</div>
		<div class="span9">
			<div id="table_thongtin_nhomngach"></div>
			<div id="table_thongtin_ngach"></div>
		</div>
	</div>
</div>
<div id="content"></div>
<div id="modal-form" class="modal hide" tabindex="-1" style="width:900px;left:35%;"></div>
<script>
	jQuery(document).ready(function($){
		var root_id = '<?php echo $root_id;?>';
		$("#caydonvi_quanly_ngachbac").jstree({
		  	"plugins" : ["themes","json_data","types","ui","cookies"],
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
			loadTableNhomngach(id);
			loadTableNgach(id);
			// showlist = data.rslt.obj.attr('showlist');
			// if(showlist != '2'){
			// 	if(showlist == 1 || showlist == 3 || showlist == 0){
			// 		return false;
			// 	}else{
			// 			data.inst.toggle_node(data.rslt.obj);
			// 		}
			// }else data.inst.toggle_node(data.rslt.obj);
		});
		var loadTableNhomngach = function(id){
			$.blockUI();
			$('#table_thongtin_nhomngach').load('index.php?option=com_danhmuc&controller=luong&task=table_thongtin_nhomngach&format=raw&id='+id,function(){
				$.unblockUI();
			});
		}
		var loadTableNgach = function(id){
			$.blockUI();
			$('#table_thongtin_ngach').load('index.php?option=com_danhmuc&controller=luong&task=table_thongtin_ngach&format=raw&id='+id,function(){
				$.unblockUI();
			});
		}
		$('#btn_themmoi_ngachbac').on('click',function(){
			window.location.href= 'index.php?option=com_danhmuc&controller=luong&task=themmoi_ngachbac';
		});
		$('#btn_edit_ngachbac').on('click',function(){
			var id;
			$.jstree._reference('#caydonvi_quanly_ngachbac')._get_node(null, true).each(function() {
				id = $(this).attr("id").replace("node_","");    
			});
			// console.log(id);
			if(id==0||id==''){
				loadNoticeBoardError('Thông báo','Vui lòng chọn một ngạch để hiệu chỉnh');
				return false;
			}
			else{
				// id = id.attr("id").replace("node_","");
				window.location.href = 'index.php?option=com_danhmuc&controller=luong&task=chinhsua_ngachbac&id='+id;
			}
		});
	});
</script>