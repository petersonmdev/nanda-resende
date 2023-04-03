(function($) {	
	"use strict";

	// Loadie
	var parcent = 1;
	$('body').loadie(parcent);

	// Zoom Product
	var imgzoom = $('#productSimple figure.zoom');
	$(imgzoom).zoom();

	// owl Carrousel
	$('#category-js').owlCarousel({
		loop:true,
		margin:10,
		responsiveClass:true,
		responsive:{
			0:{
				items:3,
				nav:false
			},
			600:{
				items:3,
				nav:false,
				loop: true
			},
			1000:{
				items:6,
				nav:false,
				loop:false
			}
		}
	});
	$('#destaques').owlCarousel({
		loop:true,
		margin:10,
		responsiveClass:true,
		responsive:{
			0:{
				items:2,
				nav:false
			},
			600:{
				items:3,
				nav:false,
				loop: true
			}
		}
	});
	$('#lancamentos').owlCarousel({
		loop:true,
		margin:10,
		responsiveClass:true,
		responsive:{
			0:{
				items:2,
				nav:false
			},
			600:{
				items:3,
				nav:false,
				loop: true
			}
		}
	});
	$('#maisvistos').owlCarousel({
		loop:true,
		margin:10,
		responsiveClass:true,
		responsive:{
			0:{
				items:2,
				nav:false
			},
			600:{
				items:3,
				nav:false,
				loop: true
			}
		}
	});
	$('#interesse').owlCarousel({
		loop:true,
		margin:10,
		responsiveClass:true,
		responsive:{
			0:{
				items:2,
				nav:false
			},
			600:{
				items:4,
				nav:false,
				loop: true
			},
			1000:{
				items:6,
				nav:false,
				loop:false
			}
		}
	});

	$(function() {
		var $searchOverlay = $(".search-overlay");
		var $search = $(".search_desk");
		var $clone, offsetX, offsetY;
		var $form = $("#searchForm");

		$search.on("click", function() {
			var $original = $(this);
			$clone = $(this).clone(true);

			$searchOverlay.addClass("s--active");

			$clone.addClass("s--cloned s--hidden");
			$searchOverlay.append($clone);

			var triggerLayout = $searchOverlay.offset().top;

			var originalRect = $original[0].getBoundingClientRect();
			var cloneRect = $clone[0].getBoundingClientRect();

			offsetX = originalRect.left - cloneRect.left;
			offsetY = originalRect.top - cloneRect.top;

			$clone.css("transform", "translate("+ offsetX +"px, "+ offsetY +"px)");
			$original.addClass("s--hidden");
			$clone.removeClass("s--hidden");

			var triggerLayout = $searchOverlay.offset().top;

			$clone.addClass("s--moving");

			$clone.attr("style", "");

			$clone.on("transitionend", openAfterMove);
		});

		function openAfterMove() {
			$clone.addClass("s--active");
			$clone.find("input").focus();

			addCloseHandler($clone);
			$clone.off("transitionend", openAfterMove);
		};

		function addCloseHandler($parent) {
			var $closeBtn = $parent.find(".search__close");
			$closeBtn.on("click", closeHandler);
		};

		/* close handler functions */
		function closeHandler(e) {
			$clone.removeClass("s--active");
			e.stopPropagation();

			var $cloneBg = $clone.find(".search__bg");

			$cloneBg.on("transitionend", moveAfterClose);
		};

		function moveAfterClose(e) {
			e.stopPropagation(); // prevents from double transitionend even fire on parent $clone

			$clone.addClass("s--moving");
			$clone.css("transform", "translate("+ offsetX +"px, "+ offsetY +"px)");
			$clone.on("transitionend", terminateSearch);
		};

		function terminateSearch(e) {
			$search.removeClass("s--hidden");
			$clone.remove();
			$searchOverlay.removeClass("s--active");
		};

		$('#searchForm').submit(function(event) {
			event.preventDefault();
			var actionUrl = $(this).attr('action');
			var formData = $(this).serialize();

			$.post(actionUrl, formData, function(data) {
				$(document.body).html(data);
			});
		});
	});
	
	//1.Hide Loading Box (Preloader)
	function handlePreloader() {
		if($('.preloader').length){
			$('.preloader').delay(200).fadeOut(500);
		}
	}	
	
	//6.Scroll to a Specific Div
	if($('.scroll-to-target').length){
		$(".scroll-to-target").click('click', function() {
			var target = $(this).attr('data-target');
		   // animate
		   $('html, body').animate({
			   scrollTop: $(target).offset().top
			 }, 1000);
	
		});
	}

	//20.Contact Form Validation
	if($("#contact-form").length){
	    $("#contact-form").validate({
	        submitHandler: function(form) {
	          var form_btn = $(form).find('button[type="submit"]');
	          var form_result_div = '#form-result';
	          $(form_result_div).remove();
	          form_btn.before('<div id="form-result" class="alert alert-success" role="alert" style="display: none;"></div>');
	          var form_btn_old_msg = form_btn.html();
	          form_btn.html(form_btn.prop('disabled', true).data("loading-text"));
	          $(form).ajaxSubmit({
	            dataType:  'json',
	            success: function(data) {
	              if( data.status = 'true' ) {
	                $(form).find('.form-control').val('');
	              }
	              form_btn.prop('disabled', false).html(form_btn_old_msg);
	              $(form_result_div).html(data.message).fadeIn('slow');
	              setTimeout(function(){ $(form_result_div).fadeOut('slow') }, 6000);
	            }
	          });
	        }
	    });
	}

	//22.Appoinment Form Validation
	if($("#appoinment-form").length){
	    $("#appoinment-form").validate({
	        submitHandler: function(form) {
	          var form_btn = $(form).find('button[type="submit"]');
	          var form_result_div = '#form-result';
	          $(form_result_div).remove();
	          form_btn.before('<div id="form-result" class="alert alert-success" role="alert" style="display: none;"></div>');
	          var form_btn_old_msg = form_btn.html();
	          form_btn.html(form_btn.prop('disabled', true).data("loading-text"));
	          $(form).ajaxSubmit({
	            dataType:  'json',
	            success: function(data) {
	              if( data.status = 'true' ) {
	                $(form).find('.form-control').val('');
	              }
	              form_btn.prop('disabled', false).html(form_btn_old_msg);
	              $(form_result_div).html(data.message).fadeIn('slow');
	              setTimeout(function(){ $(form_result_div).fadeOut('slow') }, 6000);
	            }
	          });
	        }
	    });
	}

	//26.Date picker
	function datepicker () {
	    if ($('#datepicker').length) {
	        $('#datepicker').datepicker();
	    };
	}

	//27.Select menu 
	function selectDropdown() {
	    if ($(".selectmenu").length) {
	        $(".selectmenu").selectmenu();

	        var changeSelectMenu = function(event, item) {
	            $(this).trigger('change', item);
	        };
	        $(".selectmenu").selectmenu({ change: changeSelectMenu });
	    };
	}	
	
	//28.Elements Animation
	if($('.wow').length){
		var wow = new WOW(
		  {
			boxClass:     'wow',      // animated element css class (default is wow)
			animateClass: 'animated', // animation css class (default is animated)
			offset:       0,          // distance to the element when triggering the animation (default is 0)
			mobile:       false,       // trigger animations on mobile devices (default is true)
			live:         true       // act on asynchronously loaded content (default is true)
		  }
		);
		wow.init();
	}

	// Hero Slider
	$('.hero-slider').slick({
		slidesToShow: 1,
		autoplay: true,
		autoplaySpeed: 5000,
		infinite: true,
		speed: 300,
		dots: true,
		arrows: false,
		fade: true,
		responsive: [
			{
				breakpoint: 600,
				settings: {
					arrows: false
				}
			}
		]
	});
	// Item Slider
	$('.items-container').slick({
		infinite: true,
		arrows: true,
		autoplay: true,
		slidesToShow: 3,
		slidesToScroll: 1,
		responsive: [
			{
				breakpoint: 991,
				settings: {
					slidesToShow: 2,
					arrows: false
				}
			},
			{
				breakpoint: 525,
				settings: {
					slidesToShow: 1,
					arrows: false
				}
			}
		]
	});
	// Testimonial Slider
	$('.testimonial-carousel').slick({
		infinite: true,
		arrows: false,
		autoplay: true,
		slidesToShow: 2,
		dots: true,
		slidesToScroll: 2,
		responsive: [
			{
				breakpoint: 991,
				settings: {
					slidesToShow: 2
				}
			},
			{
				breakpoint: 525,
				settings: {
					slidesToShow: 1
				}
			}
		]
	});
	
	// FancyBox Video
	$('[data-fancybox]').fancybox({
		youtube: {
			controls: 0,
			showinfo: 0
		},
		vimeo: {
			color: 'f00'
		}
	});

/* ========================When document is loaded, do===================== */
	$(window).on('load', function() {
		// add your functions
		(function ($) {
			handlePreloader();
			datepicker();
		})(jQuery);
	});

/* ======================================================= */

	$('#productSimple').on('slide.bs.carousel', function(e) {
	    var from = $('.carousel-vertical .nav li.active').index();
	    var next = $(e.relatedTarget);
	    var to =  next.index();
	  
	  	$('.carousel-vertical a.nav-link').removeClass('active').eq(to).addClass('active');
	});

	// Logo
    $('.logo-subtitle').lettering();
    var logo = jQuery('.logo img'),
    	header = jQuery('.header-uper'),
    	w = logo.width();
    jQuery(window).scroll(function () {
        if (jQuery(this).scrollTop() > 20) {
            logo.css({
              "width": w/1.2
                     });
            header.addClass('scroll-header');
            header.removeClass('topo-header');
        } else{
            logo.css({
              "width": w
                     });
            header.addClass('topo-header');
            header.removeClass('scroll-header');
        }
    });
    

})(window.jQuery);

