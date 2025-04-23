<?php 
/**
 * @package     Joomla.Site
 * @subpackage  com_tochuc
 *
 * @copyright   (C) 2009 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

 namespace Joomla\Component\Core\Site\View\Attachment;

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
    	$layout = ($layout == null)?'default':strtoupper($layout);  
        $this->setLayout(strtolower($layout));    
        switch($layout){
            case 'INPUT':
                $this->_initInput();
                break;
            case 'ATTACHMENTONEFILE':
                $this->_initInput();
                break;	
            case 'ATTACHMENT':
                $this->_initInput();
                // $this->_initAttachment();
                break;    
            case 'default':
                break;
        }
        parent::display($tpl);

    }
    

    function _initInput(){
        $isTemp = -1;
        $date = getdate();
        $year = date('Y');
        $user = Factory::getUser();
        $iddiv= Factory::getApplication()->input->getVar('iddiv');
        if(!$year){
            $year = $date['year'];
        }
           
        $idObject = Factory::getApplication()->input->getVar('idObject');
        $is_new = Factory::getApplication()->input->getVar('is_new');
        $mapper = Core::model('Core/Attachment');
        if($is_new == 1){
            $idObject = $mapper->getIdTemp();
        }else{

        }
        $this->idObject = $idObject;
        $this->isTemp = $isTemp;
        $this->year = $year;
        //Lay danh sach file dinh kem co idObject va $isTemp
        $type = Factory::getApplication()->input->getVar('type');
        if(!$type )
            $type = -1;
        $pdf = Factory::getApplication()->input->getVar('pdf');
        $is_nogetcontent = Factory::getApplication()->input->getVar('is_nogetcontent');
       
        if($type != -1){
            $this->data = $mapper->getFileByIdObjectAndType($idObject,$type);
           
        }
        else{
            $this->data= $mapper->getListFile($idObject,$isTemp);
        }
            
        $this->iddiv= $iddiv;
        $this->type=$type;
        $this->pdf=$pdf;
        $this->is_nogetcontent = $is_nogetcontent;
        $this->is_new = Factory::getApplication()->input->getVar('is_new');
        $isreadonly = Factory::getApplication()->input->getVar('isreadonly',0);
        $isCapnhat = 1;
        if($is_new == 1){
            $isCapnhat = 1;
        }
        else{if($isreadonly == 1){
            $isCapnhat = 0;
            	
        }else{$isCapnhat = 1; }
        }
        $this->isCapnhat = $isCapnhat;
        $this->id_user          = $user->id;
    }


    public function _initAttachment()
    {
        $user = Factory::getUser();
        $this->idObject = Factory::getApplication()->input->getVar('idObject');
        $this->isTemp           = Factory::getApplication()->input->getVar('isTemp');
        $this->year             = '2015';
        $this->iddiv            = Factory::getApplication()->input->getVar('iddiv');
        $this->type             = Factory::getApplication()->input->getVar('type');
        $this->from             = Factory::getApplication()->input->getVar('from');
        $this->pdf              = Factory::getApplication()->input->getVar('pdf');
        $this->is_nogetcontent  = Factory::getApplication()->input->getVar('is_nogetcontent');
        $this->is_new           = Factory::getApplication()->input->getVar('is_new');    
        $this->id_user          = $user->id;
    }
}
