<?php 
	$ds_tieuchi = $this->ds_tieuchi;
?>
<div class="table-header" style="text-align:center;margin-bottom:1%">Danh sách tiêu chí</div>
<table id="tbl_tieuchi" class="table table-striped table-bordered table-hover">
	<thead>
		<th class="center" style="width:5%"><input type="checkbox" id="checkall_tieuchi"><label class="lbl"></label></th>
		<th class="center" style="width:5%">STT</th>
		<th class="center" style="width:5%">Mã tiêu chí</th>
		<th class="center" style="width:30%">Tên tiêu chí</th>
		<th class="center" style="width:10%">Điểm min</th>
		<th class="center" style="width:10%">Điểm max</th>
		<th class="center" style="width:10%">Xếp loại</th>
		<th class="center" style="width:10%">Trạng thái</th>
		<th class="center" style="width:15%">Chức năng</th>
	</thead>
	<tbody>
		<?php for($i=0;$i<count($ds_tieuchi);$i++){ ?>
			<?php 
				$stt = $i+1;
				if($ds_tieuchi[$i]['published']==1){
					$published = 'Đang sử dụng';
				}
				else{
					$published = 'Không sử dụng';
				}
			?>
			<tr>
				<td style="padding-left:2%"><input type="checkbox" class="arrayid_tieuchi" value="<?php echo $ds_tieuchi[$i]['id']; ?>"><label class="lbl"></label></td>
				<td class="center"><?php echo $stt; ?></td>
				<td><?php echo $ds_tieuchi[$i]['code']; ?></td>
				<td><?php echo $ds_tieuchi[$i]['name']; ?></td>
				<td class="center"><?php echo $ds_tieuchi[$i]['diemmin']; ?></td>
				<td class="center"><?php echo $ds_tieuchi[$i]['diemmax']; ?></td>
				<td class="center"><?php echo $ds_tieuchi[$i]['code_xeploai']; ?></td>
				<td class="center"><?php echo $published; ?></td>
				<td class="center">
					<span class="btn btn-mini btn-primary" id="btn_edit_tieuchi" data-id="<?php echo $ds_tieuchi[$i]['id']; ?>">Cập nhật</span>
					<span class="btn btn-mini btn-danger" id="btn_delete_tieuchi" data-id="<?php echo $ds_tieuchi[$i]['id']; ?>">Xóa</span>
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
		var oTable = $('#tbl_tieuchi').dataTable({
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
				{
					"targets": 6,
					"orderable":false,
					"searchable":false
				},
				{
					"targets": 7,
					"orderable":false,
					"searchable":false
				},
				{
					"targets": 8,
					"orderable":false,
					"searchable":false
				}
			]
		});
		$('#checkall_tieuchi').on('click',function(){
			if($(this).is(':checked')){
				$('.arrayid_tieuchi').prop('checked',true);
			}
			else{
				$('.arrayid_tieuchi').prop('checked',false);
			}
		});
	});
</script>