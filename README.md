# Генератор Sitemap для всего сайта

Предназначен для генерации sitemapindex - это по сути список доступных карт по модулям, для генерации отдельных карт для каждого из модулей.

на данный момент обработчики встроены в statpage и stream - работает автоматически.
В скелетное приложение втроены скелет слушателя в модуль и сам обработчик запросов.

После установки загрузить дамп в базу, если установлен модуль stream.
В дампе содержиться дополнение для работы карты сайта.

Сам модуль на зачаточном уровне.


Принцип работы:
в файле modul.php нужно указать слушатель прерывания и установить само прерывание:

```php

...
public function onBootstrap(MvcEvent $event)
{
    $this->ServiceManager=$event->getApplication()-> getServiceManager();
    $eventManager = $event->getApplication()->getEventManager();
    $sharedEventManager = $eventManager->getSharedManager();
    //слушатель для генерации карты сайта
    $sharedEventManager->attach("simba.sitemap", "GetMap", [$this, 'GetMap']);
}

/**
*обработчик события GetMap - получение карты сайта
*/
public function GetMap(Event $event)
{
    $type=$event->getParam("type",NULL);
    $name=$event->getParam("name",NULL);
    $locale=$event->getParam("locale",NULL);
    //сервис который будет возвращать карту
    $service=$this->ServiceManager->build(GetMap::class,compact("type","locale","name"));
    return $service->GetMap();
}
```
Стандартным образом создается сервис GetMap - прописывается в конфигурации данного модуля, с фабрикой и самим сервисом.

Этому сервису передается управление при обращении к контроллеру sitemap модуля, сервис должен вернуть по формату либо массив для генерации
sitemapindex, либо массив данных для генерации sitemap.
В сервис передается:
type = "sitemapindex" или "sitemap"
locale = "ru_RU" - пока не используется
name = строка имени карты, которую возвращает этот же сервис при запросе "sitemaindex"

Замечение:
используется шаровый менеджер прерываний, поэтому при обращении вызываются ВСЕ слушатели данного прерывания! 
поэтому внутри обработчика (сервиса) нужно проверять принадлежит ли имя (параметр name) данному модулую или нет, если нет, тогда нужно сразу вернуть 
пустой массив!

