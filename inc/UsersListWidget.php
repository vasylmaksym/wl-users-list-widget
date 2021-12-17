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
        add_action("pre_user_query", [$this, "ulw_pre_user_query"]);
    }

    function ulw_load_widget()
    {
        register_widget(ULW_Widget::class);
    }

    function ulw_pre_user_query($user_query)
    {
        global $wpdb;

        $user_query->query_fields .= ", (select count(1) from {$wpdb->comments} c where ID = c.user_id and c.comment_approved = 1) comments_count";
    }
}
