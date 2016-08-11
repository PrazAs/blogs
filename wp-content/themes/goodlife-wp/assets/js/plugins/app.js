var menuscroll;
var thb_lazyload;
var skroller;

(function ($, window, _) {
	'use strict';
    
	var $doc = $(document),
			win = $(window),
			thb_md = new MobileDetect(window.navigator.userAgent);
	
	var SITE = {
		init: function() {
			var self = this,
					obj;
			
			for (obj in self) {
				if ( self.hasOwnProperty(obj)) {
					var _method =  self[obj];
					if ( _method.selector !== undefined && _method.init !== undefined ) {
						if ( $(_method.selector).length > 0 ) {
							_method.init();
						}
					}
				}
			}
			if (navigator.userAgent.indexOf('Safari') !== -1 && navigator.userAgent.indexOf('Chrome') === -1) {
				$('html').addClass('safari');
			}
		},
		fixedHeader: {
			selector: '.subheader.fixed',
			init: function() {
				var base = this,
						container = $(base.selector);
				
				win.scroll(function(){
					base.scroll(container);
				});
				
				var resizeMegaMenu = _.debounce(function(){
					var parent = $('#menu_width');
					container.find('.thb_mega_menu_holder').css({
						'width' : parent.outerWidth(),
						'left'	: parent.offset().left,
						'right'	: parent.offset().right
					});
				}, 30);
				win.resize(resizeMegaMenu).trigger('resize');
			},
			scroll: function (container) {
				var animationOffset = 400,
						wOffset = win.scrollTop(),
						stick = 'header--slide',
						unstick = 'header--unslide',
						search = container.find('.quick_search');
						
				if (wOffset > animationOffset) {
					if (container.hasClass(unstick)) {
						container.removeClass(unstick);
					}
					if (!container.hasClass(stick)) {
						setTimeout(function () {
							container.addClass(stick);
						}, 10);
					}
				} else if ((wOffset < animationOffset && (wOffset > 0))) {
					if(container.hasClass(stick)) {
						container.removeClass(stick);
						container.addClass(unstick);
						search.removeClass('active');
					}
				} else {
					container.removeClass(stick);
					container.removeClass(unstick);
					search.removeClass('active');
				}
			}
			
		},
		search: {
			selector: '.quick_toggle',
			init: function() {
				var base = this,
						container = $(base.selector);
				
				container.each(function(e) {
					var _this = $(this),
							form = _this.parents('.quick_search');
					_this.on('click', function(e) {
						form.toggleClass('active');
						return false;
					});
				}); 
			}
		},
		responsiveNav: {
			selector: '#wrapper',
			init: function() {
				var base = this,
					container = $(base.selector),
					cc = $('.click-capture'),
					target = $('.mobile-toggle').data('target'),
					span = $('#mobile-menu').find('.mobile-menu li:has(".sub-menu")>a span');
				
				
				$('.mobile-toggle').on('click', function() {
					var that = $(this),
							target= that.data('target');

					container.removeClass('open-menu').addClass(target);
					
					return false;
				});
				cc.on('click', function() {
					container.removeClass('open-menu');
				});
				
				span.on('click', function(e){
					var that = $(this),
							parent = that.parents('a'),
							menu = parent.next('.sub-menu');
					
					if (parent.hasClass('active')) {
						parent.removeClass('active');
						menu.slideUp('200', function() {
							setTimeout(function () {
								window.menuscroll.refresh();
							}, 10);
						});
					} else {
						parent.addClass('active');
						menu.slideDown('200', function() {
							setTimeout(function () {
								window.menuscroll.refresh();
							}, 10);
						});
					}
					e.stopPropagation();
					e.preventDefault();
				});
				
			}
		},
		categoryMenu: {
			selector: '.sf-menu:not(.secondary)',
			init: function() {
				var base = this,
					container = $(base.selector),
					children = container.find('.menu-item-has-children');
							 
				children.each(function() {
					var _this = $(this),
						menu = _this.find('>.sub-menu,>.thb_mega_menu_holder'),
						tabs = _this.find('.thb_mega_menu li'),
						contents = _this.find('.category-children>.row');
					
					tabs.first().addClass('active');	
					_this.hoverIntent(
						function() {
							TweenLite.to(menu, 0.5, {autoAlpha: 1, ease: Quart.easeOut, onStart: function() { menu.css('display', 'block'); }, onComplete: function() { SITE.circle_perc.control(); window.thb_lazyload.update();} });
						},
						function() {
							TweenLite.to(menu, 0.5, {autoAlpha: 0, ease: Quart.easeOut, onComplete: function() { menu.css('display', 'none'); }});
						}
					);
					tabs.mouseover(function() {
						var _li = $(this),
								n = _li.index();
						tabs.removeClass('active');
						_li.addClass('active');
						contents.hide();
						contents.filter(':nth-child('+(n+1)+')').show();
						SITE.circle_perc.control();
						window.thb_lazyload.update();
					});
				});
			}
		},
		secondaryMenu: {
			selector: '.secondary-holder',
			init: function() {
				var base = this,
					container = $(base.selector),
					menu = container.find('.sf-menu'),
					maxWidth = -1;
					
				$('>li', menu).each(function() {
					maxWidth = maxWidth > $(this).outerWidth() ? maxWidth : $(this).outerWidth();
				});
				menu.css({ 
					'display': 'none',
					'width': (maxWidth * 2) + 70
				});
				container.hoverIntent(
					function() {
						TweenLite.to(menu, 0.5, {autoAlpha: 1, ease: Quart.easeOut, onStart: function() { menu.css('display', 'flex'); }});
					},
					function() {
						TweenLite.to(menu, 0.5, {autoAlpha: 0, ease: Quart.easeOut, onComplete: function() { menu.css('display', 'none'); }});
					}
				);
			}
		},
		magnificSingle: {
			selector: '[rel="magnific"]',
			init: function() {
				var base = this,
						container = $(base.selector),
						stype;
				
				container.each(function() {
					$(this).magnificPopup({
						type: 'image',
						closeOnContentClick: true,
						fixedContentPos: true,
						closeBtnInside: false,
						mainClass: 'mfp',
						removalDelay: 250,
						overflowY: 'scroll',
						image: {
							verticalFit: false,
							titleSrc: function(item) {
								return item.el.attr('title');
							}
						}
					});
				});
	
			}
		},
		magnificImage: {
			selector: '.blog-post',
			init: function() {
				var base = this,
						container = $(base.selector);

				container.each(function() {
					$(this).magnificPopup({
						delegate: '[rel="mfp"]',
						type: 'image',
						closeOnContentClick: true,
						fixedContentPos: true,
						mainClass: 'mfp',
						removalDelay: 250,
						closeBtnInside: false,
						overflowY: 'scroll',
						gallery: {
							enabled: true,
							navigateByImgClick: false,
							preload: [0,1] // Will preload 0 - before current, and 1 after the current image
						},
						image: {
							verticalFit: false,
							titleSrc: function(item) {
								return item.el.attr('title');
							}
						}
					});
				});
				
			}
		},
		carousel: {
			selector: '.slick',
			init: function(el) {
				var base = this,
					container = el ? el : $(base.selector);
				
				container.each(function() {
					var that = $(this),
							columns = that.data('columns'),
							navigation = (that.data('navigation') === true ? true : false),
							autoplay = (that.data('autoplay') === false ? false : true),
							pagination = (that.data('pagination') === true ? true : false),
							speed = (that.data('speed') ? that.data('speed') : 1000),
							center = (that.data('center') ? that.data('center') : false),
							disablepadding = (that.data('disablepadding') ? that.data('disablepadding') : false),
							vertical = (that.data('vertical') ? that.data('vertical') : false),
							fade = (that.data('fade') === true ? true : false);
					
					var args = {
						dots: pagination,
						arrows: navigation,
						infinite: true,
						speed: speed,
						centerMode: center,
						slidesToShow: columns,
						slidesToScroll: 1,
						autoplay: autoplay,
						centerPadding: (disablepadding ? 0 : '50px'),
						autoplaySpeed: 6000,
						pauseOnHover: true,
						focusOnSelect: true,
						adaptiveHeight: true,
						vertical: vertical,
						verticalSwiping: vertical,
						accessibility: false,
						fade: fade,
						cssEase: 'ease-in-out',
						prevArrow: '<button type="button" class="slick-nav slick-prev"><i class="fa fa-angle-left"></i></button>',
						nextArrow: '<button type="button" class="slick-nav slick-next"><i class="fa fa-angle-right"></i></button>',
						responsive: [
							{
								breakpoint: 1025,
								settings: {
									slidesToShow: (columns < 3 ? columns : (vertical ? columns-1 :3)),
									centerPadding: (disablepadding ? 0 : '40px')
								}
							},
							{
								breakpoint: 780,
								settings: {
									slidesToShow: (columns < 2 ? columns : (vertical ? columns-1 :2)),
									centerPadding: (disablepadding ? 0 : '30px')
								}
							},
							{
								breakpoint: 640,
								settings: {
									slidesToShow: (columns < 2 ? columns : (vertical ? columns-1 :1)),
									centerPadding: (disablepadding ? 0 : '15px')
								}
							}
						]
					};
					that.on('afterChange', function(event, slick, currentSlide, nextSlide){
						SITE.circle_perc.control();
						window.thb_lazyload.update();
					});
					that.waitForImages(function() {
						that.slick(args);
					});
				});
			}
		},
		postGrid: {
			selector: '[data-loadmore]',
			init: function() {
				var base = this,
						container = $(base.selector);
								
				container.each(function() {
					var _this = $(this),
							loadmore = $(_this.data('loadmore')),
							text = loadmore.text(),
							loading = loadmore.data('loading'),
							nomore = loadmore.data('nomore'),
							count = loadmore.data('count'),
							offset = loadmore.data('offset'),
							page = loadmore.data('page'),
							style = loadmore.data('style'),
							columns = loadmore.data('columns'),
							excerpts = loadmore.data('excerpts');
					
					if (loadmore.length > 0) {
						loadmore.on('click', function() {
							loadmore.text(loading);
							$.post( themeajax.url, { 
								action: 'thb_posts',
								count : count,
								style : style,
								excerpts : excerpts,
								page  : page++,
								columns : columns
							}, function(data){
								var d = $.parseHTML($.trim(data)),
										l = d ? d.length : 0;
								
								if( data === '' || data === 'undefined' || data === 'No More Posts' || data === 'No $args array created') {
									data = '';
									loadmore.text(nomore).removeClass('loading').off('click');
								} else {
									$(d).appendTo(_this).hide();
										
									$(d).show();
									
									window.thb_lazyload.update();
									
									TweenMax.set($(d), {opacity: 0, y:20});
									TweenMax.staggerTo($(d), l * 0.25, { y: 0, opacity:1, ease: Quart.easeOut, onComplete: SITE.equalHeights.init() }, 0.25);

									
									if (l < count){
										loadmore.text(nomore).removeClass('loading');
									} else {
										loadmore.text(text).removeClass('loading');
									}
								}
							});
							return false;
						});
					}
				});
			}
		},
		galleryArrows: {
			selector: '.blog-post.format-gallery',
			init: function(el) {
				var base = this,
						container = el ? el : $(base.selector);
								
				$doc.on('keyup', function(e) {
					if (e.keyCode === 37 && container.find('.slick-prev', '.gallery-pagination').length) { // Left
						container.find('.slick-prev', '.gallery-pagination')[0].click();
					}
					if (e.keyCode === 39 && container.find('.slick-next', '.gallery-pagination').length) { // Right	
						container.find('.slick-next', '.gallery-pagination')[0].click();
					}
				});
			}
		},
		articleScroll: {
			selector: '#infinite-article',
			org_post_url: window.location.href,
			org_post_title: document.title,
			init: function() {
				var base = this,
						container = $(base.selector),
						on = container.data('infinite'),
						org = container.find('.blog-post:first-child'),
						id = org.data('id'),
						tempid = id,
						thb_loading = false,
						footer = $('#footer').outerHeight() + $('#subfooter').outerHeight();
					
				var scrollLocation = _.debounce(function(){
						base.location_change();
					}, 10);
					
				var scrollAjax = _.debounce(function(){
					if (win.scrollTop() >= ($doc.height() - win.height() - footer - 200) && thb_loading === false) {
						container.addClass('thb-loading');
		
						if (id === tempid) {
							$.ajax( themeajax.url, {
								method : 'POST',
								data : {
									action : 'thb_infinite_ajax',
									post_id : tempid
								},
								beforeSend: function() {
									id = null;
									thb_loading = true;
								},
								success : function(data) {
									thb_loading = false;
									var d = $.parseHTML(data),
											ads = $(d).find('.adsbygoogle, .adworx_ad');
									container.removeClass('thb-loading');
									
									if (d) {
										var the_post = $(d).find('.blog-post');
										id = the_post.data('id');
										tempid = id;
										
										$(d).appendTo(container);
										
										SITE.circle_perc.init();
										SITE.carousel.init($(d).find('.slick'));
										SITE.equalHeights.init();
										SITE.fixedPosition.init($(d).find('.fixed-me'));
										SITE.magnificImage.init();
										SITE.parallax_bg.init();
										SITE.topReviews.init();
										SITE.shareArticleDetail.init();
										window.thb_lazyload.update();
										
										if (the_post.hasClass('format-gallery')) {
											$doc.off('keyup');
											console.log('a');
											SITE.galleryArrows.init(the_post);
										}
										if (typeof window.addthis !== 'undefined') {
											addthis.toolbox();	
										}
										if (typeof window.atnt !== 'undefined') {
											window.atnt();
										}
										if (typeof window.adsbygoogle !== 'undefined' && ads.length) {
											ads.each(function() {
												(adsbygoogle = window.adsbygoogle || []).push({});
											});
										}
										if (typeof (FB) !== 'undefined') {
											FB.init({ status: true, cookie: true, xfbml: true });
										}
									} else {
										id = null;	
									}
								}
							});
						}
					}
				}, 100);
				
				if (on === 'on') {
					win.scroll(scrollLocation);
					win.scroll(scrollAjax);
				} else {
					win.scroll(_.debounce(function(){
							base.borderWidth($('.post-detail-row').offset().top, $('.post-detail-row').outerHeight(true));
					}, 10));
				}
			},
			location_change: function() {
				var base = this,
						container = $(base.selector);
					
				var windowTop           = win.scrollTop(),
						windowBottom        = windowTop + win.height(),
						windowSize          = windowBottom - windowTop,
						setsInView          = [],
						post_title,
						post_url;
					
				$('.post-detail-row').each( function() {
					var _row = $(this),
							post = _row.find('.blog-post'),
							id				= post.data( 'id' ),
							setTop			= _row.offset().top - ($('.subheader.fixed').outerHeight() + $('#wpadminbar').outerHeight()),
							setHeight		= _row.outerHeight(true),
							setBottom		= 0,
							tmp_post_url	= post.data('url'),
							tmp_post_title	= _row.find('.post-title h1').text();
					
					// Determine position of bottom of set by adding its height to the scroll position of its top.
					setBottom = setTop + setHeight;
					
					if ( setTop < windowTop && setBottom > windowBottom ) { // top of set is above window, bottom is below
						setsInView.push({'id': id, 'top': setTop, 'bottom': setBottom, 'post_url': tmp_post_url, 'post_title': tmp_post_title, 'alength' : setHeight });
					}
					else if( setTop > windowTop && setTop < windowBottom ) { // top of set is between top (gt) and bottom (lt)
						setsInView.push({'id': id, 'top': setTop, 'bottom': setBottom, 'post_url': tmp_post_url, 'post_title': tmp_post_title, 'alength' : setHeight });
					}
					else if( setBottom > windowTop && setBottom < windowBottom ) { // bottom of set is between top (gt) and bottom (lt)
						setsInView.push({'id': id, 'top': setTop, 'bottom': setBottom, 'post_url': tmp_post_url, 'post_title': tmp_post_title, 'alength' : setHeight });
					}
				});
				
				// Parse number of sets found in view in an attempt to update the URL to match the set that comprises the majority of the window
				if ( 0 === setsInView.length ) {
					post_url = base.org_post_url;
					post_title = base.org_post_title;
				} else if ( 1 === setsInView.length ) {
					var setData = setsInView.pop();
					
					post_url = setData.post_url;
					post_title = setData.post_title;
					
					base.borderWidth(setData.top, setData.alength);
				} else {
					post_url = setsInView[0].post_url;
					post_title = setsInView[0].post_title;
					base.borderWidth(setsInView[0].top, setsInView[0].alength);
				}
				if (post_url === base.org_post_url) {
					$('.subheader.fixed').find('.share-article-vertical').fadeIn();	
				} else {
					$('.subheader.fixed').find('.share-article-vertical').fadeOut();	
				}
				base.updateURL(post_url, post_title);
			},
			updateURL : function(post_url, post_title) {
				if( window.location.href !== post_url ) {
		
					if ( post_url !== '' ) {
						history.replaceState( null, null, post_url );
						document.title = post_title;
						$('#page-title').html(post_title);
					}
					this.updateGA(post_url);
				}
			},
			updateGA: function(post_url) {
				if( typeof _gaq !== 'undefined' ) {
					_gaq.push(['_trackPageview', post_url]);
				} else if ( typeof ga !== 'undefined' ) {
					var reg = /.+?\:\/\/.+?(\/.+?)(?:#|\?|$)/,
							pathname = reg.exec( post_url )[1];
							
					ga('send', 'pageview', pathname );
				}
			},
			borderWidth : function(top, setHeight) {
				var windowTop = win.scrollTop(),
						perc = (windowTop - top) / setHeight;

				$('.progress', '.subheader.fixed').css({ width: parseInt(perc*100, 10) + '%' });
			}
		},
		postGridAjaxify: {
			selector: '.ajaxify-pagination',
			init: function() {
				var base = this,
						container = $(base.selector),
						_this = container;
				
				// Initialized
				_this.data('initialized', true);
				// Prepare our Variables
				var History = window.History,
						document = window.document;
			
				// Check to see if History.js is enabled for our Browser
				if ( !History.enabled ) { 
					return false; 
				}

				var contentNode = _this.get(0),
						/* Application Generic Variables */
						$body = $(document.body),
						rootUrl = History.getRootUrl();
		
				// Ensure Content
				if ( _this.length === 0 ) { _this = $body; }
		
				// HTML Helper
				var documentHtml = function(html){
					// Prepare
					// replaces doctype, html head body tags with div
					var result = String(html).replace(/<\!DOCTYPE[^>]*>/i, '')
												.replace(/<(html|head|body|title|script)([\s\>])/gi,'<div id="document-$1"$2')
												.replace(/<\/(html|head|body|title|script)\>/gi,'</div>');
					// Return
					return result;
				};
		
				// Ajaxify Helper
				$.fn.ajaxify = _.debounce(function(){
					// Prepare
					var $_this = $(this);
					
					// Ajaxify
					$_this.find('.page-numbers').on('click',function(e){

						// Prepare
						var $_this	= $(this),
								url = $_this.attr('href'),
								title = $_this.attr('title') || null;
		
						// Continue as normal for cmd clicks etc
						if ( e.which === 2 || e.metaKey ) { return true; }
		
						// Ajaxify this link
						History.pushState(null,title,url);
						e.preventDefault();
						return false;
					});
					// Chain
					return $_this;
				}, 50);
		
				// Ajaxify our Internal Links
				_this.ajaxify();
				
				// Hook into State Changes
				$(window).bind('statechange',function(){
					// Prepare Variables
					var State = History.getState(),
							url = State.url,
							relativeUrl = url.replace(rootUrl,''),
							a = $('#wpadminbar'),
							ah = (a ? a.outerHeight() : 0);
							
					// Start Fade Out
					// Animating to opacity to 0 still keeps the element's height intact
					// Which prevents that annoying pop bang issue when loading in new content
					// Let's add some cool animation here
		
					_this.addClass('thb-loading');
					jQuery('html, body').animate({
						scrollTop: _this.offset().top - ah - 30
					}, 800);
		
		
					// Ajax Request the Traditional Page
					$.ajax({
						url: url,
						success: function(data, textStatus, jqXHR){
							// Prepare
							var $data = $(documentHtml(data)),
									$dataBody = $data.find(base.selector),
									contentHtml = $dataBody.html() || $data.html();

							if ( !contentHtml ) {
								document.location.href = url;
								return false;
							}
							// Update the content
							_this.stop(true,true);
							_this.html(contentHtml)
									.ajaxify()
									.animate({'opacity': 1}, 500, 'linear', function() {
										_this.removeClass('thb-loading');
										SITE.circle_perc.control();
										window.thb_lazyload.update();
									}); 
							
							
							// Update the title
							document.title = $data.find('#document-title:first').text();			
		
							// Inform Google Analytics of the change
							if ( typeof window.pageTracker !== 'undefined' ) { 
								window.pageTracker._trackPageview(relativeUrl); 
							}
		
							// Inform ReInvigorate of a state change
							if ( typeof window.reinvigorate !== 'undefined' && typeof window.reinvigorate.ajax_track !== 'undefined' ) {
								reinvigorate.ajax_track(url);// ^ we use the full url here as that is what reinvigorate supports
							}
						},
						error: function(jqXHR, textStatus, errorThrown){
							document.location.href = url;
							return false;
						}
		
					}); // end ajax
		
				}); // end onStateChange
			}
		},
		circle_perc: {
			selector: '.circle_perc',
			init: function() {
				var base = this,
						container = $(base.selector);
				
				base.control(container);
				
				win.scroll(function(){
					base.control(container);
				});
			},
			control: function(element) {
				var t = -1,
						control_element = element ? element : $(this.selector);
	
				control_element.filter(':in-viewport').each(function () {
					var _this = $(this),
							offset = _this.data('dashoffset'); 
							t++;
					
					setTimeout(function () {
						TweenLite.to(_this, 1, {attr:{"stroke-dashoffset":offset}});
					}, 200 * t);
					
				});
			}
		},
		topReviews: {
			selector: '.widget_topreviews .progress, .post-review .progress span',
			init: function() {
				var base = this,
						container = $(base.selector);
				
				base.control(container);
				
				win.scroll(function(){
					base.control(container);
				});
			},
			control: function(element) {
				var t = -1;
	
				element.filter(':in-viewport').each(function () {
					var _this = $(this),
							progress = _this.data('width'); 
							t++;
					setTimeout(function () {
						TweenLite.to(_this, 1, {"width": progress + '%'});
					}, 200 * t);
					
				});
			}
		},
		comments: {
			selector: '#comment-toggle',
			init: function() {
				var base = this,
				container = $(base.selector);
								
				container.on('click', function() {
					$(this).toggleClass('active');
					$(this).next('.comment-content-container').slideToggle();
					return false;
				});
			}
		},
		videoPlaylist: {
			selector: '.video_playlist',
			init: function() {
				var base = this,
				container = $(base.selector);
								
				container.each(function() {
					var _this = $(this),
							video_area = _this.find('.video-side'),
							links = _this.find('.video_play');

					container.on('click', '.video_play', function() {
						var _that = $(this),
								url = _that.data('video-url'),
								id = _that.data('post-id');
								
						if (_that.hasClass('video-active')) {
							return false;	
						}
						_this.find('.video_play').removeClass('video-active');
						_this.find('.video_play[data-video-url="'+url+'"]').addClass('video-active');
						video_area.addClass('thb-loading');
						
						$.post( themeajax.url, {
							action: 'thb-parse-embed',
							post_ID: id,
							shortcode : '[embed]'+url+'[/embed]'
						}, function(d){
							if (d.success) {
								video_area.html(d.data.body);
							}
							video_area.removeClass('thb-loading');
						});
						return false;
					});
				});
			}
		},
		postListing: {
			selector: '.thb_listing',
			init: function() {
				var base = this,
				container = $(base.selector);
								
				container.each(function() {
					var that = $(this),
							type = that.data('type'),
							count = that.data('count'),
							links = that.find('a'),
							ul = that.parents('strong').next('ul'),
							tl = new TimelineMax();
					
					links.on('click', function() {
						var _this = $(this),
								time = _this.data('time'),
								prev = ul.find('li,p'),
								prev_l = prev.length;
						
						ul.addClass('thb-loading');
						$.post( themeajax.url, {
							action: 'thb_listing',
							count : count,
							type : type,
							time : time
						}, function(data){
							var li = $.parseHTML($.trim(data)),
									li_l = li.length;
							
							TweenLite.set(li, { x: 30, opacity:0 });
							links.removeClass('active');
							_this.addClass('active');
							tl
								.staggerTo(prev, Math.min(0.15 * li_l, 1), 
									{ x: -30, opacity:0, 
										onStart: function() { ul.removeClass('thb-loading'); }, 
										onComplete: function() { ul.html(li); window.thb_lazyload.update();} 
									}, 0.1)
								.staggerTo(li, Math.min(0.15 * li_l, 1), { x: 0, opacity:1 }, 0.1);

						});
						return false;
					});
				});
			}
		},
		shareArticleDetail: {
			selector: '.share-article, .share-article-vertical',
			init: function() {
				var base = this,
						container = $(base.selector),
						social = container.find('.social');
						
				
				social.on('click', function() {
					var left = (screen.width/2)-(640/2),
							top = (screen.height/2)-(440/2)-100;
					window.open($(this).attr('href'), 'mywin', 'left='+left+',top='+top+',width=640,height=440,toolbar=0');
					return false;
				});
			}
		},
		custom_scroll: {
			selector: '.custom_scroll',
			init: function() {
				var base = this,
					container = $(base.selector);
				
				container.each(function() {
					var _this = $(this),
							id = _this.attr('id'),
							params = {
								scrollbars: true,
								mouseWheel: true,
								click: true,
								interactiveScrollbars: true,
								shrinkScrollbars: 'scale',
								fadeScrollbars: true
							};
						var newScroll = new IScroll('#'+id, params);
						if (_this.attr('id') === 'menu-scroll') {
							window.menuscroll = newScroll;	
						}
					_this.on('touchmove', function (e) { e.preventDefault(); });
				});		 
			}
		},
		categoryDropdown: {
			selector: '.thb-sibling-categories',
			init: function() {
				var base = this,
						container = $(base.selector);
						
				container.each(function() {
					var _this = $(this),
							items = _this.find('li:not(.thb-pull-down)'),
							more_container = _this.find('li.thb-pull-down'),
							vertical_container = _this.find('.thb-pull-down .sub-menu'),
							horizontal_width = 0,
							var_items = [];
					
					more_container.find('>a').on('click', function() {return false;});
					items.each(function() {
							var_items.push({
								'el' : $(this),
								'width' : $(this).outerWidth(true),
								'added' : false
							});
					});
					items.remove();
					
					base.start(_this, var_items, vertical_container, more_container);
					
				});		
			},
			start: function(parent, items, vertical_container, more_container) {
				var cached_items = items;
				
				parent.addClass('active');
				function setItems() {
					var parent_width = parent.outerWidth(),
							horizontal_width = more_container.outerWidth(true) + 15,
							visible_items = _.filter(cached_items, { 'added': false }),
							hidden_items = _.filter(cached_items, { 'added': true });

					for (var k = 0; k < visible_items.length; k++) {
						horizontal_width += visible_items[k].width;
					}

					if ( horizontal_width >= parent_width) {
						if (_.last(visible_items)) {
							_.last(visible_items).added = true;
						}
					} else if (_.first(hidden_items) ? (_.first(hidden_items).width + horizontal_width < parent_width) : true ){
						if (_.first(hidden_items)) {
							_.first(hidden_items).added = false;
						}
					}
					for (var i = 0; i < visible_items.length; i++) {
						visible_items[i].el.insertBefore(more_container);
					}
					for (var j = 0; j < hidden_items.length; j++) {
						vertical_container.prepend(hidden_items[j].el);
					}
					if (hidden_items.length === 0) {
						more_container.hide();
					} else {
						more_container.css({
							'display': 'inline-block'
						});
					}
				}
				for (var m = 0; m < cached_items.length + 1; m++) {
					setItems();
				}
				win.resize(function(){
					setItems();
				});
				
			}
		},
		parallax_bg: {
			selector: 'body',
			active: 0,
			init: function() {
				var main = $('div[role="main"]');
				
				if (main.find('.parallax_bg').length > 0) {
					main.waitForImages(function() {
						window.skroller = skrollr.init({
							forceHeight: false,
							easing: 'outCubic',
							mobileCheck: function() {
								return false;
							}
						});
					});
				}
			}
		},
		equalHeights: {
			selector: '[data-equal]',
			init: function(el) {
				var base = this,
						container = el ? el : $(base.selector);
				container.each(function(){
					var that = $(this),
							children = that.data("equal"),
							row = that.data('row-detection') ? that.data('row-detection') : false;
					
					that.find(children).matchHeight({
						byRow: row,
						property: 'min-height'
					});	
					that.waitForImages(function() {
						$.fn.matchHeight._update();
					});
					if (!thb_md.mobile()) {
						$.fn.matchHeight._afterUpdate = function(event, groups) {
							$(document.body).trigger("sticky_kit:recalc");
						};
					}
				});
			}
		},
		fixedPosition: {
			selector: '.fixed-me',
			init: function(el) {
				var base = this,
					container = el ? el : $(base.selector),
					a = $('#wpadminbar'),
					ah = (a ? a.outerHeight() : 0);
				
				if (!thb_md.mobile()) {
					container.each(function() {
						var _this = $(this),
								off = 77;
						
						_this.after('<div class="sticky-content-spacer"/>');
						_this.stick_in_parent({
							offset_top: off + ah,
							spacer: '.sticky-content-spacer'
						});
							
					});
				} else {
					win.resize(_.debounce(function(){
						$(document.body).trigger("sticky_kit:detach");
					}, 30));
				}
			}
		},
		lazyLoad: {
			selector: '#content-container',
			init: function() {
				var base = this,
						container = $(base.selector);
						
				window.thb_lazyload = new LazyLoad({
					// example of options object -> see options section
					threshold: 100,
					//container: document.getElementById('content-container'),
					elements_selector: "img:not([src])",
					throttle: 80,
					class_loading: 'image-loading',
					class_loaded: 'image-loaded',
					data_src: "original",
					data_srcset: 'original-set',
					show_while_loading: true,
					callback_set: function(el) {
						
						if ($(el).parents('.row').data('equal')) {
							$.fn.matchHeight._update();
						}
					}
				});
			}
		},
		animation: {
			selector: '#content-container .animation',
			init: function() {
				var base = this,
						container = $(base.selector);
				
				base.control(container);
				
				win.scroll(function(){
					base.control(container);
				});
			},
			control: function(element) {
				var t = -1;

				element.filter(':in-viewport').each(function () {
					var that = $(this);
							t++;
					
					setTimeout(function () {
						that.addClass("animate");
					}, 200 * t);
					
				});
			}
		},
		toTop: {
			selector: '#scroll_totop',
			init: function() {
				var base = this,
					container = $(base.selector);
				
				container.on('click', _.debounce(function(){
					TweenMax.to(window, 1, {scrollTo:{y:0}, ease:Quart.easeOut});
					return false;
				}, 50));
				win.scroll(_.debounce(function(){
					base.control();
				}, 50));
			},
			control: function() {
				var base = this,
						container = $(base.selector);
					
				if (win.scrollTop() > 300) {
					TweenMax.to(container, 0.2, { autoAlpha:1, ease: Quart.easeOut });
				} else {
					TweenMax.to(container, 0.2, { autoAlpha:0, ease: Quart.easeOut });
				}
			}
		},
		themeSwitcher: {
			selector: '#theme-switcher',
			init: function() {
				var base = this,
						container = $(base.selector),
						toggle = container.find('.style-toggle');
				
				toggle.on('click', function() {
					container.add($(this)).toggleClass('active');
					return false;
				});
				
			}
		}
	};
	
	$doc.ready(function() {
		SITE.init();
	});

})(jQuery, this, _);