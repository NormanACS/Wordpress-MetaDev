/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./js/_theme.js":
/*!**********************!*\
  !*** ./js/_theme.js ***!
  \**********************/
/*! no static exports found */
/***/ (function(module, exports) {

if ("ontouchstart" in window) {
  document.documentElement.className = document.documentElement.className + " touch-enabled";
}

if (navigator.userAgent.match(/(iPod|iPhone|iPad|Android)/i)) {
  document.documentElement.className = document.documentElement.className + " no-parallax";
}

(function ($) {
  var reqAnimFrame = function () {
    return window.requestAnimationFrame || window.webkitRequestAnimationFrame || window.mozRequestAnimationFrame || window.oRequestAnimationFrame || window.msRequestAnimationFrame || function (callback, element) {
      window.setTimeout(callback, 1000 / 60);
    };
  }();

  window.requestInterval = function (fn, delay, cancelFunction) {
    if (!window.requestAnimationFrame && !window.webkitRequestAnimationFrame && !(window.mozRequestAnimationFrame && window.mozCancelRequestAnimationFrame) && // Firefox 5 ships without cancel support
    !window.oRequestAnimationFrame && !window.msRequestAnimationFrame) return window.setInterval(fn, delay);
    var start = new Date().getTime(),
        handle = {};

    function loop() {
      var current = new Date().getTime(),
          delta = current - start;

      if (delta >= delay) {
        fn.call();
        start = new Date().getTime();
      }

      handle.value = reqAnimFrame(loop);

      if (delta >= delay && cancelFunction && cancelFunction.call() === true) {
        clearRequestInterval(handle);
      }
    }

    ;
    handle.value = reqAnimFrame(loop);
    return handle;
  };

  window.clearRequestInterval = function (handle) {
    window.cancelAnimationFrame ? window.cancelAnimationFrame(handle.value) : window.webkitCancelAnimationFrame ? window.webkitCancelAnimationFrame(handle.value) : window.webkitCancelRequestAnimationFrame ? window.webkitCancelRequestAnimationFrame(handle.value) :
    /* Support for legacy API */
    window.mozCancelRequestAnimationFrame ? window.mozCancelRequestAnimationFrame(handle.value) : window.oCancelRequestAnimationFrame ? window.oCancelRequestAnimationFrame(handle.value) : window.msCancelRequestAnimationFrame ? window.msCancelRequestAnimationFrame(handle.value) : clearInterval(handle);
  };

  if (!$.event.special.tap) {
    $.event.special.tap = {
      setup: function setup(data, namespaces) {
        var $elem = $(this);
        $elem.bind('touchstart', $.event.special.tap.handler).bind('touchmove', $.event.special.tap.handler).bind('touchend', $.event.special.tap.handler);
      },
      teardown: function teardown(namespaces) {
        var $elem = $(this);
        $elem.unbind('touchstart', $.event.special.tap.handler).unbind('touchmove', $.event.special.tap.handler).unbind('touchend', $.event.special.tap.handler);
      },
      handler: function handler(event) {
        var $elem = $(this);
        $elem.data(event.type, 1);

        if (event.type === 'touchend' && !$elem.data('touchmove')) {
          event.type = 'tap';
          $.event.handle.apply(this, arguments);
        } else if ($elem.data('touchend')) {
          $elem.removeData('touchstart touchmove touchend');
        }
      }
    };
  }

  if (!$.fn.isInView) {
    $.fn.isInView = function (fullyInView) {
      var element = this;
      var pageTop = $(window).scrollTop();
      var pageBottom = pageTop + $(window).height();
      var elementTop = $(element).offset().top;
      var elementBottom = elementTop + $(element).height();

      if (fullyInView === true) {
        return pageTop < elementTop && pageBottom > elementBottom;
      } else {
        return elementTop <= pageBottom && elementBottom >= pageTop;
      }
    };
  }

  if (!$.throttle) {
    $.throttle = function (fn, threshhold, scope) {
      threshhold || (threshhold = 250);
      var last, deferTimer;
      return function () {
        var context = scope || this;
        var now = +new Date(),
            args = arguments;

        if (last && now < last + threshhold) {
          // hold on to it
          clearTimeout(deferTimer);
          deferTimer = setTimeout(function () {
            last = now;
            fn.apply(context, args);
          }, threshhold);
        } else {
          last = now;
          fn.apply(context, args);
        }
      };
    };
  }

  if (!$.debounce) {
    $.debounce = function (func, wait, immediate) {
      var timeout;
      return function () {
        var context = this,
            args = arguments;

        var later = function later() {
          timeout = null;
          if (!immediate) func.apply(context, args);
        };

        var callNow = immediate && !timeout;
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
        if (callNow) func.apply(context, args);
      };
    };
  }
})(jQuery);

/***/ }),

/***/ "./js/backstretch.js":
/*!***************************!*\
  !*** ./js/backstretch.js ***!
  \***************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _utils__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./utils */ "./js/utils.js");

Object(_utils__WEBPACK_IMPORTED_MODULE_0__["onDocReady"])(function ($) {
  if (window.materialis_backstretch) {
    window.materialis_backstretch.duration = parseInt(window.materialis_backstretch.duration);
    window.materialis_backstretch.transitionDuration = parseInt(window.materialis_backstretch.transitionDuration);
    var images = materialis_backstretch.images;

    if (!images) {
      return;
    }

    jQuery('.header-homepage, .header').backstretch(images, materialis_backstretch);
  }
});

/***/ }),

/***/ "./js/blog-comments.js":
/*!*****************************!*\
  !*** ./js/blog-comments.js ***!
  \*****************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _utils__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./utils */ "./js/utils.js");

Object(_utils__WEBPACK_IMPORTED_MODULE_0__["onDocReady"])(function ($) {
  var $commentsWrapper = jQuery('.comments-form'),
      $commentsForm = jQuery('#commentform');

  if (window.location.hash === "#respond") {
    $commentsWrapper.show();
  }

  $('.add-comment-toggler').click(function () {
    if ($commentsForm.is(':visible')) {
      jQuery('html, body').animate({
        scrollTop: $commentsForm.offset().top - jQuery('.navigation-bar.fixto-fixed').outerHeight() - 30
      }, 600);
      return;
    }

    $commentsWrapper.show();
    $('html, body').animate({
      scrollTop: $commentsWrapper.offset().top - jQuery('.navigation-bar.fixto-fixed').outerHeight() - 30
    }, 600);
    return false;
  });
});

/***/ }),

/***/ "./js/counters.js":
/*!************************!*\
  !*** ./js/counters.js ***!
  \************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _utils__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./utils */ "./js/utils.js");


(function ($) {
  function updateCounterCircle($el) {
    var $valueHolder = $el.find('[data-countup]');
    var val = $valueHolder.text();
    val = jQuery.map(val.match(/[\d.]*[\d]+/g), function (x) {
      return x;
    }).join([]);
    var max = $valueHolder.attr('data-max') !== undefined ? $valueHolder.attr('data-max') : 100;
    var min = $valueHolder.attr('data-min') !== undefined ? $valueHolder.attr('data-min') : 0;

    if (min > max) {
      var aux = max;
      max = min;
      min = aux;
    }

    if (!val) {
      val = min;
    }

    var percentage = val / max * 100;
    var $circle = $el.find('.circle-bar');
    var r = $circle.attr('r');
    var c = Math.PI * (r * 2);

    if (percentage < 0) {
      percentage = 0;
    }

    if (percentage > 100) {
      percentage = 100;
    }

    var pct = c * (100 - percentage) / 100;
    $circle.css({
      strokeDashoffset: pct
    });
    Object(_utils__WEBPACK_IMPORTED_MODULE_0__["onDocReady"])(function () {
      if (!wp || !wp.customize) {
        $circle.parent().height($circle.parent().width());
      }
    });
  }

  function initCounterCircle($circle) {
    updateCounterCircle($circle);
    $circle.find('[data-countup]').bind('countup.update', function () {
      updateCounterCircle($circle);
    }); // $circle.find('[data-countup]').bind('DOMSubtreeModified', updateCircleOnDOMSubtreeModified);

    $circle.data('doCircle', function () {
      updateCounterCircle($circle);
    });
  }

  function initCountUP($self, force) {
    var min = $self.attr('data-min') !== undefined ? $self.attr('data-min') : 0,
        stopAt = $self.attr('data-stop'),
        max = $self.attr('data-max') !== undefined ? $self.attr('data-max') : 100,
        prefix = $self.attr('data-prefix') || "",
        suffix = $self.attr('data-suffix') || "",
        duration = $self.attr('data-duration') || 2000,
        decimals = $self.attr('data-decimals') || 0;

    if (stopAt !== undefined) {
      max = stopAt;
    }

    var formattedMax = '';

    try {
      var counter = new CountUp($self[0], parseInt(min), parseInt(max), parseInt(decimals), parseInt(duration) / 1000, {
        prefix: prefix,
        suffix: suffix,
        onUpdate: function onUpdate(value) {
          $self.trigger('countup.update', [value]);
        }
      });
      formattedMax = counter.options.formattingFn(parseInt(max));
    } catch (e) {
      console.error('invalid countup args', {
        min: min,
        max: max,
        decimals: decimals,
        duration: duration,
        suffix: suffix,
        prefix: prefix
      });
    }

    $self.data('countup', counter);
    $self.attr('data-max-computed', formattedMax);

    if (force) {
      $self.data('countup').reset();
    }

    if ($self.isInView(true) || force) {
      $self.data('countup').start();
    }

    $self.data('restartCountUp', function () {
      initCountUP($self);
    });
  }

  $('.circle-counter').each(function () {
    initCounterCircle($(this));
  });
  var $countUPs = $('[data-countup]');
  $countUPs.each(function () {
    var $self = $(this);
    initCountUP($self);
  });
  $(window).on('scroll', function () {
    $countUPs.each(function () {
      var $self = $(this);

      if ($self.isInView(true) && !$self.data('one')) {
        $self.data('countup').start();
        $self.data('one', true);
      } else {// $self.data('countup').reset();
      }
    });
  });
  Object(_utils__WEBPACK_IMPORTED_MODULE_0__["onDocReady"])(function () {
    if (!wp || !wp.customize) {
      $(window).on('resize', function () {
        $('.circle-counter .circle-svg').each(function () {
          $(this).height($(this).width());
        });
      });
    }
  }); // customizer binding

  if (parent.CP_Customizer) {
    parent.CP_Customizer.addModule(function (CP_Customizer) {
      CP_Customizer.hooks.addAction('after_node_insert', function ($node) {
        if ($node.is('[data-countup]')) {
          if ($node.closest('.circle-counter').length) {
            initCounterCircle($node.closest('.circle-counter'));
          }

          initCountUP($node, true);
        }

        $node.find('[data-countup]').each(function () {
          if ($(this).closest('.circle-counter').length) {
            initCounterCircle($(this).closest('.circle-counter'));
          }

          initCountUP($(this), true);
        });
      });
    });
  } // Bar counters


  function initCountBar($self, force) {
    if ($self.data('one')) return;
    var min = $self.attr('data-min') !== undefined ? $self.attr('data-min') : 0;
    var max = $self.attr('data-max');
    var stop = $self.attr('data-stop');
    var color = $self.attr('data-bgcolor');
    var suffix = $self.attr('data-suffix');
    var text = $self.attr('data-text');

    if (stop !== undefined) {
      max = stop;
    }

    try {
      $self.LineProgressbar({
        min: min || 0,
        max: max || 100,
        stop: stop || 50,
        color: color || '#654ea3',
        suffix: suffix || '%',
        text: text || 'Category'
      });
    } catch (e) {
      console.error('invalid countup args', {
        min: min,
        max: max,
        stop: stop,
        color: color,
        suffix: suffix,
        text: text
      });
    }

    $self.data('restartCountBar', function ($item) {
      $self.LineProgressbar({
        min: $item.attr('data-min') || 0,
        max: $item.attr('data-max') || 100,
        stop: $item.attr('data-stop') || 50,
        color: $item.attr('data-bgcolor') || '#654ea3',
        suffix: $item.attr('data-suffix') || '%',
        text: $item.attr('data-text') || 'Category'
      });
    });
  }

  var $countBars = $('.progressline');
  /*
  $countBars.each(function () {
      var $self = $(this);
      initCountBar($self);
  });
  */

  $(window).on('scroll', function () {
    $countBars.each(function () {
      var $self = $(this);

      if ($self.isInView(true) && !$self.data('one')) {
        initCountBar($self);
        $self.data('one', true);
      }
    });
  });

  if (parent.CP_Customizer) {
    parent.CP_Customizer.addModule(function (CP_Customizer) {
      CP_Customizer.hooks.addAction('after_node_insert', function ($node) {
        if ($node.is('[data-countbar]')) {
          initCountBar($node, true);
        }

        $node.find('[data-countbar]').each(function () {
          initCountBar($(this), true);
        });
      });
    });
  }
})(jQuery);

/***/ }),

/***/ "./js/footer.js":
/*!**********************!*\
  !*** ./js/footer.js ***!
  \**********************/
/*! no static exports found */
/***/ (function(module, exports) {

(function ($, MaterialisTheme) {
  function toggleFooter(footer, pageContent) {
    var footerTop = footer.offset().top + footer.outerHeight();
    var pageBottom = pageContent.offset().top + pageContent.height();

    if (footerTop >= pageBottom) {
      footer.css('visibility', 'visible');
    } else {
      footer.css('visibility', '');
    }
  }

  function updateFooter(footer, pageContent) {
    var margin = footer.outerHeight() - 2;

    if (pageContent.is('.boxed-layout')) {
      margin += 36;
    }

    pageContent.css("margin-bottom", margin);
    toggleFooter(footer, pageContent);
  }

  window.materialisFooterParalax = function () {
    var footer = $('.footer.paralax');

    if (footer.length) {
      if (footer.parents('.no-parallax').length) {
        footer.css('visibility', 'visible');
        return;
      }

      $('.header-wrapper').css('z-index', 1);
      var pageContent = footer.prev();
      pageContent.addClass('footer-shadow');
      pageContent.css({
        'position': 'relative',
        'z-index': 1
      });
      $(window).bind('resize.footerParalax', function () {
        updateFooter(footer, pageContent);
      });
      jQuery(document).ready(function () {
        window.setTimeout(function () {
          updateFooter(footer, pageContent);
        }, 100);
      });
      updateFooter(footer, pageContent);
      $(window).bind('scroll.footerParalax', function () {
        toggleFooter(footer, pageContent);
      });
    }
  };

  window.materialisStopFooterParalax = function () {
    var footer = $('.footer');
    var pageContent = footer.prev();
    $('.header-wrapper').css('z-index', 0);
    pageContent.removeClass('footer-shadow');
    pageContent.css('margin-bottom', '0px');
    $(window).unbind('resize.footerParalax');
    $(window).unbind('scroll.footerParalax');
  };

  materialisFooterParalax();
  /*
      if (footer.length && window.wp && window.wp.customize) {
          // Select the node that will be observed for mutations
          let debouncedUpdate = jQuery.debounce(updateFooter, 500);
          new MutationObserver(function (mutationsList) {
              for (let mutation of mutationsList) {
                  if (mutation.type === 'childList') {
                      debouncedUpdate();
                  }
                  else if (mutation.type === 'attributes') {
                      debouncedUpdate()
                  }
              }
          }).observe(footer[0], {
              attributes: true,
              childList: true,
              subtree: true
          });
      }
    */

  MaterialisTheme.updateFooterParallax = function () {
    var footer = $('.footer.paralax');
    var pageContent = footer.prev();

    if (footer.length) {
      updateFooter(footer, pageContent);
    }
  };
})(jQuery, MaterialisTheme);

/***/ }),

/***/ "./js/form-fields/checkbox-in-label.js":
/*!*********************************************!*\
  !*** ./js/form-fields/checkbox-in-label.js ***!
  \*********************************************/
/*! exports provided: CheckboxInsideLabelField */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "CheckboxInsideLabelField", function() { return CheckboxInsideLabelField; });
/* harmony import */ var _material_animation__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @material/animation */ "./node_modules/@material/animation/index.js");
/* harmony import */ var _material_base_component__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @material/base/component */ "./node_modules/@material/base/component.js");
/* harmony import */ var _material_selection_control__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @material/selection-control */ "./node_modules/@material/selection-control/index.js");
/* harmony import */ var _material_checkbox__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @material/checkbox */ "./node_modules/@material/checkbox/index.js");
/* harmony import */ var _material_ripple__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @material/ripple */ "./node_modules/@material/ripple/index.js");
/* harmony import */ var _material_ripple_util__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @material/ripple/util */ "./node_modules/@material/ripple/util.js");
function _typeof2(obj) { if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof2 = function _typeof2(obj) { return typeof obj; }; } else { _typeof2 = function _typeof2(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof2(obj); }

function _typeof(obj) {
  if (typeof Symbol === "function" && _typeof2(Symbol.iterator) === "symbol") {
    _typeof = function _typeof(obj) {
      return _typeof2(obj);
    };
  } else {
    _typeof = function _typeof(obj) {
      return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : _typeof2(obj);
    };
  }

  return _typeof(obj);
}

function _classCallCheck(instance, Constructor) {
  if (!(instance instanceof Constructor)) {
    throw new TypeError("Cannot call a class as a function");
  }
}

function _possibleConstructorReturn(self, call) {
  if (call && (_typeof(call) === "object" || typeof call === "function")) {
    return call;
  }

  return _assertThisInitialized(self);
}

function _assertThisInitialized(self) {
  if (self === void 0) {
    throw new ReferenceError("this hasn't been initialised - super() hasn't been called");
  }

  return self;
}

function _getPrototypeOf(o) {
  _getPrototypeOf = Object.setPrototypeOf ? Object.getPrototypeOf : function _getPrototypeOf(o) {
    return o.__proto__ || Object.getPrototypeOf(o);
  };
  return _getPrototypeOf(o);
}

function _inherits(subClass, superClass) {
  if (typeof superClass !== "function" && superClass !== null) {
    throw new TypeError("Super expression must either be null or a function");
  }

  subClass.prototype = Object.create(superClass && superClass.prototype, {
    constructor: {
      value: subClass,
      writable: true,
      configurable: true
    }
  });
  if (superClass) _setPrototypeOf(subClass, superClass);
}

function _setPrototypeOf(o, p) {
  _setPrototypeOf = Object.setPrototypeOf || function _setPrototypeOf(o, p) {
    o.__proto__ = p;
    return o;
  };

  return _setPrototypeOf(o, p);
}








var CheckboxInsideLabelField =
/*#__PURE__*/
function (_MDCCheckbox) {
  _inherits(CheckboxInsideLabelField, _MDCCheckbox);

  function CheckboxInsideLabelField(input) {
    _classCallCheck(this, CheckboxInsideLabelField);

    var container = document.createElement('div');
    input.classList.add('mdc-checkbox__native-control');
    var svgPath = '<path class="mdc-checkbox__checkmark-path" fill="none" stroke="white" d="M1.73,12.91 8.1,19.28 22.79,4.59"/>';
    var mixedMark = '<div class="mdc-checkbox__mixedmark"></div>';
    var svg = '<svg class="mdc-checkbox__checkmark" viewBox="0 0 24 24">' + svgPath + '</svg>';
    var checkboxBackground = '<div class="mdc-checkbox__background">' + svg + mixedMark + '</div>';
    var labelContent = jQuery(input).parent().find('span').html();
    var labelWrapper = '<label for="' + jQuery(input).attr('id') + '">' + labelContent + '</label>';
    var checkboxContent = '<div class="mdc-checkbox">' + input.outerHTML + checkboxBackground + '</div>';
    var label = jQuery(input).parent();
    jQuery(container).addClass('mdc-form-field');
    jQuery(container).html(checkboxContent + labelWrapper);
    label.before(container);
    label.remove();
    return _possibleConstructorReturn(this, _getPrototypeOf(CheckboxInsideLabelField).call(this, container));
  }

  return CheckboxInsideLabelField;
}(_material_checkbox__WEBPACK_IMPORTED_MODULE_3__["MDCCheckbox"]);



/***/ }),

/***/ "./js/form-fields/input-in-label.js":
/*!******************************************!*\
  !*** ./js/form-fields/input-in-label.js ***!
  \******************************************/
/*! exports provided: InputInsideLabelField */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "InputInsideLabelField", function() { return InputInsideLabelField; });
/* harmony import */ var _material_textfield__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @material/textfield */ "./node_modules/@material/textfield/index.js");
/* harmony import */ var _material_floating_label__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @material/floating-label */ "./node_modules/@material/floating-label/index.js");
/* harmony import */ var _material_notched_outline__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @material/notched-outline */ "./node_modules/@material/notched-outline/index.js");
/* harmony import */ var _material_line_ripple__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @material/line-ripple */ "./node_modules/@material/line-ripple/index.js");
/* harmony import */ var _material_textfield_constants__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @material/textfield/constants */ "./node_modules/@material/textfield/constants.js");
function _typeof2(obj) { if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof2 = function _typeof2(obj) { return typeof obj; }; } else { _typeof2 = function _typeof2(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof2(obj); }

function _typeof(obj) {
  if (typeof Symbol === "function" && _typeof2(Symbol.iterator) === "symbol") {
    _typeof = function _typeof(obj) {
      return _typeof2(obj);
    };
  } else {
    _typeof = function _typeof(obj) {
      return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : _typeof2(obj);
    };
  }

  return _typeof(obj);
}

function _classCallCheck(instance, Constructor) {
  if (!(instance instanceof Constructor)) {
    throw new TypeError("Cannot call a class as a function");
  }
}

function _defineProperties(target, props) {
  for (var i = 0; i < props.length; i++) {
    var descriptor = props[i];
    descriptor.enumerable = descriptor.enumerable || false;
    descriptor.configurable = true;
    if ("value" in descriptor) descriptor.writable = true;
    Object.defineProperty(target, descriptor.key, descriptor);
  }
}

function _createClass(Constructor, protoProps, staticProps) {
  if (protoProps) _defineProperties(Constructor.prototype, protoProps);
  if (staticProps) _defineProperties(Constructor, staticProps);
  return Constructor;
}

function _possibleConstructorReturn(self, call) {
  if (call && (_typeof(call) === "object" || typeof call === "function")) {
    return call;
  }

  return _assertThisInitialized(self);
}

function _assertThisInitialized(self) {
  if (self === void 0) {
    throw new ReferenceError("this hasn't been initialised - super() hasn't been called");
  }

  return self;
}

function _getPrototypeOf(o) {
  _getPrototypeOf = Object.setPrototypeOf ? Object.getPrototypeOf : function _getPrototypeOf(o) {
    return o.__proto__ || Object.getPrototypeOf(o);
  };
  return _getPrototypeOf(o);
}

function _inherits(subClass, superClass) {
  if (typeof superClass !== "function" && superClass !== null) {
    throw new TypeError("Super expression must either be null or a function");
  }

  subClass.prototype = Object.create(superClass && superClass.prototype, {
    constructor: {
      value: subClass,
      writable: true,
      configurable: true
    }
  });
  if (superClass) _setPrototypeOf(subClass, superClass);
}

function _setPrototypeOf(o, p) {
  _setPrototypeOf = Object.setPrototypeOf || function _setPrototypeOf(o, p) {
    o.__proto__ = p;
    return o;
  };

  return _setPrototypeOf(o, p);
}







var InputInsideLabelField =
/*#__PURE__*/
function (_MDCTextField) {
  _inherits(InputInsideLabelField, _MDCTextField);

  function InputInsideLabelField(input, type) {
    var _this;

    _classCallCheck(this, InputInsideLabelField);

    var container = document.createElement('div');

    if (type == 1) {
      var label = jQuery(input).parent().parent();
      jQuery(label).attr('for', input.name);
      jQuery(label).find('br').remove();
      jQuery(label).find('span').remove();
    }

    if (type == 2) {
      var label = jQuery(input).parent().find('label');

      if (!label.length) {
        jQuery(input).parent().prepend('<label for="' + input.name + '">' + input.placeholder + '</label>');
        var label = jQuery(input).parent().find('label');
      }
    }

    if (type == 3) {
      var label = jQuery(input).parent().parent().find('label');

      if (!label.length) {
        jQuery(input).parent().parent().prepend('<label for="' + input.name + '">' + input.placeholder.replace('(optional)', '') + '</label>');
        var label = jQuery(input).parent().parent().find('label');
      }

      jQuery(input).parent().parent().find('.woocommerce-input-wrapper').remove();
    }

    label.before(container);
    container.appendChild(input);
    container.appendChild(label[0]);
    _this = _possibleConstructorReturn(this, _getPrototypeOf(InputInsideLabelField).call(this, container));
    /** @private {?Element} */

    _this.input_;
    /** @type {?MDCRipple} */

    _this.ripple;
    /** @private {?MDCLineRipple} */

    _this.lineRipple_;
    /** @private {?MDCTextFieldHelperText} */

    _this.helperText_;
    /** @private {?MDCTextFieldIcon} */

    _this.icon_;
    /** @private {?MDCFloatingLabel} */

    _this.label_;
    /** @private {?MDCNotchedOutline} */

    _this.outline_;
    return _this;
  }

  _createClass(InputInsideLabelField, [{
    key: "initialize",
    value: function initialize() {
      var _this2 = this;

      var rippleFactory = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : function (el, foundation) {
        return new MDCRipple(el, foundation);
      };
      var lineRippleFactory = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : function (el) {
        return new _material_line_ripple__WEBPACK_IMPORTED_MODULE_3__["MDCLineRipple"](el);
      };
      var helperTextFactory = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : function (el) {
        return new _material_textfield__WEBPACK_IMPORTED_MODULE_0__["MDCTextFieldHelperText"](el);
      };
      var iconFactory = arguments.length > 3 && arguments[3] !== undefined ? arguments[3] : function (el) {
        return new _material_textfield__WEBPACK_IMPORTED_MODULE_0__["MDCTextFieldIcon"](el);
      };
      var labelFactory = arguments.length > 4 && arguments[4] !== undefined ? arguments[4] : function (el) {
        return new _material_floating_label__WEBPACK_IMPORTED_MODULE_1__["MDCFloatingLabel"](el);
      };
      var outlineFactory = arguments.length > 5 && arguments[5] !== undefined ? arguments[5] : function (el) {
        return new _material_notched_outline__WEBPACK_IMPORTED_MODULE_2__["MDCNotchedOutline"](el);
      };
      this.input_ = this.root_.querySelector('input,textarea');
      this.input_.classList.add('mdc-text-field__input');
      var labelElement = this.root_.querySelector('label');
      this.root_.classList.add('mdc-text-field');

      if (this.input_.tagName.toLocaleLowerCase() === 'textarea') {
        this.root_.classList.add('mdc-text-field--textarea');
      }

      if (labelElement) {
        labelElement.classList.add('mdc-floating-label');
        this.label_ = labelFactory(labelElement);
      }

      var lineRippleElement = this.root_.querySelector(_material_textfield_constants__WEBPACK_IMPORTED_MODULE_4__["strings"].BOTTOM_LINE_SELECTOR);

      if (lineRippleElement) {
        this.lineRipple_ = lineRippleFactory(lineRippleElement);
      } else {
        if (this.input_.tagName.toLocaleLowerCase() !== 'textarea') {
          var newRipple = document.createElement('div');
          newRipple.classList.add('mdc-line-ripple');
          this.root_.appendChild(newRipple);
          this.lineRipple_ = lineRippleFactory(newRipple);
        }
      }

      var outlineElement = this.root_.querySelector(_material_textfield_constants__WEBPACK_IMPORTED_MODULE_4__["strings"].OUTLINE_SELECTOR);

      if (outlineElement) {
        this.outline_ = outlineFactory(outlineElement);
      }

      if (this.input_.hasAttribute(_material_textfield_constants__WEBPACK_IMPORTED_MODULE_4__["strings"].ARIA_CONTROLS)) {
        var helperTextElement = document.getElementById(this.input_.getAttribute(_material_textfield_constants__WEBPACK_IMPORTED_MODULE_4__["strings"].ARIA_CONTROLS));

        if (helperTextElement) {
          this.helperText_ = helperTextFactory(helperTextElement);
        }
      }

      var iconElement = this.root_.querySelector(_material_textfield_constants__WEBPACK_IMPORTED_MODULE_4__["strings"].ICON_SELECTOR);

      if (iconElement) {
        this.icon_ = iconFactory(iconElement);
      }

      this.ripple = null;

      if (this.root_.classList.contains(_material_textfield_constants__WEBPACK_IMPORTED_MODULE_4__["cssClasses"].BOX) || this.root_.classList.contains(_material_textfield_constants__WEBPACK_IMPORTED_MODULE_4__["cssClasses"].OUTLINED)) {
        // For outlined text fields, the ripple is instantiated on the outline element instead of the root element
        // to clip the ripple at the outline while still allowing the label to be visible beyond the outline.
        var rippleCapableSurface = outlineElement ? this.outline_ : this;
        var rippleRoot = outlineElement ? outlineElement : this.root_;
        var MATCHES = getMatchesProperty(HTMLElement.prototype);
        var adapter = Object.assign(MDCRipple.createAdapter(
        /** @type {!RippleCapableSurface} */
        rippleCapableSurface), {
          isSurfaceActive: function isSurfaceActive() {
            return _this2.input_[MATCHES](':active');
          },
          registerInteractionHandler: function registerInteractionHandler(type, handler) {
            return _this2.input_.addEventListener(type, handler);
          },
          deregisterInteractionHandler: function deregisterInteractionHandler(type, handler) {
            return _this2.input_.removeEventListener(type, handler);
          }
        });
        var foundation = new MDCRippleFoundation(adapter);
        this.ripple = rippleFactory(rippleRoot, foundation);
      }
    }
  }]);

  return InputInsideLabelField;
}(_material_textfield__WEBPACK_IMPORTED_MODULE_0__["MDCTextField"]);



/***/ }),

/***/ "./js/forms.js":
/*!*********************!*\
  !*** ./js/forms.js ***!
  \*********************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _material_form_field__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @material/form-field */ "./node_modules/@material/form-field/index.js");
/* harmony import */ var _material_textfield__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @material/textfield */ "./node_modules/@material/textfield/index.js");
/* harmony import */ var _material_checkbox__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @material/checkbox */ "./node_modules/@material/checkbox/index.js");
/* harmony import */ var _form_fields_input_in_label__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./form-fields/input-in-label */ "./js/form-fields/input-in-label.js");
/* harmony import */ var _form_fields_checkbox_in_label__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./form-fields/checkbox-in-label */ "./js/form-fields/checkbox-in-label.js");
/* harmony import */ var _utils__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./utils */ "./js/utils.js");
//import {MDCFormField, MDCFormFieldFoundation} from '@material/form-field';






Object(_utils__WEBPACK_IMPORTED_MODULE_5__["onDocReady"])(function ($) {
  var textFields = document.querySelectorAll('.mdc-text-field');
  var inputSelector = 'input:not([type=hidden]):not([type=submit]):not([type=reset]):not([type=checkbox])';

  for (var i = 0, textField; textField = textFields[i]; i++) {
    new _material_textfield__WEBPACK_IMPORTED_MODULE_1__["MDCTextField"](textField);
  }

  var inputsInLabels = jQuery("p > label > span > ".concat(inputSelector, " , p > label > span > textarea"));

  for (var _i = 0; _i < inputsInLabels.length; _i++) {
    var input = inputsInLabels[_i];

    if (Object(_utils__WEBPACK_IMPORTED_MODULE_5__["isVisible"])(input)) {
      new _form_fields_input_in_label__WEBPACK_IMPORTED_MODULE_3__["InputInsideLabelField"](input, 1);
    }
  }

  var inputsInParagraphs = jQuery(".woocommerce p > ".concat(inputSelector, ", .woocommerce p > textarea"));

  for (var _i2 = 0; _i2 < inputsInParagraphs.length; _i2++) {
    var _input = inputsInParagraphs[_i2];
    new _form_fields_input_in_label__WEBPACK_IMPORTED_MODULE_3__["InputInsideLabelField"](_input, 2);
  }

  var inputsInSpans = jQuery(".woocommerce p > span > ".concat(inputSelector, ", .woocommerce p > span > textarea"));

  for (var _i3 = 0; _i3 < inputsInSpans.length; _i3++) {
    var _input2 = inputsInSpans[_i3];
    new _form_fields_input_in_label__WEBPACK_IMPORTED_MODULE_3__["InputInsideLabelField"](_input2, 3);
  }

  var checkboxesInLabels = jQuery(".woocommerce label > input[type=checkbox]");

  for (var _i4 = 0; _i4 < checkboxesInLabels.length; _i4++) {
    var checkbox = checkboxesInLabels[_i4];
    new _form_fields_checkbox_in_label__WEBPACK_IMPORTED_MODULE_4__["CheckboxInsideLabelField"](checkbox);
  } // custom script for create an account from checkout -> to be moved


  $('.woocommerce-checkout .woocommerce-account-fields #createaccount').on('change', function () {
    $('div.create-account').hide();

    if ($(this).is(':checked')) {
      // Ensure password is not pre-populated.
      $('#account_password').val('').change();
      $('div.create-account').slideDown();
    }
  });
  /* custom script for create an account password from checkout -> to be moved */

  /* password strength label and password strength hint are added/removed on keyup, thus
    making hard for MDCTextFieldHelperText to be implemented on MDCTextField */

  $('.woocommerce #account_password, .woocommerce .edit-account #password_1').on('keyup', function () {
    var _this = this;

    sleep(100).then(function () {
      var hasPasswordLabel = false,
          hasPasswordHint = false;
      var parent = $(_this).parent();
      var passwordLabel = parent.find('.woocommerce-password-strength');
      var passwordHint = parent.find('.woocommerce-password-hint');
      var parentMarginBottom = 8;

      if (passwordLabel.css('display') == 'block') {
        hasPasswordLabel = true;
        var passwordLabelHeight = 30;

        if (passwordLabel.outerHeight() != 6) {
          passwordLabelHeight = passwordLabel.outerHeight();
        }

        passwordLabel.css('bottom', '-' + passwordLabelHeight + 'px');
        parentMarginBottom += passwordLabelHeight;
      }

      if (passwordHint.length) {
        hasPasswordHint = true;
        passwordHint.css('position', 'absolute');
        passwordHint.css('bottom', '-' + (passwordHint.outerHeight() + passwordLabelHeight) + 'px');
        passwordHint.show();
        parentMarginBottom += passwordHint.outerHeight();
      }

      parent.css('margin-bottom', parentMarginBottom + 'px');
    });
  });
});

function sleep(ms) {
  return new Promise(function (resolve) {
    return setTimeout(resolve, ms);
  });
}

/***/ }),

/***/ "./js/gallery.js":
/*!***********************!*\
  !*** ./js/gallery.js ***!
  \***********************/
/*! no static exports found */
/***/ (function(module, exports) {

(function ($) {
  window.MaterialisCaptionsGallery = function (gallery) {
    var $gallery = $(gallery);

    if (!$gallery.is('.captions-enabled') || $gallery.attr('data-ready')) {
      return;
    }

    $gallery.find('dl').each(function () {
      var $dl = $(this);

      if ($dl.find('dd').length === 0 && $dl.find('img').attr('alt')) {
        $dl.append("<dd class='wp-caption-text gallery-caption'>" + $dl.find('img').attr('alt') + "</dd>");
      }

      if ($dl.find('dd').length) {
        $dl.find('a').attr('data-caption', $dl.find('dd').html());
      }
    });
    $gallery.attr('data-ready', 'true');
  };

  $(function ($) {
    var $captionsGalleries = $(".materialis-gallery.captions-enabled");
    $captionsGalleries.each(function () {
      window.MaterialisCaptionsGallery(this);
    });
  });
})(jQuery);

/***/ }),

/***/ "./js/header-animations.js":
/*!*********************************!*\
  !*** ./js/header-animations.js ***!
  \*********************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _utils__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./utils */ "./js/utils.js");

Object(_utils__WEBPACK_IMPORTED_MODULE_0__["onDocReady"])(function () {
  var morphed = jQuery("[data-text-effect]");

  if (jQuery.fn.typed && morphed.length && JSON.parse(materialis_morph.header_text_morph)) {
    morphed.each(function () {
      jQuery(this).empty();
      jQuery(this).typed({
        strings: JSON.parse(jQuery(this).attr('data-text-effect')),
        typeSpeed: parseInt(materialis_morph.header_text_morph_speed),
        loop: true
      });
    });
  }
});

