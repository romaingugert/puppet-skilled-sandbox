document.addEventListener("DOMContentLoaded", function(event) {
    document.querySelectorAll('.debug-dropdown').forEach(function(item) {
        item.addEventListener('mouseenter', function(e) {
            var pos = item.getBoundingClientRect();
            var content = item.querySelector('.debug-dropdown-content');
            var screenWidth = window.innerWidth;
            content.style.maxWidth = screenWidth+'px';
            var delta = pos.left + content.offsetWidth - screenWidth;
            if (delta > 0) {
                content.style.left = -delta+'px';
            }
        });
    });
    var debug = document.querySelector('#debug');
    window.addEventListener('keydown', function(e) {
        if (debug.checked && e.which === 27) {
            debug.checked = false;
        }
    });
});
