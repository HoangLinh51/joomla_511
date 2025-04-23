<?php 
	$ds_dgcbcc_lydocongviecfail = $this->ds_dgcbcc_lydocongviecfail;
?>
<table id="tbl_dgcbcc_lydocongviecfail" class="table table-bordered">
	<thead>
		<th class="center">STT</th>
		<th class="center"><input type="checkbox" id="checkall_dgcbcc_lydocongviecfail"><label class="lbl"></label></th>
		<th class="center">Tên lý do chưa hoàn thành công việc</th>
		<th class="center">Hệ số</th>
		<th class="center">Trạng thái</th>
		<th class="center">Chức năng</th>
	</thead>
	<tbody>
		<?php for($i=0;$i<count($ds_dgcbcc_lydocongviecfail);$i++){ ?>
		<?php 
			$stt = $i+1;
			if($ds_dgcbcc_lydocongviecfail[$i]['status']==1){
				$status = '<i class="icon-check"></i>';
			}
			else{
				$status = '';
			}
		?>
		<tr>
			<td class="center"><?php echo $stt; ?></td>
			<td class="center"><input type="checkbox" class="array_id_dgcbcc_lydocongviecfail" value="<?php echo $ds_dgcbcc_lydocongviecfail[$i]['id']; ?>"><label class="lbl"></label></td>
			<td><?php echo $ds_dgcbcc_lydocongviecfail[$i]['name']; ?></td>
			<td class="center"><?php echo $ds_dgcbcc_lydocongviecfail[$i]['heso']; ?></td>
			<td class="center"><?php echo $status; ?></td>
			<td class="center">
				<span class="btn btn-mini btn-primary btn_edit_dgcbcc_lydocongviecfail" data-id="<?php echo $ds_dgcbcc_lydocongviecfail[$i]['id']; ?>" href="#modal-form" data-toggle="modal">Cập nhật</span>
				<span class="btn btn-mini btn-danger btn_delete_dgcbcc_lydocongviecfail" data-id="<?php echo $ds_dgcbcc_lydocongviecfail[$i]['id']; ?>">Xóa</span>
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
		var oTable = $('#tbl_dgcbcc_lydocongviecfail').dataTable({
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
				},
				{
					"targets": 5,
					"orderable":false,
					"searchable":false
				}
			]
		});
		$('.btn_edit_dgcbcc_lydocongviecfail').on('click',function(){
			var id = $(this).data('id');
			$('#modal-form').html('');
	    	$('#modal-form').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&controller=danhgia&task=chinhsua_dgcbcc_lydocongviecfail&format=raw&id='+id, function(){
	    	});
		});
		$('.btn_delete_dgcbcc_lydocongviecfail').on('click',function(){
			if(confirm('Bạn có muốn xóa không?')){
				$.blockUI();
				var id = $(this).data('id');
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=dgcbcc_lydocongviecfail&task=delete_dgcbcc_lydocongviecfail',
					data: {id:id},
					success:function(data){
						if(data==true){
        					$('#btn_tk_dgcbcc_lydocongviecfail').click();
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
		$('#checkall_dgcbcc_lydocongviecfail').on('click',function(){
			if($(this).is(':checked')){
				$('.array_id_dgcbcc_lydocongviecfail').prop('checked',true);
			}
			else{
				$('.array_id_dgcbcc_lydocongviecfail').prop('checked',false);
			}
		});
	});
</script>