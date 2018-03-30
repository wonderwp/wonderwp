# Public Controller

The aim of a public controller is to be the entry point of your frontend call stack. By default you'll enter this file either via a route (be it a file route or a callable route - see the routing section for more information), or via a shortcode.

## Creating a plublic controller

There's an `AbstractPluginFrontendController` class you can extend to add a few functionalities to your own public frontend controller, but more precisely some default support for those two entry points types.

## Registering the controller within you manager

```
//Public Controller
$this->addController(AbstractManager::PUBLIC_CONTROLLER_TYPE, function () {
    return new MyPublicController($this);
});
```

## Reaching the controller via shortcode

- Inside your shortcode service : `add_shortcode('mypluginshortcode', [$myPluginFrontendController, 'handleShortCode']);`

## Reaching the controller via a route

- See the `Services / Route service` documentation.
- TL;DR:
 
```
$this->_routes = [
	['recette/resetfilters/{previousRecettePageId}',array($manager->getController(AbstractManager::$PUBLICCONTROLLERTYPE),'resetFilters'),'GET'] //example of a route that maps a url to a callable
];
```

## Calling a view from inside a controller action

```
return $this->renderView(
    'myViewFileName', // The view name => myPluginRoot/public/views/myViewFileName.php
    [ // The view params
        'param1'  => 'val1', 
        'param2' => 'val2',
    ] //You can now use $param1 & $param2 inside myViewFileName.php
);
```

This tries to locate the `myViewFileName.php` inside your plugin `/public/views/` folder. Something like `myPluginRoot/public/views/myViewFileName.php`.

If the file is found, from within the file, you'll be able to access your view parameters. From the example they'll be respectively called $param1 (which will be equal to 'val1')  & $param2 (='val2');
