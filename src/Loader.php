<?php

namespace WonderWp\Bundle;


use WonderWp\Component\Asset\Asset;
use WonderWp\Component\Asset\AssetManager;
use WonderWp\Component\Asset\DirectAssetEnqueuer;
use WonderWp\Component\Asset\JsonAssetExporter;
use WonderWp\Component\Cache\TransientCache;
use WonderWp\Component\DependencyInjection\Container;
use WonderWp\Component\DependencyInjection\SingletonInterface;
use WonderWp\Component\DependencyInjection\SingletonTrait;
use WonderWp\Component\Form\Form;
use WonderWp\Component\Form\FormValidator;
use WonderWp\Component\Form\FormView;
use WonderWp\Component\Form\FormViewReadOnly;
use WonderWp\Component\Hook\HookManager;
use WonderWp\Component\Mailing\WpMailer;
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
        $container['wwp.asset.manager']       = function () {
            return AssetManager::getInstance();
        };
        $container['wwp.asset.exporterClass'] = JsonAssetExporter::class;
        $container['wwp.asset.assetClass']    = Asset::class;
        $container['wwp.asset.manifest.path'] = $container['path_root'] . '/assets.json';
        $container['wwp.asset.enqueuer']      = function ($container) {
            return new DirectAssetEnqueuer();
        };
        $container['wwp.asset.folder.prefix'] = './';
        $container['wwp.asset.folder.dest']   = '';
        $container['wwp.asset.folder.path']   = str_replace(trim(get_bloginfo('url'),'/'), '', str_replace(trim(network_site_url(),'/'), '', get_stylesheet_directory_uri()));

        //Emails
        $container['wwp.mailing.mailer'] = $container->factory(function () {
            return new WpMailer();
        });

        //Cache
        $container['wwp.cache.cache'] = function () {
            return new TransientCache();
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

        //Hook Manager
        $container['wwp.hook.manager'] = function(){
            return new HookManager();
        };

        //Forms
        $container['wwp.form.form']              = $container->factory(function () {
            return new Form();
        });
        $container['wwp.form.view']          = $container->factory(function () {
            return new FormView();
        });
        $container['wwp.form.view.readOnly'] = $container->factory(function () {
            return new FormViewReadOnly();
        });
        $container['wwp.form.validator']     = $container->factory(function () {
            return new FormValidator();
        });

        do_action('wonderwp.loader.load');

        /**
         * Make container available
         */
        Container::setInstance($container);
    }
}
