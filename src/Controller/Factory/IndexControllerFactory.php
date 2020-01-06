<?php
namespace Mf\Sitemap\Controller\Factory;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Laminas\EventManager\EventManager;
use Laminas\EventManager\Event;

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
