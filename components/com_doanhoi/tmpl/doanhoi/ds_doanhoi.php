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
      <th style="vertical-align: middle; min-width: 185px; max-width: 195px" class="text-center text-dark">Giới tính</th>
      <th style="vertical-align: middle; min-width: 140px; max-width: 150px" class="text-center text-dark">CCCD/CMND</th>
      <th style="vertical-align: middle; min-width: 140px; max-width: 150px" class="text-center text-dark">Số điện thoại</th>
      <th style="vertical-align: middle; min-width: 140px; max-width: 150px" class="text-center text-dark">Chức vụ</th>
      <th style="vertical-align: middle; min-width: 125px; max-width: 135px" class="text-center text-dark">Chức năng</th>
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
  const doanhoi = <?= json_encode($this->doanhoiPhanQuyen[0]['is_doanvien'] ?? 0) ?>;
  const csrfToken = Joomla.getOptions('csrf.token', '');

  // hàm render tbody 
  function renderTableRows(items, startIndex) {
    if (!items || items.length === 0) {
      return '<tr><td colspan="8" class="text-center">Không có dữ liệu</td></tr>';
    }
    return items.map((item, index) => `
    <tr>
      <td class="text-center" style="vertical-align: middle">${startIndex + index}</td>
      <td style="vertical-align: middle">${item.n_hoten || ''}</td>
      <td style="vertical-align: middle">${item.n_diachi || ''}</td>
      <td style="vertical-align: middle">${item.tengioitinh || ''}</td>
      <td style="vertical-align: middle">${item.n_cccd || ''}</td>
      <td style="vertical-align: middle">${item.n_dienthoai || ''}</td>
      <td style="vertical-align: middle; text-align:center">${renderTextChucVu(item.chucvu_id, item.tenchucdanh)}</td>
      <td class="text-center" style="vertical-align: middle">
        <span class="btn btn-sm btn_hieuchinh" data-bs-toggle="modal" data-bs-target="#modalThemDoanHoi" style="font-size:18px;padding:10px; cursor: pointer;" data-doanhoi="${item.id}" data-title="Hiệu chỉnh">
          <i class="fas fa-pencil-alt"></i>
        </span>
        <span style="padding: 0 0px;font-size:22px;color:#999">|</span>
        <span class="btn btn-sm btn_xoa" style="font-size:18px;padding:10px; cursor: pointer;" data-doanhoi="${item.id}" data-title="Xóa">
          <i class="fas fa-trash-alt"></i>
        </span>
      </td>
    </tr>
  `).join('');
  }

  function renderTextChucVu(id, tenchucdanh) {
    let stringchucvu = ""
    if (id === 5 || id === 7 || id === 15) {
      stringchucvu = `<span class="badge bg-danger" style="padding: 0.4em; font-size: 80%" >${tenchucdanh}</span>`
    } else if (id === 8 || id === 10 || id === 14) {
      stringchucvu = `<span class="badge bg-primary" style="padding: 0.4em; font-size: 80%" >${tenchucdanh}</span>`
    } else if (id === 6 || id === 9 || id === 15) {
      stringchucvu = `<span class="badge bg-success" style="padding: 0.4em; font-size: 80%" >${tenchucdanh}</span>`
    }
    return stringchucvu
  }


  // Function to render pagination controls and info
  function renderPagination(currentPage, totalPages, totalRecords, itemsPerPage) {
    let html = '<ul class="pagination">';
    // First and Previous buttons
    html += `<li class="page-item ${currentPage === 1 || totalPages <= 1 ? 'disabled' : ''}">
    <a class="page-link" href="#" data-page="1">&lt;&lt;</a>
  </li>`;
    html += `<li class="page-item ${currentPage === 1 || totalPages <= 1 ? 'disabled' : ''}">
    <a class="page-link" href="#" data-page="${Math.max(1, currentPage - 1)}">&lt;</a>
  </li>`;

    // Page numbers with a range of 2 pages before and after current page
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

    // Pagination info (e.g., "Showing 1-20 of 50 items")
    const startRecord = (currentPage - 1) * itemsPerPage + 1;
    const endRecord = Math.min(startRecord + itemsPerPage - 1, totalRecords);
    const info = totalRecords > 0 ?
      `Hiển thị ${startRecord} - ${endRecord} của ${totalRecords} mục (${totalPages} trang)` :
      'Không có dữ liệu trang';

    return {
      pagination: html,
      info
    };
  }

  // hàm get list đoàn hôi
  async function loadMemberList(page = 1, filters, itemsPerPage = 20) {
    try {
      $('#tbody_danhsach').html('<tr><td colspan="8" class="text-center">Đang tải dữ liệu...</td></tr>');
      const response = await $.ajax({
        url: 'index.php?option=com_doanhoi&controller=doanhoi&task=getListDoanHoi',
        method: 'POST',
        data: {
          page,
          take: itemsPerPage,
          hoten: filters.hoten,
          cccd: filters.cccd,
          phuongxa_id: filters.phuongxa_id,
          thonto_id: filters.thonto_id,
          gioitinh_id: filters.gioitinh_id,
          doanhoi: filters.doanhoi,
          [csrfToken]: 1
        }
      });

      const items = response.data || [];
      const currentPage = response.page || page;
      const totalRecords = response.totalrecord || items.length;
      const totalPages = Math.ceil(totalRecords / itemsPerPage);
      const startIndex = (currentPage - 1) * itemsPerPage + 1;

      $('#tbody_danhsach').html(renderTableRows(items, startIndex));
      const {
        pagination,
        info
      } = renderPagination(currentPage, totalPages, totalRecords, itemsPerPage);
      $('#pagination').html(pagination);
      $('#pagination-info').text(info);

      history.pushState({}, '', `?view=doanhoi&task=default&page=${currentPage}`);
      return {
        page: currentPage,
        take: itemsPerPage,
        totalrecord: totalRecords
      };
    } catch (error) {
      console.error('Error loading data:', error);
      $('#tbody_danhsach').html('<tr><td colspan="8" class="text-center">Lỗi khi tải dữ liệu</td></tr>');
      showToastDS('Lỗi khi tải dữ liệu', false);
    }
  }

  // hàm get thông tin search 
  function getFilterParams() {
    return {
      hoten: $('#hoten').val() || '',
      cccd: $('#cccd').val() || '',
      phuongxa_id: $('#phuongxa_id').val() || '',
      thonto_id: $('#thonto_id').val() || '',
      gioitinh_id: $('#gioitinh_id').val() || 0,
      doanhoi: doanhoi
    };
  }

  $(document).ready(function() {
    // lấy url để gán page trên url 
    const urlParams = new URLSearchParams(window.location.search);
    const initialPage = parseInt(urlParams.get('page')) || 1;
    loadMemberList(initialPage, getFilterParams());

    // hành động search 
    $('#btn_filter').on('click', function(e) {
      e.preventDefault();
      loadMemberList(1, getFilterParams());
    });

    // hành động chuyển trang 
    $('body').on('click', '#pagination .page-link', function(e) {
      e.preventDefault();
      const page = parseInt($(this).data('page'));
      $('#pagination .page-item').removeClass('active');
      $(this).parent().addClass('active');
      loadMemberList(page, getFilterParams());
    });

    // hành động xóa
    $('body').on('click', '.btn_xoa', async function() {
      if (!confirm('Bạn có chắc chắn muốn xóa dữ liệu này?')) return;

      const memberId = $(this).data('doanhoi');
      try {
        const response = await fetch(`index.php?option=com_doanhoi&controller=doanhoi&task=xoa_doanhoi`, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({
            idUser,
            idThanhvienDoanHoi: memberId,
            [csrfToken]: 1
          })
        });
        const data = await response.json();
        showToastDS(data.message || 'Xóa thành công', data.success !== false);
        if (data.success !== false) {
          setTimeout(() => window.location.reload());
        }
      } catch (error) {
        console.error('Error deleting:', error);
        showToastDS('Đã xảy ra lỗi khi xóa dữ liệu', false);
      }
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