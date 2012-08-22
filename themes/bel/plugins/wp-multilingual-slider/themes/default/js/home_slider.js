var autoSlide;
var accueil_plugin_flexslider = {
	// Time between auto slide in milliseconds. Default : 5000
	slideSpeed: 5000,
	// Time for the animation in milliseconds. Default : 500 (Recommended [100-1000])
	animationDuration: 500,
	neverAuto: false,
	fading: false,
  nextFade:-1
};

	

jQuery(function(){
	
	jQuery(".block-gallery").find('ul>li:first').addClass("active");
	jQuery(".switcher").find("li:first").addClass("active");
	
	autoSlide = setInterval(function () { next_active_slide() }, accueil_plugin_flexslider.slideSpeed);
	
	jQuery('.switch').each ( function () {
		jQuery(".elipsis").dotdotdot();
		jQuery(".location").dotdotdot()
		jQuery(this).click ( function () {
			fade_slide(jQuery("ul #switch-"+jQuery(this).attr("switch")), 
				jQuery("#slide-"+jQuery(this).attr("switch")));
			accueil_plugin_flexslider.neverAuto = true;
		});
	});
});

function fade_slide (next, nextSlide) {
	var curr = jQuery(".switcher li.active");
	var currSlide = jQuery(".gallery ul li.active");
	if (!accueil_plugin_flexslider.fading) {
		if (curr.attr('id') != next.attr('id')) {
			accueil_plugin_flexslider.fading = true;
			clearInterval(autoSlide);
			currSlide.fadeOut(accueil_plugin_flexslider.animationDuration, function () {
				next.addClass("active");
				nextSlide.addClass("active");
				curr.removeClass("active");
				currSlide.removeClass("active");
				
				
				/*Display back the next slide*/
				nextSlide.hide().fadeIn(accueil_plugin_flexslider.animationDuration, function () {
						jQuery(".elipsis").dotdotdot();
						jQuery(".location").dotdotdot()
						if (!accueil_plugin_flexslider.neverAuto) {
							autoSlide = setInterval(function () { next_active_slide() }, accueil_plugin_flexslider.slideSpeed);
						}
						accueil_plugin_flexslider.fading = false;
						if (accueil_plugin_flexslider.nextFade != -1) {
							fade_slide(jQuery("ul #switch-"+accueil_plugin_flexslider.nextFade), 
								jQuery("#slide-"+accueil_plugin_flexslider.nextFade))
							accueil_plugin_flexslider.nextFade = -1;
						}
				});
			});
		}
	} else {
		accueil_plugin_flexslider.nextFade = next.children().attr('switch');
	}
}

function next_active_slide () {
	var next = jQuery(".switcher li.active").next();
	if (next.length == 0) {
		next = jQuery(".switcher li#switch-0");
	}
	var nextSlide = jQuery("#slide-"+next.children().attr("switch"));

	fade_slide(next, nextSlide);
}
