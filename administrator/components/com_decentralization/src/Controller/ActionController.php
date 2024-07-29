<?php
/* HueNN
 *
 * Created on Wed Jul 12 2023
 *
 * Copyright (c) 2023 (C) 2008 Open Source Matters, Inc. <https://www.joomla.org>
 * GNU General Public License version 2 or later; see LICENSE.txt
 */
namespace Joomla\Component\Decentralization\Administrator\Controller;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Access\Access;
use Joomla\CMS\MVC\Controller\FormController;

// phpcs:disable PSR1.Files.SideEffects
\defined('_JEXEC') or die;
// phpcs:enable PSR1.Files.SideEffects

/**
 * Group controller class.
 *
 * @since  1.6
 */
class ActionController extends FormController
{
    /**
     * @var    string  The prefix to use with controller messages.
     * @since  1.6
     */
    protected $text_prefix = 'Action';

    /**
     * Method to check if you can save a new or existing record.
     *
     * Overrides Joomla\CMS\MVC\Controller\FormController::allowSave to check the core.admin permission.
     *
     * @param   array   $data  An array of input data.
     * @param   string  $key   The name of the key for the primary key.
     *
     * @return  boolean
     *
     * @since   1.6
     */
    protected function allowSave($data, $key = 'id')
    {
        
        return ($this->app->getIdentity()->authorise('core.admin', $this->option) && parent::allowSave($data, $key));
    }
}