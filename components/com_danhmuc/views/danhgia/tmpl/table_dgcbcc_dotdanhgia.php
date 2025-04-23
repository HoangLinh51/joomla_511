<?php 
	$ds_dgcbcc_dotdanhgia = $this->ds_dgcbcc_dotdanhgia;
	$model = Core::model('Danhmuchethong/DgcbccDotdanhgia');
?>
<table id="tbl_dgcbcc_dotdanhgia" class="table table-bordered">
	<thead>
		<th class="center" style="width:5%"><input type="checkbox" id="checkall_dgcbcc_dotdanhgia"><label class="lbl"></label></th>
		<th class="center" style="width:5%;vertical-align:middle">STT</th>
		<th class="center" style="width:20%;vertical-align:middle">Tên đợt đánh giá</th>
		<th class="center" style="width:5%;vertical-align:middle">Ngày tiến hành đợt đánh giá</th>
		<th class="center" style="width:5%;vertical-align:middle">Ngày bắt đầu</th>
		<th class="center" style="width:5%;vertical-align:middle">Ngày tự đánh giá</th>
		<th class="center" style="width:5%;vertical-align:middle">Ngày kết thúc</th>
		<th class="center" style="width:5%;vertical-align:middle">Thời gian tiến hành đợt</th>
		<th class="center" style="width:5%;vertical-align:middle">Đánh giá năm</th>
		<th class="center" style="width:5%;vertical-align:middle">Khóa</th>
		<th class="center" style="width:10%;vertical-align:middle">Ghi chú</th>
		<th class="center" style="width:15%;vertical-align:middle">Chức năng</th>
	</thead>
	<tbody>
		<?php for($i=0;$i<count($ds_dgcbcc_dotdanhgia);$i++){ ?>
		<?php 
			$stt = $i+1;
			$ngaybatdau = $model->ConvertFormatDateFromDb($ds_dgcbcc_dotdanhgia[$i]['ngaybatdau']);
			$ngayketthuc = $model->ConvertFormatDateFromDb($ds_dgcbcc_dotdanhgia[$i]['ngayketthuc']);
			$ngaytudanhgia = $model->ConvertFormatDateFromDb($ds_dgcbcc_dotdanhgia[$i]['ngaytudanhgia']);
			$date_dot = $model->ConvertFormatDateFromDb($ds_dgcbcc_dotdanhgia[$i]['date_dot']);
			if($ds_dgcbcc_dotdanhgia[$i]['is_danhgianam']==1){
				$danhgianam = '<i class="icon-check"></i>';
			}
			else{
				$danhgianam = '';
			}
			if($ds_dgcbcc_dotdanhgia[$i]['is_lock']==1){
				$is_lock = '<i class="icon-check"></i>';
			}
			else{
				$is_lock = '';
			}
		?>
		<tr>
			<td class="center"><input type="checkbox" class="array_id_dgcbcc_dotdanhgia" value="<?php echo $ds_dgcbcc_dotdanhgia[$i]['id']; ?>"><label class="lbl"></label></td>
			<td class="center"><?php echo $stt; ?></td>
			<td><?php echo $ds_dgcbcc_dotdanhgia[$i]['name']; ?></td>
			<td class="center"><?php echo $date_dot; ?></td>
			<td class="center"><?php echo $ngaybatdau; ?></td>
			<td class="center"><?php echo $ngaytudanhgia; ?></td>
			<td class="center"><?php echo $ngayketthuc; ?></td>
			<td class="center"><?php echo $ds_dgcbcc_dotdanhgia[$i]['time_dot']; ?></td>
			<td class="center"><?php echo $danhgianam; ?></td>
			<td class="center"><?php echo $is_lock; ?></td>
			<td class="center"><?php echo $ds_dgcbcc_dotdanhgia[$i]['ghichu']; ?></td>
			<td class="center">
				<span class="btn btn-mini btn-primary btn_edit_dgcbcc_dotdanhgia" data-id="<?php echo $ds_dgcbcc_dotdanhgia[$i]['id']; ?>" href="#modal-form" data-toggle="modal">Hiệu chỉnh</span>
				<span class="btn btn-mini btn-danger btn_delete_dgcbcc_dotdanhgia" data-id="<?php echo $ds_dgcbcc_dotdanhgia[$i]['id']; ?>" style="width:54%">Xóa</span>
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
		var oTable = $("#tbl_dgcbcc_dotdanhgia").dataTable({
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
					"orderable":true
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
				},
				{
					"targets": 8,
					"searchable":false,
					"orderable":false
				},
				{
					"targets": 9,
					"searchable":false,
					"orderable":false
				},
				{
					"targets": 10,
					"searchable":false,
					"orderable":false
				},
				{
					"targets": 11,
					"searchable":false,
					"orderable":false
				}
			]
		});
		$('#checkall_dgcbcc_dotdanhgia').on('click',function(){
			if($(this).is(':checked')){
				$('.array_id_dgcbcc_dotdanhgia').prop('checked',true);
			}
			else{
				$('.array_id_dgcbcc_dotdanhgia').prop('checked',false);
			}
		});
		$('.btn_edit_dgcbcc_dotdanhgia').on('click',function(){
			var id = $(this).data('id');
			$('#modal-form').html('');
	    	$('#modal-form').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&controller=danhgia&task=chinhsua_dgcbcc_dotdanhgia&format=raw&id='+id, function(){
	    	});
		});
		$('.btn_delete_dgcbcc_dotdanhgia').on('click',function(){
			if(confirm('Bạn có muốn xóa không?')){
				$.blockUI();
				var id = $(this).data('id');
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=dgcbcc_dotdanhgia&task=delete_dgcbcc_dotdanhgia',
					data:{id:id},
					success:function(data){
						if(data==true){
							$('#dgcbcc_dotdanhgia_nam').change();
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
