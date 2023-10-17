/**
 * Theme Customizer Controls
 *
 * Important: If binding events, use on( 'click' ), on( 'change' ), etc. vs click(), change()
 * It may just be best to poll every half-second, however, to make sure state is always correct
 */

jQuery(document).ready(function ($) {

	/***************************************
	 * BACKGROUND IMAGE
	 ***************************************/

	// Preset thumbnail click
	$('body').on('click', '#customize-control-resurrect_customizations-background_image_preset .ctfw-customize-image-presets li', function () {

		var url, preset, colorable, $background_image_preset_control;

		// Controls
		$background_image_preset_control = $('#customize-control-' + resurrect_customize.option_id + '-background_image_preset');

		// Add selected class
		$('.ctfw-customize-image-presets li').removeClass('ctfw-customize-image-preset-selected'); // remove all first
		$(this).addClass('ctfw-customize-image-preset-selected');

		// Get preset data
		url = $(this).attr('data-customize-image-value');
		preset = $(this).attr('data-customize-image-preset-preset');
		colorable = Boolean($(this).attr('data-customize-image-preset-colorable'));

		// Set url on hidden field and trigger change()
		$('input[data-customize-setting-link="resurrect_customizations[background_image_preset]"]')
			.val(url)
			.trigger('change');

		// Update other settings and trigger change
		if (preset) {

			$("select[data-customize-setting-link=background_preset]").show();
			$("select[data-customize-setting-link=background_preset]").val(preset).trigger('change'); // trigger change for preview

			// If fill, set position centered and scroll fixed
			if ('fill' == preset) {
				$('.background-position-center-icon').trigger('click');
			}

		}

		// Hide all settings after presets
		$background_image_preset_control.nextAll().hide();

	});

	/***************************************
	 * DETECT CHANGES
	 ***************************************/

	// Continuously check controls for changes
	// .on( 'change' ) cannot help with changes to non-form elements, such as images
	$.doTimeout(500, function () {

		var $background_image_control, $background_image_preset_control, background_image_preset_url, background_image_type, logo_type, $logo_hidpi_control, $move_logo_control, $logo_image, $logo_hidpi, $logo_offset_x, $logo_text, $logo_text_size, $move_tagline, header_right, $header_items, $custom_content;

		/**************************************
		 * BACKGROUND IMAGE
		 **************************************/

		// Controls
		$background_image_control = $('#customize-control-background_image');
		$background_image_preset_control = $('#customize-control-' + resurrect_customize.option_id + '-background_image_preset');

		// Preset image url
		background_image_preset_url = $('input[data-customize-setting-link="resurrect_customizations[background_image_preset]"]').val();

		// Background image type
		background_image_type = $("input[data-customize-setting-link^='" + resurrect_customize.option_id + "[background_image_type]']:radio:checked").val();

		// Conditions based on current image type

		// Preset
		if ('preset' == background_image_type) {

			// Hide all settings after presets
			$background_image_preset_control.nextAll().hide();

			// If no preset selected, choose first
			if (!background_image_preset_url) {
				$('#customize-control-resurrect_customizations-background_image_preset .ctfw-customize-image-presets li:first-child').trigger('click');
			}

		}

		// Preset or None
		if ('none' == background_image_type || !background_image_type || 'preset' == background_image_type) {

			// Simulate click on "Remove" button on uploaded image
			$('#customize-control-background_image .actions .remove-button').trigger('click');

			// Hide all settings after presets
			$background_image_preset_control.nextAll().hide();

		}

		// Upload
		if ('upload' == background_image_type) {

			// If no image selected, set default config
			if (!$('#customize-control-background_image .attachment-thumb').length) {
				$("select[data-customize-setting-link=background_preset]").val('fill').trigger('change'); // trigger change for preview
				$('.background-position-center-icon').trigger('click');
			}

		}

		// Upload or None
		if ('upload' == background_image_type || 'none' == background_image_type || !background_image_type) {

			// Unset value for preset URL
			$('input[data-customize-setting-link="resurrect_customizations[background_image_preset]"]')
				.val('')
				.trigger('change');

			// Remove the selection around all presets
			$('.ctfw-customize-image-presets li').removeClass('ctfw-customize-image-preset-selected');

		}

		// Show/hide "Image Upload" and "Preset Images" according to Background Image Type
		if ('preset' == background_image_type) {
			$background_image_control.hide();
			$background_image_preset_control.show();
		} else if ('upload' == background_image_type) {
			$background_image_control.show();
			$background_image_preset_control.hide();
		} else { // None
			$background_image_control.hide();
			$background_image_preset_control.hide();
		}

		// Show/hide colorable note beaneath presets based on background image URL
		// Future: move this into framework control (inject CSS into head)
		if (background_image_preset_url && $('#customize-control-resurrect_customizations-background_image_preset .ctfw-customize-image-presets li[data-customize-image-value="' + background_image_preset_url + '"][data-customize-image-preset-colorable="1"]').length) {
			$('#customize-control-resurrect_customizations-background_image_preset .ctfw-customize-background-image-preset-colorable').show();
		} else {
			$('#customize-control-resurrect_customizations-background_image_preset .ctfw-customize-background-image-preset-colorable').hide();
		}

		/**************************************
		 * HEADER
		 **************************************/

		// Logo type
		logo_type = $("input[data-customize-setting-link^='" + resurrect_customize.option_id + "[logo_type]']:radio:checked").val();

		// Logo controls
		$logo_hidpi_control = $('#customize-control-' + resurrect_customize.option_id + '-logo_hidpi');
		$move_logo_control = $('#customize-control-' + resurrect_customize.option_id + '-logo_offset_x');

		// Show/hide "Logo Image" and "Retina Logo" and "Move Logo" fields
		$logo_image = $('#customize-control-' + resurrect_customize.option_id + '-logo_image');
		$logo_hidpi = $('#customize-control-' + resurrect_customize.option_id + '-logo_hidpi');
		$logo_offset_x = $('#customize-control-' + resurrect_customize.option_id + '-logo_offset_x');
		if ('image' == logo_type) {

			$logo_image.show();

			// Show Retina Logo and Move Logo controls only while Logo uploaded ( and not using Text logo )
			if ($("#customize-control-" + resurrect_customize.option_id + "-logo_image .thumbnail-image .attachment-thumb").length) {
				$logo_hidpi_control.show();
				$move_logo_control.show();
			} else {
				$logo_hidpi_control.hide();
				$move_logo_control.hide();
			}

		} else {

			$logo_image.hide();
			$logo_hidpi.hide();
			$logo_offset_x.hide();

		}

		// Show/hide "Logo Text Size" and "Logo Text Size"
		$logo_text = $('#customize-control-' + resurrect_customize.option_id + '-logo_text');
		$logo_text_size = $('#customize-control-' + resurrect_customize.option_id + '-logo_text_size');
		if (logo_type == 'text') {
			$logo_text.show();
			$logo_text_size.show();
		} else {
			$logo_text.hide();
			$logo_text_size.hide();
		}

		// "Show tagline under logo" has changed
		// Show/hide if checked or not
		$move_tagline = $('#customize-control-' + resurrect_customize.option_id + '-tagline_offset_x');
		if ($("input[data-customize-setting-link^='" + resurrect_customize.option_id + "[tagline_under_logo]']").is(':checked')) {
			$move_tagline.show();
		} else {
			$move_tagline.hide();
		}

		// "Show on Right" has changed
		header_right = $("input[data-customize-setting-link^='" + resurrect_customize.option_id + "[header_right]']:radio:checked").val();

		// Show/hide header right event/sermon/posts limit field if selected
		$header_items = $('#customize-control-' + resurrect_customize.option_id + '-header_right_items_limit');
		if ('sermons' == header_right || 'events' == header_right || 'posts' == header_right) {
			$header_items.show();
		} else {
			$header_items.hide();
		}

		// Show/hide "Custom Content" textarea if selected
		$custom_content = $('#customize-control-' + resurrect_customize.option_id + '-header_right_content');
		if ('content' == header_right) {
			$custom_content.show();
		} else {
			$custom_content.hide();
		}

		/**************************************/

		// Keep checking for changes
		return true;

	});

});
