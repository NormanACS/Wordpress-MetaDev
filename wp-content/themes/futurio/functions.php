<?php
/**
 * The current version of the theme.
 */
define( 'FUTURIO_VERSION', '1.5.0' );

add_action( 'after_setup_theme', 'futurio_setup' );

if ( !function_exists( 'futurio_setup' ) ) :

	/**
	 * Global functions
	 */
	function futurio_setup() {

		// Theme lang.
		load_theme_textdomain( 'futurio', get_template_directory() . '/languages' );

		// Add Title Tag Support.
		add_theme_support( 'title-tag' );

		// Register Menus.
		register_nav_menus(
		array(
			'main_menu'	 => esc_html__( 'Main Menu', 'futurio' ),
			'main_menu_home' => esc_html__( 'Homepage main menu', 'futurio' ),
		)
		);

		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size( 300, 300, true );
		if ( get_theme_mod( 'blog_single_image', 'default' ) == 'custom' ) {
			$sizes = get_theme_mod( 'blog_single_image_set' );
			add_image_size( 'futurio-single', absint( $sizes['width'] ), absint( $sizes['height'] ), true );
		} else {
			add_image_size( 'futurio-single', 1140, 641, true );
		}
		if ( get_theme_mod( 'blog_archive_image', 'default' ) == 'custom' ) {
			$size = get_theme_mod( 'blog_archive_image_set' );
			add_image_size( 'futurio-med', absint( $size['width'] ), absint( $size['height'] ), true );
		} else {
			add_image_size( 'futurio-med', 720, 405, true );
		}
		add_image_size( 'futurio-thumbnail', 160, 120, true );

		// Add Custom Background Support.
		add_theme_support( 'custom-background' );

		add_theme_support( 'custom-logo', array(
			'height'		 => 80,
			'width'			 => 200,
			'flex-height'	 => true,
			'flex-width'	 => true,
			'header-text'	 => array( 'site-title', 'site-description' ),
		) );

		// Adds RSS feed links to for posts and comments.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		// Set the default content width.
		$GLOBALS[ 'content_width' ] = 1240;

		add_theme_support( 'custom-header', apply_filters( 'futurio_custom_header_args', array(
			'width'				 => 2000,
			'height'			 => 550,
			'wp-head-callback'	 => 'futurio_header_style',
		) ) );

		// WooCommerce support.
		add_theme_support( 'woocommerce' );
		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );
		add_theme_support( 'html5', array( 'search-form' ) );
		/*
		 * This theme styles the visual editor to resemble the theme style,
		 * specifically font, colors, icons, and column width.
		 */
		add_editor_style( array( 'css/bootstrap.css', 'css/editor-style.css' ) );
	}

endif;

if ( !function_exists( 'futurio_header_style' ) ) :

	/**
	 * Styles the header image and text displayed on the blog.
	 */
	function futurio_header_style() {
		$header_image = get_header_image();
		// If no custom options for text are set, let's bail.
		if ( empty( $header_image ) && display_header_text() == true ) {
			return;
		}

		// If we get this far, we have custom styles. Let's do this.
		?>
		<style type="text/css" id="futurio-header-css">
		<?php
		// Has a Custom Header been added?
		if ( !empty( $header_image ) ) :
			?>
				.site-header {
					background-image: url(<?php header_image(); ?>);
					background-repeat: no-repeat;
					background-position: 50% 50%;
					-webkit-background-size: cover;
					-moz-background-size:    cover;
					-o-background-size:      cover;
					background-size:         cover;
				}
		<?php endif; ?>
		<?php
		// Has the text been hidden?
		if ( display_header_text() !== true ) :
			?>
				.site-title,
				.site-description {
					position: absolute;
					clip: rect(1px, 1px, 1px, 1px);
				}
			<?php
		endif;
		?>	
		</style>
		<?php
	}

endif; // futurio_header_style

/**
 * Set Content Width
 */
