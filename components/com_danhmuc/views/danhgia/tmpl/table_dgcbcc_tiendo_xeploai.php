<?php 
	$ds_dgcbcc_tiendo = $this->ds_dgcbcc_tiendo;
?>
<table id="tbl_dgcbcc_tiendo" class="table table-bordered">
	<thead>
		<th class="center" style="width:5%">STT</th>
		<th class="center" style="width:5%"><input type="checkbox" id="checkall_dgcbcc_tiendo"><label class="lbl"></label></th>
		<th class="center" style="width:45%">Tên tiến độ</th>
		<th class="center" style="width:10%">Hệ số</th>
		<th class="center" style="width:10%">Hệ số tự đánh giá</th>
		<th class="center" style="width:10%">Trạng thái</th>
		<th class="center" style="width:15%">Thao tác</th>
	</thead>
	<tbody>
		<?php for($i=0;$i<count($ds_dgcbcc_tiendo);$i++){ ?>
		<?php 
			$stt = $i+1;
			if($ds_dgcbcc_tiendo[$i]['status']==1){
				$status = '<i class="icon-check"></i>';
			}
			else{
				$status = '';
			}
		?>
		<tr>
			<td class="center"><?php echo $stt; ?></td>
			<td class="center"><input type="checkbox" class="array_id_dgcbcc_tiendo" value="<?php echo $ds_dgcbcc_tiendo[$i]['id']; ?>"><label class="lbl"></label></td>
			<td><?php echo $ds_dgcbcc_tiendo[$i]['name']; ?></td>
			<td class="center"><?php echo $ds_dgcbcc_tiendo[$i]['heso']; ?></td>
			<td class="center"><?php echo $ds_dgcbcc_tiendo[$i]['heso_tu_dg']; ?></td>
			<td class="center"><?php echo $status; ?></td>
			<td class="center">
				<span class="btn btn-mini btn-primary btn_edit_dgcbcc_tiendo" data-id="<?php echo $ds_dgcbcc_tiendo[$i]['id']; ?>" href="#modal-form" data-toggle="modal">Hiệu chỉnh</span>
				<span class="btn btn-mini btn-danger btn_delete_dgcbcc_tiendo" data-id="<?php echo $ds_dgcbcc_tiendo[$i]['id']; ?>">Xóa</span>
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
		var oTable = $('#tbl_dgcbcc_tiendo').dataTable({
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
					"searchable":false,
					"orderable":false
				},
				{
					"targets": 4,
					"searchable":false,
					"orderable":false
				},
				{
					"targets": 5,
					"searchable":false,
					"orderable":false
				},
				{
					"targets": 6,
					"searchable":false,
					"orderable":false
				}
			]
		});
		$('#checkall_dgcbcc_tiendo').on('click',function(){
			if($(this).is(':checked')){
				$('.array_id_dgcbcc_tiendo').prop('checked',true);
			}
			else{
				$('.array_id_dgcbcc_tiendo').prop('checked',false);
			}
		});
		$('.btn_edit_dgcbcc_tiendo').on('click',function(){
			var id = $(this).data('id');
			$('#modal-form').html('');
	    	$('#modal-form').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&controller=danhgia&task=chinhsua_tiendo_xeploai&format=raw&id='+id, function(){
	    	});
		});
		$('.btn_delete_dgcbcc_tiendo').on('click',function(){
			if(confirm('Bạn có muốn xóa không?')){
				$.blockUI();
				var id = $(this).data('id');
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=dgcbcc_tiendo&task=delete_dgcbcc_tiendo',
					data: {id:id},
					success:function(data){
						if(data==true){
        					$('#select_id_dotdanhgia').change();
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