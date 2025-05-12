<?php

use Joomla\CMS\Factory;
use Joomla\CMS\Router\Route;

defined('_JEXEC') or die('Restricted access');
$perPage = 20;
$result = $this->countItems;
$totalPages = ceil($totalRecords / $perPage);
$currentPage = Factory::getApplication()->input->getInt('start', 0) / $perPage + 1;

// Tính toán START và END
$startRecord = Factory::getApplication()->input->getInt('start', 0) + 1;
$endRecord = min($startRecord + $perPage - 1, $totalRecords);
$modelThongBao = Core::model('Thongbao/Thongbao');

?>
<div class="danhsach">
  <div class="content-header">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h3 class="m-0 text-primary"><i class="fas fa-users"></i> Quản lý thông tin nhân hộ khẩu</h3>
      </div>
      <div class="col-sm-6 text-right" style="padding:0;">
        <?php if ($is_quyen == 0) { ?>
          <a href="index.php?option=com_thongbao&view=thongbao&task=add_thongbao" class="btn btn-primary" style="font-size:16px;width:136px">
            <i class="fas fa-plus"></i> Thêm mới
          </a>
        <?php } ?>
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
          <td style="width:5%;padding:10px;" nowrap><b class="text-primary" style="font-size:17px;line-height:2.5">Tiêu đề</b></td>
          <td style="width:45%;">
            <input type="text" name="tieude" id="tieude" class="form-control" style="font-size:16px;" placeholder="Nhập tiêu đề " />
          </td>
          <td style="width:5%;padding:10px;" nowrap><b class="text-primary" style="font-size:17px;line-height:2.5">Nội dung</b></td>
          <td style="width:45%;">
            <input type="text" name="noidung" id="noidung" class="form-control" style="font-size:16px;" placeholder="Nhập nội dung" />
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
        <tr style="background-color: #FBFBFB !important;" class="bg-primary text-white">
          <th style="vertical-align:middle;color:#4F4F4F!important;" class="text-center">STT</th>
          <th style="vertical-align:middle;color:#4F4F4F!important;" class="text-center">Tiêu đề</th>
          <th style="vertical-align:middle;color:#4F4F4F!important;" class="text-center">Nội dung</th>
          <th style="vertical-align:middle;color:#4F4F4F!important;" class="text-center">Văn bản đính kèm</th>
          <th style="vertical-align:middle;color:#4F4F4F!important;" class="text-center" style="width:131px;">Chức năng</th>
        </tr>
      </thead>
      <tbody id="tbody_danhsach">
        <?php
        if (!empty($this->item)) {
          $stt = Factory::getApplication()->input->getInt('start', 0) + 1;
          foreach ($this->item as $item) {
        ?>
            <tr>
              <td class="text-center" style="vertical-align: middle"><?php echo $stt++; ?></td>
              <td style="vertical-align: middle">
                <a href="<?php echo '/index.php/component/thongbao/?view=thongbao&task=detail_thongbao&id=' . $item->id; ?>">
                  <?php echo htmlspecialchars($item->tieude); ?>
                </a>
              </td>
              <td style="vertical-align: middle"><?php echo htmlspecialchars($item->noidung); ?></td>
              <td style="vertical-align: middle" class="text-center">
                <?php if ($item->vanbandinhkem): ?>
                  <?php foreach ($modelThongBao->getVanBan($item->vanbandinhkem) as $vanban): ?>
                    <a href="<?php echo '/index.php?option=com_core&controller=attachment&format=raw&task=download&year=' . $vanban->nam . '&code=' . $vanban->code; ?>">
                      <?php echo $vanban->filename ?>
                    </a>
                    <br />
                  <?php endforeach ?>
                <?php endif ?>
              </td>
              <td class="text-center">
                <a class="btn btn-sm btn_hieuchinh" style="font-size:18px;padding:10px; cursor: pointer;" href="<?php echo Route::_('index.php?option=com_thongbao&view=thongbao&task=edit_thongbao&id=' . $item->id); ?>" data-title="Hiệu chỉnh">
                  <i class="fas fa-pencil-alt"></i>
                </a>
                <span style="padding: 0 0px;font-size:22px;color:#999">|</span>
                <span class="btn btn-sm btn_xoa" style="font-size:18px;padding:10px; cursor: pointer;" data-thongbao="<?php echo $item->id; ?>" data-title="Xóa">
                  <i class="fas fa-trash-alt"></i>
                </span>
              </td>
            </tr>
          <?php
          }
        } else {
          ?>
          <tr>
            <td colspan="8" class="text-center">Không có dữ liệu</td>
          </tr>
        <?php
        }
        ?>
      </tbody>
    </table>

    <!-- Bọc pagination-info và pagination trong một div Flexbox -->
    <div class="pagination-container d-flex align-items-center mt-3">
      <div id="pagination" class="mx-auto">
        <?php if ($totalPages > 1): ?>
          <ul class="pagination">
            <li class="page-item <?php echo $currentPage == 1 ? 'disabled' : ''; ?>">
              <a class="page-link" href="#" data-page="1">
              </a>
            </li>
            <li class="page-item <?php echo $currentPage == 1 ? 'disabled' : ''; ?>">
              <a class="page-link" href="#" data-page="<?php echo max(1, $currentPage - 1); ?>">
              </a>
            </li>
            <?php
            $range = 2;
            $startPage = max(1, $currentPage - $range);
            $endPage = min($totalPages, $currentPage + $range);

            if ($startPage > 1) {
              echo '<li class="page-item"><span class="page-link">...</span></li>';
            }

            for ($i = $startPage; $i <= $endPage; $i++) {
            ?>
              <li class="page-item <?php echo $i == $currentPage ? 'active' : ''; ?>">
                <a class="page-link" href="#" data-page="<?php echo $i; ?>"><?php echo $i; ?></a>
              </li>
            <?php
            }

            if ($endPage < $totalPages) {
              echo '<li class="page-item"><span class="page-link">...</span></li>';
            }
            ?>
            <li class="page-item <?php echo $currentPage == $totalPages ? 'disabled' : ''; ?>">
              <a class="page-link" href="#" data-page="<?php echo min($totalPages, $currentPage + 1); ?>">></a>
            </li>
            <li class="page-item <?php echo $currentPage == $totalPages ? 'disabled' : ''; ?>">
              <a class="page-link" href="#" data-page="<?php echo $totalPages; ?>">>></a>
            </li>
          </ul>
        <?php endif; ?>
      </div>

      <div class="pagination-info text-right">
        <?php if ($totalRecords > 0): ?>
          Hiển thị <?php echo $startRecord; ?> - <?php echo $endRecord; ?> của tổng cộng <?php echo $totalRecords; ?> mục
          (<?php echo $totalPages; ?> trang)
        <?php else: ?>
          Không có dữ liệu trang
        <?php endif; ?>
      </div>
    </div>

    <input type="hidden" id="totalPages" value="<?php echo $totalPages; ?>">
    <input type="hidden" id="currentPage" value="<?php echo $currentPage; ?>">
  </div>