function futurio_content_width() {

	$content_width = $GLOBALS['content_width'];

	if ( is_active_sidebar( 'futurio-sidebar' ) ) {
		$content_width = 923;
	} else {
		$content_width = 1240;
	}

	/**
	 * Filter content width of the theme.
	 */
	$GLOBALS['content_width'] = apply_filters( 'futurio_content_width', $content_width );
}

add_action( 'template_redirect', 'futurio_content_width', 0 );

/**
 * Enqueue Styles (normal style.css and bootstrap.css)
 */
function futurio_theme_stylesheets() {
	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.css', array(), '3.3.7' );
	// Theme stylesheet.
	wp_enqueue_style( 'futurio-stylesheet', get_stylesheet_uri(), array( 'bootstrap' ), FUTURIO_VERSION );
	// Load Font Awesome css.
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/css/font-awesome.min.css', array(), '4.7.0' );
}

add_action( 'wp_enqueue_scripts', 'futurio_theme_stylesheets' );

/**
 * Register Bootstrap JS with jquery
 */
function futurio_theme_js() {
	wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array( 'jquery' ), '3.3.7', true );
	wp_enqueue_script( 'futurio-theme-js', get_template_directory_uri() . '/js/customscript.js', array( 'jquery' ), FUTURIO_VERSION, true );
}

add_action( 'wp_enqueue_scripts', 'futurio_theme_js' );


/**
 * Register Custom Navigation Walker include custom menu widget to use walkerclass
 */
require_once( trailingslashit( get_template_directory() ) . 'lib/wp_bootstrap_navwalker.php' );

/**
 * Dashboard info
 */
require_once( trailingslashit( get_template_directory() ) . 'lib/dashboard.php' );

/**
 * Recommend plugin
 */
require_once( trailingslashit( get_template_directory() ) . 'lib/customizer-plugin-recommend.php' );

if ( !function_exists( 'futurio_is_extra_activated' ) ) {

	/**
	 * Query Futurio extra activation
	 */
	function futurio_is_extra_activated() {
		return defined( 'FUTURIO_EXTRA_CURRENT_VERSION' ) ? true : false;
	}

}
/**
 * Register TGM Plugin Activation
 */
if ( is_admin() ) {

	require_once( trailingslashit( get_template_directory() ) . 'lib/futurio-plugin-install.php' );
}
add_action( 'widgets_init', 'futurio_widgets_init' );

/**
 * Register the Sidebar(s)
 */
function futurio_widgets_init() {
	register_sidebar(
	array(
		'name'			 => esc_html__( 'Sidebar', 'futurio' ),
		'id'			 => 'futurio-sidebar',
		'before_widget'	 => '<div id="%1$s" class="widget %2$s">',
		'after_widget'	 => '</div>',
		'before_title'	 => '<div class="widget-title"><h3>',
		'after_title'	 => '</h3></div>',
	)
	);
	register_sidebar(
	array(
		'name'			 => esc_html__( 'Archive sidebar', 'futurio' ),
		'id'			 => 'futurio-archive-sidebar',
		'before_widget'	 => '<div id="%1$s" class="widget %2$s">',
		'after_widget'	 => '</div>',
		'before_title'	 => '<div class="widget-title"><h3>',
		'after_title'	 => '</h3></div>',
	)
	);
	register_sidebar(
	array(
		'name'			 => esc_html__( 'Menu Section', 'futurio' ),
		'id'			 => 'futurio-menu-area',
		'before_widget'	 => '<div id="%1$s" class="widget %2$s">',
		'after_widget'	 => '</div>',
		'before_title'	 => '<div class="widget-title"><h3>',
		'after_title'	 => '</h3></div>',
	)
	);
	register_sidebar(
	array(
		'name'			 => esc_html__( 'Footer Section', 'futurio' ),
		'id'			 => 'futurio-footer-area',
		'before_widget'	 => '<div id="%1$s" class="widget %2$s col-md-3">',
		'after_widget'	 => '</div>',
		'before_title'	 => '<div class="widget-title"><h3>',
		'after_title'	 => '</h3></div>',
	)
	);
	if ( class_exists( 'WooCommerce' ) ) {
		register_sidebar(
		array(
			'name'			 => esc_html__( 'WooCommerce Sidebar', 'futurio' ),
			'id'			 => 'futurio-woo-right-sidebar',
			'before_widget'	 => '<div id="%1$s" class="widget %2$s">',
			'after_widget'	 => '</div>',
			'before_title'	 => '<div class="widget-title"><h3>',
			'after_title'	 => '</h3></div>',
		)
		);
		register_sidebar(
		array(
			'name'			 => esc_html__( 'WooCommerce archive sidebar', 'futurio' ),
			'id'			 => 'futurio-woo-archive-sidebar',
			'before_widget'	 => '<div id="%1$s" class="widget %2$s">',
			'after_widget'	 => '</div>',
			'before_title'	 => '<div class="widget-title"><h3>',
			'after_title'	 => '</h3></div>',
		)
		);
	}
}

