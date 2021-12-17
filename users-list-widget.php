<?php

/**
 * Plugin Name: Users List Widget
 * Plugin URI: https://github.com/vasylmaksym/wl-users-list-widget
 * Description: A plugin to create users list widget.
 * Version: 1.0.0
 * Author: Vasyl
 * Author URI: 
 * Text Domain: users-list-features
 * Domain Path: /languages
 *
 * @package UsersListWidget
 */

defined("ABSPATH") || exit;

if (!defined("ULW_PLUGIN_FILE")) {
    define("ULW_PLUGIN_FILE", __FILE__);
}

if (!defined("ULW_TEXTDOMAIN")) {
    define("ULW_TEXTDOMAIN", "users-list-widget");
}

require __DIR__ . "/autoload.php";

/**
 * Returns the main instance of ULW.
 *
 * @since  1.0
 * @return UsersListWidget
 */
function ULW()
{
    return Inc\UsersListWidget::instance();
}

$GLOBALS["users-list-widget"] = ULW();
