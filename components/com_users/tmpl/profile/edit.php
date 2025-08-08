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

$user = Factory::getUser();
?>

<?php
$db = Factory::getDbo();
$base_url = Uri::root(true);
$avatarId = $user->avatar_id;
// var_dump($user->avatar_id);exit;
$avatar_url = $base_url . "/uploader/defaultImage.png";

if (!empty($avatarId)) {
    $query = $db->getQuery(true)
        ->select(['code', 'folder'])
        ->from($db->quoteName('core_attachment'))
        ->where($db->quoteName('id') . ' = ' . $db->quote($avatarId))
        ->order($db->quoteName('created_at') . ' DESC');
    $db->setQuery($query);
    // echo $query;
    $result = $db->loadObject();

    if (!empty($result) && !empty($result->code)) {
        $avatar_url = $base_url . "/uploader/get_image.php/" . $result->folder . "?code=" . $result->code;
    }
}
?>
<div class="com-users-profile__edit " style="padding: 10px 20px;">
    <h3>Chỉnh sửa thông tin cá nhân</h3>
    <!-- upload avatar -->
    <div class="profile-edit">
        <div class="upload-avatar">
            <img id="imagePreview" src="<?php echo htmlspecialchars($avatar_url, ENT_QUOTES, 'UTF-8'); ?>"
                alt="Avatar" style="width: 170px; height: 190px; margin-bottom: 5px">
            <?php echo Core::inputImage('uploadAvatar', null, 1, date('Y'), -1); ?>
        </div>
        <form id="profile-member" action="<?php echo Route::_('index.php?option=com_users&task=profile.save'); ?>" method="post" class="com-users-profile__edit-form form-validate form-horizontal well" enctype="multipart/form-data">
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
                    <button class="btn btn-danger" name="task" value="profile.cancel" formnovalidate>
                        <span class="icon-times" aria-hidden="true"></span>
                        <?php echo Text::_('Hủy'); ?>
                    </button>
                    <input type="hidden" name="option" value="com_users">
                </div>
            </div>
            <?php echo HTMLHelper::_('form.token'); ?>
        </form>
    </div>
</div>
<script>
    jQuery(document).ready(function($) {
        $('#profile-member').on('submit', function(e) {
            e.preventDefault();

            var $form = $(this);
            var formData = new FormData(this);

            $.ajax({
                url: $form.attr('action'),
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                success: function(response) {
                    let res = JSON.parse(response)
                    console.log(res)
                    console.log(res.success)
                    if (res.success == true) {
                        showToast('Lưu thông tin người dùng thành công', true);
                        setTimeout(() => {
                            window.location.reload()
                        }, 500);
                    } else {
                        showToast('Lỗi: ' + response.message, false);
                    }
                },
                error: function(xhr, status, error) {
                    showToast('Lỗi không xác định: ' + error, false);
                }
            });
        });
    });

    function showToast(message, isSuccess = true) {
        $('<div></div>')
            .text(message)
            .css({
                position: 'fixed',
                top: '20px',
                right: '20px',
                background: isSuccess ? '#28a745' : '#dc3545',
                color: 'white',
                padding: '10px 20px',
                borderRadius: '5px',
                boxShadow: '0 0 10px rgba(0,0,0,0.3)',
                zIndex: 9999
            })
            .appendTo('body')
            .delay(1000)
            .fadeOut(500, function() {
                $(this).remove();
            });
    }
</script>
<style>
    .profile-edit {
        display: flex;
        justify-content: space-evenly;
        padding: 15px 0px;
    }

    form.form-validate,
    fieldset {
        display: flex;
        flex-direction: column;
        gap: 10px
    }

    form.form-validate {
        gap: 20px;
    }

    .control-group {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .control-group .control-label {
        width: 150px;
        text-align: right;
        font-weight: bold;
    }

    .control-group .controls {
        width: 450px;
    }

    @media screen and (max-width: 768px) {
        .profile-edit {
            flex-direction: column;
            align-items: center;
        }

        form.form-validate {
            width: 100%;
        }

        .control-group .control-label {
            max-width: 150px;
            min-width: 80px;
            text-align: left;
        }

        .control-group .controls {
            max-width: 600px;
            min-width: 300px;
        }
    }
</style>