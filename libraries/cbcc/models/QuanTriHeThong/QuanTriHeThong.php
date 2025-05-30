<?php
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\MVC\Model\BaseDatabaseModel;
use Joomla\CMS\User\User;
use Joomla\CMS\User\UserHelper;


class QuanTriHeThong_Model_QuanTriHeThong extends BaseDatabaseModel
{

  public function getTitle()
  {
    return "Tie";
  }

  public function getListAccount($keyword, $page, $take)
  {
    $db = Factory::getDbo();
    $query = $db->getQuery(true);

    // Xây dựng truy vấn cơ bản
    $query->select('a.id, a.name, a.username, a.email, a.block, a.requireReset, GROUP_CONCAT(c.title SEPARATOR "<br/>") AS nhomnguoidung')
      ->from('#__users AS a')
      ->innerJoin('#__user_usergroup_map AS b ON a.id = b.user_id')
      ->innerJoin('#__usergroups AS c ON b.group_id = c.id')
      ->where('a.id > 100')
      ->where('a.is_deleted = 0')
      ->group('a.id');

    // Xử lý tìm kiếm theo $keyword
    if (!empty($keyword)) {
      $keyword = $db->escape($keyword); // Bảo mật chống SQL injection
      $query->where(
        '(' . 'a.name LIKE ' . $db->quote('%' . $keyword . '%') . ' OR ' . 'a.username LIKE ' . $db->quote('%' . $keyword . '%') . ')'
      );
    }

    // Đếm tổng số bản ghi (không phân trang)
    $totalQuery = clone $query;
    $totalQuery->clear('select')->clear('group')->select('COUNT(DISTINCT a.id)');
    $db->setQuery($totalQuery);
    $totalRecord = $db->loadResult();

    // Áp dụng phân trang
    $take = (int) $take > 0 ? (int) $take : 20;
    $skip = ($page - 1) * $take;
    $query->setLimit($take, $skip);

    try {
      $db->setQuery($query);
      $data = $db->loadAssocList();

      // Trả về kết quả theo định dạng yêu cầu
      return [
        'data' => $data,
        'page' => (int) $page,
        'take' => (int) $take,
        'totalrecord' => (int) $totalRecord
      ];
    } catch (Exception $e) {
      Factory::getApplication()->enqueueMessage('Lỗi khi lấy danh sách user: ' . $e->getMessage(), 'error');
      return [
        'data' => [],
        'page' => (int) $page,
        'take' => (int) $take,
        'totalrecord' => 0
      ];
    }
  }

  // get account by id  
  public function getAccountById($taikhoan_id)
  {
    $db = Factory::getDbo();
    $query = $db->getQuery(true);

    // Truy vấn chính để lấy thông tin tài khoản và các group_id
    $query->select('a.*, GROUP_CONCAT(b.group_id) AS group_ids, c.*')
      ->from('#__users AS a')
      ->innerJoin('#__user_usergroup_map AS b ON a.id = b.user_id')
      ->leftJoin('phanquyen_user2khuvuc AS c ON a.id = c.user_id')
      ->where('a.id = ' . $db->quote($taikhoan_id))
      ->group('a.id'); // Nhóm theo a.id để tránh trùng lặp dữ liệu người dùng

    $db->setQuery($query);
    $result = $db->loadAssoc();

    // Chuyển group_ids thành mảng
    if ($result && !empty($result['group_ids'])) {
      $result['group_ids'] = explode(',', $result['group_ids']);
    } else {
      $result['group_ids'] = []; // Trả về mảng rỗng nếu không có group_id
    }

    return $result;
  }

  // Get list khuvuc
  public function getRegionList()
  {
    $db = Factory::getDbo();
    $query = $db->getQuery(true);
    $query->select('a.*,b.tenkhuvuc AS cha')
      ->from('danhmuc_khuvuc AS a')
      ->innerJoin('danhmuc_khuvuc AS b ON a.cha_id = b.id')
      ->where('a.daxoa = 0')
      ->where('a.level > 1 ')
      ->order('a.level,b.tenkhuvuc ASC, a.tenkhuvuc ASC');
    try {
      $db->setQuery($query);
      return $db->loadAssocList();
    } catch (Exception $e) {
      Factory::getApplication()->enqueueMessage('Lỗi khi lấy danh sách khu vực: ' . $e->getMessage(), 'error');
      return [];
    }
  }

