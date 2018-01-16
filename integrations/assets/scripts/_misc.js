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

		// datepicker
		var lang = document.documentElement.lang;
		wrap.find('.js-datepicker').flatpickr({
			locale: lang || "en",
			allowInput: true,
		});

		// datetimepicker
		wrap.find('.js-datetimepicker').flatpickr({
			locale: lang || "en",
			enableTime: true,
			time_24hr:true,
			allowInput: true,
		});

		// charts
		wrap.find('[data-chart]').each(function() {
			var that = $(this);
			var target = $('#'+that.data('chart'));
			if (target.length) {
				that.data('chart', new Chart(this, JSON.parse(target.html())));
			}
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


		// live autocomplete inputs
		wrap.find('input[data-autocomplete]').each(function() {
			var that = $(this);

			if (typeof that.data('autocomplete-params') === 'string') {
				that.data('autocomplete-params', JSON.parse(that.data('autocomplete-params')));
			} else if (!that.data('autocomplete-params')) {
				that.data('autocomplete-params', {});
			}

			that.autocomplete({
				url: that.data('autocomplete'),
				targetSelector: that.data('autocomplete-target'),
				liveSuggest: true,
				alwaysSuggest: false,
				freeInput: false,
				invalidText: that.data('autocomplete-invalid'),
				invalidClass: 'form-control-danger',
				defaultDisplayValue: that.data('autocomplete-default'),
				template: '{{this.name}} [{{this.code}}]',
				emptyText: that.data('autocomplete-empty'),
				loadingText: that.data('autocomplete-loading'),
				params: function() {
					return $.extend({
						value: this.val(),
					}, that.data('autocomplete-params'));
				},
				display: function(data) {
					return data.name;
				},
				result: function(data) {
					return data.code;
				},
			});
		});


		// autocomplete on selects
		wrap.find('select[data-autocomplete]').each(function() {
			var that = $(this);

			// retrieve options
			var options = [];
			var current = '';
			that.children('option:not(".autocomplete-skip")').each(function() {
				var self = $(this);
				var text = $.trim(self.text());
				var value = self.prop('value') || text;
				options.push({
					value: value,
					label: text,
				});
				if (self.is('[selected]')) {
					current = text;
				}
			});

			// init autocomplete
			var input = $('<input>').attr({
				name: that.prop('name'),
				class: that.data('autocomplete-input-class'),
			}).val(that.val()).insertBefore(that);
			that.removeAttr('name').hide();
			input.autocomplete({
				targetSelector: that.data('autocomplete-target'),
				alwaysSuggest: true,
				freeInput: false,
				invalidText: that.data('autocomplete-invalid'),
				invalidClass: 'form-control-danger',
				defaultDisplayValue: current,
				template: '{{this.label}}',
				emptyText: that.data('autocomplete-empty'),
				loadingText: that.data('autocomplete-loading'),
				suggestions: options,
				display: function(data) {
					return data.label;
				},
				result: function(data) {
					return data.value;
				},
				onDestroy: function(value) {
					that.val(value).show();
					this.remove();
				}
			});
		});
	}; // end of Misc

})(jQuery);
