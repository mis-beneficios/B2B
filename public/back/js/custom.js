/*
Template Name: Dashboard Sistema Mis Beneficios Vacacionales
Author: Diego Enrique Sanchez
Email: diego.enrique76@gmail.com
File: js
*/
$(function() {
    "use strict";
    $(function() {
        $(".preloader").fadeOut();
    });
    jQuery(document).on('click', '.mega-dropdown', function(e) {
        e.stopPropagation()
    });
    var set = function() {
        var width = (window.innerWidth > 0) ? window.innerWidth : this.screen.width;
        var topOffset = 70;
        if (width < 1170) {
            $("body").addClass("mini-sidebar");
            $('.navbar-brand span').hide();
            $(".sidebartoggler i").addClass("ti-menu");
        } else {
            $("body").removeClass("mini-sidebar");
            $('.navbar-brand span').show();
            $(".sidebartoggler i").removeClass("ti-menu");
        }
        var height = ((window.innerHeight > 0) ? window.innerHeight : this.screen.height) - 1;
        height = height - topOffset;
        if (height < 1) height = 1;
        if (height > topOffset) {
            $(".page-wrapper").css("min-height", (height) + "px");
        }
    };
    $(window).ready(set);
    $(window).on("resize", set);
    $(".sidebartoggler").on('click', function() {
        if ($("body").hasClass("mini-sidebar")) {
            $("body").trigger("resize");
            $(".scroll-sidebar, .slimScrollDiv").css("overflow", "hidden").parent().css("overflow", "visible");
            $("body").removeClass("mini-sidebar");
            $('.navbar-brand span').show();
            $(".sidebartoggler i").addClass("ti-menu");
        } else {
            $("body").trigger("resize");
            $(".scroll-sidebar, .slimScrollDiv").css("overflow-x", "visible").parent().css("overflow", "visible");
            $("body").addClass("mini-sidebar");
            $('.navbar-brand span').hide();
            $(".sidebartoggler i").removeClass("ti-menu");
        }
    });
    $('.floating-labels .form-control').on('focus blur', function(e) {
        $(this).parents('.form-group').toggleClass('focused', (e.type === 'focus' || this.value.length > 0));
    }).trigger('blur');
    $(".nav-toggler").click(function() {
        $("body").toggleClass("show-sidebar");
        $(".nav-toggler i").toggleClass("mdi mdi-menu");
        $(".nav-toggler i").addClass("ti-close");
    });
    $(".sidebartoggler").on('click', function() {
        //$(".sidebartoggler i").toggleClass("ti-menu");
    });
    $(".search-box a, .search-box .app-search .srh-btn").on('click', function(e) {
        e.preventDefault();
        $(".app-search").toggle(200);
    });
    $(".right-side-toggle").click(function() {
        $(".right-sidebar").slideDown(50);
        $(".right-sidebar").toggleClass("shw-rside");
    });
    $(function() {
        var url = window.location;
        var element = $('ul#sidebarnav a').filter(function() {
            return this.href == url;
        }).addClass('active').parent().addClass('active');
        while (true) {
            if (element.is('li')) {
                element = element.parent().addClass('in').parent().addClass('active');
            } else {
                break;
            }
        }
    });
    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    })
    $(function() {
        $('[data-toggle="popover"]').popover()
    })
    $(function() {
        $('#sidebarnav').metisMenu();
    });
    $('.message-center').slimScroll({
        position: 'right',
        size: "5px",
        color: '#dcdcdc'
    });
    $('.aboutscroll').slimScroll({
        position: 'right',
        size: "5px",
        height: '80',
        color: '#dcdcdc'
    });
    $('.message-scroll').slimScroll({
        position: 'right',
        size: "5px",
        height: '570',
        color: '#dcdcdc'
    });
    $('.chat-box').slimScroll({
        position: 'right',
        size: "5px",
        height: '470',
        color: '#dcdcdc'
    });
    $('.slimscrollright').slimScroll({
        height: '100%',
        position: 'right',
        size: "5px",
        color: '#dcdcdc'
    });
    $("body").trigger("resize");
    $(".list-task li label").click(function() {
        $(this).toggleClass("task-done");
    });
    $('a[data-action="collapse"]').on('click', function(e) {
        e.preventDefault();
        $(this).closest('.card').find('[data-action="collapse"] i').toggleClass('ti-minus ti-plus');
        $(this).closest('.card').children('.card-body').collapse('toggle');
    });
    $('a[data-action="expand"]').on('click', function(e) {
        e.preventDefault();
        $(this).closest('.card').find('[data-action="expand"] i').toggleClass('mdi-arrow-expand mdi-arrow-compress');
        $(this).closest('.card').toggleClass('card-fullscreen');
    });
    $('a[data-action="close"]').on('click', function() {
        $(this).closest('.card').removeClass().slideUp('fast');
    });
    // $('#monthchart').sparkline([5, 6, 2, 9, 4, 7, 10, 12], {
    //     type: 'bar',
    //     height: '35',
    //     barWidth: '4',
    //     resize: true,
    //     barSpacing: '4',
    //     barColor: '#1e88e5'
    // });
    // $('#lastmonthchart').sparkline([5, 6, 2, 9, 4, 7, 10, 12], {
    //     type: 'bar',
    //     height: '35',
    //     barWidth: '4',
    //     resize: true,
    //     barSpacing: '4',
    //     barColor: '#7460ee'
    // });
    var sparkResize;
});