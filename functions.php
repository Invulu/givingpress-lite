<?php
/**
 * This file includes the theme functions.
 *
 * @package GivingPress Lite
 * @since GivingPress Lite 1.0
 */

/*
-------------------------------------------------------------------------------------------------------
	Theme Setup
-------------------------------------------------------------------------------------------------------
*/

if ( ! function_exists( 'givingpress_lite_setup' ) ) :

	/** Function givingpress_lite_setup */
	function givingpress_lite_setup() {

		// Make theme available for translation.
		load_theme_textdomain( 'givingpress-lite', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		// Enable support for site title tag.
		add_theme_support( 'title-tag' );

		// Enable support for Post Thumbnails.
		add_theme_support( 'post-thumbnails' );

		add_image_size( 'givingpress-lite-featured-large', 2400, 1800 ); // Large Featured Image.
		add_image_size( 'givingpress-lite-featured-medium', 1800, 1200 ); // Medium Featured Image.
		add_image_size( 'givingpress-lite-featured-small', 640, 640 ); // Small Featured Image.
		add_image_size( 'givingpress-lite-logo-size', 760, 280 ); // Logo Image Size.

		// Create Menus.
		register_nav_menus( array(
			'main-menu' => esc_html__( 'Main Menu', 'givingpress-lite' ),
			'social-menu' => esc_html__( 'Social Menu', 'givingpress-lite' ),
		));

		// Custom Header.
		register_default_headers( array(
			'forest' => array(
			'url'   => get_template_directory_uri() . '/images/header.jpg',
			'thumbnail_url' => get_template_directory_uri() . '/images/header-thumb.jpg',
			'description'   => esc_html__( 'Default Custom Header', 'givingpress-lite' ),
			),
		));
		$defaults = array(
		'width'                 => 1800,
		'height'                => 640,
		'default-image'					=> get_template_directory_uri() . '/images/header.jpg',
		'flex-height'           => true,
		'flex-width'            => true,
		'default-text-color'    => 'ffffff',
		'header-text'           => true,
		'uploads'               => true,
		);
		add_theme_support( 'custom-header', $defaults );

		// Custom Background.
		$defaults = array(
		'default-color'          => 'eeeeee',
		);
		add_theme_support( 'custom-background', $defaults );

		// Switch default core markup for search form, comment form, and comments to output valid HTML5.
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );
	}
endif; // Function givingpress_lite_setup.
add_action( 'after_setup_theme', 'givingpress_lite_setup' );

/*
-------------------------------------------------------------------------------------------------------
	Admin Notice
-------------------------------------------------------------------------------------------------------
*/

/** Function givingpress_lite_admin_notice */
function givingpress_lite_admin_notice() {
	echo '<div class="updated"><p>';
	printf( __( 'Enjoying the theme? <a href="%1$s" target="_blank">Sign Up</a> to start your <a href="%2$s" target="_blank">GivingPress Pro</a> site with a ton of added features and services!', 'givingpress-lite' ), 'https://givingpress.com', 'http://preview.givingpress.com' );
	echo '</p></div>';
}
add_action( 'admin_notices', 'givingpress_lite_admin_notice' );

/*
-------------------------------------------------------------------------------------------------------
	Category ID to Name
-------------------------------------------------------------------------------------------------------
*/

/**
 * Changes category IDs to names
 *
 * @param array $id IDs for categories.
 * @return array
 */
function givingpress_lite_tax_id_to_name( $id ) {
	$term = get_term( $id, 'category' );
	if ( is_wp_error( $term ) ) {
		return false; }
	return $name = $term->name;
}

/*
-------------------------------------------------------------------------------------------------------
	Register Scripts
-------------------------------------------------------------------------------------------------------
*/

