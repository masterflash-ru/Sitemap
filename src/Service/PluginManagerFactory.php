<?php
namespace Mf\Sitemap\Service;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 */
class PluginManagerFactory implements FactoryInterface
{
  public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
    return new $requestedName($container);
    }

}
