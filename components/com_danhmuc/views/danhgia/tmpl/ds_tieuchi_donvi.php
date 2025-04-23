<?php 
	$model = Core::model('Danhgia/Tieuchidonvi');
	$root_id = $this->root_id;
	$ds_dotdanhgia_thang = $this->ds_dotdanhgia_thang;
	$ds_donvi = $this->ds_donvi;
	$year_check = '';
	$jinput = JFactory::getApplication()->input;
	$format = $jinput->getString('format','');
	// var_dump($ds_dotdanhgia_thang);die;
?>
<div id="ds_dgcbcc_botieuchi">
	<h2 class="header">Cấu hình tiêu chí đơn vị
		<div class="pull-right" style="width:25%">
			<div class="row-fluid">
				<div class="span6">
					<span class="span4" style="font-size:15px;padding-top:2%">Đợt:</span>
					<select class="span8" id="id_dotdanhgia_thang">
						<?php $date_dot = $ds_dotdanhgia_thang[0]['date_dot']; ?>
						<?php $year = substr($date_dot,0,4); ?>
						<?php for($i=0;$i<count($ds_dotdanhgia_thang);$i++){ ?>	
							<?php $year1 = substr($ds_dotdanhgia_thang[$i]['date_dot'],0,4); ?>
							<?php if($year1==$year){ ?>
							<?php $month = substr($ds_dotdanhgia_thang[$i]['date_dot'],5,2); ?>
							<option value="<?php echo $ds_dotdanhgia_thang[$i]['date_dot']; ?>"><?php echo $month; ?></option>
							<?php }?>
						<?php } ?>
					</select>
				</div>
				<div class="span6">
					<span style="font-size:15px;padding-top:2%" class="span4">Năm:</span>
					<select class="span8" id="dotdanhgia_nam">
						<?php for($i=0;$i<count($ds_dotdanhgia_thang);$i++){ ?>
							<?php $date_dot = $ds_dotdanhgia_thang[$i]['date_dot']; ?>
							<?php $year = substr($date_dot,0,4); ?>
							<?php if($year!=$year_check){ ?>
								<?php $year_check = $year;?>
								<option value="<?php echo $year; ?>"><?php echo $year; ?></option>
							<?php }?>
						<?php }?>
					</select>
				</div>
			</div>
		</div>
	</h2>
	<div class="row-fluid">
		<table class="table table-bordered">
			<thead>
				<th style="width:5%" class="center">STT</th>
				<th style="width:40%" class="center">Tên tiêu chí</th>
				<th style="width:40%" class="center">Tên tiêu chí mới</th>
				<th style="width:15%" class="center">Hiệu chỉnh</th>
			</thead>
			<tbody id="content_table_cauhinhtieuchi"></tbody>
		</table>
	</div>