if ( ! function_exists( 'givingpress_lite_enqueue_scripts' ) ) {

	/** Function givingpress_lite_enqueue_scripts */
	function givingpress_lite_enqueue_scripts() {

		// Enqueue Styles.
		wp_enqueue_style( 'givingpress-lite-style', get_stylesheet_uri() );
		wp_enqueue_style( 'givingpress-lite-style-mobile', get_template_directory_uri() . '/css/style-mobile.css', array( 'givingpress-lite-style' ), '1.0' );
		wp_enqueue_style( 'givingpress-lite-font-awesome', get_template_directory_uri() . '/css/font-awesome.css', array( 'givingpress-lite-style' ), '1.0' );

		// Resgister Scripts.
		wp_register_script( 'givingpress-lite-fitvids', get_template_directory_uri() . '/js/jquery.fitvids.js', array( 'jquery' ), '20130729' );
		wp_register_script( 'givingpress-lite-hover', get_template_directory_uri() . '/js/hoverIntent.js', array( 'jquery' ), '20130729' );
		wp_register_script( 'givingpress-lite-superfish', get_template_directory_uri() . '/js/superfish.js', array( 'jquery', 'givingpress-lite-hover' ), '20130729' );

		// Enqueue Scripts.
		wp_enqueue_script( 'givingpress-lite-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20130729', true );
		wp_enqueue_script( 'givingpress-lite-custom', get_template_directory_uri() . '/js/jquery.custom.js', array( 'jquery', 'givingpress-lite-superfish', 'givingpress-lite-fitvids', 'masonry' ), '20130729', true );

		// Load Flexslider on front page and slideshow page template.
		if ( is_home() || is_page_template( 'template-home.php' ) || is_single() || is_page_template( 'template-slideshow.php' ) ) {
			wp_enqueue_script( 'givingpress-lite-flexslider', get_template_directory_uri() . '/js/jquery.flexslider.js', array( 'jquery' ), '20130729' );
		}

		// Load single scripts only on single pages.
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}
}
add_action( 'wp_enqueue_scripts', 'givingpress_lite_enqueue_scripts' );

/*
-------------------------------------------------------------------------------------------------------
	Register Sidebars
-------------------------------------------------------------------------------------------------------
*/

/** Function givingpress_widgets_init */
function givingpress_widgets_init() {
	register_sidebar(array(
		'name' => esc_html__( 'Default Sidebar', 'givingpress-lite' ),
		'id' => 'sidebar-1',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h6 class="widget-title">',
		'after_title' => '</h6>',
	));
	register_sidebar(array(
		'name' => esc_html__( 'Left Sidebar', 'givingpress-lite' ),
		'id' => 'sidebar-left',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h6 class="widget-title">',
		'after_title' => '</h6>',
	));
	register_sidebar(array(
		'name' => esc_html__( 'Footer Widgets', 'givingpress-lite' ),
		'id' => 'footer',
		'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="footer-widget">',
		'after_widget' => '</div></div>',
		'before_title' => '<h6 class="widget-title">',
		'after_title' => '</h6>',
	));
}
add_action( 'widgets_init', 'givingpress_widgets_init' );

/*
-------------------------------------------------------------------------------------------------------
	Add Stylesheet To Visual Editor
-------------------------------------------------------------------------------------------------------
*/

add_action( 'widgets_init', 'givingpress_lite_add_editor_styles' );
/**
 * Apply theme's stylesheet to the visual editor.
 *
 * @uses add_editor_style() Links a stylesheet to visual editor
 * @uses get_stylesheet_uri() Returns URI of theme stylesheet
 */
function givingpress_lite_add_editor_styles() {
	add_editor_style( 'css/style-editor.css' );
}

/*
------------------------------------------------------------------------------------------------------
   Content Width
------------------------------------------------------------------------------------------------------
*/

/** Function givingpress_lite_content_width */
function givingpress_lite_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'givingpress_lite_content_width', 980 );
}
add_action( 'after_setup_theme', 'givingpress_lite_content_width', 0 );

/*
-------------------------------------------------------------------------------------------------------
	Comments Function
-------------------------------------------------------------------------------------------------------
*/

