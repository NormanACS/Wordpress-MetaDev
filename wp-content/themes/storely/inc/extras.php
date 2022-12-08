<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Storely
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function storely_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}
	
	return $classes;
}
add_filter( 'body_class', 'storely_body_classes' );



if ( ! function_exists( 'wp_body_open' ) ) {
	/**
	 * Backward compatibility for wp_body_open hook.
	 *
	 * @since 1.0
	 */
	function wp_body_open() {
		do_action( 'wp_body_open' );
	}
}

if (!function_exists('storely_str_replace_assoc')) {

    /**
     * storely_str_replace_assoc
     * @param  array $replace
     * @param  array $subject
     * @return array
     */
    function storely_str_replace_assoc(array $replace, $subject) {
        return str_replace(array_keys($replace), array_values($replace), $subject);
    }
}

// Comments Counts
if ( ! function_exists( 'storely_comment_count' ) ) :
function storely_comment_count() {
	$storely_comments_count 	= get_comments_number();
	if ( 0 === intval( $storely_comments_count ) ) {
		echo esc_html__( '0 Comments', 'storely' );
	} else {
		/* translators: %s Comment number */
		 echo sprintf( _n( '%s Comment', '%s Comments', $storely_comments_count, 'storely' ), number_format_i18n( $storely_comments_count ) );
	}
} 
endif;



/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */

