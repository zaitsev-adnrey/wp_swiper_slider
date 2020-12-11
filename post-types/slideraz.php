<?php

/**
 * Registers the `slideraz` post type.
 */
function slideraz_init() {
	register_post_type( 'slideraz', array(
		'labels'                => array(
			'name'                  => __( 'Sliders', 'slideraz' ),
			'singular_name'         => __( 'Slider', 'slideraz' ),
			'all_items'             => __( 'All Sliders', 'slideraz' ),
			'archives'              => __( 'Slider Archives', 'slideraz' ),
			'attributes'            => __( 'Slider Attributes', 'slideraz' ),
			'insert_into_item'      => __( 'Insert into Slider', 'slideraz' ),
			'uploaded_to_this_item' => __( 'Uploaded to this Slider', 'slideraz' ),
			'featured_image'        => _x( 'Featured Image', 'slideraz', 'slideraz' ),
			'set_featured_image'    => _x( 'Set featured image', 'slideraz', 'slideraz' ),
			'remove_featured_image' => _x( 'Remove featured image', 'slideraz', 'slideraz' ),
			'use_featured_image'    => _x( 'Use as featured image', 'slideraz', 'slideraz' ),
			'filter_items_list'     => __( 'Filter Sliders list', 'slideraz' ),
			'items_list_navigation' => __( 'Sliders list navigation', 'slideraz' ),
			'items_list'            => __( 'Sliders list', 'slideraz' ),
			'new_item'              => __( 'New Slider', 'slideraz' ),
			'add_new'               => __( 'Add New', 'slideraz' ),
			'add_new_item'          => __( 'Add New Slider', 'slideraz' ),
			'edit_item'             => __( 'Edit Slider', 'slideraz' ),
			'view_item'             => __( 'View Slider', 'slideraz' ),
			'view_items'            => __( 'View Sliders', 'slideraz' ),
			'search_items'          => __( 'Search Sliders', 'slideraz' ),
			'not_found'             => __( 'No Sliders found', 'slideraz' ),
			'not_found_in_trash'    => __( 'No Sliders found in trash', 'slideraz' ),
			'parent_item_colon'     => __( 'Parent Slider:', 'slideraz' ),
			'menu_name'             => __( 'Sliders', 'slideraz' ),
		),
		'public'                => true,
		'publicly_queryable'	=> false,
		'exclude_from_search'	=> true,
		'hierarchical'          => false,
		'show_ui'               => true,
		'show_in_nav_menus'     => true,
		'supports'              => array( 'title'),
		'has_archive'           => true,
		'rewrite'               => true,
		'query_var'             => true,
		'menu_position'         => null,
		'menu_icon'             => 'dashicons-images-alt2',
		'show_in_rest'          => true,
		'rest_base'             => 'slideraz',
		'rest_controller_class' => 'WP_REST_Posts_Controller',
	) );

}
add_action( 'init', 'slideraz_init' );

/**
 * Sets the post updated messages for the `slideraz` post type.
 *
 * @param  array $messages Post updated messages.
 * @return array Messages for the `slideraz` post type.
 */
function slideraz_updated_messages( $messages ) {
	global $post;

	$permalink = get_permalink( $post );

	$messages['slideraz'] = array(
		0  => '', // Unused. Messages start at index 1.
		/* translators: %s: post permalink */
		1  => sprintf( __( 'Slider updated.', 'slideraz' )),
		2  => __( 'Custom field updated.', 'slideraz' ),
		3  => __( 'Custom field deleted.', 'slideraz' ),
		4  => __( 'Slider updated.', 'slideraz' ),
		/* translators: %s: date and time of the revision */
		5  => isset( $_GET['revision'] ) ? sprintf( __( 'Slider restored to revision from %s', 'slideraz' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		/* translators: %s: post permalink */
		6  => sprintf( __( 'Slider published. <a href="%s">View Slider</a>', 'slideraz' ), esc_url( $permalink ) ),
		7  => __( 'Slider saved.', 'slideraz' ),
		/* translators: %s: post permalink */
		8  => sprintf( __( 'Slider submitted. <a target="_blank" href="%s">Preview Slider</a>', 'slideraz' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
		/* translators: 1: Publish box date format, see https://secure.php.net/date 2: Post permalink */
		9  => sprintf( __( 'Slider scheduled for: <strong>%1$s</strong>.', 'slideraz' ),
		date_i18n( __( 'M j, Y @ G:i', 'slideraz' ), strtotime( $post->post_date ) )),
		/* translators: %s: post permalink */
		10 => sprintf( __( 'Slider draft updated. <a target="_blank" href="%s">Preview Slider</a>', 'slideraz' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
	);

	return $messages;
}
add_filter( 'post_updated_messages', 'slideraz_updated_messages' );
