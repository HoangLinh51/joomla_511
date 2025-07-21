<?php

/*****************************************************************************
 * @Author                : LinhLH                                            *
 * @CreatedDate           : 2025-06-29                                        *
 * @LastEditors           : LinhLH                                            *
 * @LastEditDate          :                                                   *
 * @FilePath              : Joomla_511_svn/components/com_quansu/src/View/DanQuan/RawView.php*
 * @CopyRight             : Dnict                                             *
 ****************************************************************************/

namespace Joomla\Component\QuanSu\Site\View\DanQuan;

use Core;
use Joomla\CMS\Factory;
use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;

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
      case 'DS_THONGKE':
        $this->_pageThongke();
        break;
    }
  }

  public function viewpdf()
  {
    $file = $_GET['file'];
    $folder = $_GET['folder'];
    $filePath = JPATH_ROOT . '/' . $folder . '/' . basename($file); // đảm bảo chống path traversal

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
    private function _pageThongke()
    {
        $model = Core::model('QuanSu/DanQuan');
        $app = Factory::getApplication()->input;
        $params = [
            'phuongxa_id' => $app->getInt('phuongxa_id', 0),
            'thonto_id' => $app->getString('thonto_id', ''),
            'loaidoituong_id' => $app->getInt('loaidoituong_id', 0),

        ];
        if (!empty($params['thonto_id'])) {
            $params['thonto_id'] = array_filter(explode(',', $params['thonto_id']), 'is_numeric');
        } else {
            $params['thonto_id'] = [];
        }
        $items = $model->getThongKeDanQuan($params);
        // var_dump($items);exit;

        $this->items = $items;
        parent::display();
    }
}
