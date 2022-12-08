(function (root, $) {

    // used for lazy loading images ( show make the customizer available faster )
    $(function () {
        $('img[data-src]').each(function () {
            var img = this;
            setTimeout(function () {
                img.setAttribute('src', img.getAttribute('data-src'));
            }, 5)
        });
    });

    function updateLinkedSettings(newValue) {

        var toUpdate = {};

        for (var i = 0; i < this.update.length; i++) {
            var update = this.update[i];

            if (update.value === newValue) {
                _.extend(toUpdate, update.fields);
            }

        }

        var refreshAfterSet = (this.__initialTransport === 'refresh');
        for (var settingID in toUpdate) {
            var setting = wp.customize(settingID);

            if (setting) {
                var oldTransport = setting.transport;

                setting.transport = 'postMessage';
                kirkiSetSettingValue(settingID, toUpdate[settingID]);
                setting.transport = oldTransport;

                if (oldTransport === 'refresh') {
                    refreshAfterSet = true;
                }
            }
        }

        if (refreshAfterSet) {
            wp.customize.previewer.refresh();
        }

    }

    if (!root.Materialis) {
        root.Materialis = {

            Utils: {
                getGradientString: function (colors, angle) {
                    var gradient = angle + "deg, " + colors[0].color + " 0%, " + colors[1].color + " 100%";
                    gradient = 'linear-gradient(' + gradient + ')';
                    return gradient;
                },

                getValue: function (component) {
                    var value = undefined;

                    if (component instanceof wp.customize.Control) {
                        value = component.setting.get();
                    }

                    if (component instanceof wp.customize.Setting) {
                        value = component.get();
                    }

                    if (_.isString(component)) {
                        value = wp.customize(component).get();
                    }

                    if (_.isString(value)) {

                        try {
                            value = decodeURI(value);

                        } catch (e) {

                        }

                        try {
                            value = JSON.parse(value);
                        } catch (e) {

                        }

                    }

                    return value;
                }
            },

            hooks: {
                addAction: function () {},
                addFilter: function () {},
                doAction: function () {

                },
                applyFilters: function () {

                }
            },

            wpApi: root.wp.customize,

            closePopUps: function () {
                root.tb_remove();
                root.jQuery('#TB_overlay').css({
                    'z-index': '-1'
                });
            },

            options: function (optionName) {
                return root.materialis_customize_settings[optionName];
            },

            popUp: function (title, elementID, data) {
                var selector = "#TB_inline?inlineId=" + elementID;
                var query = [];


                $.each(data || {}, function (key, value) {
                    query.push(key + "=" + value);
                });

                selector = query.length ? selector + "&" : selector + "";
                selector += query.join("&");

                root.tb_show(title, selector);

                root.jQuery('#TB_window').css({
                    'z-index': '5000001',
                    'transform': 'opacity .4s',
                    'opacity': 0
                });

                root.jQuery('#TB_overlay').css({
                    'z-index': '5000000'
                });


                setTimeout(function () {
                    root.jQuery('#TB_window').css({
                        'margin-top': -1 * ((root.jQuery('#TB_window').outerHeight() + 50) / 2),
                        'opacity': 1
                    });
                    root.jQuery('#TB_window').find('#cp-item-ok').focus();
                }, 0);

                if (data && data.class) {
                    root.jQuery('#TB_window').addClass(data.class);
                }

                return root.jQuery('#TB_window');
            },

            addModule: function (callback) {
                var self = this;

                jQuery(document).ready(function () {
                    // this.__modules.push(callback);
                    callback(self);
                });

            },
            getCustomizerRootEl: function () {
                return root.jQuery(root.document.body).find('form#customize-controls');
            },
            openRightSidebar: function (elementId, options) {
                options = options || {};
                this.hideRightSidebar();
                var $form = this.getCustomizerRootEl();
                var self = this;
                var $container = $form.find('#' + elementId + '-popup');
                if ($container.length) {
                    $container.addClass('active');

                    if (options.floating && !_(options.y).isUndefined()) {
                        $container.css({
                            top: options.y
                        });
                    }
                } else {
                    $container = $('<li id="' + elementId + '-popup" class="customizer-right-section active"> <span data-close-right-sidebar="true" title="' + materialis_customize_settings.l10n.closePanelLabel + '" class="close-panel"></span> </li>');

                    if (options.floating) {
                        $container.addClass('floating');
                    }

                    $toAppend = $form.find('li#accordion-section-' + elementId + ' > ul');

                    if ($toAppend.length === 0) {
                        $toAppend = $form.find('#sub-accordion-section-' + elementId);
                    }


                    if ($toAppend.length === 0) {
                        $toAppend = $('<div class="control-wrapper" />');
                        $toAppend.append($form.find('#customize-control-' + elementId).children());
                    }

                    $form.append($container);
                    $container.append($toAppend);

                    if (options.floating && !_(options.y).isUndefined()) {
                        $container.css({
                            top: options.y
                        });
                    }


                    $container.find('span.close-panel').click(self.hideRightSidebar);

                }

                if (options.focus) {
                    $container.find(options.focus)[0].scrollIntoViewIfNeeded();
                }

                $container.css('left', jQuery('#customize-header-actions')[0].offsetWidth + 1);

                self.hooks.doAction('right_sidebar_opened', elementId, options, $container);

                $container.on('focus', function (event) {
                    event.preventDefault();
                    event.stopPropagation();
                    return false;
                });

                $form.find('span[data-close-right-sidebar="true"]').click(function (event) {
                    event.preventDefault();
                    event.stopPropagation();
                    self.hideRightSidebar();
                });

                $form.find('li.accordion-section').unbind('click.right-section').bind('click.right-section', function (event) {
                    if ($(event.target).is('li') || $(event.target).is('.accordion-section-title')) {
                        if ($(event.target).closest('.customizer-right-section').length === 0) {
                            self.hideRightSidebar();
                        }
                    }
                });

            },

            hideRightSidebar: function () {
                var $form = root.jQuery(root.document.body).find('#customize-controls');
                var $visibleSection = $form.find('.customizer-right-section.active');
                if ($visibleSection.length) {
                    $visibleSection.removeClass('active');
                }
            },

            linkMod: function (settingID, linkWith) {
                var setting = wp.customize(settingID);
                // debugger;
                if (setting) {
                    var options = setting.findControls().length ? jQuery.extend(true, {}, setting.findControls()) : {};
                    options.__initialTransport = setting.transport;
                    options.update = linkWith;

                    var updater = _.bind(updateLinkedSettings, options);
                    setting.transport = 'postMessage';
                    setting.bind(updater);
                }
            },

            createMod: function (name, transport) {
                if (wp.customize(name)) {
                    return wp.customize(name);
                }

                name = "CP_AUTO_SETTING[" + name + "]";
                if (wp.customize(name)) {
                    return wp.customize(name);
                }

                wp.customize.create(name, name, {}, {
                    type: 'theme_mod',
                    transport: transport || 'postMessage',
                    previewer: wp.customize.previewer
                });

                return wp.customize(name);
            },

            _canUpdatedLinkedOptions: true,

            canUpdatedLinkedOptions: function () {
                return this._canUpdatedLinkedOptions;
            },

            disableLinkedOptionsUpdater: function () {
                this._canUpdatedLinkedOptions = false;
            },

            enableLinkedOptionsUpdater: function () {
                this._canUpdatedLinkedOptions = true;
            }

        };
    }

    function openMediaBrowser(type, callback, data) {
        var cb;
        if (callback instanceof jQuery) {
            cb = function (response) {

                if (!response) {
                    return;
                }

                var value = response[0].url;
                if (data !== "multiple") {
                    if (type == "icon") {
                        value = response[0].mdi
                    }
                    callback.val(value).trigger('change');
                }
            }
        } else {
            cb = callback;
        }

        switch (type) {
            case "image":
                openMultiImageManager(materialis_customize_settings.l10n.changeImageLabel, cb, data);
                break;
        }
    }

    function openMediaCustomFrame(extender, mode, title, single, callback) {
        var interestWindow = window.parent;

        var frame = extender(interestWindow.wp.media.view.MediaFrame.Select);

        var custom_uploader = new frame({
            title: title,
            button: {
                text: title
            },
            multiple: !single
        });


        //When a file is selected, grab the URL and set it as the text field's value
        custom_uploader.on('select', function () {
            attachment = custom_uploader.state().get('selection').toJSON();
            custom_uploader.content.mode('browse');
            callback(attachment);
        });


        custom_uploader.on('close', function () {
            custom_uploader.content.mode('browse');
            callback(false);
        });

        //Open the uploader dialog
        custom_uploader.open();
        custom_uploader.content.mode(mode);
        // Show Dialog over layouts frame
        interestWindow.jQuery(custom_uploader.views.selector).parent().css({
            'z-index': '16000000'
        });

    }

    function openMultiImageManager(title, callback, single) {
        var node = false;
        var interestWindow = window.parent;
        var custom_uploader = interestWindow.wp.media.frames.file_frame = interestWindow.wp.media({
            title: title,
            button: {
                text: materialis_customize_settings.l10n.chooseImagesLabel
            },
            multiple: !single
        });
        //When a file is selected, grab the URL and set it as the text field's value
        custom_uploader.on('select', function () {
            attachment = custom_uploader.state().get('selection').toJSON();
            callback(attachment);
        });
        custom_uploader.off('close.cp').on('close.cp', function () {
            callback(false);
        });
        //Open the uploader dialog
        custom_uploader.open();

        custom_uploader.content.mode('browse');
        // Show Dialog over layouts frame
        interestWindow.jQuery(interestWindow.wp.media.frame.views.selector).parent().css({
            'z-index': '16000000'
        });
    }

    root.Materialis.openMediaBrowser = openMediaBrowser;
    root.Materialis.openMediaCustomFrame = openMediaCustomFrame;

    if (window.wp && window.wp.customize) {
        wp.customize.controlConstructor['radio-html'] = wp.customize.Control.extend({

            ready: function () {

                'use strict';

                var control = this;

                // Change the value
                this.container.on('click', 'input', function () {
                    control.setting.set(jQuery(this).val());
                });

            }

        });
    }

    var linkedSettingsBindAdded = false;

    wp.customize.bind('pane-contents-reflowed', function () {

        if (linkedSettingsBindAdded) {
            return;
        }

        linkedSettingsBindAdded = true;

        jQuery.each(wp.customize.settings.controls, function (control, options) {

            if (options.update && Materialis.canUpdatedLinkedOptions()) {
                var setting = wp.customize(options.settings.default);
                // debugger;
                options.__initialTransport = setting.transport;

                var updater = _.bind(updateLinkedSettings, options);
                setting.transport = 'postMessage';
                setting.bind(updater);
            }
        });

        var overlappableSetting = Materialis.createMod('header_overlappable_section');

        overlappableSetting.bind(function (value) {
            if (CP_Customizer && value) {

                if (!CP_Customizer.wpApi('header_overlap').get()) {
                    return;
                }

                var sectionData = CP_Customizer.options('data:sections').filter(function (data) {
                    return data.id === value
                }).pop();

                if (sectionData && CP_Customizer.preview.jQuery('[data-id^="' + value + '"]').length === 0) {

                    CP_Customizer.one(CP_Customizer.events.PREVIEW_LOADED, function () {
                        CP_Customizer.preview.insertSectionFromData(sectionData);
                    });

                }
            }
            overlappableSetting.set('');
        });

    });

})(window, jQuery);