function storely_widgets_init() {	
	register_sidebar( array(
		'name' => __( 'Header Widget Area', 'storely' ),
		'id' => 'storely-header-above-first',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h5 class="widget-title">',
		'after_title' => '</h5>',
	) );
	
	register_sidebar( array(
		'name' => __( 'Sidebar Widget Area', 'storely' ),
		'id' => 'storely-sidebar-primary',
		'description' => __( 'The Primary Widget Area', 'storely' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h4 class="widget-title"><span></span>',
		'after_title' => '</h4>',
	) );
	
	
	register_sidebar( array(
		'name' => __( 'Footer Widget', 'storely' ),
		'id' => 'storely-footer-widget',
		'description' => __( 'Footer Widget', 'storely' ),
		'before_widget' => '<div class="col-lg-4 col-md-6 col-12"><aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside></div>',
		'before_title' => '<h4 class="widget-title">',
		'after_title' => '</h4>',
	) );
	
	register_sidebar( array(
		'name' => __( 'WooCommerce Widget Area', 'storely' ),
		'id' => 'storely-woocommerce-sidebar',
		'description' => __( 'This Widget area for WooCommerce Widget', 'storely' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h4 class="widget-title">',
		'after_title' => '</h4>',
	) );
}
add_action( 'widgets_init', 'storely_widgets_init' );


 /**
 * Add WooCommerce Cart Icon With Cart Count (https://isabelcastillo.com/woocommerce-cart-icon-count-theme-header)
 */
function storely_add_to_cart_count_fragment( $fragments ) {
	
    ob_start();
    $count = WC()->cart->cart_contents_count; 
    ?> 	
	<?php
    if ( $count > 0 ) {
	?>
		 <span class="cart-count"><?php echo esc_html( $count ); ?></span>
	<?php 
	}
	else {
		?>
		<span class="cart-count"><?php echo esc_html_e('0','storely')?></span>
		<?php 
	}
    ?><?php
 
    $fragments['span.cart-count'] = ob_get_clean();
     
    return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'storely_add_to_cart_count_fragment' );


function storely_add_to_cart_total_fragment( $fragments ) {
	
    ob_start(); 
    ?> 	
	<span class="cart-label">
		<span><?php echo wp_kses_post(WC()->cart->get_cart_subtotal()); ?></span>
	</span>
   <?php
    $fragments['span.cart-label'] = ob_get_clean();
     
    return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'storely_add_to_cart_total_fragment' );
 



/**
 * This Function Check whether Sidebar active or Not
 */
if(!function_exists( 'storely_blog_column_layout' )) :
function storely_blog_column_layout(){
	if(is_active_sidebar('storely-sidebar-primary'))
		{ echo 'col-lg-9'; } 
	else 
		{ echo 'col-lg-12'; }  
} endif;



/**
 * Storely Breadcrumb
 */
 function storely_breadcrumbs_list() {
	
	$showOnHome	= esc_html__('1','storely'); 	// 1 - Show breadcrumbs on the homepage, 0 - don't show
	$delimiter 	= '';   // Delimiter between breadcrumb
	$home 		= esc_html__('Home','storely'); 	// Text for the 'Home' link
	$showCurrent= esc_html__('1','storely'); // Current post/page title in breadcrumb in use 1, Use 0 for don't show
	$before		= '<li class="active">'; // Tag before the current Breadcrumb
	$after 		= '</li>'; // Tag after the current Breadcrumb
	$breadcrumb_middle_content	= '-';
	global $post;
	$homeLink = home_url();

	if (is_home() || is_front_page()) {
 
	if ($showOnHome == 1) echo '<li><a href="' . esc_url($homeLink) . '"><i class="fa fa-home"></i>  ' . esc_html($home) . '</a></li>';
 
	} else {
 
    echo '<li><a href="' . esc_url($homeLink) . '"><i class="fa fa-home"></i>  ' . esc_html($home) . '</a> ' . '&nbsp' . wp_kses_post($breadcrumb_middle_content) . '&nbsp';
 
    if ( is_category() ) 
	{
		$thisCat = get_category(get_query_var('cat'), false);
		if ($thisCat->parent != 0) echo get_category_parents($thisCat->parent, TRUE, ' ' . ' ');
		echo $before . esc_html__('Archive by category','storely').' "' . esc_html(single_cat_title('', false)) . '"' .$after;
		
	} 
	
	elseif ( is_search() ) 
	{
		echo $before . esc_html__('Search results for ','storely').' "' . esc_html(get_search_query()) . '"' . $after;
	} 
	
	elseif ( is_day() )
	{
		echo '<a href="' . esc_url(get_year_link(get_the_time('Y'))) . '">' . esc_html(get_the_time('Y')) . '</a> ' . '&nbsp' . wp_kses_post($breadcrumb_middle_content) . '&nbsp';
		echo '<a href="' . esc_url(get_month_link(get_the_time('Y'),get_the_time('m'))) . '">' . esc_html(get_the_time('F')) . '</a> '. '&nbsp' . wp_kses_post($breadcrumb_middle_content) . '&nbsp';
		echo $before . esc_html(get_the_time('d')) . $after;
	} 
	
	elseif ( is_month() )
	{
		echo '<a href="' . esc_url(get_year_link(get_the_time('Y'))) . '">' . esc_html(get_the_time('Y')) . '</a> ' . esc_attr($delimiter) . '&nbsp' . wp_kses_post($breadcrumb_middle_content) . '&nbsp';
		echo $before . esc_html(get_the_time('F')) . $after;
	} 
	
	elseif ( is_year() )
	{
		echo $before . esc_html(get_the_time('Y')) . $after;
	} 
	
	elseif ( is_single() && !is_attachment() )
	{
		if ( get_post_type() != 'post' )
		{
			$post_type = get_post_type_object(get_post_type());
			$slug = $post_type->rewrite;
			echo '<a href="' . esc_url($homeLink) . '/' . $slug['slug'] . '/"><i class="fa fa-home"></i>  ' . $post_type->labels->singular_name . '</a>';
			if ($showCurrent == 1) echo ' ' . esc_attr($delimiter) . '&nbsp' . wp_kses_post($breadcrumb_middle_content) . '&nbsp' . $before . wp_kses_post(get_the_title()) . $after;
		}
		else
		{
			$cat = get_the_category(); 
			if(!empty($cat)):
				$cat = $cat[0];
				$cats = get_category_parents($cat, TRUE, ' ' . esc_attr($delimiter) . '&nbsp' . wp_kses_post($breadcrumb_middle_content) . '&nbsp');
				if ($showCurrent == 0) $cats = preg_replace("#^(.+)\s$delimiter\s$#", "$1", $cats);
				echo $cats;
			endif;
			if ($showCurrent == 1) echo $before . esc_html(get_the_title()) . $after;
		}
 
    }
		
	elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
		if ( class_exists( 'WooCommerce' ) ) {
			if ( is_shop() ) {
				$thisshop = woocommerce_page_title();
			}
		}	
		else  {
			$post_type = get_post_type_object(get_post_type());
			echo $before . $post_type->labels->singular_name . $after;
		}	
	} 
	
	elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) 
	{
		$post_type = get_post_type_object(get_post_type());
		echo $before . $post_type->labels->singular_name . $after;
	} 
	
	elseif ( is_attachment() ) 
	{
		$parent = get_post($post->post_parent);
		$cat = get_the_category($parent->ID); 
		if(!empty($cat)){
		$cat = $cat[0];
		echo get_category_parents($cat, TRUE, ' ' . esc_attr($delimiter) . '&nbsp' . wp_kses_post($breadcrumb_middle_content) . '&nbsp');
		}
		echo '<a href="' . esc_url(get_permalink($parent)) . '">' . $parent->post_title . '</a>';
		if ($showCurrent == 1) echo ' ' . esc_attr($delimiter) . ' ' . $before . esc_html(get_the_title()) . $after;
 
    } 
	
	elseif ( is_page() && !$post->post_parent ) 
	{
		if ($showCurrent == 1) echo $before . esc_html(get_the_title()) . $after;
	} 
	
	elseif ( is_page() && $post->post_parent ) 
	{
		$parent_id  = $post->post_parent;
		$breadcrumbs = array();
		while ($parent_id) 
		{
			$page = get_page($parent_id);
			$breadcrumbs[] = '<a href="' . esc_url(get_permalink($page->ID)) . '">' . esc_html(get_the_title($page->ID)) . '</a>' . '&nbsp' . wp_kses_post($breadcrumb_middle_content) . '&nbsp';
			$parent_id  = $page->post_parent;
		}
		
		$breadcrumbs = array_reverse($breadcrumbs);
		for ($i = 0; $i < count($breadcrumbs); $i++) 
		{
			echo $breadcrumbs[$i];
			if ($i != count($breadcrumbs)-1) echo ' ' . esc_attr($delimiter) . '&nbsp' . wp_kses_post($breadcrumb_middle_content) . '&nbsp';
		}
		if ($showCurrent == 1) echo ' ' . esc_attr($delimiter) . ' ' . $before . esc_html(get_the_title()) . $after;
 
    } 
	elseif ( is_tag() ) 
	{
		echo $before . esc_html__('Posts tagged ','storely').' "' . esc_html(single_tag_title('', false)) . '"' . $after;
	} 
	
	elseif ( is_author() ) {
		global $author;
		$userdata = get_userdata($author);
		echo $before . esc_html__('Articles posted by ','storely').'' . $userdata->display_name . $after;
	} 
	
	elseif ( is_404() ) {
		echo $before . esc_html__('Error 404 ','storely'). $after;
    }
	
    if ( get_query_var('paged') ) {
		if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo '';
		echo ' ( ' . esc_html__('Page','storely') . '' . esc_html(get_query_var('paged')). ' )';
		if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo '';
    }
 
    echo '</li>';
 
  }
}
 
 
 
 /**
 * Storely Logo
 */
