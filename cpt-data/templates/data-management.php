<?php

### CREATE CUSTOM POST TYPE OF EMPLOYEE ###

function create_employee_post_type() {
    $labels = array(
        'name'               => 'Employees',
        'singular_name'      => 'Employee',
        'menu_name'          => 'Employees',
        'name_admin_bar'     => 'Employee',
        'add_new'            => 'Add New',
        'add_new_item'       => 'Add New Employee',
        'new_item'           => 'New Employee',
        'edit_item'          => 'Edit Employee',
        'view_item'          => 'View Employee',
        'all_items'          => 'All Employees',
        'search_items'       => 'Search Employees',
        'parent_item_colon'  => 'Parent Employees:',
        'not_found'          => 'No employees found.',
        'not_found_in_trash' => 'No employees found in Trash.'
    );

    $args = array(
        'labels'              => $labels,
        'public'              => true,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'query_var'           => true,
        'rewrite'             => array( 'slug' => 'employee' ),
        'capability_type'     => 'post',
        'has_archive'         => true,
        'hierarchical'        => false,
        'menu_icon'           => 'dashicons-businessman',
        'menu_position'       => null,
        'supports'            => array( 'title', 'editor', 'thumbnail' ),
    );

    register_post_type( 'employee', $args );
}
add_action( 'init', 'create_employee_post_type' );

### CREATE TEXONOMY POST TYPE OF EMPLOYEE ###

function create_employee_taxonomy() {
    $labels = array(
        'name'                       => 'Employee Types',
        'singular_name'              => 'Employee Type',
        'search_items'               => 'Search Employee Types',
        'popular_items'              => 'Popular Employee Types',
        'all_items'                  => 'All Employee Types',
        'parent_item'                => null,
        'parent_item_colon'          => null,
        'edit_item'                  => 'Edit Employee Type',
        'update_item'                => 'Update Employee Type',
        'add_new_item'               => 'Add New Employee Type',
        'new_item_name'              => 'New Employee Type Name',
        'separate_items_with_commas' => 'Separate employee types with commas',
        'add_or_remove_items'        => 'Add or remove employee types',
        'choose_from_most_used'      => 'Choose from the most used employee types',
        'not_found'                  => 'No employee types found.',
        'menu_name'                  => 'Employee Types',
    );

    $args = array(
        'hierarchical'          => true,
        'labels'                => $labels,
        'show_ui'               => true,
        'show_admin_column'     => true,
        'query_var'             => true,
        'rewrite'               => array( 'slug' => 'employee-type' ),
    );

    register_taxonomy( 'employee_type', 'employee', $args );
}
add_action( 'init', 'create_employee_taxonomy' );

### ENABLE TAGS POST TYPE OF EMPLOYEE ###

function enable_employee_tags() {
    register_taxonomy_for_object_type( 'post_tag', 'employee' );
}
add_action( 'init', 'enable_employee_tags' );
