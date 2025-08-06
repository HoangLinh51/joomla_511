<?php

/*****************************************************************************
 * @Author                : LinhLH                                            *
 * @CreatedDate           : 2025-07-29                                        *
 * @LastEditors           : LinhLH                                            *
 * @LastEditDate          :                                                   *
 * @FilePath              : Joomla_511_svn/components/com_dcxddt/src/View/ViaHe/RawView.php*
 * @CopyRight             : Dnict                                             *
 ****************************************************************************/

namespace Joomla\Component\Dcxddt\Site\View\Viahe;

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
        $user = Factory::getUser();
        $input = Factory::getApplication()->input;
        $task = strtoupper($input->getCmd('task', ''));

        if (!$user->id) {
            echo '<script>window.location.href="index.php?option=com_users&view=login";</script>';
            exit;
        }
        switch ($task) {
            case 'DANHSACHTHONGKEVIAHE':
                $this->setLayout('ds_thongke');
                $this->_getDanhSachThongKeViahe();
                break;
        }
    }
    private function _getDanhSachThongKeViahe()
    {
        $model = Core::model('Dcxddt/Viahe');
        $input = Factory::getApplication()->input;
        $params['chucdanh_id'] = $input->getInt('chucdanh_id', 0);
        $params['nhiemky_id'] = $input->getInt('nhiemky_id', 0);
        $params['phuongxa_id'] = $input->getInt('phuongxa_id', 0);
        $params['thonto_id'] = $input->getInt('thonto_id', 0);
        $items = $model->getThongKeBanDieuHanh($params);
        $this->items = $items;
    }
}
