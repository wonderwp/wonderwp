<?php

namespace WonderWp\Bundle;


use WonderWp\Component\Asset\Asset;
use WonderWp\Component\Asset\AssetManager;
use WonderWp\Component\Asset\DirectAssetEnqueuer;
use WonderWp\Component\Asset\JsonAssetEnqueuer;
use WonderWp\Component\Asset\JsonAssetExporter;
use WonderWp\Component\DependencyInjection\Container;
use WonderWp\Component\DependencyInjection\SingletonInterface;
use WonderWp\Component\DependencyInjection\SingletonTrait;
use WonderWp\Component\Routing\Router\Router;

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

        //Routes
        $container['wwp.routes.router'] = function () {
            return new Router();
        };
        //Assets
        $container['wwp.assets.manager']       = function () {
            return AssetManager::getInstance();
        };
        $container['wwp.assets.exporterClass'] = JsonAssetExporter::class;
        $container['wwp.assets.assetClass']    = Asset::class;
        $container['wwp.assets.manifest.path'] = $container['path_root'] . '/assets.json';
        $container['wwp.assets.enqueuer']      = function ($container) {
            return new DirectAssetEnqueuer();
        };
        $container['wwp.assets.folder.prefix'] = './';
        $container['wwp.assets.folder.dest']   = '';
        $container['wwp.assets.folder.path']   = str_replace(trim(get_bloginfo('url'),'/'), '', str_replace(trim(network_site_url(),'/'), '', get_stylesheet_directory_uri()));


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
