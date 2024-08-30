<?php

use Joomla\CMS\Factory;

define('_JEXEC', 1);
// Fix magic quotes.
@ini_set('magic_quotes_runtime', 0);

// Maximise error reporting.
@ini_set('zend.ze1_compatibility_mode', '0');
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

/*
 * Ensure that required path constants are defined.
*/
if (version_compare(PHP_VERSION, '5.3.1', '<'))
{
	die('Your host needs to use PHP 5.3.1 or higher to run this version of Joomla!');
}
if (!defined('_JDEFINES'))
{
	define('JPATH_BASE',dirname(dirname(__FILE__)));
	require_once JPATH_BASE . '/includes/defines.php';
}
/**
 * Import the Framework. This file is usually in JPATH_LIBRARIES
*/
require_once JPATH_LIBRARIES . '/import.legacy.php';
require_once JPATH_LIBRARIES . '/bootstrap.php';
require_once JPATH_LIBRARIES . '/cbcc/Core.php';
require_once JPATH_CONFIGURATION . '/configuration.php';
require_once JPATH_BASE . '/includes/framework.php';

$app = Factory::getApplication();
$session = $app->getSession();
$user = $session->get('user', new User);

if ((int) $user->id === 0) {
    // Switch to the admin application
    $adminApp = Factory::getApplication('administrator');
    $adminSession = $adminApp->getSession();
    $adminUser = $adminSession->get('user', new User);

    if ((int) $adminUser->id === 0) {
        echo 'Liên hệ với quản trị hệ thống';
        exit;
    }
}
require_once 'UploadHandler.php';

class CustomUploadHandler extends UploadHandler {
	protected function handle_form_data($file, $index) {
		$file->created_by = @$_REQUEST['created_by'][$index];
		$file->type_id = @$_REQUEST['type_id'][$index];
		$file->code = @$_REQUEST['code'][$index];
		$file->object_id = @$_REQUEST['object_id'][$index];
	}
	
