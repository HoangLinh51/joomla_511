<?php 
	$ds_dgcbcc_xeploaichatluong = $this->ds_dgcbcc_xeploaichatluong;
?>
<table id="tbl_dgcbcc_xeploaichatluong" class="table table-bordered">
	<thead>
		<th class="center">STT</th>
		<th class="center"><input type="checkbox" id="checkall_dgcbcc_xeploaichatluong"><label class="lbl"></label></th>
		<th class="center">Tên xếp loại chất lượng</th>
		<th class="center">Hệ số</th>
		<th class="center">Hệ số từ đánh giá</th>
		<th class="center">Đợt đánh giá</th>
		<th class="center">Trạng thái</th>
		<th class="center">Chức năng</th>
	</thead>
	<tbody>
		<?php for($i=0;$i<count($ds_dgcbcc_xeploaichatluong);$i++){ ?>
		<?php 
			$stt = $i+1;
			if($ds_dgcbcc_xeploaichatluong[$i]['status']==1){
				$status = '<i class="icon-check"></i>';
			}
			else{
				$status = '';
			}
		?>
		<tr>
			<td class="center"><?php echo $stt; ?></td>
			<td class="center"><input type="checkbox" class="array_id_dgcbcc_xeploaichatluong" value="<?php echo $ds_dgcbcc_xeploaichatluong[$i]['id']; ?>"><label class="lbl"></label></td>
			<td><?php echo $ds_dgcbcc_xeploaichatluong[$i]['name']; ?></td>
			<td class="center"><?php echo $ds_dgcbcc_xeploaichatluong[$i]['heso']; ?></td>
			<td class="center"><?php echo $ds_dgcbcc_xeploaichatluong[$i]['heso_tu_dg']; ?></td>
			<td class="center"><?php echo $ds_dgcbcc_xeploaichatluong[$i]['name_dotdanhgia']; ?></td>
			<td class="center"><?php echo $status; ?></td>
			<td class="center">
				<span class="btn btn-mini btn-primary btn_edit_dgcbcc_xeploaichatluong" data-id="<?php echo $ds_dgcbcc_xeploaichatluong[$i]['id']; ?>" href="#modal-form" data-toggle="modal">Cập nhật</span>
				<span class="btn btn-mini btn-danger btn_delete_dgcbcc_xeploaichatluong" data-id="<?php echo $ds_dgcbcc_xeploaichatluong[$i]['id']; ?>">Xóa</span>
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
		var oTable = $('#tbl_dgcbcc_xeploaichatluong').dataTable({
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
				},
				{
					"targets": 6,
					"orderable":false,
					"searchable":false
				},
				{
					"targets": 7,
					"orderable":false,
					"searchable":false
				}
			]
		});
		$('.btn_edit_dgcbcc_xeploaichatluong').on('click',function(){
			var id = $(this).data('id');
			$('#modal-form').html('');
	    	$('#modal-form').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&controller=danhgia&task=chinhsua_dgcbcc_xeploaichatluong&format=raw&id='+id, function(){
	    	});
		});
		$('.btn_delete_dgcbcc_xeploaichatluong').on('click',function(){
			if(confirm('Bạn có muốn xóa không?')){
				$.blockUI();
				var id = $(this).data('id');
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=dgcbcc_xeploaichatluong&task=delete_dgcbcc_xeploaichatluong',
					data: {id:id},
					success:function(data){
						if(data==true){
        					$('#btn_tk_dgcbcc_xeploaichatluong').click();
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
		$('#checkall_dgcbcc_xeploaichatluong').on('click',function(){
			if($(this).is(':checked')){
				$('.array_id_dgcbcc_xeploaichatluong').prop('checked',true);
			}
			else{
				$('.array_id_dgcbcc_xeploaichatluong').prop('checked',false);
			}
		});
	});
</script>