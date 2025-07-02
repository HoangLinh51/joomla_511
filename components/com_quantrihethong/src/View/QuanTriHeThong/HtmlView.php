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

        $layout = Factory::getApplication()->input->get('task');
        $layout = ($layout == null) ? 'default' : strtoupper($layout);

        switch ($layout) {
            case 'DEFAULT':
                $this->setLayout('default');
                $this->loadAccountList();
                break;
            case 'ADD_USER':
            case 'EDIT_USER':
                $this->setLayout('edit_taikhoan');
                $this->loadAccountDataById();
                break;
            default:
                $this->setLayout('default');
                $this->loadAccountList();
                break;
        }


        parent::display($tpl);
    }

    protected function loadAccountList()
    {
        $this->loadAssets();
    }

    protected function loadAccountDataById()
    {
        $this->loadAssets();
        $app = Factory::getApplication()->input;
        $model = Core::model('QuanTriHeThong/QuanTriHeThong');
        $idAccount = $app->getInt('id', null);

        $this->user = $model->getAccountById($idAccount);
        $this->dmKhuvuc = $model->getRegionList();
        $this->chucNang = $model->getUserGroupFunctions();
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
            "$base/media/cbcc/js/jquery/jquery-validation/jquery.validate.js",
            "$base/media/cbcc/js/jquery/jquery-validation/jquery.validate.min.js",
            "$base/media/cbcc/js/jquery/jquery-validation/additional-methods.min.js",
            "$base/media/cbcc/js/jquery/jquery.inputmask.min.js",
            "$base/media/cbcc/js/jstree/jquery.cookie.js",
            "$base/media/cbcc/js/jquery/jquery.toast.js",
            "$base/templates/adminlte/plugins/pace-progress/pace.min.js",
            "$base/media/legacy/js/jquery-noconflict.js",
            'https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js',
            'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js'
        ];

        foreach ($styles as $style) {
            $document->addStyleSheet($style);
        }

        foreach ($scripts as $script) {
            $document->addScript($script);
        }
    }
}
