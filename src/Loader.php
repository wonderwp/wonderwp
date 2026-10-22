<?php

namespace WonderWp\Bundle;

use Composer\InstalledVersions;
use WonderWp\Component\DependencyInjection\Container;
use WonderWp\Component\DependencyInjection\SingletonInterface;
use WonderWp\Component\DependencyInjection\SingletonTrait;

class Loader implements SingletonInterface
{
    use SingletonTrait {
        SingletonTrait::buildInstance as createInstance;
    }

    /** @inheritdoc */
    public static function buildInstance()
    {
        $instance = static::createInstance();

        $instance->load();

        return $instance;
    }

    /**
     * init the framework, loads the config, the autoloader, error handling...
     */
    public function load()
    {
        // Create DI container
        $container = Container::getInstance();

        /**
         * Define Paths
         */
        // Project root, where composer's vendor dir lives: ABSPATH . '../../' on Bedrock, ABSPATH on a classic install
        $rootPackage                                      = class_exists(InstalledVersions::class) ? InstalledVersions::getRootPackage() : [];
        $container['path_root']                           = !empty($rootPackage['install_path']) ? trailingslashit(realpath($rootPackage['install_path'])) : ABSPATH . '../../'; // root
        $container['path_framework_root']                 = __DIR__; // Framework root
        $container['wwp.path.defaultlanguagedir.plugins'] = trailingslashit(WP_LANG_DIR) . DIRECTORY_SEPARATOR . 'plugins' . DIRECTORY_SEPARATOR;
        $container['wwp.path.templates.frags']            = $container['path_root'] . '/vendor/wonderwp/template/src/frags/';

        /**
         * Define Services
         */

        // Autoloader
        /**
         * @param Container $container
         *
         * @return mixed
         */
        $container['wwp.autoLoader'] = function (Container $container) {
            return require($container['path_root'] . 'vendor/autoload.php');
        };

        //FileSystem
        $container['wwp.fileSystem'] = function () {
            global $wp_filesystem;
            if (empty($wp_filesystem)) {
                require_once(ABSPATH . '/wp-admin/includes/file.php');
                WP_Filesystem();
            }

            return $wp_filesystem;
        };

        do_action('wonderwp.loader.load', $container);

        /**
         * Make container available
         */
        Container::setInstance($container);
    }
}
