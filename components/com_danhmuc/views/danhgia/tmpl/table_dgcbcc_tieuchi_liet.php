<?php 
	$ds_dgcbcc_tieuchi_phanloai = $this->ds_dgcbcc_tieuchi_phanloai;
?>
<table id="tbl_dgcbcc_tieuchi_liet" class="table table-bordered">
	<thead>
		<th class="center" style="width:5%">STT</th>
		<th class="center" style="width:5%"><input type="checkbox" id="checkall_dgcbcc_tieuchi_liet"><label class="lbl"></label></th>
		<th class="center" style="width:65%">Tên tiêu chí</th>
		<th class="center" style="width:10%">Phát hành</th>
		<th class="center" style="width:15%">Thao tác</th>
	</thead>
	<tbody>
		<?php for($i=0;$i<count($ds_dgcbcc_tieuchi_phanloai);$i++){ ?>
		<?php 
			$stt = $i+1;
			if($ds_dgcbcc_tieuchi_phanloai[$i]['published']==1){
				$published = '<i class="icon-check"></i>';
			}
			else{
				$published = '';
			}
		?>
		<tr>
			<td class="center"><?php echo $stt; ?></td>
			<td class="center"><input type="checkbox" class="array_id_dgcbcc_tieuchi_liet" value="<?php echo $ds_dgcbcc_tieuchi_phanloai[$i]['id']; ?>"><label class="lbl"></label></td>
			<td><?php echo $ds_dgcbcc_tieuchi_phanloai[$i]['name']; ?></td>
			<td class="center"><?php echo $published; ?></td>
			<td class="center">
				<span class="btn btn-mini btn-primary btn_edit_dgcbcc_tieuchi_liet" href="#modal-form" data-toggle="modal" data-id="<?php echo $ds_dgcbcc_tieuchi_phanloai[$i]['id']; ?>">Hiệu chỉnh</span>
				<span class="btn btn-mini btn-danger btn_delete_dgcbcc_tieuchi_liet" data-id="<?php echo $ds_dgcbcc_tieuchi_phanloai[$i]['id']; ?>">Xóa</span>
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
		var oTable = $('#tbl_dgcbcc_tieuchi_liet').dataTable({
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
				}
			]
		});
		$('#checkall_dgcbcc_tieuchi_liet').on('click',function(){
			if($(this).is(':checked')){
				$('.array_id_dgcbcc_tieuchi_liet').prop('checked',true);
			}
			else{
				$('.array_id_dgcbcc_tieuchi_liet').prop('checked',false);
			}
		});
		$('.btn_edit_dgcbcc_tieuchi_liet').on('click',function(){
			var id = $(this).data('id');
			$('#modal-form').html('');
	    	$('#modal-form').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&controller=danhgia&task=chinhsua_dgcbcc_tieuchi_liet&format=raw&id='+id, function(){
	    	});
		});
		$('.btn_delete_dgcbcc_tieuchi_liet').on('click',function(){
			if(confirm('Bạn có muốn xóa không?')){
				$.blockUI();
				var id = $(this).data('id');
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=dgcbcc_tieuchiliet&task=delete_dgcbcc_tieuchi_liet',
					data: {id:id},
					success:function(data){
						if(data==true){
							$('#btn_tk_dgcbcc_tieuchi_phanloai').click();
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