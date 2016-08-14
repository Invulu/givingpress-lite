<?php
/**
 *
 * This template is used to display the home page.
 *
 * @package GivingPress Lite
 * @since GivingPress Lite 1.0
 */

get_header(); ?>

<?php if ( is_home() && is_front_page() ) { ?>

	<?php get_template_part( 'content/content', 'home' ); ?>

<?php } else { ?>

	<?php get_template_part( 'index' ); ?>

<?php } ?>

<?php get_footer(); ?>
