<?php
$dotbaucu_id = $this->dotbaucu_id;
$dotbaucu = Core::loadAssoc('baucu_dotbaucu', '*', 'id=' . (int)$dotbaucu_id);
// $capbaucu = Core::loadColumn('baucu_cauhinh_dotbaucu2capbaucu', 'capbaucu_id', 'dotbaucu_id=' . (int)$dotbaucu_id);
$diadiemhanhchinh = Core::loadAssocList('baucu_diadiemhanhchinh', '*', 'cap = 3'); //  IN(0'.implode(',',$capbaucu).')');
for ($i = 0; $i < count($diadiemhanhchinh); $i++) {
    $diadiemhanhchinh[$i]['phuongxa'] = Core::loadAssocList('baucu_diadiemhanhchinh', '*', 'cap =4 and parent_id=' . $diadiemhanhchinh[$i]['id']);
    for ($j = 0; $j < count($diadiemhanhchinh[$i]['phuongxa']); $j++){
        $diadiemhanhchinh[$i]['phuongxa'][$j]['soluongkhuvucbophieu'] = Core::loadResult('baucu_tobaucu','count(id)','daxoa=0 and trangthai=1 and phuongxa_id = '.(int)$diadiemhanhchinh[$i]['phuongxa'][$j]['id'].' AND dotbaucu_id='.(int)$dotbaucu_id);
    }
}
?>
<table class="table table-bordered table-hover table-strict">
    <thead>
        <tr>
            <th rowspan="2" class="center" style="vertical-align:middle">Quận/Huyện</th>
            <th rowspan="2" class="center" style="vertical-align:middle">Phường/Xã</th>
            <th rowspan="2" class="center" style="vertical-align:middle">Số lượng khu vực bỏ phiếu</th>
            <th rowspan="2" class="center" style="vertical-align:middle">Trong đó, số lượng tổ bầu cử độc lập</th>
            <th rowspan="2" class="center" style="vertical-align:middle">Ghi chú</th>
        </tr>
    </thead>
    <tbody>
        <?php for ($i = 0; $i < count($diadiemhanhchinh); $i++) { $px += count($diadiemhanhchinh[$i]['phuongxa']);?>
            <tr>
                <td style="vertical-align:middle" rowspan="<?php echo count($diadiemhanhchinh[$i]['phuongxa'])+1; ?>" colspan="<?php echo count($diadiemhanhchinh[$i]['phuongxa'])==0?'6':'1'?>">
                    <?php echo $diadiemhanhchinh[$i]['ten'] ?>
                </td>
            </tr>
            <?php for ($j = 0; $j < count($diadiemhanhchinh[$i]['phuongxa']); $j++) { $tbc += $diadiemhanhchinh[$i]['phuongxa'][$j]['soluongkhuvucbophieu'];?>
                <tr>
                    <td style="vertical-align:middle">
                        <?php echo $diadiemhanhchinh[$i]['phuongxa'][$j]['ten'] ?>
                    </td>
                    <td class="center" style="vertical-align:middle"><?php echo $diadiemhanhchinh[$i]['phuongxa'][$j]['soluongkhuvucbophieu']?></td>
                    <td></td>
                    <td></td>
                </tr>
            <?php } ?>
        <?php } ?>
        <tr>
            <td class="center" style="vertical-align:middle"><b>TỔNG CỘNG</b></td>
            <td class="center" style="vertical-align:middle"><b><?php echo $px?></b></td>
            <td class="center" style="vertical-align:middle"><b><?php echo $tbc?></b></td>
            <td></td>
            <td></td>
        </tr>
    </tbody>
</table>