/***/ }),

/***/ "./js/homepage-arrow.js":
/*!******************************!*\
  !*** ./js/homepage-arrow.js ***!
  \******************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _utils__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./utils */ "./js/utils.js");

Object(_utils__WEBPACK_IMPORTED_MODULE_0__["onDocReady"])(function ($) {
  $('.header-homepage-arrow-c').click(function () {
    scrollToSection($('body').find('[data-id]').first());
  });
});

/***/ }),

/***/ "./js/masonry.js":
/*!***********************!*\
  !*** ./js/masonry.js ***!
  \***********************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _utils__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./utils */ "./js/utils.js");

Object(_utils__WEBPACK_IMPORTED_MODULE_0__["onDocReady"])(function ($) {
  if (!MaterialisTheme.blog_posts_as_masonry_grid) {
    return;
  }

  var postsListRow = $(".post-list.row");

  if (!postsListRow.length) {
    return true;
  }

  function imageLoaded() {
    loadedImages++;

    if (images.length === loadedImages && postsListRow.data().postsListRow) {
      postsListRow.data().masonry.layout();
    }
  }

  var items = postsListRow.find(".post-list-item").not('.highlighted-post'),
      images = postsListRow.find('img'),
      loadedImages = 0,
      debouncepostsListRowRefresh = jQuery.debounce(function () {
    postsListRow.data().masonry.layout();
  }, 500);
  items.each(function () {
    $(this).css({
      width: $(this).css('max-width')
    });
  });
  postsListRow.masonry({
    itemSelector: '.post-list-item',
    percentPosition: true,
    columnWidth: items.eq(0).attr('data-masonry-width')
  });
  images.each(function () {
    $(this).on('load', imageLoaded);
    debouncepostsListRowRefresh();
  });
});

/***/ }),

/***/ "./js/offscreen-menu.js":
/*!******************************!*\
  !*** ./js/offscreen-menu.js ***!
  \******************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _utils__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./utils */ "./js/utils.js");

Object(_utils__WEBPACK_IMPORTED_MODULE_0__["onDocReady"])(function () {
  var $menus = jQuery('.offcanvas_menu');
  var $offCanvasWrapper = jQuery('#offcanvas-wrapper');

  if ($offCanvasWrapper.length) {
    jQuery('html').addClass('has-offscreen');
    $offCanvasWrapper.appendTo('body');
    $offCanvasWrapper.removeClass('force-hide');
    $offCanvasWrapper.on('kube.offcanvas.open', function () {
      jQuery('html').addClass('offcanvas-opened');
    });
    $offCanvasWrapper.on('kube.offcanvas.close', function () {
      jQuery('html').removeClass('offcanvas-opened');
    });
  }

  $menus.each(function () {
    var $menu = jQuery(this);
    $menu.on('materialis.open-all', function () {
      jQuery(this).find('.menu-item-has-children, .page_item_has_children').each(function () {
        jQuery(this).addClass('open');
        jQuery(this).children('ul').slideDown(100);
      });
    });
    $menu.find('.menu-item-has-children > a, .page_item_has_children > a').each(function () {
      if (jQuery(this).children('i.mdi.mdi-chevron-right').length === 0) {
        jQuery(this).append('<i class="mdi mdi-chevron-right"></i>');
      }
    });
    $menu.on('click', '.menu-item-has-children a, .page_item_has_children a,.menu-item-has-children .mdi-chevron-right, .page_item_has_children .mdi-chevron-right', function (event) {
      var $this = jQuery(this);
      var $li = $this.closest('li');

      if ($li.hasClass('open')) {
        if ($this.is('a')) {
          return true;
        }

        $li.children('ul').slideUp(100, function () {
          $li.find('ul').each(function () {
            jQuery(this).parent().removeClass('open');
            jQuery(this).css('display', 'none');
          });
        });
      } else {
        if ($li.children('ul').length) {
          $li.children('ul').slideDown(100);
        } else {
          return true;
        }
      }

      $li.toggleClass('open');
      event.preventDefault();
      event.stopPropagation();
    });
  });
});

/***/ }),

/***/ "./js/polyfills.js":
/*!*************************!*\
  !*** ./js/polyfills.js ***!
  \*************************/
/*! no static exports found */
/***/ (function(module, exports) {

(function (ElementProto) {
  if (typeof ElementProto.matches !== 'function') {
    ElementProto.matches = ElementProto.msMatchesSelector || ElementProto.mozMatchesSelector || ElementProto.webkitMatchesSelector || function matches(selector) {
      var element = this;
      var elements = (element.document || element.ownerDocument).querySelectorAll(selector);
      var index = 0;

      while (elements[index] && elements[index] !== element) {
        ++index;
      }

      return Boolean(elements[index]);
    };
  }

  if (typeof ElementProto.closest !== 'function') {
    ElementProto.closest = function closest(selector) {
      var element = this;

      while (element && element.nodeType === 1) {
        if (element.matches(selector)) {
          return element;
        }

        element = element.parentNode;
      }

      return null;
    };
  }
})(window.Element.prototype);

(function () {
  if (typeof Object.assign != 'function') {
    // Must be writable: true, enumerable: false, configurable: true
    Object.defineProperty(Object, "assign", {
      value: function assign(target, varArgs) {
        // .length of function is 2
        'use strict';

        if (target == null) {
          // TypeError if undefined or null
          throw new TypeError('Cannot convert undefined or null to object');
        }

        var to = Object(target);

        for (var index = 1; index < arguments.length; index++) {
          var nextSource = arguments[index];

          if (nextSource != null) {
            // Skip over if undefined or null
            for (var nextKey in nextSource) {
              // Avoid bugs when hasOwnProperty is shadowed
              if (Object.prototype.hasOwnProperty.call(nextSource, nextKey)) {
                to[nextKey] = nextSource[nextKey];
              }
            }
          }
        }

        return to;
      },
      writable: true,
      configurable: true
    });
  }
})();

/***/ }),

/***/ "./js/ripple.js":
/*!**********************!*\
  !*** ./js/ripple.js ***!
  \**********************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _material_ripple__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @material/ripple */ "./node_modules/@material/ripple/index.js");
/* harmony import */ var _utils__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./utils */ "./js/utils.js");


Object(_utils__WEBPACK_IMPORTED_MODULE_1__["onDocReady"])(function () {
  var btns = document.querySelectorAll('.button');

  for (var i = 0, btn; btn = btns[i]; i++) {
    _material_ripple__WEBPACK_IMPORTED_MODULE_0__["MDCRipple"].attachTo(btn);
  }
});
Object(_utils__WEBPACK_IMPORTED_MODULE_1__["onDocReady"])(function ($) {
  var menuElements = [];

  if (document.querySelectorAll('#main_menu').length !== 0) {
    menuElements = document.querySelectorAll('#main_menu li a, #materialis-footer-menu li a');
  } else {
    menuElements = document.querySelectorAll('#materialis-footer-menu li a');
  }

  for (var i = 0, menuElement; menuElement = menuElements[i]; i++) {
    _material_ripple__WEBPACK_IMPORTED_MODULE_0__["MDCRipple"].attachTo(menuElement);
  }
}); // woocommerce

function sleep(ms) {
  return new Promise(function (resolve) {
    return setTimeout(resolve, ms);
  });
}

Object(_utils__WEBPACK_IMPORTED_MODULE_1__["onDocReady"])(function ($) {
  var wooCommentSubmit = document.querySelectorAll('.woocommerce .product #respond input#submit');

  if (wooCommentSubmit.length) {
    _material_ripple__WEBPACK_IMPORTED_MODULE_0__["MDCRipple"].attachTo(wooCommentSubmit[0]);
  }

  sleep(1000).then(function () {
    var miniCartBtns = document.querySelectorAll('.materialis-woo-header-cart .woocommerce-mini-cart__buttons .button');

    for (var i = 0, cbtn; cbtn = miniCartBtns[i]; i++) {
      _material_ripple__WEBPACK_IMPORTED_MODULE_0__["MDCRipple"].attachTo(cbtn);
    }
  });
});

/***/ }),

/***/ "./js/theme.js":
/*!*********************!*\
  !*** ./js/theme.js ***!
  \*********************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

(function (MaterialisTheme) {
  __webpack_require__(/*! ./polyfills */ "./js/polyfills.js");

  __webpack_require__(/*! es6-promise */ "./node_modules/es6-promise/dist/es6-promise.js").polyfill();

  __webpack_require__(/*! ./_theme */ "./js/_theme.js");

  __webpack_require__(/*! ./ripple */ "./js/ripple.js");

  __webpack_require__(/*! ./offscreen-menu */ "./js/offscreen-menu.js");

  __webpack_require__(/*! ./masonry */ "./js/masonry.js");

  __webpack_require__(/*! ./blog-comments */ "./js/blog-comments.js");

  __webpack_require__(/*! ./forms */ "./js/forms.js");

  __webpack_require__(/*! ./backstretch */ "./js/backstretch.js");

  __webpack_require__(/*! ./masonry */ "./js/masonry.js");

  __webpack_require__(/*! ./homepage-arrow */ "./js/homepage-arrow.js");

  __webpack_require__(/*! ./counters */ "./js/counters.js");

  __webpack_require__(/*! ./header-animations */ "./js/header-animations.js");

  __webpack_require__(/*! ./footer */ "./js/footer.js");

  __webpack_require__(/*! ./gallery */ "./js/gallery.js");
})(function () {
  window.MaterialisTheme = window.MaterialisTheme || {};
  return window.MaterialisTheme;
}()); // require('./header-video');

/***/ }),

/***/ "./js/utils.js":
/*!*********************!*\
  !*** ./js/utils.js ***!
  \*********************/
/*! exports provided: onDocReady, isVisible */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "onDocReady", function() { return onDocReady; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "isVisible", function() { return isVisible; });
// function onDocReady(callback) {
//     // in case the document is already rendered
//     if (document.readyState === 'complete') {
//         callback(jQuery);
//     } else {
//         if (document.addEventListener) {
//             document.addEventListener('DOMContentLoaded', function () {
//                 callback(jQuery);
//             });
//         } else document.attachEvent('onreadystatechange', function () {
//             if (document.readyState === 'complete') callback(jQuery);
//         });
//     }
// }
var onDocReady = jQuery;

var isVisible = function isVisible(element) {
  return jQuery(element).is(':visible');
};



/***/ }),

/***/ "./node_modules/@material/animation/index.js":
/*!***************************************************!*\
  !*** ./node_modules/@material/animation/index.js ***!
  \***************************************************/
/*! exports provided: transformStyleProperties, getCorrectEventName, getCorrectPropertyName */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "transformStyleProperties", function() { return transformStyleProperties; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "getCorrectEventName", function() { return getCorrectEventName; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "getCorrectPropertyName", function() { return getCorrectPropertyName; });
/**
 * Copyright 2016 Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/**
 * @typedef {{
 *   noPrefix: string,
 *   webkitPrefix: string
 * }}
 */
var VendorPropertyMapType;
/** @const {Object<string, !VendorPropertyMapType>} */

var eventTypeMap = {
  'animationstart': {
    noPrefix: 'animationstart',
    webkitPrefix: 'webkitAnimationStart',
    styleProperty: 'animation'
  },
  'animationend': {
    noPrefix: 'animationend',
    webkitPrefix: 'webkitAnimationEnd',
    styleProperty: 'animation'
  },
  'animationiteration': {
    noPrefix: 'animationiteration',
    webkitPrefix: 'webkitAnimationIteration',
    styleProperty: 'animation'
  },
  'transitionend': {
    noPrefix: 'transitionend',
    webkitPrefix: 'webkitTransitionEnd',
    styleProperty: 'transition'
  }
};
/** @const {Object<string, !VendorPropertyMapType>} */

var cssPropertyMap = {
  'animation': {
    noPrefix: 'animation',
    webkitPrefix: '-webkit-animation'
  },
  'transform': {
    noPrefix: 'transform',
    webkitPrefix: '-webkit-transform'
  },
  'transition': {
    noPrefix: 'transition',
    webkitPrefix: '-webkit-transition'
  }
};
/**
 * @param {!Object} windowObj
 * @return {boolean}
 */

function hasProperShape(windowObj) {
  return windowObj['document'] !== undefined && typeof windowObj['document']['createElement'] === 'function';
}
/**
 * @param {string} eventType
 * @return {boolean}
 */


function eventFoundInMaps(eventType) {
  return eventType in eventTypeMap || eventType in cssPropertyMap;
}
/**
 * @param {string} eventType
 * @param {!Object<string, !VendorPropertyMapType>} map
 * @param {!Element} el
 * @return {string}
 */


function getJavaScriptEventName(eventType, map, el) {
  return map[eventType].styleProperty in el.style ? map[eventType].noPrefix : map[eventType].webkitPrefix;
}
/**
 * Helper function to determine browser prefix for CSS3 animation events
 * and property names.
 * @param {!Object} windowObj
 * @param {string} eventType
 * @return {string}
 */


function getAnimationName(windowObj, eventType) {
  if (!hasProperShape(windowObj) || !eventFoundInMaps(eventType)) {
    return eventType;
  }

  var map =
  /** @type {!Object<string, !VendorPropertyMapType>} */
  eventType in eventTypeMap ? eventTypeMap : cssPropertyMap;
  var el = windowObj['document']['createElement']('div');
  var eventName = '';

  if (map === eventTypeMap) {
    eventName = getJavaScriptEventName(eventType, map, el);
  } else {
    eventName = map[eventType].noPrefix in el.style ? map[eventType].noPrefix : map[eventType].webkitPrefix;
  }

  return eventName;
} // Public functions to access getAnimationName() for JavaScript events or CSS
// property names.


var transformStyleProperties = ['transform', 'WebkitTransform', 'MozTransform', 'OTransform', 'MSTransform'];
/**
 * @param {!Object} windowObj
 * @param {string} eventType
 * @return {string}
 */

function getCorrectEventName(windowObj, eventType) {
  return getAnimationName(windowObj, eventType);
}
/**
 * @param {!Object} windowObj
 * @param {string} eventType
 * @return {string}
 */

function getCorrectPropertyName(windowObj, eventType) {
  return getAnimationName(windowObj, eventType);
}

/***/ }),

/***/ "./node_modules/@material/base/component.js":
/*!**************************************************!*\
  !*** ./node_modules/@material/base/component.js ***!
  \**************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _foundation__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./foundation */ "./node_modules/@material/base/foundation.js");
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

/**
 * @license
 * Copyright 2016 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/**
 * @template F
 */

var MDCComponent =
/*#__PURE__*/
function () {
  _createClass(MDCComponent, null, [{
    key: "attachTo",

    /**
     * @param {!Element} root
     * @return {!MDCComponent}
     */
    value: function attachTo(root) {
      // Subclasses which extend MDCBase should provide an attachTo() method that takes a root element and
      // returns an instantiated component with its root set to that element. Also note that in the cases of
      // subclasses, an explicit foundation class will not have to be passed in; it will simply be initialized
      // from getDefaultFoundation().
      return new MDCComponent(root, new _foundation__WEBPACK_IMPORTED_MODULE_0__["default"]());
    }
    /**
     * @param {!Element} root
     * @param {F=} foundation
     * @param {...?} args
     */

  }]);

  function MDCComponent(root) {
    var foundation = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : undefined;

    _classCallCheck(this, MDCComponent);

    /** @protected {!Element} */
    this.root_ = root;

    for (var _len = arguments.length, args = new Array(_len > 2 ? _len - 2 : 0), _key = 2; _key < _len; _key++) {
      args[_key - 2] = arguments[_key];
    }

    this.initialize.apply(this, args); // Note that we initialize foundation here and not within the constructor's default param so that
    // this.root_ is defined and can be used within the foundation class.

    /** @protected {!F} */

    this.foundation_ = foundation === undefined ? this.getDefaultFoundation() : foundation;
    this.foundation_.init();
    this.initialSyncWithDOM();
  }

  _createClass(MDCComponent, [{
    key: "initialize",
    value: function initialize()
    /* ...args */
    {} // Subclasses can override this to do any additional setup work that would be considered part of a
    // "constructor". Essentially, it is a hook into the parent constructor before the foundation is
    // initialized. Any additional arguments besides root and foundation will be passed in here.

    /**
     * @return {!F} foundation
     */

  }, {
    key: "getDefaultFoundation",
    value: function getDefaultFoundation() {
      // Subclasses must override this method to return a properly configured foundation class for the
      // component.
      throw new Error('Subclasses must override getDefaultFoundation to return a properly configured ' + 'foundation class');
    }
  }, {
    key: "initialSyncWithDOM",
    value: function initialSyncWithDOM() {// Subclasses should override this method if they need to perform work to synchronize with a host DOM
      // object. An example of this would be a form control wrapper that needs to synchronize its internal state
      // to some property or attribute of the host DOM. Please note: this is *not* the place to perform DOM
      // reads/writes that would cause layout / paint, as this is called synchronously from within the constructor.
    }
  }, {
    key: "destroy",
    value: function destroy() {
      // Subclasses may implement this method to release any resources / deregister any listeners they have
      // attached. An example of this might be deregistering a resize event from the window object.
      this.foundation_.destroy();
    }
    /**
     * Wrapper method to add an event listener to the component's root element. This is most useful when
     * listening for custom events.
     * @param {string} evtType
     * @param {!Function} handler
     */

  }, {
    key: "listen",
    value: function listen(evtType, handler) {
      this.root_.addEventListener(evtType, handler);
    }
    /**
     * Wrapper method to remove an event listener to the component's root element. This is most useful when
     * unlistening for custom events.
     * @param {string} evtType
     * @param {!Function} handler
     */

  }, {
    key: "unlisten",
    value: function unlisten(evtType, handler) {
      this.root_.removeEventListener(evtType, handler);
    }
    /**
     * Fires a cross-browser-compatible custom event from the component root of the given type,
     * with the given data.
     * @param {string} evtType
     * @param {!Object} evtData
     * @param {boolean=} shouldBubble
     */

  }, {
    key: "emit",
    value: function emit(evtType, evtData) {
      var shouldBubble = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : false;
      var evt;

      if (typeof CustomEvent === 'function') {
        evt = new CustomEvent(evtType, {
          detail: evtData,
          bubbles: shouldBubble
        });
      } else {
        evt = document.createEvent('CustomEvent');
        evt.initCustomEvent(evtType, shouldBubble, false, evtData);
      }

      this.root_.dispatchEvent(evt);
    }
  }]);

  return MDCComponent;
}();

/* harmony default export */ __webpack_exports__["default"] = (MDCComponent);

/***/ }),

/***/ "./node_modules/@material/base/foundation.js":
/*!***************************************************!*\
  !*** ./node_modules/@material/base/foundation.js ***!
  \***************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

/**
 * @license
 * Copyright 2016 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/**
 * @template A
 */
var MDCFoundation =
/*#__PURE__*/
function () {
  _createClass(MDCFoundation, null, [{
    key: "cssClasses",

    /** @return enum{cssClasses} */
    get: function get() {
      // Classes extending MDCFoundation should implement this method to return an object which exports every
      // CSS class the foundation class needs as a property. e.g. {ACTIVE: 'mdc-component--active'}
      return {};
    }
    /** @return enum{strings} */

  }, {
    key: "strings",
    get: function get() {
      // Classes extending MDCFoundation should implement this method to return an object which exports all
      // semantic strings as constants. e.g. {ARIA_ROLE: 'tablist'}
      return {};
    }
    /** @return enum{numbers} */

  }, {
    key: "numbers",
    get: function get() {
      // Classes extending MDCFoundation should implement this method to return an object which exports all
      // of its semantic numbers as constants. e.g. {ANIMATION_DELAY_MS: 350}
      return {};
    }
    /** @return {!Object} */

  }, {
    key: "defaultAdapter",
    get: function get() {
      // Classes extending MDCFoundation may choose to implement this getter in order to provide a convenient
      // way of viewing the necessary methods of an adapter. In the future, this could also be used for adapter
      // validation.
      return {};
    }
    /**
     * @param {A=} adapter
     */

  }]);

  function MDCFoundation() {
    var adapter = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};

    _classCallCheck(this, MDCFoundation);

    /** @protected {!A} */
    this.adapter_ = adapter;
  }

  _createClass(MDCFoundation, [{
    key: "init",
    value: function init() {// Subclasses should override this method to perform initialization routines (registering events, etc.)
    }
  }, {
    key: "destroy",
    value: function destroy() {// Subclasses should override this method to perform de-initialization routines (de-registering events, etc.)
    }
  }]);

  return MDCFoundation;
}();

/* harmony default export */ __webpack_exports__["default"] = (MDCFoundation);

/***/ }),

/***/ "./node_modules/@material/checkbox/adapter.js":
/*!****************************************************!*\
  !*** ./node_modules/@material/checkbox/adapter.js ***!
  \****************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _material_selection_control_index__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @material/selection-control/index */ "./node_modules/@material/selection-control/index.js");
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

/**
 * @license
 * Copyright 2016 Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/* eslint-disable no-unused-vars */

/* eslint no-unused-vars: [2, {"args": "none"}] */

/**
 * Adapter for MDC Checkbox. Provides an interface for managing
 * - classes
 * - dom
 * - event handlers
 *
 * Additionally, provides type information for the adapter to the Closure
 * compiler.
 *
 * Implement this adapter for your framework of choice to delegate updates to
 * the component in your framework of choice. See architecture documentation
 * for more details.
 * https://github.com/material-components/material-components-web/blob/master/docs/code/architecture.md
 *
 * @record
 */

var MDCCheckboxAdapter =
/*#__PURE__*/
function () {
  function MDCCheckboxAdapter() {
    _classCallCheck(this, MDCCheckboxAdapter);
  }

  _createClass(MDCCheckboxAdapter, [{
    key: "addClass",

    /** @param {string} className */
    value: function addClass(className) {}
    /** @param {string} className */

  }, {
    key: "removeClass",
    value: function removeClass(className) {}
    /**
     * Sets an attribute with a given value on the input element.
     * @param {string} attr
     * @param {string} value
     */

  }, {
    key: "setNativeControlAttr",
    value: function setNativeControlAttr(attr, value) {}
    /**
     * Removes an attribute from the input element.
     * @param {string} attr
     */

  }, {
    key: "removeNativeControlAttr",
    value: function removeNativeControlAttr(attr) {}
    /** @param {!EventListener} handler */

  }, {
    key: "registerAnimationEndHandler",
    value: function registerAnimationEndHandler(handler) {}
    /** @param {!EventListener} handler */

  }, {
    key: "deregisterAnimationEndHandler",
    value: function deregisterAnimationEndHandler(handler) {}
    /** @param {!EventListener} handler */

  }, {
    key: "registerChangeHandler",
    value: function registerChangeHandler(handler) {}
    /** @param {!EventListener} handler */

  }, {
    key: "deregisterChangeHandler",
    value: function deregisterChangeHandler(handler) {}
    /** @return {!MDCSelectionControlState} */

  }, {
    key: "getNativeControl",
    value: function getNativeControl() {}
  }, {
    key: "forceLayout",
    value: function forceLayout() {}
    /** @return {boolean} */

  }, {
    key: "isAttachedToDOM",
    value: function isAttachedToDOM() {}
  }]);

  return MDCCheckboxAdapter;
}();

/* harmony default export */ __webpack_exports__["default"] = (MDCCheckboxAdapter);

/***/ }),

/***/ "./node_modules/@material/checkbox/constants.js":
/*!******************************************************!*\
  !*** ./node_modules/@material/checkbox/constants.js ***!
  \******************************************************/
/*! exports provided: cssClasses, strings, numbers */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "cssClasses", function() { return cssClasses; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "strings", function() { return strings; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "numbers", function() { return numbers; });
/**
 * @license
 * Copyright 2016 Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/** @const {string} */
var ROOT = 'mdc-checkbox';
/** @enum {string} */

var cssClasses = {
  UPGRADED: 'mdc-checkbox--upgraded',
  CHECKED: 'mdc-checkbox--checked',
  INDETERMINATE: 'mdc-checkbox--indeterminate',
  DISABLED: 'mdc-checkbox--disabled',
  ANIM_UNCHECKED_CHECKED: 'mdc-checkbox--anim-unchecked-checked',
  ANIM_UNCHECKED_INDETERMINATE: 'mdc-checkbox--anim-unchecked-indeterminate',
  ANIM_CHECKED_UNCHECKED: 'mdc-checkbox--anim-checked-unchecked',
  ANIM_CHECKED_INDETERMINATE: 'mdc-checkbox--anim-checked-indeterminate',
  ANIM_INDETERMINATE_CHECKED: 'mdc-checkbox--anim-indeterminate-checked',
  ANIM_INDETERMINATE_UNCHECKED: 'mdc-checkbox--anim-indeterminate-unchecked'
};
/** @enum {string} */

var strings = {
  NATIVE_CONTROL_SELECTOR: ".".concat(ROOT, "__native-control"),
  TRANSITION_STATE_INIT: 'init',
  TRANSITION_STATE_CHECKED: 'checked',
  TRANSITION_STATE_UNCHECKED: 'unchecked',
  TRANSITION_STATE_INDETERMINATE: 'indeterminate',
  ARIA_CHECKED_ATTR: 'aria-checked',
  ARIA_CHECKED_INDETERMINATE_VALUE: 'mixed'
};
/** @enum {number} */

var numbers = {
  ANIM_END_LATCH_MS: 250
};


/***/ }),

/***/ "./node_modules/@material/checkbox/foundation.js":
/*!*******************************************************!*\
  !*** ./node_modules/@material/checkbox/foundation.js ***!
  \*******************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _material_base_foundation__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @material/base/foundation */ "./node_modules/@material/base/foundation.js");
/* harmony import */ var _material_selection_control_index__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @material/selection-control/index */ "./node_modules/@material/selection-control/index.js");
/* harmony import */ var _adapter__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./adapter */ "./node_modules/@material/checkbox/adapter.js");
/* harmony import */ var _constants__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./constants */ "./node_modules/@material/checkbox/constants.js");
function _typeof(obj) { if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (call && (_typeof(call) === "object" || typeof call === "function")) { return call; } return _assertThisInitialized(self); }

function _assertThisInitialized(self) { if (self === void 0) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return self; }

function _getPrototypeOf(o) { _getPrototypeOf = Object.setPrototypeOf ? Object.getPrototypeOf : function _getPrototypeOf(o) { return o.__proto__ || Object.getPrototypeOf(o); }; return _getPrototypeOf(o); }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function"); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, writable: true, configurable: true } }); if (superClass) _setPrototypeOf(subClass, superClass); }

function _setPrototypeOf(o, p) { _setPrototypeOf = Object.setPrototypeOf || function _setPrototypeOf(o, p) { o.__proto__ = p; return o; }; return _setPrototypeOf(o, p); }

/**
 * @license
 * Copyright 2016 Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/* eslint-disable no-unused-vars */



/* eslint-enable no-unused-vars */


/** @const {!Array<string>} */

var CB_PROTO_PROPS = ['checked', 'indeterminate'];
/**
 * @extends {MDCFoundation<!MDCCheckboxAdapter>}
 */

var MDCCheckboxFoundation =
/*#__PURE__*/
function (_MDCFoundation) {
  _inherits(MDCCheckboxFoundation, _MDCFoundation);

  _createClass(MDCCheckboxFoundation, null, [{
    key: "cssClasses",

    /** @return enum {cssClasses} */
    get: function get() {
      return _constants__WEBPACK_IMPORTED_MODULE_3__["cssClasses"];
    }
    /** @return enum {strings} */

  }, {
    key: "strings",
    get: function get() {
      return _constants__WEBPACK_IMPORTED_MODULE_3__["strings"];
    }
    /** @return enum {numbers} */

  }, {
    key: "numbers",
    get: function get() {
      return _constants__WEBPACK_IMPORTED_MODULE_3__["numbers"];
    }
    /** @return {!MDCCheckboxAdapter} */

  }, {
    key: "defaultAdapter",
    get: function get() {
      return (
        /** @type {!MDCCheckboxAdapter} */
        {
          addClass: function addClass()
          /* className: string */
          {},
          removeClass: function removeClass()
          /* className: string */
          {},
          setNativeControlAttr: function setNativeControlAttr()
          /* attr: string, value: string */
          {},
          removeNativeControlAttr: function removeNativeControlAttr()
          /* attr: string */
          {},
          registerAnimationEndHandler: function registerAnimationEndHandler()
          /* handler: EventListener */
          {},
          deregisterAnimationEndHandler: function deregisterAnimationEndHandler()
          /* handler: EventListener */
          {},
          registerChangeHandler: function registerChangeHandler()
          /* handler: EventListener */
          {},
          deregisterChangeHandler: function deregisterChangeHandler()
          /* handler: EventListener */
          {},
          getNativeControl: function getNativeControl()
          /* !MDCSelectionControlState */
          {},
          forceLayout: function forceLayout() {},
          isAttachedToDOM: function isAttachedToDOM()
          /* boolean */
          {}
        }
      );
    }
  }]);

  function MDCCheckboxFoundation(adapter) {
    var _this;

    _classCallCheck(this, MDCCheckboxFoundation);

    _this = _possibleConstructorReturn(this, _getPrototypeOf(MDCCheckboxFoundation).call(this, Object.assign(MDCCheckboxFoundation.defaultAdapter, adapter)));
    /** @private {string} */

    _this.currentCheckState_ = _constants__WEBPACK_IMPORTED_MODULE_3__["strings"].TRANSITION_STATE_INIT;
    /** @private {string} */

    _this.currentAnimationClass_ = '';
    /** @private {number} */

    _this.animEndLatchTimer_ = 0;

    _this.animEndHandler_ =
    /** @private {!EventListener} */
    function () {
      return _this.handleAnimationEnd();
    };

    _this.changeHandler_ =
    /** @private {!EventListener} */
    function () {
      return _this.handleChange();
    };

    return _this;
  }

  _createClass(MDCCheckboxFoundation, [{
    key: "init",
    value: function init() {
      this.currentCheckState_ = this.determineCheckState_(this.getNativeControl_());
      this.updateAriaChecked_();
      this.adapter_.addClass(_constants__WEBPACK_IMPORTED_MODULE_3__["cssClasses"].UPGRADED);
      this.adapter_.registerChangeHandler(this.changeHandler_);
      this.installPropertyChangeHooks_();
    }
  }, {
    key: "destroy",
    value: function destroy() {
      this.adapter_.deregisterChangeHandler(this.changeHandler_);
      this.uninstallPropertyChangeHooks_();
    }
    /** @return {boolean} */

  }, {
    key: "isChecked",
    value: function isChecked() {
      return this.getNativeControl_().checked;
    }
    /** @param {boolean} checked */

  }, {
    key: "setChecked",
    value: function setChecked(checked) {
      this.getNativeControl_().checked = checked;
    }
    /** @return {boolean} */

  }, {
    key: "isIndeterminate",
    value: function isIndeterminate() {
      return this.getNativeControl_().indeterminate;
    }
    /** @param {boolean} indeterminate */

  }, {
    key: "setIndeterminate",
    value: function setIndeterminate(indeterminate) {
      this.getNativeControl_().indeterminate = indeterminate;
    }
    /** @return {boolean} */

  }, {
    key: "isDisabled",
    value: function isDisabled() {
      return this.getNativeControl_().disabled;
    }
    /** @param {boolean} disabled */

  }, {
    key: "setDisabled",
    value: function setDisabled(disabled) {
      this.getNativeControl_().disabled = disabled;

      if (disabled) {
        this.adapter_.addClass(_constants__WEBPACK_IMPORTED_MODULE_3__["cssClasses"].DISABLED);
      } else {
        this.adapter_.removeClass(_constants__WEBPACK_IMPORTED_MODULE_3__["cssClasses"].DISABLED);
      }
    }
    /** @return {?string} */

  }, {
    key: "getValue",
    value: function getValue() {
      return this.getNativeControl_().value;
    }
    /** @param {?string} value */

  }, {
    key: "setValue",
    value: function setValue(value) {
      this.getNativeControl_().value = value;
    }
    /**
     * Handles the animationend event for the checkbox
     */

  }, {
    key: "handleAnimationEnd",
    value: function handleAnimationEnd() {
      var _this2 = this;

      clearTimeout(this.animEndLatchTimer_);
      this.animEndLatchTimer_ = setTimeout(function () {
        _this2.adapter_.removeClass(_this2.currentAnimationClass_);

        _this2.adapter_.deregisterAnimationEndHandler(_this2.animEndHandler_);
      }, _constants__WEBPACK_IMPORTED_MODULE_3__["numbers"].ANIM_END_LATCH_MS);
    }
    /**
     * Handles the change event for the checkbox
     */

  }, {
    key: "handleChange",
    value: function handleChange() {
      this.transitionCheckState_();
    }
    /** @private */

  }, {
    key: "installPropertyChangeHooks_",
    value: function installPropertyChangeHooks_() {
      var _this3 = this;

      var nativeCb = this.getNativeControl_();
      var cbProto = Object.getPrototypeOf(nativeCb);
      CB_PROTO_PROPS.forEach(function (controlState) {
        var desc = Object.getOwnPropertyDescriptor(cbProto, controlState); // We have to check for this descriptor, since some browsers (Safari) don't support its return.
        // See: https://bugs.webkit.org/show_bug.cgi?id=49739

        if (validDescriptor(desc)) {
          var nativeCbDesc =
          /** @type {!ObjectPropertyDescriptor} */
          {
            get: desc.get,
            set: function set(state) {
              desc.set.call(nativeCb, state);

              _this3.transitionCheckState_();
            },
            configurable: desc.configurable,
            enumerable: desc.enumerable
          };
          Object.defineProperty(nativeCb, controlState, nativeCbDesc);
        }
      });
    }
    /** @private */

  }, {
    key: "uninstallPropertyChangeHooks_",
    value: function uninstallPropertyChangeHooks_() {
      var nativeCb = this.getNativeControl_();
      var cbProto = Object.getPrototypeOf(nativeCb);
      CB_PROTO_PROPS.forEach(function (controlState) {
        var desc =
        /** @type {!ObjectPropertyDescriptor} */
        Object.getOwnPropertyDescriptor(cbProto, controlState);

        if (validDescriptor(desc)) {
          Object.defineProperty(nativeCb, controlState, desc);
        }
      });
    }
    /** @private */

  }, {
    key: "transitionCheckState_",
    value: function transitionCheckState_() {
      var nativeCb = this.adapter_.getNativeControl();

      if (!nativeCb) {
        return;
      }

      var oldState = this.currentCheckState_;
      var newState = this.determineCheckState_(nativeCb);

      if (oldState === newState) {
        return;
      }

      this.updateAriaChecked_(); // Check to ensure that there isn't a previously existing animation class, in case for example
      // the user interacted with the checkbox before the animation was finished.

      if (this.currentAnimationClass_.length > 0) {
        clearTimeout(this.animEndLatchTimer_);
        this.adapter_.forceLayout();
        this.adapter_.removeClass(this.currentAnimationClass_);
      }

      this.currentAnimationClass_ = this.getTransitionAnimationClass_(oldState, newState);
      this.currentCheckState_ = newState; // Check for parentNode so that animations are only run when the element is attached
      // to the DOM.

      if (this.adapter_.isAttachedToDOM() && this.currentAnimationClass_.length > 0) {
        this.adapter_.addClass(this.currentAnimationClass_);
        this.adapter_.registerAnimationEndHandler(this.animEndHandler_);
      }
    }
    /**
     * @param {!MDCSelectionControlState} nativeCb
     * @return {string}
     * @private
     */

  }, {
    key: "determineCheckState_",
    value: function determineCheckState_(nativeCb) {
      var TRANSITION_STATE_INDETERMINATE = _constants__WEBPACK_IMPORTED_MODULE_3__["strings"].TRANSITION_STATE_INDETERMINATE,
          TRANSITION_STATE_CHECKED = _constants__WEBPACK_IMPORTED_MODULE_3__["strings"].TRANSITION_STATE_CHECKED,
          TRANSITION_STATE_UNCHECKED = _constants__WEBPACK_IMPORTED_MODULE_3__["strings"].TRANSITION_STATE_UNCHECKED;

      if (nativeCb.indeterminate) {
        return TRANSITION_STATE_INDETERMINATE;
      }

      return nativeCb.checked ? TRANSITION_STATE_CHECKED : TRANSITION_STATE_UNCHECKED;
    }
    /**
     * @param {string} oldState
     * @param {string} newState
     * @return {string}
     */

  }, {
    key: "getTransitionAnimationClass_",
    value: function getTransitionAnimationClass_(oldState, newState) {
      var TRANSITION_STATE_INIT = _constants__WEBPACK_IMPORTED_MODULE_3__["strings"].TRANSITION_STATE_INIT,
          TRANSITION_STATE_CHECKED = _constants__WEBPACK_IMPORTED_MODULE_3__["strings"].TRANSITION_STATE_CHECKED,
          TRANSITION_STATE_UNCHECKED = _constants__WEBPACK_IMPORTED_MODULE_3__["strings"].TRANSITION_STATE_UNCHECKED;
      var _MDCCheckboxFoundatio = MDCCheckboxFoundation.cssClasses,
          ANIM_UNCHECKED_CHECKED = _MDCCheckboxFoundatio.ANIM_UNCHECKED_CHECKED,
          ANIM_UNCHECKED_INDETERMINATE = _MDCCheckboxFoundatio.ANIM_UNCHECKED_INDETERMINATE,
          ANIM_CHECKED_UNCHECKED = _MDCCheckboxFoundatio.ANIM_CHECKED_UNCHECKED,
          ANIM_CHECKED_INDETERMINATE = _MDCCheckboxFoundatio.ANIM_CHECKED_INDETERMINATE,
          ANIM_INDETERMINATE_CHECKED = _MDCCheckboxFoundatio.ANIM_INDETERMINATE_CHECKED,
          ANIM_INDETERMINATE_UNCHECKED = _MDCCheckboxFoundatio.ANIM_INDETERMINATE_UNCHECKED;

      switch (oldState) {
        case TRANSITION_STATE_INIT:
          if (newState === TRANSITION_STATE_UNCHECKED) {
            return '';
          }

        // fallthrough

        case TRANSITION_STATE_UNCHECKED:
          return newState === TRANSITION_STATE_CHECKED ? ANIM_UNCHECKED_CHECKED : ANIM_UNCHECKED_INDETERMINATE;

        case TRANSITION_STATE_CHECKED:
          return newState === TRANSITION_STATE_UNCHECKED ? ANIM_CHECKED_UNCHECKED : ANIM_CHECKED_INDETERMINATE;
        // TRANSITION_STATE_INDETERMINATE

        default:
          return newState === TRANSITION_STATE_CHECKED ? ANIM_INDETERMINATE_CHECKED : ANIM_INDETERMINATE_UNCHECKED;
      }
    }
  }, {
    key: "updateAriaChecked_",
    value: function updateAriaChecked_() {
      // Ensure aria-checked is set to mixed if checkbox is in indeterminate state.
      if (this.isIndeterminate()) {
        this.adapter_.setNativeControlAttr(_constants__WEBPACK_IMPORTED_MODULE_3__["strings"].ARIA_CHECKED_ATTR, _constants__WEBPACK_IMPORTED_MODULE_3__["strings"].ARIA_CHECKED_INDETERMINATE_VALUE);
      } else {
        this.adapter_.removeNativeControlAttr(_constants__WEBPACK_IMPORTED_MODULE_3__["strings"].ARIA_CHECKED_ATTR);
      }
    }
    /**
     * @return {!MDCSelectionControlState}
     * @private
     */

  }, {
    key: "getNativeControl_",
    value: function getNativeControl_() {
      return this.adapter_.getNativeControl() || {
        checked: false,
        indeterminate: false,
        disabled: false,
        value: null
      };
    }
  }]);

  return MDCCheckboxFoundation;
}(_material_base_foundation__WEBPACK_IMPORTED_MODULE_0__["default"]);
/**
 * @param {ObjectPropertyDescriptor|undefined} inputPropDesc
 * @return {boolean}
 */


