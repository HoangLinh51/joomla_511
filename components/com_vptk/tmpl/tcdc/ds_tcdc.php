<?php
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;


?>

<div id="div_danhsach">
    <table class="table table-striped table-bordered table-hover" id="tblDanhsach">
        <thead>
            <tr class="bg-primary text-white">
                <th style="vertical-align:middle;" class="text-center">STT</th>
                <th style="vertical-align:middle;" class="text-center">Họ tên</th>
                <th style="vertical-align:middle;" class="text-center">Giới tính</th>
                <th style="vertical-align:middle;" class="text-center">Ngày sinh</th>
                <th style="vertical-align:middle;" class="text-center">CCCD/CMND</th>
                <th style="vertical-align:middle;" class="text-center">Chỗ ở hiện nay</th>
                <th style="vertical-align:middle;" class="text-center">Số điện thoại</th>
                <th style="vertical-align:middle;" class="text-center" style="width:131px;">Chức năng</th>
            </tr>
        </thead>
        <tbody id="tbody_danhsach">
            <?php $stt = 1; ?>
            <?php foreach ($this->items as $item) { ?>
                <tr class="danhsach_<?php echo $stt; ?> rp_<?php echo $item['id'] ?>">
                    <td style="vertical-align:middle;text-align: center;" rowspan=""><?php echo $stt; ?></td>
                    <td style="vertical-align:middle;" class="rp_" rowspan=""><?php echo $item['hotenchuho']; ?></td>
                    <td style="vertical-align:middle;text-align: center;" class=""><?php echo $item['tengioitinh']; ?></td>
                    <td style="vertical-align:middle;text-align: center;" class=""><?php echo $item['ngaysinh']; ?></td>
                    <td style="vertical-align:middle;text-align: center;" class=""><?php echo $item['diachi']; ?></td>
                    <td style="vertical-align:middle;text-align: center;" class=""><?php echo $item['dienthoai']; ?></td>
                    <td style="vertical-align:middle;text-align: center;" class=""><?php echo $item['cccd_so']; ?></td>
                    <td style="vertical -align:middle;  text-align: center;display:flex; justify-content: center; align-items: center; " rowspan="" class="rp_<?php //echo $stt; 
                                                                                                                                                              ?>">
                        <span class="btn btn-green btn_chitiet" data-id="<?php echo $item['id']; ?>" style="font-size:20px; margin: 0 5px;"><i class="fas fa-eye btn_eye"></i></span>
                    
                    </td>

                </tr>
                <?php $stt++; ?>
            <?php } ?>
        </tbody>
    </table>


</div>

</div>

<script type="text/javascript">
   
</script>

<style>
    .btn i {
        font-size: 18px !important;
        vertical-align: unset;
    }



    .pagination-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 1rem;
    }

    .pagination {
        display: inline-flex;
        justify-content: center;
        margin: 0;
    }

    .page-item.disabled .page-link {
        cursor: not-allowed;
        opacity: 0.5;
    }

    .page-link {
        padding: 6px 12px;
        margin: 0 2px;
    }

    .page-link:hover {
        background-color: #e9ecef;
        color: #007b8b
    }

    .pagination-info {
        font-size: 14px;
        color: #333;
        white-space: nowrap;
    }

    .btn-group .btn {
        padding: 6px 12px;
        font-size: 14px;
        line-height: 1.5;
    }

    .btn-group .btn i {
        font-size: 15px;
        vertical-align: middle;
    }

    .text-success i,
    .text-danger i {
        font-size: 15px;
        vertical-align: middle;
    }
</style>