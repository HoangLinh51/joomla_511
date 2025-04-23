<?php 
	$ds_xeploaicongviec = $this->ds_xeploaicongviec;
?>
<table id="tbl_xeploaicongviec" class="table table-bordered">
	<thead>
		<th class="center">STT</th>
		<th class="center"><input type="checkbox" id="checkall_xeploaicongviec"><label class="lbl"></label></th>
		<th class="center">Tên xếp loại công việc</th>
		<th class="center">Dữ liệu</th>
		<th class="center">Trạng thái</th>
		<th class="center">Chức năng</th>
	</thead>
	<tbody>
		<?php for($i=0;$i<count($ds_xeploaicongviec);$i++){ ?>
		<?php 
			$stt = $i+1;
			if($ds_xeploaicongviec[$i]['status']==1){
				$status = '<i class="icon-check"></i>';
			}
			else{
				$status = '';
			}
		?>
		<tr>
			<td class="center"><?php echo $stt; ?></td>
			<td class="center"><input type="checkbox" class="array_id_xeploaicongviec" value="<?php echo $ds_xeploaicongviec[$i]['id']; ?>"><label class="lbl"></label></td>
			<td><?php echo $ds_xeploaicongviec[$i]['name']; ?></td>
			<td class="center"><?php echo $ds_xeploaicongviec[$i]['data']; ?></td>
			<td class="center"><?php echo $status; ?></td>
			<td class="center">
				<span class="btn btn-mini btn-primary btn_edit_xeploaicongviec" data-id="<?php echo $ds_xeploaicongviec[$i]['id']; ?>" href="#modal-form" data-toggle="modal">Cập nhật</span>
				<span class="btn btn-mini btn-danger btn_delete_xeploaicongviec" data-id="<?php echo $ds_xeploaicongviec[$i]['id']; ?>">Xóa</span>
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
		var oTable = $('#tbl_xeploaicongviec').dataTable({
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
		$('.btn_edit_xeploaicongviec').on('click',function(){
			var id = $(this).data('id');
			$('#modal-form').html('');
	    	$('#modal-form').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&controller=danhgia&task=chinhsua_xeploaicongviec&format=raw&id='+id, function(){
	    	});
		});
		$('.btn_delete_xeploaicongviec').on('click',function(){
			if(confirm('Bạn có muốn xóa không?')){
				$.blockUI();
				var id = $(this).data('id');
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=xeploaicongviec&task=delete_xeploaicongviec',
					data: {id:id},
					success:function(data){
						if(data==true){
        					$('#btn_tk_xeploaicongviec').click();
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
		$('#checkall_xeploaicongviec').on('click',function(){
			if($(this).is(':checked')){
				$('.array_id_xeploaicongviec').prop('checked',true);
			}
			else{
				$('.array_id_xeploaicongviec').prop('checked',false);
			}
		});
	});
</script>