function validDescriptor(inputPropDesc) {
  return !!inputPropDesc && typeof inputPropDesc.set === 'function';
}

/* harmony default export */ __webpack_exports__["default"] = (MDCCheckboxFoundation);

/***/ }),

/***/ "./node_modules/@material/checkbox/index.js":
/*!**************************************************!*\
  !*** ./node_modules/@material/checkbox/index.js ***!
  \**************************************************/
/*! exports provided: MDCCheckboxFoundation, MDCCheckbox */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "MDCCheckbox", function() { return MDCCheckbox; });
/* harmony import */ var _material_animation_index__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @material/animation/index */ "./node_modules/@material/checkbox/node_modules/@material/animation/index.js");
/* harmony import */ var _material_base_component__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @material/base/component */ "./node_modules/@material/base/component.js");
/* harmony import */ var _material_selection_control_index__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @material/selection-control/index */ "./node_modules/@material/selection-control/index.js");
/* harmony import */ var _foundation__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./foundation */ "./node_modules/@material/checkbox/foundation.js");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "MDCCheckboxFoundation", function() { return _foundation__WEBPACK_IMPORTED_MODULE_3__["default"]; });

/* harmony import */ var _material_ripple_index__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @material/ripple/index */ "./node_modules/@material/ripple/index.js");
/* harmony import */ var _material_ripple_util__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @material/ripple/util */ "./node_modules/@material/ripple/util.js");
function _typeof(obj) { if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (call && (_typeof(call) === "object" || typeof call === "function")) { return call; } return _assertThisInitialized(self); }

function _assertThisInitialized(self) { if (self === void 0) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return self; }

function _get(target, property, receiver) { if (typeof Reflect !== "undefined" && Reflect.get) { _get = Reflect.get; } else { _get = function _get(target, property, receiver) { var base = _superPropBase(target, property); if (!base) return; var desc = Object.getOwnPropertyDescriptor(base, property); if (desc.get) { return desc.get.call(receiver); } return desc.value; }; } return _get(target, property, receiver || target); }

function _superPropBase(object, property) { while (!Object.prototype.hasOwnProperty.call(object, property)) { object = _getPrototypeOf(object); if (object === null) break; } return object; }

function _getPrototypeOf(o) { _getPrototypeOf = Object.setPrototypeOf ? Object.getPrototypeOf : function _getPrototypeOf(o) { return o.__proto__ || Object.getPrototypeOf(o); }; return _getPrototypeOf(o); }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function"); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, writable: true, configurable: true } }); if (superClass) _setPrototypeOf(subClass, superClass); }

function _setPrototypeOf(o, p) { _setPrototypeOf = Object.setPrototypeOf || function _setPrototypeOf(o, p) { o.__proto__ = p; return o; }; return _setPrototypeOf(o, p); }

/**
 * @license
 * Copyright 2016 Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */


/* eslint-disable no-unused-vars */


/* eslint-enable no-unused-vars */




/**
 * @extends MDCComponent<!MDCCheckboxFoundation>
 * @implements {MDCSelectionControl}
 */

var MDCCheckbox =
/*#__PURE__*/
function (_MDCComponent) {
  _inherits(MDCCheckbox, _MDCComponent);

  _createClass(MDCCheckbox, [{
    key: "nativeCb_",

    /**
     * Returns the state of the native control element, or null if the native control element is not present.
     * @return {?MDCSelectionControlState}
     * @private
     */
    get: function get() {
      var NATIVE_CONTROL_SELECTOR = _foundation__WEBPACK_IMPORTED_MODULE_3__["default"].strings.NATIVE_CONTROL_SELECTOR;
      var cbEl =
      /** @type {?MDCSelectionControlState} */
      this.root_.querySelector(NATIVE_CONTROL_SELECTOR);
      return cbEl;
    }
  }], [{
    key: "attachTo",
    value: function attachTo(root) {
      return new MDCCheckbox(root);
    }
  }]);

  function MDCCheckbox() {
    var _getPrototypeOf2;

    var _this;

    _classCallCheck(this, MDCCheckbox);

    for (var _len = arguments.length, args = new Array(_len), _key = 0; _key < _len; _key++) {
      args[_key] = arguments[_key];
    }

    _this = _possibleConstructorReturn(this, (_getPrototypeOf2 = _getPrototypeOf(MDCCheckbox)).call.apply(_getPrototypeOf2, [this].concat(args)));
    /** @private {!MDCRipple} */

    _this.ripple_ = _this.initRipple_();
    return _this;
  }
  /**
   * @return {!MDCRipple}
   * @private
   */


  _createClass(MDCCheckbox, [{
    key: "initRipple_",
    value: function initRipple_() {
      var _this2 = this;

      var MATCHES = Object(_material_ripple_util__WEBPACK_IMPORTED_MODULE_5__["getMatchesProperty"])(HTMLElement.prototype);
      var adapter = Object.assign(_material_ripple_index__WEBPACK_IMPORTED_MODULE_4__["MDCRipple"].createAdapter(this), {
        isUnbounded: function isUnbounded() {
          return true;
        },
        isSurfaceActive: function isSurfaceActive() {
          return _this2.nativeCb_[MATCHES](':active');
        },
        registerInteractionHandler: function registerInteractionHandler(type, handler) {
          return _this2.nativeCb_.addEventListener(type, handler);
        },
        deregisterInteractionHandler: function deregisterInteractionHandler(type, handler) {
          return _this2.nativeCb_.removeEventListener(type, handler);
        }
      });
      var foundation = new _material_ripple_index__WEBPACK_IMPORTED_MODULE_4__["MDCRippleFoundation"](adapter);
      return new _material_ripple_index__WEBPACK_IMPORTED_MODULE_4__["MDCRipple"](this.root_, foundation);
    }
    /** @return {!MDCCheckboxFoundation} */

  }, {
    key: "getDefaultFoundation",
    value: function getDefaultFoundation() {
      var _this3 = this;

      return new _foundation__WEBPACK_IMPORTED_MODULE_3__["default"]({
        addClass: function addClass(className) {
          return _this3.root_.classList.add(className);
        },
        removeClass: function removeClass(className) {
          return _this3.root_.classList.remove(className);
        },
        setNativeControlAttr: function setNativeControlAttr(attr, value) {
          return _this3.nativeCb_.setAttribute(attr, value);
        },
        removeNativeControlAttr: function removeNativeControlAttr(attr) {
          return _this3.nativeCb_.removeAttribute(attr);
        },
        registerAnimationEndHandler: function registerAnimationEndHandler(handler) {
          return _this3.root_.addEventListener(Object(_material_animation_index__WEBPACK_IMPORTED_MODULE_0__["getCorrectEventName"])(window, 'animationend'), handler);
        },
        deregisterAnimationEndHandler: function deregisterAnimationEndHandler(handler) {
          return _this3.root_.removeEventListener(Object(_material_animation_index__WEBPACK_IMPORTED_MODULE_0__["getCorrectEventName"])(window, 'animationend'), handler);
        },
        registerChangeHandler: function registerChangeHandler(handler) {
          return _this3.nativeCb_.addEventListener('change', handler);
        },
        deregisterChangeHandler: function deregisterChangeHandler(handler) {
          return _this3.nativeCb_.removeEventListener('change', handler);
        },
        getNativeControl: function getNativeControl() {
          return _this3.nativeCb_;
        },
        forceLayout: function forceLayout() {
          return _this3.root_.offsetWidth;
        },
        isAttachedToDOM: function isAttachedToDOM() {
          return Boolean(_this3.root_.parentNode);
        }
      });
    }
    /** @return {!MDCRipple} */

  }, {
    key: "destroy",
    value: function destroy() {
      this.ripple_.destroy();

      _get(_getPrototypeOf(MDCCheckbox.prototype), "destroy", this).call(this);
    }
  }, {
    key: "ripple",
    get: function get() {
      return this.ripple_;
    }
    /** @return {boolean} */

  }, {
    key: "checked",
    get: function get() {
      return this.foundation_.isChecked();
    }
    /** @param {boolean} checked */
    ,
    set: function set(checked) {
      this.foundation_.setChecked(checked);
    }
    /** @return {boolean} */

  }, {
    key: "indeterminate",
    get: function get() {
      return this.foundation_.isIndeterminate();
    }
    /** @param {boolean} indeterminate */
    ,
    set: function set(indeterminate) {
      this.foundation_.setIndeterminate(indeterminate);
    }
    /** @return {boolean} */

  }, {
    key: "disabled",
    get: function get() {
      return this.foundation_.isDisabled();
    }
    /** @param {boolean} disabled */
    ,
    set: function set(disabled) {
      this.foundation_.setDisabled(disabled);
    }
    /** @return {?string} */

  }, {
    key: "value",
    get: function get() {
      return this.foundation_.getValue();
    }
    /** @param {?string} value */
    ,
    set: function set(value) {
      this.foundation_.setValue(value);
    }
  }]);

  return MDCCheckbox;
}(_material_base_component__WEBPACK_IMPORTED_MODULE_1__["default"]);



/***/ }),

/***/ "./node_modules/@material/checkbox/node_modules/@material/animation/index.js":
/*!***********************************************************************************!*\
  !*** ./node_modules/@material/checkbox/node_modules/@material/animation/index.js ***!
  \***********************************************************************************/
/*! exports provided: transformStyleProperties, getCorrectEventName, getCorrectPropertyName */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "transformStyleProperties", function() { return transformStyleProperties; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "getCorrectEventName", function() { return getCorrectEventName; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "getCorrectPropertyName", function() { return getCorrectPropertyName; });
/**
 * @license
 * Copyright 2016 Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/**
 * @typedef {{
 *   noPrefix: string,
 *   webkitPrefix: string,
 *   styleProperty: string
 * }}
 */
var VendorPropertyMapType;
/** @const {Object<string, !VendorPropertyMapType>} */

var eventTypeMap = {
  'animationstart': {
    noPrefix: 'animationstart',
    webkitPrefix: 'webkitAnimationStart',
    styleProperty: 'animation'
  },
  'animationend': {
    noPrefix: 'animationend',
    webkitPrefix: 'webkitAnimationEnd',
    styleProperty: 'animation'
  },
  'animationiteration': {
    noPrefix: 'animationiteration',
    webkitPrefix: 'webkitAnimationIteration',
    styleProperty: 'animation'
  },
  'transitionend': {
    noPrefix: 'transitionend',
    webkitPrefix: 'webkitTransitionEnd',
    styleProperty: 'transition'
  }
};
/** @const {Object<string, !VendorPropertyMapType>} */

var cssPropertyMap = {
  'animation': {
    noPrefix: 'animation',
    webkitPrefix: '-webkit-animation'
  },
  'transform': {
    noPrefix: 'transform',
    webkitPrefix: '-webkit-transform'
  },
  'transition': {
    noPrefix: 'transition',
    webkitPrefix: '-webkit-transition'
  }
};
/**
 * @param {!Object} windowObj
 * @return {boolean}
 */

function hasProperShape(windowObj) {
  return windowObj['document'] !== undefined && typeof windowObj['document']['createElement'] === 'function';
}
/**
 * @param {string} eventType
 * @return {boolean}
 */


function eventFoundInMaps(eventType) {
  return eventType in eventTypeMap || eventType in cssPropertyMap;
}
/**
 * @param {string} eventType
 * @param {!Object<string, !VendorPropertyMapType>} map
 * @param {!Element} el
 * @return {string}
 */


function getJavaScriptEventName(eventType, map, el) {
  return map[eventType].styleProperty in el.style ? map[eventType].noPrefix : map[eventType].webkitPrefix;
}
/**
 * Helper function to determine browser prefix for CSS3 animation events
 * and property names.
 * @param {!Object} windowObj
 * @param {string} eventType
 * @return {string}
 */


function getAnimationName(windowObj, eventType) {
  if (!hasProperShape(windowObj) || !eventFoundInMaps(eventType)) {
    return eventType;
  }

  var map =
  /** @type {!Object<string, !VendorPropertyMapType>} */
  eventType in eventTypeMap ? eventTypeMap : cssPropertyMap;
  var el = windowObj['document']['createElement']('div');
  var eventName = '';

  if (map === eventTypeMap) {
    eventName = getJavaScriptEventName(eventType, map, el);
  } else {
    eventName = map[eventType].noPrefix in el.style ? map[eventType].noPrefix : map[eventType].webkitPrefix;
  }

  return eventName;
} // Public functions to access getAnimationName() for JavaScript events or CSS
// property names.


var transformStyleProperties = ['transform', 'WebkitTransform', 'MozTransform', 'OTransform', 'MSTransform'];
/**
 * @param {!Object} windowObj
 * @param {string} eventType
 * @return {string}
 */

function getCorrectEventName(windowObj, eventType) {
  return getAnimationName(windowObj, eventType);
}
/**
 * @param {!Object} windowObj
 * @param {string} eventType
 * @return {string}
 */


function getCorrectPropertyName(windowObj, eventType) {
  return getAnimationName(windowObj, eventType);
}



/***/ }),

/***/ "./node_modules/@material/floating-label/adapter.js":
/*!**********************************************************!*\
  !*** ./node_modules/@material/floating-label/adapter.js ***!
  \**********************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

/**
 * @license
 * Copyright 2017 Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/* eslint no-unused-vars: [2, {"args": "none"}] */

/**
 * Adapter for MDC Floating Label.
 *
 * Defines the shape of the adapter expected by the foundation. Implement this
 * adapter to integrate the floating label into your framework. See
 * https://github.com/material-components/material-components-web/blob/master/docs/authoring-components.md
 * for more information.
 *
 * @record
 */
var MDCFloatingLabelAdapter =
/*#__PURE__*/
function () {
  function MDCFloatingLabelAdapter() {
    _classCallCheck(this, MDCFloatingLabelAdapter);
  }

  _createClass(MDCFloatingLabelAdapter, [{
    key: "addClass",

    /**
     * Adds a class to the label element.
     * @param {string} className
     */
    value: function addClass(className) {}
    /**
     * Removes a class from the label element.
     * @param {string} className
     */

  }, {
    key: "removeClass",
    value: function removeClass(className) {}
    /**
     * Returns the width of the label element.
     * @return {number}
     */

  }, {
    key: "getWidth",
    value: function getWidth() {}
    /**
     * Registers an event listener on the root element for a given event.
     * @param {string} evtType
     * @param {function(!Event): undefined} handler
     */

  }, {
    key: "registerInteractionHandler",
    value: function registerInteractionHandler(evtType, handler) {}
    /**
     * Deregisters an event listener on the root element for a given event.
     * @param {string} evtType
     * @param {function(!Event): undefined} handler
     */

  }, {
    key: "deregisterInteractionHandler",
    value: function deregisterInteractionHandler(evtType, handler) {}
  }]);

  return MDCFloatingLabelAdapter;
}();

/* harmony default export */ __webpack_exports__["default"] = (MDCFloatingLabelAdapter);

/***/ }),

/***/ "./node_modules/@material/floating-label/constants.js":
/*!************************************************************!*\
  !*** ./node_modules/@material/floating-label/constants.js ***!
  \************************************************************/
/*! exports provided: cssClasses */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "cssClasses", function() { return cssClasses; });
/**
 * @license
 * Copyright 2016 Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/** @enum {string} */
var cssClasses = {
  LABEL_FLOAT_ABOVE: 'mdc-floating-label--float-above',
  LABEL_SHAKE: 'mdc-floating-label--shake'
};


/***/ }),

/***/ "./node_modules/@material/floating-label/foundation.js":
/*!*************************************************************!*\
  !*** ./node_modules/@material/floating-label/foundation.js ***!
  \*************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _material_base_foundation__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @material/base/foundation */ "./node_modules/@material/base/foundation.js");
/* harmony import */ var _adapter__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./adapter */ "./node_modules/@material/floating-label/adapter.js");
/* harmony import */ var _constants__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./constants */ "./node_modules/@material/floating-label/constants.js");
function _typeof(obj) { if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (call && (_typeof(call) === "object" || typeof call === "function")) { return call; } return _assertThisInitialized(self); }

function _assertThisInitialized(self) { if (self === void 0) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return self; }

function _getPrototypeOf(o) { _getPrototypeOf = Object.setPrototypeOf ? Object.getPrototypeOf : function _getPrototypeOf(o) { return o.__proto__ || Object.getPrototypeOf(o); }; return _getPrototypeOf(o); }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function"); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, writable: true, configurable: true } }); if (superClass) _setPrototypeOf(subClass, superClass); }

function _setPrototypeOf(o, p) { _setPrototypeOf = Object.setPrototypeOf || function _setPrototypeOf(o, p) { o.__proto__ = p; return o; }; return _setPrototypeOf(o, p); }

/**
 * @license
 * Copyright 2016 Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */



/**
 * @extends {MDCFoundation<!MDCFloatingLabelAdapter>}
 * @final
 */

var MDCFloatingLabelFoundation =
/*#__PURE__*/
function (_MDCFoundation) {
  _inherits(MDCFloatingLabelFoundation, _MDCFoundation);

  _createClass(MDCFloatingLabelFoundation, null, [{
    key: "cssClasses",

    /** @return enum {string} */
    get: function get() {
      return _constants__WEBPACK_IMPORTED_MODULE_2__["cssClasses"];
    }
    /**
     * {@see MDCFloatingLabelAdapter} for typing information on parameters and return
     * types.
     * @return {!MDCFloatingLabelAdapter}
     */

  }, {
    key: "defaultAdapter",
    get: function get() {
      return (
        /** @type {!MDCFloatingLabelAdapter} */
        {
          addClass: function addClass() {},
          removeClass: function removeClass() {},
          getWidth: function getWidth() {},
          registerInteractionHandler: function registerInteractionHandler() {},
          deregisterInteractionHandler: function deregisterInteractionHandler() {}
        }
      );
    }
    /**
     * @param {!MDCFloatingLabelAdapter} adapter
     */

  }]);

  function MDCFloatingLabelFoundation(adapter) {
    var _this;

    _classCallCheck(this, MDCFloatingLabelFoundation);

    _this = _possibleConstructorReturn(this, _getPrototypeOf(MDCFloatingLabelFoundation).call(this, Object.assign(MDCFloatingLabelFoundation.defaultAdapter, adapter)));
    /** @private {function(!Event): undefined} */

    _this.shakeAnimationEndHandler_ = function () {
      return _this.handleShakeAnimationEnd_();
    };

    return _this;
  }

  _createClass(MDCFloatingLabelFoundation, [{
    key: "init",
    value: function init() {
      this.adapter_.registerInteractionHandler('animationend', this.shakeAnimationEndHandler_);
    }
  }, {
    key: "destroy",
    value: function destroy() {
      this.adapter_.deregisterInteractionHandler('animationend', this.shakeAnimationEndHandler_);
    }
    /**
     * Returns the width of the label element.
     * @return {number}
     */

  }, {
    key: "getWidth",
    value: function getWidth() {
      return this.adapter_.getWidth();
    }
    /**
     * Styles the label to produce the label shake for errors.
     * @param {boolean} shouldShake adds shake class if true,
     * otherwise removes shake class.
     */

  }, {
    key: "shake",
    value: function shake(shouldShake) {
      var LABEL_SHAKE = MDCFloatingLabelFoundation.cssClasses.LABEL_SHAKE;

      if (shouldShake) {
        this.adapter_.addClass(LABEL_SHAKE);
      } else {
        this.adapter_.removeClass(LABEL_SHAKE);
      }
    }
    /**
     * Styles the label to float or dock.
     * @param {boolean} shouldFloat adds float class if true, otherwise remove
     * float and shake class to dock label.
     */

  }, {
    key: "float",
    value: function float(shouldFloat) {
      var _MDCFloatingLabelFoun = MDCFloatingLabelFoundation.cssClasses,
          LABEL_FLOAT_ABOVE = _MDCFloatingLabelFoun.LABEL_FLOAT_ABOVE,
          LABEL_SHAKE = _MDCFloatingLabelFoun.LABEL_SHAKE;

      if (shouldFloat) {
        this.adapter_.addClass(LABEL_FLOAT_ABOVE);
      } else {
        this.adapter_.removeClass(LABEL_FLOAT_ABOVE);
        this.adapter_.removeClass(LABEL_SHAKE);
      }
    }
    /**
     * Handles an interaction event on the root element.
     */

  }, {
    key: "handleShakeAnimationEnd_",
    value: function handleShakeAnimationEnd_() {
      var LABEL_SHAKE = MDCFloatingLabelFoundation.cssClasses.LABEL_SHAKE;
      this.adapter_.removeClass(LABEL_SHAKE);
    }
  }]);

  return MDCFloatingLabelFoundation;
}(_material_base_foundation__WEBPACK_IMPORTED_MODULE_0__["default"]);

/* harmony default export */ __webpack_exports__["default"] = (MDCFloatingLabelFoundation);

/***/ }),

/***/ "./node_modules/@material/floating-label/index.js":
/*!********************************************************!*\
  !*** ./node_modules/@material/floating-label/index.js ***!
  \********************************************************/
/*! exports provided: MDCFloatingLabel, MDCFloatingLabelFoundation */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "MDCFloatingLabel", function() { return MDCFloatingLabel; });
/* harmony import */ var _material_base_component__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @material/base/component */ "./node_modules/@material/base/component.js");
/* harmony import */ var _adapter__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./adapter */ "./node_modules/@material/floating-label/adapter.js");
/* harmony import */ var _foundation__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./foundation */ "./node_modules/@material/floating-label/foundation.js");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "MDCFloatingLabelFoundation", function() { return _foundation__WEBPACK_IMPORTED_MODULE_2__["default"]; });

function _typeof(obj) { if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

function _possibleConstructorReturn(self, call) { if (call && (_typeof(call) === "object" || typeof call === "function")) { return call; } return _assertThisInitialized(self); }

function _assertThisInitialized(self) { if (self === void 0) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return self; }

function _getPrototypeOf(o) { _getPrototypeOf = Object.setPrototypeOf ? Object.getPrototypeOf : function _getPrototypeOf(o) { return o.__proto__ || Object.getPrototypeOf(o); }; return _getPrototypeOf(o); }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function"); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, writable: true, configurable: true } }); if (superClass) _setPrototypeOf(subClass, superClass); }

function _setPrototypeOf(o, p) { _setPrototypeOf = Object.setPrototypeOf || function _setPrototypeOf(o, p) { o.__proto__ = p; return o; }; return _setPrototypeOf(o, p); }

/**
 * @license
 * Copyright 2016 Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */



/**
 * @extends {MDCComponent<!MDCFloatingLabelFoundation>}
 * @final
 */

var MDCFloatingLabel =
/*#__PURE__*/
function (_MDCComponent) {
  _inherits(MDCFloatingLabel, _MDCComponent);

  function MDCFloatingLabel() {
    _classCallCheck(this, MDCFloatingLabel);

    return _possibleConstructorReturn(this, _getPrototypeOf(MDCFloatingLabel).apply(this, arguments));
  }

  _createClass(MDCFloatingLabel, [{
    key: "shake",

    /**
     * Styles the label to produce the label shake for errors.
     * @param {boolean} shouldShake styles the label to shake by adding shake class
     * if true, otherwise will stop shaking by removing shake class.
     */
    value: function shake(shouldShake) {
      this.foundation_.shake(shouldShake);
    }
    /**
     * Styles label to float/dock.
     * @param {boolean} shouldFloat styles the label to float by adding float class
     * if true, otherwise docks the label by removing the float class.
     */

  }, {
    key: "float",
    value: function float(shouldFloat) {
      this.foundation_.float(shouldFloat);
    }
    /**
     * @return {number}
     */

  }, {
    key: "getWidth",
    value: function getWidth() {
      return this.foundation_.getWidth();
    }
    /**
     * @return {!MDCFloatingLabelFoundation}
     */

  }, {
    key: "getDefaultFoundation",
    value: function getDefaultFoundation() {
      var _this = this;

      return new _foundation__WEBPACK_IMPORTED_MODULE_2__["default"]({
        addClass: function addClass(className) {
          return _this.root_.classList.add(className);
        },
        removeClass: function removeClass(className) {
          return _this.root_.classList.remove(className);
        },
        getWidth: function getWidth() {
          return _this.root_.offsetWidth;
        },
        registerInteractionHandler: function registerInteractionHandler(evtType, handler) {
          return _this.root_.addEventListener(evtType, handler);
        },
        deregisterInteractionHandler: function deregisterInteractionHandler(evtType, handler) {
          return _this.root_.removeEventListener(evtType, handler);
        }
      });
    }
  }], [{
    key: "attachTo",

    /**
     * @param {!Element} root
     * @return {!MDCFloatingLabel}
     */
    value: function attachTo(root) {
      return new MDCFloatingLabel(root);
    }
  }]);

  return MDCFloatingLabel;
}(_material_base_component__WEBPACK_IMPORTED_MODULE_0__["default"]);



/***/ }),

/***/ "./node_modules/@material/form-field/adapter.js":
/*!******************************************************!*\
  !*** ./node_modules/@material/form-field/adapter.js ***!
  \******************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

/**
 * @license
 * Copyright 2016 Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/* eslint no-unused-vars: [2, {"args": "none"}] */

/**
 * Adapter for MDC Form Field. Provides an interface for managing
 * - event handlers
 * - ripple activation
 *
 * Additionally, provides type information for the adapter to the Closure
 * compiler.
 *
 * Implement this adapter for your framework of choice to delegate updates to
 * the component in your framework of choice. See architecture documentation
 * for more details.
 * https://github.com/material-components/material-components-web/blob/master/docs/code/architecture.md
 *
 * @record
 */
var MDCFormFieldAdapter =
/*#__PURE__*/
function () {
  function MDCFormFieldAdapter() {
    _classCallCheck(this, MDCFormFieldAdapter);
  }

  _createClass(MDCFormFieldAdapter, [{
    key: "registerInteractionHandler",

    /**
     * @param {string} type
     * @param {!EventListener} handler
     */
    value: function registerInteractionHandler(type, handler) {}
    /**
     * @param {string} type
     * @param {!EventListener} handler
     */

  }, {
    key: "deregisterInteractionHandler",
    value: function deregisterInteractionHandler(type, handler) {}
  }, {
    key: "activateInputRipple",
    value: function activateInputRipple() {}
  }, {
    key: "deactivateInputRipple",
    value: function deactivateInputRipple() {}
  }]);

  return MDCFormFieldAdapter;
}();

/* harmony default export */ __webpack_exports__["default"] = (MDCFormFieldAdapter);

/***/ }),

/***/ "./node_modules/@material/form-field/constants.js":
/*!********************************************************!*\
  !*** ./node_modules/@material/form-field/constants.js ***!
  \********************************************************/
/*! exports provided: cssClasses, strings */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "cssClasses", function() { return cssClasses; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "strings", function() { return strings; });
/**
 * @license
 * Copyright 2017 Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/** @enum {string} */
var cssClasses = {
  ROOT: 'mdc-form-field'
};
/** @enum {string} */

var strings = {
  LABEL_SELECTOR: '.mdc-form-field > label'
};


/***/ }),

/***/ "./node_modules/@material/form-field/foundation.js":
/*!*********************************************************!*\
  !*** ./node_modules/@material/form-field/foundation.js ***!
  \*********************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _material_base_foundation__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @material/base/foundation */ "./node_modules/@material/base/foundation.js");
/* harmony import */ var _adapter__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./adapter */ "./node_modules/@material/form-field/adapter.js");
/* harmony import */ var _constants__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./constants */ "./node_modules/@material/form-field/constants.js");
function _typeof(obj) { if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (call && (_typeof(call) === "object" || typeof call === "function")) { return call; } return _assertThisInitialized(self); }

function _assertThisInitialized(self) { if (self === void 0) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return self; }

function _getPrototypeOf(o) { _getPrototypeOf = Object.setPrototypeOf ? Object.getPrototypeOf : function _getPrototypeOf(o) { return o.__proto__ || Object.getPrototypeOf(o); }; return _getPrototypeOf(o); }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function"); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, writable: true, configurable: true } }); if (superClass) _setPrototypeOf(subClass, superClass); }

function _setPrototypeOf(o, p) { _setPrototypeOf = Object.setPrototypeOf || function _setPrototypeOf(o, p) { o.__proto__ = p; return o; }; return _setPrototypeOf(o, p); }

/**
 * @license
 * Copyright 2017 Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */



/**
 * @extends {MDCFoundation<!MDCFormFieldAdapter>}
 */

var MDCFormFieldFoundation =
/*#__PURE__*/
function (_MDCFoundation) {
  _inherits(MDCFormFieldFoundation, _MDCFoundation);

  _createClass(MDCFormFieldFoundation, null, [{
    key: "cssClasses",

    /** @return enum {cssClasses} */
    get: function get() {
      return _constants__WEBPACK_IMPORTED_MODULE_2__["cssClasses"];
    }
    /** @return enum {strings} */

  }, {
    key: "strings",
    get: function get() {
      return _constants__WEBPACK_IMPORTED_MODULE_2__["strings"];
    }
    /** @return {!MDCFormFieldAdapter} */

  }, {
    key: "defaultAdapter",
    get: function get() {
      return {
        registerInteractionHandler: function registerInteractionHandler()
        /* type: string, handler: EventListener */
        {},
        deregisterInteractionHandler: function deregisterInteractionHandler()
        /* type: string, handler: EventListener */
        {},
        activateInputRipple: function activateInputRipple() {},
        deactivateInputRipple: function deactivateInputRipple() {}
      };
    }
  }]);

  function MDCFormFieldFoundation(adapter) {
    var _this;

    _classCallCheck(this, MDCFormFieldFoundation);

    _this = _possibleConstructorReturn(this, _getPrototypeOf(MDCFormFieldFoundation).call(this, Object.assign(MDCFormFieldFoundation.defaultAdapter, adapter)));
    /** @private {!EventListener} */

    _this.clickHandler_ =
    /** @type {!EventListener} */
    function () {
      return _this.handleClick_();
    };

    return _this;
  }

  _createClass(MDCFormFieldFoundation, [{
    key: "init",
    value: function init() {
      this.adapter_.registerInteractionHandler('click', this.clickHandler_);
    }
  }, {
    key: "destroy",
    value: function destroy() {
      this.adapter_.deregisterInteractionHandler('click', this.clickHandler_);
    }
    /** @private */

  }, {
    key: "handleClick_",
    value: function handleClick_() {
      var _this2 = this;

      this.adapter_.activateInputRipple();
      requestAnimationFrame(function () {
        return _this2.adapter_.deactivateInputRipple();
      });
    }
  }]);

  return MDCFormFieldFoundation;
}(_material_base_foundation__WEBPACK_IMPORTED_MODULE_0__["default"]);

/* harmony default export */ __webpack_exports__["default"] = (MDCFormFieldFoundation);

/***/ }),

/***/ "./node_modules/@material/form-field/index.js":
/*!****************************************************!*\
  !*** ./node_modules/@material/form-field/index.js ***!
  \****************************************************/
/*! exports provided: MDCFormField, MDCFormFieldFoundation */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "MDCFormField", function() { return MDCFormField; });
/* harmony import */ var _material_base_component__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @material/base/component */ "./node_modules/@material/base/component.js");
/* harmony import */ var _foundation__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./foundation */ "./node_modules/@material/form-field/foundation.js");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "MDCFormFieldFoundation", function() { return _foundation__WEBPACK_IMPORTED_MODULE_1__["default"]; });

/* harmony import */ var _material_selection_control_index__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @material/selection-control/index */ "./node_modules/@material/selection-control/index.js");
function _typeof(obj) { if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (call && (_typeof(call) === "object" || typeof call === "function")) { return call; } return _assertThisInitialized(self); }

function _assertThisInitialized(self) { if (self === void 0) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return self; }

function _getPrototypeOf(o) { _getPrototypeOf = Object.setPrototypeOf ? Object.getPrototypeOf : function _getPrototypeOf(o) { return o.__proto__ || Object.getPrototypeOf(o); }; return _getPrototypeOf(o); }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function"); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, writable: true, configurable: true } }); if (superClass) _setPrototypeOf(subClass, superClass); }

function _setPrototypeOf(o, p) { _setPrototypeOf = Object.setPrototypeOf || function _setPrototypeOf(o, p) { o.__proto__ = p; return o; }; return _setPrototypeOf(o, p); }

/**
 * @license
 * Copyright 2017 Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */


/* eslint-disable no-unused-vars */


/* eslint-enable no-unused-vars */

/**
 * @extends MDCComponent<!MDCFormFieldFoundation>
 */

