<?php

use Joomla\CMS\Factory;
use Joomla\CMS\Router\Route;

defined('_JEXEC') or die('Restricted access');
$user = Factory::getUser();
$modelThongBao = Core::model('Thongbao/Thongbao');
$limit = 20; // số bản ghi mỗi trang
$this->item = $modelThongBao->getListThongBao('all', '', 1, 20);
$this->countItems = $modelThongBao->countThongBao($user->id);
// $currentPage = max(1, (int) Factory::getApplication()->input->getInt('page', 1));
// $totalPages = ceil($this->countItems / $limit);
// $startRecord = ($this->countItems > 0) ? (($currentPage - 1) * $limit + 1) : 0;
// $endRecord = min($this->countItems, $currentPage * $limit);


?>
<div class="danhsach">
  <div class="content-header">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h3 class="m-0 text-primary"><i class="fas fa-users"></i> Quản lý thông báo hổ trợ</h3>
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
          <th style="vertical-align:middle;color:#4F4F4F!important;" class="text-center">Tiêu đề</th>
          <th style="vertical-align:middle;color:#4F4F4F!important;" class="text-center">Nội dung</th>
          <th style="vertical-align:middle;color:#4F4F4F!important;" class="text-center">Văn bản đính kèm</th>
          <th style="vertical-align:middle;color:#4F4F4F!important; width:131px;" class="text-center">Chức năng</th>
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
                  <div class="d-flex flex-column">
                    <?php foreach ($item->vanban as $vanban) : ?>
                      <a href="<?php echo '/index.php?option=com_core&controller=attachment&format=raw&task=download&year=' . $vanban->nam . '&code=' . $vanban->code; ?>">
                        <?php echo $vanban->filename ?>
                      </a>
                    <?php endforeach ?>
                  </div>
                <?php endif ?>
              </td>
              <td class="text-center">
                <a class="btn btn-sm btn_hieuchinh" style="font-size:18px;padding:10px; cursor: pointer;"
                  href="<?php echo Route::_('index.php?option=com_thongbao&view=thongbao&task=edit_thongbao&id=' . $item->id); ?>"
                  data-title="Hiệu chỉnh">
                  <i class="fas fa-pencil-alt"></i>
                </a>
                <span style="padding: 0 0px;font-size:22px;color:#999">|</span>
                <span class="btn btn-sm btn_xoa" style="font-size:18px;padding:10px; cursor: pointer;"
                  data-thongbao="<?php echo $item->id; ?>" data-title="Xóa">
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

  $(document).ready(function() {
    const idUser = <?= (int)Factory::getUser()->id ?>;
    const idThongbao = <?= (int)$item->id ?>;

    //hàm load data
    function loadData(page, keyword, perPage = 1) {
      $("#tbody_danhsach").html('<tr><td colspan="9"><strong>loading...</strong></td></tr>');
      $.ajax({
        url: 'index.php?option=com_thongbao&controller=thongbao&task=getDanhSachThongBao',
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
              html += `
                <tr>
                  <td class="text-center" style="vertical-align: middle">${index + 1}</td>
                  <td style="vertical-align: middle">
                    <a href="/index.php/component/thongbao/?view=thongbao&task=detail_thongbao&id=${item.id}">
                      ${item.tieude || ''}
                    </a>
                  </td>
                  <td style="vertical-align:middle;">${item.noidung || ''}</td>
                  <td style="vertical-align: middle" class="text-center">`;
              if (item.vanban && Array.isArray(item.vanban)) {
                item.vanban.forEach(vb => {
                  html += `
                        <a href="/index.php?option=com_core&controller=attachment&format=raw&task=download&year=${vb.nam}&code=${vb.code}">
                          ${vb.filename}
                        </a><br/>`;
                });
              }
              html += `
                  </td>
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
                </tr>`;
            });
            $("#tbody_danhsach").html(html);
          } else {
            $("#tbody_danhsach").html('<tr><td colspan="9" class="text-center text-danger">Không có dữ liệu</td></tr>');
          }
        }
      });
    }
    //hành động search 
    $('#btn_filter').on('click', function(e) {
      e.preventDefault();

      let keyword = $('#keyword').val();
      let page = 1;
      loadData(page, keyword, 1)
    })
    //hành động chuyển trang
    $('body').on('click', "#pagination .page-link", function(e) {
      e.preventDefault()
      let page = $(this).data('page')
      $('#pagination .page-item').removeClass('active')
      $(this).parent().addClass('active')
      loadData(page, '', 1)
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
  .danhsach {
    padding: 20px;
  }
</style>