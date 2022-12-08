<?php if ( get_header_image() ) : ?>
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>" id="custom-header" rel="home">
		<img src="<?php esc_url(header_image()); ?>" width="<?php echo esc_attr( get_custom_header()->width ); ?>" height="<?php echo esc_attr( get_custom_header()->height ); ?>" alt="<?php echo esc_attr(get_bloginfo( 'title' )); ?>">
	</a>	
<?php endif; ?>
<header id="main-header4" class="main-header">
	<?php do_action('storely_section_header'); ?>
	<div class="navigation-wrapper">
		<div class="navigation-middle">
			<div class="main-navigation-area d-none d-lg-block">
				<div class="main-navigation <?php echo esc_attr(storely_sticky_menu()); ?>">
					<div class="container">
						<div class="row navigation-middle-row">
							<div class="col-lg-3 col-12 my-auto">
								<div class="logo">
									<?php do_action('storely_logo'); ?>
								</div>
							</div>
							<div class="col-lg-9 col-12 my-auto">
								<nav class="navbar-area">
									<div class="main-navbar justify-content-end">
										<?php do_action('storely_main_nav'); ?>
									</div>
								</nav>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="main-mobile-nav <?php echo esc_attr(storely_sticky_menu()); ?>">
			<div class="container">
				<div class="row">
					<div class="col-12">
						<div class="main-mobile-menu">
							<div class="main-menu-right main-mobile-left">
								<div class="logo">
									<?php do_action('storely_logo'); ?>
								</div>
							</div>
							<div class="menu-collapse-wrap">
								<div class="hamburger-menu">
									<button type="button" class="menu-collapsed" aria-label="<?php echo esc_attr_e('Menu Collaped','storezia'); ?>">
										<div class="top-bun"></div>
										<div class="meat"></div>
										<div class="bottom-bun"></div>
									</button>
								</div>
							</div>
							<div class="main-mobile-wrapper">
								<div id="mobile-menu-build" class="main-mobile-build">
									<button type="button" class="header-close-menu close-style" aria-label="<?php echo esc_attr_e('Header Close Menu','storezia'); ?>"></button>

									<?php do_action('storely_hdr_mobile_browse_cat')?>
								</div>
							</div>
							<?php if ( function_exists( 'ecommerce_companion_activate' ) ) : ?>
								<div class="header-above-wrapper">
									<div class="header-above-index">
										<div class="header-above-btn">
											<button type="button" class="header-above-collapse" aria-label="<?php echo esc_attr_e('Header Above Collapse','storezia');?>"><span></span></button>
										</div>
										<div id="header-above-bar" class="header-above-bar"></div>
									</div>
								</div>
							<?php endif; ?>	
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</header>
<!-- End: Main Header
=================================-->

<!--===// Start: Browse
=================================-->
<?php if(class_exists( 'woocommerce' )): ?>
<div id="browse-section" class="browse-section">
	<div class="container">
		<div class="row">
			<div class="col-lg-3 col-12">
				<?php 
				$storezia_hs_browse_cat		= get_theme_mod( 'hs_browse_cat','1');
				if($storezia_hs_browse_cat=='1' && class_exists( 'woocommerce' )): ?>
					<div class="product-category-browse d-none d-lg-block">
						<?php do_action('storely_hdr_browse_cat')?>
					</div>
				<?php endif; ?>
			</div>
			<div class="col-lg-7 col-12 d-none d-lg-block">
				<?php do_action('storely_hdr_product_search')?>                   
			</div>
			<div class="col-lg-2 col-12 d-none d-lg-block">
				<div class="main-menu-right">
					<ul class="menu-right-list pr-3">
						<?php 
							do_action('storely_hdr_account');
							do_action('storely_hdr_cart');
						?>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
<?php endif; ?>
<!-- End: Browse
=================================-->