<?php
/**
 * Mini-cart
 *
 * Contains the markup for the mini-cart, used by the cart widget.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/mini-cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 5.2.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_mini_cart' ); ?>

<?php if ( ! WC()->cart->is_empty() ) : ?>
	<div class="cart-body">
       <div class="cart-products woocommerce-mini-cart cart_list product_list_widget cart-items">
		<?php
		do_action( 'woocommerce_before_mini_cart_contents' );

		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
			$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
			$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

			if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
				$product_name      = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );
				$thumbnail         = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
				$product_price     = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
				$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
				?>
				<div class="cart-product woocommerce-mini-cart-item <?php echo esc_attr( apply_filters( 'woocommerce_mini_cart_item_class', 'mini_cart_item', $cart_item, $cart_item_key ) ); ?>">
					<?php
					echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
						'woocommerce_cart_item_remove_link',
						sprintf(
							'<div class="cart-img-col"><a href="%s" class="remove remove_from_cart_button" aria-label="%s" data-product_id="%s" data-cart_item_key="%s" data-product_sku="%s">&times;</a><a href="<?php echo esc_url( $product_permalink ); ?>">'."$thumbnail".'</a></div>',
							esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
							esc_attr__( 'Remove this item', 'storely' ),
							esc_attr( $product_id ),
							esc_attr( $cart_item_key ),
							esc_attr( $_product->get_sku() )
						),
						$cart_item_key
					);
					?>
					
					 <div class="cart-sum-col">
						<div class="cart-sm-info">
							<div class="cart-sm-left">
								<?php if ( empty( $product_permalink ) ) : ?>
									<span class="cart-pname">
										<?php echo $product_name; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
									</span>
								<?php else : ?>
									<span class="cart-pname">
										<a href="<?php echo esc_url( $product_permalink ); ?>">
										<?php echo $product_name; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
										</a>
									</span>
								<?php endif; ?>
								<?php echo wc_get_formatted_cart_item_data( $cart_item ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
								<?php echo apply_filters( 'woocommerce_widget_cart_item_quantity', '<div class="cart-qty-price">' . sprintf( '%s &times; %s', $cart_item['quantity'], $product_price ) . '</div>', $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
								</div>
							</div>
						</div>
				</div>
				<?php
			}
		}

		do_action( 'woocommerce_mini_cart_contents' );
		?>
	</div>
	</div>

	

	<?php do_action( 'woocommerce_widget_shopping_cart_before_buttons' ); ?>

	<div class="cart-footer">
		<div class="cart-ft-totals">
			<div class="cart-ft-amt cart-ft-amt-subtotal ">
				<span class="cart-ft-amt-label"><?php echo esc_html_e('Subtotal','storely'); ?></span>
				<span class="cart-ft-amt-value"><span class="woocommerce-Price-amount amount"><?php echo WC()->cart->get_cart_subtotal(); ?></span></span>
			</div>
		</div>
		<div class="cart-ft-buttons-cont">
			<a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="cart-ft-btn button btn btn-primary cart-ft-btn-cart"><?php echo esc_html_e('View Cart','storely'); ?></a>
			<a href="<?php echo esc_url( wc_get_checkout_url() ); ?>" class="cart-ft-btn button btn btn-border-secondary cart-ft-btn-checkout"><?php echo esc_html_e('Checkout','storely'); ?></a>
		</div>
	</div>
	<?php do_action( 'woocommerce_widget_shopping_cart_after_buttons' ); ?>

<?php else : ?>

	<p class="woocommerce-mini-cart__empty-message"><?php esc_html_e( 'No products in the cart.', 'storely' ); ?></p>

<?php endif; ?>

<?php do_action( 'woocommerce_after_mini_cart' ); ?>


<?php 
/**
 * Show cart contents / total Ajax
 */
add_filter( 'woocommerce_add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment' );

function woocommerce_header_add_to_cart_fragment( $fragments ) {
	global $woocommerce;

	ob_start();
	$hdr_cart_style = get_theme_mod( 'hdr_cart_style','1');
	?>
<div class="cart-data">
	<?php if ( ! WC()->cart->is_empty() ) : ?>
	<div class="cart-body">
       <div class="cart-products woocommerce-mini-cart cart_list product_list_widget cart-items">
		<?php
		do_action( 'woocommerce_before_mini_cart_contents' );

		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
			$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
			$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

			if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
				$product_name      = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );
				$thumbnail         = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
				$product_price     = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
				$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
				?>
				<div class="cart-product woocommerce-mini-cart-item <?php echo esc_attr( apply_filters( 'woocommerce_mini_cart_item_class', 'mini_cart_item', $cart_item, $cart_item_key ) ); ?>">
					<?php
					echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
						'woocommerce_cart_item_remove_link',
						sprintf(
							'<div class="cart-img-col"><a href="%s" class="remove remove_from_cart_button" aria-label="%s" data-product_id="%s" data-cart_item_key="%s" data-product_sku="%s">&times;</a><a href="<?php echo esc_url( $product_permalink ); ?>">'."$thumbnail".'</a></div>',
							esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
							esc_attr__( 'Remove this item', 'storely' ),
							esc_attr( $product_id ),
							esc_attr( $cart_item_key ),
							esc_attr( $_product->get_sku() )
						),
						$cart_item_key
					);
					?>
					
					 <div class="cart-sum-col">
						<div class="cart-sm-info">
							<div class="cart-sm-left">
								<?php if ( empty( $product_permalink ) ) : ?>
									<span class="cart-pname">
										<?php echo $product_name; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
									</span>
								<?php else : ?>
									<span class="cart-pname">
										<a href="<?php echo esc_url( $product_permalink ); ?>">
										<?php echo $product_name; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
										</a>
									</span>
								<?php endif; ?>
								<?php echo wc_get_formatted_cart_item_data( $cart_item ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
								<?php echo apply_filters( 'woocommerce_widget_cart_item_quantity', '<div class="cart-qty-price">' . sprintf( '%s &times; %s', $cart_item['quantity'], $product_price ) . '</div>', $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
								</div>
							</div>
						</div>
				</div>
				<?php
			}
		}

		do_action( 'woocommerce_mini_cart_contents' );
		?>
	</div>
	</div>

	

	<?php do_action( 'woocommerce_widget_shopping_cart_before_buttons' ); ?>

	<div class="cart-footer">
		<div class="cart-ft-totals">
			<div class="cart-ft-amt cart-ft-amt-subtotal ">
				<span class="cart-ft-amt-label"><?php echo esc_html_e('Subtotal','storely'); ?></span>
				<span class="cart-ft-amt-value"><span class="woocommerce-Price-amount amount"><?php echo WC()->cart->get_cart_subtotal(); ?></span></span>
			</div>
		</div>
		<div class="cart-ft-buttons-cont">
			<a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="cart-ft-btn button btn btn-primary cart-ft-btn-cart"><?php echo esc_html_e('View Cart','storely'); ?></a>
			<a href="<?php echo esc_url( wc_get_checkout_url() ); ?>" class="cart-ft-btn button btn btn-border-secondary cart-ft-btn-checkout"><?php echo esc_html_e('Checkout','storely'); ?></a>
		</div>
	</div>
	<?php do_action( 'woocommerce_widget_shopping_cart_after_buttons' ); ?>

<?php else : ?>

	<p class="woocommerce-mini-cart__empty-message"><?php esc_html_e( 'No products in the cart.', 'storely' ); ?></p>

<?php endif; ?>

<?php do_action( 'woocommerce_after_mini_cart' ); ?>
</div>	
	<?php
	$fragments['div.cart-data'] = ob_get_clean();
	return $fragments;
}