/**
 * Column width for content function
 */
function futurio_main_content_width_columns() {
	$columns = '12';
	if ( ( is_archive() || is_search() || is_404() ) && is_active_sidebar( 'futurio-archive-sidebar' ) ) {
		$columns = $columns - absint( get_theme_mod( 'sidebar_size', '3' ) );
	} elseif ( is_active_sidebar( 'futurio-sidebar' ) && futurio_get_meta( 'sidebar' ) != 'no_sidebar' ) {
		$columns = $columns - absint( get_theme_mod( 'sidebar_size', '3' ) );
	}
	echo absint( $columns );
}

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function futurio_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">' . "\n", esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}

add_action( 'wp_head', 'futurio_pingback_header' );

if ( !function_exists( 'futurio_entry_footer' ) ) :

	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function futurio_entry_footer() {

		// Get Categories for posts.
		$categories_list = get_the_category_list( ' ' );

		// Get Tags for posts.
		$tags_list = get_the_tag_list( '', ' ' );

		// We don't want to output .entry-footer if it will be empty, so make sure its not.
		if ( $categories_list || $tags_list || get_edit_post_link() ) {

			echo '<div class="entry-footer">';

			if ( 'post' === get_post_type() ) {
				if ( $categories_list || $tags_list ) {

					// Make sure there's more than one category before displaying.
					if ( $categories_list ) {
						echo '<div class="cat-links"><span class="space-right">' . esc_html__( 'Posted in', 'futurio' ) . '</span>' . wp_kses_data( $categories_list ) . '</div>';
					}

					if ( $tags_list ) {
						echo '<div class="tags-links"><span class="space-right">' . esc_html__( 'Tags', 'futurio' ) . '</span>' . wp_kses_data( $tags_list ) . '</div>';
					}
				}
			}

			edit_post_link();

			echo '</div>';
		}
	}

endif;

if ( !function_exists( 'futurio_generate_construct_footer' ) ) :
	/**
	 * Build footer
	 */
	add_action( 'futurio_generate_footer', 'futurio_generate_construct_footer' );

	function futurio_generate_construct_footer() {
		?>
		<div class="footer-credits-text text-center">
			<?php
			/* translators: %s: WordPress name with wordpress.org URL */
			printf( esc_html__( 'Proudly powered by %s', 'futurio' ), '<a href="' . esc_url( __( 'https://wordpress.org/', 'futurio' ) ) . '">WordPress</a>' );
			?>
			<span class="sep"> | </span>
			<?php
			/* translators: %1$s: Futurio name with futuriowp.com URL */
			printf( esc_html__( 'Theme: %1$s', 'futurio' ), '<a href="' . esc_url( 'https://futuriowp.com/' ) . '">Futurio</a>' );
			?>
		</div> 
		<?php
	}

endif;


