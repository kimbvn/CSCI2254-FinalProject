<?php
/*
Plugin Name: Site Plugin for BC KISA

Description: Site specific code changes for example.com

*/

add_image_size( 'album-grid', 225, 150, true );

add_action( 'init', 'register_cpt_album' );

function register_cpt_album() {

    $labels = array( 
        'name' => _x( 'Albums', 'album' ),
        'singular_name' => _x( 'Album', 'album' ),
        'add_new' => _x( 'Add New', 'album' ),
        'add_new_item' => _x( 'Add New Album', 'album' ),
        'edit_item' => _x( 'Edit Album', 'album' ),
        'new_item' => _x( 'New Album', 'album' ),
        'view_item' => _x( 'View Album', 'album' ),
        'search_items' => _x( 'Search Albums', 'album' ),
        'not_found' => _x( 'No albums found', 'album' ),
        'not_found_in_trash' => _x( 'No albums found in Trash', 'album' ),
        'parent_item_colon' => _x( 'Parent Album:', 'album' ),
        'menu_name' => _x( 'Albums', 'album' ),
    );

    $args = array( 
        'labels' => $labels,
        'hierarchical' => false,
        
        'supports' => array( 'title', 'editor', 'thumbnail', 'comments' ),
        
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        
        'menu_icon' => 'Albums',
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'post'
    );

    register_post_type( 'album', $args );
}
 function display_child() {
 	global $post;
 		if( is_page() && $post->post_parent) {
 			$childpages = wp_list_pages('sort_colun=menu_order&title_li=&child_of=' .$post-
 			>post_parent .'&echo=0');
 		} else {
 			$childpages = wp_list_pages('sort_column=menu_order&title_li=&child_of=' .$post->ID .
 			'&echo=0');
 		}
 		if($childpages) {
 	 		$string = '<ul>'.$childpages.'</ul'>;
 	 	}
 	 	return $string;
 	}
 	add_shortcode('wpb_childpages','wpb_list_child_pages');


