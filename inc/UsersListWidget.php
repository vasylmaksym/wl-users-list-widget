<?php

/**
 * UsersListWidget setup
 *
 * @package UsersListWidget
 * @since 1.0.0
 */

namespace Inc;

defined('ABSPATH') || exit;

/**
 * Main UsersListWidget Class.
 *
 * @class UsersListWidget
 */
final class UsersListWidget
{
    /**
     * UsersListWidget version.
     *
     * @var string
     */
    public $version = '1.0.0';

    /**
     * The single instance of the class.
     *
     * @var UsersListWidget
     * @since 1.0
     */
    protected static $_instance = null;

    /**
     * Main UsersListWidget Instance.
     *
     * Ensures only one instance of UsersListWidget is loaded or can be loaded.
     *
     * @since 1.1
     * @static
     * @see ULW()
     * @return UsersListWidget - Main instance.
     */
    public static function instance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * UsersListWidget Constructor.
     */
    public function __construct()
    {
        $this->init_hooks();
        $this->init_actions();
    }

    /**
     * Hook into actions and filters.
     *
     * @since 1.0
     */
    private function init_hooks()
    {
        add_action("widgets_init", [$this, "ulw_load_widget"]);
    }

    private function init_actions()
    {
    }

    function ulw_load_widget()
    {
        register_widget(ULW_Widget::class);
    }
}
