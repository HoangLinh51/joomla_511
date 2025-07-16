<?php

use Joomla\CMS\Factory;
use Joomla\CMS\Router\Route;

defined('_JEXEC') or die('Restricted access');
?>
<div class="danhsach">
  <div class="content-header">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h3 class="m-0 text-primary"><i class="fas fa-users"></i> Quản lý báo cáo lỗi</h3>
      </div>
      <?php if ($this->permissioError === true) { ?>
        <div class="col-sm-6 text-right" style="padding:0;">
          <a href="<?php echo Route::_('index.php?option=com_dungchung&view=baocaoloi&task=add_baocaoloi') ?>" class="btn btn-primary" style="font-size:16px;width:136px">
            <i class="fas fa-plus"></i> Thêm mới
          </a>
        </div>
      <?php } ?>
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
            <input type="text" name="keyword" id="keyword" class="form-control" style="font-size:16px;" placeholder="Tìm kiếm tên lỗi, tên module hoặc nội dung lỗi" />
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
        <tr class="bg-primary">
          <th style="vertical-align: middle" class="text-center">STT</th>
          <th style="vertical-align: middle" class="text-center">Tên lỗi</th>
          <th style="vertical-align: middle" class="text-center">Tên module</th>
          <th style="vertical-align: middle" class="text-center">Nội dung lỗi</th>
          <th style="width:131px; vertical-align: middle" class="text-center">Trạng thái</th>
        </tr>
      </thead>
      <tbody id="tbody_danhsach">
        <tr>
          <td colspan="6" class="text-center">Đang tải dữ liệu...</td>
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

  function renderStatus(status) {
    switch (parseInt(status)) {
      case 1:
        return statusHtml = '<span class="badge bg-warning">Chờ xử lý</span>';
      case 2:
        return statusHtml = '<span class="badge bg-success">Đã hoàn thành</span>';
      case 3:
        return statusHtml = '<span class="badge bg-danger">Đã hủy</span>';
      default:
        return statusHtml = '<span class="badge bg-secondary">Không xác định</span>';
    }
  }

  function renderTBody(items, start) {
    if (!items || items.length === 0) {
      return '<tr><td colspan="5" class="text-center">Không có dữ liệu</td></tr>';
    }
    return items.map((item, index) => `
    <tr>
      <td class="text-center" style="vertical-align: middle">${start + index}</td>
      <td style="vertical-align: middle">
        <a href="/index.php/component/dungchung/?view=baocaoloi&task=detail_baocaoloi&id=${item.id}">
          ${item.error_id !== 12 ? item.name_error || '' : `${item.name_error || ''} (${item.enter_error || ''})`}
        </a>
      </td>
      <td style="vertical-align:middle;">${item.name_module || ''}</td>
      <td style="vertical-align:middle;">${item.content || ''}</td>
      <td style="vertical-align:middle;" class="text-center">${renderStatus(item.status)}</td>
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

  async function loadData(page = 1, keyword = '', take = 20) {
    try {
      $('#tbody_danhsach').html('<tr><td colspan="5" class="text-center">Đang tải dữ liệu...</td></tr>');
      const response = await $.ajax({
        url: 'index.php?option=com_dungchung&controller=baocaoloi&task=getListErrorReport',
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

      history.pushState({}, '', `?view=baocaoloi&task=default&page=${currentPage}${keyword ? `&keyword=${encodeURIComponent(keyword)}` : ''}`);
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

  $(document).ready(function() {
    // Initialize from URL parameters
    const urlParams = new URLSearchParams(window.location.search);
    const initialPage = parseInt(urlParams.get('page')) || 1;
    const initialKeyword = urlParams.get('keyword') || '';

    // Load initial data
    loadData(initialPage, initialKeyword);

    // Search handler
    $('#btn_filter').on('click', function(e) {
      e.preventDefault();
      const keyword = $('#keyword').val();
      loadData(1, keyword);
    });

    // Reset search handler
    $('.un-collapsed-card[data-action="reload"]').on('click', function(e) {
      e.preventDefault();
      $('#keyword').val('');
      loadData(1, '');
    });

    // Pagination handler
    $('body').on('click', '#pagination .page-link', function(e) {
      e.preventDefault();
      const page = parseInt($(this).data('page'));
      const keyword = $('#keyword').val();
      $('#pagination .page-item').removeClass('active');
      $(this).parent().addClass('active');
      loadData(page, keyword);
    });
  });
</script>

<style>
  .danhsach {
    padding: 20px;
  }
</style>