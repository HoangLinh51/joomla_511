<?php 
	$ds_linhvucbaocao = $this->ds_linhvucbaocao;
	// echo 'aaa';die;
?>
<table class="table table-bordered table-striped">
	<thead>
		<th class="center">Stt</th>
		<th class="center">Tên lĩnh vực</th>
		<th class="center">Mã</th>
		<th class="center">Trạng thái sử dụng</th>
		<th class="center">Chức năng</th>
	</thead>
	<tbody>
		<?php for($i=0;$i<count($ds_linhvucbaocao);$i++){ ?>
		<?php 
			$stt = $i+1;
			if($ds_linhvucbaocao[$i]['trangthai']==0){
				$trangthai = 'Không sử dụng';
			}
			else if($ds_linhvucbaocao[$i]['trangthai']==1){
				$trangthai = 'Được sử dụng';
			}
			else{
				$trangthai = '';
			}
		?>
		<tr>
			<td class="center"><?php echo $stt; ?></td>
			<td class="center"><?php echo $ds_linhvucbaocao[$i]['ten']; ?></td>
			<td class="center"><?php echo $ds_linhvucbaocao[$i]['ma']; ?></td>
			<td class="center"><?php echo $trangthai; ?></td>
			<td class="center">
				<span class="btn btn-mini btn-primary btn_edit_lvbc" data-id="<?php echo $ds_linhvucbaocao[$i]['id']; ?>" href="#modal-form" data-toggle="modal"><i class="icon-edit"></i> Cập nhật</span>
				<span class="btn btn-mini btn-danger btn_delete_lvbc" data-id="<?php echo $ds_linhvucbaocao[$i]['id']; ?>"><i class="icon-trash"></i> Xóa</span>
			</td>
		</tr>
		<?php }?>
	</tbody>
</table>
<script>
	jQuery(document).ready(function($){
		$('.btn_edit_lvbc').on('click',function(){
			var id = $(this).data('id');
			$('#modal-form').html('');
	    	$('#modal-form').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&controller=tochuc&task=sualinhvucbaocao&format=raw&id='+id, function(){
	    	});
		});
		$('.btn_delete_lvbc').on('click',function(){
			if(confirm('Bạn có muốn xóa không?')){
				$.blockUI();
				var id = $(this).data('id');
				$.ajax({
					type: 'post',
					url:  'index.php?option=com_danhmuc&controller=linhvucbaocao&task=xoalinhvucbaocao',
					data: {id:id},
					success:function(data){
						if(data==true){
							$('#btn_timkiem_linhvucbaocao').click();
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
				return false;
			}
		});
	});
</script>