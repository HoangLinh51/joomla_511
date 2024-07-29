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
<button id="closeBtn" type="button" class="visually-hidden" onclick="Joomla.submitbutton('config.cancel');"></button>
<div class="container-popup">
    <?php $this->setLayout('edit'); ?>
    <?php echo $this->loadTemplate(); ?>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        Joomla.submitbutton = function(task) {
            console.log(task)
            if (task === 'config.save') {
                const form = document.getElementById('adminFormConfig');
                console.log(form)
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
                        console.log(data.data);
                        if (data.success) {
                            alert(data.data.message || 'Form submitted successfully!');
                            // Redirect to the specified URL
                        } else {
                            // Handle error
                            console.log(data);
                            alert('An error occurred: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An unexpected error occurred.');
                    });
                } else {
                    alert('Please fill in all required fields.');
                }
            }
        };
    });
</script>

