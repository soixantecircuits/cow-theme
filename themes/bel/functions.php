<?php

include( TEMPLATEPATH.'/classes.php' );
include( TEMPLATEPATH.'/widgets.php' );

/**
 * Disable automatic general feed link outputting.
 */
automatic_feed_links( false );

//remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'wp_generator');

if ( function_exists('register_sidebar') ) {
	register_sidebar(array(
		'id' => 'default-sidebar',
		'name' => 'Home Left Sidebar',
		'before_widget' => '<div class="social-networks %2$s" id="%1$s">
								<div class="holder">',
		'after_widget' => '</div></div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>'
	));
	register_sidebar(array(
		'id' => 'two-column-template-rightbar',
		'name' => 'Two Column Template Rightbar',
		'before_widget' => '<div class="box %2$s" id="%1$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>'
	));
	register_sidebar(array(
		'id' => 'footer-social',
		'name' => 'Footer Social icon',
		'before_widget' => '<div class="slide %2$s" id="%1$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>'
	));
}

if ( function_exists( 'add_theme_support' ) ) {
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 50, 50, true ); // Normal post thumbnails
	add_image_size( 'single-post-thumbnail', 400, 9999, true );
}

register_nav_menus( array(
	'primary' => __( 'Primary Navigation', 'base' ),
	'footer' => __( 'Footer Navigation', 'base' ),
) );


//add [email]...[/email] shortcode
function shortcode_email($atts, $content) {
	$result = '';
	for ($i=0; $i<strlen($content); $i++) {
		$result .= '&#'.ord($content{$i}).';';
	}
	return $result;
}
add_shortcode('email', 'shortcode_email');

// register tag [template-url]
function filter_template_url($text) {
	return str_replace('[template-url]',get_bloginfo('template_url'), $text);
}
add_filter('the_content', 'filter_template_url');
add_filter('get_the_content', 'filter_template_url');
add_filter('widget_text', 'filter_template_url');

// register tag [site-url]
function filter_site_url($text) {
	return str_replace('[site-url]',get_bloginfo('url'), $text);
}
add_filter('the_content', 'filter_site_url');
add_filter('get_the_content', 'filter_site_url');
add_filter('widget_text', 'filter_site_url');


/* Replace Standart WP Menu Classes */
function change_menu_classes($css_classes) {
        $css_classes = str_replace("current-menu-item", "active drop-active", $css_classes);
        $css_classes = str_replace("current-menu-parent", "active drop-active", $css_classes);
        return $css_classes;
}
add_filter('nav_menu_css_class', 'change_menu_classes');


//allow tags in category description
$filters = array('pre_term_description', 'pre_link_description', 'pre_link_notes', 'pre_user_description');
foreach ( $filters as $filter ) {
    remove_filter($filter, 'wp_filter_kses');
}


//Make WP Admin Menu HTML Valid
function wp_admin_bar_valid_search_menu( $wp_admin_bar ) {
	if ( is_admin() )
		return;

	$form  = '<form action="' . esc_url( home_url( '/' ) ) . '" method="get" id="adminbarsearch"><div>';
	$form .= '<input class="adminbar-input" name="s" id="adminbar-search" tabindex="10" type="text" value="" maxlength="150" />';
	$form .= '<input type="submit" class="adminbar-button" value="' . __('Search') . '"/>';
	$form .= '</div></form>';

	$wp_admin_bar->add_menu( array(
		'parent' => 'top-secondary',
		'id'     => 'search',
		'title'  => $form,
		'meta'   => array(
			'class'    => 'admin-bar-search',
			'tabindex' => -1,
		)
	) );
}
function fix_admin_menu_search() {
	remove_action( 'admin_bar_menu', 'wp_admin_bar_search_menu', 4 );
	add_action( 'admin_bar_menu', 'wp_admin_bar_valid_search_menu', 4 );
}
add_action( 'add_admin_bar_menus', 'fix_admin_menu_search' );
add_action('init','theme_custom_init');
function theme_custom_init(){
 $labels = array(
  'name' => _x('Projects', 'post type general name'),
  'singular_name' => _x('Project', 'post type singular name'),
  'add_new' => _x('Add New', 'Project'),
  'add_new_item' => __('Add New Project'),
  'edit_item' => __('Edit Project'),
  'new_item' => __('New Project'),
  'all_items' => __('All Projects'),
  'view_item' => __('View Projects'),
  'search_items' => __('Search Projects'),
  'not_found' =>  __('No Project found'),
  'not_found_in_trash' => __('No Project found in Trash'), 
  'parent_item_colon' => '',
  'menu_name' => 'Projects'
 );
 $args = array(
  'labels' => $labels,
  'public' => true,
  'publicly_queryable' => true,
  'show_ui' => true, 
  'show_in_menu' => true, 
  'query_var' => true,
  'rewrite' => true,
  'capability_type' => 'post',
  'has_archive' => true, 
  'hierarchical' => false,
  'menu_position' => null,
  'supports' => array('title','editor','author','thumbnail','excerpt','custom-fields')
 ); 
 register_post_type('projects',$args);
}
add_action('init','create_theme_taxonomies',0);
function create_theme_taxonomies(){
 $labels = array(
  'name' => _x('Project Categories','taxonomy general name'),
  'singular_name' => _x('Project Category','taxonomy singular name'),
  'search_items' =>  __('Search Project Categories'),
  'all_items' => __('All Project Categories' ),
  'parent_item' => __('Parent Project Category'),
  'parent_item_colon' => __('Parent Project Category:'),
  'edit_item' => __('Edit Project Category'), 
  'update_item' => __('Update Project Category'),
  'add_new_item' => __('Add New Project Category'),
  'new_item_name' => __('New Project Category Name'),
  'menu_name' => __('Project Categories'),
 );
 register_taxonomy('project-categories',array('projects'), array(
  'hierarchical' => true,
  'labels' => $labels,
  'show_ui' => true,
  'query_var' => true,
  'rewrite' => array('slug' => 'project-categories'),
 ));
}
?>