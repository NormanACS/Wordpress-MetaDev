(function (root, $) {

	function openMIManager(title, callback, single) {

		var frame = root.wp.media.cp.extendFrameWithMDI(root.wp.media.view.MediaFrame.Select);
		custom_uploader = new frame({
			title: title,
			button: {
				text: ficTexts.media_button_label
			},
			multiple: !single
		});
		root.wp.media.cp.MIFrame = custom_uploader;


		root.wp.media.cp.MIFrame.on('select', function () {
			attachment = custom_uploader.state().get('selection').toJSON();
			root.wp.media.cp.MIFrame.content.mode('browse');
			callback(attachment);
		});
		root.wp.media.cp.MIFrame.on('close', function () {
			root.wp.media.cp.MIFrame.content.mode('browse');
			callback(false);
		});


		root.wp.media.cp.MIFrame.open();
		root.wp.media.cp.MIFrame.content.mode('cp_material_icons');

		root.jQuery(custom_uploader.views.selector).parent().css({
			'z-index': '16000000'
		});

	}

	wp.customize.controlConstructor['material-icons-icon-control'] = wp.customize.Control.extend({

		ready: function () {

			'use strict';

			var control = this;

			// Change the value
			this.container.on('click', 'i.mdi , button', function () {
				openMIManager(ficTexts.media_title, function (response) {

					if (!response) {
						return;
					}
					var value = response[0].mdi;

					control.container.find('i.mdi').attr('class','mdi ' + value);
					control.setting.set(value);

				}, false);
			});

		}

	});

})(window, jQuery);
