<?php 
defined('_JEXEC') or die('Restricted access');
$data = $this->data;
$thidua_hinhthuc = Core::loadAssocListHasKey('danhmuc_thidua_hinhthuc','*','id');
$loaihinh = array('KT'=>'Khen thưởng', 'KL'=>'Kỷ luật', 'KLD'=>'Kỷ luật Đảng')
?>
	<table id="tbl_khenthuongkyluat" class="table table-bordered table-hover">
		<thead>
			<th style="text-align:center">STT</th>
			<th style="text-align:center; width: 40%">Tên</th>
			<th style="text-align:center">Loại hình</th>
			<th style="text-align:center">Hình thức</th>
			<th style="text-align:center">Số tháng nâng lương trước</th>
			<th style="text-align:center">Số lần tối đa trong năm</th>
			<th style="text-align:center">Trạng thái</th>
			<th style="text-align:center; width: 21%">Thao tác</th>
		</thead>
		<tbody>
			<?php for($i=0;$i<count($data);$i++){ 
			?>
				<tr>
					<td style="text-align:center"><?php echo $i+1; ?></td>
					<td style="text-align:center"><?php echo $data[$i]['name']; ?></td>
					<td style="text-align:center"><?php echo $loaihinh[$data[$i]['type']]; ?></td>
					<td style="text-align:center"><?php echo $thidua_hinhthuc[$data[$i]['hinhthuc_id']]['ten']; ?></td>
					<td style="text-align:center"><?php echo $data[$i]['months_nangluongtruoc']; ?></td>
					<td style="text-align:center"><?php echo $data[$i]['solantoidatrongnam']; ?></td>
					<td style="text-align:center"><i class="<?php if($data[$i]['status']==1) echo 'icon-check';?>"></i></td>
					<td style="text-align:center">
						<span data-toggle="modal" data-target=".modal" class="btn btn-mini btn-primary btn_edit_khenthuongkyluat" data-id="<?php echo $data[$i]['id']; ?>"><i class="icon-pencil"></i> Hiệu chỉnh</span>
						<span class="btn btn-mini btn-danger btn_delete_khenthuongkyluat" data-id="<?php echo $data[$i]['id']; ?>"><i class="icon-remove"></i> Xóa</span>
					</td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
<script>
	jQuery(document).ready(function($){
		$('.btn_edit_khenthuongkyluat').on('click',function(){
			$('#gritter-notice-wrapper').remove();
			let id = $(this).data('id');
			$.blockUI();
	        $('#modal-form').load('index.php?option=com_danhmuc&controller=thongtincbccvc&task=khenthuongkyluat_frm&format=raw&id='+id, function(){
				$.unblockUI();
	        });
		});
		$('.btn_delete_khenthuongkyluat').on('click',function(){
			$('#gritter-notice-wrapper').remove();
			if(confirm('Bạn có muốn xóa không?')){
				var data_id = $(this).data('id');
				$.blockUI();
				$.ajax({
					type: 'post',
					url: 'index.php?option=com_danhmuc&controller=khenthuongkyluat&task=xoa_khenthuongkyluat',
					data: {id:data_id},
					success:function(data){
						if(data == true){
	                        danhsachkhenthuongkyluat();
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