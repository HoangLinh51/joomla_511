<?php

use Joomla\CMS\Factory;

defined('_JEXEC') or die('Restricted access');
?>

<table class="table table-striped table-bordered table-hover" id="tblDanhsach">
  <thead>
    <tr style="background-color: #FBFBFB !important;" class="bg-primary">
      <th style="vertical-align: middle" class="text-center text-dark">STT</th>
      <th style="vertical-align: middle" class="text-center text-dark">Họ và tên</th>
      <th style="vertical-align: middle" class="text-center text-dark">Địa chỉ</th>
      <th style="vertical-align: middle" class="text-center text-dark">Giới tính</th>
      <th style="vertical-align: middle" class="text-center text-dark">CCCD/CMND</th>
      <th style="vertical-align: middle" class="text-center text-dark">Số điện thoại</th>
      <th style="vertical-align: middle" class="text-center text-dark">Tình trạng</th>
      <th style="vertical-align: middle" class="text-center text-dark">Chức năng</th>
    </tr>
  </thead>
  <tbody id="tbody_danhsach">
    <tr>
      <td colspan="8" class="text-center">Đang tải dữ liệu...</td>
    </tr>
  </tbody>
</table>
<div class="pagination-container d-flex align-items-center mt-3">
  <div id="pagination" class="mx-auto"></div>
  <div id="pagination-info" class="pagination-info text-right ml-3"></div>
</div>

<script>
  const idUser = <?= (int)Factory::getUser()->id ?>;

  function renderTextDiaChi(diachi = '', thonto = '', phuongxa = '') {
    const parts = [diachi, thonto, phuongxa].filter(part => part && part.trim() !== '');
    return parts.length > 0 ? parts.join(' - ') : '';
  }

  function renderTextTrangThai(id, tentrangthai) {
    let stringchucvu = ""
    if (id == 13) {
      stringchucvu = `<span class="badge bg-danger" style="padding: 0.4em; font-size: 80%" >${tentrangthai}</span>`
    } else if (id == 5 || id == 6) {
      stringchucvu = `<span class="badge bg-secondary" style="padding: 0.4em; font-size: 80%" >${tentrangthai}</span>`
    } else if (id == 12) {
      stringchucvu = `<span class="badge bg-warning" style="padding: 0.4em; font-size: 80%" >${tentrangthai}</span>`
    } else if (id == 4) {
      stringchucvu = `<span class="badge bg-success" style="padding: 0.4em; font-size: 80%" >${tentrangthai}</span>`
    }
    return stringchucvu
  }
  //hàm render tbody
  function renderTBody(items, start) {
    if (!items || items.length === 0) {
      return '<tr><td colspan="8" class="text-center">Không có dữ liệu</td></tr>';
    }
    return items.map((item, index) => `
      <tr>
        <td class="text-center" style="vertical-align: middle">${start + index}</td>
        <td style="vertical-align: middle">${item.n_hoten || ''}</td>
        <td style="vertical-align:middle;">${renderTextDiaChi((item.n_diachi || ''), (item.thonto || ''), (item.phuongxa || ''))}</td>
        <td style="vertical-align:middle;">${item.tengioitinh || ''}</td>
        <td style="vertical-align:middle;">${item.n_cccd || ''}</td>
        <td style="vertical-align:middle;">${item.n_dienthoai || ''}</td>
        <td style="vertical-align:middle; text-align: center">${renderTextTrangThai(item.trangthaiquansu_id,item.tentrangthai)}</td>
        <td class="text-center" style="vertical-align: middle;min-width: 120px" >
         <span class="btn btn-sm btn_hieuchinh" style="font-size:18px;padding:7px; cursor: pointer;" data-iddknvqs="${item.id}" data-title="Hiệu chỉnh">
            <i class="fas fa-pencil-alt"></i>
          </span>
          <span style="padding: 0 0px;font-size:22px;color:#999">|</span>
          <span class="btn btn-sm btn_xoa" style="font-size:18px;padding:7px; cursor: pointer;" data-iddknvqs="${item.id}" data-title="Xóa">
            <i class="fas fa-trash-alt"></i>
          </span>
        </td>
      </tr>
    `).join('');
  }

  // hàm render phân trang 
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

  // hàm get list đoàn hôi
  async function loadData(page = 1, filterSearch, take = 20) {
    try {
      $('#tbody_danhsach').html('<tr><td colspan="8" class="text-center">Đang tải dữ liệu...</td></tr>');
      const response = await $.ajax({
        url: 'index.php?option=com_quansu&controller=dknvqs&task=getListdknvqs',
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

      history.pushState({}, '', `?view=dknvqs&task=default&page=${currentPage}`);
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

  // hàm get thông tin search 
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
    // lấy url để gán page trên url 
    const urlParams = new URLSearchParams(window.location.search);
    const initialPage = parseInt(urlParams.get('page')) || 1;

    loadData(initialPage, getFilterParams());
    $('body').delegate('.btn_hieuchinh', 'click', function() {
      window.location.href = '/index.php?option=com_quansu&view=dknvqs&task=edit_dknvqs&id=' + $(this).data('iddknvqs');
    });

    // hành động search 
    $('#btn_filter').on('click', function(e) {
      e.preventDefault();
      loadData(1, getFilterParams());
    });

    // hành động chuyển trang 
    $('body').on('click', '#pagination .page-link', function(e) {
      e.preventDefault();

      const page = parseInt($(this).data('page'));
      $('#pagination .page-item').removeClass('active');
      $(this).parent().addClass('active');
      loadData(page, getFilterParams());
    });

    // hành động xóa
    $('body').on('click', '.btn_xoa', function() {
      const iddknvqs = $(this).data('iddknvqs');

      bootbox.confirm({
        title: `<span class='text-danger' style='font-weight:bold;font-size:20px;'>Xác nhận xóa</span>`,
        message: `<span style="font-size:20px;">Bạn có chắc chắn muốn xóa người đăng ký nghĩa vụ quân sự này?</span>`,
        buttons: {
          confirm: {
            label: '<i class="fas fa-check"></i> Đồng ý',
            className: 'btn-success'
          },
          cancel: {
            label: '<i class="fas fa-times"></i> Không',
            className: 'btn-danger'
          }
        },
        callback: async function(result) {
          if (!result) return;

          try {
            const response = await fetch(`index.php?option=com_quansu&controller=dknvqs&task=xoa_dknvqs`, {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json'
              },
              body: JSON.stringify({
                idUser,
                iddknvqs
              })
            });

            const data = await response.json();
            showToastDS(data.message || 'Xóa thành công', data.success !== false);
            if (data.success !== false) {
              setTimeout(() => {
                window.location.reload();
              }, 500);
            }
          } catch (error) {
            console.error('Lỗi khi xóa:', error);
            showToastDS('Đã xảy ra lỗi khi xóa dữ liệu', false);
          }
        }
      });
    });
  });

  //hàm thông báo
  function showToastDS(message, isSuccess = true) {
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
</script>

<style>
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
    color: #0066ff;
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