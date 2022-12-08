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