var MDCFormField =
/*#__PURE__*/
function (_MDCComponent) {
  _inherits(MDCFormField, _MDCComponent);

  _createClass(MDCFormField, [{
    key: "input",

    /** @param {?MDCSelectionControl} input */
    set: function set(input) {
      this.input_ = input;
    }
    /** @return {?MDCSelectionControl} */
    ,
    get: function get() {
      return this.input_;
    }
  }], [{
    key: "attachTo",
    value: function attachTo(root) {
      return new MDCFormField(root);
    }
  }]);

  function MDCFormField() {
    var _getPrototypeOf2;

    var _this;

    _classCallCheck(this, MDCFormField);

    for (var _len = arguments.length, args = new Array(_len), _key = 0; _key < _len; _key++) {
      args[_key] = arguments[_key];
    }

    _this = _possibleConstructorReturn(this, (_getPrototypeOf2 = _getPrototypeOf(MDCFormField)).call.apply(_getPrototypeOf2, [this].concat(args)));
    /** @private {?MDCSelectionControl} */

    _this.input_;
    return _this;
  }
  /**
   * @return {!Element}
   * @private
   */


  _createClass(MDCFormField, [{
    key: "getDefaultFoundation",

    /** @return {!MDCFormFieldFoundation} */
    value: function getDefaultFoundation() {
      var _this2 = this;

      return new _foundation__WEBPACK_IMPORTED_MODULE_1__["default"]({
        registerInteractionHandler: function registerInteractionHandler(type, handler) {
          return _this2.label_.addEventListener(type, handler);
        },
        deregisterInteractionHandler: function deregisterInteractionHandler(type, handler) {
          return _this2.label_.removeEventListener(type, handler);
        },
        activateInputRipple: function activateInputRipple() {
          if (_this2.input_ && _this2.input_.ripple) {
            _this2.input_.ripple.activate();
          }
        },
        deactivateInputRipple: function deactivateInputRipple() {
          if (_this2.input_ && _this2.input_.ripple) {
            _this2.input_.ripple.deactivate();
          }
        }
      });
    }
  }, {
    key: "label_",
    get: function get() {
      var LABEL_SELECTOR = _foundation__WEBPACK_IMPORTED_MODULE_1__["default"].strings.LABEL_SELECTOR;
      return (
        /** @type {!Element} */
        this.root_.querySelector(LABEL_SELECTOR)
      );
    }
  }]);

  return MDCFormField;
}(_material_base_component__WEBPACK_IMPORTED_MODULE_0__["default"]);



/***/ }),

/***/ "./node_modules/@material/line-ripple/adapter.js":
/*!*******************************************************!*\
  !*** ./node_modules/@material/line-ripple/adapter.js ***!
  \*******************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

/**
 * @license
 * Copyright 2018 Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/* eslint no-unused-vars: [2, {"args": "none"}] */

/**
 * Adapter for MDC TextField Line Ripple.
 *
 * Defines the shape of the adapter expected by the foundation. Implement this
 * adapter to integrate the line ripple into your framework. See
 * https://github.com/material-components/material-components-web/blob/master/docs/authoring-components.md
 * for more information.
 *
 * @record
 */
var MDCLineRippleAdapter =
/*#__PURE__*/
function () {
  function MDCLineRippleAdapter() {
    _classCallCheck(this, MDCLineRippleAdapter);
  }

  _createClass(MDCLineRippleAdapter, [{
    key: "addClass",

    /**
     * Adds a class to the line ripple element.
     * @param {string} className
     */
    value: function addClass(className) {}
    /**
     * Removes a class from the line ripple element.
     * @param {string} className
     */

  }, {
    key: "removeClass",
    value: function removeClass(className) {}
    /**
     * @param {string} className
     * @return {boolean}
     */

  }, {
    key: "hasClass",
    value: function hasClass(className) {}
    /**
     * Sets the style property with propertyName to value on the root element.
     * @param {string} propertyName
     * @param {string} value
     */

  }, {
    key: "setStyle",
    value: function setStyle(propertyName, value) {}
    /**
     * Registers an event listener on the line ripple element for a given event.
     * @param {string} evtType
     * @param {function(!Event): undefined} handler
     */

  }, {
    key: "registerEventHandler",
    value: function registerEventHandler(evtType, handler) {}
    /**
     * Deregisters an event listener on the line ripple element for a given event.
     * @param {string} evtType
     * @param {function(!Event): undefined} handler
     */

  }, {
    key: "deregisterEventHandler",
    value: function deregisterEventHandler(evtType, handler) {}
  }]);

  return MDCLineRippleAdapter;
}();

/* harmony default export */ __webpack_exports__["default"] = (MDCLineRippleAdapter);

/***/ }),

/***/ "./node_modules/@material/line-ripple/constants.js":
/*!*********************************************************!*\
  !*** ./node_modules/@material/line-ripple/constants.js ***!
  \*********************************************************/
/*! exports provided: cssClasses */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "cssClasses", function() { return cssClasses; });
/**
 * @license
 * Copyright 2018 Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/** @enum {string} */
var cssClasses = {
  LINE_RIPPLE_ACTIVE: 'mdc-line-ripple--active',
  LINE_RIPPLE_DEACTIVATING: 'mdc-line-ripple--deactivating'
};


/***/ }),

/***/ "./node_modules/@material/line-ripple/foundation.js":
/*!**********************************************************!*\
  !*** ./node_modules/@material/line-ripple/foundation.js ***!
  \**********************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _material_base_foundation__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @material/base/foundation */ "./node_modules/@material/base/foundation.js");
/* harmony import */ var _adapter__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./adapter */ "./node_modules/@material/line-ripple/adapter.js");
/* harmony import */ var _constants__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./constants */ "./node_modules/@material/line-ripple/constants.js");
function _typeof(obj) { if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (call && (_typeof(call) === "object" || typeof call === "function")) { return call; } return _assertThisInitialized(self); }

function _assertThisInitialized(self) { if (self === void 0) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return self; }

function _getPrototypeOf(o) { _getPrototypeOf = Object.setPrototypeOf ? Object.getPrototypeOf : function _getPrototypeOf(o) { return o.__proto__ || Object.getPrototypeOf(o); }; return _getPrototypeOf(o); }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function"); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, writable: true, configurable: true } }); if (superClass) _setPrototypeOf(subClass, superClass); }

function _setPrototypeOf(o, p) { _setPrototypeOf = Object.setPrototypeOf || function _setPrototypeOf(o, p) { o.__proto__ = p; return o; }; return _setPrototypeOf(o, p); }

/**
 * @license
 * Copyright 2018 Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */



/**
 * @extends {MDCFoundation<!MDCLineRippleAdapter>}
 * @final
 */

var MDCLineRippleFoundation =
/*#__PURE__*/
function (_MDCFoundation) {
  _inherits(MDCLineRippleFoundation, _MDCFoundation);

  _createClass(MDCLineRippleFoundation, null, [{
    key: "cssClasses",

    /** @return enum {string} */
    get: function get() {
      return _constants__WEBPACK_IMPORTED_MODULE_2__["cssClasses"];
    }
    /**
     * {@see MDCLineRippleAdapter} for typing information on parameters and return
     * types.
     * @return {!MDCLineRippleAdapter}
     */

  }, {
    key: "defaultAdapter",
    get: function get() {
      return (
        /** @type {!MDCLineRippleAdapter} */
        {
          addClass: function addClass() {},
          removeClass: function removeClass() {},
          hasClass: function hasClass() {},
          setStyle: function setStyle() {},
          registerEventHandler: function registerEventHandler() {},
          deregisterEventHandler: function deregisterEventHandler() {}
        }
      );
    }
    /**
     * @param {!MDCLineRippleAdapter=} adapter
     */

  }]);

  function MDCLineRippleFoundation() {
    var _this;

    var adapter = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] :
    /** @type {!MDCLineRippleAdapter} */
    {};

    _classCallCheck(this, MDCLineRippleFoundation);

    _this = _possibleConstructorReturn(this, _getPrototypeOf(MDCLineRippleFoundation).call(this, Object.assign(MDCLineRippleFoundation.defaultAdapter, adapter)));
    /** @private {function(!Event): undefined} */

    _this.transitionEndHandler_ = function (evt) {
      return _this.handleTransitionEnd(evt);
    };

    return _this;
  }

  _createClass(MDCLineRippleFoundation, [{
    key: "init",
    value: function init() {
      this.adapter_.registerEventHandler('transitionend', this.transitionEndHandler_);
    }
  }, {
    key: "destroy",
    value: function destroy() {
      this.adapter_.deregisterEventHandler('transitionend', this.transitionEndHandler_);
    }
    /**
     * Activates the line ripple
     */

  }, {
    key: "activate",
    value: function activate() {
      this.adapter_.removeClass(_constants__WEBPACK_IMPORTED_MODULE_2__["cssClasses"].LINE_RIPPLE_DEACTIVATING);
      this.adapter_.addClass(_constants__WEBPACK_IMPORTED_MODULE_2__["cssClasses"].LINE_RIPPLE_ACTIVE);
    }
    /**
     * Sets the center of the ripple animation to the given X coordinate.
     * @param {number} xCoordinate
     */

  }, {
    key: "setRippleCenter",
    value: function setRippleCenter(xCoordinate) {
      this.adapter_.setStyle('transform-origin', "".concat(xCoordinate, "px center"));
    }
    /**
     * Deactivates the line ripple
     */

  }, {
    key: "deactivate",
    value: function deactivate() {
      this.adapter_.addClass(_constants__WEBPACK_IMPORTED_MODULE_2__["cssClasses"].LINE_RIPPLE_DEACTIVATING);
    }
    /**
     * Handles a transition end event
     * @param {!Event} evt
     */

  }, {
    key: "handleTransitionEnd",
    value: function handleTransitionEnd(evt) {
      // Wait for the line ripple to be either transparent or opaque
      // before emitting the animation end event
      var isDeactivating = this.adapter_.hasClass(_constants__WEBPACK_IMPORTED_MODULE_2__["cssClasses"].LINE_RIPPLE_DEACTIVATING);

      if (evt.propertyName === 'opacity') {
        if (isDeactivating) {
          this.adapter_.removeClass(_constants__WEBPACK_IMPORTED_MODULE_2__["cssClasses"].LINE_RIPPLE_ACTIVE);
          this.adapter_.removeClass(_constants__WEBPACK_IMPORTED_MODULE_2__["cssClasses"].LINE_RIPPLE_DEACTIVATING);
        }
      }
    }
  }]);

  return MDCLineRippleFoundation;
}(_material_base_foundation__WEBPACK_IMPORTED_MODULE_0__["default"]);

/* harmony default export */ __webpack_exports__["default"] = (MDCLineRippleFoundation);

/***/ }),

/***/ "./node_modules/@material/line-ripple/index.js":
/*!*****************************************************!*\
  !*** ./node_modules/@material/line-ripple/index.js ***!
  \*****************************************************/
/*! exports provided: MDCLineRipple, MDCLineRippleFoundation */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "MDCLineRipple", function() { return MDCLineRipple; });
/* harmony import */ var _material_base_component__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @material/base/component */ "./node_modules/@material/base/component.js");
/* harmony import */ var _adapter__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./adapter */ "./node_modules/@material/line-ripple/adapter.js");
/* harmony import */ var _foundation__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./foundation */ "./node_modules/@material/line-ripple/foundation.js");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "MDCLineRippleFoundation", function() { return _foundation__WEBPACK_IMPORTED_MODULE_2__["default"]; });

function _typeof(obj) { if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

function _possibleConstructorReturn(self, call) { if (call && (_typeof(call) === "object" || typeof call === "function")) { return call; } return _assertThisInitialized(self); }

function _assertThisInitialized(self) { if (self === void 0) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return self; }

function _getPrototypeOf(o) { _getPrototypeOf = Object.setPrototypeOf ? Object.getPrototypeOf : function _getPrototypeOf(o) { return o.__proto__ || Object.getPrototypeOf(o); }; return _getPrototypeOf(o); }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function"); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, writable: true, configurable: true } }); if (superClass) _setPrototypeOf(subClass, superClass); }

function _setPrototypeOf(o, p) { _setPrototypeOf = Object.setPrototypeOf || function _setPrototypeOf(o, p) { o.__proto__ = p; return o; }; return _setPrototypeOf(o, p); }

/**
 * @license
 * Copyright 2018 Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */



/**
 * @extends {MDCComponent<!MDCLineRippleFoundation>}
 * @final
 */

var MDCLineRipple =
/*#__PURE__*/
function (_MDCComponent) {
  _inherits(MDCLineRipple, _MDCComponent);

  function MDCLineRipple() {
    _classCallCheck(this, MDCLineRipple);

    return _possibleConstructorReturn(this, _getPrototypeOf(MDCLineRipple).apply(this, arguments));
  }

  _createClass(MDCLineRipple, [{
    key: "activate",

    /**
     * Activates the line ripple
     */
    value: function activate() {
      this.foundation_.activate();
    }
    /**
     * Deactivates the line ripple
     */

  }, {
    key: "deactivate",
    value: function deactivate() {
      this.foundation_.deactivate();
    }
    /**
     * Sets the transform origin given a user's click location. The `rippleCenter` is the
     * x-coordinate of the middle of the ripple.
     * @param {number} xCoordinate
     */

  }, {
    key: "setRippleCenter",
    value: function setRippleCenter(xCoordinate) {
      this.foundation_.setRippleCenter(xCoordinate);
    }
    /**
     * @return {!MDCLineRippleFoundation}
     */

  }, {
    key: "getDefaultFoundation",
    value: function getDefaultFoundation() {
      var _this = this;

      return new _foundation__WEBPACK_IMPORTED_MODULE_2__["default"](
      /** @type {!MDCLineRippleAdapter} */
      Object.assign({
        addClass: function addClass(className) {
          return _this.root_.classList.add(className);
        },
        removeClass: function removeClass(className) {
          return _this.root_.classList.remove(className);
        },
        hasClass: function hasClass(className) {
          return _this.root_.classList.contains(className);
        },
        setStyle: function setStyle(propertyName, value) {
          return _this.root_.style[propertyName] = value;
        },
        registerEventHandler: function registerEventHandler(evtType, handler) {
          return _this.root_.addEventListener(evtType, handler);
        },
        deregisterEventHandler: function deregisterEventHandler(evtType, handler) {
          return _this.root_.removeEventListener(evtType, handler);
        }
      }));
    }
  }], [{
    key: "attachTo",

    /**
     * @param {!Element} root
     * @return {!MDCLineRipple}
     */
    value: function attachTo(root) {
      return new MDCLineRipple(root);
    }
  }]);

  return MDCLineRipple;
}(_material_base_component__WEBPACK_IMPORTED_MODULE_0__["default"]);



/***/ }),

/***/ "./node_modules/@material/notched-outline/adapter.js":
/*!***********************************************************!*\
  !*** ./node_modules/@material/notched-outline/adapter.js ***!
  \***********************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

/**
 * @license
 * Copyright 2017 Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/* eslint no-unused-vars: [2, {"args": "none"}] */

/**
 * Adapter for MDC Notched Outline.
 *
 * Defines the shape of the adapter expected by the foundation. Implement this
 * adapter to integrate the Notched Outline into your framework. See
 * https://github.com/material-components/material-components-web/blob/master/docs/authoring-components.md
 * for more information.
 *
 * @record
 */
var MDCNotchedOutlineAdapter =
/*#__PURE__*/
function () {
  function MDCNotchedOutlineAdapter() {
    _classCallCheck(this, MDCNotchedOutlineAdapter);
  }

  _createClass(MDCNotchedOutlineAdapter, [{
    key: "getWidth",

    /**
     * Returns the width of the root element.
     * @return {number}
     */
    value: function getWidth() {}
    /**
     * Returns the height of the root element.
     * @return {number}
     */

  }, {
    key: "getHeight",
    value: function getHeight() {}
    /**
     * Adds a class to the root element.
     * @param {string} className
     */

  }, {
    key: "addClass",
    value: function addClass(className) {}
    /**
     * Removes a class from the root element.
     * @param {string} className
     */

  }, {
    key: "removeClass",
    value: function removeClass(className) {}
    /**
     * Sets the "d" attribute of the outline element's SVG path.
     * @param {string} value
     */

  }, {
    key: "setOutlinePathAttr",
    value: function setOutlinePathAttr(value) {}
    /**
     * Returns the idle outline element's computed style value of the given css property `propertyName`.
     * We achieve this via `getComputedStyle(...).getPropertyValue(propertyName)`.
     * @param {string} propertyName
     * @return {string}
     */

  }, {
    key: "getIdleOutlineStyleValue",
    value: function getIdleOutlineStyleValue(propertyName) {}
  }]);

  return MDCNotchedOutlineAdapter;
}();

/* harmony default export */ __webpack_exports__["default"] = (MDCNotchedOutlineAdapter);

/***/ }),

/***/ "./node_modules/@material/notched-outline/constants.js":
/*!*************************************************************!*\
  !*** ./node_modules/@material/notched-outline/constants.js ***!
  \*************************************************************/
/*! exports provided: cssClasses, strings */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "cssClasses", function() { return cssClasses; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "strings", function() { return strings; });
/**
 * @license
 * Copyright 2018 Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/** @enum {string} */
var strings = {
  PATH_SELECTOR: '.mdc-notched-outline__path',
  IDLE_OUTLINE_SELECTOR: '.mdc-notched-outline__idle'
};
/** @enum {string} */

var cssClasses = {
  OUTLINE_NOTCHED: 'mdc-notched-outline--notched'
};


/***/ }),

/***/ "./node_modules/@material/notched-outline/foundation.js":
/*!**************************************************************!*\
  !*** ./node_modules/@material/notched-outline/foundation.js ***!
  \**************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _material_base_foundation__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @material/base/foundation */ "./node_modules/@material/base/foundation.js");
/* harmony import */ var _adapter__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./adapter */ "./node_modules/@material/notched-outline/adapter.js");
/* harmony import */ var _constants__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./constants */ "./node_modules/@material/notched-outline/constants.js");
function _typeof(obj) { if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (call && (_typeof(call) === "object" || typeof call === "function")) { return call; } return _assertThisInitialized(self); }

function _assertThisInitialized(self) { if (self === void 0) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return self; }

function _getPrototypeOf(o) { _getPrototypeOf = Object.setPrototypeOf ? Object.getPrototypeOf : function _getPrototypeOf(o) { return o.__proto__ || Object.getPrototypeOf(o); }; return _getPrototypeOf(o); }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function"); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, writable: true, configurable: true } }); if (superClass) _setPrototypeOf(subClass, superClass); }

function _setPrototypeOf(o, p) { _setPrototypeOf = Object.setPrototypeOf || function _setPrototypeOf(o, p) { o.__proto__ = p; return o; }; return _setPrototypeOf(o, p); }

/**
 * @license
 * Copyright 2017 Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */



/**
 * @extends {MDCFoundation<!MDCNotchedOutlineAdapter>}
 * @final
 */

var MDCNotchedOutlineFoundation =
/*#__PURE__*/
function (_MDCFoundation) {
  _inherits(MDCNotchedOutlineFoundation, _MDCFoundation);

  _createClass(MDCNotchedOutlineFoundation, null, [{
    key: "strings",

    /** @return enum {string} */
    get: function get() {
      return _constants__WEBPACK_IMPORTED_MODULE_2__["strings"];
    }
    /** @return enum {string} */

  }, {
    key: "cssClasses",
    get: function get() {
      return _constants__WEBPACK_IMPORTED_MODULE_2__["cssClasses"];
    }
    /**
     * {@see MDCNotchedOutlineAdapter} for typing information on parameters and return
     * types.
     * @return {!MDCNotchedOutlineAdapter}
     */

  }, {
    key: "defaultAdapter",
    get: function get() {
      return (
        /** @type {!MDCNotchedOutlineAdapter} */
        {
          getWidth: function getWidth() {},
          getHeight: function getHeight() {},
          addClass: function addClass() {},
          removeClass: function removeClass() {},
          setOutlinePathAttr: function setOutlinePathAttr() {},
          getIdleOutlineStyleValue: function getIdleOutlineStyleValue() {}
        }
      );
    }
    /**
     * @param {!MDCNotchedOutlineAdapter} adapter
     */

  }]);

  function MDCNotchedOutlineFoundation(adapter) {
    _classCallCheck(this, MDCNotchedOutlineFoundation);

    return _possibleConstructorReturn(this, _getPrototypeOf(MDCNotchedOutlineFoundation).call(this, Object.assign(MDCNotchedOutlineFoundation.defaultAdapter, adapter)));
  }
  /**
   * Adds the outline notched selector and updates the notch width
   * calculated based off of notchWidth and isRtl.
   * @param {number} notchWidth
   * @param {boolean=} isRtl
   */


  _createClass(MDCNotchedOutlineFoundation, [{
    key: "notch",
    value: function notch(notchWidth) {
      var isRtl = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : false;
      var OUTLINE_NOTCHED = MDCNotchedOutlineFoundation.cssClasses.OUTLINE_NOTCHED;
      this.adapter_.addClass(OUTLINE_NOTCHED);
      this.updateSvgPath_(notchWidth, isRtl);
    }
    /**
     * Removes notched outline selector to close the notch in the outline.
     */

  }, {
    key: "closeNotch",
    value: function closeNotch() {
      var OUTLINE_NOTCHED = MDCNotchedOutlineFoundation.cssClasses.OUTLINE_NOTCHED;
      this.adapter_.removeClass(OUTLINE_NOTCHED);
    }
    /**
     * Updates the SVG path of the focus outline element based on the notchWidth
     * and the RTL context.
     * @param {number} notchWidth
     * @param {boolean=} isRtl
     * @private
     */

  }, {
    key: "updateSvgPath_",
    value: function updateSvgPath_(notchWidth, isRtl) {
      // Fall back to reading a specific corner's style because Firefox doesn't report the style on border-radius.
      var radiusStyleValue = this.adapter_.getIdleOutlineStyleValue('border-radius') || this.adapter_.getIdleOutlineStyleValue('border-top-left-radius');
      var radius = parseFloat(radiusStyleValue);
      var width = this.adapter_.getWidth();
      var height = this.adapter_.getHeight();
      var cornerWidth = radius + 1.2;
      var leadingStrokeLength = Math.abs(11 - cornerWidth);
      var paddedNotchWidth = notchWidth + 8; // The right, bottom, and left sides of the outline follow the same SVG path.

      var pathMiddle = 'a' + radius + ',' + radius + ' 0 0 1 ' + radius + ',' + radius + 'v' + (height - 2 * cornerWidth) + 'a' + radius + ',' + radius + ' 0 0 1 ' + -radius + ',' + radius + 'h' + (-width + 2 * cornerWidth) + 'a' + radius + ',' + radius + ' 0 0 1 ' + -radius + ',' + -radius + 'v' + (-height + 2 * cornerWidth) + 'a' + radius + ',' + radius + ' 0 0 1 ' + radius + ',' + -radius;
      var path;

      if (!isRtl) {
        path = 'M' + (cornerWidth + leadingStrokeLength + paddedNotchWidth) + ',' + 1 + 'h' + (width - 2 * cornerWidth - paddedNotchWidth - leadingStrokeLength) + pathMiddle + 'h' + leadingStrokeLength;
      } else {
        path = 'M' + (width - cornerWidth - leadingStrokeLength) + ',' + 1 + 'h' + leadingStrokeLength + pathMiddle + 'h' + (width - 2 * cornerWidth - paddedNotchWidth - leadingStrokeLength);
      }

      this.adapter_.setOutlinePathAttr(path);
    }
  }]);

  return MDCNotchedOutlineFoundation;
}(_material_base_foundation__WEBPACK_IMPORTED_MODULE_0__["default"]);

/* harmony default export */ __webpack_exports__["default"] = (MDCNotchedOutlineFoundation);

/***/ }),

/***/ "./node_modules/@material/notched-outline/index.js":
/*!*********************************************************!*\
  !*** ./node_modules/@material/notched-outline/index.js ***!
  \*********************************************************/
/*! exports provided: MDCNotchedOutline, MDCNotchedOutlineFoundation */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "MDCNotchedOutline", function() { return MDCNotchedOutline; });
/* harmony import */ var _material_base_component__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @material/base/component */ "./node_modules/@material/base/component.js");
/* harmony import */ var _adapter__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./adapter */ "./node_modules/@material/notched-outline/adapter.js");
/* harmony import */ var _foundation__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./foundation */ "./node_modules/@material/notched-outline/foundation.js");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "MDCNotchedOutlineFoundation", function() { return _foundation__WEBPACK_IMPORTED_MODULE_2__["default"]; });

/* harmony import */ var _constants__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./constants */ "./node_modules/@material/notched-outline/constants.js");
function _typeof(obj) { if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

function _possibleConstructorReturn(self, call) { if (call && (_typeof(call) === "object" || typeof call === "function")) { return call; } return _assertThisInitialized(self); }

function _assertThisInitialized(self) { if (self === void 0) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return self; }

function _getPrototypeOf(o) { _getPrototypeOf = Object.setPrototypeOf ? Object.getPrototypeOf : function _getPrototypeOf(o) { return o.__proto__ || Object.getPrototypeOf(o); }; return _getPrototypeOf(o); }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function"); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, writable: true, configurable: true } }); if (superClass) _setPrototypeOf(subClass, superClass); }

function _setPrototypeOf(o, p) { _setPrototypeOf = Object.setPrototypeOf || function _setPrototypeOf(o, p) { o.__proto__ = p; return o; }; return _setPrototypeOf(o, p); }

/**
 * @license
 * Copyright 2017 Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */




/**
 * @extends {MDCComponent<!MDCNotchedOutlineFoundation>}
 * @final
 */

var MDCNotchedOutline =
/*#__PURE__*/
function (_MDCComponent) {
  _inherits(MDCNotchedOutline, _MDCComponent);

  function MDCNotchedOutline() {
    _classCallCheck(this, MDCNotchedOutline);

    return _possibleConstructorReturn(this, _getPrototypeOf(MDCNotchedOutline).apply(this, arguments));
  }

  _createClass(MDCNotchedOutline, [{
    key: "notch",

    /**
      * Updates outline selectors and SVG path to open notch.
      * @param {number} notchWidth The notch width in the outline.
      * @param {boolean=} isRtl Determines if outline is rtl. If rtl is true, notch
      * will be right justified in outline path, otherwise left justified.
      */
    value: function notch(notchWidth, isRtl) {
      this.foundation_.notch(notchWidth, isRtl);
    }
    /**
     * Updates the outline selectors to close notch and return it to idle state.
     */

  }, {
    key: "closeNotch",
    value: function closeNotch() {
      this.foundation_.closeNotch();
    }
    /**
     * @return {!MDCNotchedOutlineFoundation}
     */

  }, {
    key: "getDefaultFoundation",
    value: function getDefaultFoundation() {
      var _this = this;

      return new _foundation__WEBPACK_IMPORTED_MODULE_2__["default"]({
        getWidth: function getWidth() {
          return _this.root_.offsetWidth;
        },
        getHeight: function getHeight() {
          return _this.root_.offsetHeight;
        },
        addClass: function addClass(className) {
          return _this.root_.classList.add(className);
        },
        removeClass: function removeClass(className) {
          return _this.root_.classList.remove(className);
        },
        setOutlinePathAttr: function setOutlinePathAttr(value) {
          var path = _this.root_.querySelector(_constants__WEBPACK_IMPORTED_MODULE_3__["strings"].PATH_SELECTOR);

          path.setAttribute('d', value);
        },
        getIdleOutlineStyleValue: function getIdleOutlineStyleValue(propertyName) {
          var idleOutlineElement = _this.root_.parentNode.querySelector(_constants__WEBPACK_IMPORTED_MODULE_3__["strings"].IDLE_OUTLINE_SELECTOR);

          return window.getComputedStyle(idleOutlineElement).getPropertyValue(propertyName);
        }
      });
    }
  }], [{
    key: "attachTo",

    /**
     * @param {!Element} root
     * @return {!MDCNotchedOutline}
     */
    value: function attachTo(root) {
      return new MDCNotchedOutline(root);
    }
  }]);

  return MDCNotchedOutline;
}(_material_base_component__WEBPACK_IMPORTED_MODULE_0__["default"]);



/***/ }),

/***/ "./node_modules/@material/ripple/adapter.js":
/*!**************************************************!*\
  !*** ./node_modules/@material/ripple/adapter.js ***!
  \**************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

/**
 * @license
 * Copyright 2016 Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/* eslint no-unused-vars: [2, {"args": "none"}] */

/**
 * Adapter for MDC Ripple. Provides an interface for managing
 * - classes
 * - dom
 * - CSS variables
 * - position
 * - dimensions
 * - scroll position
 * - event handlers
 * - unbounded, active and disabled states
 *
 * Additionally, provides type information for the adapter to the Closure
 * compiler.
 *
 * Implement this adapter for your framework of choice to delegate updates to
 * the component in your framework of choice. See architecture documentation
 * for more details.
 * https://github.com/material-components/material-components-web/blob/master/docs/code/architecture.md
 *
 * @record
 */
var MDCRippleAdapter =
/*#__PURE__*/
function () {
  function MDCRippleAdapter() {
    _classCallCheck(this, MDCRippleAdapter);
  }

  _createClass(MDCRippleAdapter, [{
    key: "browserSupportsCssVars",

    /** @return {boolean} */
    value: function browserSupportsCssVars() {}
    /** @return {boolean} */

  }, {
    key: "isUnbounded",
    value: function isUnbounded() {}
    /** @return {boolean} */

  }, {
    key: "isSurfaceActive",
    value: function isSurfaceActive() {}
    /** @return {boolean} */

  }, {
    key: "isSurfaceDisabled",
    value: function isSurfaceDisabled() {}
    /** @param {string} className */

  }, {
    key: "addClass",
    value: function addClass(className) {}
    /** @param {string} className */

  }, {
    key: "removeClass",
    value: function removeClass(className) {}
    /** @param {!EventTarget} target */

  }, {
    key: "containsEventTarget",
    value: function containsEventTarget(target) {}
    /**
     * @param {string} evtType
     * @param {!Function} handler
     */

  }, {
    key: "registerInteractionHandler",
    value: function registerInteractionHandler(evtType, handler) {}
    /**
     * @param {string} evtType
     * @param {!Function} handler
     */

  }, {
    key: "deregisterInteractionHandler",
    value: function deregisterInteractionHandler(evtType, handler) {}
    /**
     * @param {string} evtType
     * @param {!Function} handler
     */

  }, {
    key: "registerDocumentInteractionHandler",
    value: function registerDocumentInteractionHandler(evtType, handler) {}
    /**
     * @param {string} evtType
     * @param {!Function} handler
     */

  }, {
    key: "deregisterDocumentInteractionHandler",
    value: function deregisterDocumentInteractionHandler(evtType, handler) {}
    /**
     * @param {!Function} handler
     */

  }, {
    key: "registerResizeHandler",
    value: function registerResizeHandler(handler) {}
    /**
     * @param {!Function} handler
     */

  }, {
    key: "deregisterResizeHandler",
    value: function deregisterResizeHandler(handler) {}
    /**
     * @param {string} varName
     * @param {?number|string} value
     */

  }, {
    key: "updateCssVariable",
    value: function updateCssVariable(varName, value) {}
    /** @return {!ClientRect} */

  }, {
    key: "computeBoundingRect",
    value: function computeBoundingRect() {}
    /** @return {{x: number, y: number}} */

  }, {
    key: "getWindowPageOffset",
    value: function getWindowPageOffset() {}
  }]);

  return MDCRippleAdapter;
}();

/* harmony default export */ __webpack_exports__["default"] = (MDCRippleAdapter);

/***/ }),

/***/ "./node_modules/@material/ripple/constants.js":
/*!****************************************************!*\
  !*** ./node_modules/@material/ripple/constants.js ***!
  \****************************************************/
/*! exports provided: cssClasses, strings, numbers */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "cssClasses", function() { return cssClasses; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "strings", function() { return strings; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "numbers", function() { return numbers; });
/**
 * @license
 * Copyright 2016 Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
var cssClasses = {
  // Ripple is a special case where the "root" component is really a "mixin" of sorts,
  // given that it's an 'upgrade' to an existing component. That being said it is the root
  // CSS class that all other CSS classes derive from.
  ROOT: 'mdc-ripple-upgraded',
  UNBOUNDED: 'mdc-ripple-upgraded--unbounded',
  BG_FOCUSED: 'mdc-ripple-upgraded--background-focused',
  FG_ACTIVATION: 'mdc-ripple-upgraded--foreground-activation',
  FG_DEACTIVATION: 'mdc-ripple-upgraded--foreground-deactivation'
};
var strings = {
  VAR_LEFT: '--mdc-ripple-left',
  VAR_TOP: '--mdc-ripple-top',
  VAR_FG_SIZE: '--mdc-ripple-fg-size',
  VAR_FG_SCALE: '--mdc-ripple-fg-scale',
  VAR_FG_TRANSLATE_START: '--mdc-ripple-fg-translate-start',
  VAR_FG_TRANSLATE_END: '--mdc-ripple-fg-translate-end'
};
var numbers = {
  PADDING: 10,
  INITIAL_ORIGIN_SCALE: 0.6,
  DEACTIVATION_TIMEOUT_MS: 225,
  // Corresponds to $mdc-ripple-translate-duration (i.e. activation animation duration)
  FG_DEACTIVATION_MS: 150,
  // Corresponds to $mdc-ripple-fade-out-duration (i.e. deactivation animation duration)
  TAP_DELAY_MS: 300 // Delay between touch and simulated mouse events on touch devices

};


/***/ }),

/***/ "./node_modules/@material/ripple/foundation.js":
/*!*****************************************************!*\
  !*** ./node_modules/@material/ripple/foundation.js ***!
  \*****************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _material_base_foundation__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @material/base/foundation */ "./node_modules/@material/base/foundation.js");
/* harmony import */ var _adapter__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./adapter */ "./node_modules/@material/ripple/adapter.js");
/* harmony import */ var _constants__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./constants */ "./node_modules/@material/ripple/constants.js");
/* harmony import */ var _util__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./util */ "./node_modules/@material/ripple/util.js");
function _typeof(obj) { if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (call && (_typeof(call) === "object" || typeof call === "function")) { return call; } return _assertThisInitialized(self); }

function _assertThisInitialized(self) { if (self === void 0) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return self; }

function _getPrototypeOf(o) { _getPrototypeOf = Object.setPrototypeOf ? Object.getPrototypeOf : function _getPrototypeOf(o) { return o.__proto__ || Object.getPrototypeOf(o); }; return _getPrototypeOf(o); }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function"); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, writable: true, configurable: true } }); if (superClass) _setPrototypeOf(subClass, superClass); }

function _setPrototypeOf(o, p) { _setPrototypeOf = Object.setPrototypeOf || function _setPrototypeOf(o, p) { o.__proto__ = p; return o; }; return _setPrototypeOf(o, p); }

/**
 * @license
 * Copyright 2016 Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */




/**
 * @typedef {{
 *   isActivated: (boolean|undefined),
 *   hasDeactivationUXRun: (boolean|undefined),
 *   wasActivatedByPointer: (boolean|undefined),
 *   wasElementMadeActive: (boolean|undefined),
 *   activationEvent: Event,
 *   isProgrammatic: (boolean|undefined)
 * }}
 */

var ActivationStateType;
/**
 * @typedef {{
 *   activate: (string|undefined),
 *   deactivate: (string|undefined),
 *   focus: (string|undefined),
 *   blur: (string|undefined)
 * }}
 */

var ListenerInfoType;
/**
 * @typedef {{
 *   activate: function(!Event),
 *   deactivate: function(!Event),
 *   focus: function(),
 *   blur: function()
 * }}
 */

var ListenersType;
/**
 * @typedef {{
 *   x: number,
 *   y: number
 * }}
 */

var PointType; // Activation events registered on the root element of each instance for activation

var ACTIVATION_EVENT_TYPES = ['touchstart', 'pointerdown', 'mousedown', 'keydown']; // Deactivation events registered on documentElement when a pointer-related down event occurs

var POINTER_DEACTIVATION_EVENT_TYPES = ['touchend', 'pointerup', 'mouseup']; // Tracks activations that have occurred on the current frame, to avoid simultaneous nested activations

/** @type {!Array<!EventTarget>} */

var activatedTargets = [];
/**
 * @extends {MDCFoundation<!MDCRippleAdapter>}
 */

