$(window).on('load', function (event) {
    $('.preloader-loader').delay(500).fadeOut(500);
});

$(document).ready(function () {
    $('.container').imagesLoaded(function () {
        $('.grid').isotope({
            itemSelector: '.grid-item',
        });
        $('.portfolio-btn-wrapper').on('click', 'button', function () {
            var filterValue = $(this).attr('data-filter');
            $('.grid').isotope({ filter: filterValue });
            $('.filter-button-group button').removeClass('active');
            $(this).addClass('active');
        });
    });
});