if ( !function_exists( 'futurio_widget_date_comments' ) ) :

	/**
	 * Returns date for widgets.
	 */
	function futurio_widget_date_comments() {
		if ( get_theme_mod( 'blog_archive_date', 'on' ) == 'on' || is_singular() ) {
			?>
			<div class="date-meta">
				<span class="posted-date-month">	
					<?php echo esc_html( get_the_date( 'M' ) ); ?>
				</span>
				<span class="posted-date-day">
					<?php echo esc_html( get_the_date( 'd' ) ); ?>
				</span>
				<span class="posted-date-year">	
					<?php echo absint( get_the_date( 'Y' ) ); ?>
				</span>
			</div>
		<?php } ?>
		<?php if ( !comments_open() && get_theme_mod( 'blog_archive_comments', 'on' ) == 'on' || !comments_open() && is_singular() ) { ?>
			<div class="comments-meta comments-off">
				<?php esc_html_e( 'Off', 'futurio' ); ?>
				<i class="fa fa-comments-o"></i>
			</div>
		<?php } elseif ( comments_open() && get_theme_mod( 'blog_archive_comments', 'on' ) == 'on' || comments_open() && get_theme_mod( 'blog_archive_comments', 'on' ) == 'off' || is_singular() ) { ?>
			<div class="comments-meta coments-commented">
				<a href="<?php the_permalink(); ?>#comments" rel="nofollow" title="<?php esc_attr_e( 'Comment on ', 'futurio' ) . the_title_attribute(); ?>">
					<?php echo absint( get_comments_number() ); ?>
				</a>
				<i class="fa fa-comments-o"></i>
			</div>
		<?php } ?>
		<?php
	}

endif;

if ( !function_exists( 'futurio_excerpt_length' ) ) :

	/**
	 * Excerpt limit.
	 */
	function futurio_excerpt_length( $length ) {
		if ( is_home() ) { 
			return get_theme_mod( 'blog_archive_excerpt', '35' ); 
		} else { 
			return $length; 
		} 
	}

	add_filter( 'excerpt_length', 'futurio_excerpt_length', 999 );

endif;

if ( !function_exists( 'futurio_excerpt_more' ) ) :

	/**
	 * Excerpt more.
	 */
	function futurio_excerpt_more( $more ) {
		return '&hellip;';
	}

	add_filter( 'excerpt_more', 'futurio_excerpt_more' );

endif;

if ( !function_exists( 'futurio_thumb_img' ) ) :

	/**
	 * Return featured image
	 */
	function futurio_thumb_img( $img = 'full', $col = '', $link = true ) {
		global $post;
		if ( ( has_post_thumbnail( $post->ID ) && $link == true ) ) {
			?>
			<div class="news-thumb <?php echo esc_attr( $col ); ?>">
				<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
					<?php the_post_thumbnail( $img ); ?>
				</a>
			</div><!-- .news-thumb -->
		<?php } elseif ( has_post_thumbnail( $post->ID ) ) { ?>
			<div class="news-thumb <?php echo esc_attr( $col ); ?>">
				<?php the_post_thumbnail( $img ); ?>
			</div><!-- .news-thumb -->
			<?php
		}
	}

endif;

if ( !function_exists( 'futurio_header_thumb_img' ) ) :

	/**
	 * Return header featured image
	 */
	function futurio_header_thumb_img( $img = 'full' ) {
		global $post;

		if ( is_404() ) {
			return;
		}

		if ( get_theme_mod( 'single_featured_image', 'full' ) == 'full' && has_post_thumbnail( $post->ID ) && futurio_get_meta( 'disable_featured_image' ) != 'disable' ) {
			?>	
			<div class="full-head-img container-fluid" style="background-image: url( <?php echo esc_url( get_the_post_thumbnail_url( $post->ID, $img ) ) ?> )">
				<?php if ( get_theme_mod( 'single_title_position', 'full' ) == 'full' ) { ?>
					<?php futurio_header_title() ?>
				<?php } ?>
			</div>
			<?php
		} elseif ( get_theme_mod( 'single_featured_image', 'full' ) == 'full' && !has_post_thumbnail( $post->ID ) && futurio_get_meta( 'disable_featured_image' ) != 'disable' && futurio_get_meta( 'disable_title' ) != 'disable' ) {
			?>	
			<div class="full-head-img container-fluid">
				<?php if ( get_theme_mod( 'single_title_position', 'full' ) == 'full' ) { ?>
					<?php futurio_header_title() ?>
				<?php } ?>
			</div>
			<?php
		} elseif ( get_theme_mod( 'single_title_position', 'full' ) == 'full' && futurio_get_meta( 'disable_title' ) != 'disable' ) {
			?>	
			<div class="full-head-img container-fluid">
				<?php if ( get_theme_mod( 'single_title_position', 'full' ) == 'full' ) { ?>
					<?php futurio_header_title() ?>
				<?php } ?>
			</div>
			<?php
		}
	}

