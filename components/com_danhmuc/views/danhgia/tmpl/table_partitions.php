<?php 
	$ds_partitions = $this->ds_partitions;
?>
<table id="tbl_partitions" class="table table-bordered">
	<thead>
		<th class="center" style="width:5%">STT</th>
		<th class="center" style="width:5%"><input type="checkbox" id="checkall_partitions"><label class="lbl"></label></th>
		<th class="center" style="width:35%">Tên bảng</th>
		<th class="center" style="width:15%">Khóa phân vùng</th>
		<th class="center" style="width:10%">Trạng thái</th>
		<th class="center" style="width:15%">Khóa thuộc bảng</th>
		<th class="center" style="width:15%">Thao tác</th>
	</thead>
	<tbody>
		<?php for($i=0;$i<count($ds_partitions);$i++){ ?>
		<?php 
			$stt = $i+1;
			if($ds_partitions[$i]['status']==1){
				$status = '<i class="icon-check"></i>';
			}
			else{
				$status = '';
			}
		?>
		<tr>
			<td class="center"><?php echo $stt; ?></td>
			<td class="center"><input type="checkbox" class="array_id_partitions" value="<?php echo $ds_partitions[$i]['id']; ?>"><label class="lbl"></label></td>
			<td><?php echo $ds_partitions[$i]['table']; ?></td>
			<td><?php echo $ds_partitions[$i]['key_partition']; ?></td>
			<td class="center"><?php echo $status; ?></td>
			<td><?php echo $ds_partitions[$i]['key_table']; ?></td>
			<td class="center">
				<span class="btn btn-mini btn-primary btn_edit_partition" data-id="<?php echo $ds_partitions[$i]['id']; ?>" href="#modal-form" data-toggle="modal">Hiệu chỉnh</span>
				<span class="btn btn-mini btn-danger btn_delete_partition" data-id="<?php echo $ds_partitions[$i]['id']; ?>">Xóa</span>
			</td>
		</tr>
		<?php } ?>
	</tbody>
</table>
<style>
     .dataTable > thead > tr > th[class*="sort"]::after{display: none}
</style>
<script>
	jQuery(document).ready(function($){
		var oTable = $('#tbl_partitions').dataTable({
			"oLanguage": {
				"sUrl": "<?php echo JUri::base(true);?>/media/cbcc/js/dataTables.vietnam.txt"
			},
			"columnDefs":
			[
				{
					"targets": 0,
					"searchable":false,
					"orderable":false
				},
				{
					"targets": 1,
					"searchable":false,
					"orderable":false
				},
				{
					"targets": 2,
					"searchable":true,
					"orderable":true
				},
				{
					"targets": 3,
					"searchable":true,
					"orderable":true
				},
				{
					"targets": 4,
					"searchable":false,
					"orderable":false
				},
				{
					"targets": 5,
					"searchable":true,
					"orderable":true
				},
				{
					"targets": 6,
					"searchable":false,
					"orderable":false
				}
			]
		});
		$('#checkall_partitions').on('click',function(){
			if($(this).is(':checked')){
				$('.array_id_partitions').prop('checked',true);
			}
			else{
				$('.array_id_partitions').prop('checked',false);
			}
		});
		$('.btn_edit_partition').on('click',function(){
			var id = $(this).data('id');
			$('#modal-form').html('');
	    	$('#modal-form').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&controller=danhgia&task=chinhsua_partition&format=raw&id='+id, function(){
	    	});
		});
		$('.btn_delete_partition').on('click',function(){
			if(confirm('Bạn có muốn xóa không?')){
				$.blockUI();
				var id = $(this).data('id');
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=partition&task=delete_partition',
					data: {id:id},
					success:function(data){
						if(data==true){
        					$('#btn_tk_partition').click();
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