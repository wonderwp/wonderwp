<?php

define('WP_USE_THEMES', false);
$root_dir = dirname(__DIR__);

/** @var string Document Root */
$webroot_dir = $root_dir . '/web';
define('CONTENT_DIR', '/app');
define('WP_CONTENT_DIR', $webroot_dir . CONTENT_DIR);
define('WP_LANG_DIR', WP_CONTENT_DIR . '/languages');
define( 'WP_PLUGIN_DIR', __DIR__ . '/my-plugins' );
define( 'WPINC', 'wp-includes' );
if(!isset($wordpress_dir)){
    $wordpress_dir = dirname(__DIR__).'/wordpress';
}

include __DIR__.'/noop.php';

include $wordpress_dir.'/wp-includes/load.php';
include $wordpress_dir.'/wp-includes/functions.php';
include $wordpress_dir.'/wp-includes/plugin.php';
include $wordpress_dir.'/wp-includes/pomo/translations.php';
include $wordpress_dir.'/wp-includes/l10n.php';
include $wordpress_dir.'/wp-includes/formatting.php';
include $wordpress_dir.'/wp-includes/class-wp-rewrite.php';
include $wordpress_dir.'/wp-includes/rewrite.php';
include $wordpress_dir.'/wp-includes/class-wp.php';
include $wordpress_dir.'/wp-includes/kses.php';

add_filter('pre_option_blog_charset', function(){
    return 'UTF-8';
});

$loader = \WonderWp\Bundle\Loader::getInstance();
