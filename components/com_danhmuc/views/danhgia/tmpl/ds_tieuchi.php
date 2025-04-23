<?php 
	$jinput = JFactory::getApplication()->input;
	$format = $jinput->getString('format','');
	$ds_nhomtieuchi = $this->ds_nhomtieuchi;
?>
<div id="ds_tieuchi">
	<h2 class="header" style="padding-bottom:1%">Danh sách tiêu chí
		<div class="pull-right">
			<span class="btn btn-small btn-primary" id="btn_themmoi_tieuchi">Thêm mới</span>
			<span class="btn btn-small btn-danger" id="btn_xoanhieu_tieuchi">Xóa</span>
			<span class="btn btn-small btn-success" id="btn_xuatexcel_tieuchi">Xuất excel</span>
		</div>
	</h2>
	<div id="accordion_tktieuchi" class="accordion">
		<div class="accordion-group">
			<div class="accordion-heading">
				<a href="#collapseTwo" data-parent="#accordion_tktieuchi" data-toggle="collapse" class="accordion-toggle collapsed">Tìm kiếm</a>
			</div>
			<div class="accordion-body collapse" id="collapseTwo">
				<div class="acordion-inner">
					<form class="form-horizontal">
						<div class="row-fluid">
							<div class="control-group" style="padding-top:3%">
								<div class="span4">
									<label class="control-label span4">Tên tiêu chí</label>
									<div class="controls span8">
										<input type="text" name="tk_tentieuchi" id="tk_tentieuchi" class="span12"/>		
									</div>
								</div>
								<div class="span6">
									<label class="control-label span3">Nhóm tiêu chí</label>
									<div class="controls span8">
										<select class="span12" id="tk_tieuchi_bynhomtieuchi">
											<option value="">--Chọn--</option>
											<?php for($i=0;$i<count($ds_nhomtieuchi);$i++){ ?>
											<option value="<?php echo $ds_nhomtieuchi[$i]['id']; ?>">
												<?php echo $ds_nhomtieuchi[$i]['name']; ?>
											</option>
											<?php } ?>
										</select>
										
									</div>
								</div>
								<div class="span2">
									<span class="btn btn-small btn-info" id="btn_search_tktieuchi">Tìm kiếm</span>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div id="table_tieuchi"></div>
</div>
<?php if($format==''){ ?>
<div id="content"></div>
<div id="modal-form" class="modal hide" tabindex="-1" style="width:900px;left:35%;">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="blue bigger" id="modal-title"></h4>
    </div>
    <div class="modal-body overflow-visible">
        <div id="modal-content" class="slim-scroll" data-height="350">

        </div>
    </div>
    <div class="modal-footer">

    </div>
</div>
<?php }?>
<script>
	jQuery(document).ready(function($){
		$('#btn_search_tktieuchi').on('click',function(){
			$.blockUI();
			var tk_tieuchi_bynhomtieuchi = $('#tk_tieuchi_bynhomtieuchi').val();
			$('#table_tieuchi').load('index.php?option=com_danhmuc&view=danhgia&task=table_tieuchi&format=raw&ten='+$('#tk_tentieuchi').val()+'&nhomtieuchi='+tk_tieuchi_bynhomtieuchi,function(){
				$.unblockUI();
			});
		});
		$('#btn_search_tktieuchi').click();
		$('#btn_themmoi_tieuchi').on('click',function(){
			$('#modal-title').html('Thêm mới tiêu chí');
	        $('#modal-content').html('');
	        $('#modal-content').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&view=danhgia&task=themmoitieuchi&format=raw', function(){
	            $('.modal-footer').html('<button class="btn btn-small" data-dismiss="modal">Hủy bỏ</button><button index="-1" class="btn btn-small btn-primary" id="btn_tieuchi_luu">Áp dụng</button>');
	            $('#modal-form').modal('show');

	        });
		});
		$('body').delegate('#btn_tieuchi_luu','click',function(){
			if($('#form_tieuchi').valid()==true){
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=tieuchi&task=themthongtintieuchi',
					data: $('#form_tieuchi').serialize(),
					success:function(data){
						if(data=='true'){
							$('#modal-form').modal('hide');
							$('#btn_search_tktieuchi').click();
							loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
						}
						else{
							loadNoticeBoardError('Thông báo','Xử lý thất bại, vui lòng liên hệ Quản trị viên');
						}
					}
				});
			}	
			else{
				return false;
			}
		});
		$('body').delegate('#btn_edit_tieuchi','click',function(){
			var tc_id = $(this).data('id');
			$('#modal-title').html('Chỉnh sửa tiêu chí');
	        $('#modal-content').html('');
	        $('#modal-content').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&view=danhgia&task=chinhsuatieuchi&format=raw&tc_id='+tc_id, function(){
	            $('.modal-footer').html('<button class="btn btn-small" data-dismiss="modal">Hủy bỏ</button><button index="-1" class="btn btn-small btn-primary" id="btn_tieuchi_update">Áp dụng</button>');
	            $('#modal-form').modal('show');

	        });
		});
		$('body').delegate('#btn_tieuchi_update','click',function(){
			if($('#form_tieuchi').valid()==true){
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=tieuchi&task=chinhsuathongtintieuchi',
					data: $('#form_tieuchi').serialize(),
					success:function(data){
						if(data=='true'){
							$('#modal-form').modal('hide');
							$('#btn_search_tktieuchi').click();
							loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
						}
						else{
							loadNoticeBoardError('Thông báo','Xử lý thất bại, vui lòng liên hệ Quản trị viên');
						}
					}
				});
			}else{
				return false;
			}
		});
		$('body').delegate('#btn_delete_tieuchi','click',function(){
			var ntc_id = $(this).data('id')
			if(confirm('Bạn có muốn xóa không?')){
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=tieuchi&task=xoatieuchi',
					data: {id:ntc_id},
					success:function(data){
						if(data=='true'){
							$('#btn_search_tktieuchi').click();
							loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
						}
						else{
							loadNoticeBoardError('Thông báo','Xử lý thất bại, vui lòng liên hệ Quản trị viên');
						}
					}
				});
			}
		});
		$('#btn_xoanhieu_tieuchi').on('click',function(){
			if(confirm('Bạn có muốn xóa không?')){
				var array_id = [];
				$('.arrayid_tieuchi:checked').each(function(){
					array_id.push($(this).val());
				});
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=tieuchi&task=xoanhieutieuchi',
					data: {id:array_id},
					success:function(data){
						var data1 = JSON.parse(data);
						if(data1.length>0){
							var i;
							var count=0;
							for(i=0;i<data1.length;i++){
								if(data1[i]==true){
									count= count+1;
								}
							}
							$('#btn_search_tktieuchi').click();
							loadNoticeBoardSuccess('Thông báo','Xóa thành công '+count+'/'+data1.length);
						}
						else{
							loadNoticeBoardError('Thông báo','Xử lý thất bại, vui lòng liên hệ Quản trị viên');
						}
					}
				});
			}
		});
		$('#btn_xuatexcel_tieuchi').on('click',function(){
			window.location.href = 'index.php?option=com_danhmuc&controller=tieuchi&task=xuatexceltieuchi';
		});
	});
</script>