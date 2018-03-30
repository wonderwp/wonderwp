# The Plugin Manager

The manager is an essential file for your plugin. It's inside this file that you register your controllers, your services, your plugin configuration.


##Registering your configs

See `$this->setConfig($key,$val)` and `$this->getConfig($key,$defaultValueIfEmpty)`;

##Registering your controllers

```
//Admin controller example
$this->addController(AbstractManager::ADMIN_CONTROLLER_TYPE, function () {
    return new ErThemeAdminController($this);
});

//Public controller example
$this->addController(AbstractManager::PUBLIC_CONTROLLER_TYPE, function () {
    return new ErThemePublicController($this);
});
```

The two types are constants on the `AbstractManager` class


##Registering your services

```
$this->addService(ServiceInterface::HOOK_SERVICE_NAME, function () {
    //Hook service
    return new ErThemeHookService();
});
```

You can see the reserved service names as constants on the `ServiceInterface` class.
