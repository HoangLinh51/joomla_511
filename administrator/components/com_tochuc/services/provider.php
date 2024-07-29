<?php

/**
 * @package     Joomla.Administrator
 * @subpackage  com_contenthistory
 *
 * @copyright   (C) 2018 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Dispatcher\ComponentDispatcherFactoryInterface;
use Joomla\CMS\Extension\ComponentInterface;
use Joomla\CMS\Extension\MVCComponent;
use Joomla\CMS\Extension\Service\Provider\ComponentDispatcherFactory;
use Joomla\CMS\Extension\Service\Provider\MVCFactory;
use Joomla\CMS\Extension\Service\Provider\RouterFactory;
use Joomla\CMS\MVC\Factory\MVCFactoryInterface;
use Joomla\DI\Container;
use Joomla\DI\ServiceProviderInterface;

/**
 * The categories service provider.
 *
 * @since  4.0.0
 */
return new class () implements ServiceProviderInterface {
       
    public function register(Container $container): void 
    {
        $container->registerServiceProvider(new MVCFactory('\\Joomla\\Component\\Tochuc'));
        $container->registerServiceProvider(new ComponentDispatcherFactory('\\Joomla\\Component\\Tochuc'));
        $container->registerServiceProvider(new RouterFactory('\\Joomla\\Component\\Tochuc'));
        $container->set(
                ComponentInterface::class,
                function (Container $container)
                {
                    $component = new MVCComponent($container->get(ComponentDispatcherFactoryInterface::class));
                    $component->setMVCFactory($container->get(MVCFactoryInterface::class));
                    return $component;
    
                }
        );

    }
};