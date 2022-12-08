<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Storely
 */

if ( ! function_exists( 'storely_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function storely_posted_on() {
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
		esc_html_x( 'Posted on %s', 'post date', 'storely' ),
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
	);

	$byline = sprintf(
		esc_html_x( 'by %s', 'post author', 'storely' ),
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
	);
	echo '<span class="posted-on">' . $posted_on . '</span><span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.
}
endif;

if ( ! function_exists( 'storely_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function storely_entry_footer() {
	// Hide category and tag text for pages.
	if ( 'post' === get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( esc_html__( ', ', 'storely' ) );
		if ( $categories_list && storely_categorized_blog() ) {
			printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'storely' ) . '</span>', $categories_list ); // WPCS: XSS OK.
		}

		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', esc_html__( ', ', 'storely' ) );
		if ( $tags_list ) {
			printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'storely' ) . '</span>', $tags_list ); // WPCS: XSS OK.
		}
	}

	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">';
		/* translators: %s: post title */
		comments_popup_link( sprintf( wp_kses( __( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'storely' ), array( 'span' => array( 'class' => array() ) ) ), get_the_title() ) );
		echo '</span>';
	}

	edit_post_link(
		sprintf(
			/* translators: %s: Name of current post */
			esc_html__( 'Edit %s', 'storely' ),
			the_title( '<span class="screen-reader-text">"', '"</span>', false )
		),
		'<span class="edit-link">',
		'</span>'
	);
}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function storely_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'storely_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,
			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'storely_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so storely_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so storely_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in storely_categorized_blog.
 */
function storely_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'storely_categories' );
}
add_action( 'edit_category', 'storely_category_transient_flusher' );
add_action( 'save_post',     'storely_category_transient_flusher' );


/**
 * Function that returns if the menu is sticky
 */
if (!function_exists('storely_sticky_menu')):
    function storely_sticky_menu()
    {
        $is_sticky = get_theme_mod('hide_show_sticky','1');

        if ($is_sticky == '1'):
            return 'is-sticky-on';
        else:
            return 'not-sticky';
        endif;
    }
endif;


/**
 * Register Google fonts for storely.
 */
function storely_google_font() {
	
    $get_fonts_url = '';
		
    $font_families = array();
 
	$font_families = array('Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900');
 
        $query_args = array(
            'family' => urlencode( implode( '|', $font_families ) ),
            'subset' => urlencode( 'latin,latin-ext' ),
        );
 
        $get_fonts_url = add_query_arg( $query_args, '//fonts.googleapis.com/css' );

    return $get_fonts_url;
}

function storely_scripts_styles() {
    wp_enqueue_style( 'storely-fonts', storely_google_font(), array(), null );
}
add_action( 'wp_enqueue_scripts', 'storely_scripts_styles' );


/**
 * Register Breadcrumb for Multiple Variation
 */
function storely_breadcrumbs_content() {
	$storely_hs_breadcrumb					= get_theme_mod('hs_breadcrumb','1');
	if($storely_hs_breadcrumb == '1') {	
	?>
	<div id="breadcrumb-section" class="breadcrumb-area breadcrumb-left">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="breadcrumb-content">
						<div class="breadcrumb-heading">
							<h3>
								<?php 
									if ( is_home() || is_front_page()):

										single_post_title();
								
									elseif ( is_day() ) : 
									
										printf( __( 'Daily Archives: %s', 'storely' ), get_the_date() );
									
									elseif ( is_month() ) :
									
										printf( __( 'Monthly Archives: %s', 'storely' ), (get_the_date( 'F Y' ) ));
										
									elseif ( is_year() ) :
									
										printf( __( 'Yearly Archives: %s', 'storely' ), (get_the_date( 'Y' ) ) );
										
									elseif ( is_category() ) :
									
										printf( __( 'Category Archives: %s', 'storely' ), (single_cat_title( '', false ) ));

									elseif ( is_tag() ) :
									
										printf( __( 'Tag Archives: %s', 'storely' ), (single_tag_title( '', false ) ));
										
									elseif ( is_404() ) :

										printf( __( 'Error 404', 'storely' ));
										
									elseif ( is_author() ) :
									
										printf( __( 'Author: %s', 'storely' ), (get_the_author( '', false ) ));		
									
									elseif ( class_exists( 'woocommerce' ) ) : 
										
										if ( is_shop() ) {
											woocommerce_page_title();
										}
										
										elseif ( is_cart() ) {
											the_title();
										}
										
										elseif ( is_checkout() ) {
											the_title();
										}
										
										else {
											the_title();
										}
									else :
											the_title();
											
									endif;
										
								?>
							</h3>  	
						</div>
						<ol class="breadcrumb-list">
							<?php if (function_exists('storely_breadcrumbs_list')) storely_breadcrumbs_list();?>
						</ol> 				
					</div>                    
				</div>
			</div>
		</div>
	</div>
	<?php }			
}