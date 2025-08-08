<?php

use Joomla\CMS\Factory;

defined('_JEXEC') or die('Restricted access');
$onlyview = Factory::getUser()->onlyview_viahe
?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/gh/davidshimjs/qrcodejs/qrcode.min.js"></script>
<table class="table table-striped table-bordered table-hover" id="tblDanhsach">
  <thead>
    <tr class="bg-primary">
      <th class="align-middle text-center">STT</th>
      <th class="align-middle text-center">Mã QR</th>
      <th class="align-middle text-center">Thông tin khách hàng</th>
      <th class="align-middle text-center">Thông tin giấy phép </th>
      <!-- <th class="align-middle text-center">Địa chỉ</th> -->
      <th class="align-middle text-center">Số ngày còn lại</th>
      <th class="align-middle text-center">Trạng thái</th>

      <?php if ($onlyview == 0) { ?>
        <th class="align-middle text-center">Chức năng</th>
      <?php } ?>
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

<!-- Modal QR Code -->
<div class="modal fade" id="qrCodeModal" tabindex="-1" role="dialog" aria-labelledby="qrCodeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="qrCodeModalLabel">
          <i class="fas fa-qrcode"></i> QR Code Vỉa Hè
        </h5>
      </div>
      <div class="modal-body text-center">
        <div id="qrCodeContainer" class="d-flex justify-content-center">
          <div class="spinner-border text-primary" role="status">
            <span class="sr-only">Đang tạo QR code...</span>
          </div>
          <p class="mt-2">Đang tạo QR code...</p>
        </div>
        <div id="qrCodeInfo" class="mt-3" style="display: none;">
          <p class="text-muted mb-2">Quét QR code này để xem chi tiết vỉa hè</p>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">X Đóng</button>
        <button type="button" class="btn btn-primary" id="btnDownloadQR" style="display: none;">
          <i class="fas fa-download"></i> Tải xuống
        </button>
      </div>
    </div>
  </div>
</div>


