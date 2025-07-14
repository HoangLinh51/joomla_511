<?php

use Joomla\CMS\Factory;
use Joomla\CMS\Router\Route;

defined('_JEXEC') or die('Restricted access');
?>

<div class="danhsach">
  <div class="content-header">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h3 class="m-0 text-primary"><i class="fas fa-users"></i> Quản lý thông báo hổ trợ</h3>
      </div>
      <div class="col-sm-6 text-right" style="padding:0;">
        <a href="index.php?option=com_thongbao&view=thongbao&task=add_thongbao" class="btn btn-primary" style="font-size:16px;width:136px">
          <i class="fas fa-plus"></i> Thêm mới
        </a>
      </div>
    </div>
  </div>

  <div class="card card-primary collapsed-card">
    <div class="card-header" data-card-widget="collapse">
      <h3 class="card-title"><i class="fas fa-search"></i> Tìm kiếm</h3>
      <div class="card-tools">
        <button type="button" class="btn btn-tool un-collapsed-card" data-action="reload"><i class="fas fa-sync-alt"></i></button>
        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-chevron-up"></i></button>
      </div>
    </div>
    <div class="card-body">
      <table class="table table-borderless">
        <tr>
          <td style="width:100%;">
            <input type="text" name="keyword" id="keyword" class="form-control" style="font-size:16px;" placeholder="Nhập nội dung hoặc tiêu đề" />
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
    <table class="table table-striped table-bordered table-hover" id="tblDanhsach">
      <thead>
        <tr class="bg-primary text-white">
          <th style="vertical-align:middle;" class="text-center">STT</th>
          <th style="vertical-align:middle;" class="text-center">Tiêu đề</th>
          <th style="vertical-align:middle;" class="text-center">Nội dung</th>
          <th style="vertical-align:middle;" class="text-center">Văn bản đính kèm</th>
          <th style="vertical-align:middle; width:131px;" class="text-center">Chức năng</th>
        </tr>
      </thead>
      <tbody id="tbody_danhsach">

      </tbody>
    </table>
    <!-- pagination -->
    <div class="pagination-container d-flex align-items-center mt-3">
      <div id="pagination" class="mx-auto"></div>
      <div id="pagination-info" class="pagination-info text-right ml-3"></div>
    </div>
  </div>

  <div class="modal fade modal-fixed-right" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-right" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="detailModalLabel">Thông tin chi tiết</h5>
        </div>
        <div class="modal-body">
          <div id="detailContent">Đang tải...</div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
        </div>
      </div>
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

  function renderTBody(items, start) {
    if (!items || items.length === 0) {
      return '<tr><td colspan="5" class="text-center">Không có dữ liệu</td></tr>';
    }
    return items.map((item, index) => {
      console.log(item)
      let vanbanHtml = '';
      if (item.vanban && Array.isArray(item.vanban)) {
        vanbanHtml = item.vanban.map(vb => {
          if (vb.type === 'application/pdf') {
            return `
        <a href="/index.php?option=com_thongbao&view=thongbao&format=raw&task=viewpdf&file=${vb.code}" target="_blank">
          ${vb.filename}
        </a><br/>`;
          } else {
            return `
        <a href="/index.php?option=com_core&controller=attachment&format=raw&task=download&year=${vb.nam}&code=${vb.code}">
          ${vb.filename}
        </a><br/>`;
          }
        }).join('');
      }

      return `
        <tr>
          <td class="text-center" style="vertical-align: middle">${index + 1}</td>
          <td style="vertical-align: middle">
            <a href="#" class="modal-detail" data-thongbaoId=${item.id}>
              ${item.tieude || ''}
            </a>
          </td>
          <td style="vertical-align:middle;">${item.noidung || ''}</td>
          <td style="vertical-align: middle" class="text-center">${vanbanHtml}</td>
          <td class="text-center">
            <a class="btn btn-sm btn_hieuchinh" style="font-size:18px;padding:10px; cursor: pointer;"
              href="/index.php?option=com_thongbao&view=thongbao&task=edit_thongbao&id=${item.id}"
              data-title="Hiệu chỉnh">
              <i class="fas fa-pencil-alt"></i>
            </a>
            <span style="padding: 0 0px;font-size:22px;color:#999">|</span>
            <span class="btn btn-sm btn_xoa" style="font-size:18px;padding:10px; cursor: pointer;" data-thongbao="${item.id}" data-title="Xóa">
              <i class="fas fa-trash-alt"></i>
            </span>
          </td>
        </tr>
      `;
    }).join('');
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

  async function loadData(page = 1, keyword = '', take = 20) {
    try {
      $('#tbody_danhsach').html('<tr><td colspan="5" class="text-center">Đang tải dữ liệu...</td></tr>');
      const response = await $.ajax({
        url: 'index.php?option=com_thongbao&controller=thongbao&task=getDanhSachThongBao',
        method: 'POST',
        data: {
          page,
          take,
          keyword,
          [csrfToken]: 1
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

      history.pushState({}, '', `?view=thongbao&task=default&page=${currentPage}${keyword ? `&keyword=${encodeURIComponent(keyword)}` : ''}`);
      return {
        page: currentPage,
        take,
        totalrecord: totalRecord
      };
    } catch (error) {
      console.error('Error:', error);
      $('#tbody_danhsach').html('<tr><td colspan="5" class="text-center">Lỗi khi tải dữ liệu</td></tr>');
      showToast('Lỗi khi tải dữ liệu', 'danger');
    }
  }

  function loadDetail(thongbaoId) {
    $("#overlay").fadeIn(300);
    var params = {
      option: 'com_thongbao',
      view: 'thongbao',
      format: 'raw',
      task: 'DETAIL_THONGBAO',
      thongbaoId: thongbaoId,
    };
    $.ajax({
      url: 'index.php',
      type: 'GET',
      data: params,
      success: function(response) {
        $('#detailContent').html(response);
        $('#detailModal').modal('show');
        $("#overlay").fadeOut(300);
      },
      error: function(xhr, status, error) {
        $('#detailContent').html('<p class="text-danger">Lỗi khi tải thông tin: ' + error + '</p>');
        $('#detailModal').modal('show');
        $("#overlay").fadeOut(300);
      }
    });
  }

  $(document).ready(function() {
    const idUser = <?= (int)Factory::getUser()->id ?>;
    const idThongbao = <?= (int)$item->id ?>;
    const urlParams = new URLSearchParams(window.location.search);
    const initialPage = parseInt(urlParams.get('page')) || 1;
    const initialKeyword = urlParams.get('keyword') || '';

    loadData(initialPage, initialKeyword);

    //navigate sang trang hiệu chỉnh
    $('body').delegate('.btn_hieuchinh', 'click', function() {
      window.location.href = 'index.php?option=com_thongbao&view=thongbao&task=edit_thongbao&id=' + $(this).data('thongbao');
    });

    //hành động xem detail
    $(document).on('click', '.modal-detail', function(e) {
      e.preventDefault();

      var thongbaoId = $(this).data('thongbaoid');
      loadDetail(thongbaoId);
    });

    //hành động search 
    $('#btn_filter').on('click', function(e) {
      e.preventDefault();

      let keyword = $('#keyword').val();
      let page = 1;
      loadData(page, keyword, <?= $limit ?>)
    })

    //hành động reset thanh search 
    $('.un-collapsed-card[data-action="reload"]').on('click', function(e) {
      e.preventDefault();
      $('#keyword').val('');
      loadData(1, '');
    });

    //hành động chuyển trang
    $('body').on('click', "#pagination .page-link", function(e) {
      e.preventDefault()
      let page = $(this).data('page')
      $('#pagination .page-item').removeClass('active')
      $(this).parent().addClass('active')
      loadData(page, '', <?= $limit ?>)
    })

    //hành động xóa item 
    $('body').on('click', '.btn_xoa', function() {
      const confirmed = confirm('Bạn có chắc chắn muốn xóa dữ liệu này?');
      if (!confirmed) return;

      const url = "<?= Route::_('index.php?option=com_thongbao&task=thongbao.xoa_thongbao') ?>";
      const tokenName = Joomla.getOptions('csrf.token');

      const payload = {
        idUser: idUser,
        idThongbao: $(this).data('thongbao')
      };
      payload[tokenName] = 1;
      fetch(url, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify(payload)
        })
        .then(response => response.json())
        .then(data => {
          const isSuccess = data.success ?? true;
          showToast(data.message || 'Xóa thành công', isSuccess);
          if (isSuccess) {
            setTimeout(() => location.reload(), 500);
          }
        })
        .catch(error => {
          console.error('Lỗi:', error);
          showToast('Đã xảy ra lỗi khi xóa dữ liệu', false);
        });
    });
  });
</script>

<style>
  .content-wrapper {
    background-color: #fff;
  }

  .content-box {
    padding: 0px 20px;
  }

  .modal-dialog.modal-dialog-right {
    position: fixed;
    top: 0;
    right: 0;
    margin: 0;
    height: 100%;
    min-width: 800px;
    transform: none !important;
    padding: 20px 10px;
  }

  .modal-dialog.modal-dialog-right .modal-content {
    height: 100%;
    border-radius: 5px;
  }

  .danhsach {
    padding: 20px;
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