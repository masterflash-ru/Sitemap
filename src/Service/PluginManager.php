<?php
/**
 */

namespace Mf\Sitemap\Service;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\InvokableFactory;
use Laminas\View\HelperPluginManager;
use Mf\Sitemap\View\Helper\Navigation\SitemapIndex;

use Laminas\View\Helper\Navigation\PluginManager as LaminasNavigationPluginManager;
use Laminas\View\Helper\Navigation;


/**
 * Plugin manager implementation for navigation helpers
 *
 * Enforces that helpers retrieved are instances of
 * Navigation\HelperInterface. Additionally, it registers a number of default
 * helpers.
 */
class PluginManager extends LaminasNavigationPluginManager
{
    /**
     * @var string Valid instance types.
     */
   // protected $instanceOf = AbstractHelper::class;

    /**
     * Default aliases
     *
     * @var string[]
     */
    protected $aliases = [
        'sitemap'     => Navigation\Sitemap::class,
        'sitemapindex'=> SitemapIndex::class,
    ];

    /**
     * Default factories
     *
     * @var string[]
     */
    protected $factories = [
        Navigation\Sitemap::class     => InvokableFactory::class,
        SitemapIndex::class     => InvokableFactory::class,
        // v2 canonical FQCNs

        'Laminasviewhelpernavigationsitemap'     => InvokableFactory::class,
    ];

    /**
     * @param null|ConfigInterface|ContainerInterface $configOrContainerInstance
     * @param array $v3config If $configOrContainerInstance is a container, this
     *     value will be passed to the parent constructor.
     */
    public function __construct($configOrContainerInstance = null, array $v3config = [])
    {
        $this->initializers[] = function ($first, $second) {
            // v2 vs v3 argument order
            if ($first instanceof ContainerInterface) {
                // v3
                $container = $first;
                $instance = $second;
            } else {
                // v2
                $container = $second;
                $instance = $first;
            }

            if (! $instance instanceof AbstractHelper) {
                return;
            }

            // This initializer was written with v2 functionality in mind; as such,
            // we need to test and see if we're called in a v2 context, and, if so,
            // set the service locator to the parent locator.
            //
            // Under v3, the parent locator is what is passed to the method already.
            if (! method_exists($container, 'configure') && $container->getServiceLocator()) {
                $container = $container->getServiceLocator();
            }

            $instance->setServiceLocator($container);
        };

        parent::__construct($configOrContainerInstance, $v3config);
    }
}
