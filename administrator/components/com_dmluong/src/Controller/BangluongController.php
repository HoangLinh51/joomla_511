<?php

namespace Joomla\Component\Dmluong\Administrator\Controller;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\Controller\AdminController;
use Joomla\CMS\Router\Route;
use Joomla\Utilities\ArrayHelper;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Session\Session;

\defined('_JEXEC') or die;

class BangluongController extends AdminController
{
    /**
     * Constructor.
     *
     * @param   array                $config   An optional associative array of configuration settings.
     * @param   MVCFactoryInterface  $factory  The factory.
     * @param   CMSApplication       $app      The CMSApplication for the dispatcher
     * @param   Input                $input    Input
     *
     * @since  1.6
     * @see    BaseController
     * @throws \Exception
     */
    public function __construct($config = array())
    {
        parent::__construct($config);
        $this->registerTask('add', 'edit');
    }

    public function display($cachable = false, $urlparams = array())
    {
        $input = Factory::getApplication()->input;

        $viewName = $input->getCmd('view', 'bangluong');
        $viewLayout = $input->getCmd('layout', 'default');
        $document = Factory::getDocument();

        // Get the view and set layout
        $view = $this->getView($viewName, $document->getType());
        $view->setLayout($viewLayout);

        // Display the view
        $view->display();
    }


    /**
     * Removes an item.
     *
     * Overrides Joomla\CMS\MVC\Controller\FormController::delete to check the core.admin permission.
     *
     * @return  void
     *
     * @since   1.6
     */


    // public function display($cachable = false, $urlparams = array())
    // {
    //     $input = Factory::getApplication()->input;

    //     $viewName = $input->getCmd('view', 'bangluong');
    //     $viewLayout = $input->getCmd('layout', 'default');
    //     $document = Factory::getDocument();

    //     // Get the view and set layout
    //     $view = $this->getView($viewName, $document->getType());
    //     $view->setLayout($viewLayout);

    //     // Display the view
    //     $view->display();
    // }

    public function edit()
    {
        // Ensure the request is valid
        Session::checkToken() or jexit(Text::_('JINVALID_TOKEN'));

        $input = Factory::getApplication()->input;
        $id = $input->getInt('id', 0);
        $data = array();

        if ($id > 0) {
            $model = $this->getModel('Bienches', 'Administrator');

            $model = $this->getModel('DanhmucWhoisSalMgr', 'CoreModel');
            $data = $model->read($id);
        }

        $input->set('data', $data);
        $input->set('view', 'bangluong');
        $input->set('layout', 'form');
        $input->set('hidemainmenu', true);

        parent::display();
    }

    public function cancel()
    {
        // Ensure the request is valid
        Session::checkToken() or jexit(Text::_('JINVALID_TOKEN'));

        $msg = Text::_('Hoạt động đã hủy bỏ');
        $this->setRedirect(Route::_('index.php?option=com_dmluong&view=bangluong', false), $msg);
    }
    public function getModel($name = 'Bangluong', $prefix = 'Danhmuc', $config = ['ignore_request' => true])
    {
        return parent::getModel($name, $prefix, $config);
    }

    public function save()
    {
        // Ensure the request is valid

        $input = Factory::getApplication()->input;
        $data  = $this->input->post->get('jform', [], 'array');

        $id = $input->getInt('id');
        // $model_core = Core::model('Danhmuchethong/Party_pos');
        // $return = $model_core->addparty_pos($data);
        $model = $this->getModel('Danhmuc', 'WhoisSalMgr');
        var_dump($model);exit;

        if ($id > 0) {
            if ($model->update($data)) {
                $msg = Text::_('Cập nhật thành công!');
            } else {
                $msg = Text::_('Lỗi');
            }
        } else {
            if ($model->create($data)) {
                $msg = Text::_('Thêm mới thành công!');
            } else {
                $msg = Text::_('Lỗi');
            }
        }

        $link = Route::_('index.php?option=com_dmluong&view=bangluong', false);
        $this->setRedirect($link, $msg);
    }

    public function remove()
    {
        // Ensure the request is valid
        Session::checkToken() or jexit(Text::_('JINVALID_TOKEN'));

        $input = Factory::getApplication()->input;
        $cid = $input->get('cid', array(), 'array');
        ArrayHelper::toInteger($cid);

        if (empty($cid)) {
            throw new \Exception(Text::_('Chọn ít nhất một mục để xóa'), 500);
        }

        $model = $this->getModel('Danhmuc', 'WhoisSalMgr');
        if (!$model->delete($cid)) {
            $msg = Text::_('Lỗi không xóa được');
        } else {
            $msg = Text::_('Đã xóa thành công');
        }

        $link = Route::_('index.php?option=com_dmluong&view=bangluong', false);
        $this->setRedirect($link, $msg);
    }

    public function publish()
    {
        $this->changeState(1);
    }

    public function unpublish()
    {
        $this->changeState(0);
    }

    protected function changeState($state)
    {
        // Ensure the request is valid
        Session::checkToken() or jexit(Text::_('JINVALID_TOKEN'));

        $input = Factory::getApplication()->input;
        $cid = $input->get('cid', array(), 'array');
        ArrayHelper::toInteger($cid);

        if (empty($cid)) {
            throw new \Exception(Text::_('Chọn ít nhất một mục'), 500);
        }

        $model = $this->getModel('DanhmucWhoisSalMgr', 'CoreModel');
        if (!$model->publish($cid, $state)) {
            $msg = Text::_('Lỗi cập nhật');
        } else {
            $msg = Text::_('Cập nhật thành công');
        }

        $link = Route::_('index.php?option=com_dmluong&view=bangluong', false);
        $this->setRedirect($link, $msg);
    }
}
