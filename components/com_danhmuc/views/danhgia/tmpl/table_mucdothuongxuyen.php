<?php 
	$ds_mucdothuongxuyen = $this->ds_mucdothuongxuyen;
?>
<table id="tbl_mucdothuongxuyen" class="table table-bordered">
	<thead>
		<th class="center">STT</th>
		<th class="center"><input type="checkbox" id="checkall_mucdothuongxuyen"><label class="lbl"></label></th>
		<th class="center">Tên mức độ thường xuyên</th>
		<th class="center">Chức năng</th>
	</thead>
	<tbody>
		<?php for($i=0;$i<count($ds_mucdothuongxuyen);$i++){ ?>
		<?php 
			$stt = $i+1;
			if($ds_mucdothuongxuyen[$i]['status']==1){
				$status = '<i class="icon-check"></i>';
			}
			else{
				$status = '';
			}
		?>
		<tr>
			<td class="center"><?php echo $stt; ?></td>
			<td class="center"><input type="checkbox" class="array_id_mucdothuongxuyen" value="<?php echo $ds_mucdothuongxuyen[$i]['id']; ?>"><label class="lbl"></label></td>
			<td><?php echo $ds_mucdothuongxuyen[$i]['name']; ?></td>
			<td class="center">
				<span class="btn btn-mini btn-primary btn_edit_mucdothuongxuyen" data-id="<?php echo $ds_mucdothuongxuyen[$i]['id']; ?>" href="#modal-form" data-toggle="modal">Cập nhật</span>
				<span class="btn btn-mini btn-danger btn_delete_mucdothuongxuyen" data-id="<?php echo $ds_mucdothuongxuyen[$i]['id']; ?>">Xóa</span>
			</td>
		</tr>
		<?php }?>
	</tbody>
</table>
<style>
     .dataTable > thead > tr > th[class*="sort"]::after{display: none}
</style>
<script>
	jQuery(document).ready(function($){
		var oTable = $('#tbl_mucdothuongxuyen').dataTable({
			"oLanguage": {
				"sUrl": "<?php echo JUri::base(true);?>/media/cbcc/js/dataTables.vietnam.txt"
			},
			"columnDefs":
			[
				{
					"targets": 0,
					"orderable":false,
					"searchable":false
				},
				{
					"targets": 1,
					"orderable":false,
					"searchable":false
				},
				{
					"targets": 2,
					"orderable":true,
					"searchable":true
				},
				{
					"targets": 3,
					"orderable":false,
					"searchable":false
				}
			]
		});
		$('.btn_edit_mucdothuongxuyen').on('click',function(){
			var id = $(this).data('id');
			$('#modal-form').html('');
	    	$('#modal-form').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&controller=danhgia&task=chinhsua_mucdothuongxuyen&format=raw&id='+id, function(){
	    	});
		});
		$('.btn_delete_mucdothuongxuyen').on('click',function(){
			if(confirm('Bạn có muốn xóa không?')){
				$.blockUI();
				var id = $(this).data('id');
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=mucdothuongxuyen&task=delete_mucdothuongxuyen',
					data: {id:id},
					success:function(data){
						if(data==true){
        					$('#btn_tk_mucdothuongxuyen').click();
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
		});
		$('#checkall_mucdothuongxuyen').on('click',function(){
			if($(this).is(':checked')){
				$('.array_id_mucdothuongxuyen').prop('checked',true);
			}
			else{
				$('.array_id_mucdothuongxuyen').prop('checked',false);
			}
		});
	});
</script>