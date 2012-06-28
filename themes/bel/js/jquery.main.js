// init page
jQuery(function(){
	initFixLayout();
	initOpenClose();
	initColumns();
	initClear();
	initNav();
});

function initNav(){
	initAutoScalingNav({
		menuId: "nav",
		spacing: 3,
		constant: -3,
		liHovering: true,
		sideClasses: true
	});
}

function initClear(){
	clearFormFields({
		clearInputs: true,
		clearTextareas: true,
		passwordFieldText: true,
		addClassFocus: "focus",
		filterClass: "default"
	});
}
function initColumns(){
	if(typeof  col == 'undefined' ) col = 4 ;
	jQuery('.twocolumns .main-block, .container-frame .section').columnize({
		columns: col
	});
}

function initFixLayout(){
	jQuery('.drop ul li:first-child a').addClass('first-child');
	jQuery('.drop ul li:last-child a').addClass('last-child');
};

// open-close init
function initOpenClose() {
	jQuery('div.popup').openClose({
		addClassBeforeAnimation: false,
		activeClass:'expanded',
		opener:'a.open',
		slider:'div.slide',
		effect:'slide',
		animSpeed:500
	});
}

// autoscaling navigation
function initAutoScalingNav(o) {
	if (!o.menuId) o.menuId = "nav";
	if (!o.tag) o.tag = "a";
	if (!o.spacing) o.spacing = 0;
	if (!o.constant) o.constant = 0;
	if (!o.minPaddings) o.minPaddings = 0;
	if (!o.liHovering) o.liHovering = false;
	if (!o.sideClasses) o.sideClasses = false;
	if (!o.equalLinks) o.equalLinks = false;
	if (!o.flexible) o.flexible = false;
	var nav = document.getElementById(o.menuId);
	if(nav) {
		nav.className += " scaling-active";
		var lis = nav.getElementsByTagName("li");
		var asFl = [];
		var lisFl = [];
		var width = 0;
		for (var i=0, j=0; i<lis.length; i++) {
			if(lis[i].parentNode == nav) {
				var t = lis[i].getElementsByTagName(o.tag).item(0);
				asFl.push(t);
				asFl[j++].width = t.offsetWidth;
				lisFl.push(lis[i]);
				if(width < t.offsetWidth) width = t.offsetWidth;
			}
			if(o.liHovering) {
				lis[i].onmouseover = function() {
					this.className += " hover";
				}
				lis[i].onmouseout = function() {
					this.className = this.className.replace("hover", "");
				}
			}
		}
		var menuWidth = nav.clientWidth - asFl.length*o.spacing - o.constant;
		if(o.equalLinks && width * asFl.length < menuWidth) {
			for (var i=0; i<asFl.length; i++) {
				asFl[i].width = width;
			}
		}
		width = getItemsWidth(asFl);
		if(width < menuWidth) {
			var version = navigator.userAgent.toLowerCase();
			for (var i=0; getItemsWidth(asFl) < menuWidth; i++) {
				asFl[i].width++;
				if(!o.flexible) {
					asFl[i].style.width = asFl[i].width + "px";
				}
				if(i >= asFl.length-1) i=-1;
			}
			if(o.flexible) {
				for (var i=0; i<asFl.length; i++) {
					width = (asFl[i].width - o.spacing - o.constant/asFl.length)/menuWidth*100;
					if(i != asFl.length-1) {
						lisFl[i].style.width = width + "%";
					}
					else {
						if(navigator.appName.indexOf("Microsoft Internet Explorer") == -1 || version.indexOf("msie 8") != -1 || version.indexOf("msie 9") != -1)
							lisFl[i].style.width = width + "%";
					}
				}
			}
		}
		else if(o.minPaddings > 0) {
			for (var i=0; i<asFl.length; i++) {
				asFl[i].style.paddingLeft = o.minPaddings + "px";
				asFl[i].style.paddingRight = o.minPaddings + "px";
			}
		}
		if(o.sideClasses) {
			lisFl[0].className += " first-child";
			lisFl[0].getElementsByTagName(o.tag).item(0).className += " first-child-a";
			lisFl[lisFl.length-1].className += " last-child";
			lisFl[lisFl.length-1].getElementsByTagName(o.tag).item(0).className += " last-child-a";
		}
		nav.className += " scaling-ready";
	}
	function getItemsWidth(a) {
		var w = 0;
		for(var q=0; q<a.length; q++) {
			w += a[q].width;
		}
		return w;
	}
}