if ( ! function_exists( 'givingpress_lite_comment' ) ) :

	/**
	 * Setup our comments for the theme.
	 *
	 * @param array $comment IDs for categories.
	 * @param array $args Comment arguments.
	 * @param array $depth Level of replies.
	 */
	function givingpress_lite_comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		switch ( $comment->comment_type ) :
			case 'pingback' :
			case 'trackback' :
		?>
		<li class="post pingback">
		<p><?php esc_html_e( 'Pingback:', 'givingpress-lite' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( esc_html__( 'Edit', 'givingpress-lite' ), '<span class="edit-link">', '</span>' ); ?></p>
	<?php
		break;
			default :
		?>
		<li <?php comment_class(); ?> id="<?php echo esc_attr( 'li-comment-' . get_comment_ID() ); ?>">

		<article id="<?php echo esc_attr( 'comment-' . get_comment_ID() ); ?>" class="comment">
			<footer class="comment-meta">
				<div class="comment-author vcard">
					<?php
						$avatar_size = 72;
					if ( '0' !== $comment->comment_parent ) {
						$avatar_size = 48; }

						echo get_avatar( $comment, $avatar_size );

						/* translators: 1: comment author, 2: date and time */
						printf( __( '%1$s <br/> %2$s <br/>', 'givingpress-lite' ),
							sprintf( '<span class="fn">%s</span>', wp_kses_post( get_comment_author_link() ) ),
							sprintf( '<a href="%1$s"><time pubdate datetime="%2$s">%3$s</time></a>',
								esc_url( get_comment_link( $comment->comment_ID ) ),
								get_comment_time( 'c' ),
								sprintf( esc_html__( '%1$s', 'givingpress-lite' ), get_comment_date(), get_comment_time() )
							)
						);
						?>
					</div><!-- .comment-author .vcard -->
				</footer>

				<div class="comment-content">
					<?php if ( '0' === $comment->comment_approved ) : ?>
					<em class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'givingpress-lite' ); ?></em>
					<br />
				<?php endif; ?>
					<?php comment_text(); ?>
					<div class="reply">
					<?php comment_reply_link( array_merge( $args, array( 'reply_text' => esc_html__( 'Reply', 'givingpress-lite' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
					</div><!-- .reply -->
					<?php edit_comment_link( esc_html__( 'Edit', 'givingpress-lite' ), '<span class="edit-link">', '</span>' ); ?>
				</div>

			</article><!-- #comment-## -->

		<?php
		break;
		endswitch;
	}
endif; // Ends check for givingpress_lite_comment().

/*
-------------------------------------------------------------------------------------------------------
	Custom Excerpt Length
-------------------------------------------------------------------------------------------------------
*/

/**
 * Adds a custom excerpt length
 *
 * @param array $length Excerpt word count.
 * @return array
 */
function givingpress_lite_excerpt_length( $length ) {
	return 38;
}
add_filter( 'excerpt_length', 'givingpress_lite_excerpt_length', 999 );

/**
 * Return custom read more link text for the excerpt.
 *
 * @param array $more is the excerpt more link.
 * @return array
 */
function givingpress_lite_excerpt_more( $more ) {
	return '... <a class="read-more" href="'. esc_url( get_permalink( get_the_ID() ) ) . '">'. esc_html__( 'Read More', 'givingpress-lite' ) .'</a>';
}
add_filter( 'excerpt_more', 'givingpress_lite_excerpt_more' );

/*
-------------------------------------------------------------------------------------------------------
	Posted On Function
-------------------------------------------------------------------------------------------------------
*/

/** Function givingpress_lite_posted_on */
function givingpress_lite_posted_on() {
	if ( get_the_modified_time() !== get_the_time() ) {
		printf( __( '<span class="%1$s">Last Updated:</span> %2$s <span class="meta-sep">by</span> %3$s', 'givingpress-lite' ),
			'meta-prep meta-prep-author',
			sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><span class="entry-date">%3$s</span></a>',
				esc_url( get_permalink() ),
				esc_attr( get_the_modified_time() ),
				esc_attr( get_the_modified_date() )
			),
			sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span>',
				esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
				sprintf( esc_attr__( 'View all posts by %s', 'givingpress-lite' ), get_the_author() ),
				get_the_author()
			)
		);
	} else {
		printf( __( '<span class="%1$s">Posted:</span> %2$s <span class="meta-sep">by</span> %3$s', 'givingpress-lite' ),
			'meta-prep meta-prep-author',
			sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><span class="entry-date">%3$s</span></a>',
				esc_url( get_permalink() ),
				esc_attr( get_the_time() ),
				get_the_date()
			),
			sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span>',
				esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
				sprintf( esc_attr__( 'View all posts by %s', 'givingpress-lite' ), get_the_author() ),
				get_the_author()
			)
		);
	}
}