$(document).foundation();

/*global define*/
(function (global, undefined) {
	"use strict";

	var document = global.document,
		Alertify;

	Alertify = function () {

		var _alertify = {},
			dialogs = {},
			isopen = false,
			keys = { ENTER: 13, ESC: 27, SPACE: 32 },
			queue = [],
			$, btnCancel, btnOK, btnReset, btnResetBack, btnFocus, elCallee, elCover, elDialog, elLog, form, input, getTransitionEvent;

		/**
		 * Markup pieces
		 * @type {Object}
		 */
		dialogs = {
			buttons: {
				holder: "<nav class=\"alertify-buttons\">{{buttons}}</nav>",
				submit: "<button type=\"submit\" class=\"alertify-button alertify-button-ok\" id=\"alertify-ok\">{{ok}}</button>",
				ok: "<button class=\"alertify-button alertify-button-ok\" id=\"alertify-ok\">{{ok}}</button>",
				cancel: "<button class=\"alertify-button alertify-button-cancel\" id=\"alertify-cancel\">{{cancel}}</button>"
			},
			input: "<div class=\"alertify-text-wrapper\"><input type=\"text\" class=\"alertify-text\" id=\"alertify-text\"></div>",
			message: "<p class=\"alertify-message\">{{message}}</p>",
			log: "<article class=\"alertify-log{{class}}\">{{message}}</article>"
		};

		/**
		 * Return the proper transitionend event
		 * @return {String}    Transition type string
		 */
		getTransitionEvent = function () {
			var t,
				type,
				supported = false,
				el = document.createElement("fakeelement"),
				transitions = {
					"WebkitTransition": "webkitTransitionEnd",
					"MozTransition": "transitionend",
					"OTransition": "otransitionend",
					"transition": "transitionend"
				};

			for (t in transitions) {
				if (el.style[t] !== undefined) {
					type = transitions[t];
					supported = true;
					break;
				}
			}

			return {
				type: type,
				supported: supported
			};
		};

		/**
		 * Shorthand for document.getElementById()
		 *
		 * @param  {String} id    A specific element ID
		 * @return {Object}       HTML element
		 */
		$ = function (id) {
			return document.getElementById(id);
		};

		/**
		 * Alertify private object
		 * @type {Object}
		 */
		_alertify = {

			/**
			 * Labels object
			 * @type {Object}
			 */
			labels: {
				ok: "OK",
				cancel: "Cancel"
			},

			/**
			 * Delay number
			 * @type {Number}
			 */
			delay: 5000,

			/**
			 * Whether buttons are reversed (default is secondary/primary)
			 * @type {Boolean}
			 */
			buttonReverse: false,

			/**
			 * Which button should be focused by default
			 * @type {String}	"ok" (default), "cancel", or "none"
			 */
			buttonFocus: "ok",

			/**
			 * Set the transition event on load
			 * @type {[type]}
			 */
			transition: undefined,

			/**
			 * Set the proper button click events
			 *
			 * @param {Function} fn    [Optional] Callback function
			 *
			 * @return {undefined}
			 */
			addListeners: function (fn) {
				var hasOK = (typeof btnOK !== "undefined"),
					hasCancel = (typeof btnCancel !== "undefined"),
					hasInput = (typeof input !== "undefined"),
					val = "",
					self = this,
					ok, cancel, common, key, reset;

				// ok event handler
				ok = function (event) {
					if (typeof event.preventDefault !== "undefined") event.preventDefault();
					common(event);
					if (typeof input !== "undefined") val = input.value;
					if (typeof fn === "function") {
						if (typeof input !== "undefined") {
							fn(true, val);
						}
						else fn(true);
					}
					return false;
				};

				// cancel event handler
				cancel = function (event) {
					if (typeof event.preventDefault !== "undefined") event.preventDefault();
					common(event);
					if (typeof fn === "function") fn(false);
					return false;
				};

				// common event handler (keyup, ok and cancel)
				common = function (event) {
					self.hide();
					self.unbind(document.body, "keyup", key);
					self.unbind(btnReset, "focus", reset);
					if (hasOK) self.unbind(btnOK, "click", ok);
					if (hasCancel) self.unbind(btnCancel, "click", cancel);
				};

				// keyup handler
				key = function (event) {
					var keyCode = event.keyCode;
					if ((keyCode === keys.SPACE && !hasInput) || (hasInput && keyCode === keys.ENTER)) ok(event);
					if (keyCode === keys.ESC && hasCancel) cancel(event);
				};

				// reset focus to first item in the dialog
				reset = function (event) {
					if (hasInput) input.focus();
					else if (!hasCancel || self.buttonReverse) btnOK.focus();
					else btnCancel.focus();
				};

				// handle reset focus link
				// this ensures that the keyboard focus does not
				// ever leave the dialog box until an action has
				// been taken
				this.bind(btnReset, "focus", reset);
				this.bind(btnResetBack, "focus", reset);
				// handle OK click
				if (hasOK) this.bind(btnOK, "click", ok);
				// handle Cancel click
				if (hasCancel) this.bind(btnCancel, "click", cancel);
				// listen for keys, Cancel => ESC
				this.bind(document.body, "keyup", key);
				if (!this.transition.supported) {
					this.setFocus();
				}
			},

			/**
			 * Bind events to elements
			 *
			 * @param  {Object}   el       HTML Object
			 * @param  {Event}    event    Event to attach to element
			 * @param  {Function} fn       Callback function
			 *
			 * @return {undefined}
			 */
			bind: function (el, event, fn) {
				if (typeof el.addEventListener === "function") {
					el.addEventListener(event, fn, false);
				} else if (el.attachEvent) {
					el.attachEvent("on" + event, fn);
				}
			},

			/**
			 * Use alertify as the global error handler (using window.onerror)
			 *
			 * @return {boolean} success
			 */
			handleErrors: function () {
				if (typeof global.onerror !== "undefined") {
					var self = this;
					global.onerror = function (msg, url, line) {
						self.error("[" + msg + " on line " + line + " of " + url + "]", 0);
					};
					return true;
				} else {
					return false;
				}
			},

			/**
			 * Append button HTML strings
			 *
			 * @param {String} secondary    The secondary button HTML string
			 * @param {String} primary      The primary button HTML string
			 *
			 * @return {String}             The appended button HTML strings
			 */
			appendButtons: function (secondary, primary) {
				return this.buttonReverse ? primary + secondary : secondary + primary;
			},

			/**
			 * Build the proper message box
			 *
			 * @param  {Object} item    Current object in the queue
			 *
			 * @return {String}         An HTML string of the message box
			 */
			build: function (item) {
				var html = "",
					type = item.type,
					message = item.message,
					css = item.cssClass || "";

				html += "<div class=\"alertify-dialog\">";
				html += "<a id=\"alertify-resetFocusBack\" class=\"alertify-resetFocus\" href=\"#\">Reset Focus</a>";

				if (_alertify.buttonFocus === "none") html += "<a href=\"#\" id=\"alertify-noneFocus\" class=\"alertify-hidden\"></a>";

				// doens't require an actual form
				if (type === "prompt") html += "<div id=\"alertify-form\">";

				html += "<article class=\"alertify-inner\">";
				html += dialogs.message.replace("{{message}}", message);

				if (type === "prompt") html += dialogs.input;

				html += dialogs.buttons.holder;
				html += "</article>";

				if (type === "prompt") html += "</div>";

				html += "<a id=\"alertify-resetFocus\" class=\"alertify-resetFocus\" href=\"#\">Reset Focus</a>";
				html += "</div>";

				switch (type) {
					case "confirm":
						html = html.replace("{{buttons}}", this.appendButtons(dialogs.buttons.cancel, dialogs.buttons.ok));
						html = html.replace("{{ok}}", this.labels.ok).replace("{{cancel}}", this.labels.cancel);
						break;
					case "prompt":
						html = html.replace("{{buttons}}", this.appendButtons(dialogs.buttons.cancel, dialogs.buttons.submit));
						html = html.replace("{{ok}}", this.labels.ok).replace("{{cancel}}", this.labels.cancel);
						break;
					case "alert":
						html = html.replace("{{buttons}}", dialogs.buttons.ok);
						html = html.replace("{{ok}}", this.labels.ok);
						break;
					default:
						break;
				}

				elDialog.className = "alertify alertify-" + type + " " + css;
				elCover.className = "alertify-cover";
				return html;
			},

			/**
			 * Close the log messages
			 *
			 * @param  {Object} elem    HTML Element of log message to close
			 * @param  {Number} wait    [optional] Time (in ms) to wait before automatically hiding the message, if 0 never hide
			 *
			 * @return {undefined}
			 */
			close: function (elem, wait) {
				// Unary Plus: +"2" === 2
				var timer = (wait && !isNaN(wait)) ? +wait : this.delay,
					self = this,
					hideElement, transitionDone;

				// set click event on log messages
				this.bind(elem, "click", function () {
					hideElement(elem);
				});
				// Hide the dialog box after transition
				// This ensure it doens't block any element from being clicked
				transitionDone = function (event) {
					event.stopPropagation();
					// unbind event so function only gets called once
					self.unbind(this, self.transition.type, transitionDone);
					// remove log message
					elLog.removeChild(this);
					if (!elLog.hasChildNodes()) elLog.className += " alertify-logs-hidden";
				};
				// this sets the hide class to transition out
				// or removes the child if css transitions aren't supported
				hideElement = function (el) {
					// ensure element exists
					if (typeof el !== "undefined" && el.parentNode === elLog) {
						// whether CSS transition exists
						if (self.transition.supported) {
							self.bind(el, self.transition.type, transitionDone);
							el.className += " alertify-log-hide";
						} else {
							elLog.removeChild(el);
							if (!elLog.hasChildNodes()) elLog.className += " alertify-logs-hidden";
						}
					}
				};
				// never close (until click) if wait is set to 0
				if (wait === 0) return;
				// set timeout to auto close the log message
				setTimeout(function () { hideElement(elem); }, timer);
			},

			/**
			 * Create a dialog box
			 *
			 * @param  {String}   message        The message passed from the callee
			 * @param  {String}   type           Type of dialog to create
			 * @param  {Function} fn             [Optional] Callback function
			 * @param  {String}   placeholder    [Optional] Default value for prompt input field
			 * @param  {String}   cssClass       [Optional] Class(es) to append to dialog box
			 *
			 * @return {Object}
			 */
			dialog: function (message, type, fn, placeholder, cssClass) {
				// set the current active element
				// this allows the keyboard focus to be resetted
				// after the dialog box is closed
				elCallee = document.activeElement;
				// check to ensure the alertify dialog element
				// has been successfully created
				var check = function () {
					if ((elLog && elLog.scrollTop !== null) && (elCover && elCover.scrollTop !== null)) return;
					else check();
				};
				// error catching
				if (typeof message !== "string") throw new Error("message must be a string");
				if (typeof type !== "string") throw new Error("type must be a string");
				if (typeof fn !== "undefined" && typeof fn !== "function") throw new Error("fn must be a function");
				// initialize alertify if it hasn't already been done
				this.init();
				check();

				queue.push({ type: type, message: message, callback: fn, placeholder: placeholder, cssClass: cssClass });
				if (!isopen) this.setup();

				return this;
			},

			/**
			 * Extend the log method to create custom methods
			 *
			 * @param  {String} type    Custom method name
			 *
			 * @return {Function}
			 */
			extend: function (type) {
				if (typeof type !== "string") throw new Error("extend method must have exactly one paramter");
				return function (message, wait) {
					this.log(message, type, wait);
					return this;
				};
			},

			/**
			 * Hide the dialog and rest to defaults
			 *
			 * @return {undefined}
			 */
			hide: function () {
				var transitionDone,
					self = this;
				// remove reference from queue
				queue.splice(0, 1);
				// if items remaining in the queue
				if (queue.length > 0) this.setup(true);
				else {
					isopen = false;
					// Hide the dialog box after transition
					// This ensure it doens't block any element from being clicked
					transitionDone = function (event) {
						event.stopPropagation();
						// unbind event so function only gets called once
						self.unbind(elDialog, self.transition.type, transitionDone);
					};
					// whether CSS transition exists
					if (this.transition.supported) {
						this.bind(elDialog, this.transition.type, transitionDone);
						elDialog.className = "alertify alertify-hide alertify-hidden";
					} else {
						elDialog.className = "alertify alertify-hide alertify-hidden alertify-isHidden";
					}
					elCover.className = "alertify-cover alertify-cover-hidden";
					// set focus to the last element or body
					// after the dialog is closed
					elCallee.focus();
				}
			},

			/**
			 * Initialize Alertify
			 * Create the 2 main elements
			 *
			 * @return {undefined}
			 */
			init: function () {
				// ensure legacy browsers support html5 tags
				document.createElement("nav");
				document.createElement("article");
				document.createElement("section");
				// cover
				if ($("alertify-cover") == null) {
					elCover = document.createElement("div");
					elCover.setAttribute("id", "alertify-cover");
					elCover.className = "alertify-cover alertify-cover-hidden";
					document.body.appendChild(elCover);
				}
				// main element
				if ($("alertify") == null) {
					isopen = false;
					queue = [];
					elDialog = document.createElement("section");
					elDialog.setAttribute("id", "alertify");
					elDialog.className = "alertify alertify-hidden";
					document.body.appendChild(elDialog);
				}
				// log element
				if ($("alertify-logs") == null) {
					elLog = document.createElement("section");
					elLog.setAttribute("id", "alertify-logs");
					elLog.className = "alertify-logs alertify-logs-hidden";
					document.body.appendChild(elLog);
				}
				// set tabindex attribute on body element
				// this allows script to give it focus
				// after the dialog is closed
				document.body.setAttribute("tabindex", "0");
				// set transition type
				this.transition = getTransitionEvent();
			},

			/**
			 * Show a new log message box
			 *
			 * @param  {String} message    The message passed from the callee
			 * @param  {String} type       [Optional] Optional type of log message
			 * @param  {Number} wait       [Optional] Time (in ms) to wait before auto-hiding the log
			 *
			 * @return {Object}
			 */
			log: function (message, type, wait) {
				// check to ensure the alertify dialog element
				// has been successfully created
				var check = function () {
					if (elLog && elLog.scrollTop !== null) return;
					else check();
				};
				// initialize alertify if it hasn't already been done
				this.init();
				check();

				elLog.className = "alertify-logs";
				this.notify(message, type, wait);
				return this;
			},

			/**
			 * Add new log message
			 * If a type is passed, a class name "alertify-log-{type}" will get added.
			 * This allows for custom look and feel for various types of notifications.
			 *
			 * @param  {String} message    The message passed from the callee
			 * @param  {String} type       [Optional] Type of log message
			 * @param  {Number} wait       [Optional] Time (in ms) to wait before auto-hiding
			 *
			 * @return {undefined}
			 */
			notify: function (message, type, wait) {
				var log = document.createElement("article");
				log.className = "alertify-log" + ((typeof type === "string" && type !== "") ? " alertify-log-" + type : "");
				log.innerHTML = message;
				// append child
				elLog.appendChild(log);
				// triggers the CSS animation
				setTimeout(function () { log.className = log.className + " alertify-log-show"; }, 50);
				this.close(log, wait);
			},

			/**
			 * Set properties
			 *
			 * @param {Object} args     Passing parameters
			 *
			 * @return {undefined}
			 */
			set: function (args) {
				var k;
				// error catching
				if (typeof args !== "object" && args instanceof Array) throw new Error("args must be an object");
				// set parameters
				for (k in args) {
					if (args.hasOwnProperty(k)) {
						this[k] = args[k];
					}
				}
			},

			/**
			 * Common place to set focus to proper element
			 *
			 * @return {undefined}
			 */
			setFocus: function () {
				if (input) {
					input.focus();
					input.select();
				}
				else btnFocus.focus();
			},

			/**
			 * Initiate all the required pieces for the dialog box
			 *
			 * @return {undefined}
			 */
			setup: function (fromQueue) {
				var item = queue[0],
					self = this,
					transitionDone;

				// dialog is open
				isopen = true;
				// Set button focus after transition
				transitionDone = function (event) {
					event.stopPropagation();
					self.setFocus();
					// unbind event so function only gets called once
					self.unbind(elDialog, self.transition.type, transitionDone);
				};
				// whether CSS transition exists
				if (this.transition.supported && !fromQueue) {
					this.bind(elDialog, this.transition.type, transitionDone);
				}
				// build the proper dialog HTML
				elDialog.innerHTML = this.build(item);
				// assign all the common elements
				btnReset = $("alertify-resetFocus");
				btnResetBack = $("alertify-resetFocusBack");
				btnOK = $("alertify-ok") || undefined;
				btnCancel = $("alertify-cancel") || undefined;
				btnFocus = (_alertify.buttonFocus === "cancel") ? btnCancel : ((_alertify.buttonFocus === "none") ? $("alertify-noneFocus") : btnOK),
					input = $("alertify-text") || undefined;
				form = $("alertify-form") || undefined;
				// add placeholder value to the input field
				if (typeof item.placeholder === "string" && item.placeholder !== "") input.value = item.placeholder;
				if (fromQueue) this.setFocus();
				this.addListeners(item.callback);
			},

			/**
			 * Unbind events to elements
			 *
			 * @param  {Object}   el       HTML Object
			 * @param  {Event}    event    Event to detach to element
			 * @param  {Function} fn       Callback function
			 *
			 * @return {undefined}
			 */
			unbind: function (el, event, fn) {
				if (typeof el.removeEventListener === "function") {
					el.removeEventListener(event, fn, false);
				} else if (el.detachEvent) {
					el.detachEvent("on" + event, fn);
				}
			}
		};

		return {
			alert: function (message, fn, cssClass) { _alertify.dialog(message, "alert", fn, "", cssClass); return this; },
			confirm: function (message, fn, cssClass) { _alertify.dialog(message, "confirm", fn, "", cssClass); return this; },
			extend: _alertify.extend,
			init: _alertify.init,
			log: function (message, type, wait) { _alertify.log(message, type, wait); return this; },
			prompt: function (message, fn, placeholder, cssClass) { _alertify.dialog(message, "prompt", fn, placeholder, cssClass); return this; },
			success: function (message, wait) { _alertify.log(message, "success", wait); return this; },
			error: function (message, wait) { _alertify.log(message, "error", wait); return this; },
			set: function (args) { _alertify.set(args); },
			labels: _alertify.labels,
			debug: _alertify.handleErrors
		};
	};

	// AMD and window support
	if (typeof define === "function") {
		define([], function () { return new Alertify(); });
	} else if (typeof global.alertify === "undefined") {
		global.alertify = new Alertify();
	}

}(this));


