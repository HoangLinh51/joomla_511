<?php

use Joomla\CMS\Factory;

defined('_JEXEC') or die('Restricted access');
?>

<table class="table table-striped table-bordered table-hover" id="tblDanhsach">
  <thead>
    <tr class="bg-primary">
      <th class="text-center align-middle">STT</th>
      <th class="text-center align-middle">Họ và tên</th>
      <th class="text-center align-middle">Địa chỉ</th>
      <th class="text-center align-middle">Giới tính</th>
      <th class="text-center align-middle">CCCD/CMND</th>
      <th class="text-center align-middle">Số điện thoại</th>
      <th class="text-center align-middle">Tình trạng đăng ký</th>
      <th class="text-center align-middle">Chức năng</th>
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
    if (id == 9) {
      stringchucvu = `<span class="badge bg-danger">${tentrangthai}</span>`
    } else if (id == 7) {
      stringchucvu = `<span class="badge bg-success">${tentrangthai}</span>`
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
        <td class="text-center align-middle">${start + index}</td>
        <td class="align-middle">${item.n_hoten || ''}</td>
        <td class="align-middle">${renderTextDiaChi((item.n_diachi || ''), (item.thonto || ''), (item.phuongxa || ''))}</td>
        <td class="align-middle">${item.tengioitinh || ''}</td>
        <td class="align-middle">${item.n_cccd || ''}</td>
        <td class="align-middle">${item.n_dienthoai || ''}</td>
        <td class="align-middle text-center">${renderTextTrangThai(item.trangthaiquannhan_id,item.tentrangthai)}</td>
        <td class="text-center align-middle" style="min-width: 120px" >
         <span class="btn btn-sm btn_hieuchinh" style="font-size:18px;padding:7px; cursor: pointer;" data-idquannhandubi="${item.id}" data-title="Hiệu chỉnh">
            <i class="fas fa-pencil-alt"></i>
          </span>
          <span style="padding: 0 0px;font-size:22px;color:#999">|</span>
          <span class="btn btn-sm btn_xoa" style="font-size:18px;padding:7px; cursor: pointer;" data-idquannhandubi="${item.id}" data-title="Xóa">
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
        url: 'index.php?option=com_quansu&controller=quannhandubi&task=getListquannhandubi',
        method: 'POST',
        data: {
          page,
          take,
          hoten: filterSearch.hoten,
          cccd: filterSearch.cccd,
          gioitinh_id: filterSearch.gioitinh_id,
          tinhtrang_id: filterSearch.tinhtrang_id,
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

      history.pushState({}, '', `?view=quannhandubi&task=default&page=${currentPage}`);
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
      tinhtrang_id: $('#tinhtrang_id').val() || '',
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
      window.location.href = '/index.php?option=com_quansu&view=quannhandubi&task=edit_quannhandubi&id=' + $(this).data('idquannhandubi');
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
      const idquannhandubi = $(this).data('idquannhandubi');

      bootbox.confirm({
        title: `<span class='text-primary' style='font-weight:bold;font-size:20px;'>Xác nhận xóa</span>`,
        message: `<span style="font-size:20px;">Bạn có chắc chắn muốn xóa quân nhân dự bị này?</span>`,
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
            const response = await fetch(`index.php?option=com_quansu&controller=quannhandubi&task=xoa_quannhandubi`, {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json'
              },
              body: JSON.stringify({
                idUser,
                idquannhandubi
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