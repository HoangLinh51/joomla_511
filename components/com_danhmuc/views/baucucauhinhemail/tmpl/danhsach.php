<?php
defined('_JEXEC') or die('Restricted access');
$donvihanhchinh = Core::loadAssocList('baucu_diadiemhanhchinh a', '*, (select ten from baucu_diadiemhanhchinh where id = a.parent_id) as tenthuocve', 'cap=4 and daxoa=0 and trangthai=1', 'cap asc, parent_id asc, ten asc');
$capbaucu = Core::loadAssocList('baucu_capbaucu', '*', 'daxoa=0 and trangthai=1');
?>
<table id="table_thongtinchung_baucucauhinhemail" class="table table-bordered">
	<thead>
		<tr style="background: #ECECEC;">
			<th class="center" style="vertical-align:middle; width: 5%">STT</th>
			<th class="center" style="vertical-align:middle;">Tên đơn vị</th>
			<th class="center" style="vertical-align:middle;">Thuộc</th>
			<?php for ($i = 0; $i < count($capbaucu); $i++) { ?>
				<th class="center" style="vertical-align:middle; width: 15%"><?php echo $capbaucu[$i]['ten'] ?></th>
			<?php } ?>
			<th class="center" style="vertical-align:middle;">#</th>
		</tr>
	</thead>
	<tbody>
		<?php for ($j = 0; $j < count($donvihanhchinh); $j++) { ?>
			<tr>
				<td class="center" style="vertical-align:middle;"><?php echo $j + 1 ?></td>
				<td class="" style="vertical-align:middle;">
				<span class="blue btn_edit_cauhinhemail" href="#div_modal" data-toggle="modal" style="cursor: pointer" data-diadiemhanhchinh_id="<?php echo (int)$donvihanhchinh[$j]['id']?>">
					<?php echo $donvihanhchinh[$j]['ten'] ?>
				</span>
				</td>
				<td class="center" style="vertical-align:middle;">
				<?php echo $donvihanhchinh[$j]['tenthuocve'] ?>
				</td>
				<?php for ($i = 0; $i < count($capbaucu); $i++) { ?>
					<td class="" style="vertical-align:middle;">
						<?php
						$r = Core::loadAssoc('baucu_cauhinh_capbaucunhanemail', '*', 'diadiemhanhchinh_id = ' . (int)$donvihanhchinh[$j]['id'] . ' AND capbaucu_id=' . (int)$capbaucu[$i]['id']);
						$fk = Core::loadAssoc('baucu_cauhinh_capbaucu2email', '*', 'capbaucunhanemail_id=' . (int)$r['id']);
						?>
						<?php if (count($fk) > 0 && strlen(trim($fk['email']))>0) { ?>
							<?php foreach (explode(';', $fk['email']) as $k => $v) { ?>
								<a href="mailto:<?php echo trim($v); ?>"><?php echo trim($v); ?></a>
								<?php if(count(explode(';', $fk['email']))>1 && count(explode(';', $fk['email']))!=($k+1)) { ?><hr><?php }?>
							<?php } ?>
						<?php } else { ?>
							<span class="red" style="width: 90%">Chưa có thông tin</span><br>
						<?php } ?>
					</td>
				<?php } ?>
				<td class="center" style="vertical-align:middle;">
					<span class="btn btn-small btn-primary btn_test_email" data-diadiemhanhchinh_id="<?php echo (int)$donvihanhchinh[$j]['id']?>">Gửi thử email</span>
				</td>
			</tr>
		<?php } ?>
	</tbody>
</table>
<script type="text/javascript">
	jQuery(document).ready(function($) {
		$('.btn_edit_cauhinhemail').on('click', function(){
			let capbaucu_id = $(this).data('capbaucu_id');
			let diadiemhanhchinh_id = $(this).data('diadiemhanhchinh_id');
			$.blockUI();
			$('#div_modal').load('index.php?option=com_danhmuc&view=baucucauhinhemail&format=raw&task=frm&diadiemhanhchinh_id=' + diadiemhanhchinh_id, function() {
				$.unblockUI();
			});
		})
		$('.btn_test_email').on('click', function(){
			let diadiemhanhchinh_id = $(this).data('diadiemhanhchinh_id');
			$.blockUI();
			$('#div_modal').load('index.php?option=com_danhmuc&view=baucucauhinhemail&format=raw&task=test_email&diadiemhanhchinh_id=' + diadiemhanhchinh_id, function() {
				$.unblockUI();
			});
		})
	});
</script>