<?php

namespace Inc;

defined('ABSPATH') || exit;

/**
 * Main ULW_Widget Class.
 *
 * @class ULW_Widget
 */

class ULW_Widget extends \WP_Widget
{
    protected $default_settings = [
        "users_count" => -1,
        "show_comments_count" => "on",
        "show_users_without_comments" => "on",
    ];

    function __construct()
    {
        parent::__construct(
            "users_list_widget",
            __("Users list", ULW_TEXTDOMAIN),
            ["description" => __("Users list with comment activity", ULW_TEXTDOMAIN),]
        );
    }

    // Creating widget front-end

    public function widget($args, $instance)
    {
        $title = apply_filters('widget_title', $instance['title']);

        // before and after widget arguments are defined by themes
        echo $args['before_widget'];
        if (!empty($title))
            echo $args['before_title'] . $title . $args['after_title'];

        // This is where you run the code and display the output
        echo __('Hello, World!', 'wpb_widget_domain');
        echo $args['after_widget'];
    }

    public function form($instance)
    {
        foreach ($this->default_settings as $key => $value) {
            if (isset($instance[$key])) {
                $$key = $instance[$key];
            } else {
                $$key = $value;
            }
        }

?>
        <!-- users_count -->
        <p>
            <label for="<?= $this->get_field_id("users_count"); ?>"><?= __("Users count", ULW_TEXTDOMAIN); ?></label>
            <input class="widefat" id="<?= $this->get_field_id("users_count"); ?>" name="<?= $this->get_field_id("users_count"); ?>" type="number" min="-1" value="<?= esc_attr($users_count); ?>" />
        </p>

        <!-- show_comments_count -->
        <p>
            <label for="<?= $this->get_field_id("show_comments_count"); ?>"><?= __("Show comments count", ULW_TEXTDOMAIN) ?></label>
            <input class="checkbox" type="checkbox" <?php checked($show_comments_count, "on"); ?> id="<?= $this->get_field_id("show_comments_count"); ?>" name="<?= $this->get_field_name("show_comments_count"); ?>" />
        </p>

        <!--show_users_without_comments -->
        <p>
            <label for="<?= $this->get_field_id("show_users_without_comments"); ?>"><?= __("Show users without comments", ULW_TEXTDOMAIN) ?></label>
            <input class="checkbox" type="checkbox" <?php checked($show_users_without_comments, "on"); ?> id="<?= $this->get_field_id("show_users_without_comments"); ?>" name="<?= $this->get_field_name("show_users_without_comments"); ?>" />
        </p>
<?php
    }

    public function update($new_instance, $old_instance)
    {
        $instance = [];
        $instance["show_comments_count"] = isset($new_instance["show_comments_count"]) ? "on" : "off";
        $instance["show_users_without_comments"] = isset($new_instance["show_users_without_comments"]) ? "on" : "off";
        return $instance;
    }
}
