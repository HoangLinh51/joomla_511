<?php 
	$ds_dgcbcc_theonhiemvu = $this->ds_dgcbcc_theonhiemvu;
?>
<table id="tbl_dgcbcc_theonhiemvu" class="table table-bordered">
	<thead>
		<th class="center" style="width:5%">Stt</th>
		<th class="center" style="width:5%"><input type="checkbox" id="checkall_dgcbcc_theonhiemvu"><label class="lbl"></label></th>
		<th class="center" style="width:30%">Tên đánh giá cán bộ công chức theo nhiệm vụ</th>
		<th class="center" style="width:30%">Mã đánh giá cán bộ công chức theo nhiệm vụ</th>
		<th class="center" style="width:15%">Biểu mẫu</th>
		<th class="center" style="width:15%">Chức năng</th>
	</thead>
	<tbody>
		<?php for($i=0;$i<count($ds_dgcbcc_theonhiemvu);$i++){ ?>
			<?php 
				$stt = $i+1;
			?>
			<tr>
				<td class="center"><?php echo $stt; ?></td>
				<td class="center"><input type="checkbox" class="arrayid_dgcbcc_theonhiemvu" value="<?php echo $ds_dgcbcc_theonhiemvu[$i]['id']; ?>"><label class="lbl"></label></td>
				<td><?php echo $ds_dgcbcc_theonhiemvu[$i]['name']; ?></td>
				<td><?php echo $ds_dgcbcc_theonhiemvu[$i]['code']; ?></td>
				<td><?php echo $ds_dgcbcc_theonhiemvu[$i]['template']; ?></td>
				<td class="center">
					<span class="btn btn-mini btn-primary btn_edit_dgcbcc_theonhiemvu" data-id="<?php echo $ds_dgcbcc_theonhiemvu[$i]['id']; ?>" href="#modal-form" data-toggle="modal">Hiệu chỉnh</span>
					<span class="btn btn-mini btn-danger btn_delete_dgcbcc_theonhiemvu" data-id="<?php echo $ds_dgcbcc_theonhiemvu[$i]['id']; ?>">Xóa</span>
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
		var oTable = $('#tbl_dgcbcc_theonhiemvu').dataTable({
			"oLanguage": {
				"sUrl": "<?php echo JUri::base(true);?>/media/cbcc/js/dataTables.vietnam.txt"
			},
			"columnDefs":
			[
				{
					"targets": 0,
					"searchable":false,
					"orderable":false,
				},
				{
					"targets": 1,
					"searchable":false,
					"orderable":false,
				},
				{
					"targets": 2,
					"searchable":true,
					"orderable":true,
				},
				{
					"targets": 3,
					"searchable":true,
					"orderable":true,
				},
				{
					"targets": 4,
					"searchable":false,
					"orderable":false,
				},
				{
					"targets": 5,
					"searchable":false,
					"orderable":false,
				}
			]
		});
		$('#checkall_dgcbcc_theonhiemvu').on('click',function(){
			if($(this).is(':checked')){
				$('.arrayid_dgcbcc_theonhiemvu').prop('checked',true);
			}
			else{
				$('.arrayid_dgcbcc_theonhiemvu').prop('checked',false);
			}
		});
		$('.btn_edit_dgcbcc_theonhiemvu').on('click',function(){
			var id = $(this).data('id');
			$('#modal-form').html('');
	    	$('#modal-form').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&controller=danhgia&task=chinhsua_dgcbcc_theonhiemvu&format=raw&id='+id, function(){
	    	});
		});
		$('.btn_delete_dgcbcc_theonhiemvu').on('click',function(){
			if(confirm('Bạn có muốn xóa không?')){
				$.blockUI();
				var id = $(this).data('id');
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=dgcbcc_theonhiemvu&task=delete_dgcbcc_theonhiemvu',
					data: {id:id},
					success:function(data){
						if(data==true){
        					$('#btn_tk_dgcbcc_theonhiemvu').click();
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