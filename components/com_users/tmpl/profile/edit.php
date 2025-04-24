<?php

/**
 * @package     Joomla.Site
 * @subpackage  com_users
 *
 * @copyright   (C) 2009 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;

/** @var Joomla\Component\Users\Site\View\Profile\HtmlView $this */

HTMLHelper::_('bootstrap.tooltip', '.hasTooltip');

// Load user_profile plugin language
$lang = $this->getLanguage();
$lang->load('plg_user_profile', JPATH_ADMINISTRATOR);

/** @var Joomla\CMS\WebAsset\WebAssetManager $wa */
$wa = $this->document->getWebAssetManager();
$wa->useScript('keepalive')
    ->useScript('form.validate');

?>

<?php
$db = Factory::getDbo(); // Lấy đối tượng database của Joomla
$base_url = Uri::root(true); // Lấy URL gốc của trang web
$avatar_id = !empty($this->data->avatar_id) ? $this->data->avatar_id : null; // Lấy avatar_id từ dữ liệu
$avatar_url = $base_url . "/images/avatars/noimage.png"; // Mặc định ảnh

if (!empty($avatar_id)) {
    // Tạo truy vấn lấy dữ liệu từ bảng core_attachment dựa vào id
    $query = $db->getQuery(true)
        ->select($db->quoteName('code')) // Chỉ lấy cột "code"
        ->from($db->quoteName('core_attachment'))
        ->where($db->quoteName('object_id') . ' = ' . $db->quote($avatar_id))
        ->order($db->quoteName('created_at') . ' DESC');
    $db->setQuery($query); // Thi hành truy vấn
    $result = $db->loadObject(); // Lấy kết quả dưới dạng object

    // Kiểm tra xem có dữ liệu không
    if (!empty($result) && !empty($result->code)) {
        $avatar_url = $base_url . "/uploader/get_image.php?code=" . $result->code;
    }
}
?>
<div class="com-users-profile__edit profile-edit" style="padding: 10px 20px;">
    <!-- upload avatar -->
    <img id="avatar-preview" src="<?php echo htmlspecialchars($avatar_url, ENT_QUOTES, 'UTF-8'); ?>"
        alt="Avatar" style="width: 115px; height: 150px;">
    <?php echo Core::inputAvatar('uploadAvatar', null, 1, date('Y'), -1); ?>

    <form id="member-profile" action="<?php echo Route::_('index.php?option=com_users'); ?>" method="post" class="com-users-profile__edit-form form-validate form-horizontal well" enctype="multipart/form-data">
        <?php // Iterate through the form fieldsets and display each one. 
        ?>
        <?php foreach ($this->form->getFieldsets() as $group => $fieldset) : ?>
            <?php $fields = $this->form->getFieldset($group); ?>
            <?php if (count($fields)) : ?>
                <fieldset>
                    <?php // If the fieldset has a label set, display it as the legend. 
                    ?>
                    <?php if (isset($fieldset->label)) : ?>
                        <legend>
                            <?php echo Text::_($fieldset->label); ?>
                        </legend>
                    <?php endif; ?>
                    <?php if (isset($fieldset->description) && trim($fieldset->description)) : ?>
                        <p>
                            <?php echo $this->escape(Text::_($fieldset->description)); ?>
                        </p>
                    <?php endif; ?>
                    <?php // Iterate through the fields in the set and display them. 
                    ?>
                    <?php foreach ($fields as $field) : ?>
                        <?php echo $field->renderField(); ?>
                    <?php endforeach; ?>
                </fieldset>
            <?php endif; ?>
        <?php endforeach; ?>

        <div class="com-users-profile__edit-submit control-group">
            <div class="controls">
                <button type="submit" class="btn btn-primary validate" name="task" value="profile.save">
                    <span class="icon-check" aria-hidden="true"></span>
                    <?php echo Text::_('Lưu'); ?>
                </button>
                <button type="submit" class="btn btn-danger" name="task" value="profile.cancel" formnovalidate>
                    <span class="icon-times" aria-hidden="true"></span>
                    <?php echo Text::_('Hủy'); ?>
                </button>
                <input type="hidden" name="option" value="com_users">
            </div>
        </div>
        <?php echo HTMLHelper::_('form.token'); ?>
    </form>
</div>