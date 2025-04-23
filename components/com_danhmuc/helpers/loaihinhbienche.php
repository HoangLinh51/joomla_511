<?php
defined('_JEXEC') or die('Restricted access');

// Lấy tên controller từ request
$controllerName = JFactory::getApplication()->input->getCmd('controller', 'default');

// Đường dẫn đến file controller
$controllerPath = JPATH_COMPONENT . '/controllers/' . $controllerName . '.php';

// Kiểm tra nếu file controller tồn tại
if (file_exists($controllerPath)) {
    require_once $controllerPath;

    // Đặt tên lớp controller (ví dụ: DanhmucControllerBienche)
    $controllerClass = 'DanhmucController' . ucfirst($controllerName);

    // Kiểm tra xem lớp controller có tồn tại không
    if (class_exists($controllerClass)) {
        // Khởi tạo controller
        $controller = new $controllerClass();

        // Gọi task từ URL
        $controller->execute(JFactory::getApplication()->input->getCmd('task', 'default'));

        // Chuyển hướng sau khi thực hiện task
        $controller->redirect();
    } else {
        throw new Exception('Invalid controller class: ' . $controllerName, 404);
    }
} else {
    throw new Exception(JText::_('COM_DANHMUC_INVALID_CONTROLLER'), 404);
}