endif;

/**
 * Subtitle for post and page
 */
if ( !function_exists( 'futurio_header_title' ) ) :

	function futurio_header_title() {
		global $post;
		if ( get_theme_mod( 'single_title_position', 'full' ) == 'full' ) {
			?>
			<?php if ( futurio_get_meta( 'disable_title' ) != 'disable' ) { ?>
				<h1 class="single-title container text-center">
					<?php echo esc_html( get_the_title( $post->ID ) ); ?>
				</h1>
				<?php if ( futurio_get_meta( 'subtitle' ) != '' ) { ?>
					<div class="single-subtitle container text-center">
						<?php echo esc_html( futurio_get_meta( 'subtitle', 'echo' ) ); ?>
					</div>
				<?php } ?>
			<?php } ?>
			<?php
		}
	}

endif;

/**
 * Single previous next links
 */
if ( !function_exists( 'futurio_prev_next_links' ) ) :

	function futurio_prev_next_links() {
		the_post_navigation(
		array(
			'prev_text'	 => '<span class="screen-reader-text">' . __( 'Previous Post', 'futurio' ) . '</span><span aria-hidden="true" class="nav-subtitle">' . __( 'Previous', 'futurio' ) . '</span> <span class="nav-title"><span class="nav-title-icon-wrapper"><i class="fa fa-angle-double-left" aria-hidden="true"></i></span>%title</span>',
			'next_text'	 => '<span class="screen-reader-text">' . __( 'Next Post', 'futurio' ) . '</span><span aria-hidden="true" class="nav-subtitle">' . __( 'Next', 'futurio' ) . '</span> <span class="nav-title">%title<span class="nav-title-icon-wrapper"><i class="fa fa-angle-double-right" aria-hidden="true"></i></span></span>',
		)
		);
	}

endif;

/**
 * Post author meta funciton
 */
if ( !function_exists( 'futurio_author_meta' ) ) :

	function futurio_author_meta() {
		?>
		<span class="author-meta">
			<span class="author-meta-by"><?php esc_html_e( 'By', 'futurio' ); ?></span>
			<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) ) ); ?>">
				<?php the_author(); ?>
			</a>
		</span>
		<?php
	}

endif;

if ( class_exists( 'WooCommerce' ) ) {

	if ( !function_exists( 'futurio_cart_link' ) ) {

		function futurio_cart_link() {
			?>	
			<a class="cart-contents" href="<?php echo esc_url( wc_get_cart_url() ); ?>" title="<?php esc_attr_e( 'View your shopping cart', 'futurio' ); ?>">
				<i class="fa fa-<?php echo esc_html( get_theme_mod( 'header_cart_icon', 'shopping-bag' ) ) ?>"><span class="count"><?php echo is_object( WC()->cart ) ? wp_kses_data( WC()->cart->get_cart_contents_count() ) : ''; ?></span></i>
			</a>
			<?php
		}

	}

	if ( !function_exists( 'futurio_header_cart' ) ) {

		function futurio_header_cart() {
			?>
			<div class="header-cart">
				<div class="header-cart-block">
					<div class="header-cart-inner">
						<?php futurio_cart_link(); ?>
						<ul class="site-header-cart menu list-unstyled text-center hidden-xs">
							<li>
								<?php the_widget( 'WC_Widget_Cart', 'title=' ); ?>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<?php
		}

	}

	if ( !function_exists( 'futurio_header_add_to_cart_fragment' ) ) {
		add_filter( 'woocommerce_add_to_cart_fragments', 'futurio_header_add_to_cart_fragment' );

		function futurio_header_add_to_cart_fragment( $fragments ) {
			ob_start();

			futurio_cart_link();

			$fragments[ 'a.cart-contents' ] = ob_get_clean();

			return $fragments;
		}

	}

	if ( !function_exists( 'futurio_my_account' ) ) {

		function futurio_my_account() {
			?>
			<div class="header-my-account">
				<div class="header-login"> 
					<a href="<?php echo esc_url( get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) ); ?>" title="<?php esc_attr_e( 'My Account', 'futurio' ); ?>">
						<i class="fa fa-<?php echo esc_html( get_theme_mod( 'header_my_account_icon', 'user' ) ) ?>"></i>
					</a>
				</div>
			</div>
			<?php
		}

	}

	/**
	 * Column width for woocommerce content function
	 */
	function futurio_main_content_width_woo_columns() {

		$columns = '12';
		if ( ( ( function_exists('is_shop') && is_shop() ) || is_product_tag() || is_product_category() ) && is_active_sidebar( 'futurio-woo-archive-sidebar' ) ) {
			$columns = $columns - absint( get_theme_mod( 'sidebar_size', '3' ) );
		} elseif ( is_active_sidebar( 'futurio-woo-right-sidebar' ) && futurio_get_meta( 'sidebar' ) != 'no_sidebar'  ) {
			$columns = $columns - absint( get_theme_mod( 'sidebar_size', '3' ) );
		}

		echo absint( $columns );
	}

}

