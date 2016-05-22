+function ($) {

    $(document).ready(function() {
        $('.js-header-search-toggle').on('click', function() {
            $('.search-bar').slideToggle();
        });
    });

}(jQuery);
