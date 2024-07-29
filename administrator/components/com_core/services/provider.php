<?php

/**
 * @package     Joomla.Administrator
 * @subpackage  com_core
 *
 * @copyright   (C) 2018 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Component\Router\RouterFactoryInterface;
use Joomla\CMS\Dispatcher\ComponentDispatcherFactoryInterface;
use Joomla\CMS\Extension\ComponentInterface;
use Joomla\CMS\Extension\MVCComponent;
use Joomla\CMS\Extension\Service\Provider\ComponentDispatcherFactory;
use Joomla\CMS\Extension\Service\Provider\MVCFactory;
use Joomla\CMS\Extension\Service\Provider\RouterFactory;
use Joomla\CMS\HTML\Registry;
use Joomla\CMS\MVC\Factory\MVCFactoryInterface;
use Joomla\Component\Core\Administrator\Extension\CoreComponent;
use Joomla\DI\Container;
use Joomla\DI\ServiceProviderInterface;

/**
 * The categories service provider.
 *
 * @since  4.0.0
 */
return new class () implements ServiceProviderInterface {
    /**
     * Registers the service provider with a DI container.
     *
     * @param   Container  $container  The DI container.
     *
     * @return  void
     *
     * @since   4.0.0
     */
    // public function register(Container $container)
    // {
    //     $container->registerServiceProvider(new MVCFactory('\\Joomla\\Component\\Core'));
    //     $container->registerServiceProvider(new ComponentDispatcherFactory('\\Joomla\\Component\\Core'));
    //     $container->registerServiceProvider(new RouterFactory('\\Joomla\\Component\\Core'));
    //     $container->set(
    //         ComponentInterface::class,
    //         function (Container $container) {
    //             $component = new MVCComponent($container->get(ComponentDispatcherFactoryInterface::class));
    //             $component->setMVCFactory($container->get(MVCFactoryInterface::class));
    //             return $component;
    //         }
    //     );
    // }

    public function register(Container $container)
    {
        $container->registerServiceProvider(new MVCFactory('\\Joomla\\Component\\Core'));
        $container->registerServiceProvider(new ComponentDispatcherFactory('\\Joomla\\Component\\Core'));
        $container->registerServiceProvider(new RouterFactory('\\Joomla\\Component\\Core'));

        $container->set(
            ComponentInterface::class,
            function (Container $container) {
                $component = new CoreComponent($container->get(ComponentDispatcherFactoryInterface::class));
                $component->setMVCFactory($container->get(MVCFactoryInterface::class));
                $component->setRouterFactory($container->get(RouterFactoryInterface::class));
                $component->setRegistry($container->get(Registry::class));

                return $component;
            }
        );
    }
};