// fix selectize opening
(function ($) {

    $(document).on('mouseup', '.selectize-input', function () {
        if ($(this).parent().height() + $(this).parent().offset().top > window.innerHeight) {
            $('.wp-full-overlay-sidebar-content').scrollTop($(this).parent().height() + $(this).parent().offset().top)
        }
    });

    $(document).on('change', '.customize-control-kirki-select select', function () {
        $(this).focusout();
    });

})(jQuery);


(function (root, $, api) {
    var binded = false;
    wp.customize.bind('pane-contents-reflowed', function () {
        if (binded) {
            return;
        }

        binded = true;

        api.previewer.bind('focus-control-for-setting', function (settingId) {
            var matchedControls = [];
            api.control.each(function (control) {
                var settingIds = _.pluck(control.settings, 'id');
                if (-1 !== _.indexOf(settingIds, settingId)) {
                    matchedControls.push(control);
                }
            });

            if (matchedControls.length) {
                var control = matchedControls[0];
                var sidebar = control.container.closest('.customizer-right-section');
                if (sidebar.length) {
                    var buttonSelectorValue = sidebar.attr('id').replace('-popup', ''),
                        buttonSelector = '[data-sidebar-container="' + buttonSelectorValue + '"]';

                    if ($(buttonSelector).length) {
                        $(buttonSelector)[0].scrollIntoView();
                        $(buttonSelector).click();
                    }

                    control.focus();
                }
            }

        })
    })
})(window, jQuery, wp.customize);
(function ($) {
    var wp = window.wp.media ? window.wp : parent.wp;
    var fetchedIcons = false;


    var fuzzy_match = (function () {
        var cache = _.memoize(function (str) {
            return new RegExp("^" + str.replace(/./g, function (x) {
                return /[\-\[\]\/\{\}\(\)\*\+\?\.\\\^\$\|]/.test(x) ? "\\" + x + "?" : x + "?";
            }) + "$");
        })
        return function (str, pattern) {
            return cache(str).test(pattern)
        }
    })()

    var cpWebGradientsOptions = {};

    var cpWebGratientsIconModel = Backbone.Model.extend({
        defaults: {
            buttons: {
                check: !0
            },
            can: {
                save: !1,
                remove: !1
            },
            id: null,
            title: null,
            date: null,
            modified: null,
            mime: "web-gradient/class",
            dateFormatted: null,
            height: null,
            width: null,
            orientation: null,
            filesizeInBytes: null,
            filesizeHumanReadable: null,
            size: {
                url: null
            },
            type: "web-gradient",
            icon: null,
            parsed: false
        }
    });


    var cpWebGratientsIcons = Backbone.Collection.extend({
        model: cpWebGratientsIconModel,
        initialize: function (data) {
            this.url = parent.ajaxurl + "?action=materialis_webgradients_list"
        },
        parse: function (data) {
            return data;
        }
    });

    var iconTemplate = _.template(''+
            '<div class="attachment-preview js--select-attachment type-image subtype-jpeg landscape">'+
                '<div class="thumbnail">'+
                        '<div class="webgradient <%= webgradient %>" aria-hidden="true"></i>'+
                        '<div class="label"><%= title %></div>'+
                '</div>'+
                '<button type="button" class="button-link check" tabindex="0"><span class="media-modal-icon"></span><span class="screen-reader-text">' + materialis_customize_settings.l10n.deselect + '</span></button>'+
            '</div>');


    var cpWebGratientsIconView = wp.media.view.Attachment.extend({
        tagName: "li",
        className: "attachment webgradients-image",
        template: iconTemplate,
        controller: this.controller,
        initialize: function () {
            this.render()
        },

        attributes: function () {
            return {
                'data-search': this.model.get('gradient').trim(),
                'aria-label': this.model.get('title'),
                'title': this.model.get('title'),
                'tabIndex': 0,
            }
        },
        events: {
            "click .js--select-attachment": "toggleSelectionHandler"
        },
        render: function () {
            var icon = this.model.get('gradient');
            var title = this.model.get('title');
            this.$el.html(this.template({
                'webgradient': icon,
                'title': title
            }))
        },

        toggleSelectionHandler: function (event) {
            var method = 'toggle';

            // Catch arrow events
            if (37 === event.keyCode || 38 === event.keyCode || 39 === event.keyCode || 40 === event.keyCode) {
                this.controller.trigger('attachment:keydown:arrow', event);
                return;
            }

            // Catch enter and space events
            if ('keydown' === event.type && 13 !== event.keyCode && 32 !== event.keyCode) {
                return;
            }

            event.preventDefault();


            if (event.shiftKey) {
                method = 'between';
            } else if (event.ctrlKey || event.metaKey) {
                method = 'toggle';
            }

            this.toggleSelection({
                method: 'add'
            });

            $('.media-selection.one .attachment-preview.type-mdi-icon .thumbnail').html('<div class="webgradient ' + this.model.get('gredient') + '"></div>')

            this.controller.trigger('selection:toggle');
        }
    });


    var cpWebGratientsIconsView = wp.media.View.extend({
        tagName: "ul",
        className: "attachments cp-mdi-images",
        attributes: {
            tabIndex: 0
        },
        initialize: function () {

            _.defaults(this.options, {
                refreshSensitivity: wp.media.isTouchDevice ? 300 : 200,
                refreshThreshold: 3,
                AttachmentView: wp.media.view.Attachment,
                sortable: false,
                resize: false,
                idealColumnWidth: 150
            });

            this._viewsByCid = {};
            this.$window = $(window);
            this.options.scrollElement = this.options.scrollElement || this.el;
            $(this.options.scrollElement).on("scroll", this.scroll);

            var iconsView = this;
            iconsView.collection.each(function (icon) {
                var iconView = new cpWebGratientsIconView({
                    controller: iconsView.controller,
                    selection: iconsView.options.selection,
                    model: icon
                });
                iconsView.views.add(iconView)
            })
        },

        scroll: function () {

        }
    });

    var cpMaterialIconsSearch = wp.media.View.extend({
        tagName: "input",
        className: "search",
        id: "media-search-input cp-mdi-search",
        attributes: {
            type: "search",
            placeholder: wp.media.view.l10n.search
        },
        events: {
            input: "search",
            keyup: "search",
            change: "search",
            search: "search"
        },
        render: function () {
            return this;
        },

        search: _.debounce(function (event) {
            var value = event.target.value;
            var items = this.options.browserView.view.$el.find('li');

            function toggleSearchVisibility(index, el) {
                var $el = $(el);
                if (fuzzy_match($el.data('search'), value)) {
                    $el.show();
                } else {
                    $el.hide();
                }
            }
            items.each(toggleSearchVisibility);
        }, 50)
    });

    var cpMaterialIconsBrowser = wp.media.View.extend({
        tagName: "div",
        className: "cp-mdi-media attachments-browser",

        initialize: function () {

            var browserVIew = this;
            _.defaults(this.options, {
                filters: !1,
                search: true,
                date: false,
                display: !1,
                sidebar: false,
                toolbar: true,
                AttachmentView: wp.media.view.Attachment.Library
            });

            var icons = new cpWebGratientsIcons();
            var filter = this.options.options ? this.options.options.filter : false;

            function displayIcons(icons) {
                if (filter) {
                    icons = new cpWebGratientsIcons(icons.filter(filter));
                }

                var state = browserVIew.controller.state(),
                    selection = state.get('selection');
                state.set('multiple', false);
                selection.multiple = false;
                var iconsView = new cpWebGratientsIconsView({
                    controller: browserVIew.controller,
                    selection: selection,
                    collection: icons
                });
                browserVIew.views.add(iconsView)
            }


            if (!fetchedIcons) {
                icons.fetch({
                    success: function (icons) {
                        fetchedIcons = icons;
                        displayIcons(icons);
                    }
                });
            } else {
                displayIcons(fetchedIcons);
            }

            this.createToolbar();
        },

        settings: function (view) {
            if (this._settings) {
                this._settings.remove();
            }
            this._settings = view;
            this.views.add(view);
        },
        createToolbar: function () {
            this.toolbar = new wp.media.view.Toolbar({
                controller: this.controller
            })
            this.views.add(this.toolbar);
            this.toolbar.set("search", new cpMaterialIconsSearch({
                controller: this.controller,
                browserView: this.views
            }));
        }
    });


    function extendFrameWithcpWebGratients(frame) {
        var wpMediaFrame = frame;
        var cpWebGratientsFrameExtension = {
            browseRouter: function (routerView) {
                var routes = {
                    "cp_web_gradients": {
                        text: materialis_customize_settings.l10n.chooseGradientLabel,
                        priority: 50
                    }
                };
                controller = routerView.controller;
                routerView.set(routes);
            },

            bindHandlers: function () {
                wpMediaFrame.prototype.bindHandlers.apply(this, arguments);
                this.on('content:create:cp_web_gradients', this.cpBrowseMaterialIcons, this);
            },

            createStates: function () {
                wpMediaFrame.prototype.createStates.apply(this, arguments);
            },


            cpBrowseMaterialIcons: function (contentRegion) {

                var state = this.state();

                this.$el.removeClass('hide-toolbar');

                contentRegion.view = new cpMaterialIconsBrowser({
                    controller: this,
                    options : cpWebGradientsOptions
                });
            }

        }

        return wpMediaFrame.extend(cpWebGratientsFrameExtension);
    }

    wp.media.cp = wp.media.cp || {};
    if (!wp.media.cp.extendFrameWithWebGradients) {
        wp.media.cp.extendFrameWithWebGradients = function(options) {
            cpWebGradientsOptions = options;
            return extendFrameWithcpWebGratients
        };
    }
})(jQuery);