// clear form
function clearFormFields(o)
{
	if (o.clearInputs == null) o.clearInputs = true;
	if (o.clearTextareas == null) o.clearTextareas = true;
	if (o.passwordFieldText == null) o.passwordFieldText = false;
	if (o.addClassFocus == null) o.addClassFocus = false;
	if (!o.filter) o.filter = "default";
	if(o.clearInputs) {
		var inputs = document.getElementsByTagName("input");
		for (var i = 0; i < inputs.length; i++ ) {
			if((inputs[i].type == "text" || inputs[i].type == "password") && inputs[i].className.indexOf(o.filterClass)) {
				inputs[i].valueHtml = inputs[i].value;
				inputs[i].onfocus = function ()	{
					if(this.valueHtml == this.value) this.value = "";
					if(this.fake) {
						inputsSwap(this, this.previousSibling);
						this.previousSibling.focus();
					}
					if(o.addClassFocus && !this.fake) {
						this.className += " " + o.addClassFocus;
						this.parentNode.className += " parent-" + o.addClassFocus;
					}
				}
				inputs[i].onblur = function () {
					if(this.value == "") {
						this.value = this.valueHtml;
						if(o.passwordFieldText && this.type == "password") inputsSwap(this, this.nextSibling);
					}
					if(o.addClassFocus) {
						this.className = this.className.replace(o.addClassFocus, "");
						this.parentNode.className = this.parentNode.className.replace("parent-"+o.addClassFocus, "");
					}
				}
				if(o.passwordFieldText && inputs[i].type == "password") {
					var fakeInput = document.createElement("input");
					fakeInput.type = "text";
					fakeInput.value = inputs[i].value;
					fakeInput.className = inputs[i].className;
					fakeInput.fake = true;
					inputs[i].parentNode.insertBefore(fakeInput, inputs[i].nextSibling);
					inputsSwap(inputs[i], null);
				}
			}
		}
	}
	if(o.clearTextareas) {
		var textareas = document.getElementsByTagName("textarea");
		for(var i=0; i<textareas.length; i++) {
			if(textareas[i].className.indexOf(o.filterClass)) {
				textareas[i].valueHtml = textareas[i].value;
				textareas[i].onfocus = function() {
					if(this.value == this.valueHtml) this.value = "";
					if(o.addClassFocus) {
						this.className += " " + o.addClassFocus;
						this.parentNode.className += " parent-" + o.addClassFocus;
					}
				}
				textareas[i].onblur = function() {
					if(this.value == "") this.value = this.valueHtml;
					if(o.addClassFocus) {
						this.className = this.className.replace(o.addClassFocus, "");
						this.parentNode.className = this.parentNode.className.replace("parent-"+o.addClassFocus, "");
					}
				}
			}
		}
	}
	function inputsSwap(el, el2) {
		if(el) el.style.display = "none";
		if(el2) el2.style.display = "inline";
	}
}
	
/*
 * jQuery Open/Close plugin
 */