<script>
  const idUser = <?= (int)Factory::getUser()->id ?>;
  const csrfToken = Joomla.getOptions('csrf.token', '');
  let qr;
  // hàm render tbody 
  function renderTableRows(items, startIndex) {
    if (!items || items.length === 0) {
      return `<tr>
      <td colspan="8" class="text-center">Không có dữ liệu</td>
    </tr>`;
    }

    return items.map((item, index) => {
      let {
        soNgay,
        tinhTrangHTML
      } = soNgayConLai(item.ngayhethan);
      const qrUrl = `${window.location.origin}/index.php/component/dcxddt/?view=viahe&task=xemchitiet&id=${item.id}`;

      return `
      <tr>
        <td class="text-center align-middle">${startIndex + index}</td>
        <td class="align-middle">
          <img id="qr-img-${item.id}" src="" style="width:100px;height:100px;" />
        </td>
        <td class="align-middle">
          <strong>Họ và tên :</strong>
          <a href="/index.php/component/dcxddt/?view=viahe&task=xemchitiet&id=${item.id}">${item.hoten || ''}</a><br>
          <strong>Số điện thoại :</strong> ${item.dienthoai || ''}
        </td>
        <td class="align-middle">
          <strong>Số giấy phép :</strong>${item.sogiayphep || ''} (lần ${item.solan})<br>
          <strong>Địa chỉ :</strong>${item.diachi || ''}
        </td>
        <td class="align-middle text-center">${soNgay ?? ''} ngày</td>
        <td class="align-middle text-center">${tinhTrangHTML ?? ''}</td>
        <?php if ($onlyview == 0) { ?>
        <td class="text-center align-middle">
          <span class="btn btn-sm btn_hieuchinh" style="font-size:18px;padding:10px; cursor: pointer;" data-viahe="${item.id}"
            data-title="Hiệu chỉnh">
            <i class="fas fa-pencil-alt"></i>
          </span>
          <span style="padding: 0 0px;font-size:22px;color:#999">|</span>
           <span class="btn btn-sm btn_downloadqr" data-id="${item.id}" data-url="${qrUrl}" style="font-size:18px;padding:10px; cursor: pointer;" data-idviahe="${item.id}"
            data-title="Tải QR">
            <i class="fas fa-download"></i>
          </span>
          <span style="padding: 0 0px;font-size:22px;color:#999">|</span>
          <span class="btn btn-sm btn_xoa" style="font-size:18px;padding:10px; cursor: pointer;" data-idviahe="${item.id}"
            data-title="Xóa">
            <i class="fas fa-trash-alt"></i>
          </span>
        </td>
        <?php } ?>
      </tr>
    `;
    }).join('');
  }


  function soNgayConLai(ngayHetHanStr) {
    const [d, m, y] = ngayHetHanStr.split('/');
    const ngayHetHan = new Date(`${y}-${m}-${d}`);
    const homNay = new Date();

    ngayHetHan.setHours(0, 0, 0, 0);
    homNay.setHours(0, 0, 0, 0);

    let diffMs = ngayHetHan - homNay;
    let diffDays = Math.floor(diffMs / (1000 * 60 * 60 * 24)) + 1;

    if (diffDays === 0) diffDays = 1;

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

  function generateAllQRCodes() {
    $('.btn_downloadqr').each(function() {
      const qrUrl = $(this).data('url');
      const id = $(this).data('id');
      const tempDiv = document.createElement('div');
      const qrCode = new QRCode(tempDiv, {
        text: qrUrl,
        width: 200,
        height: 200,
        colorDark: "#000000",
        colorLight: "#ffffff",
        correctLevel: QRCode.CorrectLevel.H
      });
      console.log(qrCode)

      // Sau khi tạo xong, lấy ảnh base64 từ canvas
      setTimeout(() => {
        const canvas = tempDiv.querySelector('canvas');
        if (canvas) {
          const imgData = canvas.toDataURL("image/png");
          $(`#qr-img-${id}`).attr('src', imgData).attr('data-img', imgData);
        }
      }, 200); // đợi QRCode vẽ xong
    });
  }
  $(document).ready(function() {
    // lấy url để gán page trên url 
    const urlParams = new URLSearchParams(window.location.search);
    const initialPage = parseInt(urlParams.get('page')) || 1;
    loadMemberList(initialPage, getFilterParams());
    generateAllQRCodes()

    // hành động search 
    $('#btn_filter').on('click', function(e) {
      e.preventDefault();
      loadMemberList(1, getFilterParams());
    });

    $('body').delegate('.btn_hieuchinh', 'click', function() {
      window.location.href = '/index.php?option=com_dcxddt&view=viahe&task=editviahe&id=' + $(this).data('viahe');
    });


    // Event handler cho nút tải xuống QR code
    $('body').on('click', '.btn_downloadqr', function() {
      const id = $(this).data('id');
      const imgData = $(`#qr-img-${id}`).attr('data-img');
      if (!imgData) {
        alert('QR chưa được tạo. Vui lòng thử lại sau.');
        return;
      }
      const link = document.createElement('a');
      link.href = imgData;
      link.download = `qr_viahe_${id}.png`;
      link.click();
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
      const idviahe = $(this).data('idviahe');

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
            const response = await fetch(`index.php?option=com_dcxddt&controller=viahe&task=xoa_viahe`, {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json'
              },
              body: JSON.stringify({
                idviahe,
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
  span.btn_xoa,
  span.btn_scan {
    font-size: 18px;
    padding: 10px;
    cursor: pointer;
    position: relative;
    transition: color 0.3s;
  }

  .btn_hieuchinh,
  .btn_xoa,
  .btn_scan {
    cursor: pointer;
    pointer-events: auto;
    color: #999;
    padding: 10px;
  }

  .btn_hieuchinh:hover i,
  .btn_xoa:hover i,
  .btn_scan:hover i {
    color: #007b8bb8;
  }

  .btn_hieuchinh::after,
  .btn_xoa::after,
  .btn_scan::after {
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
  .btn_xoa:hover::after,
  .btn_scan:hover::after {
    opacity: 1;
    visibility: visible;
  }

  /* QR Code Modal Styles */
  #qrCodeModal .modal-content {
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
  }

  #qrCodeModal .modal-header {
    background: linear-gradient(135deg, #014e58 0%, #048fa17c 100%);
    color: white;
    border-radius: 15px 15px 0 0;
  }

  #qrCodeModal .modal-title {
    font-weight: 600;
  }

  #qrCodeModal .modal-body {
    padding: 30px;
  }

  #qrCodeModal .modal-footer {
    border-top: 1px solid #eee;
    padding: 15px 30px;
  }

  #qrCodeContainer img {
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    transition: transform 0.3s ease;
  }

  #qrCodeContainer img:hover {
    transform: scale(1.05);
  }

  #qrCodeUrl {
    word-break: break-all;
    background: #f8f9fa;
    padding: 8px;
    border-radius: 5px;
    border: 1px solid #e9ecef;
  }

  .spinner-border {
    width: 3rem;
    height: 3rem;
  }
</style>