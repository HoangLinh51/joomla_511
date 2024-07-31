<?php

/**
 * @package     Joomla.Site
 * @subpackage  com_tags
 *
 * @copyright   (C) 2017 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\Component\Tochuc\Site\Controller;

use Core;
use Joomla\CMS\Factory;
use Joomla\CMS\MVC\Controller\BaseController;

// phpcs:disable PSR1.Files.SideEffects
\defined('_JEXEC') or die;
// phpcs:enable PSR1.Files.SideEffects

/**
 * The Tags List Controller
 *
 * @since  3.1
 */
class TochucController extends BaseController
{
    /**
     * Method to search tags with AJAX
     *
     * @return  void
     */
    protected $default_view = 'tochuc';
	/**
	 * Method to display a view.
	 *
	 * @param   boolean  $cachable   If true, the view output will be cached
	 * @param   array    $urlparams  An array of safe URL parameters and their variable types, for valid values see {@link \JFilterInput::clean()}.
	 *
	 * @return  static  This object to support chaining.
	 *
	 * @since   1.5
	 */
	public function display($cachable = false, $urlparams = array())
	{
		return parent::display();
	}

	public function generateMaxCodeTochuc(){
		
		$app = Factory::getApplication()->input;
		$model = Core::model('Tochuc/Tochuc');
		$codeCha = $model->getThongtin('max(code) as code', 'ins_dept', null, 'active =1 and type=1 and concat("",code * 1) = code', null);
		if ($codeCha[0]->code<30000) 
			$default = 30000;
		else $default = 1 + $codeCha[0]->code;
		Core::PrintJson($default);
	}
	public function generateCodeTochucNew(){
		$app = Factory::getApplication()->input;
		$model = Core::model('Tochuc/Tochuc');
		$post = $app->get('post');
		$donvi_id = $post['node_id'];
		$newCode = $model->generateCodeTochucNew($donvi_id, '');
		Core::PrintJson($newCode);
	}

	public function upload()
    {
        $app = Factory::getApplication();
        $input = $app->input;
        $file = $input->files->get('file', array(), 'array');

        // Define upload path
        $uploadDir = JPATH_SITE . '/uploader/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        // Handle file upload
        if ($file['error'] == 0) {
            $targetPath = $uploadDir . basename($file['name']);
            if (move_uploaded_file($file['tmp_name'], $targetPath)) {
                echo json_encode(['success' => true, 'file' => $file['name']]);
            } else {
                echo json_encode(['success' => false, 'error' => 'Failed to move uploaded file.']);
            }
        } else {
            echo json_encode(['success' => false, 'error' => 'No file uploaded or error occurred.']);
        }

        // Prevent Joomla from rendering the rest of the page
        $app->close();
    }
    
}
