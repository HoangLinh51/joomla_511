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
            case 'VIEWPDF':
                $this->viewpdf();
                break;
        }
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