wp.customize.controlConstructor['web-gradients'] = wp.customize.Control.extend({

    ready: function () {

        'use strict';

        var control = this;

        // Change the value
        this.container.on('click', 'button, .webgradient-icon-preview .webgradient', function () {

            Materialis.openMediaCustomFrame(
                wp.media.cp.extendFrameWithWebGradients(),
                "cp_web_gradients",
                materialis_customize_settings.l10n.selectGradient,
                true,
                function (attachement) {

                    if (attachement && attachement[0]) {
                        control.setting.set(attachement[0].gradient);
                        control.container.find('.webgradient-icon-preview > div.webgradient').attr('class', 'webgradient ' + attachement[0].gradient);
                        control.container.find('.webgradient-icon-preview > div.webgradient + .label').text(attachement[0].gradient.replace(/_/ig, ' '));
                    }
                }
            )
        });

    }

});

(function (root, $) {
    wp.customize.controlConstructor['gradient-control'] = wp.customize.Control.extend({

        ready: function () {

            'use strict';

            var control = this;


            var val = this.getValue();

            this.container.on('click', 'button, .webgradient-icon-preview .webgradient', function () {
                Materialis.openMediaCustomFrame(
                    wp.media.cp.extendFrameWithWebGradients({
                        filter : function (icon) {
                            return icon.get("parsed") !== false;
                        }
                    }),
                    "cp_web_gradients",
                    materialis_customize_settings.l10n.selectGradient,
                    true,
                    function (attachement) {
                        if (attachement && attachement[0]) {
                            var toSet = attachement[0].parsed;
                            if (control.params.choices && control.params.choices['opacity']) {
                                toSet.colors = toSet.colors.map(function (colorData) {
                                    var _color = tinycolor(colorData.color);
                                    _color.setAlpha(control.params.choices['opacity']);
                                    colorData.color = _color.toRgbString();
                                    return colorData;
                                });
                            }
                            control.setValue(toSet);
                        }
                    }
                )
            });

        },

        getValue: function () {
            'use strict';

            // The setting is saved in JSON

            var value = [];

            if (_.isString(this.setting.get())) {
                value = JSON.parse(this.setting.get());
            } else {
                value = this.setting.get();
            }

            return value;
        },

        setValue: function (value, silent) {
            this.setting.set(JSON.stringify(value));
            this.update(value);
        },

        update: function(value) {
            this.container.find('.webgradient-icon-preview > div.webgradient').attr('style', "background:" + Materialis.Utils.getGradientString(value.colors, value.angle));
        }

    });

})(window, jQuery);

