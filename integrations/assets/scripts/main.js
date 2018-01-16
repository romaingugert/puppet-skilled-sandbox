(function($) {

	// bind components
	$.fn.bindAll = function() {
		var wrap = this;
		wrap.bindMisc();
		wrap.bindModals();
		wrap.bindCheckboxes({
			cruditems: function(items, values) {
				var checked = items.filter(':checked');
				var parents = items.parents('.Selectable').removeClass('is-selected');
				var actions = $('.Selectable-actions').removeClass('is-open');
				if (checked.length) {
					checked.parents('.Selectable').addClass('is-selected');
					actions.addClass('is-open');
				}
			},
		});
	};


	// bind all on Body
	$(function() {
		$('body').bindAll();
	});

})(jQuery);
