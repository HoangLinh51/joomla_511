<?php 
	$ds_dgcbcc_xeploai = $this->ds_dgcbcc_xeploai;
?>
<table id="tbl_dgcbcc_xeploai" class="table table-bordered">
	<thead>
		<th class="center" style="width:5%">STT</th>
		<th class="center" style="width:5%"><input type="checkbox" id="checkall_dgcbcc_xeploai"><label class="lbl"></label></th>
		<th class="center" style="width:35%">Tên xếp loại</th>
		<th class="center" style="width:10%">Mã xếp loại</th>
		<th class="center" style="width:10%">Điểm nhỏ nhất</th>
		<th class="center" style="width:10%">Điểm lớn nhất</th>
		<th class="center" style="width:10%">Sử dụng</th>
		<th class="center" style="width:15%">Thao tác</th>
	</thead>
	<tbody>
		<?php for($i=0;$i<count($ds_dgcbcc_xeploai);$i++){ ?>
		<?php 
			$stt = $i+1;
			if($ds_dgcbcc_xeploai[$i]['published']==1){
				$published = '<i class="icon-check"></i>';
			}
			else{
				$published = '';
			}
		?>
		<tr>
			<td class="center"><?php echo $stt; ?></td>
			<td class="center"><input type="checkbox" class="array_id_dgcbcc_xeploai" value="<?php echo $ds_dgcbcc_xeploai[$i]['id']; ?>"><label class="lbl"></label></td>
			<td><?php echo $ds_dgcbcc_xeploai[$i]['name']; ?></td>
			<td class="center"><?php echo $ds_dgcbcc_xeploai[$i]['code']; ?></td>
			<td class="center"><?php echo $ds_dgcbcc_xeploai[$i]['diem_min']; ?></td>
			<td class="center"><?php echo $ds_dgcbcc_xeploai[$i]['diem_max']; ?></td>
			<td class="center"><?php echo $published; ?></td>
			<td class="center">
				<span class="btn btn-mini btn-primary btn_edit_dgcbcc_xeploai" data-id="<?php echo $ds_dgcbcc_xeploai[$i]['id']; ?>" href="#modal-form" data-toggle="modal">Hiệu chỉnh</span>
				<span class="btn btn-mini btn-danger btn_delete_dgcbcc_xeploai" data-id="<?php echo $ds_dgcbcc_xeploai[$i]['id']; ?>">Xóa</span>
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
		var oTable = $('#tbl_dgcbcc_xeploai').dataTable({
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
				},
				{
					"targets": 7,
					"searchable":false,
					"orderable":false
				}
			]
		});
		$('#checkall_dgcbcc_xeploai').on('click',function(){
			if($(this).is(':checked')){
				$('.array_id_dgcbcc_xeploai').prop('checked',true);
			}
			else{
				$('.array_id_dgcbcc_xeploai').prop('checked',false);
			}
		});
		$('.btn_edit_dgcbcc_xeploai').on('click',function(){
			var id = $(this).data('id');
			$('#modal-form').html('');
	    	$('#modal-form').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&controller=danhgia&task=chinhsua_xeploai&format=raw&id='+id, function(){
	    	});
		});
		$('.btn_delete_dgcbcc_xeploai').on('click',function(){
			if(confirm('Bạn có muốn xóa không?')){
				$.blockUI();
				var id = $(this).data('id');
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=dgcbcc_xeploai&task=delete_dgcbcc_xeploai',
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