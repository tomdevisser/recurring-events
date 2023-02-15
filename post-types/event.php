<?php

/**
 * Registers the `event` post type.
 */
function event_init() {
	register_post_type(
		'event',
		[
			'labels'                => [
				'name'                  => __( 'Events', 'reev' ),
				'singular_name'         => __( 'Event', 'reev' ),
				'all_items'             => __( 'All Events', 'reev' ),
				'archives'              => __( 'Event Archives', 'reev' ),
				'attributes'            => __( 'Event Attributes', 'reev' ),
				'insert_into_item'      => __( 'Insert into Event', 'reev' ),
				'uploaded_to_this_item' => __( 'Uploaded to this Event', 'reev' ),
				'featured_image'        => _x( 'Featured Image', 'event', 'reev' ),
				'set_featured_image'    => _x( 'Set featured image', 'event', 'reev' ),
				'remove_featured_image' => _x( 'Remove featured image', 'event', 'reev' ),
				'use_featured_image'    => _x( 'Use as featured image', 'event', 'reev' ),
				'filter_items_list'     => __( 'Filter Events list', 'reev' ),
				'items_list_navigation' => __( 'Events list navigation', 'reev' ),
				'items_list'            => __( 'Events list', 'reev' ),
				'new_item'              => __( 'New Event', 'reev' ),
				'add_new'               => __( 'Add New', 'reev' ),
				'add_new_item'          => __( 'Add New Event', 'reev' ),
				'edit_item'             => __( 'Edit Event', 'reev' ),
				'view_item'             => __( 'View Event', 'reev' ),
				'view_items'            => __( 'View Events', 'reev' ),
				'search_items'          => __( 'Search Events', 'reev' ),
				'not_found'             => __( 'No Events found', 'reev' ),
				'not_found_in_trash'    => __( 'No Events found in trash', 'reev' ),
				'parent_item_colon'     => __( 'Parent Event:', 'reev' ),
				'menu_name'             => __( 'Events', 'reev' ),
			],
			'public'                => true,
			'hierarchical'          => false,
			'show_ui'               => true,
			'show_in_nav_menus'     => true,
			'supports'              => [ 'title', 'editor' ],
			'has_archive'           => true,
			'rewrite'               => true,
			'query_var'             => true,
			'menu_position'         => null,
			'menu_icon'             => 'dashicons-smiley',
			'show_in_rest'          => true,
			'rest_base'             => 'event',
			'rest_controller_class' => 'WP_REST_Posts_Controller',
		]
	);

}

add_action( 'init', 'event_init' );

/**
 * Sets the post updated messages for the `event` post type.
 *
 * @param  array $messages Post updated messages.
 * @return array Messages for the `event` post type.
 */
function event_updated_messages( $messages ) {
	global $post;

	$permalink = get_permalink( $post );

	$messages['event'] = [
		0  => '', // Unused. Messages start at index 1.
		/* translators: %s: post permalink */
		1  => sprintf( __( 'Event updated. <a target="_blank" href="%s">View Event</a>', 'reev' ), esc_url( $permalink ) ),
		2  => __( 'Custom field updated.', 'reev' ),
		3  => __( 'Custom field deleted.', 'reev' ),
		4  => __( 'Event updated.', 'reev' ),
		/* translators: %s: date and time of the revision */
		5  => isset( $_GET['revision'] ) ? sprintf( __( 'Event restored to revision from %s', 'reev' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false, // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		/* translators: %s: post permalink */
		6  => sprintf( __( 'Event published. <a href="%s">View Event</a>', 'reev' ), esc_url( $permalink ) ),
		7  => __( 'Event saved.', 'reev' ),
		/* translators: %s: post permalink */
		8  => sprintf( __( 'Event submitted. <a target="_blank" href="%s">Preview Event</a>', 'reev' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
		/* translators: 1: Publish box date format, see https://secure.php.net/date 2: Post permalink */
		9  => sprintf( __( 'Event scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Event</a>', 'reev' ), date_i18n( __( 'M j, Y @ G:i', 'reev' ), strtotime( $post->post_date ) ), esc_url( $permalink ) ),
		/* translators: %s: post permalink */
		10 => sprintf( __( 'Event draft updated. <a target="_blank" href="%s">Preview Event</a>', 'reev' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
	];

	return $messages;
}

add_filter( 'post_updated_messages', 'event_updated_messages' );

/**
 * Sets the bulk post updated messages for the `event` post type.
 *
 * @param  array $bulk_messages Arrays of messages, each keyed by the corresponding post type. Messages are
 *                              keyed with 'updated', 'locked', 'deleted', 'trashed', and 'untrashed'.
 * @param  int[] $bulk_counts   Array of item counts for each message, used to build internationalized strings.
 * @return array Bulk messages for the `event` post type.
 */
function event_bulk_updated_messages( $bulk_messages, $bulk_counts ) {
	global $post;

	$bulk_messages['event'] = [
		/* translators: %s: Number of Events. */
		'updated'   => _n( '%s Event updated.', '%s Events updated.', $bulk_counts['updated'], 'reev' ),
		'locked'    => ( 1 === $bulk_counts['locked'] ) ? __( '1 Event not updated, somebody is editing it.', 'reev' ) :
						/* translators: %s: Number of Events. */
						_n( '%s Event not updated, somebody is editing it.', '%s Events not updated, somebody is editing them.', $bulk_counts['locked'], 'reev' ),
		/* translators: %s: Number of Events. */
		'deleted'   => _n( '%s Event permanently deleted.', '%s Events permanently deleted.', $bulk_counts['deleted'], 'reev' ),
		/* translators: %s: Number of Events. */
		'trashed'   => _n( '%s Event moved to the Trash.', '%s Events moved to the Trash.', $bulk_counts['trashed'], 'reev' ),
		/* translators: %s: Number of Events. */
		'untrashed' => _n( '%s Event restored from the Trash.', '%s Events restored from the Trash.', $bulk_counts['untrashed'], 'reev' ),
	];

	return $bulk_messages;
}

add_filter( 'bulk_post_updated_messages', 'event_bulk_updated_messages', 10, 2 );
