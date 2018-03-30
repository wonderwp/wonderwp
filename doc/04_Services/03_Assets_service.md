# Assets Service

The asset service is a place where you can register your assets. Registration is different from enqueing. In this servce, they are just registered so you can use them later on.

## How to create an asset service

Create a class that extends the `AbstractAssetService` class. `AbstractAssetService ` implements the `AssetServiceInterface `, therefore it requires that your hook service implements a `getAssets()` method.

```php
class MyPluginAssetService extends AbstractAssetService
{
	public function getAssets(){
		//Register your assets from there
        if(empty($this->_assets)) {
            $container = Container::getInstance();
            $manager = $container->offsetGet('wwp-recette.Manager');
            $pluginPath = $manager->getConfig('path.url');
            $assetClass = $container->offsetGet('wwp.assets.assetClass');
            $this->_assets = array(
                'css' => array(
                    new $assetClass('wwp-recette-admin', $pluginPath . '/admin/css/recette.scss', array('styleguide'), null, false, AbstractAssetService::$ADMINASSETSGROUP),
                    new $assetClass('wwp-recette-list', $pluginPath . '/public/css/recipeslist.scss', array('styleguide')),
                    new $assetClass('wwp-recette', $pluginPath . '/public/css/recipe.scss', array('styleguide'))
                ),
                'js' => array(
                    new $assetClass('wwp-recette-admin', $pluginPath . '/admin/js/recette.js', array('jquery-chosen'), null, false, AbstractAssetService::$ADMINASSETSGROUP),
                    new $assetClass('wwp-ingredient-admin', $pluginPath . '/admin/js/ingredient.js', array(), null, false, AbstractAssetService::$ADMINASSETSGROUP),
                    new $assetClass('wwp-recette', $pluginPath . '/public/js/recette.js', array('app','styleguide')),
                    new $assetClass('wwp-recette-list', $pluginPath . '/public/js/recette-list.js', array('app','styleguide')),
                )
            );
        }
        return $this->_assets;		
	}
}
```

## Registering the asset service

Add these few lines inside your plugin manager

```
$this->addService(AbstractService::$ASSETSERVICENAME,$container->factory(function(){
    //Hook service
    return new MyPluginHookService();
}));
```