var MDCRippleFoundation =
/*#__PURE__*/
function (_MDCFoundation) {
  _inherits(MDCRippleFoundation, _MDCFoundation);

  _createClass(MDCRippleFoundation, null, [{
    key: "cssClasses",
    get: function get() {
      return _constants__WEBPACK_IMPORTED_MODULE_2__["cssClasses"];
    }
  }, {
    key: "strings",
    get: function get() {
      return _constants__WEBPACK_IMPORTED_MODULE_2__["strings"];
    }
  }, {
    key: "numbers",
    get: function get() {
      return _constants__WEBPACK_IMPORTED_MODULE_2__["numbers"];
    }
  }, {
    key: "defaultAdapter",
    get: function get() {
      return {
        browserSupportsCssVars: function browserSupportsCssVars()
        /* boolean - cached */
        {},
        isUnbounded: function isUnbounded()
        /* boolean */
        {},
        isSurfaceActive: function isSurfaceActive()
        /* boolean */
        {},
        isSurfaceDisabled: function isSurfaceDisabled()
        /* boolean */
        {},
        addClass: function addClass()
        /* className: string */
        {},
        removeClass: function removeClass()
        /* className: string */
        {},
        containsEventTarget: function containsEventTarget()
        /* target: !EventTarget */
        {},
        registerInteractionHandler: function registerInteractionHandler()
        /* evtType: string, handler: EventListener */
        {},
        deregisterInteractionHandler: function deregisterInteractionHandler()
        /* evtType: string, handler: EventListener */
        {},
        registerDocumentInteractionHandler: function registerDocumentInteractionHandler()
        /* evtType: string, handler: EventListener */
        {},
        deregisterDocumentInteractionHandler: function deregisterDocumentInteractionHandler()
        /* evtType: string, handler: EventListener */
        {},
        registerResizeHandler: function registerResizeHandler()
        /* handler: EventListener */
        {},
        deregisterResizeHandler: function deregisterResizeHandler()
        /* handler: EventListener */
        {},
        updateCssVariable: function updateCssVariable()
        /* varName: string, value: string */
        {},
        computeBoundingRect: function computeBoundingRect()
        /* ClientRect */
        {},
        getWindowPageOffset: function getWindowPageOffset()
        /* {x: number, y: number} */
        {}
      };
    }
  }]);

  function MDCRippleFoundation(adapter) {
    var _this;

    _classCallCheck(this, MDCRippleFoundation);

    _this = _possibleConstructorReturn(this, _getPrototypeOf(MDCRippleFoundation).call(this, Object.assign(MDCRippleFoundation.defaultAdapter, adapter)));
    /** @private {number} */

    _this.layoutFrame_ = 0;
    /** @private {!ClientRect} */

    _this.frame_ =
    /** @type {!ClientRect} */
    {
      width: 0,
      height: 0
    };
    /** @private {!ActivationStateType} */

    _this.activationState_ = _this.defaultActivationState_();
    /** @private {number} */

    _this.initialSize_ = 0;
    /** @private {number} */

    _this.maxRadius_ = 0;
    /** @private {function(!Event)} */

    _this.activateHandler_ = function (e) {
      return _this.activate_(e);
    };
    /** @private {function(!Event)} */


    _this.deactivateHandler_ = function (e) {
      return _this.deactivate_(e);
    };
    /** @private {function(?Event=)} */


    _this.focusHandler_ = function () {
      return requestAnimationFrame(function () {
        return _this.adapter_.addClass(MDCRippleFoundation.cssClasses.BG_FOCUSED);
      });
    };
    /** @private {function(?Event=)} */


    _this.blurHandler_ = function () {
      return requestAnimationFrame(function () {
        return _this.adapter_.removeClass(MDCRippleFoundation.cssClasses.BG_FOCUSED);
      });
    };
    /** @private {!Function} */


    _this.resizeHandler_ = function () {
      return _this.layout();
    };
    /** @private {{left: number, top:number}} */


    _this.unboundedCoords_ = {
      left: 0,
      top: 0
    };
    /** @private {number} */

    _this.fgScale_ = 0;
    /** @private {number} */

    _this.activationTimer_ = 0;
    /** @private {number} */

    _this.fgDeactivationRemovalTimer_ = 0;
    /** @private {boolean} */

    _this.activationAnimationHasEnded_ = false;
    /** @private {!Function} */

    _this.activationTimerCallback_ = function () {
      _this.activationAnimationHasEnded_ = true;

      _this.runDeactivationUXLogicIfReady_();
    };
    /** @private {?Event} */


    _this.previousActivationEvent_ = null;
    return _this;
  }
  /**
   * We compute this property so that we are not querying information about the client
   * until the point in time where the foundation requests it. This prevents scenarios where
   * client-side feature-detection may happen too early, such as when components are rendered on the server
   * and then initialized at mount time on the client.
   * @return {boolean}
   * @private
   */


  _createClass(MDCRippleFoundation, [{
    key: "isSupported_",
    value: function isSupported_() {
      return this.adapter_.browserSupportsCssVars();
    }
    /**
     * @return {!ActivationStateType}
     */

  }, {
    key: "defaultActivationState_",
    value: function defaultActivationState_() {
      return {
        isActivated: false,
        hasDeactivationUXRun: false,
        wasActivatedByPointer: false,
        wasElementMadeActive: false,
        activationEvent: null,
        isProgrammatic: false
      };
    }
  }, {
    key: "init",
    value: function init() {
      var _this2 = this;

      if (!this.isSupported_()) {
        return;
      }

      this.registerRootHandlers_();
      var _MDCRippleFoundation$ = MDCRippleFoundation.cssClasses,
          ROOT = _MDCRippleFoundation$.ROOT,
          UNBOUNDED = _MDCRippleFoundation$.UNBOUNDED;
      requestAnimationFrame(function () {
        _this2.adapter_.addClass(ROOT);

        if (_this2.adapter_.isUnbounded()) {
          _this2.adapter_.addClass(UNBOUNDED); // Unbounded ripples need layout logic applied immediately to set coordinates for both shade and ripple


          _this2.layoutInternal_();
        }
      });
    }
  }, {
    key: "destroy",
    value: function destroy() {
      var _this3 = this;

      if (!this.isSupported_()) {
        return;
      }

      if (this.activationTimer_) {
        clearTimeout(this.activationTimer_);
        this.activationTimer_ = 0;
        var FG_ACTIVATION = MDCRippleFoundation.cssClasses.FG_ACTIVATION;
        this.adapter_.removeClass(FG_ACTIVATION);
      }

      this.deregisterRootHandlers_();
      this.deregisterDeactivationHandlers_();
      var _MDCRippleFoundation$2 = MDCRippleFoundation.cssClasses,
          ROOT = _MDCRippleFoundation$2.ROOT,
          UNBOUNDED = _MDCRippleFoundation$2.UNBOUNDED;
      requestAnimationFrame(function () {
        _this3.adapter_.removeClass(ROOT);

        _this3.adapter_.removeClass(UNBOUNDED);

        _this3.removeCssVars_();
      });
    }
    /** @private */

  }, {
    key: "registerRootHandlers_",
    value: function registerRootHandlers_() {
      var _this4 = this;

      ACTIVATION_EVENT_TYPES.forEach(function (type) {
        _this4.adapter_.registerInteractionHandler(type, _this4.activateHandler_);
      });
      this.adapter_.registerInteractionHandler('focus', this.focusHandler_);
      this.adapter_.registerInteractionHandler('blur', this.blurHandler_);

      if (this.adapter_.isUnbounded()) {
        this.adapter_.registerResizeHandler(this.resizeHandler_);
      }
    }
    /**
     * @param {!Event} e
     * @private
     */

  }, {
    key: "registerDeactivationHandlers_",
    value: function registerDeactivationHandlers_(e) {
      var _this5 = this;

      if (e.type === 'keydown') {
        this.adapter_.registerInteractionHandler('keyup', this.deactivateHandler_);
      } else {
        POINTER_DEACTIVATION_EVENT_TYPES.forEach(function (type) {
          _this5.adapter_.registerDocumentInteractionHandler(type, _this5.deactivateHandler_);
        });
      }
    }
    /** @private */

  }, {
    key: "deregisterRootHandlers_",
    value: function deregisterRootHandlers_() {
      var _this6 = this;

      ACTIVATION_EVENT_TYPES.forEach(function (type) {
        _this6.adapter_.deregisterInteractionHandler(type, _this6.activateHandler_);
      });
      this.adapter_.deregisterInteractionHandler('focus', this.focusHandler_);
      this.adapter_.deregisterInteractionHandler('blur', this.blurHandler_);

      if (this.adapter_.isUnbounded()) {
        this.adapter_.deregisterResizeHandler(this.resizeHandler_);
      }
    }
    /** @private */

  }, {
    key: "deregisterDeactivationHandlers_",
    value: function deregisterDeactivationHandlers_() {
      var _this7 = this;

      this.adapter_.deregisterInteractionHandler('keyup', this.deactivateHandler_);
      POINTER_DEACTIVATION_EVENT_TYPES.forEach(function (type) {
        _this7.adapter_.deregisterDocumentInteractionHandler(type, _this7.deactivateHandler_);
      });
    }
    /** @private */

  }, {
    key: "removeCssVars_",
    value: function removeCssVars_() {
      var _this8 = this;

      var strings = MDCRippleFoundation.strings;
      Object.keys(strings).forEach(function (k) {
        if (k.indexOf('VAR_') === 0) {
          _this8.adapter_.updateCssVariable(strings[k], null);
        }
      });
    }
    /**
     * @param {?Event} e
     * @private
     */

  }, {
    key: "activate_",
    value: function activate_(e) {
      var _this9 = this;

      if (this.adapter_.isSurfaceDisabled()) {
        return;
      }

      var activationState = this.activationState_;

      if (activationState.isActivated) {
        return;
      } // Avoid reacting to follow-on events fired by touch device after an already-processed user interaction


      var previousActivationEvent = this.previousActivationEvent_;
      var isSameInteraction = previousActivationEvent && e && previousActivationEvent.type !== e.type;

      if (isSameInteraction) {
        return;
      }

      activationState.isActivated = true;
      activationState.isProgrammatic = e === null;
      activationState.activationEvent = e;
      activationState.wasActivatedByPointer = activationState.isProgrammatic ? false : e.type === 'mousedown' || e.type === 'touchstart' || e.type === 'pointerdown';
      var hasActivatedChild = e && activatedTargets.length > 0 && activatedTargets.some(function (target) {
        return _this9.adapter_.containsEventTarget(target);
      });

      if (hasActivatedChild) {
        // Immediately reset activation state, while preserving logic that prevents touch follow-on events
        this.resetActivationState_();
        return;
      }

      if (e) {
        activatedTargets.push(
        /** @type {!EventTarget} */
        e.target);
        this.registerDeactivationHandlers_(e);
      }

      activationState.wasElementMadeActive = this.checkElementMadeActive_(e);

      if (activationState.wasElementMadeActive) {
        this.animateActivation_();
      }

      requestAnimationFrame(function () {
        // Reset array on next frame after the current event has had a chance to bubble to prevent ancestor ripples
        activatedTargets = [];

        if (!activationState.wasElementMadeActive && (e.key === ' ' || e.keyCode === 32)) {
          // If space was pressed, try again within an rAF call to detect :active, because different UAs report
          // active states inconsistently when they're called within event handling code:
          // - https://bugs.chromium.org/p/chromium/issues/detail?id=635971
          // - https://bugzilla.mozilla.org/show_bug.cgi?id=1293741
          // We try first outside rAF to support Edge, which does not exhibit this problem, but will crash if a CSS
          // variable is set within a rAF callback for a submit button interaction (#2241).
          activationState.wasElementMadeActive = _this9.checkElementMadeActive_(e);

          if (activationState.wasElementMadeActive) {
            _this9.animateActivation_();
          }
        }

        if (!activationState.wasElementMadeActive) {
          // Reset activation state immediately if element was not made active.
          _this9.activationState_ = _this9.defaultActivationState_();
        }
      });
    }
    /**
     * @param {?Event} e
     * @private
     */

  }, {
    key: "checkElementMadeActive_",
    value: function checkElementMadeActive_(e) {
      return e && e.type === 'keydown' ? this.adapter_.isSurfaceActive() : true;
    }
    /**
     * @param {?Event=} event Optional event containing position information.
     */

  }, {
    key: "activate",
    value: function activate() {
      var event = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : null;
      this.activate_(event);
    }
    /** @private */

  }, {
    key: "animateActivation_",
    value: function animateActivation_() {
      var _this10 = this;

      var _MDCRippleFoundation$3 = MDCRippleFoundation.strings,
          VAR_FG_TRANSLATE_START = _MDCRippleFoundation$3.VAR_FG_TRANSLATE_START,
          VAR_FG_TRANSLATE_END = _MDCRippleFoundation$3.VAR_FG_TRANSLATE_END;
      var _MDCRippleFoundation$4 = MDCRippleFoundation.cssClasses,
          FG_DEACTIVATION = _MDCRippleFoundation$4.FG_DEACTIVATION,
          FG_ACTIVATION = _MDCRippleFoundation$4.FG_ACTIVATION;
      var DEACTIVATION_TIMEOUT_MS = MDCRippleFoundation.numbers.DEACTIVATION_TIMEOUT_MS;
      this.layoutInternal_();
      var translateStart = '';
      var translateEnd = '';

      if (!this.adapter_.isUnbounded()) {
        var _this$getFgTranslatio = this.getFgTranslationCoordinates_(),
            startPoint = _this$getFgTranslatio.startPoint,
            endPoint = _this$getFgTranslatio.endPoint;

        translateStart = "".concat(startPoint.x, "px, ").concat(startPoint.y, "px");
        translateEnd = "".concat(endPoint.x, "px, ").concat(endPoint.y, "px");
      }

      this.adapter_.updateCssVariable(VAR_FG_TRANSLATE_START, translateStart);
      this.adapter_.updateCssVariable(VAR_FG_TRANSLATE_END, translateEnd); // Cancel any ongoing activation/deactivation animations

      clearTimeout(this.activationTimer_);
      clearTimeout(this.fgDeactivationRemovalTimer_);
      this.rmBoundedActivationClasses_();
      this.adapter_.removeClass(FG_DEACTIVATION); // Force layout in order to re-trigger the animation.

      this.adapter_.computeBoundingRect();
      this.adapter_.addClass(FG_ACTIVATION);
      this.activationTimer_ = setTimeout(function () {
        return _this10.activationTimerCallback_();
      }, DEACTIVATION_TIMEOUT_MS);
    }
    /**
     * @private
     * @return {{startPoint: PointType, endPoint: PointType}}
     */

  }, {
    key: "getFgTranslationCoordinates_",
    value: function getFgTranslationCoordinates_() {
      var _this$activationState = this.activationState_,
          activationEvent = _this$activationState.activationEvent,
          wasActivatedByPointer = _this$activationState.wasActivatedByPointer;
      var startPoint;

      if (wasActivatedByPointer) {
        startPoint = Object(_util__WEBPACK_IMPORTED_MODULE_3__["getNormalizedEventCoords"])(
        /** @type {!Event} */
        activationEvent, this.adapter_.getWindowPageOffset(), this.adapter_.computeBoundingRect());
      } else {
        startPoint = {
          x: this.frame_.width / 2,
          y: this.frame_.height / 2
        };
      } // Center the element around the start point.


      startPoint = {
        x: startPoint.x - this.initialSize_ / 2,
        y: startPoint.y - this.initialSize_ / 2
      };
      var endPoint = {
        x: this.frame_.width / 2 - this.initialSize_ / 2,
        y: this.frame_.height / 2 - this.initialSize_ / 2
      };
      return {
        startPoint: startPoint,
        endPoint: endPoint
      };
    }
    /** @private */

  }, {
    key: "runDeactivationUXLogicIfReady_",
    value: function runDeactivationUXLogicIfReady_() {
      var _this11 = this;

      // This method is called both when a pointing device is released, and when the activation animation ends.
      // The deactivation animation should only run after both of those occur.
      var FG_DEACTIVATION = MDCRippleFoundation.cssClasses.FG_DEACTIVATION;
      var _this$activationState2 = this.activationState_,
          hasDeactivationUXRun = _this$activationState2.hasDeactivationUXRun,
          isActivated = _this$activationState2.isActivated;
      var activationHasEnded = hasDeactivationUXRun || !isActivated;

      if (activationHasEnded && this.activationAnimationHasEnded_) {
        this.rmBoundedActivationClasses_();
        this.adapter_.addClass(FG_DEACTIVATION);
        this.fgDeactivationRemovalTimer_ = setTimeout(function () {
          _this11.adapter_.removeClass(FG_DEACTIVATION);
        }, _constants__WEBPACK_IMPORTED_MODULE_2__["numbers"].FG_DEACTIVATION_MS);
      }
    }
    /** @private */

  }, {
    key: "rmBoundedActivationClasses_",
    value: function rmBoundedActivationClasses_() {
      var FG_ACTIVATION = MDCRippleFoundation.cssClasses.FG_ACTIVATION;
      this.adapter_.removeClass(FG_ACTIVATION);
      this.activationAnimationHasEnded_ = false;
      this.adapter_.computeBoundingRect();
    }
  }, {
    key: "resetActivationState_",
    value: function resetActivationState_() {
      var _this12 = this;

      this.previousActivationEvent_ = this.activationState_.activationEvent;
      this.activationState_ = this.defaultActivationState_(); // Touch devices may fire additional events for the same interaction within a short time.
      // Store the previous event until it's safe to assume that subsequent events are for new interactions.

      setTimeout(function () {
        return _this12.previousActivationEvent_ = null;
      }, MDCRippleFoundation.numbers.TAP_DELAY_MS);
    }
    /**
     * @param {?Event} e
     * @private
     */

  }, {
    key: "deactivate_",
    value: function deactivate_(e) {
      var _this13 = this;

      var activationState = this.activationState_; // This can happen in scenarios such as when you have a keyup event that blurs the element.

      if (!activationState.isActivated) {
        return;
      }

      var state =
      /** @type {!ActivationStateType} */
      Object.assign({}, activationState);

      if (activationState.isProgrammatic) {
        var evtObject = null;
        requestAnimationFrame(function () {
          return _this13.animateDeactivation_(evtObject, state);
        });
        this.resetActivationState_();
      } else {
        this.deregisterDeactivationHandlers_();
        requestAnimationFrame(function () {
          _this13.activationState_.hasDeactivationUXRun = true;

          _this13.animateDeactivation_(e, state);

          _this13.resetActivationState_();
        });
      }
    }
    /**
     * @param {?Event=} event Optional event containing position information.
     */

  }, {
    key: "deactivate",
    value: function deactivate() {
      var event = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : null;
      this.deactivate_(event);
    }
    /**
     * @param {Event} e
     * @param {!ActivationStateType} options
     * @private
     */

  }, {
    key: "animateDeactivation_",
    value: function animateDeactivation_(e, _ref) {
      var wasActivatedByPointer = _ref.wasActivatedByPointer,
          wasElementMadeActive = _ref.wasElementMadeActive;

      if (wasActivatedByPointer || wasElementMadeActive) {
        this.runDeactivationUXLogicIfReady_();
      }
    }
  }, {
    key: "layout",
    value: function layout() {
      var _this14 = this;

      if (this.layoutFrame_) {
        cancelAnimationFrame(this.layoutFrame_);
      }

      this.layoutFrame_ = requestAnimationFrame(function () {
        _this14.layoutInternal_();

        _this14.layoutFrame_ = 0;
      });
    }
    /** @private */

  }, {
    key: "layoutInternal_",
    value: function layoutInternal_() {
      var _this15 = this;

      this.frame_ = this.adapter_.computeBoundingRect();
      var maxDim = Math.max(this.frame_.height, this.frame_.width); // Surface diameter is treated differently for unbounded vs. bounded ripples.
      // Unbounded ripple diameter is calculated smaller since the surface is expected to already be padded appropriately
      // to extend the hitbox, and the ripple is expected to meet the edges of the padded hitbox (which is typically
      // square). Bounded ripples, on the other hand, are fully expected to expand beyond the surface's longest diameter
      // (calculated based on the diagonal plus a constant padding), and are clipped at the surface's border via
      // `overflow: hidden`.

      var getBoundedRadius = function getBoundedRadius() {
        var hypotenuse = Math.sqrt(Math.pow(_this15.frame_.width, 2) + Math.pow(_this15.frame_.height, 2));
        return hypotenuse + MDCRippleFoundation.numbers.PADDING;
      };

      this.maxRadius_ = this.adapter_.isUnbounded() ? maxDim : getBoundedRadius(); // Ripple is sized as a fraction of the largest dimension of the surface, then scales up using a CSS scale transform

      this.initialSize_ = maxDim * MDCRippleFoundation.numbers.INITIAL_ORIGIN_SCALE;
      this.fgScale_ = this.maxRadius_ / this.initialSize_;
      this.updateLayoutCssVars_();
    }
    /** @private */

  }, {
    key: "updateLayoutCssVars_",
    value: function updateLayoutCssVars_() {
      var _MDCRippleFoundation$5 = MDCRippleFoundation.strings,
          VAR_FG_SIZE = _MDCRippleFoundation$5.VAR_FG_SIZE,
          VAR_LEFT = _MDCRippleFoundation$5.VAR_LEFT,
          VAR_TOP = _MDCRippleFoundation$5.VAR_TOP,
          VAR_FG_SCALE = _MDCRippleFoundation$5.VAR_FG_SCALE;
      this.adapter_.updateCssVariable(VAR_FG_SIZE, "".concat(this.initialSize_, "px"));
      this.adapter_.updateCssVariable(VAR_FG_SCALE, this.fgScale_);

      if (this.adapter_.isUnbounded()) {
        this.unboundedCoords_ = {
          left: Math.round(this.frame_.width / 2 - this.initialSize_ / 2),
          top: Math.round(this.frame_.height / 2 - this.initialSize_ / 2)
        };
        this.adapter_.updateCssVariable(VAR_LEFT, "".concat(this.unboundedCoords_.left, "px"));
        this.adapter_.updateCssVariable(VAR_TOP, "".concat(this.unboundedCoords_.top, "px"));
      }
    }
    /** @param {boolean} unbounded */

  }, {
    key: "setUnbounded",
    value: function setUnbounded(unbounded) {
      var UNBOUNDED = MDCRippleFoundation.cssClasses.UNBOUNDED;

      if (unbounded) {
        this.adapter_.addClass(UNBOUNDED);
      } else {
        this.adapter_.removeClass(UNBOUNDED);
      }
    }
  }]);

  return MDCRippleFoundation;
}(_material_base_foundation__WEBPACK_IMPORTED_MODULE_0__["default"]);

/* harmony default export */ __webpack_exports__["default"] = (MDCRippleFoundation);

/***/ }),

/***/ "./node_modules/@material/ripple/index.js":
/*!************************************************!*\
  !*** ./node_modules/@material/ripple/index.js ***!
  \************************************************/
/*! exports provided: MDCRipple, MDCRippleFoundation, RippleCapableSurface, util */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "MDCRipple", function() { return MDCRipple; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "RippleCapableSurface", function() { return RippleCapableSurface; });
/* harmony import */ var _material_base_component__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @material/base/component */ "./node_modules/@material/base/component.js");
/* harmony import */ var _adapter__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./adapter */ "./node_modules/@material/ripple/adapter.js");
/* harmony import */ var _foundation__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./foundation */ "./node_modules/@material/ripple/foundation.js");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "MDCRippleFoundation", function() { return _foundation__WEBPACK_IMPORTED_MODULE_2__["default"]; });

/* harmony import */ var _util__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./util */ "./node_modules/@material/ripple/util.js");
/* harmony reexport (module object) */ __webpack_require__.d(__webpack_exports__, "util", function() { return _util__WEBPACK_IMPORTED_MODULE_3__; });
function _typeof(obj) { if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

function _possibleConstructorReturn(self, call) { if (call && (_typeof(call) === "object" || typeof call === "function")) { return call; } return _assertThisInitialized(self); }

function _assertThisInitialized(self) { if (self === void 0) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return self; }

function _getPrototypeOf(o) { _getPrototypeOf = Object.setPrototypeOf ? Object.getPrototypeOf : function _getPrototypeOf(o) { return o.__proto__ || Object.getPrototypeOf(o); }; return _getPrototypeOf(o); }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function"); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, writable: true, configurable: true } }); if (superClass) _setPrototypeOf(subClass, superClass); }

function _setPrototypeOf(o, p) { _setPrototypeOf = Object.setPrototypeOf || function _setPrototypeOf(o, p) { o.__proto__ = p; return o; }; return _setPrototypeOf(o, p); }

/**
 * @license
 * Copyright 2016 Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */




/**
 * @extends MDCComponent<!MDCRippleFoundation>
 */

var MDCRipple =
/*#__PURE__*/
function (_MDCComponent) {
  _inherits(MDCRipple, _MDCComponent);

  /** @param {...?} args */
  function MDCRipple() {
    var _getPrototypeOf2;

    var _this;

    _classCallCheck(this, MDCRipple);

    for (var _len = arguments.length, args = new Array(_len), _key = 0; _key < _len; _key++) {
      args[_key] = arguments[_key];
    }

    _this = _possibleConstructorReturn(this, (_getPrototypeOf2 = _getPrototypeOf(MDCRipple)).call.apply(_getPrototypeOf2, [this].concat(args)));
    /** @type {boolean} */

    _this.disabled = false;
    /** @private {boolean} */

    _this.unbounded_;
    return _this;
  }
  /**
   * @param {!Element} root
   * @param {{isUnbounded: (boolean|undefined)}=} options
   * @return {!MDCRipple}
   */


  _createClass(MDCRipple, [{
    key: "setUnbounded_",

    /**
     * Closure Compiler throws an access control error when directly accessing a
     * protected or private property inside a getter/setter, like unbounded above.
     * By accessing the protected property inside a method, we solve that problem.
     * That's why this function exists.
     * @private
     */
    value: function setUnbounded_() {
      this.foundation_.setUnbounded(this.unbounded_);
    }
  }, {
    key: "activate",
    value: function activate() {
      this.foundation_.activate();
    }
  }, {
    key: "deactivate",
    value: function deactivate() {
      this.foundation_.deactivate();
    }
  }, {
    key: "layout",
    value: function layout() {
      this.foundation_.layout();
    }
    /** @return {!MDCRippleFoundation} */

  }, {
    key: "getDefaultFoundation",
    value: function getDefaultFoundation() {
      return new _foundation__WEBPACK_IMPORTED_MODULE_2__["default"](MDCRipple.createAdapter(this));
    }
  }, {
    key: "initialSyncWithDOM",
    value: function initialSyncWithDOM() {
      this.unbounded = 'mdcRippleIsUnbounded' in this.root_.dataset;
    }
  }, {
    key: "unbounded",

    /** @return {boolean} */
    get: function get() {
      return this.unbounded_;
    }
    /** @param {boolean} unbounded */
    ,
    set: function set(unbounded) {
      this.unbounded_ = Boolean(unbounded);
      this.setUnbounded_();
    }
  }], [{
    key: "attachTo",
    value: function attachTo(root) {
      var _ref = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {},
          _ref$isUnbounded = _ref.isUnbounded,
          isUnbounded = _ref$isUnbounded === void 0 ? undefined : _ref$isUnbounded;

      var ripple = new MDCRipple(root); // Only override unbounded behavior if option is explicitly specified

      if (isUnbounded !== undefined) {
        ripple.unbounded =
        /** @type {boolean} */
        isUnbounded;
      }

      return ripple;
    }
    /**
     * @param {!RippleCapableSurface} instance
     * @return {!MDCRippleAdapter}
     */

  }, {
    key: "createAdapter",
    value: function createAdapter(instance) {
      var MATCHES = _util__WEBPACK_IMPORTED_MODULE_3__["getMatchesProperty"](HTMLElement.prototype);
      return {
        browserSupportsCssVars: function browserSupportsCssVars() {
          return _util__WEBPACK_IMPORTED_MODULE_3__["supportsCssVariables"](window);
        },
        isUnbounded: function isUnbounded() {
          return instance.unbounded;
        },
        isSurfaceActive: function isSurfaceActive() {
          return instance.root_[MATCHES](':active');
        },
        isSurfaceDisabled: function isSurfaceDisabled() {
          return instance.disabled;
        },
        addClass: function addClass(className) {
          return instance.root_.classList.add(className);
        },
        removeClass: function removeClass(className) {
          return instance.root_.classList.remove(className);
        },
        containsEventTarget: function containsEventTarget(target) {
          return instance.root_.contains(target);
        },
        registerInteractionHandler: function registerInteractionHandler(evtType, handler) {
          return instance.root_.addEventListener(evtType, handler, _util__WEBPACK_IMPORTED_MODULE_3__["applyPassive"]());
        },
        deregisterInteractionHandler: function deregisterInteractionHandler(evtType, handler) {
          return instance.root_.removeEventListener(evtType, handler, _util__WEBPACK_IMPORTED_MODULE_3__["applyPassive"]());
        },
        registerDocumentInteractionHandler: function registerDocumentInteractionHandler(evtType, handler) {
          return document.documentElement.addEventListener(evtType, handler, _util__WEBPACK_IMPORTED_MODULE_3__["applyPassive"]());
        },
        deregisterDocumentInteractionHandler: function deregisterDocumentInteractionHandler(evtType, handler) {
          return document.documentElement.removeEventListener(evtType, handler, _util__WEBPACK_IMPORTED_MODULE_3__["applyPassive"]());
        },
        registerResizeHandler: function registerResizeHandler(handler) {
          return window.addEventListener('resize', handler);
        },
        deregisterResizeHandler: function deregisterResizeHandler(handler) {
          return window.removeEventListener('resize', handler);
        },
        updateCssVariable: function updateCssVariable(varName, value) {
          return instance.root_.style.setProperty(varName, value);
        },
        computeBoundingRect: function computeBoundingRect() {
          return instance.root_.getBoundingClientRect();
        },
        getWindowPageOffset: function getWindowPageOffset() {
          return {
            x: window.pageXOffset,
            y: window.pageYOffset
          };
        }
      };
    }
  }]);

  return MDCRipple;
}(_material_base_component__WEBPACK_IMPORTED_MODULE_0__["default"]);
/**
 * See Material Design spec for more details on when to use ripples.
 * https://material.io/guidelines/motion/choreography.html#choreography-creation
 * @record
 */


var RippleCapableSurface = function RippleCapableSurface() {
  _classCallCheck(this, RippleCapableSurface);
};
/** @protected {!Element} */


RippleCapableSurface.prototype.root_;
/**
 * Whether or not the ripple bleeds out of the bounds of the element.
 * @type {boolean|undefined}
 */

RippleCapableSurface.prototype.unbounded;
/**
 * Whether or not the ripple is attached to a disabled component.
 * @type {boolean|undefined}
 */

RippleCapableSurface.prototype.disabled;


/***/ }),

/***/ "./node_modules/@material/ripple/util.js":
/*!***********************************************!*\
  !*** ./node_modules/@material/ripple/util.js ***!
  \***********************************************/
/*! exports provided: supportsCssVariables, applyPassive, getMatchesProperty, getNormalizedEventCoords */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "supportsCssVariables", function() { return supportsCssVariables; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "applyPassive", function() { return applyPassive; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "getMatchesProperty", function() { return getMatchesProperty; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "getNormalizedEventCoords", function() { return getNormalizedEventCoords; });
/**
 * @license
 * Copyright 2016 Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/**
 * Stores result from supportsCssVariables to avoid redundant processing to detect CSS custom variable support.
 * @private {boolean|undefined}
 */
var supportsCssVariables_;
/**
 * Stores result from applyPassive to avoid redundant processing to detect passive event listener support.
 * @private {boolean|undefined}
 */

var supportsPassive_;
/**
 * @param {!Window} windowObj
 * @return {boolean}
 */

function detectEdgePseudoVarBug(windowObj) {
  // Detect versions of Edge with buggy var() support
  // See: https://developer.microsoft.com/en-us/microsoft-edge/platform/issues/11495448/
  var document = windowObj.document;
  var node = document.createElement('div');
  node.className = 'mdc-ripple-surface--test-edge-var-bug';
  document.body.appendChild(node); // The bug exists if ::before style ends up propagating to the parent element.
  // Additionally, getComputedStyle returns null in iframes with display: "none" in Firefox,
  // but Firefox is known to support CSS custom properties correctly.
  // See: https://bugzilla.mozilla.org/show_bug.cgi?id=548397

  var computedStyle = windowObj.getComputedStyle(node);
  var hasPseudoVarBug = computedStyle !== null && computedStyle.borderTopStyle === 'solid';
  node.remove();
  return hasPseudoVarBug;
}
/**
 * @param {!Window} windowObj
 * @param {boolean=} forceRefresh
 * @return {boolean|undefined}
 */


function supportsCssVariables(windowObj) {
  var forceRefresh = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : false;
  var supportsCssVariables = supportsCssVariables_;

  if (typeof supportsCssVariables_ === 'boolean' && !forceRefresh) {
    return supportsCssVariables;
  }

  var supportsFunctionPresent = windowObj.CSS && typeof windowObj.CSS.supports === 'function';

  if (!supportsFunctionPresent) {
    return;
  }

  var explicitlySupportsCssVars = windowObj.CSS.supports('--css-vars', 'yes'); // See: https://bugs.webkit.org/show_bug.cgi?id=154669
  // See: README section on Safari

  var weAreFeatureDetectingSafari10plus = windowObj.CSS.supports('(--css-vars: yes)') && windowObj.CSS.supports('color', '#00000000');

  if (explicitlySupportsCssVars || weAreFeatureDetectingSafari10plus) {
    supportsCssVariables = !detectEdgePseudoVarBug(windowObj);
  } else {
    supportsCssVariables = false;
  }

  if (!forceRefresh) {
    supportsCssVariables_ = supportsCssVariables;
  }

  return supportsCssVariables;
} //

/**
 * Determine whether the current browser supports passive event listeners, and if so, use them.
 * @param {!Window=} globalObj
 * @param {boolean=} forceRefresh
 * @return {boolean|{passive: boolean}}
 */


function applyPassive() {
  var globalObj = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : window;
  var forceRefresh = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : false;

  if (supportsPassive_ === undefined || forceRefresh) {
    var isSupported = false;

    try {
      globalObj.document.addEventListener('test', null, {
        get passive() {
          isSupported = true;
        }

      });
    } catch (e) {}

    supportsPassive_ = isSupported;
  }

  return supportsPassive_ ? {
    passive: true
  } : false;
}
/**
 * @param {!Object} HTMLElementPrototype
 * @return {!Array<string>}
 */


function getMatchesProperty(HTMLElementPrototype) {
  return ['webkitMatchesSelector', 'msMatchesSelector', 'matches'].filter(function (p) {
    return p in HTMLElementPrototype;
  }).pop();
}
/**
 * @param {!Event} ev
 * @param {{x: number, y: number}} pageOffset
 * @param {!ClientRect} clientRect
 * @return {{x: number, y: number}}
 */


function getNormalizedEventCoords(ev, pageOffset, clientRect) {
  var x = pageOffset.x,
      y = pageOffset.y;
  var documentX = x + clientRect.left;
  var documentY = y + clientRect.top;
  var normalizedX;
  var normalizedY; // Determine touch point relative to the ripple container.

  if (ev.type === 'touchstart') {
    normalizedX = ev.changedTouches[0].pageX - documentX;
    normalizedY = ev.changedTouches[0].pageY - documentY;
  } else {
    normalizedX = ev.pageX - documentX;
    normalizedY = ev.pageY - documentY;
  }

  return {
    x: normalizedX,
    y: normalizedY
  };
}



/***/ }),

/***/ "./node_modules/@material/selection-control/index.js":
/*!***********************************************************!*\
  !*** ./node_modules/@material/selection-control/index.js ***!
  \***********************************************************/
/*! exports provided: MDCSelectionControlState, MDCSelectionControl */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "MDCSelectionControlState", function() { return MDCSelectionControlState; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "MDCSelectionControl", function() { return MDCSelectionControl; });
/* harmony import */ var _material_ripple_index__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @material/ripple/index */ "./node_modules/@material/ripple/index.js");
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

/**
 * @license
 * Copyright 2017 Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/* eslint-disable no-unused-vars */

/* eslint-enable no-unused-vars */

