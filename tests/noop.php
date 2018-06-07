<?php

if(!defined('ABSPATH')){
    define('ABSPATH','');
}

/**
 * @ignore
 */
function get_bloginfo() {}

/**
 * @ignore
 */
function site_url() {}

/**
 * @ignore
 */
function admin_url() {}

/**
 * @ignore
 */
function home_url() {}

/**
 * @ignore
 */
function includes_url() {}

/**
 * @ignore
 */
function network_site_url() {}

/**
 * @ignore
 */
function get_stylesheet_directory_uri() {}

if ( ! function_exists( 'json_encode' ) ) :
    /**
     * @ignore
     */
    function json_encode() {}
endif;

function get_file( $path ) {

    if ( function_exists('realpath') ) {
        $path = realpath( $path );
    }

    if ( ! $path || ! @is_file( $path ) ) {
        return '';
    }

    return @file_get_contents( $path );
}
