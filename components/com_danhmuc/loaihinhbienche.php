<?php
defined('_JEXEC') or die('Restricted access');

// Lấy đối tượng input từ ứng dụng
$input = JFactory::getApplication()->input;

// Lấy tên controller từ yêu cầu (URL), nếu không có thì đặt mặc định là 'default'
$controller = $input->getCmd('controller', '');
$view = $input->getCmd('view', '');

// Nếu controller không có nhưng view có, thì sử dụng view như controller
if ($controller == '' && $view != '') {
    $controller = $view;
}

// Ngược lại, nếu controller có nhưng view chưa được xác định, thì sử dụng controller làm view
if ($controller != '' && $view == '') {
    $view = $controller;
}

// Đặt lại giá trị cho controller và view vào input để Joomla xử lý
$input->set('controller', $controller);
$input->set('view', $view);

// Đường dẫn đến file controller
$path = JPATH_COMPONENT . '/controllers/' . $controller . '.php';

// Kiểm tra xem file controller có tồn tại không
if (file_exists($path)) {
    require_once $path;
} else {
    // Nếu không có controller nào, đặt controller về mặc định
    $controller = '';
}

// Tạo tên lớp controller: DanhmucControllerTênController
$classname = 'DanhmucController' . ucfirst($controller);

// Kiểm tra xem lớp controller có tồn tại không
if (class_exists($classname)) {
    // Khởi tạo controller
    $controller = new $classname();

    // Thực hiện task từ URL
    $controller->execute($input->getCmd('task', 'default'));

    // Chuyển hướng sau khi thực hiện task
    $controller->redirect();
} else {
    throw new Exception('Invalid controller class: ' . ucfirst($controller), 404);
}
