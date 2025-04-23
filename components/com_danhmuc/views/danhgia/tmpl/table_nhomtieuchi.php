<?php 
	$ds_nhomtieuchi = $this->ds_nhomtieuchi;
?>
<div class="table-header" style="text-align:center;margin-bottom:1%">Danh sách nhóm tiêu chí</div>
<table id="tbl_nhomtieuchi" class="table table-striped table-bordered table-hover">
	<thead>
		<th class="center" style="width:5%"><input type="checkbox" id="checkall_nhomtieuchi"><label class="lbl"></label></th>
		<th class="center" style="width:5%">STT</th>
		<th class="center" style="width:20%">Mã nhóm tiêu chí</th>
		<th class="center" style="width:30%">Tên nhóm tiêu chí</th>
		<th class="center" style="width:20%">Trạng thái</th>
		<th class="center" style="width:20%">Chức năng</th>
	</thead>
	<tbody>
		<?php for($i=0;$i<count($ds_nhomtieuchi);$i++){ ?>
			<?php 
				$stt = $i+1;
				if($ds_nhomtieuchi[$i]['published']==1){
					$published = 'Đang sử dụng';
				}
				else{
					$published = 'Không sử dụng';
				}
			?>
			<tr>
				<td style="padding-left:2%"><input type="checkbox" class="arrayid_nhomtieuchi" value="<?php echo $ds_nhomtieuchi[$i]['id']; ?>"><label class="lbl"></label></td>
				<td class="center"><?php echo $stt; ?></td>
				<td><?php echo $ds_nhomtieuchi[$i]['code']; ?></td>
				<td><?php echo $ds_nhomtieuchi[$i]['name']; ?></td>
				<td class="center"><?php echo $published; ?></td>
				<td class="center">
					<span class="btn btn-mini btn-primary" id="btn_edit_nhomtieuchi" data-id="<?php echo $ds_nhomtieuchi[$i]['id']; ?>">Cập nhật</span>
					<span class="btn btn-mini btn-danger" id="btn_delete_nhomtieuchi" data-id="<?php echo $ds_nhomtieuchi[$i]['id']; ?>">Xóa</span>
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
		var oTable = $('#tbl_nhomtieuchi').dataTable({
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
					"orderable":false,
					"searchable":false
				},
				{
					"targets": 3,
					"orderable":true,
					"searchable":true
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
			]
		});
		$('#checkall_nhomtieuchi').on('click',function(){
			if($(this).is(':checked')){
				$('.arrayid_nhomtieuchi').prop('checked',true);
			}
			else{
				$('.arrayid_nhomtieuchi').prop('checked',false);
			}
		});
	});
</script>