</div>


<!-- <script type="text/javascript">
  jQuery(document).ready(function($) {
    var totalPages = parseInt($('#totalPages').val());
    var currentPage = parseInt($('#currentPage').val());

    // Xử lý click vào phân trang
    $('.pagination').on('click', '.page-link', function(e) {
      e.preventDefault();
      var page = $(this).data('page');
      if (page && !$(this).parent().hasClass('disabled') && !$(this).parent().hasClass('active')) {
        var start = (page - 1) * <?php echo $perPage; ?>;
        loadDanhSach(start);
      }
    });

    // Xử lý click vào tên chủ hộ
    $(document).on('click', '.hoten-link', function(e) {
      e.preventDefault();
      var hokhauId = $(this).data('hokhau');
      loadDetail(hokhauId);
    });

    // Xử lý click vào tên trong danh sách
    $(document).on('click', '.name-link', function(e) {
      e.preventDefault();
      var id = $(this).data('id');

      // Ẩn tất cả chi tiết và hiển thị chi tiết tương ứng
      $('.detail-item').hide();
      $('#detail-' + id).show();

      // Cập nhật class active
      $('.name-link').removeClass('active');
      $(this).addClass('active');
    });

    $('<style>.small-alert .bootbox.modal { width: 300px !important; margin: 0 auto; } .small-alert .modal-dialog { width: 300px !important; } .small-alert .modal-footer { display:none } .small-alert .modal-header { height:44px; padding: 7px 20px } .small-alert .modal-body { padding:14px } .success-icon { margin-right: 8px; vertical-align: middle; } </style>').appendTo('head');


    // $('body').delegate('.btn_xoa', 'click', function() {
    //   var hokhau_id = $(this).data('hokhau');
    //   bootbox.confirm({
    //     title: "<span class='red' style='font-weight:bold;font-size:20px;'>Thông báo</span>",
    //     message: '<span class="red" style="font-size:20px;">Bạn có chắc chắn muốn xóa dữ liệu này?</span>',
    //     buttons: {
    //       confirm: {
    //         label: '<i class="icon-ok"></i> Đồng ý',
    //         className: 'btn-success'
    //       },
    //       cancel: {
    //         label: '<i class="icon-remove"></i> Không',
    //         className: 'btn-danger'
    //       }
    //     },
    //     callback: function(result) {
    //       if (result) {
    //         console.log('Sending AJAX with hokhau_id:', hokhau_id);
    //         $.ajax({
    //           url: Joomla.getOptions('system.paths').base + 'index.php?option=com_thongbao&task=thongbao.xoa_thongbao&id=' + <?= $item->id ?>,
    //           type: 'POST',
    //           data: {
    //             hokhau_id: hokhau_id,
    //             [Joomla.getOptions('csrf.token')]: 1
    //           },
    //           success: function(response) {
    //             console.log('AJAX Success:', response);
    //             var res = typeof response === 'string' ? JSON.parse(response) : response;
    //             var message = res.success ? res.message : 'Xóa thất bại!';
    //             var icon = res.success ?
    //               '<svg class="success-icon" width="20" height="20" viewBox="0 0 20 20" fill="green"><path d="M10 0C4.48 0 0 4.48 0 10s4.48 10 10 10 10-4.48 10-10S15.52 0 10 0zm-1 15.59L4.41 11l1.42-1.42L9 12.17l5.59-5.58L16 8l-7 7z"/></svg>' :
    //               '';
    //             bootbox.alert({
    //               title: icon + "<span style='font-weight:bold;font-size:20px;'>Thông báo</span>",
    //               message: '<span style="font-size:20px;">' + message + '</span>',
    //               backdrop: true,
    //               className: 'small-alert',
    //               buttons: {
    //                 ok: {
    //                   label: 'OK',
    //                   className: 'hidden' // Ẩn nút OK
    //                 }
    //               },
    //               onShown: function() {
    //                 // Tự động đóng sau 2 giây
    //                 // setTimeout(function() {
    //                 //     bootbox.hideAll();
    //                 //     if (res.success) {
    //                 //         window.location.reload();
    //                 //     }
    //                 // }, 2000);
    //               }
    //             });
    //           },
    //           error: function(xhr) {
    //             console.error('AJAX Error:', xhr.status, xhr.responseText);
    //             bootbox.alert({
    //               title: "<span style='font-weight:bold;font-size:20px;'>Thông báo</span>",
    //               message: '<span style="font-size:20px;">Lỗi: ' + xhr.responseText + '</span>',
    //               className: 'small-alert',
    //               buttons: {
    //                 ok: {
    //                   label: 'OK',
    //                   className: 'hidden' // Ẩn nút OK
    //                 }
    //               },
    //               onShown: function() {
    //                 // Tự động đóng sau 2 giây
    //                 setTimeout(function() {
    //                   bootbox.hideAll();
    //                 }, 2000);
    //               }
    //             });
    //           }
    //         });
    //       }
    //     },
    //     className: 'custom-bootbox'
    //   });
    // });
  });
