<?php

use Joomla\CMS\Factory;

defined('_JEXEC') or die('Restricted access');
?>

<table class="table table-striped table-bordered table-hover" id="tblDanhsach">
  <thead>
    <tr class="bg-primary">
      <th class="align-middle text-center">STT</th>
      <th class="align-middle text-center">Họ và tên</th>
      <th class="align-middle text-center">Điện thoại</th>
      <th class="align-middle text-center">Số giấy phép</th>
      <th class="align-middle text-center">Địa chỉ</th>
      <th class="align-middle text-center">Số ngày còn lại</th>
      <th class="align-middle text-center">Trạng thái</th>
      <th class="align-middle text-center">Chức năng</th>
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
  const csrfToken = Joomla.getOptions('csrf.token', '');

  // hàm render tbody 
  function renderTableRows(items, startIndex) {
    if (!items || items.length === 0) {
      return '<tr><td colspan="8" class="text-center">Không có dữ liệu</td></tr>';
    }

    return items.map((item, index) => {
      let {
        soNgay,
        tinhTrangHTML
      } = soNgayConLai(item.ngayhethan);

      return `
        <tr>
          <td class="text-center align-middle">${startIndex + index}</td>
          <td class="align-middle">${item.hoten || ''}</td>
          <td class="align-middle">${item.dienthoai || ''}</td>
          <td class="align-middle text-center">${item.sogiayphep || ''} (lần ${item.solan})</td>
          <td class="align-middle">${item.diachi || ''}</td>
          <td class="align-middle text-center">${soNgay ?? ''} ngày</td>
          <td class="align-middle text-center">${tinhTrangHTML ?? ''}</td>
          <td class="text-center align-middle">
            <span class="btn btn-sm btn_hieuchinh"style="font-size:18px;padding:10px; cursor: pointer;" data-viahe="${item.id}" data-title="Hiệu chỉnh">
              <i class="fas fa-pencil-alt"></i>
            </span>
            <span style="padding: 0 0px;font-size:22px;color:#999">|</span>
            <span class="btn btn-sm btn_xoa" style="font-size:18px;padding:10px; cursor: pointer;" data-idhopdong="${item.id_hopdong}" data-title="Xóa">
              <i class="fas fa-trash-alt"></i>
            </span>
          </td>
        </tr>
      `;
    }).join('');
  }

  function soNgayConLai(ngayHetHanStr) {
    const ngayHetHan = new Date(ngayHetHanStr);
    const homNay = new Date();

    // Đặt giờ về 00:00 để so sánh chính xác
    ngayHetHan.setHours(0, 0, 0, 0);
    homNay.setHours(0, 0, 0, 0);

    const diffMs = ngayHetHan - homNay;
    let diffDays = Math.floor(diffMs / (1000 * 60 * 60 * 24));

    // Nếu ngày chưa quá hạn nhưng diffDays == 0, thì coi như còn 1 ngày
    if (diffDays === 0) {
      diffDays = 1;
    }

    // Xác định tình trạng
    let id;
    if (diffDays < 0) {
      id = 3; // Hết hạn
    } else if (diffDays < 7) {
      id = 2; // Sắp hết hạn
    } else {
      id = 1; // Còn hạn
    }

    return {
      soNgay: diffDays,
      tinhTrangHTML: renderTextTinhTrang(id)
    };
  }

  function renderTextTinhTrang(id) {
    let stringtinhtrang = "";
    if (id === 1) {
      stringtinhtrang = `<span class="badge bg-success">Còn hạn</span>`;
    } else if (id === 2) {
      stringtinhtrang = `<span class="badge bg-warning">Sắp hết hạn</span>`;
    } else if (id === 3) {
      stringtinhtrang = `<span class="badge bg-danger">Hết hạn</span>`;
    }
    return stringtinhtrang;
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
        url: 'index.php?option=com_dcxddt&controller=viahe&task=getListViaHe',
        method: 'POST',
        data: {
          page,
          take: itemsPerPage,
          diachi: filters.diachi,
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

      history.pushState({}, '', `?view=viahe&task=default&page=${currentPage}`);
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
      diachi: $('#diachi').val() || '',
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

    $('body').delegate('.btn_hieuchinh', 'click', function() {
      window.location.href = '/index.php?option=com_dcxddt&view=viahe&task=editviahe&id=' + $(this).data('viahe');
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
    $('body').on('click', '.btn_xoa', function() {
      const idhopdong = $(this).data('idhopdong');

      bootbox.confirm({
        title: '<span class="text-primary" style="font-weight:bold;font-size:20px;">Thông báo</span>',
        message: '<span class="red" style="font-size:20px;">Bạn có chắc chắn muốn xóa dữ liệu này?</span>',
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
          if (!result) return;

          try {
            const response = await fetch(`index.php?option=com_dcxddt&controller=viahe&task=xoa_hopdong`, {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json'
              },
              body: JSON.stringify({
                idhopdong,
                [csrfToken]: 1
              })
            });

            const data = await response.json();
            showToastDS(data.message || 'Xóa hợp đồng thành công', data.success !== false);

            if (data.success !== false) {
              setTimeout(() => {
                window.location.reload();
              }, 500);
            }
          } catch (error) {
            console.error('Error deleting:', error);
            showToastDS(error, data.success)
          }
        },
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