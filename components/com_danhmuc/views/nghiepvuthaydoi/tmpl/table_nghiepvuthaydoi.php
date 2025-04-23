<?php 
	$ds_nghiepvuthaydoi = $this->ds_nghiepvuthaydoi;
	// var_dump($ds_nghiepvuthaydoi);die;
?>
<table id="tbl_nghiepvuthaydoi" class="table table-bordered">
	<thead>
		<th class="center" style="vertical-align:middle;width:5%"><input type="checkbox" id="checkall_nghiepvuthaydoi"><label class="lbl"></label></th>
		<th class="center" style="vertical-align:middle;width:5%">STT</th>
		<th class="center" style="vertical-align:middle;width:50%">Tên nghiệp vụ thay đổi</th>
		<th class="center" style="vertical-align:middle;width:15%">Mã nghiệp vụ thay đổi</th>
		<th class="center" style="vertical-align:middle;width:10%">Trạng thái</th>
		<th class="center" style="vertical-align:middle;width:15%">Chức năng</th>
	</thead>
	<tbody>
		<?php for($i=0;$i<count($ds_nghiepvuthaydoi);$i++){ ?>
		<?php 
			$stt = $i+1;
			if($ds_nghiepvuthaydoi[$i]['trangthai']==1){
				$trangthai = '<i class="icon-check"></i>';
			}
			else{
				$trangthai = '';
			}
		?>
		<tr>
			<td class="center" style="vertical-align:middle"><input type="checkbox" class="array_id_nghiepvuthaydoi" value="<?php echo $ds_nghiepvuthaydoi[$i]['id']; ?>"><label class="lbl"></label></td>
			<td class="center" style="vertical-align:middle"><?php echo $stt; ?></td>
			<td style="vertical-align:middle"><?php echo $ds_nghiepvuthaydoi[$i]['ten']; ?></td>
			<td style="vertical-align:middle"><?php echo $ds_nghiepvuthaydoi[$i]['ma']; ?></td>
			<td class="center" style="vertical-align:middle"><?php echo $trangthai; ?></td>
			<td class="center" style="vertical-align:middle">
				<span class="btn btn-mini btn-primary btn_edit_nghiepvuthaydoi" data-id="<?php echo $ds_nghiepvuthaydoi[$i]['id']; ?>" href="#modal-form" data-toggle="modal">Hiệu chỉnh</span>
				<span class="btn btn-mini btn-danger btn_delete_nghiepvuthaydoi" data-id="<?php echo $ds_nghiepvuthaydoi[$i]['id']; ?>">Xóa</span>
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
		var oTable = $('#tbl_nghiepvuthaydoi').dataTable({
			"oLanguage": {
				"sUrl": "<?php echo JUri::base(true);?>/media/cbcc/js/dataTables.vietnam.txt"
			},
			"columnDefs":
			[
				{
					"targets":0,
					"searchable":false,
					"orderable":false
				},
				{
					"targets":1,
					"searchable":false,
					"orderable":false
				},
				{
					"targets":2,
					"searchable":true,
					"orderable":true
				},
				{
					"targets":3,
					"searchable":true,
					"orderable":true
				},
				{
					"targets":4,
					"searchable":false,
					"orderable":false
				},
				{
					"targets":5,
					"searchable":false,
					"orderable":false
				}
			]
		});
		$('#checkall_nghiepvuthaydoi').on('click',function(){
			if($(this).is(':checked')){
				$('.array_id_nghiepvuthaydoi').prop('checked',true);
			}
			else{
				$('.array_id_nghiepvuthaydoi').prop('checked',false);
			}
		});
		$('.btn_edit_nghiepvuthaydoi').on('click',function(){
			var id = $(this).data('id');
			$('#modal-form').html('');
	    	$('#modal-form').load('<?php echo JURI::base(true);?>/index.php?option=com_danhmuc&view=nghiepvuthaydoi&task=chinhsua_nghiepvuthaydoi&format=raw&id='+id, function(){
	    	});
		});
		$('.btn_delete_nghiepvuthaydoi').on('click',function(){
			if(confirm("Bạn có muốn xóa không?")){				
				$.blockUI();
				var id = $(this).data('id');
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=nghiepvuthaydoi&task=delete_nghiepvuthaydoi',
					data: {id:id},
					success:function(data){
						if(data==true){
							$('#btn_tk_nghiepvuthaydoi').click();
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