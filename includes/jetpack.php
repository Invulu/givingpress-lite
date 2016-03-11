<?php
/**
 * Jetpack Compatibility File
 * See: http://jetpack.me/
 *
 * @package GivingPress Lite
 * @since GivingPress Lite 1.0
 */

/**
 * Add support for Jetpack's Featured Content
 */
function givingpress_lite_jetpack_setup() {

	// See: http://jetpack.me/support/featured-content/
	add_theme_support( 'featured-content', array(
		'featured_content_filter' => 'givingpress_lite_get_featured_posts',
		'max_posts' => 10,
	) );

}
add_action( 'after_setup_theme', 'givingpress_lite_jetpack_setup' );

/**
 * Featured Content: get our featured posts
 */
function givingpress_lite_get_featured_posts() {
	return apply_filters( 'givingpress_lite_get_featured_posts', array() );
}

/**
 * Featured Content: check if we have at least one post in our FC tag
 */
function givingpress_lite_has_featured_posts( $minimum = 1 ) {
	if ( is_paged() ) {
		return true; }

	$minimum = absint( $minimum );
	$featured_posts = apply_filters( 'givingpress_lite_get_featured_posts', array() );

	if ( ! is_array( $featured_posts ) ) {
		return false; }

	if ( $minimum > count( $featured_posts ) ) {
		return false; }

	return true;
}
