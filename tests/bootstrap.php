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
    // johnpbloch/wordpress (require-dev) installs the core in ../wordpress
    $wordpress_dir = dirname(__DIR__).'/wordpress';
}
if(!is_file($wordpress_dir.'/wp-includes/load.php')){
    fwrite(STDERR, "WordPress not found in $wordpress_dir, run composer install first.\n");
    exit(1);
}
// WordPress core files require their siblings via ABSPATH . WPINC
if(!defined('ABSPATH')){
    define('ABSPATH', $wordpress_dir.'/');
}

include __DIR__.'/noop.php';

include $wordpress_dir.'/wp-includes/load.php';
include $wordpress_dir.'/wp-includes/compat.php';
include $wordpress_dir.'/wp-includes/utf8.php';
include $wordpress_dir.'/wp-includes/functions.php';
include $wordpress_dir.'/wp-includes/plugin.php';
include $wordpress_dir.'/wp-includes/pomo/translations.php';
include $wordpress_dir.'/wp-includes/l10n.php';
include $wordpress_dir.'/wp-includes/formatting.php';
include $wordpress_dir.'/wp-includes/class-wp-rewrite.php';
include $wordpress_dir.'/wp-includes/rewrite.php';
include $wordpress_dir.'/wp-includes/class-wp.php';
// kses relies on the HTML API since WordPress 6.x/7.x
foreach ([
    'class-wp-token-map',
    'html-api/html5-named-character-references',
    'html-api/class-wp-html-attribute-token',
    'html-api/class-wp-html-span',
    'html-api/class-wp-html-doctype-info',
    'html-api/class-wp-html-text-replacement',
    'html-api/class-wp-html-decoder',
    'html-api/class-wp-html-tag-processor',
] as $wp_file) {
    include $wordpress_dir.'/wp-includes/'.$wp_file.'.php';
}
include $wordpress_dir.'/wp-includes/kses.php';

add_filter('pre_option_blog_charset', function(){
    return 'UTF-8';
});

$loader = \WonderWp\Bundle\Loader::getInstance();
