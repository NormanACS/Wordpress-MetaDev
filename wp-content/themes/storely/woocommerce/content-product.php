<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}
?>

<li <?php wc_product_class( '', $product ); ?>>
	<div class="product">
		<div class="product-single">
			<div class="product-img">
				<?php
					/**
					 * Hook: woocommerce_before_shop_loop_item.
					 *
					 * @hooked woocommerce_template_loop_product_link_open - 10
					 */
					do_action( 'woocommerce_before_shop_loop_item' );
				?>
					<a href="<?php echo esc_url(the_permalink()); ?>" class="woocommerce-LoopProduct-link woocommerce-loop-product__link"></a>
					<a href="<?php echo esc_url(the_permalink()); ?>">
						<?php the_post_thumbnail(); ?>
					</a>
					<?php 
					if ( $product->is_on_sale() ) : 
						 echo apply_filters( 'woocommerce_sale_flash', '<div class="sale-ribbon"><span class="tag-line">' . esc_html__( 'Sale', 'storely' ) . '</span></div>', $post, $product ); 
					 endif; 
				
					$attachment_ids = $product->get_gallery_image_ids();
					if(!empty($attachment_ids)):
						foreach( $attachment_ids as $i=> $attachment_id ) {
						$image_url2 = wp_get_attachment_url( $attachment_id );
						if($i==0):
				?>
					<a href="<?php the_permalink(); ?>">
						<img width="801" height="801" src="<?php  echo esc_url($image_url2); ?>" class="info attachment-post-thumbnail size-post-thumbnail wp-post-image" alt="" />
					</a>
				<?php endif; } else: ?>
					<a href="<?php the_permalink(); ?>">
						<img width="801" height="801" src="<?php the_post_thumbnail_url(); ?>" class="info attachment-post-thumbnail size-post-thumbnail wp-post-image" alt="" />
					</a>
				<?php endif; ?>
			</div>
			<div class="product-content-outer">
				<div class="product-content">
					<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
					<?php $product_instance = wc_get_product($product);
								echo wp_kses_post($product_instance->get_short_description()); ?>
						<?php do_action( 'woocommerce_after_shop_loop_item_title' ); ?>
					<div class="pro-rating"></div>
				</div>
				<div class="product-action">
					<?php
					/**
					 * Hook: woocommerce_after_shop_loop_item.
					 *
					 * @hooked woocommerce_template_loop_product_link_close - 5
					 * @hooked woocommerce_template_loop_add_to_cart - 10
					 */
					 do_action( 'woocommerce_after_shop_loop_item' ); 
					?>
				</div>
			</div>
		</div>
	</div>
</li>
