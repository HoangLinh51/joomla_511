<?php 
	$ngachbac = $this->ngachbac;
?>
<table class="table table-bordered">
	<thead>
		<th style="vertical-align:middle;width:30%">Bảng lương</th>
		<th style="vertical-align:middle;width:5%">Cấp</th>
		<th style="vertical-align:middle;width:10%">Bậc bắt đầu</th>
		<th style="vertical-align:middle;width:10%">Hệ số đầu</th>
		<th style="vertical-align:middle;width:10%">Bậc kết thúc</th>
		<th style="vertical-align:middle;width:10%">Hệ số cuối</th>
		<th style="vertical-align:middle;width:10%">Năm lên lương</th>
		<!-- <th class="center" style="vertical-align:middle;width:15%">#</th> -->
	</thead>
	<tbody>
		<tr>
			<td><?php echo $ngachbac['bangluong_name']; ?></td>
			<td class="center" style="vertical-align:middle"><?php echo $ngachbac['cap']; ?></td>
			<td class="center" style="vertical-align:middle"><?php echo $ngachbac['bacdau']; ?></td>
			<td class="center" style="vertical-align:middle"><?php echo $ngachbac['hesodau']; ?></td>
			<td class="center" style="vertical-align:middle"><?php echo $ngachbac['baccuoi']; ?></td>
			<td class="center" style="vertical-align:middle"><?php echo $ngachbac['hesocuoi']; ?></td>
			<td class="center" style="vertical-align:middle"><?php echo $ngachbac['sonamluong']; ?></td>
			<!-- <td class="center" style="vertical-align:middle">
				<span class="btn btn-mini btn-primary" id="btn_save_thongtin_ngach"><i class="icon-ok"></i> Lưu</span>
			</td> -->
		</tr>
	</tbody>
</table>
<script>
	jQuery(document).ready(function($){
	});
</script>