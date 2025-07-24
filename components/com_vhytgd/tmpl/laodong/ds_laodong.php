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
      <div class="col-sm-6">
        <h3 class="m-0 text-primary"><i class="fas fa-users"></i> Quản lý thông tin lao động</h3>
      </div>
      <div class="col-sm-6 text-right" style="padding:0;">
        <a href="<?php echo Route::_('index.php?option=com_vhytgd&view=laodong&task=edit_laodong') ?>" class="btn btn-primary" style="font-size:16px;width:136px">
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
            <b class="text-primary" style="font-size:17px;line-height:2.5;text-wrap: nowrap; width: 33%">Đối tượng</b>
            <select id="doituong_id" name="doituong_id" class="custom-select" data-placeholder="Chọn đối tượng" style="width: 67%;">
              <option value=""></option>
              <?php foreach ($this->doituong as $dt) { ?>
                <option value="<?php echo $dt['id']; ?>"><?php echo $dt['tendoituong']; ?></option>
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
            <span class="btn btn-success" id="btn_xuatexcel"><i class="fas fa-file-excel"></i> Xuất excel</span>
          </td>
        </tr>
      </table>
    </div>
  </div>

  <div id="div_danhsach">
    <table class="table table-striped table-bordered table-hover" id="tblDanhsach">
      <thead>
        <tr class="bg-primary">
          <th style="vertical-align: middle" class="text-center">STT</th>
          <th style="vertical-align: middle" class="text-center">Họ và tên</th>
          <th style="vertical-align: middle" class="text-center">Đối tượng</th>
          <th style="vertical-align: middle" class="text-center">Thôn tổ</th>
          <th style="vertical-align: middle" class="text-center">Giới tính</th>
          <th style="vertical-align: middle" class="text-center">CCCD/CMND</th>
          <th style="vertical-align: middle" class="text-center">Số điện thoại</th>
          <th style="vertical-align: middle; min-width: 125px; max-width: 135px" class="text-center">Chức năng </th>
        </tr>
      </thead>
      <tbody id="tbody_danhsach">
        <tr>
          <td colspan="8" class="text-center">Đang tải dữ liệu...</td>
        </tr>
      </tbody>
    </table>
    <!-- pagination -->
    <div class="pagination-container d-flex align-items-center mt-3">
      <div id="pagination" class="mx-auto"></div>
      <div id="pagination-info" class="pagination-info text-right ml-3"></div>
    </div>
  </div>
</div>

<script>
  const idUser = <?= (int)Factory::getUser()->id ?>;
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

  function renderTextDiaChi(diachi = '', thonto = '', phuongxa = '') {
    const parts = [diachi, thonto, phuongxa].filter(part => part && part.trim() !== '');
    return parts.length > 0 ? parts.join(' - ') : '';
  }

  function renderTBody(items, start) {
    if (!items || items.length === 0) {
      return '<tr><td colspan="8" class="text-center">Không có dữ liệu</td></tr>';
    }
    return items.map((item, index) => `
      <tr>
        <td class="text-center" style="vertical-align: middle">${start + index}</td>
        <td style="vertical-align: middle">${item.n_hoten || ''}</td>
        <td style="vertical-align:middle;">${item.tendoituong || ''}</td>
        <td style="vertical-align:middle;">${renderTextDiaChi((item.n_diachi || ''), (item.thonto || ''), (item.phuongxa || ''))}</td>
        <td style="vertical-align:middle;">${item.tengioitinh || ''}</td>
        <td style="vertical-align:middle;">${item.n_cccd || ''}</td>
        <td style="vertical-align:middle;">${item.n_dienthoai || ''}</td>
        <td class="text-center" style="vertical-align: middle">
         <span class="btn btn-sm btn_hieuchinh" style="font-size:18px;padding:10px; cursor: pointer;" data-idlaodong="${item.id}" data-title="Hiệu chỉnh">
            <i class="fas fa-pencil-alt"></i>
          </span>
          <span style="padding: 0 0px;font-size:22px;color:#999">|</span>
          <span class="btn btn-sm btn_xoa" style="font-size:18px;padding:10px; cursor: pointer;" data-idlaodong="${item.id}" data-title="Xóa">
            <i class="fas fa-trash-alt"></i>
          </span>
        </td>
      </tr>
    `).join('');
  }

  function renderPagination(currentPage, totalPages, totalRecord, take) {
    let html = '<ul class="pagination">';

    // First and Previous buttons
    html += `<li class="page-item ${currentPage === 1 || totalPages <= 1 ? 'disabled' : ''}">
      <a class="page-link" href="#" data-page="1">&lt;&lt;</a>
    </li>`;
    html += `<li class="page-item ${currentPage === 1 || totalPages <= 1 ? 'disabled' : ''}">
      <a class="page-link" href="#" data-page="${Math.max(1, currentPage - 1)}">&lt;</a>
    </li>`;

    // Page numbers
    const range = 2;
    const startPage = Math.max(1, currentPage - range);
    const endPage = Math.min(totalPages, currentPage + range);

    if (totalPages > 1 && startPage > 1) {
      html += '<li class="page-item disabled"><span class="page-link">...</span></li>';
    }

    for (let i = startPage; i <= endPage; i++) {
      html += `<li class="page-item ${i === currentPage ? 'active' : ''}">
        <a class="page-link" href="#" data-page="${i}">${i}</a>
      </li>`;
    }

    if (totalPages > 1 && endPage < totalPages) {
      html += '<li class="page-item disabled"><span class="page-link">...</span></li>';
    }

    // Next and Last buttons
    html += `<li class="page-item ${currentPage === totalPages || totalPages <= 1 ? 'disabled' : ''}">
      <a class="page-link" href="#" data-page="${Math.min(totalPages, currentPage + 1)}">&gt;</a>
    </li>`;
    html += `<li class="page-item ${currentPage === totalPages || totalPages <= 1 ? 'disabled' : ''}">
      <a class="page-link" href="#" data-page="${totalPages}">&gt;&gt;</a>
    </li>`;
    html += '</ul>';

    // Pagination info
    const startRecord = (currentPage - 1) * take + 1;
    const endRecord = Math.min(startRecord + take - 1, totalRecord);
    const info = totalRecord > 0 ?
      `Hiển thị ${startRecord} - ${endRecord} của ${totalRecord} mục (${totalPages} trang)` :
      'Không có dữ liệu trang';

    return {
      pagination: html,
      info
    };
  }

  async function loadData(page = 1, filterSearch, take = 20) {
    try {
      $('#tbody_danhsach').html('<tr><td colspan="8" class="text-center">Đang tải dữ liệu...</td></tr>');
      const response = await $.ajax({
        url: 'index.php?option=com_vhytgd&controller=laodong&task=getListLaoDong',
        method: 'POST',
        data: {
          page,
          take,
          hoten: filterSearch.hoten,
          cccd: filterSearch.cccd,
          gioitinh_id: filterSearch.gioitinh_id,
          doituong_id: filterSearch.doituong_id,
          phuongxa_id: filterSearch.phuongxa_id,
          thonto_id: filterSearch.thonto_id,
          [csrfToken]: 1,
        }
      });

      const items = response.data || [];
      const currentPage = response.page || page;
      const totalRecord = response.totalrecord || items.length;
      const totalPages = Math.ceil(totalRecord / take);
      const start = (currentPage - 1) * take + 1;

      $('#tbody_danhsach').html(renderTBody(items, start));
      const {
        pagination,
        info
      } = renderPagination(currentPage, totalPages, totalRecord, take);
      $('#pagination').html(pagination);
      $('#pagination-info').text(info);

      history.pushState({}, '', `?view=laodong&task=default&page=${currentPage}`);
      return {
        page: currentPage,
        take,
        totalrecord: totalRecord
      };
    } catch (error) {
      console.error('Error:', error);
      $('#tbody_danhsach').html('<tr><td colspan="8" class="text-center">Lỗi khi tải dữ liệu</td></tr>');
      showToast('Lỗi khi tải dữ liệu', 'danger');
    }
  }

  function getFilterParams() {
    return {
      hoten: $('#hoten').val() || '',
      cccd: $('#cccd').val() || '',
      gioitinh_id: $('#gioitinh_id').val() || '',
      doituong_id: $('#doituong_id').val() || '',
      phuongxa_id: $('#phuongxa_id').val() || '',
      thonto_id: $('#thonto_id').val() || '',
    };
  }

  $(document).ready(function() {
    // Initialize from URL parameters
    const urlParams = new URLSearchParams(window.location.search);
    const initialPage = parseInt(urlParams.get('page')) || 1;

    // Load initial data
    loadData(initialPage, getFilterParams());

    $('body').delegate('.btn_hieuchinh', 'click', function() {
      window.location.href = '/index.php?option=com_vhytgd&view=laodong&task=edit_laodong&id=' + $(this).data('idlaodong');
    });
    $('#btn_xuatexcel').on('click', function() {
      let params = {
        option: 'com_vhytgd',
        controller: 'laodong',
        task: 'exportExcel',
        phuongxa_id: $('#phuongxa_id').val(),
        thonto_id: $('#thonto_id').val(),
        doituong_id: $('#doituong_id').val(),
        hoten: $('#hoten').val(),
        cccd: $('#cccd').val(),
        gioitinh_id: $('#gioitinh_id').val(),

        daxoa: 0,
        [Joomla.getOptions('csrf.token')]: 1 // Thêm CSRF token
      };

      // Tạo URL đúng
      let url = Joomla.getOptions('system.paths').base + '/index.php?' + $.param(params);
      window.location.href = url;
    });
    $('#btn_filter').on('click', function(e) {
      e.preventDefault();
      loadData(1, getFilterParams());
    });

    $('#gioitinh_id, #doituong_id, #phuongxa_id, #thonto_id').select2({
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
          option: 'com_vhytgd',
          controller: 'laodong',
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
    $('body').on('click', '.btn_xoa', function() {
      const idLaoDong = $(this).data('idlaodong');

      bootbox.confirm({
        title: '<span class="text-primary" style="font-weight:bold;font-size:20px;">Thông báo</span>',
        message: '<span style="font-size:18px;">Bạn có chắc chắn muốn xóa dữ liệu này?</span>',
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
        callback: async function(result) {
          if (!result) return; // bấm Không thì thoát

          try {
            const response = await fetch(`index.php?option=com_vhytgd&controller=laodong&task=xoa_laodong`, {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json'
              },
              body: JSON.stringify({
                idUser,
                idLaoDong,
                [csrfToken]: 1
              })
            });
            const data = await response.json();
            showToast(data.message || 'Xóa thành công', 'success');
            if (data.success !== false) {
              setTimeout(() => {
                window.location.reload();
              }, 500);
            }
          } catch (error) {
            console.error('Error:', error);
            showToast('Đã xảy ra lỗi khi xóa dữ liệu', false);
          }
        }
      });
    });


    // Pagination handler
    $('body').on('click', '#pagination .page-link', function(e) {
      e.preventDefault();

      const page = parseInt($(this).data('page'));
      $('#pagination .page-item').removeClass('active');
      $(this).parent().addClass('active');
      loadData(page, getFilterParams());
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

  .select2-container--default .select2-results__option--highlighted[aria-selected] {
    background-color: #007b8b;
    color: #fff
  }

  .select2-container .select2-selection--single {
    height: 38px;
  }

  span.btn_hieuchinh,
  span.btn_xoa {
    font-size: 18px;
    padding: 10px;
    cursor: pointer;
    position: relative;
    transition: color 0.3s;
  }

  .btn_hieuchinh,
  .btn_xoa {
    cursor: pointer;
    pointer-events: auto;
    color: #999;
    padding: 10px;
  }

  .btn_hieuchinh:hover i,
  .btn_xoa:hover i {
    color: #007b8bb8;
  }

  .btn_hieuchinh::after,
  .btn_xoa::after {
    content: attr(data-title);
    position: absolute;
    bottom: 72%;
    left: 50%;
    transform: translateX(-50%);
    background-color: rgba(79, 89, 102, .08);
    color: #000000;
    padding: 6px 10px;
    font-size: 14px;
    white-space: nowrap;
    border-radius: 6px;
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.3s;
    box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.2);
    border: 1px solid #ccc;
  }


  .btn_hieuchinh:hover::after,
  .btn_xoa:hover::after {
    opacity: 1;
    visibility: visible;
  }
</style>