if ( ! function_exists( 'storely_logo' ) ) {
	function storely_logo() {
		if(has_custom_logo())
			{	
				the_custom_logo();
			}
			else { 
			?>
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
				<h4 class="site-title">
					<?php 
						echo esc_html(get_bloginfo('name'));
					?>
				</h4>
			</a>	
		<?php 						
			}
		?>
		<?php
			$storely_description = get_bloginfo( 'description');
			if ($storely_description) : ?>
				<p class="site-description"><?php echo esc_html($storely_description); ?></p>
		<?php endif;
	}
}
add_action( 'storely_logo', 'storely_logo' );



/**
 * Storely Navigation
 */
if ( ! function_exists( 'storely_main_nav' ) ) {
	function storely_main_nav() {
		wp_nav_menu( 
			array(  
				'theme_location' => 'primary_menu',
				'container'  => '',
				'menu_class' => 'main-menu menu-primary',
				'fallback_cb' => 'WP_Bootstrap_Navwalker::fallback',
				'walker' => new WP_Bootstrap_Navwalker()
				 ) 
			);
	}
}
add_action( 'storely_main_nav', 'storely_main_nav' );



/**
 * Storely Header My Account
 */
if ( ! function_exists( 'storely_hdr_account' ) ) {
	function storely_hdr_account() {
		$storely_hide_show_acc = get_theme_mod( 'hide_show_account','1');
		if($storely_hide_show_acc=='1'  && class_exists( 'woocommerce' )): ?>
			<li class="user">
				<a href="<?php echo esc_url(get_permalink( get_option('woocommerce_myaccount_page_id') )); ?>" class="user-btn"><i class="fa fa-user"></i></a>
			</li>
		<?php endif;
	}
}
add_action( 'storely_hdr_account', 'storely_hdr_account' );



/**
 * Storely Header Cart
 */
