
# The Main Plugin File

Here's an example of a plugin main file that we'll comment right after:

```
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://digital.wonderful.fr
 * @since             1.0.0
 * @package           WonderWp
 *
 * @wordpress-plugin
 * Plugin Name:       wwp Actu
 * Plugin URI:        http://digital.wonderful.fr/wonderwp/wwp-actu
 * Description:       Module de gestion d'actualités
 * Version:           1.0.0
 * Author:            WonderfulPlugin
 * Author URI:        http://digital.wonderful.fr
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wwp-actu
 * Domain Path:       /languages
 */

use WonderWp\Framework\AbstractPlugin\ActivatorInterface;
use WonderWp\Framework\AbstractPlugin\DeactivatorInterface;
use WonderWp\Framework\AbstractPlugin\ManagerInterface;
use WonderWp\Framework\DependencyInjection\Container;
use WonderWp\Framework\Service\ServiceInterface;
use WonderWp\Plugin\Actu\ActuManager;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define('WWP_PLUGIN_ACTU_NAME','wwp-actu');
define('WWP_PLUGIN_ACTU_VERSION','1.0.0');
define('WWP_ACTU_TEXTDOMAIN','wwp-actu');
if (!defined('WWP_PLUGIN_ACTU_MANAGER')) { //So you can change this by an override in your child theme for example
    define('WWP_PLUGIN_ACTU_MANAGER', ActuManager::class);
}

/**
 * Register activation hook
 * The code that runs during plugin activation.
 * This action is documented in includes/ErActivator.php
 */
register_activation_hook(__FILE__, function () {
    $activator = Container::getInstance()->offsetGet(WWP_PLUGIN_ACTU_NAME . '.Manager')->getService(ServiceInterface::ACTIVATOR_NAME);

    if ($activator instanceof ActivatorInterface) {
        $activator->activate();
    }
});

/**
 * Register deactivation hook
 * The code that runs during plugin deactivation.
 * This action is documented in includes/MembreDeactivator.php
 */
register_deactivation_hook(__FILE__, function () {
    $deactivator = Container::getInstance()->offsetExists(WWP_PLUGIN_ACTU_NAME . '.Manager') ? Container::getInstance()->offsetGet(WWP_PLUGIN_MEMBRE_NAME . '.Manager')->getService(ServiceInterface::DEACTIVATOR_NAME) : null;

    if ($deactivator instanceof DeactivatorInterface) {
        $deactivator->deactivate();
    }
});

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 * This class is called the manager
 * Instanciate here because it handles autoloading
 */
$plugin = WWP_PLUGIN_ACTU_MANAGER;
$plugin = new $plugin(WWP_PLUGIN_ACTU_NAME, WWP_PLUGIN_ACTU_VERSION);

if (!$plugin instanceof ManagerInterface) {
    throw new \BadMethodCallException(sprintf('Invalid manager class for %s plugin : %s', WWP_PLUGIN_ACTU_NAME, WWP_PLUGIN_ACTU_MANAGER));
}

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
$plugin->run();
```

Ideally, this file should do a few things:

-  Define a few useful constants (plugin name, version and textdomain)
-  Register an activation hook
-  Register a deactivation hook
-  Require and instanciate the plugin manager

The rest of the plugin mechanic is now handled by the manager
