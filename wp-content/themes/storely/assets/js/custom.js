(function($) {
  'use strict';

    $(window).on('scroll', function () {
      if ($(this).scrollTop() > 200) {
        $('.scrollingUp').addClass('is-active');
      } else {
        $('.scrollingUp').removeClass('is-active');
      }
    });
    $(window).on('scroll', function() {
      if ($(window).scrollTop() >= 250) {
          $('.is-sticky-on').addClass('is-sticky-menu');
      }
      else {
          $('.is-sticky-on').removeClass('is-sticky-menu');
      }
    });
	
    $(window).bind("scroll", function(){if ($(".scrollingUp").length){
        let b = $("body").height(),c = $(window).height(),d = b - c,e = $(window).scrollTop(),f = 250 - e / d * 150;
        $(".scrollingUp circle").css("stroke-dashoffset", f + "px")
    }}),$('.scrollingUp').click(function(b){return b.preventDefault(),$('html, body').animate({scrollTop:0},320),!1});
    $(window).on('load', function () {
        var postFilter = $('.st-filter-init');
        $.each(postFilter,function (index,value) {
            var el = $(this);
            var parentClass = $(this).parent().attr('class');
            var $selector = $('#'+el.attr('id'));
            $($selector).imagesLoaded(function () {
              var festivarMasonry = $($selector).isotope({
                  itemSelector: '.st-filter-item',
                  percentPosition: true,
                  masonry: {
                      columnWidth: 0,
                      gutter:0
                  }
              });
              $('.collapse').on('shown.bs.collapse hidden.bs.collapse', function() {
                festivarMasonry.isotope('layout');
              });
              $(document).on('click', '.'+parentClass+' .st-tab-filter a', function () {
                  var filterValue = $(this).attr('data-filter');
                  festivarMasonry.isotope({
                      filter: filterValue,
                      animationOptions: {
                          duration: 450,
                          easing: "linear",
                          queue: false,
                      }
                  });
                  return false;
              });
            });
        });
        $(document).on('click', '.st-tab-filter a', function () {
            $(this).siblings().removeClass('active');
            $(this).addClass('active');
        });
        // debounce so filtering doesn't happen every millisecond
        function debounce(fn, threshold) {
          var timeout;
          return function debounced() {
            if (timeout) {
              clearTimeout(timeout);
            }
            function delayed() {
              fn();
              timeout = null;
            }
            timeout = setTimeout(delayed, threshold || 100);
          };
        }
    });
    $( document ).ready(function() {
        //Browse Menu
        if( $('.product-category-menus-list ul.main-menu').children().length >= 7 ) {
            $(".product-category-menus-list").addClass("active");
            $(".product-category-menus-list ul.main-menu").append('<li class="menu-item more-item"><button type="button" class="browse-more"><i class="fa fa-plus"></i> <span>More Category</span></button></li>');
            $(".product-category-menus-list > ul.main-menu > li:not(.more-item)").slice(0, 7).show();
            $(".browse-more").on('click', function (e) {
                if (!$(".browse-more").hasClass("active")) {
                    $(".browse-more").addClass("active");
                    $('.browse-more i').removeClass('fa-plus').addClass("fa-minus");
                    $(".browse-more").animate({display: "block"}, 500,
                        function () {
                            $(".product-category-menus-list > ul.main-menu > li:not(.more-item):hidden").addClass('actived').slideDown(200);
                            if ($(".product-category-menus-list > ul.main-menu > li:not(.more-item):hidden").length === 0) {
                                $(".browse-more").html('<i class="fa fa-minus"></i> <span>No More</span>');
                            }
                        }
                    );
                } else {
                    $(".browse-more").removeClass("active");
                    $(".browse-more").animate({display: "none"}, 500,
                        function () {
                            if ($(".product-category-menus-list > ul.main-menu > li:not(.more-item)").hasClass('actived')) {
                                $(".product-category-menus-list > ul.main-menu > li:not(.more-item).actived").slice(0, 7).slideUp(200);
                                $(".browse-more").html('<i class="fa fa-plus"></i> <span>More Category</span>');
                            }
                        }
                    );
                }
            });
        }
        $('.product-category-browse').hasClass('active') ? browseMenuAccessibility() : $('.product-category-btn').focus();
        function browseMenuAccessibility() {
            var e, t, i, n = document.querySelector(".product-category-browse");
            let a = document.querySelector(".product-category-btn"),
                s = n.querySelectorAll('button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])'),
                o = s[s.length - 1];
            if (!n) return !1;
            for (t = 0, i = (e = n.getElementsByTagName("a")).length; t < i; t++) e[t].addEventListener("focus", c, !0), e[t].addEventListener("blur", c, !0);
            function c() {
                for (var e = this; - 1 === e.className.indexOf("product-category-browse");) "li" === e.tagName.toLowerCase() && (-1 !== e.className.indexOf("focus") ? e.className = e.className.replace(" focus", "") : e.className += " focus"), e = e.parentElement
            }
            document.addEventListener("keydown", function(e) {
                ("Tab" === e.key || 9 === e.keyCode) && (e.shiftKey ? document.activeElement === a && (o.focus(), e.preventDefault()) : document.activeElement === o && (a.focus(), e.preventDefault()))
            })
        }
        $(".main-navbar").find("a").on("focus blur", function() { $(this).parents("ul, li").toggleClass("focus"); });
        $('.btn,.post-items .more-link').prepend('<div class="hover"><span></span><span></span><span></span><span></span><span></span></div>');
        
        var $els = $('.product-category-menus-list a');
        var count = $els.length;
        var grouplength = Math.ceil(count/3);
        var groupNumber = 0;
        var i = 1;
        $('.product-category-menus-list').css('--count',count+'');
        $els.each(function(j){
            if ( i > grouplength ) {
                groupNumber++;
                i=1;
            }
            $(this).attr('data-group',groupNumber);
            i++;
        });

        if(window.matchMedia('(max-width: 991px)').matches) {
            $('.product-category-browse').removeClass("active")
            $('.product-category-menus-list').addClass('closed');
            $('.product-category-menus .product-category-menus-list').css('display', 'none');
        } else {
            $('.product-category-browse').each(function(){
                if ($('.product-category-browse').hasClass("active")) {
                    setTimeout(function(){
                        $('.product-category-menus-list').removeClass('closed');
                    }, 100);
                    $('.product-category-menus .product-category-menus-list').slideDown(700);
                } else {
                    $('.product-category-menus-list').addClass('closed');
                    $('.product-category-menus .product-category-menus-list').css('display', 'none');
                }
            });
        }
        
		$('.product-category-btn').on('click',function(e){
			e.preventDefault();
			$els.each(function(j){
				$(this).css('--top',$(this)[0].getBoundingClientRect().top + ($(this).attr('data-group') * -15) - 20);
				$(this).css('--delay-in',j*.1+'s');
				$(this).css('--delay-out',(count-j)*.1+'s');
			});
			$('.product-category-browse').toggleClass("active");
			if ($('.product-category-browse').hasClass("active")) {
				setTimeout(function(){
					$('.product-category-menus-list').removeClass('closed');
				}, 100);
				$('.product-category-menus .product-category-menus-list').slideDown(700);
				//$("#slider-section .col-lg-9").removeAttr("style");
			} else {
				$('.product-category-menus-list').addClass('closed');
				$('.product-category-menus .product-category-menus-list').slideUp(700);
				//$("#slider-section .col-lg-9").css("width", "100%");
			}
			e.stopPropagation();
		});
		
		$(".product-category-btn").click(function () {
        if ($(window).outerWidth() > 991) {
            if ($(this).parent().hasClass("active")) {
                $(".canvas").css("width","75%");
            } else {
                $(".canvas").css("width","100%");
            }
        }
       });
	   
	   
        $('.scrollingUp').on('click', function () {
          $("html, body").animate({
            scrollTop: 0
          }, 600);
          return false;
        });
        $('.cart-trigger').on('click',function(e){
            e.preventDefault();
            if (!$('.cart-modal').hasClass("cart-active")) {
                $('.cart-modal').addClass('cart-active');
                $('.cart-close').focus();
                var e, t, i, n = document.querySelector(".cart-modal");
                let a = document.querySelector(".cart-close"),
                    s = n.querySelectorAll('button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])'),
                    o = s[s.length - 1];
                if (!n) return !1;
                for (t = 0, i = (e = n.getElementsByTagName("a")).length; t < i; t++) e[t].addEventListener("focus", c, !0), e[t].addEventListener("blur", c, !0);
                function c() {
                    for (var e = this; - 1 === e.className.indexOf("cart-container");) "li" === e.tagName.toLowerCase() && (-1 !== e.className.indexOf("focus") ? e.className = e.className.replace(" focus", "") : e.className += " focus"), e = e.parentElement
                }
                document.addEventListener("keydown", function(e) {
                    ("Tab" === e.key || 9 === e.keyCode) && (e.shiftKey ? document.activeElement === a && (o.focus(), e.preventDefault()) : document.activeElement === o && (a.focus(), e.preventDefault()))
                })
            } else {
                $('.cart-trigger').focus();
                $('.cart-modal').removeClass('cart-active');
            }
        });
        $('.cart-close, .cart-overlay').on('click',function(e){
            e.preventDefault();
            $('.cart-trigger').focus();
            $('.cart-modal').removeClass('cart-active');
        });
        $('.cart-close, .cart-overlay').on('click',function(e){
            e.preventDefault();
            $('.cart-trigger').focus();
            $('.cart-modal').removeClass('cart-active');
        });
        
        
       // Home Slider
	   if ($('.home-slider').length > 0) {
		var home_slider = tns({
            "container":".home-slider",
            "nav":false,
            "controls":false,
            "mouseDrag":true,
            "autoplay":true,
            "autoplayTimeout":10000,
            "autoplayButtonOutput":false
        });

        $(".tns-next").click(function(){
            home_slider.goTo('next');
        });
        $(".tns-prev").click(function(){
            home_slider.goTo('prev');
        });

        home_slider.events.on('indexChanged', function (event) {
            var data_anim = $("[data-animation]:not(.side-slide [data-animation]");
            data_anim.each(function () {
                var anim_name = $(this).data('animation');
                $(this).removeClass('animated ' + anim_name).css('opacity', '0');
            });
        });
        $("[data-delay]").each(function () {
            var anim_del = $(this).data('delay');
            $(this).css('animation-delay', anim_del);
        });
        $("[data-duration]").each(function () {
            var anim_dur = $(this).data('duration');
            $(this).css('animation-duration', anim_dur);
        });
        home_slider.events.on('indexChanged', function () {
            var data_anim = $(".home-slider").find('.tns-slide-active').find("[data-animation]");
            data_anim.each(function () {
                var anim_name = $(this).data('animation');
                $(this).addClass('animated ' + anim_name).css('opacity', '1');
            });
        });
	   }
		
		// Popular Product Carousel
        var owlPopularProducts = $(".popular-products-carousel .woocommerce .products");
        owlPopularProducts.each(function () {
            $(this).addClass('owl-carousel owl-theme');
        });
        owlPopularProducts.owlCarousel({
            rtl: $("html").attr("dir") == 'rtl' ? true : false,
            loop: false,
            rewind: true,
            nav: true,
            navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
            dots: false,
            margin: 20,
            mouseDrag: true,
            touchDrag: true,
            autoplay: false,
            autoplayTimeout: 12000,
            stagePadding: 0,
            autoHeight: true,
            responsive: {
                0: {
                    items: 1
                },
                576: {
                    items: 2
                },
                992: {
                    items: 4,
                }
            }
        });
        $( '.popular-products-carousel .owl-filter-bar' ).on( 'click', '.item', function() {
          var $item = $(this);
          var filter = $item.data( 'owl-filter' )
          owlPopularProducts.owlcarousel2_filter( filter );
        });        
        $(document).on('click', '.owl-filter-bar a', function () {
            $(this).siblings().removeClass('current');
            $(this).addClass('current');
        });
		

        $('#grid').click(function() {
            $(this).addClass('active');
            $('#list').removeClass('active');
            $('ul.products').fadeOut(300, function() {
                $(this).addClass('grid').removeClass('list').fadeIn(300);
            });
            return false;
        });

        $('#list').click(function() {
            $(this).addClass('active');
            $('#grid').removeClass('active');
            $('ul.products').fadeOut(300, function() {
                $(this).removeClass('grid').addClass('list').fadeIn(300);
            });
            return false;
        });

        $('#gridlist-toggle a').click(function(event) {
            event.preventDefault();
        });

        var $grid = $('.js-masonry').imagesLoaded( function() {
            $grid.masonry({
                itemSelector: '.js-masonry-item',
                percentPosition: true
            });
        });      
    });
	
	
	$(".switcher-tab > button").click(function (e) {
        if (!$(this).hasClass("active-bg")) {
            $(".product-categories,.menu-primary").toggleClass("d-none");
            $(this).parent().children().toggleClass("active-bg");
        }
    });

    // Mobile Menu Browse Category
    var startTrap = function (elem) {
        var tabbable = elem.find('select, input, textarea, button, a, [href],[tabindex]:not([tabindex="-1"])').filter(':visible');

        var firstTabbable = tabbable.first();
        var lastTabbable = tabbable.last();

        $('.product-categories-list li:first-of-type a').focus();

        lastTabbable.on('keydown', function (e) {
            if ((e.which === 9 && !e.shiftKey)) {
                e.preventDefault();
                firstTabbable.focus();
            }
        });

        firstTabbable.on('keydown', function (e) {
            if ((e.which === 9 && e.shiftKey)) {
                e.preventDefault();
                lastTabbable.focus();
            }
        });

        elem.on('keyup', function (e) {
            if (e.keyCode === 27) {
                $(".header-close-menu").click();
            };
        });
    };


    $('.cat-menu-bt').click(function (e) {
        e.preventDefault();
        startTrap($('.main-mobile-build'));
    });

}(jQuery));


