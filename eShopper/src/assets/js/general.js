$(document).ready(function() {

    // Fancybox
    $('.fancybox').fancybox({
        padding : 0,
        openEffect  : 'elastic'
    });

    //cart
    $(".add-to-cart").click(function() {
        $(this).toggleClass("active");
        $(".cart-wrap").slideToggle(500);
    })


    //Prevent Page Reload on all # links
    $("a[href='#']").click(function(e) {
        e.preventDefault();
    });

    $('.back-to-top').click(function () {
        $("html, body").animate({
            scrollTop: 0
        }, 600);
        return false;
    });

    if($(window).width() < 768){
        $(".menu-link").click(function(){
            $(this).closest(".menu-item").toggleClass("active")
            $(this).closest(".menu-item").find(".sub-menu").slideToggle()
        })
    }

    $(window).scroll(function(e) {
        if($(window).scrollTop() > 200)
            $("body").addClass('top-arrow');
        else
            $("body").removeClass('top-arrow');
    });

    $(window).scroll(function(e) {
        if ($(window).scrollTop() > 0)
            $(".wrapper").addClass('small-header');
        else
            $(".wrapper").removeClass('small-header');
    });

    //search
    $(".search-link a").click(function() {
        $(this).closest(".search-link").toggleClass("active");
    });


    //placeholder

    $("[placeholder]").each(function() {
        $(this).attr("data-placeholder", this.placeholder);

        $(this).bind("focus", function() {
            this.placeholder = '';
        });
        $(this).bind("blur", function() {
            this.placeholder = $(this).attr("data-placeholder");
        });
    });



    // Slider
    var sync1 = $("#sync1");
    var sync2 = $("#sync2");

    sync1.owlCarousel({
        singleItem: true,
        slideSpeed: 1000,
        navigation: true,
        pagination: false,
        afterAction: syncPosition,
        responsiveRefreshRate: 200,
    });

    sync2.owlCarousel({
        items: 3,
        itemsDesktop: [1199, 3],
        itemsDesktopSmall: [979, 3],
        itemsTablet: [768, 3],
        itemsMobile: [479, 3],
        pagination: false,
        responsiveRefreshRate: 100,
        afterInit: function(el) {
            el.find(".owl-item").eq(0).addClass("synced");
        }
    });

    function syncPosition(el) {
        var current = this.currentItem;
        $("#sync2")
        .find(".owl-item")
        .removeClass("synced")
        .eq(current)
        .addClass("synced")
        if ($("#sync2").data("owlCarousel") !== undefined) {
            center(current)
        }

    }


    $("#sync2").on("click", ".owl-item", function(e) {
        e.preventDefault();
        var number = $(this).data("owlItem");
        sync1.trigger("owl.goTo", number);
    });

    function center(number) {
        var sync2visible = sync2.data("owlCarousel").owl.visibleItems;

        var num = number;
        var found = false;
        for (var i in sync2visible) {
            if (num === sync2visible[i]) {
                var found = true;
            }
        }

        if (found === false) {
            if (num > sync2visible[sync2visible.length - 1]) {
                sync2.trigger("owl.goTo", num - sync2visible.length + 2)
            } else {
                if (num - 1 === -1) {
                    num = 0;
                }
                sync2.trigger("owl.goTo", num);
            }
        } else if (num === sync2visible[sync2visible.length - 1]) {
            sync2.trigger("owl.goTo", sync2visible[1])
        } else if (num === sync2visible[0]) {
            sync2.trigger("owl.goTo", num - 1)
        }
    }


    //testimonial slider
    $(".testimonial-slider").owlCarousel({
        singleItem: true,
        slideSpeed: 1000,
        navigation: false,
        pagination: true,
        autoPlay: true
    });

    // Fastclick
    FastClick.attach(document.body);


    var sync1 = $(".sync1");
    var sync2 = $(".sync2");

    sync1.owlCarousel({
        autoplay: false,
        auto: false,
        singleItem: true,
        slideSpeed: 1000,
        navigation: false,
        pagination: false,
        afterAction: syncPosition,
        responsiveRefreshRate: 200,
    });

    sync2.owlCarousel({
        autoplay: false,
        auto: false,
        items: 4,
        itemsDesktop: [1199, 4],
        itemsDesktopSmall: [979, 3],
        itemsTablet: [768, 3],
        itemsMobile: [479, 3],
        pagination: false,
        navigation: true,
        responsiveRefreshRate: 100,
        afterInit: function(el) {
            el.find(".owl-item").eq(0).addClass("synced");
        }
    });

    function syncPosition(el) {
        var current = this.currentItem;
        $(".sync2")
        .find(".owl-item")
        .removeClass("synced")
        .eq(current)
        .addClass("synced")
        if ($(".sync2").data("owlCarousel") !== undefined) {
            center(current)
        }
    }

    $(".sync2").on("click", ".owl-item", function(e) {
        e.preventDefault();
        var number = $(this).data("owlItem");
        sync1.trigger("owl.goTo", number);
    });

    function center(number) {
        var sync2visible = sync2.data("owlCarousel").owl.visibleItems;
        var num = number;
        var found = false;
        for (var i in sync2visible) {
            if (num === sync2visible[i]) {
                var found = true;
            }
        }

        if (found === false) {
            if (num > sync2visible[sync2visible.length - 1]) {
                sync2.trigger("owl.goTo", num - sync2visible.length + 2)
            } else {
                if (num - 1 === -1) {
                    num = 0;
                }
                sync2.trigger("owl.goTo", num);
            }
        } else if (num === sync2visible[sync2visible.length - 1]) {
            sync2.trigger("owl.goTo", sync2visible[1])
        } else if (num === sync2visible[0]) {
            sync2.trigger("owl.goTo", num - 1)
        }

    }

    $(".owl-example1").owlCarousel({
        pagination: false,
        autoPlay: true,
        auto: true,
        center: true,
        loop: true,
        margin: 10,


    });

    $(".review-tag").click(function() {
        $(".review-open").slideToggle();
    });
});
