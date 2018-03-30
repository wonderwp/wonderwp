# Plugin Activator 

Create a class that extends `AbstractPluginActivator` or implements the `ActivatorInterface`

```
class RecetteActivator extends AbstractPluginActivator
{

    /**
     * Create table for entity
     */
    public function activate()
    {
    	//What's inside the activate method will be executed upon plugin activation
    	//Here you could for example create a table for your plugin, define options, copy default language files...
      
    }
}
```
What's inside the activate method will be executed upon plugin activation
Here you could for example create a table for your plugin, define options, copy default language files...
