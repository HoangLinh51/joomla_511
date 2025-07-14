<?php

use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Factory;
use Joomla\CMS\Router\Route;

defined('_JEXEC') or die('Restricted access');
?>
<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="<?php echo Uri::root(true); ?>/media/cbcc/js/bootstrap-datepicker/locales/bootstrap-datepicker.vi.min.js" type="text/javascript"></script>

<div class="danhsach" style="background-color:#fff">
  <div class="content-header">
    <div class="row mb-2">
      <div class="col-sm-8">
        <h3 class="m-0 text-primary"><i class="fas fa-users"></i> Quản lý quân nhân dự bị </h3>
      </div>
      <div class="col-sm-4 text-right" style="padding:0;">
        <a href="<?php echo Route::_('/index.php?option=com_quansu&view=quannhandubi&task=edit_quannhandubi') ?>" class="btn btn-primary" style="font-size:16px;width:136px">
          <i class="fas fa-plus"></i> Thêm mới
        </a>
      </div>
    </div>
  </div>

  <div class="card card-primary collapsed-card">
    <div class="card-header" data-card-widget="collapse">
      <h3 class="card-title"><i class="fas fa-search"></i> Tìm kiếm</h3>
      <div class="card-tools">
        <button type="button" class="btn btn-tool" data-card-widget="none" data-action="reload"><i class="fas fa-sync-alt"></i></button>
        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-chevron-up"></i></button>
      </div>
    </div>
    <div class="card-body">
      <table class="table table-borderless">
        <tr class="d-flex align-items-center">
          <td class="d-flex align-items-center w-50">
            <b class="text-primary" style="font-size:17px;line-height:2.5;text-wrap: nowrap; width: 33%">Họ tên</b>
            <input type="text" name="hoten" id="hoten" class="form-control" style="width: 67%; font-size:16px;" placeholder="Nhập họ tên" />
          </td>
          <td class="d-flex align-items-center w-50">
            <b class="text-primary" style="font-size:17px;line-height:2.5;text-wrap: nowrap; width: 33%">CCCD/CMND</b>
            <input type="text" name="cccd" id="cccd" class="form-control" style="width: 67%; font-size:16px;" placeholder="Nhập CCCD/CMND" />
          </td>
        </tr>
        <tr class="d-flex align-items-center">
          <td class="d-flex align-items-center w-50">
            <b class="text-primary" style="font-size:17px;line-height:2.5;text-wrap: nowrap; width: 33%">Giới tính</b>
            <select id="gioitinh_id" name="gioitinh_id" class="custom-select" data-placeholder="Chọn giới tính" style="width: 67%;">
              <option value=""></option>
              <?php foreach ($this->gioitinh as $gt) { ?>
                <option value="<?php echo $gt['id']; ?>"><?php echo $gt['tengioitinh']; ?></option>
              <?php } ?>
            </select>
          </td>
          <td class="d-flex align-items-center w-50">
            <b class="text-primary" style="font-size:17px;line-height:2.5;text-wrap: nowrap; width: 33%">Tình trạng</b>
            <select id="tinhtrang_id" name="tinhtrang_id" class="custom-select" data-placeholder="Chọn tình trạng" style="width: 67%;">
              <option value=""></option>
              <?php foreach ($this->trangthai as $tt) { ?>
                <option value="<?php echo $tt['id']; ?>"><?php echo $tt['tentrangthai']; ?></option>
              <?php } ?>
            </select>
          </td>
        </tr>
        <tr class="d-flex align-items-center">
          <td class="d-flex align-items-center w-50">
            <b class="text-primary" style="font-size:17px;line-height:2.5;text-wrap: nowrap; width: 33%">Phường/xã</b>
            <select id="phuongxa_id" name="phuongxa_id" class="custom-select" data-placeholder="Chọn xã/phường" style="width: 67%;">
              <option value=""></option>
              <?php foreach ($this->phuongxa as $px) { ?>
                <option value="<?php echo $px['id']; ?>"><?php echo $px['tenkhuvuc']; ?></option>
              <?php } ?>
            </select>
          </td>
          <td class="d-flex align-items-center w-50">
            <b class="text-primary" style="font-size:17px;line-height:2.5;text-wrap: nowrap; width: 33%">Thôn/tổ</b>
            <select id="thonto_id" name="thonto_id" class="custom-select" data-placeholder="Chọn thôn/tổ" style="width: 67%;">
              <option value=""></option>
            </select>
          </td>
        </tr>
        <tr>
          <td colspan="4" class="text-center" style="padding-top:10px;">
            <button class="btn btn-primary" id="btn_filter"><i class="fas fa-search"></i> Tìm kiếm</button>
          </td>
        </tr>
      </table>
    </div>
  </div>

  <div id="div_danhsach">
    <?php require_once 'ds_quannhandubi.php'; ?>
  </div>
</div>

<script>
  const csrfToken = Joomla.getOptions('csrf.token', '');

  function showToast(message, isSuccess = true) {
    const toast = $('<div></div>')
      .text(message)
      .css({
        position: 'fixed',
        top: '20px',
        right: '20px',
        background: isSuccess ? '#28a745' : '#dc3545',
        color: 'white',
        padding: '10px 20px',
        borderRadius: '5px',
        boxShadow: '0 0 10px rgba(0,0,0,0.3)',
        zIndex: 9999
      })
      .appendTo('body');

    setTimeout(() => toast.fadeOut(500, () => toast.remove()), 1000);
  }


  $(document).ready(function() {
    $('#gioitinh_id, #tinhtrang_id, #phuongxa_id, #thonto_id').select2({
      width: '67%',
      allowClear: true,
      placeholder: function() {
        return $(this).data('placeholder');
      }
    });

    $('#phuongxa_id').on('change', function() {
      if ($(this).val() == '') {
        $('#thonto_id').html('<option value=""></option>').trigger('change');
      } else {
        $.post('index.php', {
          option: 'com_quansu',
          controller: 'quannhandubi',
          task: 'getThonTobyPhuongxa',
          phuongxa_id: $('#phuongxa_id').val()
        }, function(data) {
          if (data.length > 0) {
            var str = '<option value=""></option>';
            $.each(data, function(i, v) {
              str += '<option value="' + v.id + '">' + v.tenkhuvuc + '</option>';
            });
            $('#thonto_id').html(str).trigger('change');
          }
        });
      }
    });
  });
</script>

<style>
  .danhsach {
    padding: 0px 20px;
  }

  .content-header {
    padding: 20px 8px 15px 8px
  }

  .select2-container .select2-choice {
    height: 34px !important;
  }

  .select2-container .select2-choice .select2-chosen {
    height: 34px !important;
    padding: 5px 0 0 5px !important;
  }

  .select2-container .select2-selection--single {
    height: 38px;
  }
</style>