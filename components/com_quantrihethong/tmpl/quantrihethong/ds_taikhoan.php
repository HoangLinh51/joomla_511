<?php

use Joomla\CMS\Factory;
use Joomla\CMS\Router\Route;

defined('_JEXEC') or die('Restricted access');
?>
<div class="danhsach">
  <div class="content-header">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h3 class="m-0 text-primary"><i class="fas fa-users"></i> Danh sách tài khoản </h3>
      </div>
      <div class="col-sm-6 text-right" style="padding:0;">
        <a href="<?php echo Route::_('index.php?option=com_quantrihethong&view=quantrihethong&task=edit_user') ?>" class="btn btn-primary" style="font-size:16px;width:136px">
          <i class="fas fa-plus"></i> Thêm mới
        </a>
      </div>
    </div>
  </div>

  <div class="card card-primary collapsed-card">
    <div class="card-header" data-card-widget="collapse">
      <h3 class="card-title"><i class="fas fa-search"></i> Tìm kiếm</h3>
      <div class="card-tools">
        <button type="button" class="btn btn-tool" data-action="reload"><i class="fas fa-sync-alt"></i></button>
        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-chevron-up"></i></button>
      </div>
    </div>
    <div class="card-body">
      <table class="table table-borderless">
        <tr>
          <td style="width:100%;">
            <input type="text" name="keyword" id="keyword" class="form-control" style="font-size:16px;" placeholder="Nhập họ và tên hoặc tên người dùng" />
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
          <th class="text-center">STT</th>
          <th class="text-center">Họ và tên</th>
          <th class="text-center">Tên người dùng</th>
          <th class="text-center">Trạng thái</th>
          <th class="text-center" style="width: 25%">Đặt lại mật khẩu</th>
          <th class="text-center" style="width:135px">Chức năng</th>
        </tr>
      </thead>
      <tbody id="tbody_danhsach">
        <tr>
          <td colspan="6" class="text-center">Đang tải dữ liệu...</td>
        </tr>
      </tbody>
    </table>
    <div class="pagination-container d-flex align-items-center mt-3">
      <div id="pagination" class="mx-auto"></div>
      <div class="pagination-info text-right ml-3"></div>
    </div>
  </div>
</div>

