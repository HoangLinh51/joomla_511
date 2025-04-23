<?php 
	$ds_mucdophuctap = $this->ds_mucdophuctap;
?>
<table id="tbl_mucdophuctap" class="table table-bordered">
	<thead>
		<th class="center" style="width:5%">STT</th>
		<th class="center" style="width:5%"><input type="checkbox" id="checkall_mucdophuctap"><label class="lbl"></label></th>
		<th class="center" style="width:45%">Tên mức độ phức tạp</th>
		<th class="center" style="width:10%">Hệ số</th>
		<th class="center" style="width:10%">Hệ số tự đánh giá</th>
		<th class="center" style="width:10%">Trạng thái</th>
		<th class="center" style="width:15%">Thao tác</th>
	</thead>
	<tbody>
		<?php for($i=0;$i<count($ds_mucdophuctap);$i++){ ?>
		<?php 
			$stt = $i+1;
			if($ds_mucdophuctap[$i]['status']==1){
				$status = '<i class="icon-check"></i>';
			}
			else{
				$status = '';
			}
		?>
		<tr>
			<td class="center"><?php echo $stt; ?></td>
			<td class="center"><input type="checkbox" class="array_id_mucdophuctap" value="<?php echo $ds_mucdophuctap[$i]['id']; ?>"><label class="lbl"></label></td>
			<td><?php echo $ds_mucdophuctap[$i]['name']; ?></td>
			<td class="center"><?php echo $ds_mucdophuctap[$i]['heso']; ?></td>
			<td class="center"><?php echo $ds_mucdophuctap[$i]['heso_tu_dg']; ?></td>
			<td class="center"><?php echo $status; ?></td>
			<td class="center">
				<span class="btn btn-mini btn-primary btn_edit_mucdophuctap" data-id="<?php echo $ds_mucdophuctap[$i]['id']; ?>" href="#modal-form" data-toggle="modal">Hiệu chỉnh</span>
				<span class="btn btn-mini btn-danger btn_delete_mucdophuctap" data-id="<?php echo $ds_mucdophuctap[$i]['id']; ?>">Xóa</span>
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
		var oTable = $('#tbl_mucdophuctap').dataTable({
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
		$('#checkall_mucdophuctap').on('click',function(){
			if($(this).is(':checked')){
				$('.array_id_mucdophuctap').prop('checked',true);
			}
			else{
				$('.array_id_mucdophuctap').prop('checked',false);
			}
		});
		$('.btn_edit_mucdophuctap').on('click',function(){
			var id = $(this).data('id');
			$('#modal-form').html('');
	    	$('#modal-form').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&controller=danhgia&task=chinhsua_mucdophuctap&format=raw&id='+id, function(){
	    	});
		});
		$('.btn_delete_mucdophuctap').on('click',function(){
			if(confirm('Bạn có muốn xóa không?')){
				$.blockUI();
				var id = $(this).data('id');
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=mucdophuctap&task=delete_mucdophuctap',
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