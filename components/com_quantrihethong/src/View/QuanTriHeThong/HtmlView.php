<?php

/**
 * @package     Joomla.Site
 * @subpackage  com_quantrihethong
 *
 * @copyright   (C) 2009 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\Component\QuanTriHeThong\Site\View\QuanTriHeThong;

defined('_JEXEC') or die;

use Core;
use Joomla\CMS\Factory;
use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;
use Joomla\CMS\Uri\Uri;

class HtmlView extends BaseHtmlView
{
    public function display($tpl = null)
    {
        $app = Factory::getApplication();
        $id = $app->input->getInt('id');
        $task = strtolower($app->input->get('task', '', 'CMD'));

        // Xác định layout
        switch ($task) {
            case 'edit_baocaoloi':
                $layout = ($id > 0) ? 'edit_baocaoloi' : 'add_baocaoloi';
                break;
            case 'add_taikhoan':
            case 'edit_taikhoan':
            case 'ds_quantrihethong':
                $layout = $task;
                break;
            default:
                $layout = 'default';
        }

        // Xử lý từng layout
        switch ($layout) {
            case 'default':
                $this->setLayout('default');
                $this->loadAccountList();
                break;
            case 'add_taikhoan':
            case 'edit_taikhoan':
                $this->setLayout('edit_taikhoan');
                $this->loadUserData();
                break;
            case 'ds_quantrihethong':
                $this->setLayout('ds_quantrihethong');
                $this->loadAdminList();
                break;
        }

        parent::display($tpl);
    }

    protected function loadAccountList()
    {
        $model = Core::model('Vptk/Danhmuc');
        $this->accounts = $model->getDanhsachTaikhoan();
    }

    protected function loadAdminList()
    {
        $this->loadAssets();
    }

    protected function loadUserData()
    {
        $this->loadAssets();
        $app = Factory::getApplication();
        $id = $app->input->getInt('id');
        $model = Core::model('QuanTriHeThong/QuanTriHeThong');

        $this->user = $id ? $model->getTaikhoanById($id) : [];

        $this->dmKhuvuc = $model->getDanhsachKhuvuc();
        $this->chucNang = $model->getChucNangSuDung();
    }

    protected function loadAssets()
    {
        $document = Factory::getDocument();
        $base = Uri::base(true);
        $root = Uri::root(true);

        $styles = [
            "$base/templates/adminlte/plugins/global/style.bundle.css",
            "$base/templates/adminlte/plugins/global/plugins.bundle.css",
            "$root/media/cbcc/js/jstree-3.2.1/themes/default/style.min.css",
            "$base/media/cbcc/js/bootstrap-datepicker/css/bootstrap-datepicker.min.css",
            "$root/media/cbcc/js/bootstrap/bootstrap-datetimepicker.min.css",
            "$root/media/cbcc/css/jquery.toast.css",
            "$base/templates/adminlte/plugins/pace-progress/themes/blue/pace-theme-flash.css",
            'https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.min.css'
        ];

        $scripts = [
            "$base/templates/adminlte/plugins/jquery/jquery.min.js",
            "$base/media/cbcc/js/bootstrap-datepicker/js/bootstrap-datepicker.min.js",
            "$root/media/cbcc/js/bootstrap/bootstrap.bundle.min.js",
            "$base/media/cbcc/js/jstree-3.2.1/jstree.min.js",
            "$base/media/cbcc/js/fuelux/fuelux.tree.min.js",
            "$base/media/cbcc/js/ace-elements.min.js",
            "$base/media/cbcc/js/jquery/jquery-validation/jquery.validate.min.js",
            "$base/media/cbcc/js/jquery/jquery-validation/additional-methods.min.js",
            "$base/media/cbcc/js/jquery/jquery.inputmask.min.js",
            "$base/media/cbcc/js/jstree/jquery.cookie.js",
            "$base/media/cbcc/js/jquery/jquery.toast.js",
            "$base/templates/adminlte/plugins/pace-progress/pace.min.js",
            "$base/media/legacy/js/jquery-noconflict.js",
            'https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js'
        ];

        foreach ($styles as $style) {
            $document->addStyleSheet($style);
        }

        foreach ($scripts as $script) {
            $document->addScript($script);
        }
    }
}
