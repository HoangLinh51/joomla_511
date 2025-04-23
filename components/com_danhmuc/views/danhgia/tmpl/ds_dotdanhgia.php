<?php 
	$ds_dotdanhgia = $this->ds_dotdanhgia;
	$year1 = '';
	$jinput = JFactory::getApplication()->input;
	$format = $jinput->getString('format','');
?>
<div id="ds_dotdanhgia">
	<h2 class="header">
		Đợt đánh giá cán bộ công chức
		<div class="pull-right">
			<span class="btn btn-small btn-success" id="btn_themmoi_dotdanhgia" href="#modal-form" data-toggle="modal">Thêm mới</span>
			<span class="btn btn-small btn-danger" id="btn_xoanhieu_dotdanhgia">Xóa</span>
		</div>
	</h2>
	<div class="pull-right row-fluid">
		<div class="span9"></div>
		<div class="span3">
			<div class="span2" style="padding-top:2%;font-size:18px">Đợt</div>
			<div class="span4">
				<select class="span12" id="dotdanhgia_id">
				<?php 
					$year = substr($ds_dotdanhgia[0]['date_dot'],0,4);
					for($i=0;$i<count($ds_dotdanhgia);$i++){
						$year_dot = substr($ds_dotdanhgia[$i]['date_dot'],0,4);
						if($year_dot==$year){
							$month = substr($ds_dotdanhgia[$i]['date_dot'],5,2);
				?>
					<option value="<?php echo $ds_dotdanhgia[$i]['date_dot']; ?>"><?php echo $month; ?></option>
					<?php }?>
				<?php }?>
				</select>
			</div>
			<div class="span2" style="padding-top:2%;font-size:18px">Năm</div>
			<div class="span4">
				<select class="span12" id="dotdanhgia_nam">
					<?php for($i=0;$i<count($ds_dotdanhgia);$i++){ ?>
					<?php 
						$year = substr($ds_dotdanhgia[$i]['date_dot'],0,4); 
						if($year!=$year1){
							$year1 = $year;
					?>
						<option value="<?php echo $year; ?>"><?php echo $year; ?></option>
						<?php }?>
					<?php }?>
				</select>
			</div>
		</div>
	</div>
	<div id="table_dotdanhgia"></div>
</div>
<?php if($format==''){ ?>
<div id="content"></div>
<div id="modal-form" class="modal hide" tabindex="-1" style="width:900px;left:35%;"></div>
<?php }?>
<script>	
	jQuery(document).ready(function($){
		function setCookie(name,value){
		    document.cookie = name + "=" + value;
		}
		function getCookie(name) {
		    var nameEQ = name + "=";
		    var ca = document.cookie.split(';');
		    for(var i=0;i < ca.length;i++) {
		        var c = ca[i];
		        while (c.charAt(0)==' ') c = c.substring(1,c.length);
		        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
		    }
		    return null;
		}
		var loadTable = function(){
			$.blockUI();
			var date_dot = $('#dotdanhgia_id').val();
			$('#table_dotdanhgia').load('index.php?option=com_danhmuc&controller=danhgia&task=table_dotdanhgia&format=raw&date_dot='+date_dot,function(){
				$.unblockUI();
			});
		};
		loadTable();
		$('#dotdanhgia_nam').on('change',function(){
			setCookie('danhgia_nam',$(this).val());
			var year = $(this).val();
			var ds_dotdanhgia = '<?php echo json_encode($ds_dotdanhgia); ?>';
			var xhtml = '';
			var year_dot = '';
			var month_dot = '';
			ds_dotdanhgia = JSON.parse(ds_dotdanhgia);
			var danhgia_id_dotdanhgia = getCookie('danhgia_id_dotdanhgia');
			console.log(danhgia_id_dotdanhgia);
			for(var i=0;i<ds_dotdanhgia.length;i++){
				year_dot = ds_dotdanhgia[i]['date_dot'].substring(0,4);
				if(year_dot==year){
					month_dot = ds_dotdanhgia[i]['date_dot'].substring(5,7);
					if(ds_dotdanhgia[i]['date_dot']==danhgia_id_dotdanhgia){
						xhtml += '<option value="'+ds_dotdanhgia[i]['date_dot']+'" selected>'+month_dot+'</option>';
					}
					else{
						xhtml += '<option value="'+ds_dotdanhgia[i]['date_dot']+'">'+month_dot+'</option>';
					}				
				}
			}
			$("#dotdanhgia_id").html(xhtml);
			$('#dotdanhgia_id').change();
		});
		$('#dotdanhgia_id').on('change',function(){
			setCookie('danhgia_id_dotdanhgia',$(this).val());
			loadTable();
		});
		$('#btn_themmoi_dotdanhgia').on('click',function(){
			$('#modal-form').html('');
	    	$('#modal-form').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&controller=danhgia&task=themmoi_dotdanhgia&format=raw', function(){
	    	});
		});
		$('#btn_xoanhieu_dotdanhgia').on('click',function(){
			if(confirm('Bạn có muốn xóa không?')){
				$.blockUI();
				var array_id = [];
				$('.array_id_dotdanhgia').each(function(){
					array_id.push($(this).val());
				});
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=dotdanhgia&task=xoanhieu_dotdanhgia',
					data: {id:array_id},
					success:function(data){
						if(data.length>0){
							var count  = 0;
							for(var i=0;i<data.length;i++){
								if(data[i]==true){
									count++;
								}
							}
							if(count>0){
								$('#dotdanhgia_nam').change();
								loadNoticeBoardSuccess('Thông báo','Xử lý thành công '+count+'/'+data.length);
								$.unblockUI();
							}
							else{
								loadNoticeBoardError('Thông báo','Xử lý thất bại, vui lòng liên hệ Quản trị viên.');
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
		});
	});
</script>