	protected function handle_file_upload($uploaded_file, $name, $size, $type, $error,$index = null, $content_range = null) {
	    $mainframe = Factory::getApplication('site');
	    $mainframe->initialise();
	    $user = $mainframe->getSession()->get("user");
            if(!function_exists('mime_content_type')) {
                function mime_content_type($filename) {
                    $mime_types = array(
                        'txt' => 'text/plain',
                        'htm' => 'text/html',
                        'html' => 'text/html',
                        'php' => 'text/html',
                        'css' => 'text/css',
                        'js' => 'application/javascript',
                        'json' => 'application/json',
                        'xml' => 'application/xml',
                        'swf' => 'application/x-shockwave-flash',
                        'flv' => 'video/x-flv',
                        // images
                        'png' => 'image/png',
                        'jpe' => 'image/jpeg',
                        'jpeg' => 'image/jpeg',
                        'jpg' => 'image/jpeg',
                        'gif' => 'image/gif',
                        'bmp' => 'image/bmp',
                        'ico' => 'image/vnd.microsoft.icon',
                        'tiff' => 'image/tiff',
                        'tif' => 'image/tiff',
                        'svg' => 'image/svg+xml',
                        'svgz' => 'image/svg+xml',
                        // archives
                        'zip' => 'application/zip',
                        'rar' => 'application/x-rar-compressed',
                        'exe' => 'application/x-msdownload',
                        'msi' => 'application/x-msdownload',
                        'cab' => 'application/vnd.ms-cab-compressed',
                        // audio/video
                        'mp3' => 'audio/mpeg',
                        'qt' => 'video/quicktime',
                        'mov' => 'video/quicktime',
                        // adobe
                        'pdf' => 'application/pdf',
                        'psd' => 'image/vnd.adobe.photoshop',
                        'ai' => 'application/postscript',
                        'eps' => 'application/postscript',
                        'ps' => 'application/postscript',
                        // ms office
                        'doc' => 'application/msword',
                        'rtf' => 'application/rtf',
                        'xls' => 'application/vnd.ms-excel',
                        'ppt' => 'application/vnd.ms-powerpoint',
                        // open office
                        'odt' => 'application/vnd.oasis.opendocument.text',
                        'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
                    );
                    $ext = strtolower(array_pop(explode('.',$filename)));
                    if (array_key_exists($ext, $mime_types)) {
                        return $mime_types[$ext];
                    }else if (function_exists('finfo_open')) {
                        $finfo = finfo_open(FILEINFO_MIME);
                        $mimetype = finfo_file($finfo, $filename);
                        finfo_close($finfo);
                        return $mimetype;
                    }else {
                        return 'application/octet-stream';
                    }
                }
            }
		
		//$new_name = $this->strtolower_utf8($name);
		//$newfilename = rand(1,99999).end(explode(".",$_FILES["file"]["name"]));		
		$is_image = false;
		switch ($type) {
                    case 'image/jpeg':
                    case 'image/png':
                    case 'image/gif':
                        $name = str_replace(" ", "_", $name);
                        $new_name = time().$name;
                        //$duoi = end(explode(".",$name));
                        //var_dump($duoi);
                        //$new_name = md5(time().$name).'.'.$duoi;
                        //var_dump($name);exit;
                        $ext = mime_content_type($uploaded_file);
//                        echo $ext;exit;
                        $is_image = false;
                        switch ($ext) {
                            case 'image/png':
                            case 'image/jpeg':
                            case 'image/gif':
                                $is_image = true;
                                break;
                            default:
                                //error_log('Function not found: imagecreatetruecolor');	
                                echo 'Vui lòng liên hệ Quản trị viên';					 
                                exit;
                                break;
                        }
                        break;
                    default:
                        $name = str_replace(" ", "_", $name);
                        $new_name = md5(time().$name);
                        break;
		}

		$file = parent::handle_file_upload($uploaded_file, $new_name, $size, $type, $error, $index, $content_range);
		if (empty($file->error)) {			
// 			$db = JFactory::getDbo();
// 			$jConfig= new JConfig();
// 			$db->select($jConfig->db);
// 			$user = JFactory::getUser();
		
			if(!$file->type_id)$file->type_id = -1;
			if(!$file->object_id)$file->object_id = 0;
// 			if(!$file->created_by)$file->created_by = $user->id;
			$file->created_by = $user->id;
			if(!$file->filename)$file->filename = $name;
			$mapper = Core::model('Core/Attachment');
			$file->code = $new_name;
			$formData = array(
				'folder'=> $file->folder,
				'object_id'=> $file->object_id,
				'code'=> $new_name,
				'mime'=> $file->type,
				'url'=> (($is_image == false)?$file->url.'&download=1':$file->url),
				'filename'=> $name,
				'type_id'=> $file->type_id,
				'created_by'=> $file->created_by,
				'created_at'=> date('Y-m-d H:i:s')
			);
			$file->id = $mapper->create($formData);
			$file->url = $formData['url'];
		}
		return $file;
	}

