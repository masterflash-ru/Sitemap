<?php
namespace Mf\Kontakt\Controller\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;


/**
 */
class IndexControllerFactory implements FactoryInterface
{
  public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {

    $connection = $container->get('ADO/connection');
    return new $requestedName($connection);
    }

}
