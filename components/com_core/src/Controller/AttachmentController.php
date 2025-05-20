<?php

/**
 * @file: ajax.php
 * @author: nguyennpb@danang.gov.vn
 * @date: 01-08-2012
 * @company : http://dnict.vn
 **/

namespace Joomla\Component\Core\Site\Controller;

use Core;
use CoresController;
use Joomla\CMS\Factory;
use Joomla\CMS\MVC\Controller\BaseController;
use Joomla\CMS\Uri\Uri;

\defined('_JEXEC') or die;

class AttachmentController extends BaseController
{

    function __construct($config = array())
    {
        parent::__construct($config);
        $user = &Factory::getUser();
        if ($user->id == null) {
            if (Factory::getApplication()->input->getVar('format') == 'raw') {
                echo '<script> window.location.href="index.php?option=com_users&view=login"; </script>';
                exit;
            } else {
                $this->setRedirect("index.php?option=com_users&view=login");
            }
        }
    }
    function display($cachable = false, $urlparams = array())
    {
        $document    = Factory::getDocument();
        $viewName    = Factory::getApplication()->input->getVar('view', 'attachment');
        $viewLayout  = Factory::getApplication()->input->getVar('layout', 'default');
        $viewType = $document->getType();
        $view = $this->getView($viewName, $viewType);
        $view->setLayout($viewLayout);
        $view->display();
    }

    function doattachment()
    {
        $formData = Factory::getApplication()->input->post->getArray();

        // Multiple files will be stored in an array
        $files = $_FILES['uploadfile'];
        $date = getdate();
        $from = $formData['from'];
        $is_nogetcontent = $formData['is_nogetcontent'];
        $is_new = $formData['is_new'];
        $iddiv = $formData['iddiv'];

        $year = $formData['year'] ?? $date['year'];
        $type = $formData['type'] ?? -1;
        $idObject = $formData['idObject'] ?? 0;
        $isTemp = $formData['isTemp'] ?? 0;
        $pdf = $formData['pdf'] ?? 0;
        $user = Factory::getUser();
        $mapper = Core::model('Core/Attachment');
        $dirPath = $mapper->getDir($date['year'], $date['mon']);

        // Loop through all uploaded files
        if (count($files['name']) <= 5) {
            for ($i = 0; $i < count($files['name']); $i++) {
                if ($files['error'][$i] == 0) {
                    $new_name = md5($files['name'][$i] . time());
                    $data = array(
                        'folder' => $dirPath,
                        'object_id' => $idObject,
                        'code' => $new_name,
                        'mime' => $files['type'][$i],
                        'url' => '#',
                        'filename' => $files['name'][$i],
                        'type_id' => $type,
                        'created_by' => $user->id,
                        'created_at' => date('Y-m-d H:i:s')
                    );
                    $mapper->create($data);
                    $uploadfile = $dirPath . '/' . basename($new_name);
                    if (move_uploaded_file($files['tmp_name'][$i], $uploadfile)) {
                        $url = 'index.php?option=com_core&view=attachment&format=raw&task=input&iddiv=' . $iddiv . '&idObject=' . $idObject . '&is_new=' . $is_new . '&year=' . $year . '&type=' . $type . "&pdf=" . $pdf . "&is_nogetcontent=" . $is_nogetcontent;
                        echo "<script>window.parent.loadDivFromUrl('" . $iddiv . "','$url" . "');</script>";
                    } else {
                        echo "Possible file upload attack on file " . $files['name'][$i] . "!\n";
                    }
                }
            }
        } else {
            // echo  "Bạn đã đính kèm vượt quá giới hạn file cho phép";
            echo "<script>window.parent.appendHtmlDiv('" . $iddiv . "-error','Bạn đã đính kèm vượt quá giới hạn file cho phép" . "');</script>";
        }

        exit;
    }

