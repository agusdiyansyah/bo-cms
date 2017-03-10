$(document).ready(function() {

	if (jQuery(window).width() > 767) {
		jQuery('.header-nav > li').hover(function() {
			jQuery(this).children('.sub-menu').show().animate({
				top : '78px'
			}, 350)
		}, function() {
			jQuery(this).children('.sub-menu').hide().animate({
				top : '60px'
			})
		})
		jQuery('.header-nav .sub-menu li').hover(function() {
			jQuery(this).children('.sub-menu').animate({
				top : '0px'
			}, 350)
		}, function() {
			jQuery(this).children('.sub-menu').animate({
				top : '-25px'
			})
		})
	}

	$(".page-container .toggle-row").click(function() {
	
		$(this).toggleClass("active");
		$(this).siblings(".header-navigation").slideToggle();
		
		
		$(".menu-arrow").removeClass("active");
	});
	
	$('.header-nav .menu-arrow').click(function(){
		$(this).siblings('.sub-menu').slideToggle();
	});
	
	$('.header-nav .nextmenu-arrow').click(function(){
		$(this).siblings('.sub-menu').slideToggle();
	});
	
	
});
