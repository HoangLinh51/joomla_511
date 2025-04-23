<?php 
	$ds_dgcbcc_mucdothamgia = $this->ds_dgcbcc_mucdothamgia;
?>
<table id="tbl_dgcbcc_mucdothamgia" class="table table-bordered">
	<thead>
		<th class="center">STT</th>
		<th class="center"><input type="checkbox" id="checkall_dgcbcc_mucdothamgia"><label class="lbl"></label></th>
		<th class="center">Tên mức độ tham gia</th>
		<th class="center">Trạng thái</th>
		<th class="center">Thao tác</th>
	</thead>
	<tbody>
		<?php for($i=0;$i<count($ds_dgcbcc_mucdothamgia);$i++){ ?>
		<?php
			$stt = $i+1;
			if($ds_dgcbcc_mucdothamgia[$i]['status']==1){
				$status = '<i class="icon-check"></i>';
			}
			else{
				$status = '';
			}
		?>
		<tr>
			<td class="center"><?php echo $stt; ?></td>
			<td class="center"><input type="checkbox" class="array_id_dgcbcc_mucdothamgia" value="<?php echo $ds_dgcbcc_mucdothamgia[$i]['id']; ?>"><label class="lbl"></label></td>
			<td><?php echo $ds_dgcbcc_mucdothamgia[$i]['name']; ?></td>
			<td class="center"><?php echo $status; ?></td>
			<td class="center">
				<span class="btn btn-mini btn-primary btn_edit_dgcbcc_mucdothamgia" data-id="<?php echo $ds_dgcbcc_mucdothamgia[$i]['id']; ?>" href="#modal-form" data-toggle="modal">Hiệu chỉnh</span>
				<span class="btn btn-mini btn-danger btn_delete_dgcbcc_mucdothamgia" data-id="<?php echo $ds_dgcbcc_mucdothamgia[$i]['id']; ?>">Xóa</span>
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
		var oTable = $('#tbl_dgcbcc_mucdothamgia').dataTable({
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
		$('#checkall_dgcbcc_mucdothamgia').on('click',function(){
			if($(this).is(":checked")){
				$('.array_id_dgcbcc_mucdothamgia').prop('checked',true);
			}
			else{
				$('.array_id_dgcbcc_mucdothamgia').prop('checked',false);
			}
		});
		$('.btn_edit_dgcbcc_mucdothamgia').on('click',function(){
			var id = $(this).data('id');
			$('#modal-form').html('');
	    	$('#modal-form').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&controller=danhgia&task=chinhsua_mucdothamgia&format=raw&id='+id, function(){
	    	});
		});
		$('.btn_delete_dgcbcc_mucdothamgia').on('click',function(){
			if(confirm('Bạn có muốn xóa không?')){
				$.blockUI();
				var id = $(this).data('id');
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=dgcbcc_mucdothamgia&task=delete_dgcbcc_mucdothamgia',
					data: {id:id},
					success:function(data){
						if(data==true){
							$('#btn_tk_dgcbcc_mucdothamgia').click();
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