/*
-------------------------------------------------------------------------------------------------------
   Custom Page Links
-------------------------------------------------------------------------------------------------------
*/

/**
 * Adds custom page links to pages.
 *
 * @param array $args for page links.
 * @return array
 */
function givingpress_lite_wp_link_pages_args_prevnext_add( $args ) {
	global $page, $numpages, $more, $pagenow;

	if ( 'next_and_number' === ! $args['next_or_number'] ) {
		return $args; }

	$args['next_or_number'] = 'number'; // Keep numbering for the main part.
	if ( ! $more ) {
		return $args; }

	if ( $page -1 ) { // There is a previous page.
		$args['before'] .= _wp_link_page( $page -1 )
		. $args['link_before']. $args['previouspagelink'] . $args['link_after'] . '</a>'; }

	if ( $page < $numpages ) { // There is a next page.
		$args['after'] = _wp_link_page( $page + 1 )
		. $args['link_before'] . $args['nextpagelink'] . $args['link_after'] . '</a>'
		. $args['after']; }

	return $args;
}
add_filter( 'wp_link_pages_args', 'givingpress_lite_wp_link_pages_args_prevnext_add' );

/*
-------------------------------------------------------------------------------------------------------
	Body Class
-------------------------------------------------------------------------------------------------------
*/

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function givingpress_lite_body_class( $classes ) {

	$header_image = get_header_image();

	if ( is_singular() ) {
		$classes[] = 'givingpress-lite-singular'; }

	if ( has_post_thumbnail() ) {
		$classes[] = 'has-featured-img'; }

	if ( is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'givingpress-lite-right-sidebar'; }

	if ( is_active_sidebar( 'sidebar-left' ) ) {
		$classes[] = 'givingpress-lite-left-sidebar'; }

	if ( is_page_template( 'template-home.php' ) && class_exists( 'Jetpack' ) && givingpress_lite_has_featured_posts( 1 ) ) {
		$classes[] = 'givingpress-lite-slider-active'; }

	if ( ! empty( $header_image ) ) {
		$classes[] = 'givingpress-lite-header-active'; }

	if ( empty( $header_image ) ) {
		$classes[] = 'givingpress-lite-header-inactive'; }

	if ( 'blank' !== get_theme_mod( 'header_textcolor' ) ) {
		$classes[] = 'givingpress-lite-title-active'; }

	if ( 'blank' === get_theme_mod( 'header_textcolor' ) ) {
		$classes[] = 'givingpress-lite-title-inactive'; }

	if ( get_theme_mod( 'givingpress_lite_logo', get_template_directory_uri() . '/images/logo.png' ) ) {
		$classes[] = 'givingpress-lite-logo-active'; }

	if ( 'left' === get_theme_mod( 'givingpress_lite_description_align', 'left' ) ) {
		$classes[] = 'givingpress-lite-description-left'; }

	if ( 'center' === get_theme_mod( 'givingpress_lite_description_align' ) ) {
		$classes[] = 'givingpress-lite-description-center'; }

	if ( 'right' === get_theme_mod( 'givingpress_lite_description_align' ) ) {
		$classes[] = 'givingpress-lite-description-right'; }

	if ( 'left' === get_theme_mod( 'givingpress_lite_logo_align', 'left' ) ) {
		$classes[] = 'givingpress-lite-logo-left'; }

	if ( 'center' === get_theme_mod( 'givingpress_lite_logo_align' ) ) {
		$classes[] = 'givingpress-lite-logo-center'; }

	if ( 'right' === get_theme_mod( 'givingpress_lite_logo_align' ) ) {
		$classes[] = 'givingpress-lite-logo-right'; }

	if ( get_theme_mod( 'givingpress_lite_contact_email', 'info@givingpress.com' ) || get_theme_mod( 'givingpress_lite_contact_phone', '808.123.4567' ) || get_theme_mod( 'givingpress_lite_contact_address', '231 Front Street, Lahaina, HI 96761' ) ) {
		$classes[] = 'givingpress-lite-info-active'; }

	if ( get_theme_mod( 'background_image' ) ) {
		// This class will render when a background image is set
		// regardless of whether the user has set a color as well.
		$classes[] = 'givingpress-lite-background-image';
	} else if ( ! in_array( get_background_color(), array( '', get_theme_support( 'custom-background', 'default-color' ) ), true ) ) {
		// This class will render when a background color is set
		// but no image is set. In the case the content text will
		// Adjust relative to the background color.
		$classes[] = 'givingpress-lite-relative-text';
	}

	return $classes;
}
add_action( 'body_class', 'givingpress_lite_body_class' );

