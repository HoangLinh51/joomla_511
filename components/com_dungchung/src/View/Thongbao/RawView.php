<?php

/*****************************************************************************
 * @Author                : LinhLH                                            *
 * @CreatedDate           : 2025-05-13                                        *
 * @LastEditors           : LinhLH                                            *
 * @LastEditDate          :                                                   *
 * @FilePath              : Joomla_511_svn/components/com_dungchung/src/View/thongbao/RawView.php*
 * @CopyRight             : Dnict                                             *
 ****************************************************************************/

namespace Joomla\Component\DungChung\Site\View\Thongbao;

use Core;
use Joomla\CMS\Factory;
use Joomla\CMS\MVC\View\GenericDataException;
use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;
use Joomla\CMS\Pagination\Pagination;

// phpcs:disable PSR1.Files.SideEffects
\defined('_JEXEC') or die;
// phpcs:enable PSR1.Files.SideEffects

/**
 * Categories view class for the Category package.
 *
 * @since  1.6
 */
class RawView extends BaseHtmlView
{
    /**
     * The pagination object
     *
     * @var    Pagination
     * @since  3.9.0
     */
    protected $pagination;
    /**
     * Display the view
     *
     * @param   string|null  $tpl  The name of the template file to parse; automatically searches through the template paths.
     *
     * @throws  GenericDataException
     *
     * @return  void
     */
    public function display($tpl = null)
    {
        $layout = Factory::getApplication()->input->get('task');
        $layout = ($layout == null) ? 'default' : strtoupper($layout);
        $this->setLayout(strtolower($layout));
        switch ($layout) {
            case 'DETAIL_THONGBAO':
                $this->_pageDetailTHONGBAO();
                break;
            case 'VIEWPDF':
                $this->viewpdf();
                break;
        }
    }

    private function _pageDetailTHONGBAO()
    {
        $app = Factory::getApplication()->input;
        $thongbaoId = $app->getInt('thongbaoId', 0);
        $model = Core::model('Dungchung/ThongBao');

        $detail = $model->getDetailThongbao($thongbaoId);
        if (!$detail) {
            echo '<p class="text-danger">Không tìm thấy thông tin.</p>';
            Factory::getApplication()->close();
            return;
        }

        echo '<div class="container">';
        echo '  <div class="content-box">';
        echo '    <h3 class="m-0">' . htmlspecialchars($detail->tieude) . '</h3>';
        echo '    <hr>';
        echo '    <div class="mb-4">';
        echo '      <h6 class="text-muted">Nội dung:</h6>';
        echo '      <p>' . nl2br(htmlspecialchars($detail->noidung)) . '</p>';
        echo '    </div>';

        if (!empty($detail->vanban) && is_array($detail->vanban)) {
            echo '    <div class="mb-4">';
            echo '      <h6 class="text-muted">Văn bản đính kèm:</h6>';
            echo '      <div class="d-flex flex-column">';
            foreach ($detail->vanban as $vanban) {

                if ($vanban['type'] === 'application/pdf') {
                    echo '        <a href="/index.php?option=com_dungchung&view=thongbao&format=raw&task=viewpdf&file=' . $vanban['code'] . '&folder='.$vanban['folder'] . '" target="_blank">';
                    echo              htmlspecialchars($vanban['filename']);
                    echo '        </a>';
                } else {
                    echo '        <a href="/index.php?option=com_core&controller=attachment&format=raw&task=download&year=' . $vanban['nam'] . '&code=' . $vanban['code'] . '" target="_blank">';
                    echo              htmlspecialchars($vanban['filename']);
                    echo '        </a>';
                }
            }
            echo '      </div>';
            echo '    </div>';
        }
        echo '    <div class="mt-4 border-top pt-3 border-bottom pb-3">';
        echo '      <h6 class="text-muted">Thông tin hệ thống:</h6>';
        echo '      <p class="mb-1 info-text">Người tạo: ' . htmlspecialchars($detail->name) . '</p>';
        echo '      <p class="mb-1 info-text">Ngày tạo: ' . htmlspecialchars($detail->ngay_tao) . '</p>';
        echo '      <p class="mb-1 info-text">Email người tạo: ' . htmlspecialchars($detail->email) . '</p>';

        if (!empty($detail->daxoa)) {
            echo '      <p class="mb-1 info-text text-danger">Đã xóa bởi: ' .
                htmlspecialchars($detail->deleted_by) . ' lúc ' . htmlspecialchars($detail->deleted_at) . '</p>';
        }
        echo '    </div>'; // end system info
        echo '  </div>';   // end content-box
        echo '</div>';
        Factory::getApplication()->close();
    }

    public function viewpdf()
    {
        $file = $_GET['file'] ?? '';
        $folder = $_GET['folder'] ?? '';

        // Chống path traversal: chỉ lấy phần basename và folder sạch
        $file = basename($file); // lọc file
        $folder = preg_replace('/[^a-zA-Z0-9_\/-]/', '', $folder); // lọc folder an toàn, chỉ cho ký tự hợp lệ

        // Ghép đường dẫn tuyệt đối
        $filePath = JPATH_ROOT . '/' . $folder . '/' . $file;

        if (file_exists($filePath)) {
            header('Content-Type: application/pdf');
            header('Content-Disposition: inline; filename="' . basename($filePath) . '"');
            header('Content-Length: ' . filesize($filePath));
            header('Accept-Ranges: bytes');
            header('Cache-Control: public, must-revalidate, max-age=0');
            readfile($filePath);      // Header chuẩn
            exit;
        } else {
            echo "File không tồn tại.";
        }
    }
}