</script> -->
<script>
  $(document).ready(function() {
    const idUser = <?= (int)Factory::getUser()->id ?>;
    const idThongbao = <?= (int)$item->id ?>;

    $('body').on('click', '.btn_xoa', function() {
      const confirmed = confirm('Bạn có chắc chắn muốn xóa dữ liệu này?');
      if (!confirmed) return;

      const url = "<?= Route::_('index.php?option=com_thongbao&task=thongbao.xoa_thongbao') ?>";

      fetch(url, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({
            idUser: idUser,
            idThongbao: $(this).data('thongbao'),
            [Joomla.getOptions('csrf.token')]: 1
          })
        })
        .then(response => response.json())
        .then(data => {
          const isSuccess = data.success ?? true;
          showToast(data.message || 'Xóa thành công', isSuccess);
          if (isSuccess) {
            setTimeout(() => location.reload(), 1000);
          }
        })
        .catch(error => {
          console.error('Lỗi:', error);
          showToast('Đã xảy ra lỗi khi xóa dữ liệu', false);
        });
    });

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

      setTimeout(() => toast.fadeOut(500, () => toast.remove()), 2000);
    }
  });
</script>

<style>
  .danhsach {
    padding: 20px;
  }

  .modal {
    overflow-x: hidden;
  }

  .modal-dialog {
    max-width: 1200px;
    min-width: 300px;
    width: 1000px;
    margin-left: auto;
    margin-right: 0;
    margin-top: 1.75rem;
    margin-bottom: 1.75rem;
    transform: translateX(100%);
    transition: transform 0.5s ease-in-out;
  }

  .modal.show .modal-dialog {
    transform: translateX(0);
  }

  .modal.fade .modal-dialog {
    transition: transform 0.5s ease-in-out;
    opacity: 1;
  }

  .modal.fade:not(.show) .modal-dialog {
    transform: translateX(100%);
  }

  .modal-body {
    padding: 20px;
    word-break: break-word;
  }

  .modal-body p {
    margin-bottom: 10px;
    font-size: 16px;
  }

  .modal-content {
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
  }

  .modal-header,
  .modal-footer {
    padding: 15px 20px;
  }

  .name-list {
    max-height: 400px;
    overflow-y: auto;
  }

  .name-list ul {
    margin: 0;
    padding: 0;
  }

  .name-list li {
    margin-bottom: 5px;
  }

  .name-link {
    display: block;
    padding: 5px 10px;
    color: #007bff;
    text-decoration: none;
    border-radius: 4px;
  }

  .name-link:hover {
    background-color: #f0f0f0;
    text-decoration: none;
  }

  .name-link.active {
    background-color: #007bff;
    color: white;
  }

  .detail-container {
    min-height: 300px;
  }

  .hoten-link {
    color: #007bff;
    text-decoration: none;
    cursor: pointer;
  }

  .hoten-link:hover {
    text-decoration: underline;
  }

  .pagination-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 1rem;
  }

  .pagination {
    display: inline-flex;
    justify-content: center;
    margin: 0;
  }

  .page-item.disabled .page-link {
    cursor: not-allowed;
    opacity: 0.5;
  }

  .page-item.active .page-link {
    background-color: #007bff;
    border-color: #007bff;
    color: white;
  }

  .page-link {
    padding: 6px 12px;
    margin: 0 2px;
    color: #007bff;
  }

  .page-link:hover {
    background-color: #e9ecef;
  }

  .pagination-info {
    font-size: 14px;
    color: #333;
    white-space: nowrap;
  }

  #detailModal.show .modal-dialog {
    transform: translateX(0);
  }

  .custom-bootbox .modal-dialog {
    width: 498px !important;
    margin: 30px auto !important;
    transform: translateY(-50%);
  }

  .modal {
    overflow-x: hidden;
  }

  .modal-header,
  .modal-footer {
    padding: 15px 20px;
  }

  .modal-body {
    padding: 20px;
    word-break: break-word;
  }
</style>