<?php
/*
 * Plugin Name:       CPT Data Management
 * Description:       Plugin Display Custom Post Type Data which allow users to add data into Custom Post Type.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Nishita Joshi
 * Author URI:        https://www.linkedin.com/in/nishita-joshi-1bb5b6217
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://example.com/my-plugin/
 * Text Domain:       cpt-data-mangement
 * Domain Path:       /languages
 */

 /*
{Plugin Name} is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

{Plugin Name} is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with {Plugin Name}. If not, see {URI to Plugin License}.
*/


/** Create Table of CPT Data on Plugin Activation */
function edata_plugin_activation() {
    // Register the custom post type
    register_post_type('employee', array(
        'labels' => array(
            'name' => 'Employees',
            'singular_name' => 'Employee',
        ),
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor', 'thumbnail'),
    ));

    // Register the taxonomy
    register_taxonomy('employee_type', 'employee', array(
        'labels' => array(
            'name' => 'Employee Types',
            'singular_name' => 'Employee Type',
        ),
        'hierarchical' => true,
        'show_admin_column' => true,
    ));
}
register_activation_hook(__FILE__, 'edata_plugin_activation');


/** Delete Table of CPT Data on Plugin DeActivation */
function edata_plugin_deactivation() {
    
    // Unregister custom post type "Employee Data"
    unregister_post_type('employee');
}
register_deactivation_hook(__FILE__, 'edata_plugin_deactivation');


/** Include CPT Data file of DB */
require_once __DIR__ . '/templates/data-management.php';

function load_custom_wp_admin_style()
{
    wp_register_style( 'custom_bootstrap_admin_css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css' );
    wp_enqueue_style( 'custom_bootstrap_admin_css');

    wp_register_style( 'custom_bootstrap_admin_style_2', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css' );
    wp_enqueue_style( 'custom_bootstrap_admin_style_2' );

    wp_register_script( 'custom_bootstrap_admin_js', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js' );
    wp_enqueue_script( 'custom_bootstrap_admin_js' );

    wp_register_script( 'custom_bootstrap_admin_js_2', 'https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js' );
    wp_enqueue_script( 'custom_bootstrap_admin_js_2' ); 
}
add_action('admin_enqueue_scripts', 'load_custom_wp_admin_style');



