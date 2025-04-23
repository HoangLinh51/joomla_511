<?php 
	$jinput = JFactory::getApplication()->input;
	$id = $jinput->getInt('id',0);
	$ds_cb_bac_heso = $this->ds_cb_bac_heso;
	// var_dump($ds_cb_bac_heso);die;
?>
<h4 class="header">
	Các ngạch thuộc nhóm ngạch
	<div class="pull-right">
		<span class="btn btn-mini btn-success" id="btn_themmoi_thongtin_ngach" href="#modal-form" data-toggle="modal"><i class="icon-plus"></i></span>
		<span class="btn btn-mini btn-danger" id="btn_delete_thongtin_ngach"><i class="icon-trash"></i></span>
	</div>
</h4>
<!-- <form id="form_thongtin_ngach" class="form-horizontal">
	<?php echo JHtml::_( 'form.token' ); ?> -->
	<table id="tbl_thongtin_ngach" class="table table-bordered">
		<thead>
			<th class="center" style="vertical-align:middle;width:5%">#</th>
			<th style="vertical-align:middle;width:25%">Ngạch</th>
			<th style="vertical-align:middle;width:15%">Mã ngạch</th>
			<th style="vertical-align:middle;width:25%">Thuộc ngành</th>
			<th style="vertical-align:middle;width:25%">Ngạch nâng lên</th>
			<th style="vertical-align:middle;width:5%">VK</th>
		</thead>
		<tbody id="content_thongtin_ngach">
			<?php if(count($ds_cb_bac_heso)>0){ ?>
			<?php for($i=0;$i<count($ds_cb_bac_heso);$i++){ ?>
			<?php $stt = $i+1; ?>
			<tr id="row_<?php echo $stt; ?>">
				<td class="center" style="vertical-align:middle">
					<input type="checkbox" class="checkbox_row_thongtin_ngach" value="<?php echo $stt; ?>" data-id="<?php echo $ds_cb_bac_heso[$i]['id']; ?>"><label class="lbl"></label>
				</td>
				<td style="vertical-align:middle">
					<span class="btn-link btn_edit_thongtin_ngach" data-id="<?php echo $ds_cb_bac_heso[$i]['id']; ?>" href="#modal-form" data-toggle="modal"><?php echo $ds_cb_bac_heso[$i]['name']; ?></span>
					<input type="hidden" name="id[]" value="<?php echo $ds_cb_bac_heso[$i]['id']; ?>">
				</td>
				<td style="vertical-align:middle">
					<?php echo $ds_cb_bac_heso[$i]['mangach']; ?>
				</td>
				<td style="vertical-align:middle">
					<?php echo $ds_cb_bac_heso[$i]['nganh_name']; ?>
				</td>
				<td style="vertical-align:middle">
					<?php echo $ds_cb_bac_heso[$i]['mangachtiep_name']; ?>
				</td>
				<td class="center" style="vertical-align:middle">
					<?php 
						if($ds_cb_bac_heso[$i]['is_vuotkhung']==1){
							$is_vuotkhung = '<i class="icon-check"></i>';
						}
						else{
							$is_vuotkhung = '';
						}
						echo $is_vuotkhung;
					?>
				</td>
			</tr>
			<?php } ?>
			<?php } ?>
		</tbody>
	</table>
<!-- </form> -->
<script>
	jQuery(document).ready(function($){
		$('#btn_themmoi_thongtin_ngach').on('click',function(){
			var id = '<?php echo $id; ?>';
			$('#modal-form').html('');
	    	$('#modal-form').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&view=luong&task=themmoi_thongtin_ngach&format=raw&id='+id, function(){
	    	});
		});
		$('.btn_edit_thongtin_ngach').on('click',function(){
			var id = '<?php echo $id; ?>';
			var id_ngach = $(this).data('id');
			$('#modal-form').html('');
	    	$('#modal-form').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&view=luong&task=chinhsua_thongtin_ngach&format=raw&id='+id+'&id_ngach='+id_ngach, function(){
	    	});
		});
		var loadTableNgach = function(id){
			$.blockUI();
			$('#table_thongtin_ngach').load('index.php?option=com_danhmuc&controller=luong&task=table_thongtin_ngach&format=raw&id='+id,function(){
				$.unblockUI();
			});
		}
		$('#btn_delete_thongtin_ngach').on('click',function(){
			var array_id = [];
			$('.checkbox_row_thongtin_ngach:checked').each(function(){
				array_id.push($(this).data('id'));
			});
			if(array_id.length>0){
				if(confirm('Bạn có muốn xóa không?')){
					$.blockUI();
					var id = '<?php echo $id; ?>';
					$.ajax({
						type: 'post',
						url: 'index.php?option=com_danhmuc&controller=ngachbac&task=delete_cb_bac_heso',
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
									loadTableNgach(id);
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
			}
			else{
				loadNoticeBoardError('Thông báo','Vui lòng chọn ít nhất một ngạch để xóa');
				return false;
			}
		});
	});
</script>