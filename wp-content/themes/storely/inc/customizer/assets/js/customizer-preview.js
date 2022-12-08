/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {

	/**
     * Outputs custom css for responsive controls
     * @param  {[string]} setting customizer setting
     * @param  {[string]} css_selector
     * @param  {[array]} css_prop css property to write
     * @param  {String} ext css value extension eg: px, in
     * @return {[string]} css output
     */
    function range_live_media_load( setting, css_selector, css_prop, ext = '' ) {
        wp.customize(
            setting, function( value ) {
                'use strict';
                value.bind(
                    function( to ){
                        var values          = JSON.parse( to );
                        var desktop_value   = JSON.parse( values.desktop );
                        var tablet_value    = JSON.parse( values.tablet );
                        var mobile_value    = JSON.parse( values.mobile );

                        var class_name      = 'customizer-' + setting;
                        var css_class       = $( '.' + class_name );
                        var selector_name   = css_selector;
                        var property_name   = css_prop;

                        var desktop_css     = '';
                        var tablet_css      = '';
                        var mobile_css      = '';

                        if ( property_name.length == 1 ) {
                            var desktop_css     = property_name[0] + ': ' + desktop_value + ext + ';';
                            var tablet_css      = property_name[0] + ': ' + tablet_value + ext + ';';
                            var mobile_css      = property_name[0] + ': ' + mobile_value + ext + ';';
                        } else if ( property_name.length == 2 ) {
                            var desktop_css     = property_name[0] + ': ' + desktop_value + ext + ';';
                            var desktop_css     = desktop_css + property_name[1] + ': ' + desktop_value + ext + ';';

                            var tablet_css      = property_name[0] + ': ' + tablet_value + ext + ';';
                            var tablet_css      = tablet_css + property_name[1] + ': ' + tablet_value + ext + ';';

                            var mobile_css      = property_name[0] + ': ' + mobile_value + ext + ';';
                            var mobile_css      = mobile_css + property_name[1] + ': ' + mobile_value + ext + ';';
                        }

                        var head_append     = '<style class="' + class_name + '">@media (min-width: 320px){ ' + selector_name + ' { ' + mobile_css + ' } } @media (min-width: 720px){ ' + selector_name + ' { ' + tablet_css + ' } } @media (min-width: 960px){ ' + selector_name + ' { ' + desktop_css + ' } }</style>';

                        if ( css_class.length ) {
                            css_class.replaceWith( head_append );
                        } else {
                            $( "head" ).append( head_append );
                        }
                    }
                );
            }
        );
    }
	// Site title and description.
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title' ).text( to );
		} );
	} );
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		} );
	} );

	// Header text color.
	wp.customize( 'header_textcolor', function( value ) {
		value.bind( function( to ) {
			if ( 'blank' === to ) {
				$( '.site-title, .site-description' ).css( {
					'clip': 'rect(1px, 1px, 1px, 1px)',
					'position': 'absolute'
				} );
			} else {
				$( '.site-title, .site-description' ).css( {
					'clip': 'auto',
					'position': 'relative'
				} );
				$( '.site-title, .site-description' ).css( {
					'color': to
				} );
			}
		} );
	} );
	
	$(document).ready(function ($) {
        $('input[data-input-type]').on('input change', function () {
            var val = $(this).val();
            $(this).prev('.cs-range-value').html(val);
            $(this).val(val);
        });
    })
	
	
	/**
	 * logo_width
	 */
	range_live_media_load( 'logo_width', '.logo img, .mobile-logo img', [ 'max-width' ], 'px !important' );
	
	//popular_product_ttl
	wp.customize(
		'popular_product_ttl', function( value ) {
			value.bind(
				function( newval ) {
					$( '.popular-products-home .heading-default h5' ).text( newval );
				}
			);
		}
	);
	
	
	//blog_ttl
	wp.customize(
		'blog_ttl', function( value ) {
			value.bind(
				function( newval ) {
					$( '.post-home .heading-default h5' ).text( newval );
				}
			);
		}
	);
	
	
	/**
	 * Breadcrumb 
	 */
	wp.customize( 'breadcrumb_min_height', function( value ) {
		value.bind( function( margin ) {
			jQuery( 'div.breadcrumb-content' ).css( 'min-height', margin + 'px' );
		} );
	} );
	
	/**
	 * Body font family
	 */
	wp.customize( 'storely_body_font_family', function( value ) {
		value.bind( function( font_family ) {
			jQuery( 'body' ).css( 'font-family', font_family );
		} );
	} );
	
	/**
	 * Body font size
	 */
	
	range_live_media_load( 'storely_body_font_size', 'body', [ 'font-size' ], 'px' );
	
	/**
	 * Body Letter Spacing
	 */
	
	range_live_media_load( 'storely_body_ltr_space', 'body', [ 'letter-spacing' ], 'px' );
	
	/**
	 * Body font weight
	 */
	wp.customize( 'storely_body_font_weight', function( value ) {
		value.bind( function( font_weight ) {
			jQuery( 'body' ).css( 'font-weight', font_weight );
		} );
	} );
	
	/**
	 * Body font style
	 */
	wp.customize( 'storely_body_font_style', function( value ) {
		value.bind( function( font_style ) {
			jQuery( 'body' ).css( 'font-style', font_style );
		} );
	} );
	
	/**
	 * Body Text Decoration
	 */
	wp.customize( 'storely_body_txt_decoration', function( value ) {
		value.bind( function( decoration ) {
			jQuery( 'body, a' ).css( 'text-decoration', decoration );
		} );
	} );
	/**
	 * Body text tranform
	 */
	wp.customize( 'storely_body_text_transform', function( value ) {
		value.bind( function( text_tranform ) {
			jQuery( 'body' ).css( 'text-transform', text_tranform );
		} );
	} );
	
	/**
	 * storely_body_line_height
	 */
	range_live_media_load( 'storely_body_line_height', 'body', [ 'line-height' ] );
	
	/**
	 * H1 font family
	 */
	wp.customize( 'storely_h1_font_family', function( value ) {
		value.bind( function( font_family ) {
			jQuery( 'h1' ).css( 'font-family', font_family );
		} );
	} );
	
	/**
	 * H1 font size
	 */
	range_live_media_load( 'storely_h1_font_size', 'h1', [ 'font-size' ], 'px' );
	
	/**
	 * H1 font style
	 */
	wp.customize( 'storely_h1_font_style', function( value ) {
		value.bind( function( font_style ) {
			jQuery( 'h1' ).css( 'font-style', font_style );
		} );
	} );
	
	/**
	 * H1 Text Decoration
	 */
	wp.customize( 'storely_h1_text_decoration', function( value ) {
		value.bind( function( decoration ) {
			jQuery( 'h1' ).css( 'text-decoration', decoration );
		} );
	} );
	
	/**
	 * H1 font weight
	 */
	wp.customize( 'storely_h1_font_weight', function( value ) {
		value.bind( function( font_weight ) {
			jQuery( 'h1' ).css( 'font-weight', font_weight );
		} );
	} );
	
	/**
	 * H1 text tranform
	 */
	wp.customize( 'storely_h1_text_transform', function( value ) {
		value.bind( function( text_tranform ) {
			jQuery( 'h1' ).css( 'text-transform', text_tranform );
		} );
	} );
	
	/**
	 * H1 line height
	 */
	range_live_media_load( 'storely_h1_line_height', 'h1', [ 'line-height' ] );
	
	/**
	 * H1 Letter Spacing
	 */
	 
	range_live_media_load( 'storely_h1_ltr_spacing', 'h1', [ 'letter-spacing' ], 'px' );
	
	/**
	 * H2 font family
	 */
	wp.customize( 'storely_h2_font_family', function( value ) {
		value.bind( function( font_family ) {
			jQuery( 'h2' ).css( 'font-family', font_family );
		} );
	} );
	
	/**
	 * H2 font size
	 */
	range_live_media_load( 'storely_h2_font_size', 'h2', [ 'font-size' ], 'px' );
	
	/**
	 * H2 font style
	 */
	wp.customize( 'storely_h2_font_style', function( value ) {
		value.bind( function( font_style ) {
			jQuery( 'h2' ).css( 'font-style', font_style );
		} );
	} );
	
	/**
	 * H2 Text Decoration
	 */
	wp.customize( 'storely_h2_text_decoration', function( value ) {
		value.bind( function( decoration ) {
			jQuery( 'h2' ).css( 'text-decoration', decoration );
		} );
	} );
	
	/**
	 * H2 font weight
	 */
	wp.customize( 'storely_h2_font_weight', function( value ) {
		value.bind( function( font_weight ) {
			jQuery( 'h2' ).css( 'font-weight', font_weight );
		} );
	} );
	
	/**
	 * H2 text tranform
	 */
	wp.customize( 'storely_h2_text_transform', function( value ) {
		value.bind( function( text_tranform ) {
			jQuery( 'h2' ).css( 'text-transform', text_tranform );
		} );
	} );
	
	/**
	 * H2 line height
	 */
	range_live_media_load( 'storely_h2_line_height', 'h2', [ 'line-height' ]);
	
	/**
	 * H2 Letter Spacing
	 */
	
	range_live_media_load( 'storely_h2_ltr_spacing', 'h2', [ 'letter-spacing' ], 'px' );
	/**
	 * H3 font family
	 */
	wp.customize( 'storely_h3_font_family', function( value ) {
		value.bind( function( font_family ) {
			jQuery( 'h3' ).css( 'font-family', font_family );
		} );
	} );
	
	/**
	 * H3 font size
	 */
	range_live_media_load( 'storely_h3_font_size', 'h3', [ 'font-size' ], 'px' );
	
	/**
	 * H3 font style
	 */
	wp.customize( 'storely_h3_font_style', function( value ) {
		value.bind( function( font_style ) {
			jQuery( 'h3' ).css( 'font-style', font_style );
		} );
	} );
	
	/**
	 * H3 Text Decoration
	 */
	wp.customize( 'storely_h3_text_decoration', function( value ) {
		value.bind( function( decoration ) {
			jQuery( 'h3' ).css( 'text-decoration', decoration );
		} );
	} );
	
	/**
	 * H3 font weight
	 */
	wp.customize( 'storely_h3_font_weight', function( value ) {
		value.bind( function( font_weight ) {
			jQuery( 'h3' ).css( 'font-weight', font_weight );
		} );
	} );
	
	/**
	 * H3 text tranform
	 */
	wp.customize( 'storely_h3_text_transform', function( value ) {
		value.bind( function( text_tranform ) {
			jQuery( 'h3' ).css( 'text-transform', text_tranform );
		} );
	} );
	
	/**
	 * H3 line height
	 */
	range_live_media_load( 'storely_h3_line_height', 'h3', [ 'line-height' ]);
	
	/**
	 * H3 Letter Spacing
	 */
	
	range_live_media_load( 'storely_h3_ltr_spacing', 'h3', [ 'letter-spacing' ], 'px' );
	
	
	/**
	 * H4 font family
	 */
	wp.customize( 'storely_h4_font_family', function( value ) {
		value.bind( function( font_family ) {
			jQuery( 'h4' ).css( 'font-family', font_family );
		} );
	} );
	
	/**
	 * H4 font size
	 */
	range_live_media_load( 'storely_h4_font_size', 'h4', [ 'font-size' ], 'px' );
	
	/**
	 * H4 font style
	 */
	wp.customize( 'storely_h4_font_style', function( value ) {
		value.bind( function( font_style ) {
			jQuery( 'h4' ).css( 'font-style', font_style );
		} );
	} );
	
	/**
	 * H4 Text Decoration
	 */
	wp.customize( 'storely_h4_text_decoration', function( value ) {
		value.bind( function( decoration ) {
			jQuery( 'h4' ).css( 'text-decoration', decoration );
		} );
	} );
	
	/**
	 * H4 font weight
	 */
	wp.customize( 'storely_h4_font_weight', function( value ) {
		value.bind( function( font_weight ) {
			jQuery( 'h4' ).css( 'font-weight', font_weight );
		} );
	} );
	
	/**
	 * H4 text tranform
	 */
	wp.customize( 'storely_h4_text_transform', function( value ) {
		value.bind( function( text_tranform ) {
			jQuery( 'h4' ).css( 'text-transform', text_tranform );
		} );
	} );
	
	/**
	 * H4 line height
	 */
	range_live_media_load( 'storely_h4_line_height', 'h4', [ 'line-height' ]);
	
	/**
	 * H4 Letter Spacing
	 */
	
		range_live_media_load( 'storely_h4_ltr_spacing', 'h4', [ 'letter-spacing' ], 'px' );
	
	/**
	 * H5 font family
	 */
	wp.customize( 'storely_h5_font_family', function( value ) {
		value.bind( function( font_family ) {
			jQuery( 'h5' ).css( 'font-family', font_family );
		} );
	} );
	
	/**
	 * H5 font size
	 */
	range_live_media_load( 'storely_h5_font_size', 'h5', [ 'font-size' ], 'px' );
	
	/**
	 * H5 font style
	 */
	wp.customize( 'storely_h5_font_style', function( value ) {
		value.bind( function( font_style ) {
			jQuery( 'h5' ).css( 'font-style', font_style );
		} );
	} );
	
	/**
	 * H5 Text Decoration
	 */
	wp.customize( 'storely_h5_text_decoration', function( value ) {
		value.bind( function( decoration ) {
			jQuery( 'h5' ).css( 'text-decoration', decoration );
		} );
	} );
	
	
	/**
	 * H5 font weight
	 */
	wp.customize( 'storely_h5_font_weight', function( value ) {
		value.bind( function( font_weight ) {
			jQuery( 'h5' ).css( 'font-weight', font_weight );
		} );
	} );
	
	/**
	 * H5 text tranform
	 */
	wp.customize( 'storely_h5_text_transform', function( value ) {
		value.bind( function( text_tranform ) {
			jQuery( 'h5' ).css( 'text-transform', text_tranform );
		} );
	} );
	
	/**
	 * H5 line height
	 */
	range_live_media_load( 'storely_h5_line_height', 'h5', [ 'line-height' ]);
	
	/**
	 * H5 Letter Spacing
	 */
	
	range_live_media_load( 'storely_h5_ltr_spacing', 'h5', [ 'letter-spacing' ], 'px' );
	
	/**
	 * H6 font family
	 */
	wp.customize( 'storely_h6_font_family', function( value ) {
		value.bind( function( font_family ) {
			jQuery( 'h6' ).css( 'font-family', font_family );
		} );
	} );
	
	/**
	 * H6 font size
	 */
	range_live_media_load( 'storely_h6_font_size', 'h6', [ 'font-size' ], 'px' );
	
	/**
	 * H6 font style
	 */
	wp.customize( 'storely_h6_font_style', function( value ) {
		value.bind( function( font_style ) {
			jQuery( 'h6' ).css( 'font-style', font_style );
		} );
	} );
	
	/**
	 * H6 Text Decoration
	 */
	wp.customize( 'storely_h6_text_decoration', function( value ) {
		value.bind( function( decoration ) {
			jQuery( 'h6' ).css( 'text-decoration', decoration );
		} );
	} );
	
	
	/**
	 * H6 font weight
	 */
	wp.customize( 'storely_h6_font_weight', function( value ) {
		value.bind( function( font_weight ) {
			jQuery( 'h6' ).css( 'font-weight', font_weight );
		} );
	} );
	
	/**
	 * H6 text tranform
	 */
	wp.customize( 'storely_h6_text_transform', function( value ) {
		value.bind( function( text_tranform ) {
			jQuery( 'h6' ).css( 'text-transform', text_tranform );
		} );
	} );
	
	/**
	 * H6 line height
	 */
	range_live_media_load( 'storely_h6_line_height', 'h6', [ 'line-height' ]);
	
	/**
	 * H6 Letter Spacing
	 */
	
	range_live_media_load( 'storely_h6_ltr_spacing', 'h6', [ 'letter-spacing' ], 'px' );
	
	
	
} )( jQuery );