function materialisLiveUpdate(setting, callback) {
    var cb = function (value) {
        value.bind(callback);
    };
    var _setting = setting;
    wp.customize(_setting, cb);

    if (parent.CP_Customizer) {
        var _prefixedSetting = parent.CP_Customizer.slugPrefix() + "_" + setting;
        wp.customize(_prefixedSetting, cb);
    }
}

function materialisLiveUpdateHeader(settingPart, callback) {
    materialisLiveUpdate("header" + settingPart, function (value, oldValue) {
        callback(value, oldValue, false);
    });

    materialisLiveUpdate("inner_header" + settingPart, function (value, oldValue) {
        callback(value, oldValue, true);
    });
}

(function ($) {
    wp.customize('full_height_header', function (value) {
        value.bind(function (newval) {
            if (newval) {
                $('.header-homepage').css('min-height', "100vh");
            } else {
                $('.header-homepage').css('min-height', "");
            }
        });
    });

    wp.customize('header_show_overlay', function (value) {
        value.bind(function (newval) {
            if (newval) {
                $('.header-homepage').addClass('color-overlay');
            } else {
                $('.header-homepage').removeClass('color-overlay');
            }
        });
    });
    wp.customize('header_sticked_background', function (value) {
        value.bind(function (newval) {
            if (newval) {
                $('.homepage.navigation-bar.fixto-fixed').css('background-color', newval);
            }
            var transparent = JSON.parse(wp.customize('header_nav_transparent').get());
            if (!transparent) {
                $('.homepage.navigation-bar').css('background-color', newval);
            }
        });
    });
    wp.customize('header_nav_transparent', function (value) {
        value.bind(function (newval) {
            if (newval) {
                $('.homepage.navigation-bar').removeClass('coloured-nav');
            } else {
                $('.homepage.navigation-bar').css('background-color', '');
                $('.homepage.navigation-bar').addClass('coloured-nav');
            }
        });
    });
    wp.customize('inner_header_sticked_background', function (value) {
        value.bind(function (newval) {
            if (newval) {
                $('.navigation-bar:not(.homepage).fixto-fixed').css('background-color', newval);
            }

            var transparent = JSON.parse(wp.customize('inner_header_nav_transparent').get());
            if (!transparent) {
                $('.navigation-bar:not(.homepage)').css('background-color', newval);
            }
        });
    });
    wp.customize('inner_header_nav_transparent', function (value) {
        value.bind(function (newval) {
            if (newval) {
                $('.navigation-bar:not(.homepage)').removeClass('coloured-nav');
            } else {
                $('.navigation-bar:not(.homepage)').addClass('coloured-nav');
            }
        });
    });
    wp.customize('inner_header_show_overlay', function (value) {
        value.bind(function (newval) {
            if (newval) {
                $('.header').addClass('color-overlay');
            } else {
                $('.header').removeClass('color-overlay');
            }
        });
    });

    wp.customize('header_gradient', function (value) {
        value.bind(function (newval, oldval) {
            $('.header-homepage').removeClass(oldval);
            $('.header-homepage').addClass(newval);
        });
    });

    wp.customize('inner_header_gradient', function (value) {
        value.bind(function (newval, oldval) {
            $('.header').removeClass(oldval);
            $('.header').addClass(newval);
        });
    });


    wp.customize('header_text_box_text_vertical_align', function (value) {
        value.bind(function (newVal, oldVal) {
            $('.header-hero-content-v-align').removeClass(oldVal).addClass(newVal);
        });
    });

    wp.customize('header_media_box_vertical_align', function (value) {
        value.bind(function (newVal, oldVal) {
            $('.header-hero-media-v-align').removeClass(oldVal).addClass(newVal);
        });
    });

    wp.customize('header_text_box_text_align', function (value) {
        value.bind(function (newVal, oldVal) {
            $('.materialis-front-page  .header-content .align-holder').removeClass(oldVal).addClass(newVal);
        });
    });

    function updateMobileBgImagePosition() {
        var position = wp.customize('header_bg_position_mobile').get(),
            positionParts = position.split(' '),
            offset = wp.customize('header_bg_position_mobile_offset').get(),
            styleHolder = jQuery('[data-name="custom-mobile-image-position"]');

        if (styleHolder.length == 0) {
            styleHolder = jQuery('<style data-name="custom-mobile-image-position"></style>');
            styleHolder.appendTo('head');
        }


        position = position + " " + offset + "px";

        styleHolder.text("" +
            "@media screen and (max-width: 767px) {\n" +
            "   .header-homepage {\n" +
            "       background-position: " + position + "!important ;\n" +
            "   }\n" +
            "}\n");
    }

    wp.customize('header_bg_position_mobile', function (value) {
        value.bind(updateMobileBgImagePosition);
    });

    wp.customize('header_bg_position_mobile_offset', function (value) {
        value.bind(updateMobileBgImagePosition);
    })

    // media frame //
    wp.customize('header_content_frame_offset_left', function (value) {
        value.bind(function (left) {
            var top = wp.customize('header_content_frame_offset_top').get();
            $('.materialis-front-page  .header-description .overlay-box-offset').css({
                'transform': 'translate(' + left + '%,' + top + '%)'
            });
        });
    });


    wp.customize('header_content_frame_offset_top', function (value) {
        value.bind(function (top) {
            var left = wp.customize('header_content_frame_offset_left').get();
            $('.materialis-front-page  .header-description .overlay-box-offset').css({
                'transform': 'translate(' + left + '%,' + top + '%)'
            });
        });
    });

    wp.customize('header_content_frame_width', function (value) {
        value.bind(function (width) {
            $('.materialis-front-page  .header-description .overlay-box-offset').css({
                'width': width + '%'
            });
        });
    });


    wp.customize('header_content_frame_height', function (value) {
        value.bind(function (height) {
            $('.materialis-front-page  .header-description .overlay-box-offset').css({
                'height': height + '%'
            });
        });
    });

    wp.customize('header_content_frame_thickness', function (value) {
        value.bind(function (thickness) {
            $('.materialis-front-page  .header-description .overlay-box-offset').css({
                'border-width': thickness + 'px'
            });
        });
    });

    wp.customize('header_content_frame_show_over_image', function (value) {
        value.bind(function (value) {
            var zIndex = value ? "1" : "-1";
            $('.materialis-front-page  .header-description .overlay-box-offset').css('z-index', zIndex);
        });
    });

    wp.customize('header_content_frame_shadow', function (value) {
        value.bind(function (value) {
            var shadow = "mdc-elevation--z4";
            var frame = $('.materialis-front-page  .header-description .overlay-box-offset');
            if (value) {
                frame.addClass(shadow);
            } else {
                frame.removeClass(shadow);
            }
        });
    });


    wp.customize('header_content_frame_color', function (value) {
        value.bind(function (color) {
            var type = wp.customize('header_content_frame_type').get();
            var property = type + "-color";
            $('.materialis-front-page  .header-description .overlay-box-offset').css(property, color);
        });
    });

    wp.customize('header_content_frame_hide_on_mobile', function (value) {
        value.bind(function (hide) {
            $('.materialis-front-page  .header-description .overlay-box-offset').toggleClass('hide-xs');
        });
    });

    function updateTopBarInfo(area, index) {
        return function (value) {
            value.bind(function (html) {
                var id = 'header_top_bar_' + area + '_info_field_' + index + '_icon';
                $("[data-focus-control=" + id + "]").find('span').html(html);
            });
        }
    }

    var areas = ['area-left', 'area-right'];
    for (var i = 0; i < areas.length; i++) {
        for (var j = 0; j < 3; j++) {
            wp.customize('header_top_bar_' + areas[i] + '_info_field_' + j + '_text', updateTopBarInfo(areas[i], j));
        }
    }


    /* START FOOTER */

    function toggleFooterSocialIcon(index, selector) {
        return function (value) {
            value.bind(function (newval) {
                if (newval) {
                    $('.footer .footer-social-icons ' + selector).eq(index).removeAttr('data-reiki-hidden');
                } else {
                    $('.footer .footer-social-icons ' + selector).eq(index).attr('data-reiki-hidden', 'true');
                }
            });
        }
    }

    function changeFooterSocialIcon(index, selector) {
        return function (value) {
            value.bind(function (newval, oldval) {
                $('.footer .footer-social-icons ' + selector).eq(index).find('i').removeClass(oldval).addClass(newval);
            });
        }
    }

    for (var ki = 0; ki < 5; ki++) {
        wp.customize('footer_content_social_icon_' + ki + '_enabled', toggleFooterSocialIcon(ki, '.social-icon'));
        wp.customize('footer_content_social_icon_' + ki + '_icon', changeFooterSocialIcon(ki, '.social-icon'));
    }


    wp.customize('footer_paralax', function (value) {
        value.bind(function (newval) {
            if (newval) {
                $('.footer').addClass('paralax');
                materialisFooterParalax();
            }
            else {
                $('.footer').removeClass('paralax');
                materialisStopFooterParalax();
            }
        });
    });

    /* END FOOTER */

})(jQuery);