    function doattachmentone()
    {
        $formData = Factory::getApplication()->input->post->getArray();

        // Multiple files will be stored in an array
        $files = $_FILES['uploadfile'];
        $date = getdate();
        $from = $formData['from'];
        $is_nogetcontent = $formData['is_nogetcontent'];
        $is_new = $formData['is_new'];
        $iddiv = $formData['iddiv'];

        $year = $formData['year'] ?? $date['year'];
        $type = $formData['type'] ?? -1;
        $idObject = $formData['idObject'] ?? 0;
        $isTemp = $formData['isTemp'] ?? 0;
        $pdf = $formData['pdf'] ?? 0;
        $user = Factory::getUser();
        $mapper = Core::model('Core/Attachment');
        $dirPath = $mapper->getDir($date['year'], $date['mon']);

        // Loop through all uploaded files
        if (count($files['name']) <= 5) {
            for ($i = 0; $i < count($files['name']); $i++) {
                if ($files['error'][$i] == 0) {
                    $new_name = md5($files['name'][$i] . time());
                    $data = array(
                        'folder' => $dirPath,
                        'object_id' => $idObject,
                        'code' => $new_name,
                        'mime' => $files['type'][$i],
                        'url' => '#',
                        'filename' => $files['name'][$i],
                        'type_id' => $type,
                        'created_by' => $user->id,
                        'created_at' => date('Y-m-d H:i:s')
                    );
                    $mapper->create($data);
                    $uploadfile = $dirPath . '/' . basename($new_name);
                    if (move_uploaded_file($files['tmp_name'][$i], $uploadfile)) {
                        $url = 'index.php?option=com_core&view=attachment&format=raw&task=attachmentonefile&iddiv=' . $iddiv . '&idObject=' . $idObject . '&is_new=' . $is_new . '&year=' . $year . '&type=' . $type . "&pdf=" . $pdf . "&is_nogetcontent=" . $is_nogetcontent;
                        echo "<script>window.parent.loadDivFromUrl('" . $iddiv . "','$url" . "');</script>";
                    } else {
                        echo "Possible file upload attack on file " . $files['name'][$i] . "!\n";
                    }
                }
            }
        } else {
            // echo  "Bạn đã đính kèm vượt quá giới hạn file cho phép";
            echo "<script>window.parent.appendHtmlDiv('" . $iddiv . "-error','Bạn đã đính kèm vượt quá giới hạn file cho phép" . "');</script>";
        }

        exit;
    }