;(function($){
	jQuery.fn.openClose = function(o){
		// default options
		var options = jQuery.extend({
			addClassBeforeAnimation: true,
			activeClass:'active',
			opener:'.opener',
			slider:'.slide',
			animSpeed: 400,
			animStart:false,
			animEnd:false,
			effect:'fade',
			event:'click'
		},o);

		return this.each(function(){
			// options
			var holder = jQuery(this), animating;
			var opener = jQuery(options.opener, holder);
			var slider = jQuery(options.slider, holder);
			if(slider.length) {
				opener.bind(options.event,function(){
					if(!animating) {
						animating = true;
						if(typeof options.animStart === 'function') options.animStart();
						if(holder.hasClass(options.activeClass)) {
							toggleEffects[options.effect].hide({
								speed: options.animSpeed,
								box: slider,
								complete: function() {
									animating = false;
									if(!options.addClassBeforeAnimation) {
										holder.removeClass(options.activeClass);
									}
									if(typeof options.animEnd === 'function') options.animEnd();
								}
							});
							if(options.addClassBeforeAnimation) {
								holder.removeClass(options.activeClass);
							}
						} else {
							if(options.addClassBeforeAnimation) {
								holder.addClass(options.activeClass);
							}
							toggleEffects[options.effect].show({
								speed: options.animSpeed,
								box: slider,
								complete: function() {
									animating = false;
									if(!options.addClassBeforeAnimation) {
										holder.addClass(options.activeClass);
									}
									if(typeof options.animEnd === 'function') options.animEnd();
								}
							})
						}
					}
					return false;
				});
				if(holder.hasClass(options.activeClass)) {
					slider.show();
				}
				else {
					slider.hide();
				}
			}
		});
	}
	
	// animation effects
	var toggleEffects = {
		slide: {
			show: function(o) {
				o.box.slideDown(o.speed, o.complete);
			},
			hide: function(o) {
				o.box.slideUp(o.speed, o.complete);
			}
		},
		fade: {
			show: function(o) {
				o.box.fadeIn(o.speed, o.complete);
			},
			hide: function(o) {
				o.box.fadeOut(o.speed, o.complete);
			}
		}
	}
}(jQuery));

// version 1.4.0
// http://welcome.totheinter.net/columnizer-jquery-plugin/
// created by: Adam Wulf adam.wulf@gmail.com

