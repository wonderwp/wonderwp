# Hook Service

Potentially, in a large plugin, you could find all sorts of hooks at many different places. The idea to have a hook service is to have a central place where all hooks are stored cleanly.

This service is then responsible for registering all the plugin hooks, and then dispatch the hook execution to the required classes.

## How to create a hook service
Create a class that extends the `AbstractHookService` class. `AbstractHookService` implements the `HookServiceInterface`, therefore it requires that your hook service implements a `run()` method.

```php
class MyPluginHookService extends AbstractHookService
{
	public function run(){
		//Register your hooks from there
	}
}
```

## Adding the hooks

Within the run method, add your actions and filters. Ideally the callable used by the hooks should be called on a dedicated service instead of being just a functino that lies randomly a few lines later.

For example :
```
class MyPluginHookService extends AbstractHookService
{
	public function run(){
		//Register your hooks from there
		
		$adminUiService = $this->manager->getService('adminUi');
		
		add_action('my_action_a', [$adminUiService,'handleActionA');
		add_action('my_action_b', [$adminUiService,'handleActionB');
		
		add_filter('example_filter', [$adminUiService,'filterSampleValue')
		
	}
}
```

## Registering the hook service
Now that your hook service is ready, add these few lines inside your plugin manager to let him now about your hook service.

```
$this->addService(AbstractService::$HOOKSERVICENAME,$container->factory(function(){
    //Hook service
    return new MyPluginHookService();
}));
```