/*
-------------------------------------------------------------------------------------------------------
	Post Class
-------------------------------------------------------------------------------------------------------
*/

/**
 * Adds custom classes to the array of post classes.
 *
 * @param array $classes Classes for the post element.
 * @param array $class Class for the post element.
 * @param array $post_id ID for the post element.
 * @return array
 */
function givingpress_lite_post_classes( $classes, $class, $post_id ) {
	if ( 0 === get_comments_number( $post_id ) ) {
		$classes[] = 'no-comments';
	}
	return $classes;
}
add_filter( 'post_class', 'givingpress_lite_post_classes', 10, 3 );

/*
-----------------------------------------------------------------------------------------------
	Retrieve email value from Customizer and add mailto protocol
-----------------------------------------------------------------------------------------------
*/

/**
 * Retrieve email value from Customizer.
 */
function givingpress_lite_get_email_link() {
	$email = get_theme_mod( 'givingpress_lite_link_email' );

	if ( ! $email ) {
		return false; }

	return 'mailto:' . sanitize_email( $email );
}

/*
-------------------------------------------------------------------------------------------------------
	Posted Author and Date Function
-------------------------------------------------------------------------------------------------------
*/

if ( ! function_exists( 'givingpress_lite_posted_on' ) ) {

	/**
	 * Posted On Author and Date Function.
	 */
	function givingpress_lite_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}
		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( 'c' ) ),
			esc_html( get_the_modified_date() )
		);
		$posted_on = sprintf(
			esc_html_x( 'Posted on %s', 'post date', 'givingpress-lite' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);
		$byline = sprintf(
			esc_html_x( 'by %s', 'post author', 'givingpress-lite' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);
		echo '<span class="posted-on">' . $posted_on . '</span><span class="byline"> ' . $byline . '</span>';
	}
}

/*
-------------------------------------------------------------------------------------------------------
	First Featured Video
-------------------------------------------------------------------------------------------------------
*/

/**
 * Retrieve first video from post content.
 */
function givingpress_lite_first_embed_media() {
	global $post, $posts;
	$first_vid = '';
	$content = do_shortcode( apply_filters( 'the_content', $post->post_content ) );
	$embeds = get_media_embedded_in_content( $content );

	if ( ! empty( $embeds ) ) {
		foreach ( $embeds as $embed ) {
			if ( strpos( $embed, 'video' ) || strpos( $embed, 'youtube' ) || strpos( $embed, 'vimeo' ) ) {
				return $embed;
			}
		}
	} else {
		return false;
	}
}

/*
-------------------------------------------------------------------------------------------------------
	Remove First Gallery
-------------------------------------------------------------------------------------------------------
*/

/**
 * Retrieve first gallery from post content.
 *
 * @param array $content Returns gallery in content.
 * @return array
 */
function givingpress_lite_remove_gallery( $content ) {
	if ( is_page_template( 'template-slideshow.php' ) ) {
		$content = preg_replace( '/\[gallery(.*?)ids=[^\]]+\]/', '', $content, 1 );
	}
	return $content;
}
add_filter( 'the_content', 'givingpress_lite_remove_gallery' );

/*
-------------------------------------------------------------------------------------------------------
	Includes
-------------------------------------------------------------------------------------------------------
*/

require_once( get_template_directory() . '/includes/customizer.php' );
require_once( get_template_directory() . '/includes/typefaces.php' );

/*
-------------------------------------------------------------------------------------------------------
	Load Jetpack File
-------------------------------------------------------------------------------------------------------
*/

if ( class_exists( 'Jetpack' ) ) {
	require get_template_directory() . '/includes/jetpack.php';
}