if ( ! function_exists( 'storely_hdr_cart' ) ) {
	function storely_hdr_cart() {
		$storely_hide_show_cart = get_theme_mod( 'hide_show_cart','1');
		if($storely_hide_show_cart=='1' && class_exists( 'woocommerce' )): ?>
			<li class="cart-wrapper">
				<div class="cart-main">
					<button type="button" class="cart-icon-wrap header-cart cart-trigger">
						<i class="fa fa-shopping-cart"></i>
						<?php 
							if ( class_exists( 'woocommerce' ) ) {
								$count = WC()->cart->cart_contents_count;
								if ( $count > 0 ) {
								?>
									 <span class="cart-count"><?php echo esc_html( $count ); ?></span>
								<?php 
								}
								else {
									?>
									<span class="cart-count"><?php echo esc_html_e('0','storely')?></span>
									<?php 
								}
							}
							?>
					</button>
					<span class="cart-label">
						<span><?php echo wp_kses_post(WC()->cart->get_cart_subtotal()); ?></span>
					</span>
				</div>
				<div class="cart-modal cart-modal-1">
					<div class="cart-container">
						<div class="cart-header">
							<div class="cart-top">
								<span class="cart-text"><?php echo esc_html_e('Shopping Cart','storely'); ?></span>
								<a href="javascript:void(0);" class="cart-close"><?php echo esc_html_e('CLOSE','storely'); ?></a>
							</div>
						</div>
						<div class="cart-data">
							<?php get_template_part('woocommerce/cart/mini','cart'); ?>
						</div>	
					</div>
					<div class="cart-overlay"></div>
				</div>
			</li>
			<?php endif;
	}
}
add_action( 'storely_hdr_cart', 'storely_hdr_cart' );




/**
 * Storely Browse Category
 */
if ( ! function_exists( 'storely_hdr_browse_cat' ) ) {
	function storely_hdr_browse_cat() {
		$storely_browse_cat_ttl		= get_theme_mod( 'browse_cat_ttl');
		?>
		<?php if(!empty($storely_browse_cat_ttl)): ?>
			<button type="button" class="product-category-btn"><span><?php echo wp_kses_post($storely_browse_cat_ttl); ?></span></button>
		<?php else: ?>
			<button type="button" class="product-category-btn"><span><i class="fa fa-list-ul"></i> <?php echo esc_html_e('Browse Categories','storely'); ?></span></button>
		<?php endif; ?>	
		<div class="product-category-menus">
			<div class="product-category-menus-list">
				<ul class="main-menu">
					<?php
						$storely_product_categories = array(
							  'taxonomy' => 'product_cat',
							  'hide_empty' => false,
							  'parent'   => 0
						  );
						$storely_product_cat = get_terms( $storely_product_categories );
						foreach ($storely_product_cat as $parent_product_cat) {
							$child_args = array(
								'taxonomy' => 'product_cat',
								'hide_empty' => false,
								'parent'   => $parent_product_cat->term_id
							);
							$thumbnail_id = get_term_meta( $parent_product_cat->term_id, 'thumbnail_id', true );
							$image = wp_get_attachment_url( $thumbnail_id );
							$child_product_cats = get_terms( $child_args );
							$storely_product_cat_icon = get_term_meta($parent_product_cat->term_id, 'storely_product_cat_icon', true);
							if ( ! empty($child_product_cats) ) {
								echo '<li class="menu-item menu-item-has-children"><a href="'.esc_url(get_term_link($parent_product_cat->term_id)).'" class="nav-link">'.(!empty($storely_product_cat_icon) ? "<i class='fa {$storely_product_cat_icon}'></i>":''); echo esc_html($parent_product_cat->name).'</a>';
							} else {
								echo '<li class="menu-item"><a href="'.esc_url(get_term_link($parent_product_cat->term_id)).'" class="nav-link">'.(!empty($storely_product_cat_icon) ? "<i class='fa {$storely_product_cat_icon}'></i>":''); echo esc_html($parent_product_cat->name).'</a>';
							}
							if ( ! empty($child_product_cats) ) {
								echo '<ul class="dropdown-menu">';
								foreach ($child_product_cats as $child_product_cat) {
								echo '<li class="menu-item"><a href="'.esc_url(get_term_link($child_product_cat->term_id)).'" class="dropdown-item">'.esc_html($child_product_cat->name).'</a></li>';
								} echo '</ul>';
							} echo '</li>';
						} ?>
				</ul>
			</div>
		</div>
		<?php
	}
}
add_action( 'storely_hdr_browse_cat', 'storely_hdr_browse_cat' );




/**
 * Storely Mobile Browse Category
 */