  //get list chuc nang 
  public function getUserGroupFunctions()
  {
    $db = Factory::getDbo();
    $query = $db->getQuery(true)
      ->select(['id', 'title'])
      ->from($db->quoteName('jos_usergroups'));

    $db->setQuery($query);

    try {
      return $db->loadObjectList();
    } catch (Exception $e) {
      Factory::getApplication()->enqueueMessage('Lỗi khi lấy danh sách chức năng sử dụng: ' . $e->getMessage(), 'error');
      return [];
    }
  }

  public function changeTrangthaiTK($user_id, $trangthai)
  {
    $db = Factory::getDbo();
    $query = $db->getQuery(true);
    $query->update($db->quoteName('jos_users'));
    if ($trangthai == 1) {
      $query->set('block = 0');
    } else if ($trangthai == 0) {
      $query->set('block = 1');
    } else {
      return false;
    }
    $query->where('id = ' . $db->quote($user_id));
    $db->setQuery($query);
    return $db->execute();
  }

  function resetPassworkTK($id, $inputPassword)
  {
    $user = Factory::getUser($id);

    if ($user->id == 0) {
      return ['success' => false, 'message' => 'User không tồn tại'];
    }

    $newPassword = (string) $inputPassword;
    $newPassword = mb_convert_encoding($newPassword, 'UTF-8');

    // Tắt yêu cầu reset
    $user->requireReset = 0;

    $data = [
      'password'  => $newPassword,
      'password2' => $newPassword,
    ];

    if (!$user->bind($data)) {
      return ['success' => false, 'message' => $user->getError()];
    }

    // Test nội bộ hash đúng chưa
    if (!UserHelper::verifyPassword($newPassword, $user->password, $user->id)) {
      return ['success' => false, 'message' => 'Mã hóa sai'];
    }

    if (!$user->save(true)) {
      return ['success' => false, 'message' => $user->getError()];
    }

    return ['success' => true, 'message' => 'Cập nhật thành công'];
  }

  // function to save user model
  public function saveUserModel($formData)
  {
    // Get the database object
    $db = Factory::getDbo();
    $formData['chucNang'] = array_map('intval', explode(',', $formData['chucNang']));

    try {
      // New user creation
      if (empty($formData['id'])) {
        return $this->createUser($formData, $db);
      }

      // Update existing user
      return $this->updateUser($formData, $db);
    } catch (Exception $e) {
      return [
        'success' => false,
        'error' => $e->getMessage()
      ];
    }
  }

  private function createUser($formData, $db): array
  {
    $user = new User();
    // Prepare user data
    $data = [
      'name'         => $formData['name'],
      'username'     => $formData['username'],
      'email'        => $formData['email'],
      'password'     => $formData['password'],
      'password2'    => $formData['password'],
      'block'        => isset($formData['block']) ? (int)$formData['block'] : 0,
      'requireReset' => (int)$formData['requireReset'],
      'groups'       => $formData['chucNang'],
      'lastvisitDate' => '0000-00-00 00:00:00',
      'lastResetTime' => '0000-00-00 00:00:00',
    ];

    // Bind and save the user
    if (!$user->bind($data)) {
      return [
        'success' => false,
        'error' => 'Bind failed: ' . implode(', ', $user->getErrors())
      ];
    }

    if (!$user->save()) {
      return [
        'success' => false,
        'error' => 'Save failed: ' . implode(', ', $user->getErrors())
      ];
    }

    $chucNangs = $formData['chucNang'];
    // Insert user permissions into core_user_action_donvi
    $query = $db->getQuery(true)
      ->insert($db->quoteName('core_user_action_donvi'))
      ->columns(['user_id', 'action_id', 'iddonvi', 'group_id']);

    foreach ($chucNangs as $chucNangId) {
      $query->values(
        (int)$user->id . ', 1, 1, ' . (int)$chucNangId
      );
    }

    $db->setQuery($query);

    if (!$db->execute()) {
      return [
        'success' => false,
        'error' => $db->getErrorMsg()
      ];
    }

    // Insert user permissions into phanquyen_user2khuvuc
    $permissionResult = $this->saveUserPermissions($formData, $user->id, $db);
    if (!$permissionResult['success']) {
      return $permissionResult;
    }

    return [
      'success' => true,
      'user_id' => $user->id
    ];
  }

