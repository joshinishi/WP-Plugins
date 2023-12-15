<?php
/**
 * Plugin Name:       My Plugin
 * Plugin URI:        http://localhost/wp-plugin/
 * Description:       Handle the basics with this plugin.
 * Version:           1.10.3
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Nishita Joshi
 * Author URI:        #
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       my-basics-plugin
 * Domain Path:       /languages
 */

if (!defined('ABSPATH')) {
    header("Location: /");
    die("");
}

function plugin_activation() {
    global $wpdb, $table_prefix;
    $wp_emp = $table_prefix . 'emp';

    $q = "CREATE TABLE IF NOT EXISTS `$wp_emp` (`ID` INT NOT NULL AUTO_INCREMENT , `name` VARCHAR(50) NOT NULL, `email` VARCHAR(100) NOT NULL , `status` BOOLEAN NOT NULL , PRIMARY KEY (`ID`)) ENGINE = InnoDB";
    $wpdb->query($q);

    $data = array(
        'name'   => 'Nishii',
        'email'  => 'nishita@demolink.info',
        'status' =>  1
    );
    $wpdb->insert($wp_emp, $data);
}
register_activation_hook(__FILE__, 'plugin_activation');

function plugin_deactivation() {
    global $wpdb, $table_prefix;
    $wp_emp = $table_prefix . 'emp';

    $q = "TRUNCATE `$wp_emp`;";
    $wpdb->query($q);
}
register_deactivation_hook(__FILE__, 'plugin_deactivation');

function my_custom_scripts() {
    $path = plugins_url('js/main.js', __FILE__);
    $path_style = plugins_url('css/style.css', __FILE__); // Define $path_style
    $dep = array('jquery');
    $ver = filemtime(plugin_dir_path(__FILE__) . 'js/main.js');
    $ver_style = filemtime(plugin_dir_path(__FILE__) . 'css/style.css');
    $is_login = is_user_logged_in() ? 1 : 0;

    wp_enqueue_style('my-custom-style', $path_style, '', $ver_style);

    wp_enqueue_script('my_custom_js', $path, $dep, $ver, true);
    wp_add_inline_script('my_custom_js', 'var is_login = ' . $is_login . ';', 'before');

    ##CSS ONLY APPLICABLE FOR SINGLE SPECIFIC PAGE

    // if(is_page('home')){
    //     wp_enqueue_style('my-custom-style', $path_style, '', $ver_style);
    // }
}
add_action('wp_enqueue_scripts', 'my_custom_scripts');
add_action('admin_enqueue_scripts', 'my_custom_scripts');


function custom_code(){
    global $wpdb, $table_prefix;
    $wp_emp = $table_prefix . 'emp';
    
    
    $q = "SELECT * FROM `$wp_emp`;";
    $results = $wpdb->get_results($q);

    ob_start()
    ?>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Status</th>
            </tr>
            <tbody>
                <?php 
                    foreach($results as $row):
                ?>
                <tr>
                    <td><?php echo $row->ID; ?></td>
                    <td><?php echo $row->name; ?></td>
                    <td><?php echo $row->email; ?></td>
                    <td><?php echo $row->status; ?></td>
                </tr>
                <?php 
                 endforeach;
                ?>
            </tbody>
        </table>
    <?php
    $html = ob_get_clean();

   // return $html;
}
add_shortcode('mycode', 'custom_code');


function custom_blocks(){
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => 3,
        'meta_key' => 'views',
        'orderby' => 'ID    ',
        'order' => 'DESC'
    );

    $query = new WP_Query($args);

    ob_start();
    if($query->have_posts()):
    ?>
        <ul>
            <?php
                while($query->have_posts()){
                    $query->the_post();
                    echo '<li><a href=" ' .get_the_permalink(). ' ">' .get_the_title(). ' </a>  -> '. get_the_content(). '</li>';
                }
            ?>
        </ul>
    <?php
    endif;
    wp_reset_postdata();
    $html = ob_get_clean();
    return $html;

}
add_shortcode('myblock', 'custom_blocks');


function head_fun(){
    if(is_single()){
        global $post;
        $views = get_post_meta($post->ID, 'views', true);

        if($views == ''){
            add_post_meta($post->ID, 'views', 1);
        }else{
            $views++;
            update_post_meta($post->ID, 'views', $views);
        }

        echo get_post_meta($post->ID, 'views', true);
    }
}

add_action('wp_head','head_fun');

function view_count(){
    global $post;
    return 'Total Views:'.get_post_meta($post->ID, 'views', true);
}

add_shortcode('my-views', 'view_count');


function myplugin_page_func(){
    include 'admin/main-page.php';
}

function myplugin_subpage_func(){
    include 'admin/sub-page.php';
}

function register_my_custom_menu_page() {
	add_menu_page('My Plugin Page', 'My Plugin Page',
		'manage_options',
		'myplugin_page',
		'myplugin_page_func',
        '',
		6
	);

    add_submenu_page('myplugin_page', 'All Employees', 
        'All Employees',
        'manage_options',
        'myplugin_page',
        'myplugin_page_func',
    );

    add_submenu_page('myplugin_page', 'My Plugin Sub Page', 
    'My Plugin Sub Page',
    'manage_options',
    'my-plugin-subpage',
    'myplugin_subpage_func',
    );
}
add_action( 'admin_menu', 'register_my_custom_menu_page' );


add_action('wp_ajax_my_search_func', 'my_search_func');
add_action('wp_ajax_nopriv_my_search_func', 'my_search_func');

function my_search_fun(){
   global $wpdb, $table_prefix;
   $wp_emp = $table_prefix.'emp';
   $search_term = $post['search_term'];
   
   if(!empty($search_term)){
        $q = "SELECT * FROM `$wp_emp` WHERE 
        `name` LIKE '%" .$search_term."%'
        OR `email` LIKE '%".$search_term."%'
        OR `status` LIKE '%".$search_term."%';"; 
   }else{
        $q = "SELECT * FROM `$wp_emp`;"; 
   }

   $results = $wpdb->get_results($q);
   ob_start();

   foreach($results as $row):
    ?>
        <tr>
            <td><?php echo $row->ID; ?></td>
            <td><?php echo $row->name; ?></td>
            <td><?php echo $row->email; ?></td>
            <td><?php echo $row->status; ?></td>
        </tr>
    <?php 
    endforeach;

   echo ob_get_clean();
   wp_die(); 
}

add_shortcode('my-data', 'my_table_data');
function my_table_data(){
    include 'admin/main-page.php';
}


function register_my_cpt(){
    $labels = array(
        'name' => 'Cars',
        'singular_name' => 'Car'
    );
    $supports = array('title', 'editor', 'thumbnail', 'comments', 'excerpts');
    $options = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => true,
        'rewrite' => array('slug' => 'cars'),
        'show_in_rest' => true,
        'supports' => $supports,
        'texonomies' => array('category'),
        'publicly_queryable' => true,
    );
    register_post_type('cars', $options);
}
add_action('init', 'register_my_cpt');

function register_car_types(){
    $labels = array(
        'name' => 'Car Type',
        'singular_name' => 'Car Types'
    );
    $options = array(
        'labels' => $labels,
        'hierarchical' => true,
        'rewrite' => array('slug' => 'car-type'),
        'show_in_rest' => true
    );
    register_taxonomy('car-type', array('cars'), $options);
}
add_action('init', 'register_car_types');

 
function my_register_form(){
    ob_start();
    include 'public/register.php';
    return ob_get_clean();
}
add_shortcode('my-register-form', 'my_register_form' );