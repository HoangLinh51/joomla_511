<?php

/*****************************************************************************
 * @Author                : HueNN                                            *
 * @CreatedDate           : 2024-08-04 17:29:45                              *
 * @LastEditors           : HueNN                                            *
 * @LastEditDate          : 2024-08-04 17:29:45                              *
 * @FilePath              : Joomla_511_svn/components/com_tochuc/src/View/Tochucs/RawView.php*
 * @CopyRight             : Dnict                                            *
 ****************************************************************************/

namespace Joomla\Component\VPTK\Site\View\Tcdc;

use Core;
use Joomla\CMS\Factory;
use Joomla\CMS\MVC\View\GenericDataException;
use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;
use Joomla\CMS\Pagination\Pagination;
use Joomla\Component\VPTK\Site\Helper\VPTKHelper;
use stdClass;

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

            case 'DS_TCDC':
                $this->_pageTracudancu();
                break;
            
        }
    }



    private function _pageTracudancu()
    {
        $model = Core::model('Vptk/Tcdc');
        $app = Factory::getApplication()->input;

        $params = [
            
            'cccd' => $app->getString('cccd', ''),
           
        ];

        
        $this->items = $model->getDanhsachTraCuuDanCu($params);

        parent::display();
    }
   
}