/**
 * @typedef {{
 *   checked: boolean,
 *   indeterminate: boolean,
 *   disabled: boolean,
 *   value: ?string
 * }}
 */

var MDCSelectionControlState;
/**
 * @record
 */

var MDCSelectionControl =
/*#__PURE__*/
function () {
  function MDCSelectionControl() {
    _classCallCheck(this, MDCSelectionControl);
  }

  _createClass(MDCSelectionControl, [{
    key: "ripple",

    /** @return {?MDCRipple} */
    get: function get() {}
  }]);

  return MDCSelectionControl;
}();



/***/ }),

/***/ "./node_modules/@material/textfield/adapter.js":
/*!*****************************************************!*\
  !*** ./node_modules/@material/textfield/adapter.js ***!
  \*****************************************************/
/*! exports provided: MDCTextFieldAdapter, NativeInputType, FoundationMapType */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "MDCTextFieldAdapter", function() { return MDCTextFieldAdapter; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "NativeInputType", function() { return NativeInputType; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "FoundationMapType", function() { return FoundationMapType; });
/* harmony import */ var _helper_text_foundation__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./helper-text/foundation */ "./node_modules/@material/textfield/helper-text/foundation.js");
/* harmony import */ var _icon_foundation__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./icon/foundation */ "./node_modules/@material/textfield/icon/foundation.js");
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

/**
 * @license
 * Copyright 2017 Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/* eslint-disable no-unused-vars */


/* eslint no-unused-vars: [2, {"args": "none"}] */

/**
 * @typedef {{
 *   value: string,
 *   disabled: boolean,
 *   badInput: boolean,
 *   validity: {
 *     badInput: boolean,
 *     valid: boolean,
 *   },
 * }}
 */

var NativeInputType;
/**
 * @typedef {{
 *   helperText: (!MDCTextFieldHelperTextFoundation|undefined),
 *   icon: (!MDCTextFieldIconFoundation|undefined),
 * }}
 */

var FoundationMapType;
/**
 * Adapter for MDC Text Field.
 *
 * Defines the shape of the adapter expected by the foundation. Implement this
 * adapter to integrate the Text Field into your framework. See
 * https://github.com/material-components/material-components-web/blob/master/docs/authoring-components.md
 * for more information.
 *
 * @record
 */

var MDCTextFieldAdapter =
/*#__PURE__*/
function () {
  function MDCTextFieldAdapter() {
    _classCallCheck(this, MDCTextFieldAdapter);
  }

  _createClass(MDCTextFieldAdapter, [{
    key: "addClass",

    /**
     * Adds a class to the root Element.
     * @param {string} className
     */
    value: function addClass(className) {}
    /**
     * Removes a class from the root Element.
     * @param {string} className
     */

  }, {
    key: "removeClass",
    value: function removeClass(className) {}
    /**
     * Returns true if the root element contains the given class name.
     * @param {string} className
     * @return {boolean}
     */

  }, {
    key: "hasClass",
    value: function hasClass(className) {}
    /**
     * Registers an event handler on the root element for a given event.
     * @param {string} type
     * @param {function(!Event): undefined} handler
     */

  }, {
    key: "registerTextFieldInteractionHandler",
    value: function registerTextFieldInteractionHandler(type, handler) {}
    /**
     * Deregisters an event handler on the root element for a given event.
     * @param {string} type
     * @param {function(!Event): undefined} handler
     */

  }, {
    key: "deregisterTextFieldInteractionHandler",
    value: function deregisterTextFieldInteractionHandler(type, handler) {}
    /**
     * Registers an event listener on the native input element for a given event.
     * @param {string} evtType
     * @param {function(!Event): undefined} handler
     */

  }, {
    key: "registerInputInteractionHandler",
    value: function registerInputInteractionHandler(evtType, handler) {}
    /**
     * Deregisters an event listener on the native input element for a given event.
     * @param {string} evtType
     * @param {function(!Event): undefined} handler
     */

  }, {
    key: "deregisterInputInteractionHandler",
    value: function deregisterInputInteractionHandler(evtType, handler) {}
    /**
     * Registers a validation attribute change listener on the input element.
     * Handler accepts list of attribute names.
     * @param {function(!Array<string>): undefined} handler
     * @return {!MutationObserver}
     */

  }, {
    key: "registerValidationAttributeChangeHandler",
    value: function registerValidationAttributeChangeHandler(handler) {}
    /**
     * Disconnects a validation attribute observer on the input element.
     * @param {!MutationObserver} observer
     */

  }, {
    key: "deregisterValidationAttributeChangeHandler",
    value: function deregisterValidationAttributeChangeHandler(observer) {}
    /**
     * Returns an object representing the native text input element, with a
     * similar API shape. The object returned should include the value, disabled
     * and badInput properties, as well as the checkValidity() function. We never
     * alter the value within our code, however we do update the disabled
     * property, so if you choose to duck-type the return value for this method
     * in your implementation it's important to keep this in mind. Also note that
     * this method can return null, which the foundation will handle gracefully.
     * @return {?Element|?NativeInputType}
     */

  }, {
    key: "getNativeInput",
    value: function getNativeInput() {}
    /**
     * Returns true if the textfield is focused.
     * We achieve this via `document.activeElement === this.root_`.
     * @return {boolean}
     */

  }, {
    key: "isFocused",
    value: function isFocused() {}
    /**
     * Returns true if the direction of the root element is set to RTL.
     * @return {boolean}
     */

  }, {
    key: "isRtl",
    value: function isRtl() {}
    /**
     * Activates the line ripple.
     */

  }, {
    key: "activateLineRipple",
    value: function activateLineRipple() {}
    /**
     * Deactivates the line ripple.
     */

  }, {
    key: "deactivateLineRipple",
    value: function deactivateLineRipple() {}
    /**
     * Sets the transform origin of the line ripple.
     * @param {number} normalizedX
     */

  }, {
    key: "setLineRippleTransformOrigin",
    value: function setLineRippleTransformOrigin(normalizedX) {}
    /**
     * Only implement if label exists.
     * Shakes label if shouldShake is true.
     * @param {boolean} shouldShake
     */

  }, {
    key: "shakeLabel",
    value: function shakeLabel(shouldShake) {}
    /**
     * Only implement if label exists.
     * Floats the label above the input element if shouldFloat is true.
     * @param {boolean} shouldFloat
     */

  }, {
    key: "floatLabel",
    value: function floatLabel(shouldFloat) {}
    /**
     * Returns true if label element exists, false if it doesn't.
     * @return {boolean}
     */

  }, {
    key: "hasLabel",
    value: function hasLabel() {}
    /**
     * Only implement if label exists.
     * Returns width of label in pixels.
     * @return {number}
     */

  }, {
    key: "getLabelWidth",
    value: function getLabelWidth() {}
    /**
     * Returns true if outline element exists, false if it doesn't.
     * @return {boolean}
     */

  }, {
    key: "hasOutline",
    value: function hasOutline() {}
    /**
     * Only implement if outline element exists.
     * Updates SVG Path and outline element based on the
     * label element width and RTL context.
     * @param {number} labelWidth
     * @param {boolean=} isRtl
     */

  }, {
    key: "notchOutline",
    value: function notchOutline(labelWidth, isRtl) {}
    /**
     * Only implement if outline element exists.
     * Closes notch in outline element.
     */

  }, {
    key: "closeOutline",
    value: function closeOutline() {}
  }]);

  return MDCTextFieldAdapter;
}();



/***/ }),

/***/ "./node_modules/@material/textfield/constants.js":
/*!*******************************************************!*\
  !*** ./node_modules/@material/textfield/constants.js ***!
  \*******************************************************/
/*! exports provided: cssClasses, strings, numbers, VALIDATION_ATTR_WHITELIST */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "cssClasses", function() { return cssClasses; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "strings", function() { return strings; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "numbers", function() { return numbers; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "VALIDATION_ATTR_WHITELIST", function() { return VALIDATION_ATTR_WHITELIST; });
/**
 * @license
 * Copyright 2016 Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/** @enum {string} */
var strings = {
  ARIA_CONTROLS: 'aria-controls',
  INPUT_SELECTOR: '.mdc-text-field__input',
  LABEL_SELECTOR: '.mdc-floating-label',
  ICON_SELECTOR: '.mdc-text-field__icon',
  OUTLINE_SELECTOR: '.mdc-notched-outline',
  LINE_RIPPLE_SELECTOR: '.mdc-line-ripple'
};
/** @enum {string} */

var cssClasses = {
  ROOT: 'mdc-text-field',
  UPGRADED: 'mdc-text-field--upgraded',
  DISABLED: 'mdc-text-field--disabled',
  DENSE: 'mdc-text-field--dense',
  FOCUSED: 'mdc-text-field--focused',
  INVALID: 'mdc-text-field--invalid',
  BOX: 'mdc-text-field--box',
  OUTLINED: 'mdc-text-field--outlined'
};
/** @enum {number} */

var numbers = {
  LABEL_SCALE: 0.75,
  DENSE_LABEL_SCALE: 0.923
}; // whitelist based off of https://developer.mozilla.org/en-US/docs/Web/Guide/HTML/HTML5/Constraint_validation
// under section: `Validation-related attributes`

var VALIDATION_ATTR_WHITELIST = ['pattern', 'min', 'max', 'required', 'step', 'minlength', 'maxlength'];


/***/ }),

/***/ "./node_modules/@material/textfield/foundation.js":
/*!********************************************************!*\
  !*** ./node_modules/@material/textfield/foundation.js ***!
  \********************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _material_base_foundation__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @material/base/foundation */ "./node_modules/@material/base/foundation.js");
/* harmony import */ var _helper_text_foundation__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./helper-text/foundation */ "./node_modules/@material/textfield/helper-text/foundation.js");
/* harmony import */ var _icon_foundation__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./icon/foundation */ "./node_modules/@material/textfield/icon/foundation.js");
/* harmony import */ var _adapter__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./adapter */ "./node_modules/@material/textfield/adapter.js");
/* harmony import */ var _constants__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./constants */ "./node_modules/@material/textfield/constants.js");
function _typeof(obj) { if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (call && (_typeof(call) === "object" || typeof call === "function")) { return call; } return _assertThisInitialized(self); }

function _assertThisInitialized(self) { if (self === void 0) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return self; }

function _getPrototypeOf(o) { _getPrototypeOf = Object.setPrototypeOf ? Object.getPrototypeOf : function _getPrototypeOf(o) { return o.__proto__ || Object.getPrototypeOf(o); }; return _getPrototypeOf(o); }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function"); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, writable: true, configurable: true } }); if (superClass) _setPrototypeOf(subClass, superClass); }

function _setPrototypeOf(o, p) { _setPrototypeOf = Object.setPrototypeOf || function _setPrototypeOf(o, p) { o.__proto__ = p; return o; }; return _setPrototypeOf(o, p); }

/**
 * @license
 * Copyright 2016 Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/* eslint-disable no-unused-vars */



/* eslint-enable no-unused-vars */



/**
 * @extends {MDCFoundation<!MDCTextFieldAdapter>}
 * @final
 */

var MDCTextFieldFoundation =
/*#__PURE__*/
function (_MDCFoundation) {
  _inherits(MDCTextFieldFoundation, _MDCFoundation);

  _createClass(MDCTextFieldFoundation, [{
    key: "shouldShake",

    /** @return {boolean} */
    get: function get() {
      return !this.isValid() && !this.isFocused_;
    }
    /** @return {boolean} */

  }, {
    key: "shouldFloat",
    get: function get() {
      return this.isFocused_ || !!this.getValue() || this.isBadInput_();
    }
    /**
     * {@see MDCTextFieldAdapter} for typing information on parameters and return
     * types.
     * @return {!MDCTextFieldAdapter}
     */

  }], [{
    key: "cssClasses",

    /** @return enum {string} */
    get: function get() {
      return _constants__WEBPACK_IMPORTED_MODULE_4__["cssClasses"];
    }
    /** @return enum {string} */

  }, {
    key: "strings",
    get: function get() {
      return _constants__WEBPACK_IMPORTED_MODULE_4__["strings"];
    }
    /** @return enum {string} */

  }, {
    key: "numbers",
    get: function get() {
      return _constants__WEBPACK_IMPORTED_MODULE_4__["numbers"];
    }
  }, {
    key: "defaultAdapter",
    get: function get() {
      return (
        /** @type {!MDCTextFieldAdapter} */
        {
          addClass: function addClass() {},
          removeClass: function removeClass() {},
          hasClass: function hasClass() {},
          registerTextFieldInteractionHandler: function registerTextFieldInteractionHandler() {},
          deregisterTextFieldInteractionHandler: function deregisterTextFieldInteractionHandler() {},
          registerInputInteractionHandler: function registerInputInteractionHandler() {},
          deregisterInputInteractionHandler: function deregisterInputInteractionHandler() {},
          registerValidationAttributeChangeHandler: function registerValidationAttributeChangeHandler() {},
          deregisterValidationAttributeChangeHandler: function deregisterValidationAttributeChangeHandler() {},
          getNativeInput: function getNativeInput() {},
          isFocused: function isFocused() {},
          isRtl: function isRtl() {},
          activateLineRipple: function activateLineRipple() {},
          deactivateLineRipple: function deactivateLineRipple() {},
          setLineRippleTransformOrigin: function setLineRippleTransformOrigin() {},
          shakeLabel: function shakeLabel() {},
          floatLabel: function floatLabel() {},
          hasLabel: function hasLabel() {},
          getLabelWidth: function getLabelWidth() {},
          hasOutline: function hasOutline() {},
          notchOutline: function notchOutline() {},
          closeOutline: function closeOutline() {}
        }
      );
    }
    /**
     * @param {!MDCTextFieldAdapter} adapter
     * @param {!FoundationMapType=} foundationMap Map from subcomponent names to their subfoundations.
     */

  }]);

  function MDCTextFieldFoundation(adapter) {
    var _this;

    var foundationMap = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] :
    /** @type {!FoundationMapType} */
    {};

    _classCallCheck(this, MDCTextFieldFoundation);

    _this = _possibleConstructorReturn(this, _getPrototypeOf(MDCTextFieldFoundation).call(this, Object.assign(MDCTextFieldFoundation.defaultAdapter, adapter)));
    /** @type {!MDCTextFieldHelperTextFoundation|undefined} */

    _this.helperText_ = foundationMap.helperText;
    /** @type {!MDCTextFieldIconFoundation|undefined} */

    _this.icon_ = foundationMap.icon;
    /** @private {boolean} */

    _this.isFocused_ = false;
    /** @private {boolean} */

    _this.receivedUserInput_ = false;
    /** @private {boolean} */

    _this.useCustomValidityChecking_ = false;
    /** @private {boolean} */

    _this.isValid_ = true;
    /** @private {function(): undefined} */

    _this.inputFocusHandler_ = function () {
      return _this.activateFocus();
    };
    /** @private {function(): undefined} */


    _this.inputBlurHandler_ = function () {
      return _this.deactivateFocus();
    };
    /** @private {function(): undefined} */


    _this.inputInputHandler_ = function () {
      return _this.autoCompleteFocus();
    };
    /** @private {function(!Event): undefined} */


    _this.setPointerXOffset_ = function (evt) {
      return _this.setTransformOrigin(evt);
    };
    /** @private {function(!Event): undefined} */


    _this.textFieldInteractionHandler_ = function () {
      return _this.handleTextFieldInteraction();
    };
    /** @private {function(!Array): undefined} */


    _this.validationAttributeChangeHandler_ = function (attributesList) {
      return _this.handleValidationAttributeChange(attributesList);
    };
    /** @private {!MutationObserver} */


    _this.validationObserver_;
    return _this;
  }

  _createClass(MDCTextFieldFoundation, [{
    key: "init",
    value: function init() {
      var _this2 = this;

      this.adapter_.addClass(MDCTextFieldFoundation.cssClasses.UPGRADED); // Ensure label does not collide with any pre-filled value.

      if (this.adapter_.hasLabel() && (this.getValue() || this.isBadInput_())) {
        this.adapter_.floatLabel(this.shouldFloat);
        this.notchOutline(this.shouldFloat);
      }

      if (this.adapter_.isFocused()) {
        this.inputFocusHandler_();
      }

      this.adapter_.registerInputInteractionHandler('focus', this.inputFocusHandler_);
      this.adapter_.registerInputInteractionHandler('blur', this.inputBlurHandler_);
      this.adapter_.registerInputInteractionHandler('input', this.inputInputHandler_);
      ['mousedown', 'touchstart'].forEach(function (evtType) {
        _this2.adapter_.registerInputInteractionHandler(evtType, _this2.setPointerXOffset_);
      });
      ['click', 'keydown'].forEach(function (evtType) {
        _this2.adapter_.registerTextFieldInteractionHandler(evtType, _this2.textFieldInteractionHandler_);
      });
      this.validationObserver_ = this.adapter_.registerValidationAttributeChangeHandler(this.validationAttributeChangeHandler_);
    }
  }, {
    key: "destroy",
    value: function destroy() {
      var _this3 = this;

      this.adapter_.removeClass(MDCTextFieldFoundation.cssClasses.UPGRADED);
      this.adapter_.deregisterInputInteractionHandler('focus', this.inputFocusHandler_);
      this.adapter_.deregisterInputInteractionHandler('blur', this.inputBlurHandler_);
      this.adapter_.deregisterInputInteractionHandler('input', this.inputInputHandler_);
      ['mousedown', 'touchstart'].forEach(function (evtType) {
        _this3.adapter_.deregisterInputInteractionHandler(evtType, _this3.setPointerXOffset_);
      });
      ['click', 'keydown'].forEach(function (evtType) {
        _this3.adapter_.deregisterTextFieldInteractionHandler(evtType, _this3.textFieldInteractionHandler_);
      });
      this.adapter_.deregisterValidationAttributeChangeHandler(this.validationObserver_);
    }
    /**
     * Handles user interactions with the Text Field.
     */

  }, {
    key: "handleTextFieldInteraction",
    value: function handleTextFieldInteraction() {
      if (this.adapter_.getNativeInput().disabled) {
        return;
      }

      this.receivedUserInput_ = true;
    }
    /**
     * Handles validation attribute changes
     * @param {!Array<string>} attributesList
     */

  }, {
    key: "handleValidationAttributeChange",
    value: function handleValidationAttributeChange(attributesList) {
      var _this4 = this;

      attributesList.some(function (attributeName) {
        if (_constants__WEBPACK_IMPORTED_MODULE_4__["VALIDATION_ATTR_WHITELIST"].indexOf(attributeName) > -1) {
          _this4.styleValidity_(true);

          return true;
        }
      });
    }
    /**
     * Opens/closes the notched outline.
     * @param {boolean} openNotch
     */

  }, {
    key: "notchOutline",
    value: function notchOutline(openNotch) {
      if (!this.adapter_.hasOutline() || !this.adapter_.hasLabel()) {
        return;
      }

      if (openNotch) {
        var isDense = this.adapter_.hasClass(_constants__WEBPACK_IMPORTED_MODULE_4__["cssClasses"].DENSE);
        var labelScale = isDense ? _constants__WEBPACK_IMPORTED_MODULE_4__["numbers"].DENSE_LABEL_SCALE : _constants__WEBPACK_IMPORTED_MODULE_4__["numbers"].LABEL_SCALE;
        var labelWidth = this.adapter_.getLabelWidth() * labelScale;
        var isRtl = this.adapter_.isRtl();
        this.adapter_.notchOutline(labelWidth, isRtl);
      } else {
        this.adapter_.closeOutline();
      }
    }
    /**
     * Activates the text field focus state.
     */

  }, {
    key: "activateFocus",
    value: function activateFocus() {
      this.isFocused_ = true;
      this.styleFocused_(this.isFocused_);
      this.adapter_.activateLineRipple();
      this.notchOutline(this.shouldFloat);

      if (this.adapter_.hasLabel()) {
        this.adapter_.shakeLabel(this.shouldShake);
        this.adapter_.floatLabel(this.shouldFloat);
      }

      if (this.helperText_) {
        this.helperText_.showToScreenReader();
      }
    }
    /**
     * Sets the line ripple's transform origin, so that the line ripple activate
     * animation will animate out from the user's click location.
     * @param {!Event} evt
     */

  }, {
    key: "setTransformOrigin",
    value: function setTransformOrigin(evt) {
      var targetClientRect = evt.target.getBoundingClientRect();
      var evtCoords = {
        x: evt.clientX,
        y: evt.clientY
      };
      var normalizedX = evtCoords.x - targetClientRect.left;
      this.adapter_.setLineRippleTransformOrigin(normalizedX);
    }
    /**
     * Activates the Text Field's focus state in cases when the input value
     * changes without user input (e.g. programatically).
     */

  }, {
    key: "autoCompleteFocus",
    value: function autoCompleteFocus() {
      if (!this.receivedUserInput_) {
        this.activateFocus();
      }
    }
    /**
     * Deactivates the Text Field's focus state.
     */

  }, {
    key: "deactivateFocus",
    value: function deactivateFocus() {
      this.isFocused_ = false;
      this.adapter_.deactivateLineRipple();
      var input = this.getNativeInput_();
      var shouldRemoveLabelFloat = !input.value && !this.isBadInput_();
      var isValid = this.isValid();
      this.styleValidity_(isValid);
      this.styleFocused_(this.isFocused_);

      if (this.adapter_.hasLabel()) {
        this.adapter_.shakeLabel(this.shouldShake);
        this.adapter_.floatLabel(this.shouldFloat);
        this.notchOutline(this.shouldFloat);
      }

      if (shouldRemoveLabelFloat) {
        this.receivedUserInput_ = false;
      }
    }
    /**
     * @return {string} The value of the input Element.
     */

  }, {
    key: "getValue",
    value: function getValue() {
      return this.getNativeInput_().value;
    }
    /**
     * @param {string} value The value to set on the input Element.
     */

  }, {
    key: "setValue",
    value: function setValue(value) {
      this.getNativeInput_().value = value;
      var isValid = this.isValid();
      this.styleValidity_(isValid);

      if (this.adapter_.hasLabel()) {
        this.adapter_.shakeLabel(this.shouldShake);
        this.adapter_.floatLabel(this.shouldFloat);
        this.notchOutline(this.shouldFloat);
      }
    }
    /**
     * @return {boolean} If a custom validity is set, returns that value.
     *     Otherwise, returns the result of native validity checks.
     */

  }, {
    key: "isValid",
    value: function isValid() {
      return this.useCustomValidityChecking_ ? this.isValid_ : this.isNativeInputValid_();
    }
    /**
     * @param {boolean} isValid Sets the validity state of the Text Field.
     */

  }, {
    key: "setValid",
    value: function setValid(isValid) {
      this.useCustomValidityChecking_ = true;
      this.isValid_ = isValid; // Retrieve from the getter to ensure correct logic is applied.

      isValid = this.isValid();
      this.styleValidity_(isValid);

      if (this.adapter_.hasLabel()) {
        this.adapter_.shakeLabel(this.shouldShake);
      }
    }
    /**
     * @return {boolean} True if the Text Field is disabled.
     */

  }, {
    key: "isDisabled",
    value: function isDisabled() {
      return this.getNativeInput_().disabled;
    }
    /**
     * @param {boolean} disabled Sets the text-field disabled or enabled.
     */

  }, {
    key: "setDisabled",
    value: function setDisabled(disabled) {
      this.getNativeInput_().disabled = disabled;
      this.styleDisabled_(disabled);
    }
    /**
     * @param {string} content Sets the content of the helper text.
     */

  }, {
    key: "setHelperTextContent",
    value: function setHelperTextContent(content) {
      if (this.helperText_) {
        this.helperText_.setContent(content);
      }
    }
    /**
     * Sets the aria label of the icon.
     * @param {string} label
     */

  }, {
    key: "setIconAriaLabel",
    value: function setIconAriaLabel(label) {
      if (this.icon_) {
        this.icon_.setAriaLabel(label);
      }
    }
    /**
     * Sets the text content of the icon.
     * @param {string} content
     */

  }, {
    key: "setIconContent",
    value: function setIconContent(content) {
      if (this.icon_) {
        this.icon_.setContent(content);
      }
    }
    /**
     * @return {boolean} True if the Text Field input fails in converting the
     *     user-supplied value.
     * @private
     */

  }, {
    key: "isBadInput_",
    value: function isBadInput_() {
      return this.getNativeInput_().validity.badInput;
    }
    /**
     * @return {boolean} The result of native validity checking
     *     (ValidityState.valid).
     */

  }, {
    key: "isNativeInputValid_",
    value: function isNativeInputValid_() {
      return this.getNativeInput_().validity.valid;
    }
    /**
     * Styles the component based on the validity state.
     * @param {boolean} isValid
     * @private
     */

  }, {
    key: "styleValidity_",
    value: function styleValidity_(isValid) {
      var INVALID = MDCTextFieldFoundation.cssClasses.INVALID;

      if (isValid) {
        this.adapter_.removeClass(INVALID);
      } else {
        this.adapter_.addClass(INVALID);
      }

      if (this.helperText_) {
        this.helperText_.setValidity(isValid);
      }
    }
    /**
     * Styles the component based on the focused state.
     * @param {boolean} isFocused
     * @private
     */

  }, {
    key: "styleFocused_",
    value: function styleFocused_(isFocused) {
      var FOCUSED = MDCTextFieldFoundation.cssClasses.FOCUSED;

      if (isFocused) {
        this.adapter_.addClass(FOCUSED);
      } else {
        this.adapter_.removeClass(FOCUSED);
      }
    }
    /**
     * Styles the component based on the disabled state.
     * @param {boolean} isDisabled
     * @private
     */

  }, {
    key: "styleDisabled_",
    value: function styleDisabled_(isDisabled) {
      var _MDCTextFieldFoundati = MDCTextFieldFoundation.cssClasses,
          DISABLED = _MDCTextFieldFoundati.DISABLED,
          INVALID = _MDCTextFieldFoundati.INVALID;

      if (isDisabled) {
        this.adapter_.addClass(DISABLED);
        this.adapter_.removeClass(INVALID);
      } else {
        this.adapter_.removeClass(DISABLED);
      }

      if (this.icon_) {
        this.icon_.setDisabled(isDisabled);
      }
    }
    /**
     * @return {!Element|!NativeInputType} The native text input from the
     * host environment, or a dummy if none exists.
     * @private
     */

  }, {
    key: "getNativeInput_",
    value: function getNativeInput_() {
      return this.adapter_.getNativeInput() ||
      /** @type {!NativeInputType} */
      {
        value: '',
        disabled: false,
        validity: {
          badInput: false,
          valid: true
        }
      };
    }
  }]);

  return MDCTextFieldFoundation;
}(_material_base_foundation__WEBPACK_IMPORTED_MODULE_0__["default"]);

/* harmony default export */ __webpack_exports__["default"] = (MDCTextFieldFoundation);

/***/ }),

/***/ "./node_modules/@material/textfield/helper-text/adapter.js":
/*!*****************************************************************!*\
  !*** ./node_modules/@material/textfield/helper-text/adapter.js ***!
  \*****************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

/**
 * @license
 * Copyright 2017 Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/* eslint no-unused-vars: [2, {"args": "none"}] */

/**
 * Adapter for MDC Text Field Helper Text.
 *
 * Defines the shape of the adapter expected by the foundation. Implement this
 * adapter to integrate the TextField helper text into your framework. See
 * https://github.com/material-components/material-components-web/blob/master/docs/authoring-components.md
 * for more information.
 *
 * @record
 */
var MDCTextFieldHelperTextAdapter =
/*#__PURE__*/
function () {
  function MDCTextFieldHelperTextAdapter() {
    _classCallCheck(this, MDCTextFieldHelperTextAdapter);
  }

  _createClass(MDCTextFieldHelperTextAdapter, [{
    key: "addClass",

    /**
     * Adds a class to the helper text element.
     * @param {string} className
     */
    value: function addClass(className) {}
    /**
     * Removes a class from the helper text element.
     * @param {string} className
     */

  }, {
    key: "removeClass",
    value: function removeClass(className) {}
    /**
     * Returns whether or not the helper text element contains the given class.
     * @param {string} className
     * @return {boolean}
     */

  }, {
    key: "hasClass",
    value: function hasClass(className) {}
    /**
     * Sets an attribute with a given value on the helper text element.
     * @param {string} attr
     * @param {string} value
     */

  }, {
    key: "setAttr",
    value: function setAttr(attr, value) {}
    /**
     * Removes an attribute from the helper text element.
     * @param {string} attr
     */

  }, {
    key: "removeAttr",
    value: function removeAttr(attr) {}
    /**
     * Sets the text content for the helper text element.
     * @param {string} content
     */

  }, {
    key: "setContent",
    value: function setContent(content) {}
  }]);

  return MDCTextFieldHelperTextAdapter;
}();

/* harmony default export */ __webpack_exports__["default"] = (MDCTextFieldHelperTextAdapter);

/***/ }),

/***/ "./node_modules/@material/textfield/helper-text/constants.js":
/*!*******************************************************************!*\
  !*** ./node_modules/@material/textfield/helper-text/constants.js ***!
  \*******************************************************************/
/*! exports provided: strings, cssClasses */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "strings", function() { return strings; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "cssClasses", function() { return cssClasses; });
/**
 * @license
 * Copyright 2016 Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/** @enum {string} */
var strings = {
  ARIA_HIDDEN: 'aria-hidden',
  ROLE: 'role'
};
/** @enum {string} */

var cssClasses = {
  HELPER_TEXT_PERSISTENT: 'mdc-text-field-helper-text--persistent',
  HELPER_TEXT_VALIDATION_MSG: 'mdc-text-field-helper-text--validation-msg'
};


/***/ }),

/***/ "./node_modules/@material/textfield/helper-text/foundation.js":
/*!********************************************************************!*\
  !*** ./node_modules/@material/textfield/helper-text/foundation.js ***!
  \********************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _material_base_foundation__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @material/base/foundation */ "./node_modules/@material/base/foundation.js");
/* harmony import */ var _adapter__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./adapter */ "./node_modules/@material/textfield/helper-text/adapter.js");
/* harmony import */ var _constants__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./constants */ "./node_modules/@material/textfield/helper-text/constants.js");
function _typeof(obj) { if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (call && (_typeof(call) === "object" || typeof call === "function")) { return call; } return _assertThisInitialized(self); }

function _assertThisInitialized(self) { if (self === void 0) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return self; }

function _getPrototypeOf(o) { _getPrototypeOf = Object.setPrototypeOf ? Object.getPrototypeOf : function _getPrototypeOf(o) { return o.__proto__ || Object.getPrototypeOf(o); }; return _getPrototypeOf(o); }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function"); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, writable: true, configurable: true } }); if (superClass) _setPrototypeOf(subClass, superClass); }

function _setPrototypeOf(o, p) { _setPrototypeOf = Object.setPrototypeOf || function _setPrototypeOf(o, p) { o.__proto__ = p; return o; }; return _setPrototypeOf(o, p); }

/**
 * @license
 * Copyright 2017 Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */



/**
 * @extends {MDCFoundation<!MDCTextFieldHelperTextAdapter>}
 * @final
 */

var MDCTextFieldHelperTextFoundation =
/*#__PURE__*/
function (_MDCFoundation) {
  _inherits(MDCTextFieldHelperTextFoundation, _MDCFoundation);

  _createClass(MDCTextFieldHelperTextFoundation, null, [{
    key: "cssClasses",

    /** @return enum {string} */
    get: function get() {
      return _constants__WEBPACK_IMPORTED_MODULE_2__["cssClasses"];
    }
    /** @return enum {string} */

  }, {
    key: "strings",
    get: function get() {
      return _constants__WEBPACK_IMPORTED_MODULE_2__["strings"];
    }
    /**
     * {@see MDCTextFieldHelperTextAdapter} for typing information on parameters and return
     * types.
     * @return {!MDCTextFieldHelperTextAdapter}
     */

  }, {
    key: "defaultAdapter",
    get: function get() {
      return (
        /** @type {!MDCTextFieldHelperTextAdapter} */
        {
          addClass: function addClass() {},
          removeClass: function removeClass() {},
          hasClass: function hasClass() {},
          setAttr: function setAttr() {},
          removeAttr: function removeAttr() {},
          setContent: function setContent() {}
        }
      );
    }
    /**
     * @param {!MDCTextFieldHelperTextAdapter} adapter
     */

  }]);

  function MDCTextFieldHelperTextFoundation(adapter) {
    _classCallCheck(this, MDCTextFieldHelperTextFoundation);

    return _possibleConstructorReturn(this, _getPrototypeOf(MDCTextFieldHelperTextFoundation).call(this, Object.assign(MDCTextFieldHelperTextFoundation.defaultAdapter, adapter)));
  }
  /**
   * Sets the content of the helper text field.
   * @param {string} content
   */


  _createClass(MDCTextFieldHelperTextFoundation, [{
    key: "setContent",
    value: function setContent(content) {
      this.adapter_.setContent(content);
    }
    /** @param {boolean} isPersistent Sets the persistency of the helper text. */

  }, {
    key: "setPersistent",
    value: function setPersistent(isPersistent) {
      if (isPersistent) {
        this.adapter_.addClass(_constants__WEBPACK_IMPORTED_MODULE_2__["cssClasses"].HELPER_TEXT_PERSISTENT);
      } else {
        this.adapter_.removeClass(_constants__WEBPACK_IMPORTED_MODULE_2__["cssClasses"].HELPER_TEXT_PERSISTENT);
      }
    }
    /**
     * @param {boolean} isValidation True to make the helper text act as an
     *   error validation message.
     */

  }, {
    key: "setValidation",
    value: function setValidation(isValidation) {
      if (isValidation) {
        this.adapter_.addClass(_constants__WEBPACK_IMPORTED_MODULE_2__["cssClasses"].HELPER_TEXT_VALIDATION_MSG);
      } else {
        this.adapter_.removeClass(_constants__WEBPACK_IMPORTED_MODULE_2__["cssClasses"].HELPER_TEXT_VALIDATION_MSG);
      }
    }
    /** Makes the helper text visible to the screen reader. */

  }, {
    key: "showToScreenReader",
    value: function showToScreenReader() {
      this.adapter_.removeAttr(_constants__WEBPACK_IMPORTED_MODULE_2__["strings"].ARIA_HIDDEN);
    }
    /**
     * Sets the validity of the helper text based on the input validity.
     * @param {boolean} inputIsValid
     */

  }, {
    key: "setValidity",
    value: function setValidity(inputIsValid) {
      var helperTextIsPersistent = this.adapter_.hasClass(_constants__WEBPACK_IMPORTED_MODULE_2__["cssClasses"].HELPER_TEXT_PERSISTENT);
      var helperTextIsValidationMsg = this.adapter_.hasClass(_constants__WEBPACK_IMPORTED_MODULE_2__["cssClasses"].HELPER_TEXT_VALIDATION_MSG);
      var validationMsgNeedsDisplay = helperTextIsValidationMsg && !inputIsValid;

      if (validationMsgNeedsDisplay) {
        this.adapter_.setAttr(_constants__WEBPACK_IMPORTED_MODULE_2__["strings"].ROLE, 'alert');
      } else {
        this.adapter_.removeAttr(_constants__WEBPACK_IMPORTED_MODULE_2__["strings"].ROLE);
      }

      if (!helperTextIsPersistent && !validationMsgNeedsDisplay) {
        this.hide_();
      }
    }
    /**
     * Hides the help text from screen readers.
     * @private
     */

  }, {
    key: "hide_",
    value: function hide_() {
      this.adapter_.setAttr(_constants__WEBPACK_IMPORTED_MODULE_2__["strings"].ARIA_HIDDEN, 'true');
    }
  }]);

  return MDCTextFieldHelperTextFoundation;
}(_material_base_foundation__WEBPACK_IMPORTED_MODULE_0__["default"]);

/* harmony default export */ __webpack_exports__["default"] = (MDCTextFieldHelperTextFoundation);

/***/ }),

/***/ "./node_modules/@material/textfield/helper-text/index.js":
/*!***************************************************************!*\
  !*** ./node_modules/@material/textfield/helper-text/index.js ***!
  \***************************************************************/
