# Installation

## Prepare your WordPress install for Composer

WonderWp relies on composer to run properly. We'll therefore make sure that our WordPress install has a correct composer.json file that will hold the composer configuration.

If you don't have a composer.json file already, you could create one with the following content :

```
{
    "extra": {
        "installer-paths": {
            "wp-content/mu-plugins/{$name}/": ["type:wordpress-muplugin"],
            "wp-content/plugins/{$name}/": ["type:wordpress-plugin"],
            "wp-content/themes/{$name}/": ["type:wordpress-theme"]
        },
        "wordpress-install-dir": "/"
    }
}
``` 

That will tell composer where your WordPress instance is located, and where to install the packages it gets from its packagist mirror.

## Prepare your WordPress install for must-use plugins (muplugins)

muplugins are some special kinds of plugins that can't be deactivated. If your WordPress install doesn't support them yet, you can activate them like so : https://codex.wordpress.org/Must_Use_Plugins 

## Require WonderWp

This is a composer package, you can get it like this:

```
composer require wonderwp/wonderwp
```

## Initialisation

To be initialized, the WonderWp Framework loader should be called.
By default, WonderWp does so automatically via ist autoloader must use plugin.

If you haven't activated must use plugins, you can still manually call the composer autoloader plus the WonderWp Framework Loader by yourself.

```
//Try to load composer autoload
$composerAutoLoaderFile = ABSPATH.'/vendor/autoload.php';
if(file_exists($composerAutoLoaderFile)){
    $loader = include_once($composerAutoLoaderFile);
}

\WonderWp\Bundle\Loader::getInstance();
```

WonderWp is now activated and should be ready to help you get started on your own plugin code.
