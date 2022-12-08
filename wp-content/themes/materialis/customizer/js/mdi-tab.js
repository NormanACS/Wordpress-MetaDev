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
    })();


    var cpMDIIconModel = Backbone.Model.extend({
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
            mime: "fa-icon/font",
            dateFormatted: null,
            height: null,
            width: null,
            orientation: null,
            filesizeInBytes: null,
            filesizeHumanReadable: null,
            size: {
                url: null
            },
            type: "fa-icon",
            icon: null
        }
    });


    var cpMdiIcons = Backbone.Collection.extend({
        model: cpMDIIconModel,
        initialize: function (data) {
            this.url = parent.ajaxurl + "?action=materialis_list_mdi"
        },
        parse: function (data) {
            return data;
        }
    });


    var cachedIconsCollection = new cpMdiIcons();
    var iconsViewInstance;
    cachedIconsCollection.fetch({
        success: function (icons) {
            if (!fetchedIcons) {
                fetchedIcons = icons;
            }
        }
    });

    var iconTemplate = _.template('' +
        '<div class="attachment-preview js--select-attachment type-image subtype-jpeg landscape">' +
        '<div class="thumbnail">' +
        '<i class="mdi <%= mdi %>" aria-hidden="true"></i>' +
        '<div class="label"><%= title %></div>' +
        '</div>' +
        '<button type="button" class="button-link check" tabindex="0"><span class="media-modal-icon"></span><span class="screen-reader-text">' + materialis_customize_settings.l10n.deselect + '</span></button>' +
        '</div>');


    var cpMdiIconView = wp.media.view.Attachment.extend({
        tagName: "li",
        className: "attachment cp-mdi-image",
        template: iconTemplate,
        controller: this.controller,
        initialize: function () {
            this.render()
        },

        attributes: function () {
            return {
                'data-search': this.model.get('mdi').replace('mdi-', '').trim(),
                'aria-label': this.model.get('title'),
                'title': this.model.get('title'),
                'tabIndex': 0,
            }
        },
        events: {
            "click .js--select-attachment": "toggleSelectionHandler"
        },
        render: function () {
            var icon = this.model.get('mdi');
            var title = this.model.get('title');
            this.$el.html(this.template({
                'mdi': icon,
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

            $('.media-selection.one .attachment-preview.type-mdi-icon .thumbnail').html('<i class="mdi-preview-icon mdi ' + this.model.get('mdi') + '"></i>')

            this.controller.trigger('selection:toggle');
        }
    });


    var cpMdiIconsView = wp.media.View.extend({
        tagName: "ul",
        className: "attachments cp-mdi-images",
        attributes: {
            tabIndex: 0
        },
        perPage: 50,
        currentPage: 1,
        filter: '',
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
            var self = this;
            $(this.options.scrollElement).on("scroll", function (event) {
                if ($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight) {
                    self.scrolledToBottom(event);
                }

            });

            iconsViewInstance = this;

            this.renderPage(1);
        },

        getItems: function () {
            var filterValue = this.filter;
            return this.collection.filter(function (item) {
                return fuzzy_match(item.get('title'), filterValue);
            })
        },

        setFilter: function (filter) {
            this.filter = filter;
        },

        renderPage: function (page) {
            var startFrom = (page - 1) * this.perPage;
            for (var i = 0; i < this.perPage; i++) {
                var icon = this.getItems()[startFrom + i];

                if (icon) {
                    var iconView = new cpMdiIconView({
                        controller: iconsViewInstance.controller,
                        selection: iconsViewInstance.options.selection,
                        model: icon
                    });
                    iconsViewInstance.views.add(iconView)
                }
            }
        },

        startAgain: function () {
            this.currentPage = 1;
            this.$el.empty();
            this.renderPage(1);
        },

        scrolledToBottom: function (event) {
            if (this.collection.length > this.currentPage * this.perPage) {
                this.currentPage += 1;
                this.renderPage(this.currentPage);
            }
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
            iconsViewInstance.setFilter(event.target.value);
            iconsViewInstance.startAgain(1);
        }, 100)
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

            var icons = cachedIconsCollection;


            function displayIcons(icons) {
                var state = browserVIew.controller.state(),
                    selection = state.get('selection');
                state.set('multiple', true);
                selection.multiple = false;
                var iconsView = new cpMdiIconsView({
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


    function extendFrameWithCPMDI(frame) {

        var wpMediaFrame = frame;
        var cpMdiFrameExtension = {
            browseRouter: function (routerView) {
                var routes = {

                    "cp_material_icons": {
                        text: materialis_customize_settings.l10n.chooseMDILabel,
                        priority: 50
                    }
                };
                controller = routerView.controller;
                routerView.set(routes);
            },

            bindHandlers: function () {

                wpMediaFrame.prototype.bindHandlers.apply(this, arguments);
                this.on('content:create:cp_material_icons', this.cpBrowseMaterialIcons, this);
            },

            createStates: function () {
                wpMediaFrame.prototype.createStates.apply(this, arguments);
            },


            cpBrowseMaterialIcons: function (contentRegion) {

                var state = this.state();

                this.$el.removeClass('hide-toolbar');

                contentRegion.view = new cpMaterialIconsBrowser({
                    controller: this
                });
            }

        }

        return wpMediaFrame.extend(cpMdiFrameExtension);
    }

    wp.media.cp = wp.media.cp || {};
    if (!wp.media.cp.extendFrameWithMDI) {
        wp.media.cp.extendFrameWithMDI = extendFrameWithCPMDI;
    }
})(jQuery);
