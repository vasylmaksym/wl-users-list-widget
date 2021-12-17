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
    protected $roles;
    protected $default_settings;

    function __construct()
    {
        global $wp_roles;

        parent::__construct(
            "users_list_widget",
            __("Users list", ULW_TEXTDOMAIN),
            ["description" => __("Users list with comment activity", ULW_TEXTDOMAIN),]
        );

        $this->default_settings = [
            "users_count" => 1,
            "user_has_role" => [],
            "show_comments_count" => "",
            "show_users_without_comments" => "",
        ];

        $this->roles = $wp_roles->roles;
    }

    public function widget($args, $instance)
    {
        $args = [
            "fields" => ["display_name"],
            "number" => $instance["users_count"],
            "role__in" => $instance["user_has_role"],
        ];

        $users = get_users($args);

        if ($instance["show_users_without_comments"] !== "on") {
            $users = array_filter($users, function ($u) {
                return $u->comments_count > 0;
            });
        }

        $keys = array_column($users, "comments_count");
        array_multisort($keys, SORT_DESC, $users);
?>
        <div>
            <h2><?= __("Users list", ULW_TEXTDOMAIN); ?></h2>
            <?php if ($instance["show_comments_count"] !== "on") : ?>
                <ul>
                    <?php foreach ($users as $user) : ?>
                        <li><?= $user->display_name; ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php else : ?>
                <ul>
                    <?php foreach ($users as $user) : ?>
                        <li><?= "{$user->display_name}({$user->comments_count})"; ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    <?php
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
            <input class="widefat" id="<?= $this->get_field_id("users_count"); ?>" name="<?= $this->get_field_name("users_count"); ?>" type="number" min="1" value="<?= esc_attr($users_count); ?>" />
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

        <!--user_has_role -->
        <p>
            <label for="<?= $this->get_field_id("user_has_role"); ?>"><?= __("User has role", ULW_TEXTDOMAIN); ?></label>
            <select multiple="multiple" name="<?= $this->get_field_name("user_has_role[]"); ?>" id="<?= $this->get_field_id("user_has_role"); ?>">
                <?php foreach ($this->roles as $role) : ?>
                    <option value="<?= $role["name"]; ?>" <?php selected(array_search($role["name"], $user_has_role) !== false); ?>><?= $role["name"]; ?></option>
                <?php endforeach; ?>
            </select>
        </p>
<?php
    }

    public function update($new_instance, $old_instance)
    {
        return $new_instance;
    }
}
