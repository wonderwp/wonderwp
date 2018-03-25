<?php

namespace WonderWp\Bundle;


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
        $container['path_root']                           = ABSPATH . '../../'; // root
        $container['path_framework_root']                 = __DIR__; // Framework root
        $container['wwp.path.defaultlanguagedir.plugins'] = trailingslashit(WP_LANG_DIR) . DIRECTORY_SEPARATOR . 'plugins' . DIRECTORY_SEPARATOR;

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

        do_action('wonderwp.loader.load');

        /**
         * Make container available
         */
        Container::setInstance($container);
    }
}
