(function ($) {
    "use strict";

    // Initiate the wowjs
    new WOW().init();


    // Sticky Navbar
    $(window).scroll(function () {
        if ($(this).scrollTop() > 300) {
            $('.sticky-top').addClass('shadow-sm').css('top', '0px');
        } else {
            $('.sticky-top').removeClass('shadow-sm').css('top', '-100px');
        }
    });
    
    //detect page
    document.addEventListener("DOMContentLoaded", function () {
        let links = document.querySelectorAll("nav a");
        let currentPage = window.location.pathname.split("/").pop(); // Get current page name
    
        links.forEach(link => {
            if (link.getAttribute("href") === currentPage) {
                link.classList.add("active");
            }
        });
    });
    


    // Back to top button
    $(window).scroll(function () {
        if ($(this).scrollTop() > 300) {
            $('.back-to-top').fadeIn('slow');
        } else {
            $('.back-to-top').fadeOut('slow');
        }
    });
    $('.back-to-top').click(function () {
        $('html, body').animate({scrollTop: 0}, 1500, 'easeInOutExpo');
        return false;
    });

    //active page
        const navLinks = document.querySelectorAll('nav a');

    navLinks.forEach(link => {
    if (link.href === window.location.href) {
        link.classList.add('active');
    }
    });

    document.addEventListener('DOMContentLoaded', function() {
        var myCarousel = new bootstrap.Carousel(document.getElementById('header-carousel'), {
            interval: 5000, // Change slides every 5 seconds
            wrap: true, // Enable continuous loop
            keyboard: true // Enable keyboard navigation
        });
    });
    
})(jQuery);