if ( ! function_exists( 'storely_hdr_mobile_browse_cat' ) ) {
	function storely_hdr_mobile_browse_cat() {
		$storely_hs_browse_cat		= get_theme_mod( 'hs_browse_cat','1');
		$storely_browse_cat_ttl		= get_theme_mod( 'browse_cat_ttl');
		if($storely_hs_browse_cat=='1' && class_exists( 'woocommerce' )):
		?>
			<div class="switcher-tab">
				<button class="active-bg"><?php echo esc_html_e('Menu','storely');?></button>
				<?php if(!empty($storely_browse_cat_ttl)): ?>
					<button class="cat-menu-bt"><?php echo wp_kses_post($storely_browse_cat_ttl); ?></button>
				<?php else: ?>
					<button class="cat-menu-bt"><i class="fa fa-list-ul"></i> <?php echo esc_html_e('Browse Categories','storely'); ?></button>
				<?php endif; ?>	
			</div>
			<div class="product-categories d-none">
				<div class="product-categories-list">
					<ul class="main-menu">
						<?php
							$storely_product_categories = array(
								  'taxonomy' => 'product_cat',
								  'hide_empty' => false,
								  'parent'   => 0
							  );
							$storely_product_cat = get_terms( $storely_product_categories );
							foreach ($storely_product_cat as $parent_product_cat) {
								$child_args = array(
									'taxonomy' => 'product_cat',
									'hide_empty' => false,
									'parent'   => $parent_product_cat->term_id
								);
								$thumbnail_id = get_term_meta( $parent_product_cat->term_id, 'thumbnail_id', true );
								$image = wp_get_attachment_url( $thumbnail_id );
								$child_product_cats = get_terms( $child_args );
								$storely_product_cat_icon = get_term_meta($parent_product_cat->term_id, 'storely_product_cat_icon', true);
								if ( ! empty($child_product_cats) ) {
									echo '<li class="menu-item menu-item-has-children"><a href="'.esc_url(get_term_link($parent_product_cat->term_id)).'" class="nav-link">'.(!empty($storely_product_cat_icon) ? "<i class='fa {$storely_product_cat_icon}'></i>":''); echo esc_html($parent_product_cat->name).'</a><span class="mobile-collapsed d-lg-none"><button type="button" class="fa fa-chevron-right" aria-label="Mobile Collapsed"></button></span>';
								} else {
									echo '<li class="menu-item"><a href="'.esc_url(get_term_link($parent_product_cat->term_id)).'" class="nav-link">'.(!empty($storely_product_cat_icon) ? "<i class='fa {$storely_product_cat_icon}'></i>":''); echo esc_html($parent_product_cat->name).'</a>';
								}
								if ( ! empty($child_product_cats) ) {
									echo '<ul class="dropdown-menu">';
									foreach ($child_product_cats as $child_product_cat) {
									echo '<li class="menu-item"><a href="'.esc_url(get_term_link($child_product_cat->term_id)).'" class="dropdown-item">'.esc_html($child_product_cat->name).'</a></li>';
									} echo '</ul>';
								} echo '</li>';
							} ?>
					</ul>
				</div>
			</div>
		<?php endif;
	}
}
add_action( 'storely_hdr_mobile_browse_cat', 'storely_hdr_mobile_browse_cat' );




/**
 * Storely Product Search
 */
if ( ! function_exists( 'storely_hdr_product_search' ) ) {
	function storely_hdr_product_search() {
		$storely_hs_product_search	= get_theme_mod( 'hs_product_search','1'); 
		 if($storely_hs_product_search=='1'): ?>
			<div class="header-search-form">
				<form method="get" action="<?php echo esc_url(home_url('/')); ?>">
					<input type="hidden" name="post_type" value="product" />
					<input class="header-search-input" name="s" type="text"
						placeholder="<?php esc_attr_e('Search Products Here', 'storely'); ?>" />
					<select class="header-search-select" name="product_cat">
					   <option value=""><?php esc_html_e('Select Category', 'storely'); ?></option> 
						<?php
							$storely_product_categories = get_categories('taxonomy=product_cat');
							foreach ($storely_product_categories as $category) {
								$option = '<option value="' . esc_attr($category->category_nicename) . '">';
								$option .= esc_html($category->cat_name);
								$option .= ' (' . absint($category->category_count) . ')';
								$option .= '</option>';
								echo $option; // WPCS: XSS OK.
							}
						?>
					</select>
					<input type="hidden" name="post_type" value="product" />
					<button class="header-search-button" type="submit"><i class="fa fa-search"></i></button>
				</form>
			</div>
		<?php endif;
	}
}
add_action( 'storely_hdr_product_search', 'storely_hdr_product_search' );