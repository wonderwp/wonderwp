# Shortcode Service

Similarly to hooks, in large plugins you could have multiple shortcode definitions, pointing to callables defined in various places. Still similarly to hooks, this service tries to act as the object that gathers and manages the shortcode definitions.

## How to create a shortcode service
Create a class that extends the `AbstractShortcodeService` class. The `AbstractShortcodeService ` class implements the `ShortcodeServiceInterface`, therefore it requires that your route service implements a `registerShortcodes()` method.

```
class MyPluginShortcodeService extends AbstractShortcodeService
{

    public function registerShortcodes()
    {
        add_shortcode('myshortcode', array($this, 'myshortcodemethod'));
    }
    
    public function myshortcodemethod(){
    	return 'hello world';
    }
}
```

## Registering the shortcode service
Add these few lines inside your plugin manager.

```
//Shortcode
$this->addService(AbstractService::$SHORTCODESERVICENAME, function(){
    return new MyPLuginShortcodeService();
});
```