! function(n, t) {
    "object" == typeof exports && "undefined" != typeof module ? module.exports = t() : "function" == typeof define && define.amd ? define(t) : n.Splitting = t()
}(this, function() {
    "use strict"
    var u = document,
        l = u.createTextNode.bind(u)

    function d(n, t, e) {
        n.style.setProperty(t, e)
    }

    function f(n, t) {
        return n.appendChild(t)
    }

    function p(n, t, e, r) {
        var i = u.createElement("span")
        return t && (i.className = t), e && (!r && i.setAttribute("data-" + t, e), i.textContent = e), n && f(n, i) || i
    }

    function h(n, t) {
        return n.getAttribute("data-" + t)
    }

    function m(n, t) {
        return n && 0 != n.length ? n.nodeName ? [n] : [].slice.call(n[0].nodeName ? n : (t || u).querySelectorAll(n)) : []
    }

    function o(n) {
        for (var t = []; n--;) t[n] = []
        return t
    }

    function g(n, t) {
        n && n.some(t)
    }

    function c(t) {
        return function(n) {
            return t[n]
        }
    }
    var a = {}

    function n(n, t, e, r) {
        return {
            by: n,
            depends: t,
            key: e,
            split: r
        }
    }

    function e(n) {
        return function t(e, n, r) {
            var i = r.indexOf(e)
            if (-1 == i) r.unshift(e), g(a[e].depends, function(n) {
                t(n, e, r)
            })
            else {
                var u = r.indexOf(n)
                r.splice(i, 1), r.splice(u, 0, e)
            }
            return r
        }(n, 0, []).map(c(a))
    }

    function t(n) {
        a[n.by] = n
    }

    function v(n, r, i, u, o) {
        n.normalize()
        var c = [],
            a = document.createDocumentFragment()
        u && c.push(n.previousSibling)
        var s = []
        return m(n.childNodes).some(function(n) {
            if (!n.tagName || n.hasChildNodes()) {
                if (n.childNodes && n.childNodes.length) return s.push(n), void c.push.apply(c, v(n, r, i, u, o))
                var t = n.wholeText || "",
                    e = t.trim()
                e.length && (" " === t[0] && s.push(l(" ")), g(e.split(i), function(n, t) {
                    t && o && s.push(p(a, "whitespace", " ", o))
                    var e = p(a, r, n)
                    c.push(e), s.push(e)
                }), " " === t[t.length - 1] && s.push(l(" ")))
            } else s.push(n)
        }), g(s, function(n) {
            f(a, n)
        }), n.innerHTML = "", f(n, a), c
    }
    var s = 0
    var i = "words",
        r = n(i, s, "word", function(n) {
            return v(n, "word", /\s+/, 0, 1)
        }),
        y = "chars",
        w = n(y, [i], "char", function(n, e, t) {
            var r = []
            return g(t[i], function(n, t) {
                r.push.apply(r, v(n, "char", "", e.whitespace && t))
            }), r
        })

    function b(t) {
        var f = (t = t || {}).key
        return m(t.target || "[data-splitting]").map(function(a) {
            var s = a["🍌"]
            if (!t.force && s) return s
            s = a["🍌"] = {
                el: a
            }
            var n = e(t.by || h(a, "splitting") || y),
                l = function(n, t) {
                    for (var e in t) n[e] = t[e]
                    return n
                }({}, t)
            return g(n, function(n) {
                if (n.split) {
                    var t = n.by,
                        e = (f ? "-" + f : "") + n.key,
                        r = n.split(a, l, s)
                    e && (i = a, c = (o = "--" + e) + "-index", g(u = r, function(n, t) {
                        Array.isArray(n) ? g(n, function(n) {
                            d(n, c, t)
                        }) : d(n, c, t)
                    }), d(i, o + "-total", u.length)), s[t] = r, a.classList.add(t)
                }
                var i, u, o, c
            }), a.classList.add("splitting"), s
        })
    }

    function N(n, t, e) {
        var r = m(t.matching || n.children, n),
            i = {}
        return g(r, function(n) {
            var t = Math.round(n[e]);
            (i[t] || (i[t] = [])).push(n)
        }), Object.keys(i).map(Number).sort(x).map(c(i))
    }

    function x(n, t) {
        return n - t
    }
    b.html = function(n) {
        var t = (n = n || {}).target = p()
        return t.innerHTML = n.content, b(n), t.outerHTML
    }, b.add = t
    var T = n("lines", [i], "line", function(n, t, e) {
            return N(n, {
                matching: e[i]
            }, "offsetTop")
        }),
        L = n("items", s, "item", function(n, t) {
            return m(t.matching || n.children, n)
        }),
        k = n("rows", s, "row", function(n, t) {
            return N(n, t, "offsetTop")
        }),
        A = n("cols", s, "col", function(n, t) {
            return N(n, t, "offsetLeft")
        }),
        C = n("grid", ["rows", "cols"]),
        M = "layout",
        S = n(M, s, s, function(n, t) {
            var e = t.rows = +(t.rows || h(n, "rows") || 1),
                r = t.columns = +(t.columns || h(n, "columns") || 1)
            if (t.image = t.image || h(n, "image") || n.currentSrc || n.src, t.image) {
                var i = m("img", n)[0]
                t.image = i && (i.currentSrc || i.src)
            }
            t.image && d(n, "background-image", "url(" + t.image + ")")
            for (var u = e * r, o = [], c = p(s, "cell-grid"); u--;) {
                var a = p(c, "cell")
                p(a, "cell-inner"), o.push(a)
            }
            return f(n, c), o
        }),
        H = n("cellRows", [M], "row", function(n, t, e) {
            var r = t.rows,
                i = o(r)
            return g(e[M], function(n, t, e) {
                i[Math.floor(t / (e.length / r))].push(n)
            }), i
        }),
        O = n("cellColumns", [M], "col", function(n, t, e) {
            var r = t.columns,
                i = o(r)
            return g(e[M], function(n, t) {
                i[t % r].push(n)
            }), i
        }),
        j = n("cells", ["cellRows", "cellColumns"], "cell", function(n, t, e) {
            return e[M]
        })
    return t(r), t(w), t(T), t(L), t(k), t(A), t(C), t(S), t(H), t(O), t(j), b
})
Splitting();