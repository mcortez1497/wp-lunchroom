<?php

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

include_once(plugin_dir_path(__FILE__) . 'helpers/class-whp-widget.php');

class WP_Discord_Follow_Widget extends WPH_Widget
{
    public function __construct()
    {
        $args = [
            'label' => __('Discord Widget', 'wp-discord-widget'),
            'description' => __('Show who is online for your server.', 'wp-discord-widget'),
            'fields' => [
                // ID Field
                [
                    'name' => __('Server ID', 'wp-discord-widget'),
                    'desc' => __('Go to Server Settings -> Widget to get your Server ID.', 'wp-discord-widget'),
                    'id' => 'wp-discord-server-id',
                    'type' => 'text',
                    'class' => 'widefat',
                    'std' => __('Discord Server', 'wp-discord-widgets'),
                    'validate' => 'numeric',
                    'filter' => 'strip_tags|esc_attr'
                ],
                // Theme Field
                [
                    'name' => __('Color Theme', 'wp-discord-widget'),
                    'desc' => __('Select Color Theme', 'wp-discord-widget'),
                    'id' => 'wp-discord-theme',
                    'type' => 'select',
                    'class' => 'widefat',
                    'fields' => [
                        [
                            'name' => __('White', 'wp-discord-widget'),
                            'value' => 'wpd-white'
                        ],
                        [
                            'name' => __('Dark', 'wp-discord-widget'),
                            'value' => 'wpd-dark'
                        ],
                        [
                            'name' => __('Gray', 'wp-discord-widget'),
                            'value' => 'wpd-gray'
                        ],
                    ],
                    'filter' => 'strip_tags|esc_attr'
                ],
                // Member Count Field
                [
                    'name' => __('Member Count', 'wp-discord-widget'),
                    'desc' => __('How Many Online Members would you like widget to display?', 'wp-discord-widget'),
                    'id' => 'wp-discord-member-count',
                    'type' => 'select',
                    'class' => 'widefat',
                    'fields' => [
                        [
                            'name' => __('None', 'wp-discord-widget'),
                            'value' => '0'
                        ],
                        [
                            'name' => __('3', 'wp-discord-widget'),
                            'value' => '3'
                        ],
                        [
                            'name' => __('6', 'wp-discord-widget'),
                            'value' => '6'
                        ],
                        [
                            'name' => __('9', 'wp-discord-widget'),
                            'value' => '9'
                        ],
                        [
                            'name' => __('12', 'wp-discord-widget'),
                            'value' => '12'
                        ],
                        [
                            'name' => __('All', 'wp-discord-widget'),
                            'value' => '-1'
                        ],
                    ],
                    'filter' => 'strip_tags|esc_attr'
                ]
            ]
        ];

        $this->create_widget($args);
    }

    public static function filter_bots($members)
    {
        $real_users = [];

        foreach ($members as $member) {
            //Not Bots!
            if ((isset($member->bot) && $member->bot == true) == false) {
                $real_users[] = $member;
            }
        }

        return $real_users;
    }

    public static function member_shuffle($members)
    {
        $shuffled_members = [];

        $keys = array_keys($members);
        shuffle($keys);

        foreach ($keys as $key) {
            $shuffled_members[$key] = $members[$key];
        }

        return $shuffled_members;
    }

    public static function render_widget($widget_object, $theme_class = 'wpd-white', $member_count = 3)
    {
        $server_title = $widget_object->name;
        $users_online = self::filter_bots($widget_object->members);
        $invite_url = $widget_object->instant_invite;
        $img_path = plugin_dir_url(__FILE__) . '../public/img';

        $output = '<div id="wp-discord" class="' . $theme_class . '">' . PHP_EOL;
        $output .= '<div class="wpd-head">' . PHP_EOL;
        $output .= '<img src="' . $img_path . '/icon.png" class="wpd-icon">' . PHP_EOL;
        $output .= '<img src="' . $img_path . '/discord.png" class="wpd-name">' . PHP_EOL;
        $output .= '<h3>' . $server_title . '</h3>' . PHP_EOL;
        $output .= '</div>' . PHP_EOL;
        $output .= '<div class="wpd-info">' . PHP_EOL;
        $output .= '<span><strong>' . count($users_online) . '</strong> User(s) Online</span>' . PHP_EOL;

        if (!empty($invite_url)) {
            $output .= '<a href="' . $invite_url . '" target="_blank">Join Server</a>' . PHP_EOL;
        }

        if ($member_count != 0 && count($users_online) > 0) {
            // $users_online = self::member_shuffle($users_online);
            $user_counter = 0;
            $output .= '<ul class="wpd-users">';

            foreach ($users_online as $user) {
                // $user_counter++;
                $output .= '<li><img src="' . str_replace('https://', '//', $user->avatar_url) . '"><strong>' . $user->username . '</strong><span class="wpd-status ' . $user->status . '"></span></li>';

                if ($member_count != -1 && $user_counter >= $member_count) {
                    break;
                }
            }

            $output .= '</ul>';
        }

        $output .= '<div class="lr-discord-toggle">Show All <i class="fa fa-chevron-down"></i></div>' . PHP_EOL;

        $output .= '</div>' . PHP_EOL;
        $output .= '</div>' . PHP_EOL;

        return $output;
    }

    // Output function
    public function widget($args, $instance)
    {

        $server_id = $instance['wp-discord-server-id'];
        $theme_class = $instance['wp-discord-theme'];
        $widget_object = self::widget_feed($server_id);
        $member_count = 0;

        if (isset($instance['wp-discord-member-count'])) {
            $member_count = $instance['wp-discord-member-count'];
        } elseif (isset($instance['wp-discord-show-members']) && $instance['wp-discord-show-members'] == true) {
            //legacy
            $member_count = 3;
        }

        if (is_object($widget_object) && !empty($widget_object)) {
            $output = self::render_widget($widget_object, $theme_class, $member_count);
            echo $output;
        }
    }

    public static function widget_feed($server_id)
    {
        $url = 'https://discordapp.com/api/servers/' . trim($server_id) . '/widget.json';

        // create curl resource
        $ch = curl_init();

        // set url
        curl_setopt($ch, CURLOPT_URL, $url);

        //return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // $output contains the output string
        $output = curl_exec($ch);

        // close curl resource to free up system resources
        curl_close($ch);

        return json_decode($output);
    }
}
