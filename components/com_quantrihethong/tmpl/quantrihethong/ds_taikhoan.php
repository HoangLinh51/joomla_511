<?php

use Joomla\CMS\Factory;
use Joomla\CMS\Router\Route;

defined('_JEXEC') or die('Restricted access');
$user = Factory::getUser();

?>
<div class="danhsach">
  <div class="content-header">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h3 class="m-0 text-primary"><i class="fas fa-users"></i> Danh sách tài khoản </h3>
      </div>
      <div class="col-sm-6 text-right" style="padding:0;">
        <?php if ($is_quyen == 0) { ?>
          <a href="index.php?option=com_quantrihethong&view=quantrihethong&task=edit_user" class="btn btn-primary" style="font-size:16px;width:136px">
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
        <tr style="background-color: #FBFBFB !important;" class="bg-primary text-white">
          <th style="vertical-align:middle;color:#4F4F4F!important;" class="text-center">STT</th>
          <th style="vertical-align:middle;color:#4F4F4F!important;" class="text-center">Họ và tên</th>
          <th style="vertical-align:middle;color:#4F4F4F!important;" class="text-center">Tên người dùng</th>
          <th style="vertical-align:middle;color:#4F4F4F!important;" class="text-center">Trạng thái</th>
          <th style="vertical-align:middle;color:#4F4F4F!important; width: 25%" class="text-center">Đặt lại mật khẩu</th>
          <th style="vertical-align:middle;color:#4F4F4F!important; width:135px" class="text-center">Chức năng</th>
        </tr>
      </thead>
      <tbody id="tbody_danhsach">
        <?php
        if (!empty($this->accounts)) {
          $stt = Factory::getApplication()->input->getInt('start', 0) + 1;
          foreach ($this->accounts as $account):
        ?>
            <tr>
              <td class="text-center" style="vertical-align: middle"><?php echo $stt++; ?></td>
              <td style="vertical-align: middle; max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="<?php echo htmlspecialchars($account['name']); ?>">
                <?php echo htmlspecialchars($account['name']); ?>
              </td>
              <td style="vertical-align: middle"><?php echo htmlspecialchars($account['username']); ?></td>
              <td style="vertical-align: middle; text-align: center">
                <label class="custom-toggle">
                  <input type="checkbox" class="btn_doitrangthai"
                    data-key="<?php echo $account['id']; ?>"
                    data-status="<?php echo $account['block']; ?>"
                    <?php echo ($account['block'] == 0) ? 'checked' : ''; ?>>
                  <span class="slider"></span>
                </label>

              </td>
              <td style="vertical-align: middle;" class="text-center d-flex align-items-center">
                <input type="text" class="form-control input-reset" name="input-reset">
                <button class="btn btn-primary btn_reset_password" data-name="<?php echo $account['name']; ?>" data-id="<?php echo $account['id']; ?>">
                  <i class="fas fa-sync-alt"></i>
                </button>
              </td>
              <td style="vertical-align: middle" class="text-center">
                <a class="btn btn-sm btn_hieuchinh" style="font-size:18px;padding:10px; cursor: pointer;" data-title="Hiệu chỉnh"
                  href="<?php echo Route::_('index.php?option=com_quantrihethong&view=quantrihethong&task=edit_user&id=' . $account['id']); ?>">
                  <i class="fas fa-pencil-alt"></i>
                </a>
                <span style="padding: 0 0px;font-size:22px;color:#999">|</span>
                <span class="btn btn-sm btn_xoa" style="font-size:18px;padding:10px; cursor: pointer;"
                  data-title="Xóa" data-account="<?php echo $account['id']; ?>">
                  <i class="fas fa-trash-alt"></i>
                </span>
              </td>
            </tr>
          <?php
          endforeach;
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
    <!-- pagination -->
    <div class="pagination-container d-flex align-items-center mt-3">
      <div id="pagination" class="mx-auto">
        <?php if ($totalPages > 1): ?>
          <ul class="pagination">
            <li class="page-item <?= $currentPage == 1 ? 'disabled' : ''; ?>">
              <a class="page-link" href="#" data-page="1">
                <<
                  </a>
            </li>
            <li class="page-item <?= $currentPage == 1 ? 'disabled' : ''; ?>">
              <a class="page-link" href="#" data-page="<?= max(1, $currentPage - 1); ?>">
                <
                  </a>
            </li>
            <?php
            $range = 2;
            $startPage = max(1, $currentPage - $range);
            $endPage = min($totalPages, $currentPage + $range);

            if ($startPage > 1) {
              echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
            }
            for ($i = $startPage; $i <= $endPage; $i++): ?>
              <li class="page-item <?= $i == $currentPage ? 'active' : ''; ?>">
                <a class="page-link" href="#" data-page="<?= $i; ?>"><?= $i; ?></a>
              </li>
            <?php endfor;

            if ($endPage < $totalPages) {
              echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
            }
            ?>
            <li class="page-item <?= $currentPage == $totalPages ? 'disabled' : ''; ?>">
              <a class="page-link" href="#" data-page="<?= min($totalPages, $currentPage + 1); ?>">></a>
            </li>
            <li class="page-item <?= $currentPage == $totalPages ? 'disabled' : ''; ?>">
              <a class="page-link" href="#" data-page="<?= $totalPages; ?>">>></a>
            </li>
          </ul>
        <?php endif; ?>
      </div>

      <div class="pagination-info text-right ml-3">
        <?php if ($this->countItems > 0): ?>
          Hiển thị <?= $startRecord; ?> - <?= $endRecord; ?> của <?= $this->countItems; ?> mục (<?= $totalPages; ?> trang)
        <?php else: ?>
          Không có dữ liệu trang
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<script>
  function showToast(message, type = 'success') {
    let color;

    switch (type) {
      case 'success':
        color = '#28a745'; // xanh
        break;
      case 'danger':
        color = '#dc3545'; // đỏ
        break;
      case 'warning':
        color = '#ffc107'; // vàng
        break;
      default:
        color = '#17a2b8'; // xanh nhạt (info)
    }

    const toast = $('<div></div>')
      .text(message)
      .css({
        position: 'fixed',
        top: '20px',
        right: '20px',
        background: color,
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
      }, 300); // fade-in

    // Tự động biến mất
    setTimeout(() => {
      toast.fadeOut(500, () => toast.remove());
    }, 2000);
  }

  $(document).ready(function() {
    const idUser = <?= (int)Factory::getUser()->id ?>;

    $('body').delegate('.btn_doitrangthai', 'click', function() {
      const status = $(this).data('status');
      if ($(this).data('status') == 1) {
        $(this).data('status', 0);
      } else {
        $(this).data('status', 1);
      }
      console.log('status', status, '---', $(this).data('task'), '---', $(this).data('key'))
      $.post('index.php', {
        option: 'com_quantrihethong',
        controller: 'quantrihethong',
        task: 'trangthaiTK',
        id: $(this).data('key'),
        status: status
      }, function(data) {
        if (data == 1) {
          showToast('Cập nhật trạng thái thành công', 'success');
        } else {
          showToast('Cập nhật trạng thái thất bại', 'danger');
        }
      });
    });

    $('body').delegate('.btn_reset_password', 'click', function() {
      const row_index = $('.btn_reset_password').index($(this))
      const matkhau_capnhat = $('input[name="input-reset"]').eq(row_index).val()
      const name = $(this).data('name')
      const confirmed = confirm(`Bạn có chắc chắn muốn cập nhật lại mật khẩu của ${name} này không?`);

      if (!confirmed) return;
      if (matkhau_capnhat == '' || matkhau_capnhat == null) {
        showToast('Không có gì để cập nhật', 'warning')
      } else {
        console.log

        $.post('index.php', {
          option: 'com_quantrihethong',
          controller: 'quantrihethong',
          task: 'capnhatMK',
          id: $(this).data('id'),
          matkhau: matkhau_capnhat
        }, function(data) {
          console.log(data)
          if (data.success == true) {
            showToast('Cập nhật mật khẩu thành công', 'success');
            // window.location.reload()
          } else {
            showToast('Cập nhật mật khẩu thất bại', 'danger');
          }
        });
      }
    });

    //hàm load data
    function loadData(page, keyword, perPage = 20) {
      $("#tbody_danhsach").html('<tr><td colspan="9"><strong>loading...</strong></td></tr>');
      $.ajax({
        url: 'index.php?option=com_quantrihethong&controller=quantrihethong&task=getDanhSachQuanTriHeThong',
        method: "POST",
        data: {
          page: page,
          perPage: perPage,
          keyword: keyword || ""
        },
        success: function(responseData) {
          console.log(responseData)
          if (Array.isArray(responseData) && responseData.length > 0) {
            let html = '';
            responseData.forEach(function(item, index) {
              statusHtml = '';
              switch (parseInt(item.status)) {
                case 1:
                  statusHtml = '<span class="text-warning">Chờ xử lý</span>';
                  break;
                case 2:
                  statusHtml = '<span class="text-success">Đã hoàn thành</span>';
                  break;
                case 3:
                  statusHtml = '<span class="text-danger">Đã hủy</span>';
                  break;
                default:
                  statusHtml = '<span class="text-muted">Không xác định</span>';
                  break;
              }
              html += `
                <tr>
                  <td class="text-center" style="vertical-align: middle">${index + 1}</td>
                  <td style="vertical-align: middle">
                    <a href="/index.php/component/quantrihethong/?view=quantrihethong&task=detail_quantrihethong&id=${item.id}">
                      ${item.name_error || ''}
                    </a>
                  </td>
                  <td style="vertical-align:middle;">${item.name_module || ''}</td>
                  <td style="vertical-align:middle;">${item.content || ''}</td>
                  <td style="vertical-align:middle;">${statusHtml}</td>
                </tr>`;
            });
            $("#tbody_danhsach").html(html);
          } else {
            $("#tbody_danhsach").html('<tr><td colspan="9" class="text-center text-danger">Không có dữ liệu</td></tr>');
          }
        }
      });
    }

    $('body').on('click', '.btn_xoa', function() {
      const confirmed = confirm('Bạn có chắc chắn muốn xóa dữ liệu này?');
      if (!confirmed) return;

      const url = "<?= Route::_('index.php?option=com_quantrihethong&task=quantrihethong.xoa_taikhoan') ?>";
      const tokenName = Joomla.getOptions('csrf.token');

      const payload = {
        idUser: idUser,
        idAccount: $(this).data('account')
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
          showToast(data.message || 'Xóa thành công', 'success');
          if (isSuccess) {
            setTimeout(() => location.reload(), 500);
          }
        })
        .catch(error => {
          console.error('Lỗi:', error);
          showToast('Đã xảy ra lỗi khi xóa dữ liệu', 'danger');
        });
    });
    //hành động search 
    $('#btn_filter').on('click', function(e) {
      e.preventDefault();

      let keyword = $('#keyword').val();
      let page = 1;
      loadData(page, keyword, 20)
    })
    //hành động chuyển trang
    $('body').on('click', "#pagination .page-link", function(e) {
      e.preventDefault()
      let page = $(this).data('page')
      $('#pagination .page-item').removeClass('active')
      $(this).parent().addClass('active')
      loadData(page, '', 20)
    })
  });
</script>

<style>
  .danhsach {
    padding: 20px;
  }

  .input-reset {
    border-radius: 4px 0px 0px 4px;
  }

  .button-reset {
    border-radius: 0px 4px 4px 0px;
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
    background-color: #007bff;
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
</style>