(function ($) {

    wp.customize('header_nav_border', function (value) {
        value.bind(function (newval) {
            if (newval) {

                $('.materialis-front-page .navigation-bar.bordered:not(.fixto-fixed)').css({
                    "border-bottom-width": wp.customize('header_nav_border_thickness').get() + 'px',
                    'border-bottom-color': wp.customize('header_nav_border_color').get()
                });

            }
        });
    });
    wp.customize('inner_header_nav_border', function (value) {
        value.bind(function (newval) {
            if (newval) {
                $('.materialis-inner-page .navigation-bar.bordered:not(.fixto-fixed)').css({
                    "border-bottom-width": wp.customize('header_nav_border_thickness').get() + 'px',
                    'border-bottom-color': wp.customize('header_nav_border_color').get()
                });
            }
        });
    });

})(jQuery);

(function ($) {
    function getGradientValue(setting) {
        var getValue = parent.CP_Customizer ? parent.CP_Customizer.utils.getValue : parent.Materialis.Utils.getValue;
        var control = parent.wp.customize.control(setting);
        var gradient = getValue(control);
        var colors = gradient.colors;
        var angle = gradient.angle;
        angle = parseFloat(angle);
        return parent.Materialis.Utils.getGradientString(colors, angle);
    }

    function recalculateHeaderOverlayGradient() {
        $('.header-homepage .background-overlay').css("background-image", getGradientValue('header_overlay_gradient_colors'));
    }

    function recalculateInnerHeaderOverlayGradient() {
        $('.header .background-overlay').css("background-image", getGradientValue('inner_header_overlay_gradient_colors'));
    }

    materialisLiveUpdate('header_overlay_gradient_colors', recalculateHeaderOverlayGradient);
    materialisLiveUpdate('inner_header_overlay_gradient_colors', recalculateInnerHeaderOverlayGradient);
})(jQuery);

