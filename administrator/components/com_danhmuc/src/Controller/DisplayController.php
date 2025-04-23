<?php

namespace Joomla\Component\Danhmuc\Administrator\Controller;

use Joomla\CMS\MVC\Controller\BaseController;
use Joomla\CMS\Factory;

\defined('_JEXEC') or die;

/**
 * Class DisplayController
 *
 * @since  1.6
 */
class DisplayController extends BaseController
{
    /**
     * The default view.
     *
     * @var string
     * @since 1.6
     */
    //   public function __construct() {
    //     // In ra giá trị của default_view khi khởi tạo
    //     var_dump($this->default_view);
    //     exit;
    // }
    protected $default_view = 'dantoc';  // View mặc định nếu không có view được truyền từ URL

        /**
     * Method to display a view.
     *
     * @param   boolean  $cachable   If true, the view output will be cached.
     * @param   array    $urlparams  An array of safe URL parameters and their variable types.
     *
     * @return  static|boolean  This object to support chaining.
     * @since   1.5
     */
    public function display($cachable = false, $urlparams = [])
    {
        $viewName = $this->input->get('tmpl', $this->default_view);
        $format   = $this->input->get('format', 'html');

        // Check CSRF token for sysinfo export views
        if ($viewName === 'sysinfo' && ($format === 'text' || $format === 'json')) {
            // Check for request forgeries.
            $this->checkToken('GET');
        }

        return parent::display($cachable, $urlparams);
    }
}
    