	protected function set_additional_file_properties($file) {
		parent::set_additional_file_properties($file);
		if ($_SERVER['REQUEST_METHOD'] === 'GET') {
			$mapper = Core::model('Core/Attachment');
			$row = $mapper->getRowByCode($file->name);
			//var_dump($row);exit;		
			if ($row != null) {
				$file->id = $row['id'];
				$file->type = $row['mime'];				
				$file->folder = $row['folder'];
				$file->url = $row['url'];
				$file->code = $row['code'];
				$file->create_at = $row['created_at'];
				$file->created_by = $row['created_by'];
				$file->type_id = $row['type_id'];
				$file->filename = $row['filename'];
				$file->object_id = $row['object_id'];
			}
		}
	}
	public function get_file(){
		$file_code = $this->get_file_name_param();
		$mapper = Core::model('Core/Attachment');
		if (isset($_GET['object_id']) && isset($_GET['type_id']) ) {
			$row =  $mapper->getRowByObjectIdAndTypeId($_GET['object_id'],$_GET['type_id']);
		}else{
			$row =  $mapper->getRowByCode($file_code);
		}
		
		return $row;
	}
	protected function download() {
		//var_dump($file_name,'aaa');exit;
		switch ($this->options['download_via_php']) {
			case 1:
				$redirect_header = null;
				break;
			case 2:
				$redirect_header = 'X-Sendfile';
				break;
			case 3:
				$redirect_header = 'X-Accel-Redirect';
				break;
			default:
				return $this->header('HTTP/1.1 403 Forbidden');
		}
		$file = $this->get_file();
		$file_name = $file['code'];
		//var_dump($file_name);exit;
		if (!$this->is_valid_file_object($file_name)) {
			return $this->header('HTTP/1.1 404 Not Found');
		}
		
		if ($redirect_header) {
			return $this->header(
					$redirect_header.': '.$this->get_download_url(
							$file_name,
							$this->get_version_param(),
							true
					)
			);
		}
		$file_path = $this->get_upload_path($file_name, $this->get_version_param());
		//var_dump($file_path);exit;
		// Prevent browsers from MIME-sniffing the content-type:
		$this->header('X-Content-Type-Options: nosniff');
		if (!preg_match($this->options['inline_file_types'], $file_name)) {
			//$this->header('Content-Type: application/octet-stream');
			$this->header('Content-Type: '.$file['mime']);
			$this->header('Content-Disposition: attachment; filename="'.$file['filename'].'"');
		} else {
			$this->header('Content-Type: '.$this->get_file_type($file_path));
			$this->header('Content-Disposition: inline; filename="'.$file['filename'].'"');
		}
		$this->header('Content-Length: '.$this->get_file_size($file_path));
		$this->header('Last-Modified: '.gmdate('D, d M Y H:i:s T', filemtime($file_path)));
		$this->readfile($file_path);
	}
	public function get($print_response = true) {
		//var_dump($print_response && isset($_GET['download']));exit;
		$app = Factory::getSession();
		$user = $app->getStores();
		//$user = $app->getSession();
		//var_dump($user);exit;
		
		if ($user == null) {
			return $this->header('HTTP/1.1 404 Not Found');
		}
		if ($print_response && isset($_GET['download'])) {
			return $this->download();
		}
		$file_name = $this->get_file_name_param();
		if ($file_name) {
			$response = array(
					$this->get_singular_param_name() => $this->get_file_object($file_name)
			);
		} else {			
			$response = array(
					$this->options['param_name'] => $this->get_file_objects()
			);			
		}
		//var_dump($print_response);exit;
		return $this->generate_response($response, $print_response);
	}
	protected function get_file_objects($iteration_method = 'get_file_object') {
		$created_by = 0;
		if (isset($_GET['created_by']) ) {
			$created_by =  $_GET['created_by'];
		}
		$upload_dir = $this->get_upload_path();
		if (!is_dir($upload_dir)) {
			return array();
		}
			$db = Factory::getDbo();
			$jConfig= new JConfig();
			$db->select($jConfig->db);
			$query = $db->getQuery(true);
			$query->select('code')->from('core_attachment')
					->where('created_by = '.$db->quote($created_by))
					->where('type_id = '.$db->quote('-1'));
			$db->setQuery($query);
			$rows = $db->loadColumn();
		return array_values(array_filter(array_map(array($this, $iteration_method),$rows)));
		
		
	}
	public function delete($print_response = true) {
		$response = parent::delete(false);
		$mapper = Core::model('Core/Attachment');
		foreach ($response as $code => $deleted) {
			if ($deleted) {
				$mapper->deleteByCode($code);
			}
		}
		//exit;
		return $this->generate_response($response, $print_response);
	}

}
$upload_handler = new CustomUploadHandler();