(function ($) {

    // boxed layout //

    wp.customize('layout_boxed_content_enabled', function (value) {
        value.bind(function (value) {
            var $elements = $('body #page .page-content,body #page > .content ');
            if (value) {
                $elements.addClass('mdc-elevation--z20 boxed-layout');
                $elements.css({
                    'margin-top': '-' + wp.customize('layout_boxed_content_overlap_height').get() + 'px',
                });
                $('#page').css('background-color', wp.customize('layout_boxed_content_background_color').get());

                $('.footer').removeClass('paralax');
                materialisStopFooterParalax();
            } else {
                $elements.removeClass('mdc-elevation--z20 boxed-layout');
                $elements.css({
                    'margin-top': '0px',
                });

                $('#page').css('background-color', 'transparent');
            }
        });
    });

    wp.customize('layout_boxed_content_background_color', function (value) {
        value.bind(function (v) {
            $('#page').css('background-color', v);
        });
    });

    wp.customize('layout_boxed_content_overlap_height', function (value) {
        value.bind(function (value) {
            var $elements = $('body #page .page-content,body #page > .content ');
            $elements.css({
                'margin-top': '-' + value + 'px'
            });
        });
    });

    // logo

    wp.customize('logo_max_height', function (value) {
        value.bind(function (newval) {

            currentActionTime = Math.round(+new Date()/1000);

            _.delay(function() {
                if((Math.round(+new Date()/1000)) >= (currentActionTime + 3)) {
                    parent.CP_Customizer.preview.refresh();
                }
            }, 3000);

        });
    });

})(jQuery);