  private function updateUser($formData, $db): array
  {
    // Load existing user
    $user = new User();
    if (!$user->load($formData['id'])) {
      return [
        'success' => false,
        'error' => 'Failed to load user with ID: ' . $formData['id']
      ];
    }

    // Prepare user data for update
    $data = [
      'id'           => $formData['id'],
      'name'         => $formData['name'],
      'username'     => $formData['username'],
      'email'        => $formData['email'],
      'password'     => $formData['password'],
      'password2'    => $formData['password'],
      'block'        => isset($formData['block']) ? (int)$formData['block'] : 0,
      'requireReset' => (int)$formData['requireReset'],
      'groups'       => $formData['chucNang'],
    ];

    // Bind updated data to user
    if (!$user->bind($data)) {
      return [
        'success' => false,
        'error' => 'Bind failed in upldate: ' . implode(', ', $user->getErrors())
      ];
    }

    // Save the updated user
    if (!$user->save()) {
      return [
        'success' => false,
        'error' => 'Save failed: ' . implode(', ', $user->getErrors())
      ];
    }
    // Include password only if provided
    // if (!empty($formData['password'])) {
    //   $salt = UserHelper::genRandomPassword(32);

    //   $data['password'] = UserHelper::hashPassword($formData['password']) . ':' . $salt;
    // }

    // Delete existing permissions
    $query = $db->getQuery(true)
      ->delete($db->quoteName('core_user_action_donvi'))
      ->where($db->quoteName('user_id') . ' = ' . (int)$formData['id']);

    if (!$db->setQuery($query)->execute()) {
      return [
        'success' => false,
        'error' => 'Failed to delete existing permissions: ' . $db->getErrorMsg()
      ];
    }

    // Insert updated permissions
    $chucNangs = $formData['chucNang'];
    $query = $db->getQuery(true)
      ->insert($db->quoteName('core_user_action_donvi'))
      ->columns(['user_id', 'action_id', 'iddonvi', 'group_id']);

    foreach ($chucNangs as $chucNangId) {
      $query->values(
        (int)$formData["id"] . ', 0, 0, ' . (int)$chucNangId
      );
    }

    if (!$db->setQuery($query)->execute()) {
      return [
        'success' => false,
        'error' => 'Failed to insert updated permissions: ' . $db->getErrorMsg()
      ];
    }

    // Delete existing permissions in phanquyen_user2khuvuc
    $query = $db->getQuery(true)
      ->delete($db->quoteName('phanquyen_user2khuvuc'))
      ->where($db->quoteName('user_id') . ' = ' . (int)$formData['id']);

    if (!$db->setQuery($query)->execute()) {
      return [
        'success' => false,
        'error' => 'Failed to delete existing khu vuc permissions: ' . $db->getErrorMsg()
      ];
    }

    // Update user permissions in phanquyen_user2khuvuc
    $permissionResult = $this->saveUserPermissions($formData, $formData["id"], $db);
    if (!$permissionResult['success']) {
      return $permissionResult;
    }

    return [
      'success' => true,
      'user_id' => $formData['id']
    ];
  }

  private function saveUserPermissions($formData, $userId, $db): array
  {
    $query = $db->getQuery(true)
      ->insert($db->quoteName('phanquyen_user2khuvuc'))
      ->columns(['user_id', 'quanhuyen_id', 'phuongxa_id', 'thonto_id'])
      ->values(
        (int)$userId . ',' .
          $db->quote(0) . ',' .
          $db->quote($formData["phuongXa"]) . ',' .
          $db->quote($formData["thonTo"])
      );

    $db->setQuery($query);

    if (!$db->execute()) {
      return [
        'success' => false,
        'error' => 'Failed to insert user permissions: ' . $db->getErrorMsg()
      ];
    }

    return [
      'success' => true
    ];
  }

  public function deleteAccount($formData)
  {
    $db = Factory::getDbo();
    $query = $db->getQuery(true)
      ->update('jos_users')
      ->set('is_deleted = 1')
      ->set('deleted_by = ' . $db->quote($formData['idUser']))
      ->set('deleted_at = NOW()')
      ->where('id =' . $db->quote($formData['idAccount']));

    $db->setQuery($query);
    try {
      $db->execute();
      return [
        'success' => true,
      ];
    } catch (Exception $e) {
      return [
        'success' => false,
        'error' => 'Có lỗi khi xóa User: ' . $e->getMessage()
      ];
    }
  }
}
