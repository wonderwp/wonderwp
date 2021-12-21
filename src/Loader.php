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
use WonderWp\Component\Logging\DirectOutputLogger;
use WonderWp\Component\Mailing\WpMailer;
use WonderWp\Component\Routing\Router\Router;
use WonderWp\Component\Search\Engine\SearchEngine;
use WonderWp\Component\Search\Renderer\SearchResultSetsRenderer;
use WonderWp\Component\Search\Result\SearchResult;
use WonderWp\Component\Search\ResultSet\SearchResultSet;
use WonderWp\Component\Template\Views\AdminVue;
use WonderWp\Component\Template\Views\EditAdminView;
use WonderWp\Component\Template\Views\ListAdminView;
use WonderWp\Component\Template\Views\OptionsAdminView;

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

        $container['wwp.asset.folder.prefix'] = './';
        $container['wwp.asset.folder.dest']   = '';
        $container['wwp.asset.folder.path']   = str_replace(trim(get_bloginfo('url'), '/'), '', str_replace(trim(network_site_url(), '/'), '', get_stylesheet_directory_uri()));

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

        $container['wwp.asset.enqueuer']      = function ($container) {
            $publicPath = ROOT_DIR . str_replace('.', '', $container['wwp.asset.folder.prefix']);
            return new DirectAssetEnqueuer($container['wwp.asset.manager'], $container['wwp.fileSystem'], $publicPath);
        };

        //Hook Manager
        $container['wwp.hook.manager'] = function () {
            return new HookManager();
        };

        //Forms
        $container['wwp.form.form']          = $container->factory(function () {
            return new Form();
        });
        $container['wwp.form.view.readOnly'] = $container->factory(function () {
            return new FormViewReadOnly();
        });
        $container['wwp.form.validator']     = $container->factory(function () {
            return new FormValidator();
        });
        $container['wwp.form.view']          = $container->factory(function () use ($container) {
            return new FormView(
                $container['wwp.form.validator']
            );
        });

        //Logs
        $container['wwp.log.log'] = function () {
            return new DirectOutputLogger();
        };

        //Search
        $container['wwp.search.engine']   = function () {
            return new SearchEngine();
        };
        $container['wwp.search.renderer'] = function () {
            return new SearchResultSetsRenderer();
        };
        $container['wwp.search.result']   = $container->factory(function () {
            return new SearchResult();
        });
        $container['wwp.search.set']      = $container->factory(function () {
            return new SearchResultSet();
        });

        //Views
        $container['wwp.views.baseAdmin']    = function () {
            return new AdminVue();
        };
        $container['wwp.views.listAdmin']    = function () {
            return new ListAdminView();
        };
        $container['wwp.views.editAdmin']    = function () {
            return new EditAdminView();
        };
        $container['wwp.views.optionsAdmin'] = function () {
            return new OptionsAdminView();
        };

        do_action('wonderwp.loader.load');

        /**
         * Make container available
         */
        Container::setInstance($container);
    }
}
