(function($) {

	// Misc
	$.fn.bindMisc = function() {
		var wrap = this;

		// tooltips
		wrap.find('[data-toggle="tooltip"]').tooltip();

		// dialog
		var dialog = $('#dialog').modal({ show: false });
		wrap.find('[data-confirm]').on('click', function(e, confirmed) {
			if (confirmed) return true;
			e.preventDefault();
			var that = $(this);
			dialog.find('.js-dialog-text').html(that.data('confirm'));
			dialog.find('.js-dialog-confirm').off().click(function(e) {
				dialog.hide('hide');
				that.trigger('click', [true]);
			});
			dialog.modal('show');
		});

		// focus field on click
		wrap.find('[data-focus]').on('click', function() {
			var that = $(this);
			$(that.data('focus')).focus();
		});

		// select input on focus
		wrap.find('.js-focus-select').on('focus', function() {
			this.select();
		});

		// live submit form
		wrap.find('.js-live-submit').on('change', function() {
			var that = $(this);
			if (that.is(':valid')) that.parents('form').submit();
		});

		// auto-dismiss alerts
		wrap.find('[data-auto-dismiss]').each(function() {
			var that = $(this);
			setTimeout(function() {
				that.slideUp(150, function() {
					that.remove();
				});
			}, that.data('auto-dismiss'));
		});
	}; // end of Misc

})(jQuery);