</div>
<?php if($format==''){ ?>
<div id="content"></div>
<div id="modal-form" class="modal hide" tabindex="-1" style="width:900px;left:35%;"></div>
<?php }?>
<style>
#main-content-tree{
 height: 200px;
 overflow: auto;
}
</style>
<script>
	jQuery(document).ready(function($){
		$('.chzn-select').chosen({"width":"100%","search_contains":true,"display":"inline-block"});
		var root_id = '<?php echo $this->root_id;?>';
			// console.log(root_id);
		createTreeviewInMenuBar('Cây bộ tiêu chí');
		$("#main-content-tree").jstree({
		  	"plugins" : ["themes","json_data","checkbox","types","ui","cookies"],
		   	"json_data" : {
		   		"data": <?php echo $model->getOneNodeJsTree($root_id); ?>,
				"ajax" : {
					"url" : "<?php echo JURI::base(true);?>/index.php",
					"data" : function (n) {
						return {
				     			"option" : "com_danhmuc",   
				     			"view" : "danhgia",                         
				     			"task" : "tree_botieuchi",
				     			"format" : "raw",                            
				     			"root_id" :  root_id,
				     			"id" : n.attr ? n.attr("id").replace("node_","") : root_id,
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
				        $('#main-content-tree').jstree('uncheck_all');
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
			var id_dotdanhgia_thang = $('#id_dotdanhgia_thang').val();
			if(id>0){
				$.blockUI();
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=tieuchi_donvi&task=find_tieuchi_by_botieuchi',
					data: {id:id,id_dotdanhgia_thang:id_dotdanhgia_thang},
					success:function(data){
						if(data==''){
							$('#content_table_cauhinhtieuchi').html('');
						}
						else if(data==false){
							loadNoticeBoardError('Thông báo','Xử lý thất bại, vui lòng liên hệ Quản trị viên!');
							console.log('123');
							$.unblockUI();
						}
						
						else{
							var xhtml = '';
							var name_botieuchi = '';
							var stt = 1;
							for(var i=0;i<data.length;i++){
								if(data[i]['tentieuchimoi']==null){
									$tentieuchimoi = '';
								}
								else{
									$tentieuchimoi = data[i]['tentieuchimoi'];
								}
								if(data[i]['name_botieuchi']!=name_botieuchi){
									xhtml += '<tr>';
									xhtml += '<td class="center" colspan="4">'+data[i]['name_botieuchi']+'</td>';
									xhtml +='</tr>';
									name_botieuchi = data[i]['name_botieuchi'];
								}
								xhtml += '<tr>';
								xhtml += '<td style="vertical-align:middle" class="center">'+stt+'</td>';
								xhtml += '<td style="vertical-align:middle">'+data[i]['name_tieuchi']+'</td>';
								xhtml += '<td style="vertical-align:middle">'+$tentieuchimoi+'</td>';
								xhtml += '<td style="vertical-align:middle" class="center"><span class="btn btn-mini btn-primary btn_change_dgcbcc_tieuchi" data-id="'+data[i]['id_tieuchi']+'" href="#modal-form" data-toggle="modal">Thay đổi</span></td>';
								xhtml += '</tr>';
								stt += 1;
							}
							$('#content_table_cauhinhtieuchi').html(xhtml);
							$.unblockUI();
						}
					},
					error:function(){
						// loadNoticeBoardError('Thông báo','Xử lý thất bại, vui lòng liên hệ Quản trị viên.');
						$.unblockUI();
					}
				});
				$.unblockUI();
			}
		});
		$('#id_dotdanhgia_thang').on('change',function(){
			$.blockUI();
			var id;
			$.jstree._reference('#main-content-tree')._get_node(null, true).each(function() {
				id = $(this).attr("id").replace("node_","");    
			});
			var id_dotdanhgia_thang = $('#id_dotdanhgia_thang').val();
			$.ajax({
				type: 'post',
				url: 'index.php?option=com_danhmuc&controller=tieuchi_donvi&task=find_tieuchi_by_botieuchi',
				data: {id:id,id_dotdanhgia_thang:id_dotdanhgia_thang},
				success:function(data){
					if(data==''){
						$('#content_table_cauhinhtieuchi').html('');
						$.unblockUI();
					}
					else if(data==false){
						loadNoticeBoardError('Thông báo','Xử lý thất bại, vui lòng liên hệ Quản trị viên!');
						console.log('123');
						$.unblockUI();
					}
					
					else{
						var xhtml = '';
						var name_botieuchi = '';
						var stt = 1;
						for(var i=0;i<data.length;i++){
							if(data[i]['tentieuchimoi']==null){
								$tentieuchimoi = '';
							}
							else{
								$tentieuchimoi = data[i]['tentieuchimoi'];
							}
							if(data[i]['name_botieuchi']!=name_botieuchi){
								xhtml += '<tr>';
								xhtml += '<td class="center" colspan="4">'+data[i]['name_botieuchi']+'</td>';
								xhtml +='</tr>';
								name_botieuchi = data[i]['name_botieuchi'];
							}
							xhtml += '<tr>';
							xhtml += '<td style="vertical-align:middle" class="center">'+stt+'</td>';
							xhtml += '<td>'+data[i]['name_tieuchi']+'</td>';
							xhtml += '<td>'+$tentieuchimoi+'</td>';
							xhtml += '<td style="vertical-align:middle" class="center"><span class="btn btn-mini btn-primary btn_change_dgcbcc_tieuchi" data-id="'+data[i]['id_tieuchi']+'" href="#modal-form" data-toggle="modal">Thay đổi</span></td>';
							xhtml += '</tr>';
							stt += 1;
						}
						$('#content_table_cauhinhtieuchi').html(xhtml);
						$.unblockUI();
					}
				},
				error:function(){
					// loadNoticeBoardError('Thông báo','Xử lý thất bại, vui lòng liên hệ Quản trị viên.');
					$.unblockUI();
				}
			});
		});
		$('#id_dotdanhgia_thang').change();
		$('#dotdanhgia_nam').on('change',function(){
			// setCookie('danhgia_nam',$(this).val());
			var nam_danhgia = $(this).val();
			var ds_dotdanhgia_thang = '<?php echo json_encode($ds_dotdanhgia_thang); ?>';
			ds_dotdanhgia_thang = JSON.parse(ds_dotdanhgia_thang);
			var year='';
			var xhtml = '';
			var id_dotdanhgia = $.cookie('danhgia_id_dotdanhgia');
			var month_check = '';
			for(var i=0;i<ds_dotdanhgia_thang.length;i++){
				year = ds_dotdanhgia_thang[i]['date_dot'].substring(0,4);
				month = ds_dotdanhgia_thang[i]['date_dot'].substring(5,7);
				if(year==nam_danhgia){
					if(month!=month_check){
						month_check = month;
						xhtml += '<option value="'+ds_dotdanhgia_thang[i]['date_dot']+'">'+month+'</option>';
					}	
				}
			}
			$('#id_dotdanhgia_thang').html(xhtml);
			$('#id_dotdanhgia_thang').change();
		});
		$('body').delegate('.btn_change_dgcbcc_tieuchi','click',function(){
			var id = $(this).data('id');
			$('#modal-form').html('');
	    	$('#modal-form').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&controller=danhgia&task=change_tieuchi_donvi&format=raw&id_tieuchi='+id, function(){
	    	});
		});
	});
</script>