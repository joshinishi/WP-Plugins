<?php
/**
 * Plugin Name:       Custom CSS Inoculate
 * Plugin URI:        https://wordpress.org/plugins/custom-css-inoculate
 * Description:       Add custom CSS styles to your site without modifying the theme files.
 *  This can be useful for making small design twitch.   
 * Version:           1.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Nishita Joshi
 * Author URI:        https://www.linkedin.com/in/nishita-joshi-1bb5b6217?utm_source=share&utm_campaign=share_via&utm_content=profile&utm_medium=android_app
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       custom-css-inoculate
 */

if (!defined('ABSPATH')) {
    header("Location: /");
    die("");
}

function custom_css_inoculate_menu() {
    add_menu_page(
        __( 'Custom CSS Inoculate Settings' ),
        __( 'Custom CSS Inoculate' ),
        'manage_options',
        'custom-css-inoculate',
        'custom_css_inoculate_page',
        'dashicons-art',
        3
    );
}
add_action('admin_menu', 'custom_css_inoculate_menu');

function custom_css_inoculate_page() {
    ?>
    <div class="wrap">
        <h2>Custom CSS Inoculate</h2>
        <form method="post" action="options.php">
            <?php settings_fields('custom-css-inoculate'); ?>
            <?php do_settings_sections('custom-css-inoculate'); ?>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

function custom_css_inoculate_settings_init() {
    register_setting('custom-css-inoculate', 'custom_css_inoculate_settings');

    add_settings_section(
        'custom_css_inoculate_section',
        esc_html( 'Custom CSS Settings' ),
        'custom_css_inoculate_section_callback',
        'custom-css-inoculate'
    );

    add_settings_field(
        'custom_css',
        esc_html( 'Custom CSS' ),
        'custom_css_callback',
        'custom-css-inoculate',
        'custom_css_inoculate_section'
    );
}
add_action('admin_init', 'custom_css_inoculate_settings_init');

function custom_css_inoculate_section_callback() {
    echo esc_html( 'Enter your custom CSS here:' );
}

function custom_css_callback() {
    $options = get_option('custom_css_inoculate_settings');
    $custom_css = isset($options['custom_css']) ? $options['custom_css'] : '';
    echo "<textarea id='custom_css' name='custom_css_inoculate_settings[custom_css]' rows='10' cols='50'>" . esc_textarea( $custom_css ) . "</textarea>";
}

function custom_css_inoculate_enqueue_styles() {
    $options = get_option('custom_css_inoculate_settings');
    $custom_css = isset($options['custom_css']) ? $options['custom_css'] : '';

    echo '<style type="text/css">';
    echo esc_html( $custom_css );
    echo '</style>';
}
add_action('wp_head', 'custom_css_inoculate_enqueue_styles');