if ( !function_exists( 'futurio_breadcrumbs' ) ) {

	function futurio_breadcrumbs() {
		if ( function_exists( 'yoast_breadcrumb' ) ) {
			yoast_breadcrumb( '<div class="container-fluid head-bread" role="main"><div id="breadcrumbs" class="container text-left">', '</div></div>' ); // Yoast breadcrumbs support
		}
	}

}

if ( !function_exists( 'futurio_sidebar_position' ) ) {

	function futurio_sidebar_position( $src = '' ) {
		$position		 = '';
		$content_push	 = get_theme_mod( 'sidebar_size', '3' );
		$sidebar_pull	 = 12 - get_theme_mod( 'sidebar_size', '3' );
		if ( is_active_sidebar( 'futurio-sidebar' ) && futurio_get_meta( 'sidebar' ) != 'right' && futurio_get_meta( 'sidebar' ) != 'no_sidebar' ) {
			if ( $src == 'sidebar' && ( get_theme_mod( 'sidebar_position', 'right' ) == 'left' || futurio_get_meta( 'sidebar' ) == 'left' ) ) {
				$position = 'col-md-pull-' . absint( $sidebar_pull );
				echo esc_html( $position );
			}
			if ( $src == 'content' && ( get_theme_mod( 'sidebar_position', 'right' ) == 'left' || futurio_get_meta( 'sidebar' ) == 'left' ) ) {
				$position = 'col-md-push-' . absint( $content_push );
				echo esc_html( $position );
			}
		}
		if ( is_active_sidebar( 'futurio-woo-right-sidebar' ) && class_exists( 'WooCommerce' ) && futurio_get_meta( 'sidebar' ) != 'right' && futurio_get_meta( 'sidebar' ) != 'no_sidebar' ) {
			if ( $src == 'sidebar-woo' && ( get_theme_mod( 'sidebar_position', 'right' ) == 'left' || futurio_get_meta( 'sidebar' ) == 'left' ) ) {
				$position = 'col-md-pull-' . absint( $sidebar_pull );
				echo esc_html( $position );
			}
			if ( $src == 'content-woo' && ( get_theme_mod( 'sidebar_position', 'right' ) == 'left' || futurio_get_meta( 'sidebar' ) == 'left' ) ) {
				$position = 'col-md-push-' . absint( $content_push );
				echo esc_html( $position );
			}
		}
	}

}

if ( !function_exists( 'futurio_content_layout' ) ) :

	/**
	 * Content layout
	 */
	function futurio_content_layout() {
		if ( futurio_get_meta( 'content_layout' ) ) {
			if ( futurio_get_meta( 'content_layout' ) == 'fullwidth' ) {
				?>
				<div class="container-fluid main-container" role="main">
					<div class="page-area">
			<?php } elseif ( futurio_get_meta( 'content_layout' ) == 'fullwidth_builders' ) { ?>
				<div class="container-fluid main-container page-builders" role="main">
					<div class="page-area">		
			<?php } else { ?>
				<div class="container main-container" role="main">
					<div class="page-area">		
			<?php
			}
		} else {
	?>
	<div class="container main-container" role="main">
		<div class="page-area">
			<?php
		}
	}

