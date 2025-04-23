<?php 
	$model = Core::model('Danhmuchethong/Dgcbcc_botieuchi');
	var_dump($model);
	$root_id = $this->root_id;
	$jinput = JFactory::getApplication()->input;
	$format = $jinput->getString('format','');
	$ds_dgcbcc_nhiemvu = $this->ds_dgcbcc_nhiemvu;
?>
<div id="ds_dgcbcc_botieuchi">
	<h2 class="header">Danh sách bộ tiêusdasdasdasdasasd chí đánh giá cán bộ công chức
		<div class="pull-right">
			<span class="btn btn-small btn-info" id="btn_thietlaplai_dgcbcc_botieuchi">Thiết lập lại</span>
			<span class="btn btn-small btn-success" id="btn_themmoi_dgcbcc_botieuchi" href="#modal-form" data-toggle="modal">Thêm mới</span>
			<span class="btn btn-small btn-primary" id="btn_edit_dgcbcc_botieuchi">Hiệu chỉnh</span>
			<span class="btn btn-small btn-danger" id="btn_delete_dgcbcc_botieuchi">Xóa</span>
		</div>
	</h2>
	<div class="accordion-group" style="margin:3%">
		<div class="accordion-heading">
			<a href="#collapseFourteen" data-toggle="collapse" class="accordion-toggle collapsed">Tìm kiếm</a>
		</div>
		<div class="accordion-body collapse" id="collapseFourteen">
			<div class="accordion-inner">
				<div class="row-fluid">
					<label class="span3">Nhiệm vụ đánh giá cán bộ công chức</label>
					<div class="span9">
						<select class="span12" id="tk_dgcbcc_botieuchi_bynhiemvu">
							<option value="">--Chọn--</option>
							<?php for($i=0;$i<count($ds_dgcbcc_nhiemvu);$i++){ ?>
							<option value="<?php echo $ds_dgcbcc_nhiemvu[$i]['id'] ?>"><?php echo $ds_dgcbcc_nhiemvu[$i]['name']; ?></option>
							<?php }?>
						</select>
					</div>
					<div class="span12 center">
						<span class="btn btn-info btn-small" id="btn_tk_dgcbcc_botieuchi">Tìm kiếm</span>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="pull-right">
		<span class="btn btn-small btn-info" id="btn_sapxeplen_dgcbcc_botieuchi">Sắp xếp lên</span>
		<span class="btn btn-small btn-info" id="btn_sapxepxuong_dgcbcc_botieuchi">Sắp xếp xuống</span>
		<span class="btn btn-small btn-info" id="btn_saochepnhanh_dgcbcc_botieuchi" href="#modal-form" data-toggle="modal">Sao chép nhánh</span>
	</div>
	<div id="caydonvi_dgcbcc_botieuchi" style="overflow:auto;"> CÂY ĐƠN VỊ </div>
</div>
<?php if($format==''){ ?>
<div id="content"></div>
<div id="modal-form" class="modal hide" tabindex="-1" style="width:900px;left:35%;"></div>
<?php }?>
<script>
	jQuery(document).ready(function($){
		$('#btn_tk_dgcbcc_botieuchi').on('click',function(){
			var nhiemvu_id = $('#tk_dgcbcc_botieuchi_bynhiemvu').val();
			var root_id = '<?php echo $this->root_id;?>';
			$("#caydonvi_dgcbcc_botieuchi").jstree({
			  	"plugins" : ["themes","json_data","checkbox","types","ui","cookies"],
			   	"json_data" : {
			   		"data": <?php echo $model->getOneNodeJsTree($root_id); ?>,
					"ajax" : {
						"url" : "<?php echo JURI::base(true);?>/index.php",
						"data" : function (n) {
							return {
					     			"option" : "com_danhmuc",   
					     			"view" : "danhgia",                         
					     			"task" : "tree_dgcbcc_botieuchi",
					     			"format" : "raw",                            
					     			"root_id" :  root_id,
					     			"id" : n.attr ? n.attr("id").replace("node_","") : root_id,
					     			"nhiemvu_id": nhiemvu_id
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
					        $('#caydonvi_dgcbcc_botieuchi').jstree('uncheck_all');
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
				// showlist = data.rslt.obj.attr('showlist');
				// if(showlist != '2'){
				// 	if(showlist == 1 || showlist == 3 || showlist == 0){
				// 		return false;
				// 	}else{
				// 			data.inst.toggle_node(data.rslt.obj);
				// 		}
				// }else data.inst.toggle_node(data.rslt.obj);
			});
		});
		$('#btn_tk_dgcbcc_botieuchi').click();	
		$('#btn_thietlaplai_dgcbcc_botieuchi').on('click',function(){
			window.location.href = 'index.php?option=com_danhmuc&controller=dgcbcc_botieuchi&task=reset_tree_dgcbcc_botieuchi';
		});
		$('#btn_sapxeplen_dgcbcc_botieuchi').on('click',function(){
			var id = $("#caydonvi_dgcbcc_botieuchi").jstree("get_checked", null, true).attr("id").replace("node_","");
			window.location.href = 'index.php?option=com_danhmuc&controller=dgcbcc_botieuchi&task=sapxeplen_tree_dgcbcc_botieuchi&id='+id;
		});
		$('#btn_sapxepxuong_dgcbcc_botieuchi').on('click',function(){
			var id = $("#caydonvi_dgcbcc_botieuchi").jstree("get_checked", null, true).attr("id").replace("node_","");
			window.location.href = 'index.php?option=com_danhmuc&controller=dgcbcc_botieuchi&task=sapxepxuong_tree_dgcbcc_botieuchi&id='+id;
		});
		$('#btn_themmoi_dgcbcc_botieuchi').on('click',function(){
			$('#modal-form').html('');
	    	$('#modal-form').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&controller=danhgia&task=themmoi_dgcbcc_botieuchi&format=raw', function(){
	    	});
		});
		$('#btn_edit_dgcbcc_botieuchi').on('click',function(){		
			var id = $("#caydonvi_dgcbcc_botieuchi").jstree("get_checked", null, true);
			if(id.length>0){
				id = id.attr("id").replace("node_","");
				$('#modal-form').html('');
		    	$('#modal-form').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&controller=danhgia&task=chinhsua_dgcbcc_botieuchi&format=raw&id='+id, function(){
		    	});
		    	$('#modal-form').modal('show');
			}
			else{
				loadNoticeBoardError('Thông báo','Vui lòng chọn một bộ tiêu chí để hiệu chỉnh');
			}
		});
		$('#btn_delete_dgcbcc_botieuchi').on('click',function(){
			var id = $("#caydonvi_dgcbcc_botieuchi").jstree("get_checked", null, true);
			if(id.length>0){
				if(confirm('Bạn có muốn xóa không?')){
					$.blockUI();
					id = id.attr("id").replace("node_","");
					$.ajax({
						type: 'post',
						url: 'index.php?option=com_danhmuc&controller=dgcbcc_botieuchi&task=delete_dgcbcc_botieuchi',
						data: {id:id},
						success:function(data){
							if(data==true){
								loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
								$.unblockUI();
								$('#btn_thietlaplai_dgcbcc_botieuchi').click();
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
				loadNoticeBoardError('Thông báo','Vui lòng chọn một bộ tiêu chí để xóa');
			}
		});
		$("#btn_saochepnhanh_dgcbcc_botieuchi").on('click',function(){
			$('#modal-form').html('');
	    	$('#modal-form').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&controller=danhgia&task=saochep_dgcbcc_botieuchi&format=raw', function(){
	    	});
		});
	});
</script>