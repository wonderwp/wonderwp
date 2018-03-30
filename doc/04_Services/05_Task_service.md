# Task Service (WP-CLI)

Sometimes in plugins, you could want to create some specific WP-CLI command.

## How to create a task service

Create a class that implements the `TaskServiceInterface`, which requires you to implement a `registerCommands` method.

```
class MyPluginCommandService implements TaskServiceInterface
{
    public function registerCommands(){
        if(!class_exists('WP_CLI')){ return; }
        
        \WP_CLI::add_command( 'commandName', CommandClass::name ); //authorizing a new wp-cli task works by calling this method with a task name and a class to execute it
    }
}
```

At the moment this service is not auto loaded by the framework ,you'll need to add add a hook in your hookService to fire it:

```
add_action('init', array($this->_manager->getService(AbstractService::$COMMANDSERVICENAME), 'registerCommands'));
```
We'll probably abstract that someday though.
