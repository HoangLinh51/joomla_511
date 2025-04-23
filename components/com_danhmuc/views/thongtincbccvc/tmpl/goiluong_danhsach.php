<?php 
defined('_JEXEC') or die('Restricted access');
$data = $this->data;
$ngach = Core::loadAssocListHasKey('cb_bac_heso','*', 'id', null);
$muctuongduong = Core::loadAssocListHasKey('grade_level','*','id', array('status=1'));
?>
	<table id="tbl_goiluong" class="table table-bordered table-hover">
		<thead>
			<th style="text-align:center">STT</th>
			<th style="text-align:center; width: 40%">Tên</th>
			<th style="text-align:center">Ngạch tương ứng</th>
			<th style="text-align:center">Ngạch tương đương</th>
			<th style="text-align:center">Trạng thái</th>
			<th style="text-align:center; width: 21%">Thao tác</th>
		</thead>
		<tbody>
			<?php for($i=0;$i<count($data);$i++){ 
			?>
				<tr>
					<td style="text-align:center"><?php echo $i+1; ?></td>
					<td style="text-align:center"><?php echo $data[$i]['name']; ?></td>
					<td style="text-align:center"><?php echo $ngach[$data[$i]['ngach_id']]['name']; ?></td>
					<td style="text-align:center"><?php echo $muctuongduong[$data[$i]['muctuongduong']]['name_grade']; ?></td>
					<td style="text-align:center"><i class="<?php if($data[$i]['trangthai']==1) echo 'icon-check';?>"></i></td>
					<td style="text-align:center">
						<span data-toggle="modal" data-target=".modal" class="btn btn-mini btn-primary btn_edit_goiluong" data-id="<?php echo $data[$i]['id']; ?>"><i class="icon-pencil"></i> Hiệu chỉnh</span>
						<span class="btn btn-mini btn-danger btn_delete_goiluong" data-id="<?php echo $data[$i]['id']; ?>"><i class="icon-remove"></i> Xóa</span>
					</td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
<script>
	jQuery(document).ready(function($){
		$('.btn_edit_goiluong').on('click',function(){
			$('#gritter-notice-wrapper').remove();
			let id = $(this).data('id');
			$.blockUI();
	        $('#modal-form').load('index.php?option=com_danhmuc&controller=thongtincbccvc&task=goiluong_frm&format=raw&id='+id, function(){
				$.unblockUI();
	        });
		});
		$('.btn_delete_goiluong').on('click',function(){
			$('#gritter-notice-wrapper').remove();
			if(confirm('Bạn có muốn xóa không?')){
				var data_id = $(this).data('id');
				$.blockUI();
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=goiluong&task=xoa_goiluong',
					data: {id:data_id},
					success:function(data){
						if(data == true){
	                        danhsachgoiluong();
							loadNoticeBoardSuccess('Thông báo','Xử lý thành công');
							$.unblockUI();
	                    }
	                    else{
							loadNoticeBoardError('Thông báo','Xử lý không thành công! Vui lòng liên hệ Quản trị viên!');
							$.unblockUI();
	                    }
					},
					error: function(){
						loadNoticeBoardError('Thông báo','Xử lý không thành công! Vui lòng liên hệ Quản trị viên!');
						$.unblockUI();
					}
				});
			}
		});
	});
</script>