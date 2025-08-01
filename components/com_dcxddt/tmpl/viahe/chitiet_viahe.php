<?php
defined('_JEXEC') or die('Restricted access');
$item = $this->item;
$idUser = JFactory::getUser()->id;
$cauhinh =  Core::config('core/system/namduong');
$jsonArray = json_decode($cauhinh);
?>
<form id="frmViaHe" name="frmViaHe" method="post" action="index.php?option=com_dcxddtmt&controller=viahe&task=saveThongtinViahe" style="font-size:16px;">
    <div class="clear"></div>
    <h2 class="row-fluid header smaller lighter blue">
        <?php echo ((int)$item['id'] > 0) ? "Xem chi tiết" : "Thêm mới"; ?> thông tin cấp phép sử dụng tạm thời một phần vỉa hè
        <button type="button" id="btn_quaylai" class="btn pull-right inline" style="font-size:18px;"><i class="icon-long-arrow-left"></i> Quay lại</button>
    </h2>
    <h3 class="row-fluid header smaller lighter" style="margin-top:8px;">Thông tin khách hàng</h3>
    <table style="width:100%;" id="tblThongtin">
        <tbody>
            <tr>
                <td style="vertical-align:middle;width:150px;"><strong>Họ tên: <span class="required">*</span></strong></td>
                <td style="vertical-align:middle;" colspan="<?php echo $jsonArray->$idUser != '1' ? "3" : "5" ?>">
                    <div class="control-group">
                        <input disabled class="form-group" type="text" id="tenkhachhang" name="tenkhachhang" value="<?php echo $item['hoten'] ?>" style="<?php echo $jsonArray->$idUser != '1' ? "width:90%;" : "width:99%;" ?>height:30px;font-size:16px;margin-top:10px;" />
                    </div>
                </td>
                <?php if ($jsonArray->$idUser != '1') { ?>
                    <td style="vertical-align:middle;width:116px;"><strong>Số điện thoại: <span class="required">*</span></strong></td>
                    <td style="vertical-align:middle;" colspan="5">
                        <div class="control-group">
                            <input disabled class="form-group" type="text" id="sodienthoai" name="sodienthoai" value="<?php echo $item['dienthoai'] ?>" />

                        </div>
                    </td>
                <?php } ?>
            </tr>
            <tr>
                <td style="vertical-align:middle;width:150px;"><strong>Địa chỉ thường trú: <span class="required">*</span></strong></td>
                <td style="vertical-align:middle;" colspan="<?php echo $jsonArray->$idUser != '1' ? "3" : "5" ?>">
                    <div class="control-group" style="margin-bottom: 0px !important;">
                        <input disabled class="form-group" type="text" name="diachithuongtru" value="<?php echo $item['diachithuongtru'] ?>" style="<?php echo $jsonArray->$idUser != '1' ? "width:95%;" : "width:99%;" ?>height:30px;font-size:16px;margin-top:10px;" />
                    </div>
                </td>
                <?php if ($jsonArray->$idUser != '1') { ?>
                    <td style="vertical-align:middle;width:116px;"><strong>Ngày tháng năm sinh: <span class="required">*</span></strong></td>
                    <td style="vertical-align:middle;" colspan="5">
                        <div class="control-group" style="margin-bottom: 0px !important;">
                            <input disabled class="form-group date-picker" data-date-format="dd/mm/yyyy" type="text" style="width:95%;height: 30px;" id="ngaysinh" name="ngaysinh" value="<?php echo date("d/m/Y", strtotime($item['ngaysinh'])); ?>" />

                        </div>
                    </td>
                <?php } ?>
            </tr>
            <tr>
                <td style="vertical-align:middle;" nowrap><strong style="white-space: break-spaces;word-break: break-word;">CMND/CCCD: <span class="required">*</span></strong></td>
                <td style="vertical-align:middle;">
                    <input disabled disabled class="form-group" type="text" id="cccd" name="cccd" value="<?php echo $item['cccd'] ?>" style="width:90%;height:30px;font-size:16px;margin-top:10px;" />
                </td>
                <td style="vertical-align:middle;"><strong>Ngày cấp: <span class="required">*</span></strong></td>
                <td style="vertical-align:middle;">
                    <input disabled class="form-group date-picker" autocomplete="off" data-date-format="dd/mm/yyyy" type="text" id="ngaycap_cccd" name="ngaycap_cccd" value="<?php echo date("d/m/Y", strtotime($item['ngaycap_cmnd'])); ?>" style="width:85%;height:30px;font-size:16px;margin-top:10px;" />
                </td>
                <td style="vertical-align:middle;"><strong>Nơi cấp: <span class="required">*</span></strong></td>
                <td style="vertical-align:middle;">
                    <input disabled class="form-group" type="text" id="noicap_cccd" name="noicap_cccd" value="<?php echo $item['noicap_cccd'] ?>" style="width:94.7%;height:30px;font-size:16px;margin-top:10px;" />
                </td>
            </tr>
            <tr>
                <td style="vertical-align:middle;" colspan="6">
                    <h3 class="row-fluid header smaller lighter" style="margin-top:0px;">Thông tin cấp phép
                </td>
            </tr>
            <tr>
                <td style="vertical-align:middle;"><strong>Địa chỉ:</strong></td>
                <td style="vertical-align:middle;" colspan="5">
                    <input disabled type="text" class="form-group" id="diachi" name="diachi" value="<?php echo $item['diachi'] ?>" style="width:98.6% !important;height:30px;font-size:16px;margin-top:10px;" />
                </td>
            </tr>
            <tr>
                <td style="vertical-align:middle;" nowrap><strong style="white-space: break-spaces;word-break: break-word;">Diện tích được phép <br>sử dụng tạm thời:</strong></td>
                <td style="vertical-align:middle;">
                    <input disabled class="form-group" type="text" id="dientich" name="dientich" value="<?php echo $item['dientichtamthoi'] ?>" style="width:90%;height:30px;font-size:16px;margin-top:10px;" />
                </td>
                <td style="vertical-align:middle;"><strong>Chiều dài dọc vỉa hè:</strong></td>
                <td style="vertical-align:middle;">
                    <input disabled class="form-group" type="text" id="chieudai" name="chieudai" value="<?php echo $item['chieudai'] ?>" style="width:90%;height:30px;font-size:16px;margin-top:10px;" />
                </td>
                <td style="vertical-align:middle;"><strong>Chiều rộng:</strong></td>
                <td style="vertical-align:middle;">
                    <input disabled class="form-group" type="text" id="chieurong" name="chieurong" value="<?php echo $item['chieurong'] ?>" style="width:94.7%;height:30px;font-size:16px;margin-top:10px;" />
                </td>
            </tr>
            <tr>
                <td style="vertical-align:middle;"><strong>Mục đích sử dụng:</strong></td>
                <td style="vertical-align:middle;" colspan="5">
                    <input disabled type="text" class="form-group" id="mucdich" name="mucdich" value="<?php echo $item['mucdichsudung'] ?>" style="width:98.6% !important;height:30px;font-size:16px;margin-top:10px;" />
                </td>

            </tr>
            <tr>
                <td style="vertical-align:top;"><strong style="display: block;margin-top: 10px;">Văn bản đính kèm:</strong></td>
                <td style="display: block;margin-top: 10px;width: 126%;" class="dinhkem" colspan="5" rowspan="">
                    <input type="hidden" name="vanbaovao_id[]" value="<?php echo $item['filedinhkem_id'] ?>" />
                    <?php //echo Core::inputAttachment('vanbanvao_id',null,1, date('Y'),-1);
                    ?>
                    <?php if ($item['filedinhkem_id'] > 0) {
                        // $thanhphan = Core::loadAssocList('core_attachment', '*', 'object_id IN ('.$item['filedinhkem_id'].')');
                        $thanhphan = Core::loadAssocList('core_attachment', '*', 'id IN (SELECT filedinhkem_id FROM dcxddtmt_viahe_filedinhkem WHERE thongtinviahe_id = ' . $item['id'] . ')');

                        for ($tp = 0; $tp < count($thanhphan); $tp++) {
                            $filename = $thanhphan[$tp]['code'];
                            $typeFile = $thanhphan[$tp]['mime'];
                            $url      = "https://csdlphuongxa.danang.gov.vn/" . '/tmp/' . $filename;
                    ?>
                            <input type="hidden" id="file" class="fileUploaded" name="idFile-vanbaovao_id[]" value="<?php echo $thanhphan[$tp]['code'] ?>">
                            <!-- <span class="btn btn-minier btn-danger btn_xoa_taptin" style="line-height: 16px !important;" data-code="<?php echo $thanhphan[$tp]['code'] ?>" data-object_id="<?php echo $thanhphan[$tp]['object_id'] ?>" data-type_id="<?php echo $thanhphan[$tp]['type_id'] ?>">
                <i class="icon-trash"></i>
            </span> -->
                            <!-- <a href="<?php echo JUri::root(true) ?>/index.php?option=com_core&controller=attachment&task=download&code=<?php echo $thanhphan[$tp]['code'] ?>" target="_blank"><?php echo mb_strimwidth($thanhphan[0]['filename'], 0, 35, "..."); ?></a> -->
                            <?php if ($typeFile == 'image/jpeg' || $typeFile == 'image/png') { ?>
                                <!-- Trigger the Modal -->
                                <img id="myImg" class="hinhanh" src="<?php echo $url ?>" alt="" style="width:25%;max-width:100px;height: 52px;border: 1px solid;">

                                <!-- The Modal -->
                                <div id="myModal" class="modal2">

                                    <!-- The Close Button -->
                                    <span class="close">&times;</span>

                                    <!-- Modal Content (The Image) -->
                                    <img class="modal-content mdhinhanh" id="img01">

                                    <!-- Modal Caption (Image Text) -->
                                    <div id="caption"></div>
                                </div>
                            <?php } else { ?>
                                <a href="<?php echo $url ?>" target="_blank"><?php echo mb_strimwidth($thanhphan[$tp]['filename'], 0, 35, "..."); ?></a>

                            <?php } ?>

                    <?php }
                    } ?>
                </td>

            </tr>

            <tr>
                <td style="vertical-align:middle;" colspan="6">
                    <h3 class="row-fluid header smaller lighter" style="margin-top:20px;">Thông tin hợp đồng
                        <span class="pull-right inline">
                            <div class="btn-group">
                                <!-- <button data-toggle="dropdown" id="<?php echo ((int)$item['id'] > 0) ? "btn_themthongtin_edit" : "btn_themthongtin" ?>" class="btn btn-success btn-lg dropdown-toggle">
                Thêm
            </button> -->
                            </div>
                        </span>
                    </h3>
                </td>
            </tr>

        </tbody>
    </table>

    <div class="divFixHead">
        <table class="table table-striped table-bordered tableFixHead" id="tblDanhsach">
            <thead>
                <tr style="background: #027be3;width: 100%;" class="first">
                    <th style="vertical-align:middle;color:#FFF!important;min-width: 30px;" class="center">#</th>
                    <th style="vertical-align:middle;color:#FFF!important;" class="center">Số giấy phép</th>
                    <th style="vertical-align:middle;color:#FFF!important;" class="center">Số lần</th>
                    <th style="vertical-align:middle;color:#FFF!important;" class="center">Ngày ký hợp đồng</th>
                    <th style="vertical-align:middle;color:#FFF!important;" class="center">Ngày hết hạn hợp đồng</th>
                    <th style="vertical-align:middle;color:#FFF!important;" class="center">Thời hạn</th>
                    <th style="vertical-align:middle;color:#FFF!important;" class="center">Số tiền</th>
                    <!-- <th style="vertical-align:middle;color:#FFF!important;" class="center">Tình trạng</th> -->
                    <th style="vertical-align:middle;color:#FFF!important;" class="center">Ghi chú</th>
                    <!-- <th style="vertical-align:middle;color:#FFF!important;" class="center">Chức năng</th> -->
                </tr>
            </thead>
            <tbody id="tbdThongTin">

                <?php
                $dem = 0;
                $stttss = 0;
                if (count($this->thongtinthanhphan) > 0) {
                    //echo "<pre>";
                    //var_dump($this->thongtinthanhphan);
                    for ($i = 0; $i < count($this->thongtinthanhphan); $i++) {
                        $tphan = $this->thongtinthanhphan[$i];
                        if ($tphan['countRows'] > 1) {
                            $res = Core::loadAssocList('dcxddtmt_viahe_thongtinhopdong', '*', 'giayphep_id = ' . $tphan['id_giayphep'] . ' AND daxoa = 0');
                            $j = 1;
                            $h = 1;
                            $sl = 1;
                            for ($d = 0; $d < count($res); $d++) {  ?>
                                <tr class="themlan_<?php echo $d + 1 . ' ' . ($i + 1) ?> <?php echo $tphan['id_hopdong'] == $res[$d]['id'] ? "thongtin id_" . ($i + 1) : "" ?>">

                                    <input class="form-group" type="hidden" name="id_hopdong[]" value="<?php echo $res[$d]['id'] ?>">
                                    <input class="form-group" type="hidden" name="id_giayphep[]" value="<?php echo $tphan['id_giayphep'] ?>">
                                    <td style="text-align: center;vertical-align: middle;"><?php echo $tphan['id_hopdong'] == $res[$d]['id'] ? ($i + 1) : ($i + 1) . '.' . ($j++) ?></td>
                                    <td style="text-align: center;vertical-align: top !important;">
                                        <input class="form-group" type="hidden" name="stts[<?php echo ($i + 1) ?>][]" value="<?php echo $tphan['id_hopdong'] == $res[$d]['id'] ? ($i + 1) : ($i + 1) . '.' . ($j + 1) ?>">
                                        <input class="form-group" type="hidden" name="stt[]" value="<?php echo $tphan['id_hopdong'] == $res[$d]['id'] ? ($i + 1) : ($i + 1) . '.' . ($j + 1) ?>">
                                        <?php if ($tphan['id_hopdong'] == $res[$d]['id']) { ?>
                                            <input class="form-group" type="hidden" name="lv[]" value="<?php echo ($i + 1) ?>">
                                            <!-- <input class="form-group" type="hidden" name="id_giayphep[]" value="<?php echo $tphan['id_giayphep'] ?>"> -->
                                            <input disabled data-giayphep_id="<?php echo $tphan['id_giayphep'] ?>" class="form-group sgp_<?php echo $tphan['id_giayphep'] ?>" style="" type="text" name="sogiayphep[]" value="<?php echo $tphan['sogiayphep'] ?>">
                                        <?php } else { ?>
                                            <input disabled data-giayphep_id="<?php echo $tphan['id_giayphep'] ?>" class="form-group sgp_<?php echo $tphan['id_giayphep'] ?>" style="" type="hidden" name="sogiayphep[]" value="<?php echo $tphan['sogiayphep'] ?>">
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <input type="hidden" name="cha_id[]" value="<?php echo ($i + 1) ?>" />
                                        <input type="hidden" name="form-group solan_hd_<?php echo ($i + 1) ?>" value="<?php echo $tphan['id_hopdong'] == $res[$d]['id'] ? 0 : ($i + 1) ?>" />
                                        <input disabled type="text" class="<?php echo $tphan['id_hopdong'] == $res[$d]['id'] ? "" : "solan_" . ($sl++) ?>" name="solan_[]" value="<?php echo $tphan['id_hopdong'] == $res[$d]['id'] ? "Bắt đầu" : "Lần " . ($h++) ?>" />
                                    </td>
                                    <td><input disabled type="text" style="width: 70px;" data-date-format="dd/mm/yyyy" class="form-group date-picker ngaykyhopdong" name="ngay_kyhopdong[]" value="<?php echo date("d/m/Y", strtotime($res[$d]['ngayky'])); ?>" /></td>
                                    <td><input disabled type="text" style="width: 70px;" data-date-format="dd/mm/yyyy" class="form-group date-picker ngayhethan endDatess" name="ngay_hethan[]" value="<?php echo date("d/m/Y", strtotime($res[$d]['ngayhethan'])); ?>" /></td>
                                    <td>
                                        <?php
                                        $datetime1 = date_create($res[$d]['ngayky']);
                                        $datetime2 = date_create($res[$d]['ngayhethan']);
                                        $interval = date_diff($datetime1, $datetime2);
                                        $songay = $interval->format('%R %a ngày') . "\n";
                                        ?>
                                        <input type="hidden" style="width: 90px;display: block;float: left;" class="thoihan_hd" name="thoihan[]" value="<?php echo $songay ?>" />
                                        <input type="text" disabled style="width: 90px;display: block;float: left;" class="thoihan" name="" value="<?php echo $songay ?>" />
                                    </td>
                                    <td><input disabled type="text" style="width: 90px;display: block;float: left;" class="" name="sotien[]" value="<?php echo $res[$d]['sotien'] ?>" /></td>
                                    <td><textarea disabled class="" name="ghichu[]"><?php echo $res[$d]['ghichu'] ?></textarea></td>
                                    <!-- <td style="vertical-align: middle;min-width: 97px;">            
                                <button style="margin-top:0px;<?php echo $tphan['id_hopdong'] == $res[$d]['id'] ? "" : "display:none" ?>" data-array_id="" data-sogiayphep="<?php echo $tphan['sogiayphep'] ?>" data-giayphep_id="<?php echo $tphan['id_giayphep'] ?>" data-stt="<?php echo ($i + 1) ?>" data-id="" data-dongbao_id="" class="btn btn-success dropdown-toggle icon-plus <?php echo (int)$item['id'] > 0 ? " btn_themlan_edit" : "btn_themlan" ?>"  data-toggle="dropdown" type="button"><i class="" aria-hidden="true"></i></button>  
                                <button style="margin-top:0px;float: right;" data-array_id="" data-nam="" data-level="<?php echo $d == 0 ? 0 : 1 ?>" data-stt="<?php echo $d + 1 ?>" data-id="<?php echo $res[$d]['id'] ?>" data-dongbao_id="" class="btn btn-danger dropdown-toggle icon-remove btn_xoanam"  data-toggle="dropdown" type="button"><i class="" aria-hidden="true"></i></button>
                            </td>  -->
                                </tr>
                            <?php
                            }
                        } else { ?>
                            <tr class="themlan_<?php echo 1 . ' ' . ($i + 1) ?> thongtin id_<?php echo ($i + 1) . "" ?>">
                                <input class="form-group" type="hidden" name="lv[]" value="<?php echo ($i + 1) . "" ?>">
                                <input class="form-group" type="hidden" name="id_giayphep[]" value="<?php echo $tphan['id_giayphep'] ?>">
                                <input class="form-group" type="hidden" name="id_hopdong[]" value="<?php echo $tphan['id_hopdong'] ?>">
                                <td style="text-align: center;vertical-align: middle;"><?php echo ($i + 1) ?></td>
                                <td style="text-align: center;vertical-align: top !important;">
                                    <input class="form-group" type="hidden" name="stt[]" value="<?php echo ($i + 1) ?>">
                                    <input disabled class="form-group" style="" type="text" name="sogiayphep[]" value="<?php echo $tphan['sogiayphep'] ?>">
                                </td>
                                <td>
                                    <input type="hidden" name="cha_id[]" value="<?php echo ($i + 1) ?>" />
                                    <input type="hidden" name="form-group solan_hd_<?php echo ($i + 1) ?>" value="<?php echo  0 ?>" />
                                    <input disabled type="text" class="solan_" name="solan_[]" value="<?php echo "Bắt đầu" ?>" />
                                </td>
                                <td><input disabled type="text" style="width: 70px;" data-date-format="dd/mm/yyyy" class="form-group date-picker ngaykyhopdong" name="ngay_kyhopdong[]" value="<?php echo date("d/m/Y", strtotime($tphan['ngayky'])); ?>" /></td>
                                <td><input disabled type="text" style="width: 70px;" data-date-format="dd/mm/yyyy" class="form-group date-picker ngayhethan endDatess" name="ngay_hethan[]" value="<?php echo date("d/m/Y", strtotime($tphan['ngayhethan'])); ?>" /></td>
                                <td>
                                    <?php
                                    $datetime1 = date_create($tphan['ngayky']);
                                    $datetime2 = date_create($tphan['ngayhethan']);

                                    $interval = date_diff($datetime1, $datetime2);
                                    $songay = $interval->format('%R %a ngày') . "\n";
                                    ?>
                                    <input type="hidden" style="width: 90px;display: block;float: left;" class="thoihan_hd" name="thoihan[]" value="<?php echo $songay ?>" />
                                    <input type="text" disabled style="width: 90px;display: block;float: left;" class="thoihan" name="" value="<?php echo $songay ?>" />
                                </td>
                                <td><input disabled type="text" style="width: 90px;display: block;float: left;" class="" name="sotien[]" value="<?php echo $tphan['sotien'] ?>" /></td>
                                <td><textarea disabled class="" name="ghichu[]"><?php echo $tphan['ghichu'] ?></textarea></td>
                                <!-- <td style="vertical-align: middle;min-width: 97px;">            
                                <button style="margin-top:0px;" data-array_id="" data-sogiayphep="<?php echo $tphan['sogiayphep'] ?>" data-giayphep_id="<?php echo $tphan['id_giayphep'] ?>" data-stt="<?php echo ($i + 1) ?>" data-id="" data-dongbao_id="" class="btn btn-success dropdown-toggle icon-plus <?php echo (int)$item['id'] > 0 ? " btn_themlan_edit" : "btn_themlan" ?>"  data-toggle="dropdown" type="button"><i class="" aria-hidden="true"></i></button>  
                                <button style="margin-top:0px;float: right;" data-array_id="" data-nam="" data-level="0" data-stt="<?php echo $i + 1 ?>" data-id="<?php echo $tphan['id'] ?>" data-dongbao_id="" class="btn btn-danger dropdown-toggle icon-remove btn_xoanam"  data-toggle="dropdown" type="button"><i class="" aria-hidden="true"></i></button>
                            </td>  -->
                            </tr>
                        <?php
                        }
                        ?>

                    <?php
                    }
                } else { ?>
                    <tr class="themlan_1 1 thongtin id_1">
                        <input class="form-group" type="hidden" name="lv[]" value="1">
                        <input class="form-group" type="hidden" name="id_giayphep[]" value="">
                        <input class="form-group" type="hidden" name="id_hopdong[]" value="">
                        <td style="text-align: center;vertical-align: middle;">1</td>
                        <td>
                            <input class="form-group" type="hidden" name="stt[]" value="1">
                            <input class="form-group" type="text" name="sogiayphep[]" value="">
                        </td>
                        <td>
                            <input type="hidden" name="cha_id[]" value="1" />
                            <input type="hidden" name="solan[gp_1][]" value="0" />
                            <input disabled type="text" name="solan[]" value="Bắt đầu" />
                        </td>
                        <td><input type="text" style="width: 70px;" autocomplete="off" data-date-format="dd/mm/yyyy" class="form-group date-picker ngaykyhopdong" name="ngay_kyhopdong[]" value="" /></td>
                        <td><input type="text" style="width: 70px;" autocomplete="off" data-date-format="dd/mm/yyyy" class="form-group date-picker ngayhethan endDatess" name="ngay_hethan[]" value="" /></td>
                        <td>
                            <input type="hidden" style="width: 90px;display: block;float: left;" class="thoihan_hd" name="thoihan[]" value="" />
                            <input type="text" disabled style="width: 90px;display: block;float: left;" class="thoihan" name="" value="" />
                        </td>
                        <td><input type="text" style="width: 90px;display: block;float: left;" class="" name="sotien[]" value="" /></td>
                        <!-- <td><input type="text" class="tinhtrang" name="tinhtrang[]" value="" /></td> -->
                        <td><textarea class="" name="ghichu[]"></textarea></td>
                        <td style="vertical-align: middle;/* text-align: center; */min-width: 97px;">
                            <button style="margin-top:0px;" data-array_id="" data-nam="" data-stt="<?php echo $iss + 1 ?>" data-id="" data-dongbao_id="" class="btn btn-success dropdown-toggle icon-plus btn_themlan" data-toggle="dropdown" type="button"><i class="" aria-hidden="true"></i></button>
                            <button style="margin-top:0px;float: right;" data-array_id="" data-nam="" data-stt="<?php echo $iss + 1 ?>" data-id="" data-dongbao_id="" class="btn btn-danger dropdown-toggle icon-remove btn_xoanam" data-toggle="dropdown" type="button"><i class="" aria-hidden="true"></i></button>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>

    <table style="width:100%;">
        <tr>
            <!-- <td class="center">
        <span id="btn_luu" class="btn btn-info" style="width:110px;font-size:18px;"><i class="icon-save"></i> Lưu</span>
    </td> -->
        </tr>
    </table>
    <input type="hidden" id="id" name="id_khachhang" value="<?php echo $item['id']; ?>" />
    <?php echo JHTML::_('form.token'); ?>
</form>
<script type="text/javascript">
    let saveThanhphan = function(giayphep_id) {
        let rs = true;
        let gpId = giayphep_id;
        jQuery.ajax({
            type: 'post',
            data: jQuery('#frmViaHe').serialize(),
            url: 'index.php?option=com_dcxddtmt&controller=viahe&task=saveThanhphan&format=raw&id_giayphepsss=' + gpId,
            success: function(data) {
                rs = data;
                jQuery('.id_hopdong_' + gpId).val(rs);
                jQuery('#btn_' + gpId).attr("data-id", rs);
            },
            error: function() {
                rs = false;

            }
        });
        return rs;
    }
    jQuery(document).ready(function($) {
        $('table.tableFixHead').css('max-width', $('#tblThongtin').width() + 'px');
        $('table.tableFixHead').on('scroll', function() {
            $("table.tableFixHead > *").width($("table.tableFixHead").width() + $("table.tableFixHead").scrollLeft());
        });
        $('input[name="sogiayphep[]"]').on('keyup', function(e) {
            console.log($(this).data('giayphep_id'));
            $('.sgp_' + $(this).data('giayphep_id')).val($(this).val())
        }).bind('paste', function(e) {
            var v = e.originalEvent.clipboardData.getData('Text');

            $('.sgp_' + $(this).data('giayphep_id')).val(v)
        });

        $('.btn_themlan_edit').on('click', function() {
            var id = $(this).data('stt');
            var giayphep_id = jQuery(this).data('giayphep_id');
            var sogiayphep = jQuery(this).data('sogiayphep');
            var stt = $('.' + id + '').length;
            var stt_edit = $('.' + id + '').length;
            console.log('.themlan_' + (stt_edit) + '.' + id);
            var str = '';
            str += '<tr class="themlan_' + (stt_edit + 1) + ' ' + id + '"  style="width: 100%;">';
            str += '    <input class="form-group" type="hidden" name="id_giayphep[]" value="' + giayphep_id + '">';
            str += '    <input class="form-group id_hopdong_' + giayphep_id + '" type="hidden" name="id_hopdong[]" value="">';
            str += '    <td style="text-align: center;vertical-align: middle;">' + id + "." + (stt_edit) + '</td>';
            str += '    <input class="form-group" type="hidden" name="stts[' + id + '][]" value="' + id + "." + (stt_edit) + '">';
            str += '    <td><input class="form-group" type="hidden" name="stt[]" value="' + id + "." + (stt_edit) + '"><input class="form-group sgp_' + giayphep_id + '" type="hidden" name="sogiayphep[]" value=""></td>';

            str += '    <td>';
            str += '    <input class="form-group"  name="cha_id[]" type="hidden"  value="' + id + '">';
            str += '    <input class="form-group solan_hd_' + stt_edit + '"  name="solan[gp_' + id + '][]" type="hidden"  value="">';
            str += '    <input disabled type="text" name="solan_[]" class="form-group solan_' + stt_edit + '" value="" />';
            str += '    </td>';
            str += '    <td><input type="text" style="width: 70px;" data-date-format="dd/mm/yyyy" class="form-group date-picker ngaykyhopdong" name="ngay_kyhopdong[]" value="" /></td>';
            str += '    <td><input type="text" style="width: 70px;" data-date-format="dd/mm/yyyy" class="form-group date-picker ngayhethan endDatess" name="ngay_hethan[]" value="" /></td>';
            str += '    <td>';
            str += '    <input class="thoihan_hd" type="hidden"  name="thoihan[gp_' + id + '][]" value="">';
            str += '    <input disabled type="text" style="width: 90px;display: block;float: left;" class="thoihan" name="thoihan[]" value="" />';
            str += '    </td>';
            str += '    <td><input type="text" style="width: 90px;display: block;float: left;" class="" name="sotien[]" value="" /></td>';
            str += '    <td><textarea  class="form-group" name="ghichu[]" ></textarea></td>';
            str += '    <td style="vertical-align: middle;text-align: center;">';
            str += '        <button style="margin-top:0px; float: right;" id="btn_' + giayphep_id + '" data-array_id="" data-nam="" data-stt="' + (stt + 1) + '" data-id="" data-dongbao_id="" class="btn btn-danger dropdown-toggle icon-remove btn_xoanam" data-toggle="dropdown" type="button"><i class="" aria-hidden="true"></i></button>';
            str += '    </td> ';
            str += '</tr>';
            // $('#tbdThongTin').append(str);
            // $(str).insertAfter('.id_'+(id)+'');
            $.when(saveThanhphan(giayphep_id)).done(function() {
                if (stt_edit === 1) {
                    $(str).insertAfter('.themlan_' + (stt_edit) + '.' + id);
                } else {
                    $(str).insertAfter('.themlan_' + (stt_edit) + '.' + id);
                }
                let dem = 0
                $('.sgp_' + giayphep_id).val(sogiayphep);
                $('.solan_' + stt_edit + '').val("Lần " + (stt_edit));
                $('.solan_hd_' + stt_edit + '').val(stt_edit);
            });
            const d = new Date();
            let year = d.getFullYear();
            $('.date-picker').datepicker({
                startDate: "01/01/1900",
                endDate: "01/01/3000"
            }).next().on(ace.click_event, function() {
                $(this).prev().focus();
            });
        });
        $('#btn_themthongtin_edit').on('click', function() {
            var stt = $('.thongtin').length;
            var h = 0;
            var str = '';
            str += '<tr class="themlan_' + (h + 1) + ' ' + (stt + 1) + ' thongtin id_' + (stt + 1) + '"  style="width: 100%;">';
            str += '    <input class="form-group" type="hidden" name="id_giayphep[]" value="">';
            str += '    <input class="form-group" type="hidden" name="id_hopdong[]" value="">';
            str += '    <td style="text-align: center;vertical-align: middle;">' + (stt + 1) + '</td>';
            str += '    <td><input class="form-group" type="hidden" name="stt[]" value="' + (stt + 1) + '"><input class="form-group" type="text" name="sogiayphep[]" value=""></td>';
            str += '    <input class="form-group"  name="cha_id[]" type="hidden"  value="' + (stt + 1) + '">';
            str += '    <td><input type="hidden" name="solan[gp_' + (stt + 1) + '][]" class="form-group" value="0" /><input disabled type="text" name="solan[]" class="form-group" value="Bắt đầu" /></td>';
            str += '    <td><input type="text" style="width: 70px;" data-date-format="dd/mm/yyyy" class="form-group date-picker ngaykyhopdong" name="ngay_kyhopdong[]" value="" /></td>';
            str += '    <td><input type="text" style="width: 70px;" data-date-format="dd/mm/yyyy" class="form-group date-picker ngayhethan endDatess" name="ngay_hethan[]" value="" /></td>';
            str += '    <td><input disabled type="hidden" style="width: 90px;display: block;float: left;" class="thoihan_hd" name="thoihan[]" value="" /><input disabled type="text" style="width: 90px;display: block;float: left;" class="thoihan" name="thoihan[]" value="" /></td>';
            str += '    <td><input type="text" style="width: 90px;display: block;float: left;" class="" name="sotien[]" value="" /></td>';
            // str += '    <td><input type="text" class="form-group tinhtrang" name="tinhtrang[]" /></td>';
            str += '    <td><textarea  class="form-group" name="ghichu[]" ></textarea></td>';
            str += '    <td style="vertical-align: middle;/* text-align: center; */min-width: 97px;">';
            str += '        <button style="margin-top:0px;" data-array_id="" data-nam="" data-stt="' + (stt + 1) + '" data-id="" data-dongbao_id="" class="btn btn-success dropdown-toggle icon-plus btn_themlan" data-toggle="dropdown" type="button"><i class="" aria-hidden="true"></i></button>';
            str += '        <button style="margin-top:0px; float: right;" data-array_id="" data-nam="" data-stt="1" data-id="" data-dongbao_id="" class="btn btn-danger dropdown-toggle icon-remove btn_xoanam" data-toggle="dropdown" type="button"><i class="" aria-hidden="true"></i></button>';
            str += '    </td> ';
            str += '</tr>';

            $('#tbdThongTin').append(str);
            const d = new Date();
            let year = d.getFullYear();
            $('.date-picker').datepicker({
                startDate: "01/01/1900",
                endDate: "01/01/3000"
            }).next().on(ace.click_event, function() {
                $(this).prev().focus();
            });

        });
        $('.date-picker').datepicker({
            startDate: "01/01/1900",
            endDate: "01/01/3000"
        }).next().on(ace.click_event, function() {
            $(this).prev().focus();
        });

        function formatRepo(repo) {
            if (repo.loading) {
                return repo.text;
            }
            var $container = $(
                "<div class='select2-result-repository clearfix'>" +
                "<div class='select2-result-repository__meta'>" +
                "<div class='select2-result-repository__hoten'></div>" +
                "<div class='select2-result-repository__diachi'></div>" +
                "<div class='select2-result-repository__cccd_so'></div>" +
                "<div class='select2-result-repository__dienthoai'></div>" +
                "</div>" +
                "</div>"
            );
            $container.find(".select2-result-repository__hoten").text(repo.hoten + ' (' + repo.tengioitinh + ')');
            $container.find(".select2-result-repository__diachi").text(repo.diachi + '- ' + repo.phuongxa);
            $container.find(".select2-result-repository__cccd_so").text(repo.cccd_so);
            var dienthoai = "";
            if (repo.dienthoai != null) {
                dienthoai = repo.dienthoai;
            }
            $container.find(".select2-result-repository__dienthoai").text(dienthoai);
            return $container;
        };

        function formatRepoSelection(item) {
            return item.hoten || item.text;
        };

        $("#nhankhau_select_id").select2({
            allowClear: true,
            ajax: {
                url: 'index.php?option=com_dcxddtmt&controller=ajax&task=getNhanKhau',
                dataType: 'json',
                delay: 200,
                data: function(params) {
                    return {
                        q: params.term, // search term
                        page: params.page
                    };
                },
                processResults: function(data, params) {
                    params.page = params.page || 1;
                    return {
                        results: data,
                        pagination: {
                            more: (params.page * 30) < data.total_count
                        }
                    };
                },
                cache: true
            },
            placeholder: "Nhập họ tên và chọn công dân",
            minimumInputLength: 3,
            width: '100%',
            height: "34px",
            templateResult: formatRepo,
            templateSelection: formatRepoSelection,
        }).on("select2:select", function(e) {
            //$.get('index.php', {option:'com_vptk',controller:'ajax',task:'getThongTinNhanKhau',nhankhau_id:e.val}, function(data){
            var selected = e.params.data;
            console.log(selected);
            if (selected != undefined) {
                $('#gioitinh').val(selected.tengioitinh);
                $('#ngaysinh').val(selected.ngaysinh);
                $('#cccd_so').val(selected.cccd_so);
                $('#dienthoai').val(selected.dienthoai);
                $('#dantoc').val(selected.tendantoc);
                $('#tongiao').val(selected.tentongiao);
                $('#diachi').val(selected.diachi);
                $('#phuongxa_id').val(selected.phuongxa_id);
                $('#thonto_id').val(selected.thonto_id);
                $('#nhankhau_id').val(selected.id);
                $('#nhankhau_select_id').val(selected.id);

            }
        });
        let saveGiayphep = function() {
            let rs = true;
            jQuery.ajax({
                type: 'post',
                data: jQuery('#frmViaHe').serialize(),
                url: 'index.php?option=com_caicachhanhchinh&controller=viahe&task=saveGiayphep&format=raw',
                success: function(data) {
                    rs = data;
                },
                error: function() {
                    rs = false;
                }
            });
            return rs;
        }
        $('#btn_themthongtin').on('click', function() {
            var stt = $('.thongtin').length;
            var h = 0;
            console.log(stt);
            var str = '';
            str += '<tr class="themlan_' + (h + 1) + ' ' + (stt + 1) + ' thongtin id_' + (stt + 1) + '"  style="width: 100%;">';
            str += '    <input class="form-group" type="hidden" name="id_giayphep[]" value="">';
            str += '    <input class="form-group" type="hidden" name="id_hopdong[]" value="">';
            str += '    <td style="text-align: center;vertical-align: middle;">' + (stt + 1) + '</td>';
            str += '    <td><input class="form-group" type="hidden" name="stt[]" value="' + (stt + 1) + '"><input class="form-group" type="text" name="sogiayphep[]" value=""></td>';
            str += '    <input class="form-group"  name="cha_id[]" type="hidden"  value="' + (stt + 1) + '">';
            str += '    <td><input type="hidden" name="solan[gp_' + (stt + 1) + '][]" class="form-group" value="0" /><input disabled type="text" name="solan[]" class="form-group" value="Bắt đầu" /></td>';
            str += '    <td><input type="text" style="width: 70px;" data-date-format="dd/mm/yyyy" class="form-group date-picker ngaykyhopdong" name="ngay_kyhopdong[]" value="" /></td>';
            str += '    <td><input type="text" style="width: 70px;" data-date-format="dd/mm/yyyy" class="form-group date-picker ngayhethan endDatess" name="ngay_hethan[]" value="" /></td>';
            str += '    <td><input disabled type="hidden" style="width: 90px;display: block;float: left;" class="thoihan_hd" name="thoihan[]" value="" /><input disabled type="text" style="width: 90px;display: block;float: left;" class="thoihan" name="thoihan[]" value="" /></td>';
            str += '    <td><input type="text" style="width: 90px;display: block;float: left;" class="" name="sotien[]" value="" /></td>';
            // str += '    <td><input type="text" class="form-group tinhtrang" name="tinhtrang[]" /></td>';
            str += '    <td><textarea  class="form-group" name="ghichu[]" ></textarea></td>';
            str += '    <td style="vertical-align: middle;/* text-align: center; */min-width: 97px;">';
            str += '        <button style="margin-top:0px;" data-array_id="" data-nam="" data-stt="' + (stt + 1) + '" data-id="" data-dongbao_id="" class="btn btn-success dropdown-toggle icon-plus btn_themlan" data-toggle="dropdown" type="button"><i class="" aria-hidden="true"></i></button>';
            str += '        <button style="margin-top:0px; float: right;" data-array_id="" data-nam="" data-stt="1" data-id="" data-dongbao_id="" class="btn btn-danger dropdown-toggle icon-remove btn_xoanam" data-toggle="dropdown" type="button"><i class="" aria-hidden="true"></i></button>';
            str += '    </td> ';
            str += '</tr>';

            $.when(saveGiayphep()).done(function() {
                $('#tbdThongTin').append(str);
            });
            const d = new Date();
            let year = d.getFullYear();
            $('.date-picker').datepicker({
                startDate: "01/01/1900",
                endDate: "01/01/3000"
            }).next().on(ace.click_event, function() {
                $(this).prev().focus();
            });

        });
        $('body').delegate('.btn_themlan', 'click', function() {
            var id = $(this).data('stt');
            var stt = $('.' + id + '').length;
            var stt_edit = $('.' + id + '').length;
            console.log('.themlan_' + (stt_edit) + '.' + id);
            // var stt = $('#tbdThongTin').children('tr').length;
            var str = '';
            str += '<tr class="themlan_' + (stt_edit + 1) + ' ' + id + '"  style="width: 100%;">';
            str += '    <input class="form-group" type="hidden" name="id_hopdong[]" value="">';
            str += '    <td style="text-align: center;vertical-align: middle;">' + id + "." + (stt_edit) + '</td>';
            // str += '    <td><input class="form-group" type="text" name="sogiayphep[]" value=""></td>';
            str += '<input class="form-group" type="hidden" name="stts[' + id + '][]" value="' + id + "." + (stt_edit) + '">';
            str += '    <td><input class="form-group" type="hidden" name="stt[]" value="' + id + "." + (stt_edit) + '"><input class="form-group" type="hidden" name="sogiayphep_[]" value=""></td>';

            str += '    <td>';
            str += '    <input class="form-group"  name="cha_id[]" type="hidden"  value="' + id + '">';
            str += '    <input class="form-group solan_hd_' + stt_edit + '"  name="solan[gp_' + id + '][]" type="hidden"  value="">';
            str += '    <input disabled type="text" name="solan_[]" class="form-group solan_' + stt_edit + '" value="" />';
            str += '    </td>';
            str += '    <td><input type="text" style="width: 70px;" data-date-format="dd/mm/yyyy" class="form-group date-picker ngaykyhopdong" name="ngay_kyhopdong[]" value="" /></td>';
            str += '    <td><input type="text" style="width: 70px;" data-date-format="dd/mm/yyyy" class="form-group date-picker ngayhethan endDatess" name="ngay_hethan[]" value="" /></td>';
            str += '    <td>';
            str += '    <input class="thoihan_hd" type="hidden"  name="thoihan[gp_' + id + '][]" value="">';
            str += '    <input disabled type="text" style="width: 90px;display: block;float: left;" class="thoihan" name="thoihan[]" value="" />';
            str += '    </td>';
            str += '    <td><input type="text" style="width: 90px;display: block;float: left;" class="" name="sotien[]" value="" /></td>';
            // str += '    <td><input type="text" class="form-group tinhtrang" name="tinhtrang[]" /></td>';
            str += '    <td><textarea  class="form-group" name="ghichu[]" ></textarea></td>';
            str += '    <td style="vertical-align: middle;text-align: center;">';
            str += '        <button style="margin-top:0px; float: right;" data-array_id="" data-nam="" data-stt="' + (stt + 1) + '" data-id="" data-dongbao_id="" class="btn btn-danger dropdown-toggle icon-remove btn_xoanam" data-toggle="dropdown" type="button"><i class="" aria-hidden="true"></i></button>';
            str += '    </td> ';
            str += '</tr>';
            // $('#tbdThongTin').append(str);
            // $(str).insertAfter('.id_'+(id)+'');

            if (stt_edit === 1) {
                $(str).insertAfter('.themlan_' + (stt_edit) + '.' + id);
            } else {
                $(str).insertAfter('.themlan_' + (stt_edit) + '.' + id);
            }
            let dem = 0

            // for (let index = 0; index < $('.themlan_'+id+'').length; index++) {
            //     const element = $('.themlan_'+id+'')[index];
            //     const solan_hd = $('.solan_hd_'+id+'')[index];
            //     const solan = $('.solan_'+id+'')[index];
            //     $(element).children('td:first-child').html(id+"."+(index+1));
            //     $(solan_hd).val((index+1));
            //     $(solan).val("Lần "+(stt_edit));
            // }
            $('.solan_' + stt_edit + '').val("Lần " + (stt_edit));
            $('.solan_hd_' + stt_edit + '').val(stt_edit);
            const d = new Date();
            let year = d.getFullYear();
            $('.date-picker').datepicker({
                startDate: "01/01/1900",
                endDate: "01/01/3000"
            }).next().on(ace.click_event, function() {
                $(this).prev().focus();
            });

        });

        // $('#tblDanhsach').rowspanizer({
        // 		columns: [1],
        // 		vertical_align: 'top'

        // });

        $('body').delegate('.ngayhethan', 'change', function() {
            var id = $('.ngayhethan').index($(this));
            console.log(id);
            var startDate = $('.ngaykyhopdong').eq(id).val();
            var endDate = $('.ngayhethan').eq(id).val();
            var toDate = new Date();

            var start = new Date(startDate.split('/')[2], startDate.split('/')[1] - 1, startDate.split('/')[0]);
            var end = new Date(endDate.split('/')[2], endDate.split('/')[1] - 1, endDate.split('/')[0]);

            var timeDiff = Math.abs(end.getTime() - start.getTime());
            var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));
            var tinhtrang = Math.abs(toDate.getTime() - start.getTime());
            var diffDaysTinhtrang = Math.round(tinhtrang / (1000 * 3600 * 24));
            if (diffDays - diffDaysTinhtrang <= 0) {
                $('.tinhtrang').eq(id).val('Hết hạn');
            } else if (diffDays - diffDaysTinhtrang <= 5) {
                $('.tinhtrang').eq(id).val('Gần đến hạn');
            } else {
                $('.tinhtrang').eq(id).val('Còn hạn');
            };
            console.log(diffDays);
            if (diffDays < 0) {
                loadNoticeBoardError('Thông báo', 'Ngày ký hợp đồng phải nhỏ hơn ngày hết hạn');
                $('.thoihan').eq(id).val();
            } else {
                $('.thoihan').eq(id).val("+ " + diffDays + " ngày");
                $('.thoihan_hd').eq(id).val(diffDays);
            };

        });

        var compareDate = function(dateStart, dateEnd) {
            if (dateStart != '' && dateEnd != '') {
                var arrDateStart = dateStart.split('/', 3);
                var arrDateEnd = dateEnd.split('/', 3);
                var numberStart = parseInt(arrDateStart[2] + arrDateStart[1] + arrDateStart[0]);
                var numberEnd = parseInt(arrDateEnd[2] + arrDateEnd[1] + arrDateEnd[0]);
                if (numberStart < numberEnd) {
                    return -1;
                } else if (numberStart == numberEnd) {
                    return 0;
                } else {
                    return 1;
                }
            } else {
                return -1;
            }
        };

        $.validator.addMethod("endDatess", function(value, element) {
            var row_index = $('.endDatess').index($(element));
            var tungay = $('.ngaykyhopdong').eq(row_index);
            var denngay = $('.ngayhethan').eq(row_index);
            if (tungay.val() != '' && denngay.val() != '') {
                if (compareDate(tungay.val(), denngay.val()) == -1) {
                    denngay.addClass('valid').removeClass('error');
                    return true;
                } else {
                    denngay.addClass('error').removeClass('valid');
                    return false;
                }
            } else {
                denngay.addClass('valid').removeClass('error');
                return true;
            }
        }, "Từ ngày phải nhỏ hơn đến ngày.");

        $.validator.addMethod("endDatess1", function(value, element) {
            var id = $('.endDatess1').index($(this));
            var startDate = $('.ngaykyhopdong').eq(id).val();
            var endDate = $('.ngayhethan').eq(id).val();
            var diff = new Date(endDate - startDate);

            // get days
            var days = diff / 1000 / 60 / 60 / 24;
            console.log(days)
            // if(Date.parse(startDate) <= Date.parse(endDate) == true){
            //     $('.ngayhethan').eq(id).addClass('valid').removeClass('error');
            //     return true;
            // }else{
            //     $('.ngayhethan').eq(id).addClass('valid').removeClass('error');
            //     return false;
            // }
            //console.log(Date.parse(startDate) + " " + Date.parse(endDate))
            return Date.parse(startDate) <= Date.parse(endDate) || value == "";
        }, "Ngày hết hạn ký phải lớn hơn ngày ký hợp đồng");

        $('#frmViaHe').validate({
            ignore: true,
            invalidHandler: function(form, validator) {
                var errors = validator.numberOfInvalids();

                if (errors) {
                    var message = errors == 1 ?
                        'Kiểm tra lỗi sau:<br/>' :
                        'Phát hiện ' + errors + ' lỗi sau:<br/>';
                    var errors = "";
                    if (validator.errorList.length > 0) {
                        for (x = 0; x < validator.errorList.length; x++) {
                            errors += "<br/>\u25CF " + validator.errorList[x].message;
                        }
                    }
                    loadNoticeBoardError('Thông báo', message + errors);
                }
                validator.focusInvalid();
            },
            errorPlacement: function(error, element) {},
            rules: {
                "tenkhachhang": {
                    required: true
                },
                "sodienthoai": {
                    required: true
                },
                "diachi": {
                    required: true
                },
                "dientich": {
                    required: true
                },
                "chieudai": {
                    required: true
                },
                "chieurong": {
                    required: true
                },
                "mucdich": {
                    required: true
                },
                "sogiayphep[]": {
                    required: function(element) {
                        var row_index = $('input[name="sogiayphep[]"]').index($(element));
                        if ($('input[name="sogiayphep[]"]').eq(row_index).val() == '' || $('input[name="sogiayphep[]"]').eq(row_index).val() == null) {
                            return true;
                        } else {
                            return false;
                        }
                    }
                },
                "ngay_kyhopdong[]": {
                    required: function(element) {
                        var row_index = $('input[name="ngay_kyhopdong[]"]').index($(element));
                        if ($('input[name="ngay_kyhopdong[]"]').eq(row_index).val() === "" || $('input[name="ngay_kyhopdong[]"]').eq(row_index).val() === null) {
                            return true;
                        } else {
                            return false;
                        }
                    }
                },
                "ngay_hethan[]": {
                    required: function(element) {
                        var row_index = $('input[name="ngay_hethan[]"]').index($(element));
                        if ($('input[name="ngay_hethan[]"]').eq(row_index).val() == '' || $('input[name="ngay_hethan[]"]').eq(row_index).val() == null) {
                            return true;
                        } else {
                            return false;
                        }
                    },
                }
            },
            messages: {
                "tenkhachhang": {
                    required: 'Nhập họ tên'
                },
                "sodienthoai": {
                    required: 'Nhập số điện thoai'
                },
                "diachi": {
                    required: 'Nhập địa chỉ'
                },
                "dientich": {
                    required: 'Nhập diện tích'
                },
                "chieudai": {
                    required: 'Nhập chiều dài'
                },
                "chieurong": {
                    required: 'Nhập chiều rộng'
                },
                "mucdich": {
                    required: 'Nhập mục đích'
                },
                "sogiayphep[]": {
                    required: 'Nhập số giấy phép'
                },
                "ngay_kyhopdong[]": {
                    required: 'Nhập ngày ký hợp đồng'
                },
                "ngay_hethan[]": {
                    required: 'Nhập ngày hết hạn'
                }
            },
            highlight: function(e) {
                $(e).closest('.form-group').removeClass('has-info').addClass('has-error');
            },
            success: function(e) {
                $(e).closest('.form-group').removeClass('has-error');
            }
        });
        $('#btn_luu').on('click', function() {
            if ($('#frmViaHe').valid()) {
                document.frmViaHe.submit();
            }
            return false;
        });

        $('#btn_quaylai').on('click', function() {
            window.location.href = 'index.php?option=com_dcxddtmt&controller=viahe&task=default';
        });

        $('body').delegate('.btn_xoanam', 'click', function() {
            var row_index = $('.btn_xoanam').index($(this));
            console.log($('.btn_xoanam').eq(row_index).data('id'));
            if ($('.btn_xoanam').eq(row_index).data('id') != "") {
                bootbox.confirm({
                    title: "<span class='red' style='font-weight:bold;font-size:20px;'>Thông báo</span>",
                    message: '<span class="red" style="font-size:24px;">Bạn có chắc chắn muốn xóa thông tin này khỏi danh sách?</span>',
                    buttons: {
                        confirm: {
                            label: '<i class="icon-ok"></i> Đồng ý',
                            className: 'btn-success'
                        },
                        cancel: {
                            label: '<i class="icon-remove"></i> Không',
                            className: 'btn-danger'
                        }
                    },
                    callback: function(result) {
                        if (result) {
                            $.post('index.php', {
                                option: 'com_dcxddtmt',
                                controller: 'viahe',
                                task: 'removeThanhphan',
                                id_giayphep: $('.btn_xoanam').eq(row_index).data('id'),
                                level: $('.btn_xoanam').eq(row_index).data('level')
                            }, function(data) {
                                if (data == '1') {
                                    $('.btn_xoanam').eq(row_index).closest('tr').remove();
                                    $.gritter.add({
                                        title: '<h3>Thông báo</h3>',
                                        text: '<span style="font-size:24px;">Đã xử lý xóa dữ liệu thành công!</span>',
                                        time: '1000',
                                        class_name: 'gritter-success gritter-center gritter-light'
                                    });
                                } else {
                                    $.gritter.add({
                                        title: '<h3>Thông báo</h3>',
                                        text: '<span style="font-size:24px;">Có lỗi xảy ra!!! Vui lòng liên hệ quản trị viên.</span>',
                                        time: '1000',
                                        class_name: 'gritter-error gritter-center gritter-light'
                                    });
                                }

                            });
                        }
                    }
                });
            } else {
                $('.btn_xoanam').eq(row_index).closest('tr').remove();

            }
        });

        $('.hinhanh').on('click', function() {
            var modal = document.getElementById("myModal");
            modal.style.display = "block";
            var modalImg = document.getElementsByClassName("mdhinhanh");
            $('.mdhinhanh').attr('src', $(this).attr('src'))
            var captionText = document.getElementById("caption");
            captionText.innerHTML = this.alt;
        });
        $('.close').on('click', function() {
            var modal = document.getElementById("myModal");
            modal.style.display = "none";

        });


    });
