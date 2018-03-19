<?php
namespace Mf\Sitemap\Controller\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Zend\EventManager\EventManager;
use Zend\EventManager\Event;

/**
 */
class IndexControllerFactory implements FactoryInterface
{
  public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
      $SharedEventManager=$container->get('SharedEventManager');
      /*общий менеджер прерываний*/
      $EventManager=new EventManager($SharedEventManager);
      /*идентификатор прерывания*/
      $EventManager->addIdentifiers(["simba.sitemap"]);
    return new $requestedName($EventManager,$container);
    }

}
