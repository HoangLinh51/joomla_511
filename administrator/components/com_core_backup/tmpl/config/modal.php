<?php

/**
 * @package     Joomla.Administrator
 * @subpackage  com_menus
 *
 * @copyright   (C) 2016 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

use Joomla\CMS\Factory;

defined('_JEXEC') or die;

?>
<button id="saveBtn" type="button" class="visually-hidden" onclick="Joomla.submitbutton('config.save');"></button>
<button id="closeBtn" type="button" class="visually-hidden"></button>
<div class="container-popup">
    <?php $this->setLayout('edit'); ?>
    <?php echo $this->loadTemplate(); ?>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    Joomla.submitbutton = function(task) {
        if (task === 'config.save') {
            const form = document.getElementById('adminFormConfig');
            if (document.formvalidator.isValid(form)) {
                // Use AJAX to submit the form
                const formData = new FormData(form);
                fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.data.success) {
                        //window.location.href = data.data.redirect;
                        // window.parent.location.reload();

                        let element = document.getElementById('system-message-container');
                        console.log(element)
                        const notifica = '<joomla-alert type="success" close-text="Close" dismiss="true" role="alert" style="animation-name: joomla-alert-fade-in;"><button type="button" class="joomla-alert--close" aria-label="Close"><span aria-hidden="true">×</span></button><button type="button" class="joomla-alert--close" aria-label="Close"><span aria-hidden="true">×</span></button><div class="alert-heading"><span class="success"></span><span class="visually-hidden">success</span></div><div class="alert-wrapper"><div class="alert-message">Xử lý thành công</div></div></joomla-alert>'
                        element.innerHTML = notifica;
                       
                    } else {
                        // Handle error
                        alert('An error occurred: ' + data.data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An unexpected error occurred.');
                });
            } else {
                alert('Please fill in all required fields 143.');
            }
        }
    };
});
</script>

