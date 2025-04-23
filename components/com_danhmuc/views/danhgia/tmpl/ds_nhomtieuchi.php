<?php 
	$jinput = JFactory::getApplication()->input;
	$format = $jinput->getString('format','');
?>
<div id="ds_nhomtieuchi">
	<h2 class="header" style="padding-bottom:1%">Danh sách nhóm tiêu chí
		<div class="pull-right">
			<span class="btn btn-small btn-primary" id="btn_themmoi_nhomtieuchi">Thêm mới</span>
			<span class="btn btn-small btn-danger" id="btn_xoanhieu_nhomtieuchi">Xóa</span>
			<span class="btn btn-small btn-success" id="btn_xuatexcel_nhomtieuchi">Xuất excel</span>
		</div>
	</h2>
	<div id="accordion_tknhomtieuchi" class="accordion">
		<div class="accordion-group">
			<div class="accordion-heading">
				<a href="#collapseOne" data-parent="#accordion_tknhomtieuchi" data-toggle="collapse" class="accordion-toggle collapsed">Tìm kiếm</a>
			</div>
			<div class="accordion-body collapse" id="collapseOne">
				<div class="acordion-inner">
					<form class="form-horizontal">
						<div class="control-group" style="padding-top:3%">
							<label class="control-label span4">Tên nhóm tiêu chí</label>
							<div class="controls span7">
								<input type="text" name="tk_tennhomtieuchi" id="tk_tennhomtieuchi"/>
								<span class="btn btn-small btn-info pull-right" id="btn_search_tknhomtieuchi">Tìm kiếm</span>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div id="table_nhomtieuchi"></div>
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
		$('#btn_search_tknhomtieuchi').on('click',function(){
			$.blockUI();
			$('#table_nhomtieuchi').load('index.php?option=com_danhmuc&view=danhgia&task=table_nhomtieuchi&format=raw&ten='+$('#tk_tennhomtieuchi').val(),function(){
				$.unblockUI();
			});
		});
		$('#btn_search_tknhomtieuchi').click();
		$('#btn_themmoi_nhomtieuchi').on('click',function(){
			$('#modal-title').html('Thêm mới nhóm tiêu chí');
	        $('#modal-content').html('');
	        $('#modal-content').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&view=danhgia&task=themmoinhomtieuchi&format=raw', function(){
	            $('.modal-footer').html('<button class="btn btn-small" data-dismiss="modal">Hủy bỏ</button><button index="-1" class="btn btn-small btn-primary" id="btn_nhomtieuchi_luu">Áp dụng</button>');
	            $('#modal-form').modal('show');

	        });
		});
		$('body').delegate('#btn_nhomtieuchi_luu','click',function(){
			if($('#form_nhomtieuchi').valid()==true){
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=nhomtieuchi&task=themthongtinnhomtieuchi',
					data: $('#form_nhomtieuchi').serialize(),
					success:function(data){
						if(data=='true'){
							$('#modal-form').modal('hide');
							$('#btn_search_tknhomtieuchi').click();
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
		$('body').delegate('#btn_edit_nhomtieuchi','click',function(){
			var ntc_id = $(this).data('id');
			$('#modal-title').html('Chỉnh sửa nhóm tiêu chí');
	        $('#modal-content').html('');
	        $('#modal-content').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&view=danhgia&task=chinhsuanhomtieuchi&format=raw&ntc_id='+ntc_id, function(){
	            $('.modal-footer').html('<button class="btn btn-small" data-dismiss="modal">Hủy bỏ</button><button index="-1" class="btn btn-small btn-primary" id="btn_nhomtieuchi_update">Áp dụng</button>');
	            $('#modal-form').modal('show');

	        });
		});
		$('body').delegate('#btn_nhomtieuchi_update','click',function(){
			if($('#form_nhomtieuchi').valid()==true){
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=nhomtieuchi&task=chinhsuathongtinnhomtieuchi',
					data: $('#form_nhomtieuchi').serialize(),
					success:function(data){
						if(data=='true'){
							$('#modal-form').modal('hide');
							$('#btn_search_tknhomtieuchi').click();
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
		$('body').delegate('#btn_delete_nhomtieuchi','click',function(){
			var ntc_id = $(this).data('id')
			if(confirm('Bạn có muốn xóa không?')){
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=nhomtieuchi&task=xoanhomtieuchi',
					data: {id:ntc_id},
					success:function(data){
						if(data=='true'){
							$('#btn_search_tknhomtieuchi').click();
							loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
						}
						else{
							loadNoticeBoardError('Thông báo','Xử lý thất bại, vui lòng liên hệ Quản trị viên');
						}
					}
				});
			}
		});
		$('#btn_xoanhieu_nhomtieuchi').on('click',function(){
			if(confirm('Bạn có muốn xóa không?')){
				var array_id = [];
				$('.arrayid_nhomtieuchi:checked').each(function(){
					array_id.push($(this).val());
				});
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=nhomtieuchi&task=xoanhieunhomtieuchi',
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
							$('#btn_search_tknhomtieuchi').click();
							loadNoticeBoardSuccess('Thông báo','Xóa thành công '+count+'/'+data1.length);
						}
						else{
							loadNoticeBoardError('Thông báo','Xử lý thất bại, vui lòng liên hệ Quản trị viên');
						}
					}
				});
			}
		});
		$('#btn_xuatexcel_nhomtieuchi').on('click',function(){
			window.location.href = 'index.php?option=com_danhmuc&controller=nhomtieuchi&task=xuatexcelnhomtieuchi';
		});
	});
</script>