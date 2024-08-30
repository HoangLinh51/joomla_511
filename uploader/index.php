<?php

use Joomla\CMS\Factory;

define('_JEXEC', 1);
// Fix magic quotes.
@ini_set('magic_quotes_runtime', 0);

// Maximise error reporting.
@ini_set('zend.ze1_compatibility_mode', '0');
//error_reporting(E_ALL);
// ini_set('display_errors', 1);

if (!defined('_JDEFINES'))
{
	define('JPATH_BASE',dirname(dirname(__FILE__)));
	require_once JPATH_BASE . '/includes/defines.php';
}
// Check for presence of vendor dependencies not included in the git repository
if (!file_exists(JPATH_LIBRARIES . '/vendor/autoload.php') || !is_dir(JPATH_PUBLIC . '/media/vendor')) {
    echo file_get_contents(JPATH_ROOT . '/templates/system/build_incomplete.html');

    exit;
}

require_once JPATH_BASE . '/includes/framework.php';
require_once JPATH_LIBRARIES.'/cbcc/Core.php';
/**
 * Import the Framework. This file is usually in JPATH_LIBRARIES
*/

// require_once JPATH_LIBRARIES . '/bootstrap.php';
// require_once JPATH_LIBRARIES . '/cms.php';
// require_once JPATH_LIBRARIES . '/cbcc/Core.php';
// require_once JPATH_CONFIGURATION . '/configuration.php';
// require_once JPATH_LIBRARIES .'/cms/application/cms.php';
// require_once JPATH_BASE . '/includes/framework.php';

// Initialize Joomla application
// $app = Factory::getApplication('site');
// $app->initialise();

// Include the UploadHandler class
require_once 'UploadHandler.php';  // Ensure correct path and use require_once to prevent multiple inclusions

class CustomUploadHandler extends UploadHandler
{
    // Your existing methods here

    protected function handle_form_data($file, $index)
    {
        $file->created_by = @$_REQUEST['created_by'][$index];
        $file->type_id = @$_REQUEST['type_id'][$index];
        $file->code = @$_REQUEST['code'][$index];
        $file->object_id = @$_REQUEST['object_id'][$index];
    }

    protected function handle_file_upload(
        $uploaded_file,
        $name,
        $size,
        $type,
        $error,
        $index = null,
        $content_range = null
    ) {
        $file = new \stdClass();
        $file->name = $this->get_file_name(
            $uploaded_file,
            $name,
            $size,
            $type,
            $error,
            $index,
            $content_range
        );
        $file->size = $this->fix_integer_overflow((int)$size);
        $file->type = $type;
        if ($this->validate($uploaded_file, $file, $error, $index)) {
            $this->handle_form_data($file, $index);
            $upload_dir = $this->get_upload_path();
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, $this->options['mkdir_mode'], true);
            }
            $file_path = $this->get_upload_path($file->name);
            $append_file = $content_range && is_file($file_path) &&
                $file->size > $this->get_file_size($file_path);
            if ($uploaded_file && is_uploaded_file($uploaded_file)) {
                // multipart/formdata uploads (POST method uploads)
                if ($append_file) {
                    file_put_contents(
                        $file_path,
                        fopen($uploaded_file, 'r'),
                        FILE_APPEND
                    );
                } else {
                    move_uploaded_file($uploaded_file, $file_path);
                }
            } else {
                // Non-multipart uploads (PUT method support)
                file_put_contents(
                    $file_path,
                    fopen($this->options['input_stream'], 'r'),
                    $append_file ? FILE_APPEND : 0
                );
            }
            $file_size = $this->get_file_size($file_path, $append_file);
            if ($file_size === $file->size) {
                $file->url = $this->get_download_url($file->name);
                if ($this->is_valid_image_file($file_path)) {
                    $this->handle_image_file($file_path, $file);
                }
            } else {
                $file->size = $file_size;
                if (!$content_range && $this->options['discard_aborted_uploads']) {
                    unlink($file_path);
                    $file->error = $this->get_error_message('abort');
                }
            }
            $this->set_additional_file_properties($file);
        }
        return $file;
    }

    protected function set_additional_file_properties($file)
    {
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
    public function get_file()
    {
        $file_code = $this->get_file_name_param();
        $mapper = Core::model('Core/Attachment');
        if (isset($_GET['object_id']) && isset($_GET['type_id'])) {
            $row =  $mapper->getRowByObjectIdAndTypeId($_GET['object_id'], $_GET['type_id']);
        } else {
            $row =  $mapper->getRowByCode($file_code);
        }

        return $row;
    }
    protected function download()
    {
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
                $redirect_header . ': ' . $this->get_download_url(
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
            $this->header('Content-Type: ' . $file['mime']);
            $this->header('Content-Disposition: attachment; filename="' . $file['filename'] . '"');
        } else {
            $this->header('Content-Type: ' . $this->get_file_type($file_path));
            $this->header('Content-Disposition: inline; filename="' . $file['filename'] . '"');
        }
        $this->header('Content-Length: ' . $this->get_file_size($file_path));
        $this->header('Last-Modified: ' . gmdate('D, d M Y H:i:s T', filemtime($file_path)));
        $this->readfile($file_path);
    }
    public function get($print_response = true)
    {
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
    protected function get_file_objects($iteration_method = 'get_file_object')
    {
        $created_by = 0;
        if (isset($_GET['created_by'])) {
            $created_by =  $_GET['created_by'];
        }
        $upload_dir = $this->get_upload_path();
        if (!is_dir($upload_dir)) {
            return array();
        }
        $db = Factory::getDbo();
        $jConfig = new JConfig();
        $db->select($jConfig->db);
        $query = $db->getQuery(true);
        $query->select('code')->from('core_attachment')
            ->where('created_by = ' . $db->quote($created_by))
            ->where('type_id = ' . $db->quote('-1'));
        $db->setQuery($query);
        $rows = $db->loadColumn();
        return array_values(array_filter(array_map(array($this, $iteration_method), $rows)));
    }
    public function delete($print_response = true)
    {
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

    // Other methods...
}

// Instantiate and use your custom upload handler
$upload_handler = new CustomUploadHandler();