</script>
<style>
    input {
        color: black !important;
    }

    table.tableFixHead {
        border-collapse: collapse;
        max-width: 1009px;
        overflow-x: scroll;
        display: block;
    }

    table.tableFixHead thead {
        background-color: #027be3;
    }

    #tblThongtin strong {
        font-size: 14px !important;
    }

    .select2-container .select2-selection--single {
        border-radius: 0px !important;
        height: 40px !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 40px !important;
    }

    .onerow {
        width: 96% !important;
    }

    .input-append {
        width: 99% !important;
    }

    input[name='sonha[]'],
    input[name='thuadat_so[]'],
    input[name='tobando_so[]'] {
        width: 100px;
    }

    textarea,
    input[type='text'] {
        height: 35px;
        margin-bottom: 0px;
        color: black !important;
    }

    select[name='trangthai[]'] {
        height: 45px;
        margin-bottom: 0px;
        width: 160px;
    }

    .control-group input[disabled],
    .control-group input:disabled {
        color: black !important;
    }

    select[name='lydothaydoi[]'] {
        height: 45px;
        margin-bottom: 0px;
    }

    strong {
        font-size: 14px;
    }

    .select2-container .select2-choice {
        height: 34px !important;
    }

    .select2-container .select2-choice .select2-chosen {
        height: 34px !important;
        padding: 5px 0 0 5px !important;
    }

    /* Style the Image Used to Trigger the Modal */
    #myImg {
        border-radius: 5px;
        cursor: pointer;
        transition: 0.3s;
    }

    #myImg:hover {
        opacity: 0.7;
    }

    /* The Modal (background) */
    .modal2 {
        display: none;
        /* Hidden by default */
        position: fixed;
        /* Stay in place */
        z-index: 1;
        /* Sit on top */
        padding-top: 100px;
        /* Location of the box */
        left: 0;
        top: 0;
        width: 100%;
        /* Full width */
        height: 100%;
        /* Full height */
        overflow: auto;
        /* Enable scroll if needed */
        background-color: rgb(0, 0, 0);
        /* Fallback color */
        background-color: rgba(0, 0, 0, 0.9);
        /* Black w/ opacity */
    }

    /* Modal Content (Image) */
    .modal-content {
        margin: auto;
        display: block;
        width: 80%;
        max-width: 700px;
    }

    /* Caption of Modal Image (Image Text) - Same Width as the Image */
    #caption {
        margin: auto;
        display: block;
        width: 80%;
        max-width: 700px;
        text-align: center;
        color: #ccc;
        padding: 10px 0;
        height: 150px;
    }

    /* Add Animation - Zoom in the Modal */
    .modal-content,
    #caption {
        animation-name: zoom;
        animation-duration: 0.6s;
    }

    @keyframes zoom {
        from {
            transform: scale(0)
        }

        to {
            transform: scale(1)
        }
    }

    /* The Close Button */
    .close {
        position: absolute;
        top: 15px;
        right: 35px;
        color: #f1f1f1;
        font-size: 40px;
        font-weight: bold;
        transition: 0.3s;
        opacity: unset !important;
    }

    .close:hover,
    .close:focus {
        color: #bbb;
        text-decoration: none;
        cursor: pointer;
    }

    /* 100% Image Width on Smaller Screens */
    @media only screen and (max-width: 700px) {
        .modal-content {
            width: 100%;
        }
    }
</style>