wp.customize.controlConstructor['sidebar-button-group'] = wp.customize.Control.extend({
    ready: function () {
        var control = this;
        var components = this.params.choices;
        var popupId = this.params.popup;
        var in_row_with = this.params.in_row_with || [];

        control.container.find('#group_customize-button-' + popupId).click(function () {

            if (window.CP_Customizer) {
                CP_Customizer.openRightSidebar(popupId);
            } else {
                Materialis.openRightSidebar(popupId);
            }
        });

        control.container.find('#' + popupId + '-popup > ul').on('focus', function (event) {
            return false;
        });

        wp.customize.bind('pane-contents-reflowed', function () {

            var holder = control.container.find('#' + popupId + '-popup > ul');


            var controls = [];


            _.each(components, function (c) {
                var _c = wp.customize.control(c);
                if (_c) {
                    controls.push(_c);
                }
            });

            /*
            controls = _.sortBy(controls, function(c) {
                return c.priority();
            });
           */


            _.each(controls, function (c) {
                holder.append(c.container);
            });


            if (in_row_with && in_row_with.length) {
                _.each(in_row_with, function (c) {
                    control.container.css({
                        "width": "calc(35% - 6px)",
                        "clear": "right",
                        "float": "right",
                    });

                    var ct = wp.customize.control(c);
                    if (ct) {
                        ct.container.css({
                            "width": "auto",
                            "max-width": "calc(65% - 6px)"
                        })
                    }
                })
            }

            var hasActiveItems = control.params.choices.map(function (setting) {
                return wp.customize.control(setting) ? wp.customize.control(setting).active() : false;
            }).reduce(function (a, b) {
                return a || b
            });

            if (control.params.always_active) {
                return;
            }

            if (control.active()) {
                if (hasActiveItems) {
                    control.activate();
                } else {
                    control.deactivate();
                }
            }
        });
    }
});