endif;

if ( !function_exists( 'futurio_get_meta' ) ) :

	/**
	 * Meta
	 */
	function futurio_get_meta( $name = '', $output = '' ) {
	if ( is_singular() || ( function_exists('is_shop') && is_shop() ) ) {
			global $post;
			if( function_exists('is_shop') && is_shop() ) {
				$post_id = get_option( 'woocommerce_shop_page_id' );
			} else {
				$post_id = $post->ID;
			}
			$meta = get_post_meta( $post_id, 'futurio_meta_' . $name, true );
			if ( isset( $meta ) && $meta != '' ) {
				if ( $output == 'echo' ) {
					echo esc_html( $meta );
				} else {
					return $meta;
				}
			} else {
				return;
			}
		}
	}

endif;

function futurio_check_elementor() { 
	if ( in_array( 'elementor/elementor.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
		return true;
	}
	return false;
}

if ( !function_exists( 'futurio_generate_header' ) ) :

	/**
	 * Generate header
	 */
	function futurio_generate_header( $topnav = '', $header = '', $mainmenu = '', $thumbimg = '', $breadcrumbs = '', $openingdiv = '' ) {
		if ( futurio_get_meta( 'disable_top_bar' ) != 'disable' && $topnav ) {
			get_template_part( 'template-parts/template-part', 'topnav' );
		}
		if ( get_theme_mod( 'custom_header', '' ) != '' && futurio_check_elementor() ) {
			if ( futurio_get_meta( 'disable_elementor_header' ) != 'disable' ) {
				$elementor_section_ID = get_theme_mod( 'custom_header', '' );
				echo do_shortcode( '[elementor-template id="' . $elementor_section_ID . '"]' );
			}
		} else {
			if ( futurio_get_meta( 'disable_header' ) != 'disable' && $header ) {
				get_template_part( 'template-parts/template-part', 'header' );
			}
			if ( futurio_get_meta( 'disable_main_menu' ) != 'disable' && $mainmenu ) {
				get_template_part( 'template-parts/template-part', 'mainmenu' );
			}
		}
		if ( $thumbimg ) {
			futurio_header_thumb_img();
		}
		if ( futurio_get_meta( 'disable_breadcrumbs' ) != 'disable' && $breadcrumbs ) {
			futurio_breadcrumbs();
		}
		if ( $openingdiv ) {
			futurio_content_layout();
		}
	}

endif;

if ( ! function_exists( 'wp_body_open' ) ) :
    /**
     * Fire the wp_body_open action.
     *
     * Added for backwards compatibility to support pre 5.2.0 WordPress versions.
     *
     */
    function wp_body_open() {
        /**
         * Triggered after the opening <body> tag.
         *
         */
        do_action( 'wp_body_open' );
    }
endif;

if ( !function_exists( 'futurio_site_content_div' ) ) :
    /**
     * Build footer
     */
    add_action( 'futurio_after_menu', 'futurio_site_content_div' );

    function futurio_site_content_div() {
            ?>
            <div id="site-content"></div>
            <?php
    }

endif;

/**
 * Include a skip to content link at the top of the page so that users can bypass the header.
 */
function futurio_skip_link() {
    echo '<a class="skip-link screen-reader-text" href="#site-content">' . esc_html__( 'Skip to the content', 'futurio' ) . '</a>';
}

add_action( 'wp_body_open', 'futurio_skip_link', 5 );

/**
 * Add No-JS Class.
 * If we're missing JavaScript support, the HTML element will have a no-js class.
 */
function futurio_no_js_class() {

	?>
	<script>document.documentElement.className = document.documentElement.className.replace( 'no-js', 'js' );</script>
	<?php

}

add_action( 'wp_head', 'futurio_no_js_class' );