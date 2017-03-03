<?php
/**
 * Plugin Name: IDer Login
 * Plugin URI: https://oid.ider.com/core
 * Version: 0.8.0
 * Description: Provides Single Sign On integration with IDer Identity Server using OpenID specs.
 * Author: Davide Lattanzio
 * Author URI: https://oid.ider.com/core
 * License: GPL2
 *
 * This program is GLP but; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of.
 */


defined('ABSPATH') or die('No script kiddies please!');

if (!defined('IDER_PLUGIN_FILE')) {
    define('IDER_PLUGIN_FILE', __FILE__);
}

if (!defined('IDER_PLUGIN_DIR')) {
    define('IDER_PLUGIN_DIR', trailingslashit(plugin_dir_path(__FILE__)));
}

if (!defined('IDER_PLUGIN_URL')) {
    define('IDER_PLUGIN_URL', trailingslashit(plugin_dir_url(__FILE__)));
}

if (!defined('IDER_CLIENT_VERSION')) {
    define('IDER_CLIENT_VERSION', '0.8.0');
}

if (!defined('IDER_SITE_DOMAIN')) {
    define('IDER_SITE_DOMAIN', implode(".", array_reverse(array_slice(array_reverse(explode(".", $_SERVER['HTTP_HOST'])), 0, 2))));
}

// Enable shortcodes in text widgets
add_filter('widget_text','do_shortcode');

// require the main lib
require_once IDER_PLUGIN_DIR . '/vendor/autoload.php';
require_once IDER_PLUGIN_DIR . '/includes/IDER_Server.php';

// bootstrap the plugin
IDER_Server::instance();


/* If you need customization (ie: field map) you can write below */
add_filter('ider_fields_map', function($fields){

    $fields['ider_sub'] = 'sub';
    $fields['first_name'] = 'given_name';
    $fields['last_name'] = 'family_name';
    $fields['nickname'] = 'nickname';
    $fields['email'] = 'email';
    $fields['display_name'] = 'preferred_user_name';
    $fields['url'] = 'website';
    $fields['description'] = 'note';

    $fields['billing_address_1'] = 'address_company_street_address';
    $fields['billing_address_2'] = '';
    $fields['billing_city'] = 'address_company_locality';
    $fields['billing_state'] = 'address_company_region';
    $fields['billing_postcode'] = 'address_company_postal_code';
    $fields['billing_country'] = 'address_company_country';

    $fields['shipping_address_1'] = 'address_shipping_street_address';
    $fields['shipping_address_2'] = '';
    $fields['shipping_city'] = 'address_shipping_locality';
    $fields['shipping_state'] = 'address_shipping_region';
    $fields['shipping_postcode'] = 'address_shipping_postal_code';
    $fields['shipping_country'] = 'address_shipping_country';

    // tmp
    $fields['billing_first_name'] = 'given_name';
    $fields['billing_last_name'] = 'family_name';
    $fields['billing_company'] = 'company_name';
    $fields['billing_phone'] = '';
    $fields['billing_email'] = 'company_email';

    $fields['shipping_first_name'] = 'given_name';
    $fields['shipping_last_name'] = 'family_name';
    $fields['shipping_company'] = '';
    $fields['shipping_phone'] = 'phone_number';
    $fields['shipping_email'] = 'email';
    // --

    return $fields;
});