<script>
  const idUser = <?= (int)Factory::getUser()->id ?>;
  const baseUrl = 'index.php?option=com_quantrihethong&controller=quantrihethong';
  const csrfToken = Joomla.getOptions('csrf.token', '');

  // hàm hiện thông báo
  function showToast(message, type = 'success') {
    const colors = {
      success: '#28a745',
      danger: '#dc3545',
      warning: '#ffc107',
      info: '#17a2b8'
    };
    const toast = $('<div></div>')
      .text(message)
      .css({
        position: 'fixed',
        top: '20px',
        right: '20px',
        background: colors[type] || colors.info,
        color: 'white',
        padding: '12px 24px',
        borderRadius: '8px',
        fontSize: '14px',
        fontWeight: 'bold',
        boxShadow: '0 4px 12px rgba(0,0,0,0.15)',
        opacity: 0,
        zIndex: 9999
      })
      .appendTo('body')
      .animate({
        opacity: 1
      }, 300);
    setTimeout(() => toast.fadeOut(500, () => toast.remove()), 3000);
  }

  function escapeHtml(str) {
    return str.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#039;');
  }

  // hàm render table
  function renderTableRows(accounts, start) {
    if (!accounts || accounts.length === 0) {
      return '<tr><td colspan="6" class="text-center">Không có dữ liệu</td></tr>';
    }
    return accounts.map((account, index) => `
    <tr>
      <td class="text-center" style="vertical-align: middle">${start + index}</td>
      <td style="vertical-align: middle; max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="${escapeHtml(account.name)}">
        ${escapeHtml(account.name)}
      </td>
      <td style="vertical-align: middle">${escapeHtml(account.username)}</td>
      <td style="vertical-align: middle; text-align: center">
        <label class="custom-toggle">
          <input type="checkbox" class="btn_doitrangthai"
            data-key="${account.id}"
            data-status="${account.block}"
            ${account.block == 0 ? 'checked' : ''}>
          <span class="slider"></span>
        </label>
      </td>
      <td style="vertical-align: middle;" class="text-center d-flex align-items-center">
        <input type="text" class="form-control input-reset" name="input-reset">
        <button class="btn btn-primary btn_reset_password" data-name="${escapeHtml(account.name)}" data-id="${account.id}">
          <i class="fas fa-sync-alt"></i>
        </button>
      </td>
      <td style="vertical-align: middle" class="text-center">
        <a class="btn btn-sm btn_hieuchinh" style="font-size:18px;padding:10px; cursor: pointer;" data-title="Hiệu chỉnh"
          href="index.php?option=com_quantrihethong&view=quantrihethong&task=edit_user&id=${account.id}">
          <i class="fas fa-pencil-alt"></i>
        </a>
        <span style="padding: 0 0px;font-size:22px;color:#999">|</span>
        <span class="btn btn-sm btn_xoa" style="font-size:18px;padding:10px; cursor: pointer;"
          data-title="Xóa" data-account="${account.id}">
          <i class="fas fa-trash-alt"></i>
        </span>
      </td>
    </tr>
  `).join('');
  }

  // hàm render phân trang
  function renderPagination(currentPage, totalPages, totalRecord, take) {
    if (totalPages <= 1) return '';
    const range = 2;
    const startPage = Math.max(1, currentPage - range);
    const endPage = Math.min(totalPages, currentPage + range);
    let html = '<ul class="pagination">';

    // First and Previous buttons
    html += `<li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
        <a class="page-link" href="#" data-page="1">&lt;&lt;</a>
      </li>`;
    html += `<li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
        <a class="page-link" href="#" data-page="${Math.max(1, currentPage - 1)}">&lt;</a>
      </li>`;

    // Page numbers
    if (startPage > 1) html += '<li class="page-item disabled"><span class="page-link">...</span></li>';
    for (let i = startPage; i <= endPage; i++) {
      html += `<li class="page-item ${i === currentPage ? 'active' : ''}">
          <a class="page-link" href="#" data-page="${i}">${i}</a>
        </li>`;
    }
    if (endPage < totalPages) html += '<li class="page-item disabled"><span class="page-link">...</span></li>';

    // Next and Last buttons
    html += `<li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
        <a class="page-link" href="#" data-page="${Math.min(totalPages, currentPage + 1)}">&gt;</a>
      </li>`;
    html += `<li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
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
      $('#tbody_danhsach').html('<tr><td colspan="6" class="text-center">Đang tải dữ liệu...</td></tr>');
      const response = await $.ajax({
        url: `${baseUrl}&task=getListAccount`,
        method: 'POST',
        data: {
          page,
          take,
          keyword,
          [csrfToken]: 1
        }
      });

      const accounts = response.data || [];
      const currentPage = response.page || 1;
      const totalRecord = response.totalrecord || 0;
      const totalPages = Math.ceil(totalRecord / take);
      const start = (currentPage - 1) * response.take + 1;;

      // Render table and pagination
      $('#tbody_danhsach').html(renderTableRows(accounts, start));
      const {
        pagination,
        info
      } = renderPagination(currentPage, totalPages, totalRecord, take);
      $('#pagination').html(pagination);
      $('.pagination-info').text(info);

      // Update browser URL without reloading
      history.pushState({}, '', `?view=quantrihethong&task=ds_taikhoan&page=${currentPage}${keyword ? `&keyword=${encodeURIComponent(keyword)}` : ''}`);
    } catch (error) {
      console.error('Error:', error);
      $('#tbody_danhsach').html('<tr><td colspan="6" class="text-center">Lỗi khi tải dữ liệu</td></tr>');
      showToast('Lỗi khi tải dữ liệu', 'danger');
    }
  }

  $(document).ready(function() {
    // khởi tạo load data
    const urlParams = new URLSearchParams(window.location.search);
    const initialPage = parseInt(urlParams.get('page')) || 1;
    const initialKeyword = urlParams.get('keyword') || '';
    loadData(initialPage, initialKeyword);

    $('#pagination').on('click', '.page-link', function(e) {
      e.preventDefault();
      const page = parseInt($(this).data('page'));
      if (!isNaN(page) && !$(this).parent().hasClass('disabled')) {
        loadData(page, $('#keyword').val());
      }
    });

    // search 
    $('#btn_filter').on('click', function(e) {
      e.preventDefault();
      loadData(1, $('#keyword').val());
    });

    // Reset button
    $('[data-action="reload"]').on('click', function() {
      $('#keyword').val('');
      loadData(1, '');
    });

    // change status 
    $('body').on('click', '.btn_doitrangthai', function() {
      const $input = $(this);
      const id = $input.data('key');
      const newStatus = $input.data('status') == 0 ? 1 : 0;

      $.post(baseUrl, {
        task: 'changeStatusCTL',
        id,
        status: newStatus,
        [csrfToken]: 1
      }, function(data) {
        if (data.result == 1) {
          $input.data('status', newStatus);
          showToast('Cập nhật trạng thái thành công', 'success');
        } else {
          $input.prop('checked', !newStatus);
          showToast('Cập nhật trạng thái thất bại', 'danger');
        }
      }).fail(() => {
        $input.prop('checked', !newStatus);
        showToast('Lỗi khi cập nhật trạng thái', 'danger');
      });
    });

    // reset password
    $('body').on('click', '.btn_reset_password', function() {
      const index = $('.btn_reset_password').index($(this));
      const password = $('input[name="input-reset"]').eq(index).val();
      const name = $(this).data('name');
      const id = $(this).data('id');

      if (!password) {
        showToast('Vui lòng nhập mật khẩu mới', 'warning');
        return;
      }

      if (!confirm(`Bạn có chắc chắn muốn cập nhật mật khẩu của ${name}?`)) return;

      $.post('index.php', {
        option: 'com_quantrihethong',
        controller: 'quantrihethong',
        task: 'resetPasswordCTL',
        id,
        password
      }, function(data) {
        if (data.success == true) {
          showToast('Cập nhật mật khẩu thành công', 'success');
          // window.location.reload()
        } else {
          showToast('Cập nhật mật khẩu thất bại', 'danger');
        }
      });
    });

    // delete account
    $('body').on('click', '.btn_xoa', async function() {
      if (!confirm('Bạn có chắc chắn muốn xóa dữ liệu này?')) return;

      const idAccount = $(this).data('account');
      try {
        const response = await fetch(`${baseUrl}&task=quantrihethong.deleteAccountCTL`, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({
            idUser,
            idAccount,
            [csrfToken]: 1
          })
        });
        const data = await response.json();
        showToast(data.message || 'Xóa thành công', 'success');
        if (data.success !== false) {
          loadData(1, $('#keyword').val());
        }
      } catch (error) {
        console.error('Error:', error);
        showToast('Đã xảy ra lỗi khi xóa dữ liệu', 'danger');
      }
    });
  });
</script>

<style>
  .danhsach {
    padding: 20px;
  }

  .input-reset {
    border-radius: 4px 0 0 4px;
  }

  .custom-toggle {
    position: relative;
    display: inline-block;
    width: 52px;
    height: 28px;
  }

  .custom-toggle input {
    opacity: 0;
    width: 0;
    height: 0;
  }

  .slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    transition: background-color 0.4s;
    border-radius: 34px;
  }

  .slider:before {
    content: "";
    position: absolute;
    height: 22px;
    width: 22px;
    left: 3px;
    bottom: 3px;
    background-color: white;
    transition: transform 0.4s;
    border-radius: 50%;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
  }

  input:checked+.slider {
    background-color: #007b8bb8;
  }

  input:checked+.slider:before {
    transform: translateX(24px);
  }

  .slider::after {
    content: "✕";
    position: absolute;
    left: 8px;
    top: 4px;
    font-size: 14px;
    color: #fff;
    transition: all 0.4s ease;
  }

  input:checked+.slider::after {
    content: "✓";
    left: 28px;
  }

  .pagination {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 10px;
    margin: 20px 0;
    font-family: Arial, sans-serif;
  }

  .pagination button,
  .pagination span {
    padding: 8px 12px;
    border: 1px solid #ddd;
    border-radius: 4px;
    cursor: pointer;
    background-color: #f9f9f9;
    transition: background-color 0.3s;
  }

  .pagination button:hover:not(:disabled) {
    background-color: #007bff;
    color: white;
  }

  .pagination button:disabled {
    cursor: not-allowed;
    opacity: 0.5;
  }

  .pagination span.active {
    background-color: #007bff;
    color: white;
    border-color: #007bff;
  }

  .pagination span {
    cursor: default;
  }
</style>