<div id="materialis_homepage" style="display:none; ">
    <div class="materialis-popup" style="">
        <div>
            <div class="materialis_cp_column">
                <h3 class="materialis_title"><?php esc_html_e( 'Please Install the Materialis Companion Plugin to Enable All the Theme Features',
						'materialis' ) ?></h3>
                <h4><?php esc_html_e( 'Here\'s what you\'ll get:', 'materialis' ); ?></h4>
                <ul class="materialis-features-list">
                    <li><?php esc_html_e( 'Beautiful ready-made homepage', 'materialis' ); ?></li>
                    <li><?php esc_html_e( 'Drag and drop page customization', 'materialis' ); ?></li>
                    <li><?php esc_html_e( '35+ predefined content sections', 'materialis' ); ?></li>
                    <li><?php esc_html_e( 'Live content editing', 'materialis' ); ?></li>
                    <li><?php esc_html_e( '5 header types', 'materialis' ); ?></li>
                    <li><?php esc_html_e( '3 footer types', 'materialis' ); ?></li>
                    <li><?php esc_html_e( 'and many other features', 'materialis' ); ?></li>
                </ul>
            </div>
            <div class="materialis_cp_column">
                <img class="popup-theme-screenshot"
                     src="<?php echo esc_attr( get_template_directory_uri() . "/screenshot.jpg" ) ?>"/>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="footer">
            <label class="disable-popup-cb">
				<?php

				$checkbox_atts     = "";
				$is_popup_disabled = get_option( "materialis_companion_disable_popup", 0 );

				if ( intval( $is_popup_disabled ) ) {
					$checkbox_atts = "checked";
				}

				?>
                <input <?php echo $checkbox_atts; ?> type="checkbox" id="disable-popup-cb"/>
				<?php esc_html_e( "Don't show this popup in the future", 'materialis' ); ?>
            </label>
            <script type="text/javascript">
                jQuery('.materialis-welcome-notice').on('click', '.notice-dismiss', function () {
                    jQuery.post(
                        ajaxurl,
                        {
                            value: 1,
                            action: "companion_disable_popup",
                            companion_disable_popup_wpnonce: '<?php echo wp_create_nonce( "companion_disable_popup" ); ?>'
                        }
                    )
                });
            </script>
			<?php

			if ( \Materialis\Companion_Plugin::$plugin_state['installed'] ) {
				$link  = \Materialis\Companion_Plugin::get_activate_link();
				$label = esc_html__( 'Activate now', 'materialis' );
			} else {
				$link  = \Materialis\Companion_Plugin::get_install_link();
				$label = esc_html__( 'Install now', 'materialis' );
			}
			printf( '<a class="install-now button button-primary button-hero" href="%1$s">%2$s</a>', esc_url( $link ),
				$label );

			?>
        </div>
    </div>
</div>
