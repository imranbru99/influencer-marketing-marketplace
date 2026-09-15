"user strict";

// Preloader
$(window).on("load", function () {
	$(".preloader").fadeOut(1000);
});

$(".faq-single__header").each(function () {
	$(this).on("click", function () {
		$(this).siblings(".faq-single__content").slideToggle();
		$(this).parent(".faq-single").toggleClass("active");
	});
});

//Menu Dropdown
$("ul>li>.sub-menu").parent("li").addClass("has-sub-menu");

$(".menu li a").on("click", function () {
	var element = $(this).parent("li");
	if (element.hasClass("open")) {
		element.removeClass("open");
		element.find("li").removeClass("open");
		element.find("ul").slideUp(300, "swing");
	} else {
		element.addClass("open");
		element.children("ul").slideDown(300, "swing");
		element.siblings("li").children("ul").slideUp(300, "swing");
		element.siblings("li").removeClass("open");
		element.siblings("li").find("li").removeClass("open");
		element.siblings("li").find("ul").slideUp(300, "swing");
	}
});

// Responsive Menu
var headerTrigger = $(".header-trigger");
headerTrigger.on("click", function () {
	$(".menu").toggleClass("active");
	$(".overlay").toggleClass("overlay-color");
});
$('.header-close').on('click', function (e) {
	$('.menu').removeClass('active')
	$('.overlay').removeClass('active')
})

// Overlay Event
var over = $(".overlay");
over.on("click", function () {
	$(".overlay").removeClass("overlay-color");
	$(".overlay").removeClass("active");
	$(".menu, .header-trigger").removeClass("active");
	$(".dash-sidebar").removeClass("active");
});




// Scroll To Top
var scrollTop = $(".scrollToTop");
$(window).on("scroll", function () {
	if ($(this).scrollTop() < 500) {
		scrollTop.removeClass("active");
	} else {
		scrollTop.addClass("active");
	}
});

//Click event to scroll to top
$(".scrollToTop").on("click", function () {
	$("html, body").animate(
		{
			scrollTop: 0,
		},
		300
	);
	return false;
});

$(".brands-slider").slick({
	fade: false,
	slidesToShow: 6,
	slidesToScroll: 1,
	infinite: true,
	autoplay: true,
	pauseOnHover: true,
	centerMode: false,
	dots: false,
	arrows: false,
	nextArrow: '<i class="las la-arrow-right arrow-right"></i>',
	prevArrow: '<i class="las la-arrow-left arrow-left"></i> ',
	responsive: [
		{
			breakpoint: 1199,
			settings: {
				slidesToShow: 5,
			},
		},
		{
			breakpoint: 992,
			settings: {
				slidesToShow: 4,
			},
		},
		{
			breakpoint: 767,
			settings: {
				slidesToShow: 3,
			},
		},
		{
			breakpoint: 575,
			settings: {
				slidesToShow: 2,
			},
		},
	],
});

$(".testimonial-slider").slick({
	fade: false,
	slidesToShow: 3,
	slidesToScroll: 1,
	infinite: true,
	autoplay: true,
	pauseOnHover: true,
	centerMode: false,
	dots: false,
	arrows: false,
	nextArrow: '<i class="las la-arrow-right arrow-right"></i>',
	prevArrow: '<i class="las la-arrow-left arrow-left"></i> ',
	responsive: [
		{
			breakpoint: 992,
			settings: {
				slidesToShow: 2,
			},
		},
		{
			breakpoint: 767,
			settings: {
				slidesToShow: 1,
			},
		},
	],
});

//Faq
$(".faq-item__title").on("click", function (e) {
	var element = $(this).parent(".faq-item");
	if (element.hasClass("open")) {
		element.removeClass("open");
		element.find(".faq-item__content").removeClass("open");
		element.find(".faq-item__content").slideUp(300, "swing");
	} else {
		element.addClass("open");
		element.children(".faq-item__content").slideDown(300, "swing");
		element.siblings(".faq-item").children(".faq-item__content").slideUp(300, "swing");
		element.siblings(".faq-item").removeClass("open");
		element.siblings(".faq-item").find(".faq-item__content").slideUp(300, "swing");
	}
});

$(".video-button").magnificPopup({
	type: "iframe",
	// other options
});

function proPicURL(input) {
	if (input.files && input.files[0]) {
		var reader = new FileReader();
		reader.onload = function (e) {
			var preview = $(input).parents(".thumb").find(".profilePicPreview");
			$(preview).css("background-image", "url(" + e.target.result + ")");
			$(preview).addClass("has-image");
			$(preview).hide();
			$(preview).fadeIn(650);
		};
		reader.readAsDataURL(input.files[0]);
	}
}
$(document).on("change", ".profilePicUpload", function () {
	proPicURL(this);
});

$(".filter-toggle").on("click", function () {
	$(".service-tab").toggleClass("active");
});

$(".service-details-slider").slick({
	slidesToShow: 1,
	slidesToScroll: 1,
	arrows: false,
	fade: true,
	asNavFor: ".service-nav-slider",
});
$(".service-nav-slider").slick({
	slidesToShow: 6,
	slidesToScroll: 1,
	asNavFor: ".service-details-slider",
	dots: false,
	centerMode: false,
	centerPadding: "0px",
	focusOnSelect: true,
	arrows: true,
	prevArrow: '<div class="prev"><i class="las la-long-arrow-alt-left"></i></div>',
	nextArrow: '<div class="next"><i class="las la-long-arrow-alt-right"></i></div>',
	responsive: [
		{
			breakpoint: 992,
			settings: {
				slidesToShow: 4,
			},
		},
		{
			breakpoint: 767,
			settings: {
				slidesToShow: 3,
			},
		},
	],
});



$(".dashboard-toggler").on("click", function () {
	$(".dash-sidebar").toggleClass("active");
	$(".overlay").toggleClass("overlay-color");
});
$(".sidebar-close").on("click", function () {
	$(".dash-sidebar").removeClass("active");
	$(".overlay").toggleClass("overlay-color");
});

$(".sidebar-menu li a").on("click", function (e) {
	var element = $(this).parent("li");
	element.addClass("open");
	element.children(".sidebar-submenu").slideDown();

});

$(".sidebar-menu li .sidebar-submenu").parent("li").addClass("has-submenu");

$(".sidebar-submenu li a.active").parent("li").parent(".sidebar-submenu").parent("li").addClass("sidebar-submenu__open");

$.each($("input, select, textarea"), function (i, element) {
	if (element.hasAttribute("required")) {
		$(element).closest(".form-group").find("label").first().addClass("required");
	}
});

