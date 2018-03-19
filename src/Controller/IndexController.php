<?php
/**
контроллер работы с Sitemap

 */

namespace Mf\Sitemap\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Exception;
use Zend\Navigation\Service\ConstructedNavigationFactory;

use Mf\Sitemap\Service\PluginManager;


class IndexController extends AbstractActionController
{
    protected $EventManager;
    protected $ServiceManager;
    protected $ServerDefaultUri;

public function __construct ($EventManager,$ServiceManager)
{

    $this->EventManager=$EventManager;
    $this->ServiceManager=$ServiceManager;
    $config=$ServiceManager->get("config");
    $this->ServerDefaultUri=$config["ServerDefaultUri"];
    
}

/**
*формирование sitemapindex из всех модулей которые могут формировать его
*/
public function indexAction()
{
	$factory    = new ConstructedNavigationFactory([]);
	$navigation = $factory->createService($this->ServiceManager);

    /*новый плагин для генерации sitemap*/
    $pluginManager = $this->ServiceManager->get(PluginManager::class);
    $items=$this->EventManager->trigger("GetMap", $this, ["type"=>"sitemapindex","locale"=>"ru_RU"]);
    if (count($items)==0) {throw new  Exception("Нет ни одной доступной карты сайта");}
    $view=new ViewModel([
        "navigation"=>$navigation,
        "pluginManager"=>$pluginManager,
        "items"=>$items,
        "ServerDefaultUri"=>$this->ServerDefaultUri
    ]);
    
    $view->setTerminal(true);

    return $view;
}

/**
*формирование sitemap для конкретного модуля
*/
public function detalAction()
{
    $name=$this->params('url',NULL);
    $rez=[];
    foreach ($this->EventManager->trigger("GetMap", $this, ["type"=>"sitemap","locale"=>"ru_RU","name"=>$name]) as $item){
        if (!empty($item)) {$rez=array_merge($rez,$item);}
    }
    if (count($rez)==0) {throw new  Exception("Карта $name пустая");}

    $factory    = new ConstructedNavigationFactory($rez);
    $navigation = $factory->createService($this->ServiceManager);

    $view=new ViewModel([
        "navigation"=>$navigation,
        "ServerDefaultUri"=>$this->ServerDefaultUri
    ]);

    $view->setTerminal(true);

    return $view;
}

    
}