$('button.success').click(function () {
	alertify.set({ delay: 1700 });
	alertify.success("Success notification");
});

$('button.alert').click(function () {
	alertify.set({ delay: 1700 });
	alertify.error("Error notification");
});

$(document).on('change', '.variation-radios input', function () {
	$('select[name="' + $(this).attr('name') + '"]').val($(this).val()).trigger('change');
});
$(document).on('woocommerce_update_variation_values', function () {
	$('.variation-radios input').each(function (index, element) {
		$(element).removeAttr('disabled');
		var thisName = $(element).attr('name');
		var thisVal = $(element).attr('value');
		if ($('select[name="' + thisName + '"] option[value="' + thisVal + '"]').is(':disabled')) {
			$(element).prop('disabled', true);
		}
	});
});

$(document).ready(function() {
	var slider = $("#filterPrice");
	var output = $("#valuePriceFilter");
	output.html(slider.val());

	slider.on("input", function() {
		output.html($(this).val());
	});
});

jQuery(document).ready(function ($) {
	
	$(".inpt-pa-tamanho[name='attribute_pa_tamanho']").click( function () {
		var variation_data = $('form.variations_form').attr('data-product_variations');
		var variation_data = JSON.parse(variation_data);
		$(".reset_variations").css('visibility', 'visible');
		var inpt_select = $(this).filter(':checked').val();
		variation_data.forEach(function (o, index) {			
			var term = o.attributes.attribute_pa_tamanho;
			var stoke = o.availability_html;
			var description = o.variation_description;
			if (term == inpt_select) {				
				$(".woocommerce-variation-description").html('<p>Tamanho escolhido: </p>'+description);
				$(".woocommerce-variation-availability").html(stoke);
			}
		});
	});

	$(".reset_variations").click(function () {
		$(".inpt-pa-tamanho[name='attribute_pa_tamanho']").prop('checked', false); 
		$(".woocommerce-variation-description p").remove();
		$(".woocommerce-variation-availability p").remove();
		$(".reset_variations").css('visibility', 'hidden');
	});

	// .firefox
	var isFF = true;
	var addRule = (function (style) {
		var sheet = document.head.appendChild(style).sheet;
		return function (selector, css) {
			if (isFF) {
				if (sheet.cssRules.length > 0) {
					sheet.deleteRule(0);
				}

				try {
					sheet.insertRule(selector + "{" + css + "}", 0);
				} catch (ex) {
					isFF = false;
				}
			}
		};
	})(document.createElement("style"));

	$('.content-filter-nandaresende input[type=range]').on('input', function () {
		const numRange = this.value;
		const maxRange = this.max;
		const minRang = this.min;
		const totalPercent = Math.round(((numRange - minRang) * 100) / (maxRange - minRang) );

		$(this).css('background', 'linear-gradient(to right, #752566 0%, #752566 ' + totalPercent + '%, #d7d7d7 ' + totalPercent + '%, #d7d7d7 100%)');
	});

	const inptMax = $('.content-filter-nandaresende input[type=range]').attr('max');
	const inptMin = $('.content-filter-nandaresende input[type=range]').attr('min');
	const inptValue = $('.content-filter-nandaresende input[type=range]').attr('value');
	$('.content-filter-nandaresende input[type=range]').css('background', 'linear-gradient(to right, #752566 0%, #752566 ' + Math.round(((inptValue - inptMin) * 100) / (inptMax - inptMin) ) + '%, #d7d7d7 ' + Math.round(((inptValue - inptMin) * 100) / (inptMax - inptMin) ) + '%, #d7d7d7 100%)');

	$(".cat-filter").click(function(e){
		e.preventDefault();
		$("#cat-filter li > a").removeClass("active");
		$(this).addClass("active");
		var category = $(this).attr('data-selected');
		$("input[name=cat-filter]").val(category);

		$("#form-filter").submit();
	});

	$("#filterPrice").change(function(event) {
		$("#form-filter").submit();
	});

});