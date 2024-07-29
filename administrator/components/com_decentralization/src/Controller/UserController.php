<?php 
 /* HueNN
 *
 * Created on Thu Jul 06 2023
 *
 * Copyright (c) 2023 (C) 2008 Open Source Matters, Inc. <https://www.joomla.org>
 * GNU General Public License version 2 or later; see LICENSE.txt
 */
namespace Joomla\Component\Decentralization\Administrator\Controller;


use Joomla\CMS\MVC\Controller\FormController;
// phpcs:disable PSR1.Files.SideEffects
\defined('_JEXEC') or die;
// phpcs:enable PSR1.Files.SideEffects

/**
 * User controller class.
 *
 * @since  1.6
 */
class UserController extends FormController
{
    /**
     * @var    string  The prefix to use with controller messages.
     * @since  1.6
     */
    protected $text_prefix = 'COM_DECENTRALIZATION_USER';

}
