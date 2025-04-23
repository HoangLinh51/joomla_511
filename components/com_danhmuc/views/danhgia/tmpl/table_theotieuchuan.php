<?php 
	$ds_theotieuchuan = $this->ds_theotieuchuan;
	$ds_dgcbcc_loaicongviec = $this->ds_dgcbcc_loaicongviec;
?>
<table id="tbl_theotieuchuan" class="table table-bordered">
	<thead>
		<th class="center" style="width:5%">Stt</th>
		<th class="center" style="width:5%"><input type="checkbox" id="checkall_theotieuchuan"><label class="lbl"></label></th>
		<th class="center" style="width:30%">Tên đánh giá cán bộ công chức theo tiêu chuẩn</th>
		<th class="center" style="width:10%">Mã đánh giá cán bộ công chức theo tiêu chuẩn</th>
		<th class="center" style="width:5%">Hệ số</th>
		<th class="center" style="width:5%">Cá nhân</th>
		<th class="center" style="width:5%">Đang sử dụng</th>
		<th class="center" style="width:20%">Loại công việc</th>
		<th class="center" style="width:15%">Chức năng</th>
	</thead>
	<tbody>
		<?php for($i=0;$i<count($ds_theotieuchuan);$i++){ ?>
			<?php 
				$stt = $i+1;
				if($ds_theotieuchuan[$i]['is_canhan']==1){
					$is_canhan = '<i class="icon-check"></i>';
				}
				else{
					$is_canhan = '';
				}
				if($ds_theotieuchuan[$i]['published']==1){
					$published = '<i class="icon-check"></i>';
				}
				else{
					$published = '';
				}
				$loaicongviec = '';
				$array_loaicongviec = explode(',',$ds_theotieuchuan[$i]['ids_loaicongviec']);
				for($k=0;$k<count($array_loaicongviec);$k++){
					for($j=0;$j<count($ds_dgcbcc_loaicongviec);$j++){
						if($ds_dgcbcc_loaicongviec[$j]['id']==$array_loaicongviec[$k]){
							if($k==0){
								$loaicongviec .= $ds_dgcbcc_loaicongviec[$j]['name'];
							}
							else{
								$loaicongviec .= ', '.$ds_dgcbcc_loaicongviec[$j]['name'];
							}
						}
					}	
				}
			?>
			<tr>
				<td class="center"><?php echo $stt; ?></td>
				<td class="center"><input type="checkbox" class="arrayid_theotieuchuan" value="<?php echo $ds_theotieuchuan[$i]['id']; ?>"><label class="lbl"></label></td>
				<td><?php echo $ds_theotieuchuan[$i]['name']; ?></td>
				<td><?php echo $ds_theotieuchuan[$i]['code']; ?></td>
				<td class="center"><?php echo $ds_theotieuchuan[$i]['heso']; ?></td>
				<td class="center"><?php echo $is_canhan; ?></td>
				<td class="center"><?php echo $published; ?></td>
				<td><?php echo $loaicongviec; ?></td>
				<td class="center">
					<span class="btn btn-mini btn-primary btn_edit_theotieuchuan" data-id="<?php echo $ds_theotieuchuan[$i]['id']; ?>" href="#modal-form" data-toggle="modal">Hiệu chỉnh</span>
					<span class="btn btn-mini btn-danger btn_delete_theotieuchuan" data-id="<?php echo $ds_theotieuchuan[$i]['id']; ?>">Xóa</span>
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
		var oTable = $('#tbl_theotieuchuan').dataTable({
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
				},
				{
					"targets": 6,
					"searchable":false,
					"orderable":false,
				},
				{
					"targets": 7,
					"searchable":false,
					"orderable":false,
				},
				{
					"targets": 8,
					"searchable":false,
					"orderable":false,
				}
			]
		});
		$('#checkall_theotieuchuan').on('click',function(){
			if($(this).is(':checked')){
				$('.arrayid_theotieuchuan').prop('checked',true);
			}
			else{
				$('.arrayid_theotieuchuan').prop('checked',false);
			}
		});
		$('.btn_edit_theotieuchuan').on('click',function(){
			var id = $(this).data('id');
			$('#modal-form').html('');
	    	$('#modal-form').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&controller=danhgia&task=chinhsua_theotieuchuan&format=raw&id='+id, function(){
	    	});
		});
		$('.btn_delete_theotieuchuan').on('click',function(){
			if(confirm('Bạn có muốn xóa không?')){
				$.blockUI();
				var id = $(this).data('id');
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=theotieuchuan&task=delete_theotieuchuan',
					data: {id:id},
					success:function(data){
						if(data==true){
        					$('#btn_tk_theotieuchuan').click();
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