(function($){

 jQuery.fn.columnize = function(options) {


	var defaults = {
		// default width of columnx
		width: 400,
		// optional # of columns instead of width
		columns : false,
		// true to build columns once regardless of window resize
		// false to rebuild when content box changes bounds
		buildOnce : false,
		// an object with options if the text should overflow
		// it's container if it can't fit within a specified height
		overflow : false,
		// this function is called after content is columnized
		doneFunc : function(){},
		// if the content should be columnized into a 
		// container node other than it's own node
		target : false,
		// re-columnizing when images reload might make things
		// run slow. so flip this to true if it's causing delays
		ignoreImageLoading : true,
		// should columns float left or right
		float : "left",
		// ensure the last column is never the tallest column
		lastNeverTallest : false
	};
	var options = jQuery.extend(defaults, options);

    return this.each(function() {
	    var $inBox = options.target ? jQuery(options.target) : jQuery(this);
		var maxHeight = jQuery(this).height();
		var $cache = jQuery('<div></div>'); // this is where we'll put the real content
		var lastWidth = 0;
		var columnizing = false;
		$cache.append(jQuery(this).children().clone(true));
	    
	    // images loading after dom load
	    // can screw up the column heights,
	    // so recolumnize after images load
	    if(!options.ignoreImageLoading && !options.target){
	    	if(!$inBox.data("imageLoaded")){
		    	$inBox.data("imageLoaded", true);
		    	if($(this).find("img").length > 0){
		    		// only bother if there are
		    		// actually images...
			    	var func = function($inBox,$cache){ return function(){
				    	if(!$inBox.data("firstImageLoaded")){
				    		$inBox.data("firstImageLoaded", "true");
					    	$inBox.empty().append($cache.children().clone(true));
					    	$inBox.columnize(options);
				    	}
			    	}}(jQuery(this), $cache);
				    jQuery(this).find("img").one("load", func);
				    jQuery(this).find("img").one("abort", func);
				    return;
		    	}
	    	}
	    }
	    
		$inBox.empty();
		
		columnizeIt();
		
		if(!options.buildOnce){
			jQuery(window).resize(function() {
				if(!options.buildOnce && jQuery.browser.msie){
					if($inBox.data("timeout")){
						clearTimeout($inBox.data("timeout"));
					}
					$inBox.data("timeout", setTimeout(columnizeIt, 200));
				}else if(!options.buildOnce){
					columnizeIt();
				}else{
					// don't rebuild
				}
			});
		}
		
		/**
		 * return a node that has a height
		 * less than or equal to height
		 *
		 * @param putInHere, a dom element
		 * @$pullOutHere, a jQuery element
		 */
		function columnize($putInHere, $pullOutHere, $parentColumn, height){
			while($parentColumn.height() < height &&
				  $pullOutHere[0].childNodes.length){
				$putInHere.append($pullOutHere[0].childNodes[0]);
			}
			if($putInHere[0].childNodes.length == 0) return;
			
			// now we're too tall, undo the last one
			var kids = $putInHere[0].childNodes;
			var lastKid = kids[kids.length-1];
			$putInHere[0].removeChild(lastKid);
			var $item = jQuery(lastKid);
			
			
			if($item[0].nodeType == 3){
				// it's a text node, split it up
				var oText = $item[0].nodeValue;
				var counter2 = options.width / 18;
				if(options.accuracy)
				counter2 = options.accuracy;
				var columnText;
				var latestTextNode = null;
				while($parentColumn.height() < height && oText.length){
					if (oText.indexOf(' ', counter2) != '-1') {
						columnText = oText.substring(0, oText.indexOf(' ', counter2));
					} else {
						columnText = oText;
					}
					latestTextNode = document.createTextNode(columnText);
					$putInHere.append(latestTextNode);
					
					if(oText.length > counter2){
						oText = oText.substring(oText.indexOf(' ', counter2));
					}else{
						oText = "";
					}
				}
				if($parentColumn.height() >= height && latestTextNode != null){
					// too tall :(
					$putInHere[0].removeChild(latestTextNode);
					oText = latestTextNode.nodeValue + oText;
				}
				if(oText.length){
					$item[0].nodeValue = oText;
				}else{
					return false; // we ate the whole text node, move on to the next node
				}
			}
			
			if($pullOutHere.children().length){
				$pullOutHere.prepend($item);
			}else{
				$pullOutHere.append($item);
			}
			
			return $item[0].nodeType == 3;
		}
		
		function split($putInHere, $pullOutHere, $parentColumn, height){
			if($pullOutHere.children().length){
				$cloneMe = $pullOutHere.children(":first");
				$clone = $cloneMe.clone(true);
				if($clone.attr("nodeType") == 1 && !$clone.hasClass("dontend")){ 
					$putInHere.append($clone);
					if($clone.is("img") && $parentColumn.height() < height + 20){
						$cloneMe.remove();
					}else if(!$cloneMe.hasClass("dontsplit") && $parentColumn.height() < height + 20){
						$cloneMe.remove();
					}else if($clone.is("img") || $cloneMe.hasClass("dontsplit")){
						$clone.remove();
					}else{
						$clone.empty();
						if(!columnize($clone, $cloneMe, $parentColumn, height)){
							if($cloneMe.children().length){
								split($clone, $cloneMe, $parentColumn, height);
							}
						}
						if($clone.get(0).childNodes.length == 0){
							// it was split, but nothing is in it :(
							$clone.remove();
						}
					}
				}
			}
		}
		
		
		function singleColumnizeIt() {
			if ($inBox.data("columnized") && $inBox.children().length == 1) {
				return;
			}
			$inBox.data("columnized", true);
			$inBox.data("columnizing", true);
			
			$inBox.empty();
			$inBox.append(jQuery("<div class='first last column' style='width:98%; padding: 3px; float: " + options.float + ";'></div>")); //"
			$col = $inBox.children().eq($inBox.children().length-1);
			$destroyable = $cache.clone(true);
			if(options.overflow){
				targetHeight = options.overflow.height;
				columnize($col, $destroyable, $col, targetHeight);
				// make sure that the last item in the column isn't a "dontend"
				if(!$destroyable.children().find(":first-child").hasClass("dontend")){
					split($col, $destroyable, $col, targetHeight);
				}
				
				while(checkDontEndColumn($col.children(":last").length && $col.children(":last").get(0))){
					var $lastKid = $col.children(":last");
					$lastKid.remove();
					$destroyable.prepend($lastKid);
				}

				var html = "";
				var div = document.createElement('DIV');
				while($destroyable[0].childNodes.length > 0){
					var kid = $destroyable[0].childNodes[0];
					for(var i=0;i<kid.attributes.length;i++){
						if(kid.attributes[i].nodeName.indexOf("jQuery") == 0){
							kid.removeAttribute(kid.attributes[i].nodeName);
						}
					}
					div.innerHTML = "";
					div.appendChild($destroyable[0].childNodes[0]);
					html += div.innerHTML;
				}
				var overflow = jQuery(options.overflow.id)[0];
				overflow.innerHTML = html;

			}else{
				$col.append($destroyable);
			}
			$inBox.data("columnizing", false);
			
			if(options.overflow){
				options.overflow.doneFunc();
			}
			
		}
		
		function checkDontEndColumn(dom){
			if(dom.nodeType != 1) return false;
			if(jQuery(dom).hasClass("dontend")) return true;
			if(dom.childNodes.length == 0) return false;
			return checkDontEndColumn(dom.childNodes[dom.childNodes.length-1]);
		}
		
		function columnizeIt() {
			if(lastWidth == $inBox.width()) return;
			lastWidth = $inBox.width();
			
			var numCols = Math.round($inBox.width() / options.width);
			if(options.columns) numCols = options.columns;
//			if ($inBox.data("columnized") && numCols == $inBox.children().length) {
//				return;
//			}
			if(numCols <= 1){
				return singleColumnizeIt();
			}
			if($inBox.data("columnizing")) return;
			$inBox.data("columnized", true);
			$inBox.data("columnizing", true);
			
			$inBox.empty();
			$inBox.append(jQuery("<div style='width:" + (Math.round(100 / numCols) - 2)+ "%; padding: 3px; float: " + options.float + ";'></div>")); //"
			$col = $inBox.children(":last");
			$col.append($cache.clone());
			maxHeight = $col.height();
			$inBox.empty();
			
			var targetHeight = maxHeight / numCols;
			var firstTime = true;
			var maxLoops = 3;
			var scrollHorizontally = false;
			if(options.overflow){
				maxLoops = 1;
				targetHeight = options.overflow.height;
			}else if(options.height && options.width){
				maxLoops = 1;
				targetHeight = options.height;
				scrollHorizontally = true;
			}
			
			for(var loopCount=0;loopCount<maxLoops;loopCount++){
				$inBox.empty();
				var $destroyable;
				try{
					$destroyable = $cache.clone(true);
				}catch(e){
					// jquery in ie6 can't clone with true
					$destroyable = $cache.clone();
				}
				$destroyable.css("visibility", "hidden");
				// create the columns
				for (var i = 0; i < numCols; i++) {
					/* create column */
					var className = (i == 0) ? "first column" : "column";
					var className = (i == numCols - 1) ? ("last " + className) : className;
					$inBox.append(jQuery("<div class='" + className + "' style='width:" + (Math.round(100 / numCols) - 2)+ "%; float: " + options.float + ";'></div>")); //"
				}
				
				// fill all but the last column (unless overflowing)
				var i = 0;
				while(i < numCols - (options.overflow ? 0 : 1) || scrollHorizontally && $destroyable.children().length){
					if($inBox.children().length <= i){
						// we ran out of columns, make another
						$inBox.append($("<div class='" + className + "' style='width:" + (Math.round(100 / numCols) - 2)+ "%; float: " + options.float + ";'></div>")); //"
					}
					var $col = $inBox.children().eq(i);
					columnize($col, $destroyable, $col, targetHeight);
					// make sure that the last item in the column isn't a "dontend"
					if(!$destroyable.children().find(":first-child").hasClass("dontend")){
						split($col, $destroyable, $col, targetHeight);
					}else{
//						alert("not splitting a dontend");
					}
					
					while(checkDontEndColumn($col.children(":last").length && $col.children(":last").get(0))){
						var $lastKid = $col.children(":last");
						$lastKid.remove();
						$destroyable.prepend($lastKid);
					}
					i++;
				}
				if(options.overflow && !scrollHorizontally){
					var IE6 = false /*@cc_on || @_jscript_version < 5.7 @*/;
					var IE7 = (document.all) && (navigator.appVersion.indexOf("MSIE 7.") != -1);
					if(IE6 || IE7){
						var html = "";
						var div = document.createElement('DIV');
						while($destroyable[0].childNodes.length > 0){
							var kid = $destroyable[0].childNodes[0];
							for(var i=0;i<kid.attributes.length;i++){
								if(kid.attributes[i].nodeName.indexOf("jQuery") == 0){
									kid.removeAttribute(kid.attributes[i].nodeName);
								}
							}
							div.innerHTML = "";
							div.appendChild($destroyable[0].childNodes[0]);
							html += div.innerHTML;
						}
						var overflow = jQuery(options.overflow.id)[0];
						overflow.innerHTML = html;
					}else{
						jQuery(options.overflow.id).empty().append($destroyable.children().clone(true));
					}
				}else if(!scrollHorizontally){
					// the last column in the series
					$col = $inBox.children().eq($inBox.children().length-1);
					while($destroyable.children().length) $col.append($destroyable.children(":first"));
					var afterH = $col.height();
					var diff = afterH - targetHeight;
					var totalH = 0;
					var min = 10000000;
					var max = 0;
					var lastIsMax = false;
					$inBox.children().each(function($inBox){ return function($item){
						var h = $inBox.children().eq($item).height();
						lastIsMax = false;
						totalH += h;
						if(h > max) {
							max = h;
							lastIsMax = true;
						}
						if(h < min) min = h;
					}}($inBox));

					var avgH = totalH / numCols;
					if(options.lastNeverTallest && lastIsMax){
						// the last column is the tallest
						// so allow columns to be taller
						// and retry
						targetHeight = targetHeight + 30;
						if(loopCount == maxLoops-1) maxLoops++;
					}else if(max - min > 30){
						// too much variation, try again
						targetHeight = avgH + 30;
					}else if(Math.abs(avgH-targetHeight) > 20){
						// too much variation, try again
						targetHeight = avgH;
					}else {
						// solid, we're done
						loopCount = maxLoops;
					}
				}else{
					// it's scrolling horizontally, fix the width/classes of the columns
					$inBox.children().each(function(i){
						$col = $inBox.children().eq(i);
						$col.width(options.width + "px");
						if(i==0){
							$col.addClass("first");
						}else if(i==$inBox.children().length-1){
							$col.addClass("last");
						}else{
							$col.removeClass("first");
							$col.removeClass("last");
						}
					});
					$inBox.width($inBox.children().length * options.width + "px");
				}
				$inBox.append($("<br style='clear:both;'>"));
			}
			$inBox.find('.column').find(':first.removeiffirst').remove();
			$inBox.find('.column').find(':last.removeiflast').remove();
			$inBox.data("columnizing", false);

			if(options.overflow){
				options.overflow.doneFunc();
			}
			options.doneFunc();
		}
    });
 };
})(jQuery);
