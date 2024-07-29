<?php

use Joomla\CMS\Language\Text;

defined('_JEXEC') or die;

if (empty($list)) {
    return;
}

echo '<ul class="breadcrumbs">';
foreach ($list as $item) {
    $componentName = !empty($item->component) ? ' (' . Text::_($item->component) . ')' : '';
    $viewName = !empty($item->view) ? ' [' . Text::_($item->view) . ']' : '';
    if ($item->link) {
        echo '<li><a href="' . $item->link . '">' . $item->name . $componentName . $viewName . '</a></li>';
    } else {
        echo '<li>' . $item->name . $componentName . $viewName . '</li>';
    }
}
echo '</ul>';
