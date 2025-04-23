<?php 
	$ds_dotdanhgia = $this->ds_dotdanhgia;
	$year = '';
	$jinput = JFactory::getApplication()->input;
	$format = $jinput->getString('format','');
?>
<div id="ds_tiendo_xeploai">
	<h2 class="header">Tiến độ
		<div class="pull-right">
			<span class="btn btn-small btn-success" id="btn_themmoi_tiendo" href="#modal-form" data-toggle="modal">Thêm mới</span>
			<span class="btn btn-small btn-danger" id="btn_xoanhieu_tiendo">Xóa</span>
		</div>
	</h2>
	<div class="row-fluid pull-right">
		<div class="span7"></div>
		<div class="span5">
			<div class="span2" style="padding-top:2%">Đợt</div>
			<div class="span5">
				<select id="select_id_dotdanhgia" class="span12">
					<?php $year_dot = substr($ds_dotdanhgia[0]['date_dot'],0,4); ?>
					<?php for($i=0;$i<count($ds_dotdanhgia);$i++){ ?>
						<?php if(substr($ds_dotdanhgia[$i]['date_dot'],0,4)==$year_dot){ ?>
						<option value="<?php echo $ds_dotdanhgia[$i]['id']; ?>"><?php echo $ds_dotdanhgia[$i]['name']; ?></option>
						<?php } ?>
					<?php } ?>
				</select>
			</div>
			<div class="span2" style="padding-top:2%">Năm</div>
			<div class="span3">
				<select class="span12" id="select_dotdanhgia_nam">
					<?php for($i=0;$i<count($ds_dotdanhgia);$i++){ ?>
						<?php 
							$year_dot = substr($ds_dotdanhgia[$i]['date_dot'],0,4);
							if($year_dot!=$year){
								$year = $year_dot;
						?>
						<option value="<?php echo $year; ?>"><?php echo $year; ?></option>
						<?php } ?>
					<?php } ?>
				</select>
			</div>
		</div>
	</div>
	<div id="table_tiendo_xeploai"></div>
</div>
<?php if($format==''){ ?>
<div id="content"></div>
<div id="modal-form" class="modal hide" tabindex="-1" style="width:900px;left:35%;"></div>
<?php } ?>
<script>
	jQuery(document).ready(function($){
		$('#select_id_dotdanhgia').on('change',function(){
			$.blockUI();
			var id_dotdanhgia = $(this).val();
			$('#table_tiendo_xeploai').load('index.php?option=com_danhmuc&controller=danhgia&task=table_tiendo_xeploai&format=raw&id_dotdanhgia='+id_dotdanhgia,function(){
				$.unblockUI();
			});
		});
		$('#select_id_dotdanhgia').change();
		$('#select_dotdanhgia_nam').on('change',function(){
			var dotdanhgia_nam = $(this).val();
			var ds_dotdanhgia = '<?php echo json_encode($ds_dotdanhgia); ?>';
			ds_dotdanhgia = JSON.parse(ds_dotdanhgia);
			var year_dotdanhgia;
			var xhtml = '';
			for(var i=0;i<ds_dotdanhgia.length;i++){
				year_dotdanhgia = ds_dotdanhgia[i]['date_dot'].substring(0,4);
				if(year_dotdanhgia==dotdanhgia_nam){
					xhtml += '<option value="'+ds_dotdanhgia[i]['id']+'">'+ds_dotdanhgia[i]['name']+'</option>';
				}
			}
			$('#select_id_dotdanhgia').html(xhtml);
			$('#select_id_dotdanhgia').change();
		});
		$('#btn_themmoi_tiendo').on('click',function(){
			$('#modal-form').html('');
	    	$('#modal-form').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&controller=danhgia&task=themmoi_tiendo_xeploai&format=raw', function(){
	    	});
		});
		$('#btn_xoanhieu_tiendo').on('click',function(){
			var array_id = [];
			$('.array_id_tiendo:checked').each(function(){
				array_id.push($(this).val());
			});
			if(array_id.length>0){
				if(confirm("Bạn có muốn xóa không?")){
					$.blockUI();
					$.ajax({
						type: 'post',
						url: 'index.php?option=com_danhmuc&controller=tiendo&task=xoanhieu_tiendo',
						data: {array_id:array_id},
						success:function(data){
							if(data.length>0){
								var count = 0;
	        					for(var i=0;i<data.length;i++){
	        						if(data[i]==true){
	        							count++;
	        						}
	        					}
	        					if(count>0){
	        						$('#select_id_dotdanhgia').change();
		        					loadNoticeBoardSuccess('Thông báo','Xử lý thành công '+count+'/'+data.length);
		        					$.unblockUI();
	        					}
	        					else{
	        						loadNoticeBoardError('Thông báo','Xử lý thất bại, vui lòng liên hệ Quản trị viên..');
	        						$.unblockUI();
	        					}
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
					return false;
				}
			}
			else{
				loadNoticeBoardError('Thông báo','Vui lòng chọn ít nhất một tiến độ để xóa');
				return false;
			}
		});
	});
</script>