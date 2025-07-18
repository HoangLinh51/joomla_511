<?php
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\MVC\Model\BaseDatabaseModel;

class DungChung_Model_Base extends BaseDatabaseModel
{

  public function getTitle()
  {
    return "Tie";
  }

  public function checkPermissionAdmin()
  {
    $userId = Factory::getUser()->id;
    $db = Factory::getDbo();
    $query = $db->getQuery(true)
      ->select('COUNT(*)')
      ->from('jos_user_usergroup_map')
      ->where('user_id = ' . (int) $userId)
      ->where('group_id =' .  75);
    $db->setQuery($query);
    $permission = (int) $db->loadResult();
    return $permission > 0;
  }

  public function checkPermissionError()
  {
    $userId = Factory::getUser()->id;
    $db = Factory::getDbo();
    $query = $db->getQuery(true)
      ->select('COUNT(*)')
      ->from('jos_user_usergroup_map')
      ->where('user_id = ' . (int) $userId)
      ->where('group_id =' .  77);
    $db->setQuery($query);
    $permission = (int) $db->loadResult();
    return $permission > 0;
  }

  public function checkPermissionNotification()
  {
    $userId = Factory::getUser()->id;
    $db = Factory::getDbo();
    $query = $db->getQuery(true)
      ->select('COUNT(*)')
      ->from('jos_user_usergroup_map')
      ->where('user_id = ' . (int) $userId)
      ->where('group_id =' .  76);
    $db->setQuery($query);
    $permission = (int) $db->loadResult();
    return $permission > 0;
  }
}
