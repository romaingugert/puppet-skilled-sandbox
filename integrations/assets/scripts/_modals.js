(function($) {

  $.fn.bindModals = function() {
    var wrap = this;

    // NOTE use $([data-modal]).data('post', {…}) to transmit extra parameters
    var handler = function(e) {
      e.preventDefault();
      var that = $(this);
      var url = that.data('modal');
      var req = {
        async: true,
        headers: {'X-REFERER-URL': encodeURIComponent(location.href)}, // send referer as header
      };

      // add POST data if any
      if (that.data('post')) {
        req.method = 'POST';
        req.data = that.data('post');
      } else if (that.is('form')) {
        req.method = 'POST';
        req.data = that.serialize();
      }

      // send query
      $.ajax(url, req).fail(function(xhr, status, error) {
        console.log(error);
      }).done(function(data, status, xhr) {
        var redirect = xhr.getResponseHeader('X-REDIRECT-URL');
        if (redirect) {
          location.href = redirect;
        } else {
          // close old one
          $('.modal').modal('hide');

          // create new one
          var html = $('<div>').append($(data.responseText || data).find('.js-modal-wrap')).html();
          html = '<div class="modal-dialog"><div class="modal-content">'+html+'</div></div>';
          var modal = $('<div class="modal fade">').html(html).attr('data-async', true).appendTo('body');

          // bind elements
          modal.bindAll();
          modal.on('hidden.bs.modal', function() {
            modal.remove();
          }).modal('show');
        }
      });
    };

    wrap.find('[data-modal]').not('form').on('click', handler);
    wrap.find('form[data-modal]').on('submit', handler);
  }; // end of Modals

})(jQuery);