    function uploadSingleImage()
    {
        $formData = Factory::getApplication()->input->post->getArray();
        $file = $_FILES['uploadfile'];
        $date = getdate();

        // Kiểm tra có đúng 1 file được upload không
        if (!isset($file) || !is_uploaded_file($file['tmp_name'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Không có file nào được upload hoặc dữ liệu không hợp lệ']);
            exit;
        }
        $type = $formData['type'] ?? -1;
        $idObject = $formData['idObject'] ?? 0;

        $user = Factory::getUser();
        $mapper = Core::model('Core/Attachment');
        $dirPath = $mapper->getDir($date['year'], $date['mon']);

        // Tạo tên file mới
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $new_name = md5($file['name'] . time()) . '.' . $ext;
        $uploadfile = $dirPath . '/' . $new_name;

        if (move_uploaded_file($file['tmp_name'], $uploadfile)) {
            $data = array(
                'folder' => $dirPath,
                'object_id' => $idObject,
                'code' => $new_name,
                'mime' => $file['type'],
                'url' => $uploadfile,
                'filename' => $file['name'],
                'type_id' => $type,
                'created_by' => $user->id,
                'created_at' => date('Y-m-d H:i:s')
            );
            $mapper->create($data);
            // ✅ Tạo URL ảnh thông qua get_image.php
            $publicUrl = Uri::root(true) . "/uploader/get_image.php?code=" . $data['code'];
            $objectId = $data['object_id'];
            var_dump($data);

            echo '<script>
            if (window.parent && window.parent.document) {
            var imagePreview = window.parent.document.getElementById("imagePreview");
                if (imagePreview) {
                    imagePreview.src = "' . htmlspecialchars($publicUrl, ENT_QUOTES, 'UTF-8') . '";
                }
                var form = window.parent.document.getElementById("imageUploadForm");
                if (form) {
                    var input = window.parent.document.getElementById("imageIdInput");
                    if (!input) {
                        input = document.createElement("input");
                        input.type = "hidden";
                        input.name = "image_id";
                        input.id = "imageIdInput";
                        form.appendChild(input);
                    }
                    input.value = "' . $objectId . '";
                }
            }
          </script>';
            exit;
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Lỗi khi upload file']);
            exit;
        }

        exit;
    }

    function uploadMultiImages()
    {
        $app = Factory::getApplication();
        $input = $app->input;
        $formData = $input->post->getArray();
        $uploadedFiles = $_FILES['uploadfiles'] ?? null;

        if (empty($uploadedFiles) || empty(array_filter($uploadedFiles['name'] ?? []))) {
            http_response_code(400);
            echo '<script>alert("Không có file nào được chọn hoặc dữ liệu không hợp lệ.");</script>';
            exit;
        }

        $type = $formData['type'] ?? -1;
        $idObject = $formData['idObject'] ?? 0;
        $user = Factory::getUser();
        $mapper = Core::model('Core/Attachment');
        $date = getdate();
        $dirPath = $mapper->getDir($date['year'], $date['mon']);

        if (!is_dir($dirPath) && !mkdir($dirPath, 0755, true)) {
            http_response_code(500);
            echo '<script>alert("Lỗi nghiêm trọng: Không thể tạo thư mục upload.");</script>';
            exit;
        }

        $numFiles = count($uploadedFiles['name'] ?? []);
        $successfulAttachments = [];

        for ($i = 0; $i < $numFiles; $i++) {
            $originalName = $uploadedFiles['name'][$i] ?? '';
            $tmpName = $uploadedFiles['tmp_name'][$i] ?? '';
            $fileError = $uploadedFiles['error'][$i] ?? UPLOAD_ERR_NO_FILE;
            $fileType = $uploadedFiles['type'][$i] ?? '';

            if ($fileError !== UPLOAD_ERR_OK || !is_uploaded_file($tmpName)) {
                continue;
            }

            // Optional: Kiểm tra định dạng file ảnh
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            if (!in_array($fileType, $allowedTypes)) {
                continue;
            }

            $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
            $newName = md5($originalName . time() . uniqid()) . '.' . $ext;
            $uploadPath = $dirPath . '/' . $newName;

            if (!move_uploaded_file($tmpName, $uploadPath)) {
                continue;
            }

            $data = [
                'folder' => $dirPath,
                'object_id' => $idObject,
                'code' => $newName,
                'mime' => $fileType,
                'url' => $uploadPath,
                'filename' => $originalName,
                'type_id' => $type,
                'created_by' => $user->id,
                'created_at' => date('Y-m-d H:i:s')
            ];

            if ($mapper->create($data)) {
                $publicUrl = Uri::root(true) . "/uploader/get_image.php?code=" . $newName;
                $successfulAttachments[] = [
                    'url' => $publicUrl,
                    'idObject' => $idObject, // hoặc có thể thay bằng `$data['id']` nếu `$mapper->create()` trả về ID mới
                    'filename' => $originalName
                ];
            } else {
                unlink($uploadPath); // rollback nếu lưu DB thất bại
            }
        }
        echo '<script>';
        echo 'if (window.parent && window.parent.document) {';
        echo '  const form = window.parent.document.getElementById("imageUploadForm");';
        echo '  const imagePreview = window.parent.document.getElementById("imagePreview");';

        foreach ($successfulAttachments as $file) {
            $url = htmlspecialchars($file['url'], ENT_QUOTES, 'UTF-8');
            $filename = htmlspecialchars($file['filename'], ENT_QUOTES, 'UTF-8');
            $idObject = htmlspecialchars($file['idObject'], ENT_QUOTES, 'UTF-8');
            echo '  if (imagePreview) {';
            echo '    const img = document.createElement("img");';
            echo '    img.src = "' . htmlspecialchars($file['url'], ENT_QUOTES, 'UTF-8') . '";';
            echo '    img.alt = "' . htmlspecialchars($file['filename'], ENT_QUOTES, 'UTF-8') . '";';
            echo '    Object.assign(img.style, { maxWidth: "100px", maxHeight: "100px", marginRight: "5px", border: "1px solid #ccc", padding: "2px" });';
            echo '    imagePreview.appendChild(img);';
            echo '  }';

            // Thêm hidden input
            echo '  if (form) {';
            echo '    const input = document.createElement("input");';
            echo '    input.type = "hidden";';
            echo '    input.name = "image_id[]";';
            echo '    input.value = "' . htmlspecialchars($file['idObject'], ENT_QUOTES, 'UTF-8') . '";';
            echo '    form.appendChild(input);';
            echo '  }';
        }

        //     echo '  if (imagePreview) {';
        //     echo '    const wrapper = document.createElement("div");';
        //     echo '    wrapper.id = "imagePreviewWrapper";';
        //     echo '    wrapper.style.position = "relative";';
        //     echo '    wrapper.style.display = "inline-block";';
        //     echo '    wrapper.style.marginRight = "10px";';

        //     echo '    const img = document.createElement("img");';
        //     echo '    img.src = "' . $url . '";';
        //     echo '    img.alt = "' . $filename . '";';
        //     echo '    Object.assign(img.style, { width: "100px", height: "100px", border: "1px solid #ccc", padding: "2px" });';

        //     echo '    const closeBtn = document.createElement("span");';
        //     echo '   closeBtn.className = "DELidfiledk' . $idObject . '[]";';
        //     echo '    closeBtn.innerHTML = "×";';
        //     echo '    Object.assign(closeBtn.style, { position: "absolute", top: "0", right: "0", background: "rgba(0,0,0,0.5)", color: "#fff", cursor: "pointer", padding: "2px 6px", borderRadius: "0 0 0 5px", fontSize: "14px" });';
        //     echo '    closeBtn.onclick = function() { 
        //     const event = new CustomEvent("imageRemoved", {
        //     detail: { filename: "' . $filename . '", idObject: "' . $idObject . '", url: "' . $url . '", dirPath: "' . $dirPath . '" },
        //     });
        //     window.parent.document.dispatchEvent(event);
        //     };';

        //     echo '    wrapper.appendChild(img);';
        //     echo '    wrapper.appendChild(closeBtn);';
        //     echo '    imagePreview.appendChild(wrapper);';
        //     echo '  }';
        // }

        echo '}';
        echo '</script>';

        exit;
    }

    function doattachment_old()
    {
        $formData = Factory::getApplication()->input->post->getArray();
        var_dump($formData);

        $file = $_FILES['uploadfile'];
        var_dump($file);
        exit;
        if ($file['error'] == 0) {
            //$adapter = new Zend_File_Transfer_Adapter_Http();
            //Lay tham so nhan tu client
            $date = getdate();
            $from = $formData['from'];
            $is_nogetcontent = $formData['is_nogetcontent'];
            $is_new = $formData['is_new'];
            $iddiv = $formData['iddiv'];

            $year = '2015'; //nam cua bang du lieu
            $type = $formData['type'];
            if (!$type)
                $type = -1;
            if (!$year)
                $year = $date['year'];
            $idObject = $formData['idObject']; //id cua doi tuong chua file dinh kem
            if (!$idObject)
                $idObject = 0;
            $isTemp = $formData['isTemp'];
            if (!$isTemp)
                $isTemp = 0;
            $pdf = $formData['pdf'];
            if (!$pdf)
                $pdf = 0;
            $user = Factory::getUser();
            $mapper = Core::model('Core/Attachment');
            //$mapper = new CoreAttachment_Model_AttachmentMapper(); //doi tuong model
            $dirPath = $mapper->getDir($date['year'], $date['mon']);
            // $dirPath = $mapper->getTempPath();
            $new_name = md5($file['name'] . time());
            $data = array(
                'folder' => $dirPath,
                'object_id' => $idObject,
                'code' => $new_name,
                'mime' => $file['type'],
                'url' => '#',
                'filename' => $file['name'],
                'type_id' => $type,
                'created_by' => $user->id,
                'created_at' => date('Y-m-d H:i:s')
            );
            $mapper->create($data);
            $uploadfile = $dirPath . '/' . basename($new_name);
            if (move_uploaded_file($file['tmp_name'], $uploadfile)) {
                $url = 'index.php?option=com_core&view=attachment&format=raw&task=input&iddiv=' . $iddiv . '&idObject=' . $idObject . '&is_new=' . $is_new . '&year=' . $year . '&type=' . $type . "&pdf=" . $pdf . "&is_nogetcontent=" . $is_nogetcontent;
                echo "<script>window.parent.loadDivFromUrl('" . $iddiv . "','$url" . "'); </script>";
            } else {
                echo "Possible file upload attack!\n";
            }

            exit;
        }
    }

    function doattachment_new()
    {
        // $formData = Factory::getApplication()->get('post');
        $app = Factory::getApplication()->input;
        $formData = array(
            'from' => $app->getVar('from', ""),
            'is_nogetcontent' => $app->getInt('is_nogetcontent', 0),
            'is_new' => $app->getInt('is_new', 0),
            'iddiv' => $app->getVar('iddiv', ""),
            'type' => $app->getVar('type', ""),
            'year' => $app->getVar('year', ""),
            'idObject' => $app->getInt('idObject', 0),
            'isTemp' => $app->getVar('isTemp', ""),
            'pdf' => $app->getVar('pdf', "")
        );
        $response = [];
        $file = $_FILES['file'];

        if ($file['error'] == 0) {
            //$adapter = new Zend_File_Transfer_Adapter_Http();
            //Lay tham so nhan tu client
            $date = getdate();
            $from = $formData['from'];
            $is_nogetcontent = $formData['is_nogetcontent'];
            $is_new = $formData['is_new'];
            $iddiv = $formData['iddiv'];
            $year = $date['year']; //nam cua bang du lieu
            $type = $formData['type'];
            if (!$type)
                $type = -1;
            if (!$year)
                $year = $date['year'];
            $idObject = $formData['idObject']; //id cua doi tuong chua file dinh kem
            if (!$idObject)
                $idObject = 0;
            $isTemp = $formData['isTemp'];
            if (!$isTemp)
                $isTemp = 0;
            $pdf = $formData['pdf'];
            if (!$pdf)
                $pdf = 0;
            $user = Factory::getUser();
            $mapper = Core::model('Core/Attachment');
            $dirPath = $mapper->getDir($date['year'], $date['mon']);
            // $dirPath = $mapper->getTempPath();
            $new_name = md5($file['name'] . time());
            $data = array(
                'folder' => $dirPath,
                'object_id' => $idObject,
                'code' => $new_name,
                'mime' => $file['type'],
                'url' => '#',
                'filename' => $file['name'],
                'type_id' => $type,
                'created_by' => $user->id,
                'created_at' => date('Y-m-d H:i:s')
            );

            $mapper->create($data);
            $uploadfile = $dirPath . '/' . basename($new_name);
            if (move_uploaded_file($file['tmp_name'], $uploadfile)) {
                $fileUrl = "index.php?option=com_core&controller=attachment&format=raw&task=download&year=" . $year . "&code=" . $new_name . "";
                echo json_encode(['success' => true, 'file' => $file['name'], 'fileUrl' => $fileUrl, 'code' => $new_name]);
                // array_push($response, ['success' => true, 'file' => $file['name'], 'fileUrl' => $fileUrl]);
            } else {
                echo json_encode(['success' => false, 'error' => 'Failed to move uploaded file.']);
            }
        }
        Factory::getApplication()->close();
    }

    function doDinhKemMotFile()
    {
        $formData = Factory::getApplication()->get('post');
        $file = $_FILES['uploadfile'];
        for ($i = 0; $i < count($file['name']); $i++) {
            if ($file['error'][$i] == 0) {
                // kiểm tra size
                //if(ini_get('upload_max_filesize')*1024*1024< $file[$i]['size']){ echo "Quá dung lượng cho phép";die;}
                //Lay tham so nhan tu client
                $date = getdate();
                $from = $formData['from'];
                $is_nogetcontent = $formData['is_nogetcontent'];
                $is_new = $formData['is_new'];
                // var_dump($formData);exit;
                $iddiv = $formData['iddiv'];
                $year = date('Y'); //nam cua bang du lieu
                $type = $formData['type'];
                if (!$type)
                    $type = -1;
                if (!$year)
                    $year = $date['year'];
                $idObject = $formData['idObject']; //id cua doi tuong chua file dinh kem
                if (!$idObject)
                    $idObject = 0;
                $isTemp = $formData['isTemp'];
                if (!$isTemp)
                    $isTemp = 0;
                $pdf = $formData['pdf'];
                if (!$pdf)
                    $pdf = 0;
                $user = Factory::getUser();
                $mapper = Core::model('Core/Attachment');
                $dirPath = $mapper->getTempPath();
                $new_name = md5($file['name'][$i] . time());
                $data = array(
                    'folder' => $dirPath,
                    'object_id' => $idObject,
                    'code' => $new_name,
                    'mime' => $file['type'][$i],
                    'url' => '#',
                    'filename' => $file['name'][$i],
                    'type_id' => $type,
                    'created_by' => $user->id,
                    'created_at' => date('Y-m-d H:i:s')
                );
                $mapper->create($data);
                $uploadfile = $dirPath . '/' . basename($new_name);
                if (move_uploaded_file($file['tmp_name'][$i], $uploadfile)) {
                    $url = 'index.php?option=com_core&controller=attachment&format=raw&task=dinhKemMotFile&iddiv=' . $iddiv . '&idObject=' . $idObject . '&is_new=' . $is_new . '&year=' . $year . '&type=' . $type . "&pdf=" . $pdf . "&is_nogetcontent=" . $is_nogetcontent;
                    echo "<script>window.parent.loadDivFromUrl('" . $iddiv . "','$url" . "'); </script>";
                } else {
                    echo "Lỗi không upload được tập tin\n";
                }
            } else {
                echo '<br>- Tập tin ' . $file['name'][$i] . ' không hợp lệ !';
            }
        }
        die;
    }

    public function delete()
    {
        $is_new = 0;
        $app = Factory::getApplication();
        $input = $app->input;

        $type = $input->get('type', '', 'STRING');
        $year = $input->getInt('year', 0);
        $iddiv = $input->get('iddiv', '', 'STRING');
        $idObject = $input->getInt('idObject', 0);
        $isTemp = $input->getBool('isTemp', false);
        $from = $input->get('from', '', 'STRING');
        $arr_code = Factory::getApplication()->input->getVar('DELidfiledk' . $idObject . '[]');
        $pdf = Factory::getApplication()->input->getVar('pdf');
        $is_nogetcontent = Factory::getApplication()->input->getVar('is_nogetcontent');
        $mapper = Core::model('Core/Attachment');
        for ($i = 0; $i < count($arr_code); $i++) {
            $mapper->deleteFileByMaso($arr_code[$i]);
        }
        $url = Uri::root(true) . '/index.php?option=com_core&view=attachment&format=raw&task=input&iddiv=' . $iddiv . '&idObject=' . $idObject . '&is_new=' . $is_new . '&year=' . $year . '&type=' . $type . "&pdf=" . $pdf . "&is_nogetcontent=" . $is_nogetcontent;
        echo "<script>window.parent.loadDivFromUrl('" . $iddiv . "','$url" . "'); </script>";
        exit;
    }

    public function deleteOneFile()
    {
        $date = getdate();
        $year =  Factory::getApplication()->input->getInt('year', 0);
        $iddiv =  Factory::getApplication()->input->getVar('iddiv');
        $is_new = 0;
        //truongvc attachment for traodoi module
        $from = Factory::getApplication()->input->getVar('from');
        if (!$year)
            $year = $date['year'];
        $code =     Factory::getApplication()->input->getVar('maso');
        $idObject = Factory::getApplication()->input->getVar('idObject');
        if (!$idObject)
            $idObject = 0;
        $isTemp = Factory::getApplication()->input->getVar('isTemp');
        if (!$isTemp)
            $isTemp = 0;
        $type = Factory::getApplication()->input->getVar('type');
        $arr_code = Factory::getApplication()->input->getVar('DELidfiledk' . $idObject);
        $pdf = Factory::getApplication()->input->getVar('pdf');
        $is_nogetcontent = Factory::getApplication()->input->getVar('is_nogetcontent');
        $mapper = Core::model('Core/Attachment');
        //var_dump($arr_code);exit;
        for ($i = 0; $i < count($arr_code); $i++) {
            $mapper->deleteFileByMaso($arr_code[$i]);
        }

        //$this->_redirect($url);
        //echo "parent.loadDivFromUrl('".$iddiv."','$url"."',1);";
        $url = Uri::root(true) . '/index.php?option=com_core&controller=attachment&format=raw&task=dinhKemMotFile&iddiv=' . $iddiv . '&idObject=' . $idObject . '&is_new=' . $is_new . '&year=' . $year . '&type=' . $type . "&pdf=" . $pdf . "&is_nogetcontent=" . $is_nogetcontent;
        echo "<script>window.parent.loadDivFromUrl('" . $iddiv . "','$url" . "'); </script>";
        exit;
    }

    public function updatetypebycode()
    {
        $formData = Factory::getApplication()->input->get('post');
        $mapper = Core::model('Core/Attachment');
        for ($i = 0; $i < count($formData["idFile"]); $i++) {
            $mapper->updateTypeIdByCode($formData["idFile"][$i], $formData['type_id'], true);
        }
        //var_dump($formData);
        //exit;
    }

    public function download()
    {
        $date = getdate();
        $code = Factory::getApplication()->input->getVar('code');
        $mapper = Core::model('Core/Attachment');
        $file = $mapper->getRowByCode($code);
        if (null != $file['code']) {
            header("Pragma: public");
            header("Expires: 0");
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header("Content-type:" . $file['mime']);
            header('Content-Disposition: attachment; filename="' . $file['filename'] . '"');
            echo file_get_contents($file['folder'] . '/' . $file['code']);
        }
        exit;
    }

    public function fixedFileNotCopy()
    {
        $user_id = Factory::getApplication()->input->getUser()->id;
        if ($user_id == '1') {
            $model = Core::model('Core/Attachment');
            $model->fixedFileNotCopy();
            $data = Factory::getApplication()->get('post');
            var_dump($data);
            exit;
        } else {
            echo '';
            exit;
        }
    }
}