(function ($) {

    // Text box background and Elevation

    function setMDCElevation(element, value) {

        element.attr('class', function (i, c) {
            return c.replace(/(^|\s)mdc-elevation-\S+/g, '');
        });

        if (value > 0) {
            element.addClass('mdc-elevation--z' + value);
        }

    }

    function setBorderWidth(element, value) {
        element.css({
            'border-width': value.top + ' ' + value.right + ' ' + value.bottom + ' ' + value.left,
            'border-style': 'solid'
        });
    }

    wp.customize('header_content_fullwidth', function (value) {
        value.bind(function (newval) {

            if (newval) {
                $('.header-homepage .header-description').removeClass('gridContainer');
            } else {
                $('.header-homepage .header-description').addClass('gridContainer');
            }


        });
    });


    wp.customize('header_text_box_background_border_thickness', function (value) {
        value.bind(function (newval) {
            var $element = $('.header-homepage .align-holder');
            setBorderWidth($element, newval);
        });
    });

    wp.customize('header_text_box_background_shadow', function (value) {
        value.bind(function (newval) {
            var $element = $('.header-homepage .align-holder');
            setMDCElevation($element, newval);
        });
    });

    wp.customize('header_content_title_background_border_thickness', function (value) {
        value.bind(function (newval) {
            var $element = $('.hero-title');
            setBorderWidth($element, newval);
        });
    });

    wp.customize('header_content_title_background_shadow', function (value) {
        value.bind(function (newval) {
            var $element = $('.hero-title');
            setMDCElevation($element, newval);
        });
    });

    wp.customize('header_content_subtitle_background_border_thickness', function (value) {
        value.bind(function (newval) {
            var $element = $('.header-subtitle');
            setBorderWidth($element, newval);
        });
    });

    wp.customize('header_content_subtitle_background_shadow', function (value) {
        value.bind(function (newval) {
            var $element = $('.header-subtitle');
            setMDCElevation($element, newval);
        });
    });

    wp.customize('header_content_subtitle2_background_border_thickness', function (value) {
        value.bind(function (newval) {
            var $element = $('.header-subtitle2');
            setBorderWidth($element, newval);
        });
    });

    wp.customize('header_content_subtitle2_background_shadow', function (value) {
        value.bind(function (newval) {
            var $element = $('.header-subtitle2');
            setMDCElevation($element, newval);
        });
    });

    wp.customize('header_content_buttons_background_border_thickness', function (value) {
        value.bind(function (newval) {
            var $element = $('.header-buttons-wrapper');
            setBorderWidth($element, newval);
        });
    });

    wp.customize('header_content_buttons_background_shadow', function (value) {
        value.bind(function (newval) {
            var $element = $('.header-buttons-wrapper');
            setMDCElevation($element, newval);
        });
    });


    wp.customize('header_overlap', function (value) {
        value.bind(function (newval) {
            var $element = $('body');
            if (newval) {
                $element.addClass('overlap-first-section');
            } else {
                $element.removeClass('overlap-first-section');
            }
        });
    });

})(jQuery);


(function ($) {
   materialisLiveUpdateHeader("_nav_border", function (value, oldValue, inner) {
        var selectorStart = inner ? '.materialis-inner-page' : '.materialis-front-page';
        var selector = ".navigation-bar";

        if (value) {
            $([selectorStart, selector].join(' ')).addClass('bordered');
        } else {
            $([selectorStart, selector].join(' ')).removeClass('bordered');
        }
    });

    materialisLiveUpdateHeader("_nav_sticked", function (value, oldValue, inner) {

        var selectorStart = inner ? '.materialis-inner-page' : '.materialis-front-page';
        var selector = ".navigation-bar";
        var $navBar = $([selectorStart, selector].join(' '));

        if($navBar.length) {

            if (value) {
                $navBar.attr({
                    "data-sticky": 0,
                    "data-sticky-mobile": 1,
                    "data-sticky-to": "top"
                });

                if ($navBar.data().fixtoInstance) {
                    $navBar.data().fixtoInstance.start();
                } else {
                    materialisMenuSticky();
                }

            } else {
                $navBar.removeAttr('data-sticky');
                $navBar.removeAttr('data-sticky-mobile');
                $navBar.removeAttr('data-sticky-to');

                if ($navBar.data().fixtoInstance) {
                    $navBar.data().fixtoInstance.stop();
                }
            }

        }
    });


    materialisLiveUpdateHeader('_slideshow_duration', function (value, oldValue, inner) {
        var selectorStart = inner ? '.materialis-inner-page' : '.materialis-front-page';
        var selector = inner ? ".header" : ".header-homepage";
        var $header = $([selectorStart, selector].join(' '));

        if ($header.data().backstretch) {
            $header.data().backstretch.options.duration = parseInt(value);
        }

    });


    materialisLiveUpdateHeader('_slideshow_speed', function (value, oldValue, inner) {
        var selectorStart = inner ? '.materialis-inner-page' : '.materialis-front-page';
        var selector = inner ? ".header" : ".header-homepage";
        var $header = $([selectorStart, selector].join(' '));

        if ($header.data().backstretch) {
            $header.data().backstretch.options.transitionDuration = parseInt(value);
        }

    });

})(jQuery)
