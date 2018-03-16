<?php
/**
контроллер работы с Sitemap

 */

namespace Mf\Sitemap\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Exception;

class IndexController extends AbstractActionController
{

    protected $connection;

public function __construct ($connection)
{
    $this->connection=$connection;
}


public function indexAction()
{

}