/*! exports provided: MDCTextFieldHelperText, MDCTextFieldHelperTextFoundation */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "MDCTextFieldHelperText", function() { return MDCTextFieldHelperText; });
/* harmony import */ var _material_base_component__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @material/base/component */ "./node_modules/@material/base/component.js");
/* harmony import */ var _adapter__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./adapter */ "./node_modules/@material/textfield/helper-text/adapter.js");
/* harmony import */ var _foundation__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./foundation */ "./node_modules/@material/textfield/helper-text/foundation.js");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "MDCTextFieldHelperTextFoundation", function() { return _foundation__WEBPACK_IMPORTED_MODULE_2__["default"]; });

function _typeof(obj) { if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

function _possibleConstructorReturn(self, call) { if (call && (_typeof(call) === "object" || typeof call === "function")) { return call; } return _assertThisInitialized(self); }

function _assertThisInitialized(self) { if (self === void 0) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return self; }

function _getPrototypeOf(o) { _getPrototypeOf = Object.setPrototypeOf ? Object.getPrototypeOf : function _getPrototypeOf(o) { return o.__proto__ || Object.getPrototypeOf(o); }; return _getPrototypeOf(o); }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function"); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, writable: true, configurable: true } }); if (superClass) _setPrototypeOf(subClass, superClass); }

function _setPrototypeOf(o, p) { _setPrototypeOf = Object.setPrototypeOf || function _setPrototypeOf(o, p) { o.__proto__ = p; return o; }; return _setPrototypeOf(o, p); }

/**
 * @license
 * Copyright 2017 Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */



/**
 * @extends {MDCComponent<!MDCTextFieldHelperTextFoundation>}
 * @final
 */

var MDCTextFieldHelperText =
/*#__PURE__*/
function (_MDCComponent) {
  _inherits(MDCTextFieldHelperText, _MDCComponent);

  function MDCTextFieldHelperText() {
    _classCallCheck(this, MDCTextFieldHelperText);

    return _possibleConstructorReturn(this, _getPrototypeOf(MDCTextFieldHelperText).apply(this, arguments));
  }

  _createClass(MDCTextFieldHelperText, [{
    key: "getDefaultFoundation",

    /**
     * @return {!MDCTextFieldHelperTextFoundation}
     */
    value: function getDefaultFoundation() {
      var _this = this;

      return new _foundation__WEBPACK_IMPORTED_MODULE_2__["default"](
      /** @type {!MDCTextFieldHelperTextAdapter} */
      Object.assign({
        addClass: function addClass(className) {
          return _this.root_.classList.add(className);
        },
        removeClass: function removeClass(className) {
          return _this.root_.classList.remove(className);
        },
        hasClass: function hasClass(className) {
          return _this.root_.classList.contains(className);
        },
        setAttr: function setAttr(attr, value) {
          return _this.root_.setAttribute(attr, value);
        },
        removeAttr: function removeAttr(attr) {
          return _this.root_.removeAttribute(attr);
        },
        setContent: function setContent(content) {
          _this.root_.textContent = content;
        }
      }));
    }
  }, {
    key: "foundation",

    /**
     * @return {!MDCTextFieldHelperTextFoundation}
     */
    get: function get() {
      return this.foundation_;
    }
  }], [{
    key: "attachTo",

    /**
     * @param {!Element} root
     * @return {!MDCTextFieldHelperText}
     */
    value: function attachTo(root) {
      return new MDCTextFieldHelperText(root);
    }
  }]);

  return MDCTextFieldHelperText;
}(_material_base_component__WEBPACK_IMPORTED_MODULE_0__["default"]);



/***/ }),

/***/ "./node_modules/@material/textfield/icon/adapter.js":
/*!**********************************************************!*\
  !*** ./node_modules/@material/textfield/icon/adapter.js ***!
  \**********************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

/**
 * @license
 * Copyright 2017 Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/* eslint no-unused-vars: [2, {"args": "none"}] */

/**
 * Adapter for MDC Text Field Icon.
 *
 * Defines the shape of the adapter expected by the foundation. Implement this
 * adapter to integrate the text field icon into your framework. See
 * https://github.com/material-components/material-components-web/blob/master/docs/authoring-components.md
 * for more information.
 *
 * @record
 */
var MDCTextFieldIconAdapter =
/*#__PURE__*/
function () {
  function MDCTextFieldIconAdapter() {
    _classCallCheck(this, MDCTextFieldIconAdapter);
  }

  _createClass(MDCTextFieldIconAdapter, [{
    key: "getAttr",

    /**
     * Gets the value of an attribute on the icon element.
     * @param {string} attr
     * @return {string}
     */
    value: function getAttr(attr) {}
    /**
     * Sets an attribute on the icon element.
     * @param {string} attr
     * @param {string} value
     */

  }, {
    key: "setAttr",
    value: function setAttr(attr, value) {}
    /**
     * Removes an attribute from the icon element.
     * @param {string} attr
     */

  }, {
    key: "removeAttr",
    value: function removeAttr(attr) {}
    /**
     * Sets the text content of the icon element.
     * @param {string} content
     */

  }, {
    key: "setContent",
    value: function setContent(content) {}
    /**
     * Registers an event listener on the icon element for a given event.
     * @param {string} evtType
     * @param {function(!Event): undefined} handler
     */

  }, {
    key: "registerInteractionHandler",
    value: function registerInteractionHandler(evtType, handler) {}
    /**
     * Deregisters an event listener on the icon element for a given event.
     * @param {string} evtType
     * @param {function(!Event): undefined} handler
     */

  }, {
    key: "deregisterInteractionHandler",
    value: function deregisterInteractionHandler(evtType, handler) {}
    /**
     * Emits a custom event "MDCTextField:icon" denoting a user has clicked the icon.
     */

  }, {
    key: "notifyIconAction",
    value: function notifyIconAction() {}
  }]);

  return MDCTextFieldIconAdapter;
}();

/* harmony default export */ __webpack_exports__["default"] = (MDCTextFieldIconAdapter);

/***/ }),

/***/ "./node_modules/@material/textfield/icon/constants.js":
/*!************************************************************!*\
  !*** ./node_modules/@material/textfield/icon/constants.js ***!
  \************************************************************/
/*! exports provided: strings */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "strings", function() { return strings; });
/**
 * @license
 * Copyright 2016 Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/** @enum {string} */
var strings = {
  ICON_EVENT: 'MDCTextField:icon',
  ICON_ROLE: 'button'
};


/***/ }),

/***/ "./node_modules/@material/textfield/icon/foundation.js":
/*!*************************************************************!*\
  !*** ./node_modules/@material/textfield/icon/foundation.js ***!
  \*************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _material_base_foundation__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @material/base/foundation */ "./node_modules/@material/base/foundation.js");
/* harmony import */ var _adapter__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./adapter */ "./node_modules/@material/textfield/icon/adapter.js");
/* harmony import */ var _constants__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./constants */ "./node_modules/@material/textfield/icon/constants.js");
function _typeof(obj) { if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (call && (_typeof(call) === "object" || typeof call === "function")) { return call; } return _assertThisInitialized(self); }

function _assertThisInitialized(self) { if (self === void 0) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return self; }

function _getPrototypeOf(o) { _getPrototypeOf = Object.setPrototypeOf ? Object.getPrototypeOf : function _getPrototypeOf(o) { return o.__proto__ || Object.getPrototypeOf(o); }; return _getPrototypeOf(o); }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function"); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, writable: true, configurable: true } }); if (superClass) _setPrototypeOf(subClass, superClass); }

function _setPrototypeOf(o, p) { _setPrototypeOf = Object.setPrototypeOf || function _setPrototypeOf(o, p) { o.__proto__ = p; return o; }; return _setPrototypeOf(o, p); }

/**
 * @license
 * Copyright 2017 Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */



/**
 * @extends {MDCFoundation<!MDCTextFieldIconAdapter>}
 * @final
 */

var MDCTextFieldIconFoundation =
/*#__PURE__*/
function (_MDCFoundation) {
  _inherits(MDCTextFieldIconFoundation, _MDCFoundation);

  _createClass(MDCTextFieldIconFoundation, null, [{
    key: "strings",

    /** @return enum {string} */
    get: function get() {
      return _constants__WEBPACK_IMPORTED_MODULE_2__["strings"];
    }
    /**
     * {@see MDCTextFieldIconAdapter} for typing information on parameters and return
     * types.
     * @return {!MDCTextFieldIconAdapter}
     */

  }, {
    key: "defaultAdapter",
    get: function get() {
      return (
        /** @type {!MDCTextFieldIconAdapter} */
        {
          getAttr: function getAttr() {},
          setAttr: function setAttr() {},
          removeAttr: function removeAttr() {},
          setContent: function setContent() {},
          registerInteractionHandler: function registerInteractionHandler() {},
          deregisterInteractionHandler: function deregisterInteractionHandler() {},
          notifyIconAction: function notifyIconAction() {}
        }
      );
    }
    /**
     * @param {!MDCTextFieldIconAdapter} adapter
     */

  }]);

  function MDCTextFieldIconFoundation(adapter) {
    var _this;

    _classCallCheck(this, MDCTextFieldIconFoundation);

    _this = _possibleConstructorReturn(this, _getPrototypeOf(MDCTextFieldIconFoundation).call(this, Object.assign(MDCTextFieldIconFoundation.defaultAdapter, adapter)));
    /** @private {string?} */

    _this.savedTabIndex_ = null;
    /** @private {function(!Event): undefined} */

    _this.interactionHandler_ = function (evt) {
      return _this.handleInteraction(evt);
    };

    return _this;
  }

  _createClass(MDCTextFieldIconFoundation, [{
    key: "init",
    value: function init() {
      var _this2 = this;

      this.savedTabIndex_ = this.adapter_.getAttr('tabindex');
      ['click', 'keydown'].forEach(function (evtType) {
        _this2.adapter_.registerInteractionHandler(evtType, _this2.interactionHandler_);
      });
    }
  }, {
    key: "destroy",
    value: function destroy() {
      var _this3 = this;

      ['click', 'keydown'].forEach(function (evtType) {
        _this3.adapter_.deregisterInteractionHandler(evtType, _this3.interactionHandler_);
      });
    }
    /** @param {boolean} disabled */

  }, {
    key: "setDisabled",
    value: function setDisabled(disabled) {
      if (!this.savedTabIndex_) {
        return;
      }

      if (disabled) {
        this.adapter_.setAttr('tabindex', '-1');
        this.adapter_.removeAttr('role');
      } else {
        this.adapter_.setAttr('tabindex', this.savedTabIndex_);
        this.adapter_.setAttr('role', _constants__WEBPACK_IMPORTED_MODULE_2__["strings"].ICON_ROLE);
      }
    }
    /** @param {string} label */

  }, {
    key: "setAriaLabel",
    value: function setAriaLabel(label) {
      this.adapter_.setAttr('aria-label', label);
    }
    /** @param {string} content */

  }, {
    key: "setContent",
    value: function setContent(content) {
      this.adapter_.setContent(content);
    }
    /**
     * Handles an interaction event
     * @param {!Event} evt
     */

  }, {
    key: "handleInteraction",
    value: function handleInteraction(evt) {
      if (evt.type === 'click' || evt.key === 'Enter' || evt.keyCode === 13) {
        this.adapter_.notifyIconAction();
      }
    }
  }]);

  return MDCTextFieldIconFoundation;
}(_material_base_foundation__WEBPACK_IMPORTED_MODULE_0__["default"]);

/* harmony default export */ __webpack_exports__["default"] = (MDCTextFieldIconFoundation);

/***/ }),

/***/ "./node_modules/@material/textfield/icon/index.js":
/*!********************************************************!*\
  !*** ./node_modules/@material/textfield/icon/index.js ***!
  \********************************************************/
/*! exports provided: MDCTextFieldIcon, MDCTextFieldIconFoundation */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "MDCTextFieldIcon", function() { return MDCTextFieldIcon; });
/* harmony import */ var _material_base_component__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @material/base/component */ "./node_modules/@material/base/component.js");
/* harmony import */ var _adapter__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./adapter */ "./node_modules/@material/textfield/icon/adapter.js");
/* harmony import */ var _foundation__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./foundation */ "./node_modules/@material/textfield/icon/foundation.js");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "MDCTextFieldIconFoundation", function() { return _foundation__WEBPACK_IMPORTED_MODULE_2__["default"]; });

function _typeof(obj) { if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

function _possibleConstructorReturn(self, call) { if (call && (_typeof(call) === "object" || typeof call === "function")) { return call; } return _assertThisInitialized(self); }

function _assertThisInitialized(self) { if (self === void 0) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return self; }

function _getPrototypeOf(o) { _getPrototypeOf = Object.setPrototypeOf ? Object.getPrototypeOf : function _getPrototypeOf(o) { return o.__proto__ || Object.getPrototypeOf(o); }; return _getPrototypeOf(o); }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function"); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, writable: true, configurable: true } }); if (superClass) _setPrototypeOf(subClass, superClass); }

function _setPrototypeOf(o, p) { _setPrototypeOf = Object.setPrototypeOf || function _setPrototypeOf(o, p) { o.__proto__ = p; return o; }; return _setPrototypeOf(o, p); }

/**
 * @license
 * Copyright 2017 Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */



/**
 * @extends {MDCComponent<!MDCTextFieldIconFoundation>}
 * @final
 */

var MDCTextFieldIcon =
/*#__PURE__*/
function (_MDCComponent) {
  _inherits(MDCTextFieldIcon, _MDCComponent);

  function MDCTextFieldIcon() {
    _classCallCheck(this, MDCTextFieldIcon);

    return _possibleConstructorReturn(this, _getPrototypeOf(MDCTextFieldIcon).apply(this, arguments));
  }

  _createClass(MDCTextFieldIcon, [{
    key: "getDefaultFoundation",

    /**
     * @return {!MDCTextFieldIconFoundation}
     */
    value: function getDefaultFoundation() {
      var _this = this;

      return new _foundation__WEBPACK_IMPORTED_MODULE_2__["default"](
      /** @type {!MDCTextFieldIconAdapter} */
      Object.assign({
        getAttr: function getAttr(attr) {
          return _this.root_.getAttribute(attr);
        },
        setAttr: function setAttr(attr, value) {
          return _this.root_.setAttribute(attr, value);
        },
        removeAttr: function removeAttr(attr) {
          return _this.root_.removeAttribute(attr);
        },
        setContent: function setContent(content) {
          _this.root_.textContent = content;
        },
        registerInteractionHandler: function registerInteractionHandler(evtType, handler) {
          return _this.root_.addEventListener(evtType, handler);
        },
        deregisterInteractionHandler: function deregisterInteractionHandler(evtType, handler) {
          return _this.root_.removeEventListener(evtType, handler);
        },
        notifyIconAction: function notifyIconAction() {
          return _this.emit(_foundation__WEBPACK_IMPORTED_MODULE_2__["default"].strings.ICON_EVENT, {}
          /* evtData */
          , true
          /* shouldBubble */
          );
        }
      }));
    }
  }, {
    key: "foundation",

    /**
     * @return {!MDCTextFieldIconFoundation}
     */
    get: function get() {
      return this.foundation_;
    }
  }], [{
    key: "attachTo",

    /**
     * @param {!Element} root
     * @return {!MDCTextFieldIcon}
     */
    value: function attachTo(root) {
      return new MDCTextFieldIcon(root);
    }
  }]);

  return MDCTextFieldIcon;
}(_material_base_component__WEBPACK_IMPORTED_MODULE_0__["default"]);



/***/ }),

/***/ "./node_modules/@material/textfield/index.js":
/*!***************************************************!*\
  !*** ./node_modules/@material/textfield/index.js ***!
  \***************************************************/
/*! exports provided: MDCTextField, MDCTextFieldFoundation, MDCTextFieldHelperText, MDCTextFieldHelperTextFoundation, MDCTextFieldIcon, MDCTextFieldIconFoundation */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "MDCTextField", function() { return MDCTextField; });
/* harmony import */ var _material_base_component__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @material/base/component */ "./node_modules/@material/base/component.js");
/* harmony import */ var _material_ripple_index__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @material/ripple/index */ "./node_modules/@material/ripple/index.js");
/* harmony import */ var _material_ripple_util__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @material/ripple/util */ "./node_modules/@material/ripple/util.js");
/* harmony import */ var _constants__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./constants */ "./node_modules/@material/textfield/constants.js");
/* harmony import */ var _adapter__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./adapter */ "./node_modules/@material/textfield/adapter.js");
/* harmony import */ var _foundation__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./foundation */ "./node_modules/@material/textfield/foundation.js");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "MDCTextFieldFoundation", function() { return _foundation__WEBPACK_IMPORTED_MODULE_5__["default"]; });

/* harmony import */ var _material_line_ripple_index__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! @material/line-ripple/index */ "./node_modules/@material/line-ripple/index.js");
/* harmony import */ var _helper_text_index__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! ./helper-text/index */ "./node_modules/@material/textfield/helper-text/index.js");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "MDCTextFieldHelperText", function() { return _helper_text_index__WEBPACK_IMPORTED_MODULE_7__["MDCTextFieldHelperText"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "MDCTextFieldHelperTextFoundation", function() { return _helper_text_index__WEBPACK_IMPORTED_MODULE_7__["MDCTextFieldHelperTextFoundation"]; });

/* harmony import */ var _icon_index__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! ./icon/index */ "./node_modules/@material/textfield/icon/index.js");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "MDCTextFieldIcon", function() { return _icon_index__WEBPACK_IMPORTED_MODULE_8__["MDCTextFieldIcon"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "MDCTextFieldIconFoundation", function() { return _icon_index__WEBPACK_IMPORTED_MODULE_8__["MDCTextFieldIconFoundation"]; });

/* harmony import */ var _material_floating_label_index__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! @material/floating-label/index */ "./node_modules/@material/floating-label/index.js");
/* harmony import */ var _material_notched_outline_index__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! @material/notched-outline/index */ "./node_modules/@material/notched-outline/index.js");
function _typeof(obj) { if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

function _possibleConstructorReturn(self, call) { if (call && (_typeof(call) === "object" || typeof call === "function")) { return call; } return _assertThisInitialized(self); }

function _assertThisInitialized(self) { if (self === void 0) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return self; }

function _get(target, property, receiver) { if (typeof Reflect !== "undefined" && Reflect.get) { _get = Reflect.get; } else { _get = function _get(target, property, receiver) { var base = _superPropBase(target, property); if (!base) return; var desc = Object.getOwnPropertyDescriptor(base, property); if (desc.get) { return desc.get.call(receiver); } return desc.value; }; } return _get(target, property, receiver || target); }

function _superPropBase(object, property) { while (!Object.prototype.hasOwnProperty.call(object, property)) { object = _getPrototypeOf(object); if (object === null) break; } return object; }

function _getPrototypeOf(o) { _getPrototypeOf = Object.setPrototypeOf ? Object.getPrototypeOf : function _getPrototypeOf(o) { return o.__proto__ || Object.getPrototypeOf(o); }; return _getPrototypeOf(o); }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function"); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, writable: true, configurable: true } }); if (superClass) _setPrototypeOf(subClass, superClass); }

function _setPrototypeOf(o, p) { _setPrototypeOf = Object.setPrototypeOf || function _setPrototypeOf(o, p) { o.__proto__ = p; return o; }; return _setPrototypeOf(o, p); }

/**
 * @license
 * Copyright 2016 Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/* eslint-disable no-unused-vars */


/* eslint-enable no-unused-vars */





/* eslint-disable no-unused-vars */






/* eslint-enable no-unused-vars */

/**
 * @extends {MDCComponent<!MDCTextFieldFoundation>}
 * @final
 */

var MDCTextField =
/*#__PURE__*/
function (_MDCComponent) {
  _inherits(MDCTextField, _MDCComponent);

  /**
   * @param {...?} args
   */
  function MDCTextField() {
    var _getPrototypeOf2;

    var _this;

    _classCallCheck(this, MDCTextField);

    for (var _len = arguments.length, args = new Array(_len), _key = 0; _key < _len; _key++) {
      args[_key] = arguments[_key];
    }

    _this = _possibleConstructorReturn(this, (_getPrototypeOf2 = _getPrototypeOf(MDCTextField)).call.apply(_getPrototypeOf2, [this].concat(args)));
    /** @private {?Element} */

    _this.input_;
    /** @type {?MDCRipple} */

    _this.ripple;
    /** @private {?MDCLineRipple} */

    _this.lineRipple_;
    /** @private {?MDCTextFieldHelperText} */

    _this.helperText_;
    /** @private {?MDCTextFieldIcon} */

    _this.icon_;
    /** @private {?MDCFloatingLabel} */

    _this.label_;
    /** @private {?MDCNotchedOutline} */

    _this.outline_;
    return _this;
  }
  /**
   * @param {!Element} root
   * @return {!MDCTextField}
   */


  _createClass(MDCTextField, [{
    key: "initialize",

    /**
     * @param {(function(!Element): !MDCRipple)=} rippleFactory A function which
     * creates a new MDCRipple.
     * @param {(function(!Element): !MDCLineRipple)=} lineRippleFactory A function which
     * creates a new MDCLineRipple.
     * @param {(function(!Element): !MDCTextFieldHelperText)=} helperTextFactory A function which
     * creates a new MDCTextFieldHelperText.
     * @param {(function(!Element): !MDCTextFieldIcon)=} iconFactory A function which
     * creates a new MDCTextFieldIcon.
     * @param {(function(!Element): !MDCFloatingLabel)=} labelFactory A function which
     * creates a new MDCFloatingLabel.
     * @param {(function(!Element): !MDCNotchedOutline)=} outlineFactory A function which
     * creates a new MDCNotchedOutline.
     */
    value: function initialize() {
      var _this2 = this;

      var rippleFactory = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : function (el, foundation) {
        return new _material_ripple_index__WEBPACK_IMPORTED_MODULE_1__["MDCRipple"](el, foundation);
      };
      var lineRippleFactory = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : function (el) {
        return new _material_line_ripple_index__WEBPACK_IMPORTED_MODULE_6__["MDCLineRipple"](el);
      };
      var helperTextFactory = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : function (el) {
        return new _helper_text_index__WEBPACK_IMPORTED_MODULE_7__["MDCTextFieldHelperText"](el);
      };
      var iconFactory = arguments.length > 3 && arguments[3] !== undefined ? arguments[3] : function (el) {
        return new _icon_index__WEBPACK_IMPORTED_MODULE_8__["MDCTextFieldIcon"](el);
      };
      var labelFactory = arguments.length > 4 && arguments[4] !== undefined ? arguments[4] : function (el) {
        return new _material_floating_label_index__WEBPACK_IMPORTED_MODULE_9__["MDCFloatingLabel"](el);
      };
      var outlineFactory = arguments.length > 5 && arguments[5] !== undefined ? arguments[5] : function (el) {
        return new _material_notched_outline_index__WEBPACK_IMPORTED_MODULE_10__["MDCNotchedOutline"](el);
      };
      this.input_ = this.root_.querySelector(_constants__WEBPACK_IMPORTED_MODULE_3__["strings"].INPUT_SELECTOR);
      var labelElement = this.root_.querySelector(_constants__WEBPACK_IMPORTED_MODULE_3__["strings"].LABEL_SELECTOR);

      if (labelElement) {
        this.label_ = labelFactory(labelElement);
      }

      var lineRippleElement = this.root_.querySelector(_constants__WEBPACK_IMPORTED_MODULE_3__["strings"].LINE_RIPPLE_SELECTOR);

      if (lineRippleElement) {
        this.lineRipple_ = lineRippleFactory(lineRippleElement);
      }

      var outlineElement = this.root_.querySelector(_constants__WEBPACK_IMPORTED_MODULE_3__["strings"].OUTLINE_SELECTOR);

      if (outlineElement) {
        this.outline_ = outlineFactory(outlineElement);
      }

      if (this.input_.hasAttribute(_constants__WEBPACK_IMPORTED_MODULE_3__["strings"].ARIA_CONTROLS)) {
        var helperTextElement = document.getElementById(this.input_.getAttribute(_constants__WEBPACK_IMPORTED_MODULE_3__["strings"].ARIA_CONTROLS));

        if (helperTextElement) {
          this.helperText_ = helperTextFactory(helperTextElement);
        }
      }

      var iconElement = this.root_.querySelector(_constants__WEBPACK_IMPORTED_MODULE_3__["strings"].ICON_SELECTOR);

      if (iconElement) {
        this.icon_ = iconFactory(iconElement);
      }

      this.ripple = null;

      if (this.root_.classList.contains(_constants__WEBPACK_IMPORTED_MODULE_3__["cssClasses"].BOX)) {
        var MATCHES = Object(_material_ripple_util__WEBPACK_IMPORTED_MODULE_2__["getMatchesProperty"])(HTMLElement.prototype);
        var adapter = Object.assign(_material_ripple_index__WEBPACK_IMPORTED_MODULE_1__["MDCRipple"].createAdapter(
        /** @type {!RippleCapableSurface} */
        this), {
          isSurfaceActive: function isSurfaceActive() {
            return _this2.input_[MATCHES](':active');
          },
          registerInteractionHandler: function registerInteractionHandler(type, handler) {
            return _this2.input_.addEventListener(type, handler);
          },
          deregisterInteractionHandler: function deregisterInteractionHandler(type, handler) {
            return _this2.input_.removeEventListener(type, handler);
          }
        });
        var foundation = new _material_ripple_index__WEBPACK_IMPORTED_MODULE_1__["MDCRippleFoundation"](adapter);
        this.ripple = rippleFactory(this.root_, foundation);
      }
    }
  }, {
    key: "destroy",
    value: function destroy() {
      if (this.ripple) {
        this.ripple.destroy();
      }

      if (this.lineRipple_) {
        this.lineRipple_.destroy();
      }

      if (this.helperText_) {
        this.helperText_.destroy();
      }

      if (this.icon_) {
        this.icon_.destroy();
      }

      if (this.label_) {
        this.label_.destroy();
      }

      if (this.outline_) {
        this.outline_.destroy();
      }

      _get(_getPrototypeOf(MDCTextField.prototype), "destroy", this).call(this);
    }
    /**
     * Initiliazes the Text Field's internal state based on the environment's
     * state.
     */

  }, {
    key: "initialSyncWithDom",
    value: function initialSyncWithDom() {
      this.disabled = this.input_.disabled;
    }
    /**
     * @return {string} The value of the input.
     */

  }, {
    key: "layout",

    /**
     * Recomputes the outline SVG path for the outline element.
     */
    value: function layout() {
      var openNotch = this.foundation_.shouldFloat;
      this.foundation_.notchOutline(openNotch);
    }
    /**
     * @return {!MDCTextFieldFoundation}
     */

  }, {
    key: "getDefaultFoundation",
    value: function getDefaultFoundation() {
      var _this3 = this;

      return new _foundation__WEBPACK_IMPORTED_MODULE_5__["default"](
      /** @type {!MDCTextFieldAdapter} */
      Object.assign({
        addClass: function addClass(className) {
          return _this3.root_.classList.add(className);
        },
        removeClass: function removeClass(className) {
          return _this3.root_.classList.remove(className);
        },
        hasClass: function hasClass(className) {
          return _this3.root_.classList.contains(className);
        },
        registerTextFieldInteractionHandler: function registerTextFieldInteractionHandler(evtType, handler) {
          return _this3.root_.addEventListener(evtType, handler);
        },
        deregisterTextFieldInteractionHandler: function deregisterTextFieldInteractionHandler(evtType, handler) {
          return _this3.root_.removeEventListener(evtType, handler);
        },
        registerValidationAttributeChangeHandler: function registerValidationAttributeChangeHandler(handler) {
          var getAttributesList = function getAttributesList(mutationsList) {
            return mutationsList.map(function (mutation) {
              return mutation.attributeName;
            });
          };

          var observer = new MutationObserver(function (mutationsList) {
            return handler(getAttributesList(mutationsList));
          });

          var targetNode = _this3.root_.querySelector(_constants__WEBPACK_IMPORTED_MODULE_3__["strings"].INPUT_SELECTOR);

          var config = {
            attributes: true
          };
          observer.observe(targetNode, config);
          return observer;
        },
        deregisterValidationAttributeChangeHandler: function deregisterValidationAttributeChangeHandler(observer) {
          return observer.disconnect();
        },
        isFocused: function isFocused() {
          return document.activeElement === _this3.root_.querySelector(_constants__WEBPACK_IMPORTED_MODULE_3__["strings"].INPUT_SELECTOR);
        },
        isRtl: function isRtl() {
          return window.getComputedStyle(_this3.root_).getPropertyValue('direction') === 'rtl';
        }
      }, this.getInputAdapterMethods_(), this.getLabelAdapterMethods_(), this.getLineRippleAdapterMethods_(), this.getOutlineAdapterMethods_()), this.getFoundationMap_());
    }
    /**
     * @return {!{
     *   shakeLabel: function(boolean): undefined,
     *   floatLabel: function(boolean): undefined,
     *   hasLabel: function(): boolean,
     *   getLabelWidth: function(): number,
     * }}
     */

  }, {
    key: "getLabelAdapterMethods_",
    value: function getLabelAdapterMethods_() {
      var _this4 = this;

      return {
        shakeLabel: function shakeLabel(shouldShake) {
          return _this4.label_.shake(shouldShake);
        },
        floatLabel: function floatLabel(shouldFloat) {
          return _this4.label_.float(shouldFloat);
        },
        hasLabel: function hasLabel() {
          return !!_this4.label_;
        },
        getLabelWidth: function getLabelWidth() {
          return _this4.label_.getWidth();
        }
      };
    }
    /**
     * @return {!{
     *   activateLineRipple: function(): undefined,
     *   deactivateLineRipple: function(): undefined,
     *   setLineRippleTransformOrigin: function(number): undefined,
     * }}
     */

  }, {
    key: "getLineRippleAdapterMethods_",
    value: function getLineRippleAdapterMethods_() {
      var _this5 = this;

      return {
        activateLineRipple: function activateLineRipple() {
          if (_this5.lineRipple_) {
            _this5.lineRipple_.activate();
          }
        },
        deactivateLineRipple: function deactivateLineRipple() {
          if (_this5.lineRipple_) {
            _this5.lineRipple_.deactivate();
          }
        },
        setLineRippleTransformOrigin: function setLineRippleTransformOrigin(normalizedX) {
          if (_this5.lineRipple_) {
            _this5.lineRipple_.setRippleCenter(normalizedX);
          }
        }
      };
    }
    /**
     * @return {!{
     *   notchOutline: function(number, boolean): undefined,
     *   hasOutline: function(): boolean,
     * }}
     */

  }, {
    key: "getOutlineAdapterMethods_",
    value: function getOutlineAdapterMethods_() {
      var _this6 = this;

      return {
        notchOutline: function notchOutline(labelWidth, isRtl) {
          return _this6.outline_.notch(labelWidth, isRtl);
        },
        closeOutline: function closeOutline() {
          return _this6.outline_.closeNotch();
        },
        hasOutline: function hasOutline() {
          return !!_this6.outline_;
        }
      };
    }
    /**
     * @return {!{
     *   registerInputInteractionHandler: function(string, function()): undefined,
     *   deregisterInputInteractionHandler: function(string, function()): undefined,
     *   getNativeInput: function(): ?Element,
     * }}
     */

  }, {
    key: "getInputAdapterMethods_",
    value: function getInputAdapterMethods_() {
      var _this7 = this;

      return {
        registerInputInteractionHandler: function registerInputInteractionHandler(evtType, handler) {
          return _this7.input_.addEventListener(evtType, handler);
        },
        deregisterInputInteractionHandler: function deregisterInputInteractionHandler(evtType, handler) {
          return _this7.input_.removeEventListener(evtType, handler);
        },
        getNativeInput: function getNativeInput() {
          return _this7.input_;
        }
      };
    }
    /**
     * Returns a map of all subcomponents to subfoundations.
     * @return {!FoundationMapType}
     */

  }, {
    key: "getFoundationMap_",
    value: function getFoundationMap_() {
      return {
        helperText: this.helperText_ ? this.helperText_.foundation : undefined,
        icon: this.icon_ ? this.icon_.foundation : undefined
      };
    }
  }, {
    key: "value",
    get: function get() {
      return this.foundation_.getValue();
    }
    /**
     * @param {string} value The value to set on the input.
     */
    ,
    set: function set(value) {
      this.foundation_.setValue(value);
    }
    /**
     * @return {boolean} True if the Text Field is disabled.
     */

  }, {
    key: "disabled",
    get: function get() {
      return this.foundation_.isDisabled();
    }
    /**
     * @param {boolean} disabled Sets the Text Field disabled or enabled.
     */
    ,
    set: function set(disabled) {
      this.foundation_.setDisabled(disabled);
    }
    /**
     * @return {boolean} valid True if the Text Field is valid.
     */

  }, {
    key: "valid",
    get: function get() {
      return this.foundation_.isValid();
    }
    /**
     * @param {boolean} valid Sets the Text Field valid or invalid.
     */
    ,
    set: function set(valid) {
      this.foundation_.setValid(valid);
    }
    /**
     * @return {boolean} True if the Text Field is required.
     */

  }, {
    key: "required",
    get: function get() {
      return this.input_.required;
    }
    /**
     * @param {boolean} required Sets the Text Field to required.
     */
    ,
    set: function set(required) {
      this.input_.required = required;
    }
    /**
     * @return {string} The input element's validation pattern.
     */

  }, {
    key: "pattern",
    get: function get() {
      return this.input_.pattern;
    }
    /**
     * @param {string} pattern Sets the input element's validation pattern.
     */
    ,
    set: function set(pattern) {
      this.input_.pattern = pattern;
    }
    /**
     * @return {number} The input element's minLength.
     */

  }, {
    key: "minLength",
    get: function get() {
      return this.input_.minLength;
    }
    /**
     * @param {number} minLength Sets the input element's minLength.
     */
    ,
    set: function set(minLength) {
      this.input_.minLength = minLength;
    }
    /**
     * @return {number} The input element's maxLength.
     */

  }, {
    key: "maxLength",
    get: function get() {
      return this.input_.maxLength;
    }
    /**
     * @param {number} maxLength Sets the input element's maxLength.
     */
    ,
    set: function set(maxLength) {
      // Chrome throws exception if maxLength is set < 0
      if (maxLength < 0) {
        this.input_.removeAttribute('maxLength');
      } else {
        this.input_.maxLength = maxLength;
      }
    }
    /**
     * @return {string} The input element's min.
     */

  }, {
    key: "min",
    get: function get() {
      return this.input_.min;
    }
    /**
     * @param {string} min Sets the input element's min.
     */
    ,
    set: function set(min) {
      this.input_.min = min;
    }
    /**
     * @return {string} The input element's max.
     */

  }, {
    key: "max",
    get: function get() {
      return this.input_.max;
    }
    /**
     * @param {string} max Sets the input element's max.
     */
    ,
    set: function set(max) {
      this.input_.max = max;
    }
    /**
     * @return {string} The input element's step.
     */

  }, {
    key: "step",
    get: function get() {
      return this.input_.step;
    }
    /**
     * @param {string} step Sets the input element's step.
     */
    ,
    set: function set(step) {
      this.input_.step = step;
    }
    /**
     * Sets the helper text element content.
     * @param {string} content
     */

  }, {
    key: "helperTextContent",
    set: function set(content) {
      this.foundation_.setHelperTextContent(content);
    }
    /**
     * Sets the aria label of the icon.
     * @param {string} label
     */

  }, {
    key: "iconAriaLabel",
    set: function set(label) {
      this.foundation_.setIconAriaLabel(label);
    }
    /**
     * Sets the text content of the icon.
     * @param {string} content
     */

  }, {
    key: "iconContent",
    set: function set(content) {
      this.foundation_.setIconContent(content);
    }
  }], [{
    key: "attachTo",
    value: function attachTo(root) {
      return new MDCTextField(root);
    }
  }]);

  return MDCTextField;
}(_material_base_component__WEBPACK_IMPORTED_MODULE_0__["default"]);



/***/ }),

