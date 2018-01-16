(function($) {

	// Toggle multiple checkboxes using [data-check-toggle="<id>"] and [data-check="<id>"]
	// NOTE use [data-check-count="<id>"] to display the number of checked items in <id> list
	// NOTE use [data-check-data="<id>"] to build POST data on the element from checked values in <id> list
	// See `views/users.php` for an example
	$.fn.bindCheckboxes = function(callbacks) {
		var wrap = this;
		if (!callbacks) callbacks = {};


		// update elements on change
		wrap.bind('update', function(e, id) {
			// get states & values
			var total = wrap.find('input[data-check="'+id+'"]');
			var checked = total.filter(':checked');
			var values = [];
			checked.each(function() {
				var v = $(this).attr('value');
				if (values.indexOf(v) < 0) values.push(v);
			});

			// update related elements
			wrap.find('[data-check-toggle="'+id+'"]').trigger('update', [checked.length, total.length]);
			wrap.find('[data-check-count="'+id+'"]').trigger('update', [checked.length, total.length]);
			wrap.find('[data-check-data="'+id+'"]').trigger('update', [values]);

			// trigger callback if set
			if (callbacks[id] && callbacks[id].call) {
				callbacks[id](total, values);
			}
		});


		// cancel checkboxes
		wrap.find('[data-check-cancel]').on('click', function(e, values) {
			var that = $(this);
			wrap.find('input[data-check="'+that.data('check-cancel')+'"]').not(':disabled').prop('checked', false).trigger('update');
		});


		// toggle multiple checkboxes
		wrap.find('input[data-check-toggle]').on('change', function() {
			var that = $(this);
			wrap.find('input[data-check="'+that.data('check-toggle')+'"]').not(':disabled').prop('checked', that.prop('checked')).trigger('update');
		}).on('update', function(e, checked, total) {
			// update toggler state
			var that = $(this);
			that.prop('disabled', total == 0);
			that.prop('indeterminate', checked > 0 && checked < total);
			that.prop('checked', checked == total);

			// toggle parent toggler if any (nested behavior)
			if (that.is('[data-check]')) wrap.trigger('update', [that.data('check')]);
		});


		// update count
		wrap.find('[data-check-count]').on('update', function(e, checked, total) {
			$(this).text(checked);
		});


		// update data
		wrap.find('[data-check-data]').on('update', function(e, values) {
			$(this).addClass('js-post').data('post',  {values: values}).prop('disabled', values.length == 0);
		});


		// update all when any checkbox state changes
		var lastIndex = {};
		wrap.find('input[data-check]').on('update', function(e, shift) {
			// shift + click for checking range
			var that = $(this);
			var items = wrap.find('[data-check="'+that.data('check')+'"]');
			if (typeof lastIndex[that.data('check')] === 'undefined') lastIndex[that.data('check')] = -1;
			var last = lastIndex[that.data('check')];
			if (shift && last > -1) {
				var pos = items.index(that);
				var targets = pos < last ? items.slice(pos, last+1) : items.slice(last, pos+1);
				targets.prop('checked', that.is(':checked'));
			} else if (!shift) lastIndex[that.data('check')] = items.index(that);

			// update elements
			wrap.trigger('update', [that.data('check')]);
		}).on('click', function(e) {
			$(this).trigger('update', [e.shiftKey]);
		}).trigger('change');
	}; // end of Checkboxes

})(jQuery);
