<?php 
	$ds_dieukienlamviec = $this->ds_dieukienlamviec;
?>
<table id="tbl_dieukienlamviec" class="table table-bordered">
	<thead>
		<th class="center">STT</th>
		<th class="center"><input type="checkbox" id="checkall_dieukienlamviec"><label class="lbl"></label></th>
		<th class="center">Tên điều kiện làm việc</th>
		<th class="center">Trạng thái</th>
		<th class="center">Chức năng</th>
	</thead>
	<tbody>
		<?php for($i=0;$i<count($ds_dieukienlamviec);$i++){ ?>
		<?php 
			$stt = $i+1;
			if($ds_dieukienlamviec[$i]['status']==1){
				$status = '<i class="icon-check"></i>';
			}
			else{
				$status = '';
			}
		?>
		<tr>
			<td class="center"><?php echo $stt; ?></td>
			<td class="center"><input type="checkbox" class="array_id_dieukienlamviec" value="<?php echo $ds_dieukienlamviec[$i]['id']; ?>"><label class="lbl"></label></td>
			<td><?php echo $ds_dieukienlamviec[$i]['name']; ?></td>
			<td class="center"><?php echo $status; ?></td>
			<td class="center">
				<span class="btn btn-mini btn-primary btn_edit_dieukienlamviec" data-id="<?php echo $ds_dieukienlamviec[$i]['id']; ?>" href="#modal-form" data-toggle="modal">Cập nhật</span>
				<span class="btn btn-mini btn-danger btn_delete_dieukienlamviec" data-id="<?php echo $ds_dieukienlamviec[$i]['id']; ?>">Xóa</span>
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
		var oTable = $('#tbl_dieukienlamviec').dataTable({
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
				},
				{
					"targets": 4,
					"orderable":false,
					"searchable":false
				}
			]
		});
		$('.btn_edit_dieukienlamviec').on('click',function(){
			var id = $(this).data('id');
			$('#modal-form').html('');
	    	$('#modal-form').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&controller=danhgia&task=chinhsua_dieukienlamviec&format=raw&id='+id, function(){
	    	});
		});
		$('.btn_delete_dieukienlamviec').on('click',function(){
			if(confirm('Bạn có muốn xóa không?')){
				$.blockUI();
				var id = $(this).data('id');
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=dieukienlamviec&task=delete_dieukienlamviec',
					data: {id:id},
					success:function(data){
						if(data==true){
        					$('#btn_tk_dieukienlamviec').click();
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
		$('#checkall_dieukienlamviec').on('click',function(){
			if($(this).is(':checked')){
				$('.array_id_dieukienlamviec').prop('checked',true);
			}
			else{
				$('.array_id_dieukienlamviec').prop('checked',false);
			}
		});
	});
</script>