/***/ "./node_modules/es6-promise/dist/es6-promise.js":
/*!******************************************************!*\
  !*** ./node_modules/es6-promise/dist/es6-promise.js ***!
  \******************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

/* WEBPACK VAR INJECTION */(function(process, global) {var __WEBPACK_AMD_DEFINE_FACTORY__, __WEBPACK_AMD_DEFINE_RESULT__;function _typeof(obj) { if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

/*!
 * @overview es6-promise - a tiny implementation of Promises/A+.
 * @copyright Copyright (c) 2014 Yehuda Katz, Tom Dale, Stefan Penner and contributors (Conversion to ES6 API by Jake Archibald)
 * @license   Licensed under MIT license
 *            See https://raw.githubusercontent.com/stefanpenner/es6-promise/master/LICENSE
 * @version   v4.2.6+9869a4bc
 */
(function (global, factory) {
  ( false ? undefined : _typeof(exports)) === 'object' && typeof module !== 'undefined' ? module.exports = factory() :  true ? !(__WEBPACK_AMD_DEFINE_FACTORY__ = (factory),
				__WEBPACK_AMD_DEFINE_RESULT__ = (typeof __WEBPACK_AMD_DEFINE_FACTORY__ === 'function' ?
				(__WEBPACK_AMD_DEFINE_FACTORY__.call(exports, __webpack_require__, exports, module)) :
				__WEBPACK_AMD_DEFINE_FACTORY__),
				__WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__)) : undefined;
})(this, function () {
  'use strict';

  function objectOrFunction(x) {
    var type = _typeof(x);

    return x !== null && (type === 'object' || type === 'function');
  }

  function isFunction(x) {
    return typeof x === 'function';
  }

  var _isArray = void 0;

  if (Array.isArray) {
    _isArray = Array.isArray;
  } else {
    _isArray = function _isArray(x) {
      return Object.prototype.toString.call(x) === '[object Array]';
    };
  }

  var isArray = _isArray;
  var len = 0;
  var vertxNext = void 0;
  var customSchedulerFn = void 0;

  var asap = function asap(callback, arg) {
    queue[len] = callback;
    queue[len + 1] = arg;
    len += 2;

    if (len === 2) {
      // If len is 2, that means that we need to schedule an async flush.
      // If additional callbacks are queued before the queue is flushed, they
      // will be processed by this flush that we are scheduling.
      if (customSchedulerFn) {
        customSchedulerFn(flush);
      } else {
        scheduleFlush();
      }
    }
  };

  function setScheduler(scheduleFn) {
    customSchedulerFn = scheduleFn;
  }

  function setAsap(asapFn) {
    asap = asapFn;
  }

  var browserWindow = typeof window !== 'undefined' ? window : undefined;
  var browserGlobal = browserWindow || {};
  var BrowserMutationObserver = browserGlobal.MutationObserver || browserGlobal.WebKitMutationObserver;
  var isNode = typeof self === 'undefined' && typeof process !== 'undefined' && {}.toString.call(process) === '[object process]'; // test for web worker but not in IE10

  var isWorker = typeof Uint8ClampedArray !== 'undefined' && typeof importScripts !== 'undefined' && typeof MessageChannel !== 'undefined'; // node

  function useNextTick() {
    // node version 0.10.x displays a deprecation warning when nextTick is used recursively
    // see https://github.com/cujojs/when/issues/410 for details
    return function () {
      return process.nextTick(flush);
    };
  } // vertx


  function useVertxTimer() {
    if (typeof vertxNext !== 'undefined') {
      return function () {
        vertxNext(flush);
      };
    }

    return useSetTimeout();
  }

  function useMutationObserver() {
    var iterations = 0;
    var observer = new BrowserMutationObserver(flush);
    var node = document.createTextNode('');
    observer.observe(node, {
      characterData: true
    });
    return function () {
      node.data = iterations = ++iterations % 2;
    };
  } // web worker


  function useMessageChannel() {
    var channel = new MessageChannel();
    channel.port1.onmessage = flush;
    return function () {
      return channel.port2.postMessage(0);
    };
  }

  function useSetTimeout() {
    // Store setTimeout reference so es6-promise will be unaffected by
    // other code modifying setTimeout (like sinon.useFakeTimers())
    var globalSetTimeout = setTimeout;
    return function () {
      return globalSetTimeout(flush, 1);
    };
  }

  var queue = new Array(1000);

  function flush() {
    for (var i = 0; i < len; i += 2) {
      var callback = queue[i];
      var arg = queue[i + 1];
      callback(arg);
      queue[i] = undefined;
      queue[i + 1] = undefined;
    }

    len = 0;
  }

  function attemptVertx() {
    try {
      var vertx = Function('return this')().require('vertx');

      vertxNext = vertx.runOnLoop || vertx.runOnContext;
      return useVertxTimer();
    } catch (e) {
      return useSetTimeout();
    }
  }

  var scheduleFlush = void 0; // Decide what async method to use to triggering processing of queued callbacks:

  if (isNode) {
    scheduleFlush = useNextTick();
  } else if (BrowserMutationObserver) {
    scheduleFlush = useMutationObserver();
  } else if (isWorker) {
    scheduleFlush = useMessageChannel();
  } else if (browserWindow === undefined && "function" === 'function') {
    scheduleFlush = attemptVertx();
  } else {
    scheduleFlush = useSetTimeout();
  }

  function then(onFulfillment, onRejection) {
    var parent = this;
    var child = new this.constructor(noop);

    if (child[PROMISE_ID] === undefined) {
      makePromise(child);
    }

    var _state = parent._state;

    if (_state) {
      var callback = arguments[_state - 1];
      asap(function () {
        return invokeCallback(_state, child, callback, parent._result);
      });
    } else {
      subscribe(parent, child, onFulfillment, onRejection);
    }

    return child;
  }
  /**
    `Promise.resolve` returns a promise that will become resolved with the
    passed `value`. It is shorthand for the following:
  
    ```javascript
    let promise = new Promise(function(resolve, reject){
      resolve(1);
    });
  
    promise.then(function(value){
      // value === 1
    });
    ```
  
    Instead of writing the above, your code now simply becomes the following:
  
    ```javascript
    let promise = Promise.resolve(1);
  
    promise.then(function(value){
      // value === 1
    });
    ```
  
    @method resolve
    @static
    @param {Any} value value that the returned promise will be resolved with
    Useful for tooling.
    @return {Promise} a promise that will become fulfilled with the given
    `value`
  */


  function resolve$1(object) {
    /*jshint validthis:true */
    var Constructor = this;

    if (object && _typeof(object) === 'object' && object.constructor === Constructor) {
      return object;
    }

    var promise = new Constructor(noop);
    resolve(promise, object);
    return promise;
  }

  var PROMISE_ID = Math.random().toString(36).substring(2);

  function noop() {}

  var PENDING = void 0;
  var FULFILLED = 1;
  var REJECTED = 2;
  var TRY_CATCH_ERROR = {
    error: null
  };

  function selfFulfillment() {
    return new TypeError("You cannot resolve a promise with itself");
  }

  function cannotReturnOwn() {
    return new TypeError('A promises callback cannot return that same promise.');
  }

  function getThen(promise) {
    try {
      return promise.then;
    } catch (error) {
      TRY_CATCH_ERROR.error = error;
      return TRY_CATCH_ERROR;
    }
  }

  function tryThen(then$$1, value, fulfillmentHandler, rejectionHandler) {
    try {
      then$$1.call(value, fulfillmentHandler, rejectionHandler);
    } catch (e) {
      return e;
    }
  }

  function handleForeignThenable(promise, thenable, then$$1) {
    asap(function (promise) {
      var sealed = false;
      var error = tryThen(then$$1, thenable, function (value) {
        if (sealed) {
          return;
        }

        sealed = true;

        if (thenable !== value) {
          resolve(promise, value);
        } else {
          fulfill(promise, value);
        }
      }, function (reason) {
        if (sealed) {
          return;
        }

        sealed = true;
        reject(promise, reason);
      }, 'Settle: ' + (promise._label || ' unknown promise'));

      if (!sealed && error) {
        sealed = true;
        reject(promise, error);
      }
    }, promise);
  }

  function handleOwnThenable(promise, thenable) {
    if (thenable._state === FULFILLED) {
      fulfill(promise, thenable._result);
    } else if (thenable._state === REJECTED) {
      reject(promise, thenable._result);
    } else {
      subscribe(thenable, undefined, function (value) {
        return resolve(promise, value);
      }, function (reason) {
        return reject(promise, reason);
      });
    }
  }

  function handleMaybeThenable(promise, maybeThenable, then$$1) {
    if (maybeThenable.constructor === promise.constructor && then$$1 === then && maybeThenable.constructor.resolve === resolve$1) {
      handleOwnThenable(promise, maybeThenable);
    } else {
      if (then$$1 === TRY_CATCH_ERROR) {
        reject(promise, TRY_CATCH_ERROR.error);
        TRY_CATCH_ERROR.error = null;
      } else if (then$$1 === undefined) {
        fulfill(promise, maybeThenable);
      } else if (isFunction(then$$1)) {
        handleForeignThenable(promise, maybeThenable, then$$1);
      } else {
        fulfill(promise, maybeThenable);
      }
    }
  }

  function resolve(promise, value) {
    if (promise === value) {
      reject(promise, selfFulfillment());
    } else if (objectOrFunction(value)) {
      handleMaybeThenable(promise, value, getThen(value));
    } else {
      fulfill(promise, value);
    }
  }

  function publishRejection(promise) {
    if (promise._onerror) {
      promise._onerror(promise._result);
    }

    publish(promise);
  }

  function fulfill(promise, value) {
    if (promise._state !== PENDING) {
      return;
    }

    promise._result = value;
    promise._state = FULFILLED;

    if (promise._subscribers.length !== 0) {
      asap(publish, promise);
    }
  }

  function reject(promise, reason) {
    if (promise._state !== PENDING) {
      return;
    }

    promise._state = REJECTED;
    promise._result = reason;
    asap(publishRejection, promise);
  }

  function subscribe(parent, child, onFulfillment, onRejection) {
    var _subscribers = parent._subscribers;
    var length = _subscribers.length;
    parent._onerror = null;
    _subscribers[length] = child;
    _subscribers[length + FULFILLED] = onFulfillment;
    _subscribers[length + REJECTED] = onRejection;

    if (length === 0 && parent._state) {
      asap(publish, parent);
    }
  }

  function publish(promise) {
    var subscribers = promise._subscribers;
    var settled = promise._state;

    if (subscribers.length === 0) {
      return;
    }

    var child = void 0,
        callback = void 0,
        detail = promise._result;

    for (var i = 0; i < subscribers.length; i += 3) {
      child = subscribers[i];
      callback = subscribers[i + settled];

      if (child) {
        invokeCallback(settled, child, callback, detail);
      } else {
        callback(detail);
      }
    }

    promise._subscribers.length = 0;
  }

  function tryCatch(callback, detail) {
    try {
      return callback(detail);
    } catch (e) {
      TRY_CATCH_ERROR.error = e;
      return TRY_CATCH_ERROR;
    }
  }

  function invokeCallback(settled, promise, callback, detail) {
    var hasCallback = isFunction(callback),
        value = void 0,
        error = void 0,
        succeeded = void 0,
        failed = void 0;

    if (hasCallback) {
      value = tryCatch(callback, detail);

      if (value === TRY_CATCH_ERROR) {
        failed = true;
        error = value.error;
        value.error = null;
      } else {
        succeeded = true;
      }

      if (promise === value) {
        reject(promise, cannotReturnOwn());
        return;
      }
    } else {
      value = detail;
      succeeded = true;
    }

    if (promise._state !== PENDING) {// noop
    } else if (hasCallback && succeeded) {
      resolve(promise, value);
    } else if (failed) {
      reject(promise, error);
    } else if (settled === FULFILLED) {
      fulfill(promise, value);
    } else if (settled === REJECTED) {
      reject(promise, value);
    }
  }

  function initializePromise(promise, resolver) {
    try {
      resolver(function resolvePromise(value) {
        resolve(promise, value);
      }, function rejectPromise(reason) {
        reject(promise, reason);
      });
    } catch (e) {
      reject(promise, e);
    }
  }

  var id = 0;

  function nextId() {
    return id++;
  }

  function makePromise(promise) {
    promise[PROMISE_ID] = id++;
    promise._state = undefined;
    promise._result = undefined;
    promise._subscribers = [];
  }

  function validationError() {
    return new Error('Array Methods must be provided an Array');
  }

  var Enumerator = function () {
    function Enumerator(Constructor, input) {
      this._instanceConstructor = Constructor;
      this.promise = new Constructor(noop);

      if (!this.promise[PROMISE_ID]) {
        makePromise(this.promise);
      }

      if (isArray(input)) {
        this.length = input.length;
        this._remaining = input.length;
        this._result = new Array(this.length);

        if (this.length === 0) {
          fulfill(this.promise, this._result);
        } else {
          this.length = this.length || 0;

          this._enumerate(input);

          if (this._remaining === 0) {
            fulfill(this.promise, this._result);
          }
        }
      } else {
        reject(this.promise, validationError());
      }
    }

    Enumerator.prototype._enumerate = function _enumerate(input) {
      for (var i = 0; this._state === PENDING && i < input.length; i++) {
        this._eachEntry(input[i], i);
      }
    };

    Enumerator.prototype._eachEntry = function _eachEntry(entry, i) {
      var c = this._instanceConstructor;
      var resolve$$1 = c.resolve;

      if (resolve$$1 === resolve$1) {
        var _then = getThen(entry);

        if (_then === then && entry._state !== PENDING) {
          this._settledAt(entry._state, i, entry._result);
        } else if (typeof _then !== 'function') {
          this._remaining--;
          this._result[i] = entry;
        } else if (c === Promise$1) {
          var promise = new c(noop);
          handleMaybeThenable(promise, entry, _then);

          this._willSettleAt(promise, i);
        } else {
          this._willSettleAt(new c(function (resolve$$1) {
            return resolve$$1(entry);
          }), i);
        }
      } else {
        this._willSettleAt(resolve$$1(entry), i);
      }
    };

    Enumerator.prototype._settledAt = function _settledAt(state, i, value) {
      var promise = this.promise;

      if (promise._state === PENDING) {
        this._remaining--;

        if (state === REJECTED) {
          reject(promise, value);
        } else {
          this._result[i] = value;
        }
      }

      if (this._remaining === 0) {
        fulfill(promise, this._result);
      }
    };

    Enumerator.prototype._willSettleAt = function _willSettleAt(promise, i) {
      var enumerator = this;
      subscribe(promise, undefined, function (value) {
        return enumerator._settledAt(FULFILLED, i, value);
      }, function (reason) {
        return enumerator._settledAt(REJECTED, i, reason);
      });
    };

    return Enumerator;
  }();
  /**
    `Promise.all` accepts an array of promises, and returns a new promise which
    is fulfilled with an array of fulfillment values for the passed promises, or
    rejected with the reason of the first passed promise to be rejected. It casts all
    elements of the passed iterable to promises as it runs this algorithm.
  
    Example:
  
    ```javascript
    let promise1 = resolve(1);
    let promise2 = resolve(2);
    let promise3 = resolve(3);
    let promises = [ promise1, promise2, promise3 ];
  
    Promise.all(promises).then(function(array){
      // The array here would be [ 1, 2, 3 ];
    });
    ```
  
    If any of the `promises` given to `all` are rejected, the first promise
    that is rejected will be given as an argument to the returned promises's
    rejection handler. For example:
  
    Example:
  
    ```javascript
    let promise1 = resolve(1);
    let promise2 = reject(new Error("2"));
    let promise3 = reject(new Error("3"));
    let promises = [ promise1, promise2, promise3 ];
  
    Promise.all(promises).then(function(array){
      // Code here never runs because there are rejected promises!
    }, function(error) {
      // error.message === "2"
    });
    ```
  
    @method all
    @static
    @param {Array} entries array of promises
    @param {String} label optional string for labeling the promise.
    Useful for tooling.
    @return {Promise} promise that is fulfilled when all `promises` have been
    fulfilled, or rejected if any of them become rejected.
    @static
  */


  function all(entries) {
    return new Enumerator(this, entries).promise;
  }
  /**
    `Promise.race` returns a new promise which is settled in the same way as the
    first passed promise to settle.
  
    Example:
  
    ```javascript
    let promise1 = new Promise(function(resolve, reject){
      setTimeout(function(){
        resolve('promise 1');
      }, 200);
    });
  
    let promise2 = new Promise(function(resolve, reject){
      setTimeout(function(){
        resolve('promise 2');
      }, 100);
    });
  
    Promise.race([promise1, promise2]).then(function(result){
      // result === 'promise 2' because it was resolved before promise1
      // was resolved.
    });
    ```
  
    `Promise.race` is deterministic in that only the state of the first
    settled promise matters. For example, even if other promises given to the
    `promises` array argument are resolved, but the first settled promise has
    become rejected before the other promises became fulfilled, the returned
    promise will become rejected:
  
    ```javascript
    let promise1 = new Promise(function(resolve, reject){
      setTimeout(function(){
        resolve('promise 1');
      }, 200);
    });
  
    let promise2 = new Promise(function(resolve, reject){
      setTimeout(function(){
        reject(new Error('promise 2'));
      }, 100);
    });
  
    Promise.race([promise1, promise2]).then(function(result){
      // Code here never runs
    }, function(reason){
      // reason.message === 'promise 2' because promise 2 became rejected before
      // promise 1 became fulfilled
    });
    ```
  
    An example real-world use case is implementing timeouts:
  
    ```javascript
    Promise.race([ajax('foo.json'), timeout(5000)])
    ```
  
    @method race
    @static
    @param {Array} promises array of promises to observe
    Useful for tooling.
    @return {Promise} a promise which settles in the same way as the first passed
    promise to settle.
  */


  function race(entries) {
    /*jshint validthis:true */
    var Constructor = this;

    if (!isArray(entries)) {
      return new Constructor(function (_, reject) {
        return reject(new TypeError('You must pass an array to race.'));
      });
    } else {
      return new Constructor(function (resolve, reject) {
        var length = entries.length;

        for (var i = 0; i < length; i++) {
          Constructor.resolve(entries[i]).then(resolve, reject);
        }
      });
    }
  }
  /**
    `Promise.reject` returns a promise rejected with the passed `reason`.
    It is shorthand for the following:
  
    ```javascript
    let promise = new Promise(function(resolve, reject){
      reject(new Error('WHOOPS'));
    });
  
    promise.then(function(value){
      // Code here doesn't run because the promise is rejected!
    }, function(reason){
      // reason.message === 'WHOOPS'
    });
    ```
  
    Instead of writing the above, your code now simply becomes the following:
  
    ```javascript
    let promise = Promise.reject(new Error('WHOOPS'));
  
    promise.then(function(value){
      // Code here doesn't run because the promise is rejected!
    }, function(reason){
      // reason.message === 'WHOOPS'
    });
    ```
  
    @method reject
    @static
    @param {Any} reason value that the returned promise will be rejected with.
    Useful for tooling.
    @return {Promise} a promise rejected with the given `reason`.
  */


  function reject$1(reason) {
    /*jshint validthis:true */
    var Constructor = this;
    var promise = new Constructor(noop);
    reject(promise, reason);
    return promise;
  }

  function needsResolver() {
    throw new TypeError('You must pass a resolver function as the first argument to the promise constructor');
  }

  function needsNew() {
    throw new TypeError("Failed to construct 'Promise': Please use the 'new' operator, this object constructor cannot be called as a function.");
  }
  /**
    Promise objects represent the eventual result of an asynchronous operation. The
    primary way of interacting with a promise is through its `then` method, which
    registers callbacks to receive either a promise's eventual value or the reason
    why the promise cannot be fulfilled.
  
    Terminology
    -----------
  
    - `promise` is an object or function with a `then` method whose behavior conforms to this specification.
    - `thenable` is an object or function that defines a `then` method.
    - `value` is any legal JavaScript value (including undefined, a thenable, or a promise).
    - `exception` is a value that is thrown using the throw statement.
    - `reason` is a value that indicates why a promise was rejected.
    - `settled` the final resting state of a promise, fulfilled or rejected.
  
    A promise can be in one of three states: pending, fulfilled, or rejected.
  
    Promises that are fulfilled have a fulfillment value and are in the fulfilled
    state.  Promises that are rejected have a rejection reason and are in the
    rejected state.  A fulfillment value is never a thenable.
  
    Promises can also be said to *resolve* a value.  If this value is also a
    promise, then the original promise's settled state will match the value's
    settled state.  So a promise that *resolves* a promise that rejects will
    itself reject, and a promise that *resolves* a promise that fulfills will
    itself fulfill.
  
  
    Basic Usage:
    ------------
  
    ```js
    let promise = new Promise(function(resolve, reject) {
      // on success
      resolve(value);
  
      // on failure
      reject(reason);
    });
  
    promise.then(function(value) {
      // on fulfillment
    }, function(reason) {
      // on rejection
    });
    ```
  
    Advanced Usage:
    ---------------
  
    Promises shine when abstracting away asynchronous interactions such as
    `XMLHttpRequest`s.
  
    ```js
    function getJSON(url) {
      return new Promise(function(resolve, reject){
        let xhr = new XMLHttpRequest();
  
        xhr.open('GET', url);
        xhr.onreadystatechange = handler;
        xhr.responseType = 'json';
        xhr.setRequestHeader('Accept', 'application/json');
        xhr.send();
  
        function handler() {
          if (this.readyState === this.DONE) {
            if (this.status === 200) {
              resolve(this.response);
            } else {
              reject(new Error('getJSON: `' + url + '` failed with status: [' + this.status + ']'));
            }
          }
        };
      });
    }
  
    getJSON('/posts.json').then(function(json) {
      // on fulfillment
    }, function(reason) {
      // on rejection
    });
    ```
  
    Unlike callbacks, promises are great composable primitives.
  
    ```js
    Promise.all([
      getJSON('/posts'),
      getJSON('/comments')
    ]).then(function(values){
      values[0] // => postsJSON
      values[1] // => commentsJSON
  
      return values;
    });
    ```
  
    @class Promise
    @param {Function} resolver
    Useful for tooling.
    @constructor
  */


  var Promise$1 = function () {
    function Promise(resolver) {
      this[PROMISE_ID] = nextId();
      this._result = this._state = undefined;
      this._subscribers = [];

      if (noop !== resolver) {
        typeof resolver !== 'function' && needsResolver();
        this instanceof Promise ? initializePromise(this, resolver) : needsNew();
      }
    }
    /**
    The primary way of interacting with a promise is through its `then` method,
    which registers callbacks to receive either a promise's eventual value or the
    reason why the promise cannot be fulfilled.
     ```js
    findUser().then(function(user){
      // user is available
    }, function(reason){
      // user is unavailable, and you are given the reason why
    });
    ```
     Chaining
    --------
     The return value of `then` is itself a promise.  This second, 'downstream'
    promise is resolved with the return value of the first promise's fulfillment
    or rejection handler, or rejected if the handler throws an exception.
     ```js
    findUser().then(function (user) {
      return user.name;
    }, function (reason) {
      return 'default name';
    }).then(function (userName) {
      // If `findUser` fulfilled, `userName` will be the user's name, otherwise it
      // will be `'default name'`
    });
     findUser().then(function (user) {
      throw new Error('Found user, but still unhappy');
    }, function (reason) {
      throw new Error('`findUser` rejected and we're unhappy');
    }).then(function (value) {
      // never reached
    }, function (reason) {
      // if `findUser` fulfilled, `reason` will be 'Found user, but still unhappy'.
      // If `findUser` rejected, `reason` will be '`findUser` rejected and we're unhappy'.
    });
    ```
    If the downstream promise does not specify a rejection handler, rejection reasons will be propagated further downstream.
     ```js
    findUser().then(function (user) {
      throw new PedagogicalException('Upstream error');
    }).then(function (value) {
      // never reached
    }).then(function (value) {
      // never reached
    }, function (reason) {
      // The `PedgagocialException` is propagated all the way down to here
    });
    ```
     Assimilation
    ------------
     Sometimes the value you want to propagate to a downstream promise can only be
    retrieved asynchronously. This can be achieved by returning a promise in the
    fulfillment or rejection handler. The downstream promise will then be pending
    until the returned promise is settled. This is called *assimilation*.
     ```js
    findUser().then(function (user) {
      return findCommentsByAuthor(user);
    }).then(function (comments) {
      // The user's comments are now available
    });
    ```
     If the assimliated promise rejects, then the downstream promise will also reject.
     ```js
    findUser().then(function (user) {
      return findCommentsByAuthor(user);
    }).then(function (comments) {
      // If `findCommentsByAuthor` fulfills, we'll have the value here
    }, function (reason) {
      // If `findCommentsByAuthor` rejects, we'll have the reason here
    });
    ```
     Simple Example
    --------------
     Synchronous Example
     ```javascript
    let result;
     try {
      result = findResult();
      // success
    } catch(reason) {
      // failure
    }
    ```
     Errback Example
     ```js
    findResult(function(result, err){
      if (err) {
        // failure
      } else {
        // success
      }
    });
    ```
     Promise Example;
     ```javascript
    findResult().then(function(result){
      // success
    }, function(reason){
      // failure
    });
    ```
     Advanced Example
    --------------
     Synchronous Example
     ```javascript
    let author, books;
     try {
      author = findAuthor();
      books  = findBooksByAuthor(author);
      // success
    } catch(reason) {
      // failure
    }
    ```
     Errback Example
     ```js
     function foundBooks(books) {
     }
     function failure(reason) {
     }
     findAuthor(function(author, err){
      if (err) {
        failure(err);
        // failure
      } else {
        try {
          findBoooksByAuthor(author, function(books, err) {
            if (err) {
              failure(err);
            } else {
              try {
                foundBooks(books);
              } catch(reason) {
                failure(reason);
              }
            }
          });
        } catch(error) {
          failure(err);
        }
        // success
      }
    });
    ```
     Promise Example;
     ```javascript
    findAuthor().
      then(findBooksByAuthor).
      then(function(books){
        // found books
    }).catch(function(reason){
      // something went wrong
    });
    ```
     @method then
    @param {Function} onFulfilled
    @param {Function} onRejected
    Useful for tooling.
    @return {Promise}
    */

    /**
    `catch` is simply sugar for `then(undefined, onRejection)` which makes it the same
    as the catch block of a try/catch statement.
    ```js
    function findAuthor(){
    throw new Error('couldn't find that author');
    }
    // synchronous
    try {
    findAuthor();
    } catch(reason) {
    // something went wrong
    }
    // async with promises
    findAuthor().catch(function(reason){
    // something went wrong
    });
    ```
    @method catch
    @param {Function} onRejection
    Useful for tooling.
    @return {Promise}
    */


    Promise.prototype.catch = function _catch(onRejection) {
      return this.then(null, onRejection);
    };
    /**
      `finally` will be invoked regardless of the promise's fate just as native
      try/catch/finally behaves
    
      Synchronous example:
    
      ```js
      findAuthor() {
        if (Math.random() > 0.5) {
          throw new Error();
        }
        return new Author();
      }
    
      try {
        return findAuthor(); // succeed or fail
      } catch(error) {
        return findOtherAuther();
      } finally {
        // always runs
        // doesn't affect the return value
      }
      ```
    
      Asynchronous example:
    
      ```js
      findAuthor().catch(function(reason){
        return findOtherAuther();
      }).finally(function(){
        // author was either found, or not
      });
      ```
    
      @method finally
      @param {Function} callback
      @return {Promise}
    */


    Promise.prototype.finally = function _finally(callback) {
      var promise = this;
      var constructor = promise.constructor;

      if (isFunction(callback)) {
        return promise.then(function (value) {
          return constructor.resolve(callback()).then(function () {
            return value;
          });
        }, function (reason) {
          return constructor.resolve(callback()).then(function () {
            throw reason;
          });
        });
      }

      return promise.then(callback, callback);
    };

    return Promise;
  }();

  Promise$1.prototype.then = then;
  Promise$1.all = all;
  Promise$1.race = race;
  Promise$1.resolve = resolve$1;
  Promise$1.reject = reject$1;
  Promise$1._setScheduler = setScheduler;
  Promise$1._setAsap = setAsap;
  Promise$1._asap = asap;
  /*global self*/

  function polyfill() {
    var local = void 0;

    if (typeof global !== 'undefined') {
      local = global;
    } else if (typeof self !== 'undefined') {
      local = self;
    } else {
      try {
        local = Function('return this')();
      } catch (e) {
        throw new Error('polyfill failed because global object is unavailable in this environment');
      }
    }

    var P = local.Promise;

    if (P) {
      var promiseToString = null;

      try {
        promiseToString = Object.prototype.toString.call(P.resolve());
      } catch (e) {// silently ignored
      }

      if (promiseToString === '[object Promise]' && !P.cast) {
        return;
      }
    }

    local.Promise = Promise$1;
  } // Strange compat..


  Promise$1.polyfill = polyfill;
  Promise$1.Promise = Promise$1;
  return Promise$1;
});
/* WEBPACK VAR INJECTION */}.call(this, __webpack_require__(/*! ./../../process/browser.js */ "./node_modules/process/browser.js"), __webpack_require__(/*! ./../../webpack/buildin/global.js */ "./node_modules/webpack/buildin/global.js")))

/***/ }),

/***/ "./node_modules/process/browser.js":
/*!*****************************************!*\
  !*** ./node_modules/process/browser.js ***!
  \*****************************************/
/*! no static exports found */
/***/ (function(module, exports) {

// shim for using process in browser
var process = module.exports = {}; // cached from whatever global is present so that test runners that stub it
// don't break things.  But we need to wrap it in a try catch in case it is
// wrapped in strict mode code which doesn't define any globals.  It's inside a
// function because try/catches deoptimize in certain engines.

var cachedSetTimeout;
var cachedClearTimeout;

function defaultSetTimout() {
  throw new Error('setTimeout has not been defined');
}

function defaultClearTimeout() {
  throw new Error('clearTimeout has not been defined');
}

(function () {
  try {
    if (typeof setTimeout === 'function') {
      cachedSetTimeout = setTimeout;
    } else {
      cachedSetTimeout = defaultSetTimout;
    }
  } catch (e) {
    cachedSetTimeout = defaultSetTimout;
  }

  try {
    if (typeof clearTimeout === 'function') {
      cachedClearTimeout = clearTimeout;
    } else {
      cachedClearTimeout = defaultClearTimeout;
    }
  } catch (e) {
    cachedClearTimeout = defaultClearTimeout;
  }
})();

function runTimeout(fun) {
  if (cachedSetTimeout === setTimeout) {
    //normal enviroments in sane situations
    return setTimeout(fun, 0);
  } // if setTimeout wasn't available but was latter defined


  if ((cachedSetTimeout === defaultSetTimout || !cachedSetTimeout) && setTimeout) {
    cachedSetTimeout = setTimeout;
    return setTimeout(fun, 0);
  }

  try {
    // when when somebody has screwed with setTimeout but no I.E. maddness
    return cachedSetTimeout(fun, 0);
  } catch (e) {
    try {
      // When we are in I.E. but the script has been evaled so I.E. doesn't trust the global object when called normally
      return cachedSetTimeout.call(null, fun, 0);
    } catch (e) {
      // same as above but when it's a version of I.E. that must have the global object for 'this', hopfully our context correct otherwise it will throw a global error
      return cachedSetTimeout.call(this, fun, 0);
    }
  }
}

function runClearTimeout(marker) {
  if (cachedClearTimeout === clearTimeout) {
    //normal enviroments in sane situations
    return clearTimeout(marker);
  } // if clearTimeout wasn't available but was latter defined


  if ((cachedClearTimeout === defaultClearTimeout || !cachedClearTimeout) && clearTimeout) {
    cachedClearTimeout = clearTimeout;
    return clearTimeout(marker);
  }

  try {
    // when when somebody has screwed with setTimeout but no I.E. maddness
    return cachedClearTimeout(marker);
  } catch (e) {
    try {
      // When we are in I.E. but the script has been evaled so I.E. doesn't  trust the global object when called normally
      return cachedClearTimeout.call(null, marker);
    } catch (e) {
      // same as above but when it's a version of I.E. that must have the global object for 'this', hopfully our context correct otherwise it will throw a global error.
      // Some versions of I.E. have different rules for clearTimeout vs setTimeout
      return cachedClearTimeout.call(this, marker);
    }
  }
}

var queue = [];
var draining = false;
var currentQueue;
var queueIndex = -1;

function cleanUpNextTick() {
  if (!draining || !currentQueue) {
    return;
  }

  draining = false;

  if (currentQueue.length) {
    queue = currentQueue.concat(queue);
  } else {
    queueIndex = -1;
  }

  if (queue.length) {
    drainQueue();
  }
}

function drainQueue() {
  if (draining) {
    return;
  }

  var timeout = runTimeout(cleanUpNextTick);
  draining = true;
  var len = queue.length;

  while (len) {
    currentQueue = queue;
    queue = [];

    while (++queueIndex < len) {
      if (currentQueue) {
        currentQueue[queueIndex].run();
      }
    }

    queueIndex = -1;
    len = queue.length;
  }

  currentQueue = null;
  draining = false;
  runClearTimeout(timeout);
}

process.nextTick = function (fun) {
  var args = new Array(arguments.length - 1);

  if (arguments.length > 1) {
    for (var i = 1; i < arguments.length; i++) {
      args[i - 1] = arguments[i];
    }
  }

  queue.push(new Item(fun, args));

  if (queue.length === 1 && !draining) {
    runTimeout(drainQueue);
  }
}; // v8 likes predictible objects


function Item(fun, array) {
  this.fun = fun;
  this.array = array;
}

Item.prototype.run = function () {
  this.fun.apply(null, this.array);
};

process.title = 'browser';
process.browser = true;
process.env = {};
process.argv = [];
process.version = ''; // empty string to avoid regexp issues

process.versions = {};

function noop() {}

process.on = noop;
process.addListener = noop;
process.once = noop;
process.off = noop;
process.removeListener = noop;
process.removeAllListeners = noop;
process.emit = noop;
process.prependListener = noop;
process.prependOnceListener = noop;

process.listeners = function (name) {
  return [];
};

process.binding = function (name) {
  throw new Error('process.binding is not supported');
};

process.cwd = function () {
  return '/';
};

process.chdir = function (dir) {
  throw new Error('process.chdir is not supported');
};

process.umask = function () {
  return 0;
};

/***/ }),

/***/ "./node_modules/webpack/buildin/global.js":
/*!***********************************!*\
  !*** (webpack)/buildin/global.js ***!
  \***********************************/
/*! no static exports found */
/***/ (function(module, exports) {

function _typeof(obj) { if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

var g; // This works in non-strict mode

g = function () {
  return this;
}();

try {
  // This works if eval is allowed (see CSP)
  g = g || new Function("return this")();
} catch (e) {
  // This works if the window reference is available
  if ((typeof window === "undefined" ? "undefined" : _typeof(window)) === "object") g = window;
} // g can still be undefined, but nothing to do about it...
// We return undefined, instead of nothing here, so it's
// easier to handle this case. if(!global) { ...}


module.exports = g;

/***/ }),

/***/ "./scss/gutenberg-style.scss":
/*!***********************************!*\
  !*** ./scss/gutenberg-style.scss ***!
  \***********************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ "./scss/material-icons.scss":
/*!**********************************!*\
  !*** ./scss/material-icons.scss ***!
  \**********************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ "./scss/style.scss":
/*!*************************!*\
  !*** ./scss/style.scss ***!
  \*************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ "./scss/woocommerce.scss":
/*!*******************************!*\
  !*** ./scss/woocommerce.scss ***!
  \*******************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ 0:
/*!****************************************************************************************************************************!*\
  !*** multi ./js/theme.js ./scss/style.scss ./scss/gutenberg-style.scss ./scss/woocommerce.scss ./scss/material-icons.scss ***!
  \****************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! /var/lib/jenkins/workspace/Materialis FREE Release/build-materialis/materialis/dev/js/theme.js */"./js/theme.js");
__webpack_require__(/*! /var/lib/jenkins/workspace/Materialis FREE Release/build-materialis/materialis/dev/scss/style.scss */"./scss/style.scss");
__webpack_require__(/*! /var/lib/jenkins/workspace/Materialis FREE Release/build-materialis/materialis/dev/scss/gutenberg-style.scss */"./scss/gutenberg-style.scss");
__webpack_require__(/*! /var/lib/jenkins/workspace/Materialis FREE Release/build-materialis/materialis/dev/scss/woocommerce.scss */"./scss/woocommerce.scss");
module.exports = __webpack_require__(/*! /var/lib/jenkins/workspace/Materialis FREE Release/build-materialis/materialis/dev/scss/material-icons.scss */"./scss/material-icons.scss");


/***/ })

/******/ });
//# sourceMappingURL=theme.js.map
