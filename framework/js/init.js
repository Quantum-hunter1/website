/*
 * Copyright (c) 2022 Frenify
 * Author: Frenify
 * This file is made for CURRENT THEME
*/


/*

	@Author: Frenify
	@URL: http://themeforest.net/user/frenify


	This file contains the jquery functions for the actual theme, this
	is the file you need to edit to change the structure of the
	theme.

	This files contents are outlined below.

*/

var MetaPortalAjax				= MetaPortalAjaxObject;
var MetaPortalListLimit			= MetaPortalAjax.list_limit;
var MetaPortalBody				= jQuery('body');
var MetaPortalWrapper			= jQuery('.metaportal-fn-wrapper');
var MetaPortalCollection		= jQuery('.metaportal_fn_collection');
var MetaPortalFilterArray		= [];

// All other theme functions
(function ($){

	"use strict";
	
	var FrenifyCounter		= 0;
	
    var MetaPortalInit 		= {
		
		
		
		pageNumber: 1,
		
        init: function () {
			this.cursor();
			this.blog_info();
			this.url_fixer();
			this.hamburgerOpener__Mobile();
			this.submenu__Mobile();
			this.imgToSVG();
			this.isotopeMasonry();
			this.dataFnBgImg();
			this.dataFnStyle();
			this.estimateWidgetHeight();
			this.prev_next_posts();
			this.widget__pages();
			this.widget__archives();
			this.portfolioContentHeight();
			this.inputCheckBoxInComment();
			
			
			this.menuFixer();
			this.widgetTriangle();
			this.widgetTitle();
			this.applyFilter();
			this.filterItems();
			this.pagedFilter();
			this.fixAdminBar();
			this.minHeightPages();
			this.countdown();
			
			// since MetaPortal
			this.ready();
			this.menuCenter();
			this.headerAnchor();
			this.totopScroll();
			this.walletAndLeftNavOpener();
			this.navSubMenu();
			this.resizeWalletAndLeftNav();
			this.hold();
			this.seachSomething();
			this.totopFixer();
			this.rippleEffect();
			this.reversedMenu();
			this.productModal();
        },
		
		productModal: function(){
			var modal = $('.metaportal_fn_modal.product_modal');
			$('.nft__item a').off().on('click', function(){
				var element		= $(this);
				if(element.data('lightbox') === 'enabled'){
					var parent		= element.closest('.nft__item');
					var image		= parent.data('modal-image');
					var title		= parent.data('modal-title');
					var description	= parent.data('modal-description');
					var permalink	= parent.data('modal-permalink');

					modal.find('.view_on').html(parent.find('.view_on').html());
					modal.find('.img_item').html('<img src="'+image+'" />');
					modal.find('.metaportal_fn_title .fn_title').text(title).attr('data-text',title);
					modal.find('.desc p').text(description).append('<a href="'+permalink+'">'+MetaPortalAjax.read_more_nft+'</a>');

					MetaPortalInit.imgToSVG();
					modal.addClass('opened');
					return false;
				}
			});
			
			modal.find('.modal_closer a').off().on('click', function(){
				modal.removeClass('opened');
				return false;
			});
			
			modal.find('.modal_ux_closer').off().on('click', function(){
				modal.removeClass('opened');
				return false;
			});
		},
		
		reversedMenu: function(){
			$('.metaportal_fn_main_nav ul').each(function(){
				var e = $(this),
					w = e.offset().left + 240,
					W = $('body').width();
				if(w>W){
					e.addClass('reverse');
				}
			});
		},
		
		
		rippleEffect: function(){
			if($('.ripple').length){
				$('.ripple').ripples({
					resolution: 500,
					dropRadius: 20,
					perturbance: 0.04
				});
			}
		},
		
		
		totopFixer: function(){
			var w = $('.metaportal_fn_totop .totop_inner').width();	
			$('.metaportal_fn_totop').css({height: w + 'px'});
		},
		
		seachSomething: function(){
			var searchOpener 	= $('.metaportal_fn_search');
			var searchbox 		= $('.metaportal_fn_searchbox');
			var searchCloser	= $('.metaportal_fn_search_closer');
			var input 			= searchbox.find('input[type="text"]');
			searchOpener.on('click',function(){
				if(searchbox.hasClass('active')){
					searchbox.removeClass('active');
					searchCloser.removeClass('active');
				}else{
					searchbox.addClass('active');
					searchCloser.addClass('active');
					input.val('');
					setTimeout(function(){
						input[0].focus();
					},100);
				}
				return false;
			});
			searchCloser.on('click',function(){
				searchbox.removeClass('active');
				searchCloser.removeClass('active');
				return false;
			});
			input.on("keypress", function(event) {
				if (event.key === "Enter") {
					event.preventDefault();
					$('.metaportal_fn_searchbox input[type="submit"]').trigger('click');
				}
			});
		},
		
		hold: function(){
//			var holdable			= $('#social,.metaportal_fn_search');
			var holdable			= $('#social');
			var inactivityTime = function () {
				var time;
				window.onload 			= resetTimer;
				document.onmousemove 	= resetTimer;
				document.onkeypress	 	= resetTimer;
				function logout() {
					holdable.addClass('hold');
				}
				function resetTimer() {
					if($(window).scrollTop() > $(window).height()){
						clearTimeout(time);
						time = setTimeout(logout, 2000);
						holdable.removeClass('hold');
					}
				}
			};
			if(	MetaPortalInit.holdCondition()){
				holdable.addClass('hold');
			}
			$(window).on('scroll',function(){
				if(MetaPortalInit.holdCondition()){
					holdable.addClass('hold');
				}
			});
			inactivityTime();
		},
		
		holdCondition: function(){
			var h = $(window).height();
			if(($(window).scrollTop() < h) && ($('body').height() > 2*h) ){
				return true;
			}else{
				return false;
			}
		},
		
		resizeWalletAndLeftNav: function(){
			var walletHeight = $('.metaportal_fn_walletbox').height();
			$('.metaportal_fn_walletbox .walletbox').css({minHeight: walletHeight});
			
			
			var leftnavHeight = $('.metaportal_fn_leftnav').height();
			$('.metaportal_fn_leftnav .navbox').css({minHeight: leftnavHeight});
		},
		
		navSubMenu: function(){
			$('.metaportal_fn_leftnav .nav_holder a').off().on('click',function(){
				var e = $(this);
				var s = e.siblings('.sub-menu');
				var svg = $('.metaportal_fn_leftnav .nav_holder .icon').html();
				if(s.length){
					e.parent().siblings().children('a').removeClass('active');
					e.addClass('active');
					FrenifyCounter++;
					if(!s.find('>li>.prev').length){
						s.prepend('<li><a href="#" class="prev"><span class="creative_link">'+svg+e.text()+'</span></a></li>');
					}
					$('.metaportal_fn_leftnav .left_nav').css({transform: 'translateX(-'+(100*FrenifyCounter)+'%)'});
					MetaPortalInit.previousItems();
					return false;
				}
			});
		},
		
		previousItems: function(){
			$('.metaportal_fn_leftnav .nav_holder .prev').off().on('click',function(){
				FrenifyCounter--;
				$('.metaportal_fn_leftnav .left_nav').css({transform: 'translateX(-'+(100*FrenifyCounter)+'%)'});
				return false;
			});	
		},
		
		walletAndLeftNavOpener: function(){
			var walletbox 	= $('.metaportal_fn_walletbox');
			var closer		= $('.metaportal_fn_wallet_closer,.metaportal_fn_walletbox .fn__closer');
			$('.wallet_opener').on('click',function(){
				walletbox.addClass('active');
				closer.addClass('active');
				
				return false;
			});
			closer.on('click',function(){
				walletbox.removeClass('active');
				closer.removeClass('active');
				
				return false;
			});
			
			var leftNav 	= $('.metaportal_fn_leftnav');
			var closer2		= $('.metaportal_fn_leftnav_closer,.metaportal_fn_leftnav .fn__closer');
			$('.header .trigger,.metaportal_fn_mobnav .social_trigger .trigger').on('click',function(){
				leftNav.addClass('active');
				closer2.addClass('active');
				
				return false;
			});
			closer2.on('click',function(){
				leftNav.removeClass('active');
				closer2.removeClass('active');
				
				return false;
			});
			var mobOpener 	= $('.metaportal_fn_mobnav .mob_mid .trigger');
			var mobDD		= $('.metaportal_fn_mobnav .mob_bot');
			mobOpener.on('click',function(){
				if(mobOpener.hasClass('active')){
					mobOpener.removeClass('active');
					mobDD.slideUp(300);
				}else{
					mobOpener.addClass('active');
					mobDD.slideDown(300);
				}
				
				return false;
			});
		},
		
		totopScroll: function(){
			var minSpeed 		= 500;
			var maxSpeed		= 1500;
			$(".metaportal_fn_totop").off().on('click', function(e) {
				e.preventDefault();
				var speed		= ($(window).scrollTop()-$(window).height())/2;
				if(speed < minSpeed){speed = minSpeed;}
				if(speed > maxSpeed){speed = maxSpeed;}
				$("html, body").animate({ scrollTop: 0 }, speed);
				return false;
			});
		},
		
		headerAnchor: function(){
			$('.header .nav a').on('click',function(){
				var e = $(this);
				if($(e.attr('href')).length){
					$("html, body").animate({ scrollTop: $(e.attr('href')).offset().top }, 1000);
					return false;
				}
			});
		},
		
		menuCenter: function(){
			var left 		= $('.header .trigger_logo');
			var right 		= $('.header .wallet');
			var nav 		= $('.header .nav');
			var leftWidth 	= 0;
			var rightWidth 	= 0;
			if(left.length){
				leftWidth 	= parseInt(left.width());
			}
			if(right.length){
				rightWidth 	= parseInt(right.width());
			}
			if(left.length && right.length){
				if(leftWidth < rightWidth){
					nav.css({paddingLeft: ((rightWidth - leftWidth)) + 'px'});
				}else{
					nav.css({paddingRight: ((leftWidth - rightWidth)) + 'px'});
				}
			}
			nav.css({opacity: 1});
			
		},
		
		
		
		ready: function(){
			$('.metaportal_fn_walletbox, .metaportal_fn_wallet_closer, .metaportal_fn_leftnav, .metaportal_fn_leftnav_closer').removeClass('ready');
		},
		
		countdown: function(){
			$('.metaportal_fn_countdown').each(function(){
				var e = $(this),
					t = e.data('type');
				if(t === 'due_date'){
					var countDownDate = new Date(e.data('date')).getTime();
					console.log(e.data('date'));
				}else if(t === 'ever'){
					var days 	= parseInt(e.data('days')) * 24 * 3600,
						hours	= parseInt(e.data('hours')) * 3600,
						minutes	= parseInt(e.data('minutes')) * 60,
						seconds	= parseInt(e.data('seconds'));
					var ever	= days + hours + minutes + seconds;
				}
				if(e.hasClass('boxed')){
					e.after('<div class="metaportal_fn_boxed_countdown"><ul><li class="days"><div class="item"><div class="count"><h3 class="fn__gradient_title">0</h3></div><span>'+e.data('text-days')+'</span></div></li><li class="hours"><div class="item"><div class="count"><h3 class="fn__gradient_title">0</h3></div><span>'+e.data('text-hours')+'</span></div></li><li class="minutes"><div class="item"><div class="count"><h3 class="fn__gradient_title">0</h3></div><span>'+e.data('text-minutes')+'</span></div></li><li class="seconds"><div class="item"><div class="count"><h3 class="fn__gradient_title">0</h3></div><span>'+e.data('text-seconds')+'</span></div></li></ul></div>');
					var p = e.parent().find('.metaportal_fn_boxed_countdown');
					e.remove();
				}
				if(t === 'due_date'){
					// Update the count down every 1 second
					var x = setInterval(function() {
						// Get today's date and time
						var now = new Date().getTime();

						// Find the distance between now and the count down date
						var distance = countDownDate - now;

						// Time calculations for days, hours, minutes and seconds
						var days = Math.floor(distance / (1000 * 60 * 60 * 24));
						var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
						var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
						var seconds = Math.floor((distance % (1000 * 60)) / 1000);

						if(e.hasClass('boxed')){
							days = (days < 10 ? '0' + days : days);
							hours = (hours < 10 ? '0' + hours : hours);
							minutes = (minutes < 10 ? '0' + minutes : minutes);
							seconds = (seconds < 10 ? '0' + seconds : seconds);
							p.find('.days h3').text(days);
							p.find('.hours h3').text(hours);
							p.find('.minutes h3').text(minutes);
							p.find('.seconds h3').text(seconds);
						}else{
							var text = '';
							if(days > 0){text += days + 'd: ';}
							text += hours + 'h: ' + minutes + 'm: ' + seconds + 's';
							e.text(text);
						}
						if (distance < 0) {
							if(e.hasClass('boxed')){
								p.find('.days h3').text(0);
								p.find('.hours h3').text(0);
								p.find('.minutes h3').text(0);
								p.find('.seconds h3').text(0);
							}else{
								e.text('0d: 0h: 0m: 0s');
							}
							clearInterval(x);
					  	}
					}, 1000);
				}else if(t === 'ever'){
					setInterval(function(){
						days 	= Math.floor(ever / 86400);
						hours	= Math.floor((ever % 86400) / 3600);
						minutes	= Math.floor((ever % 3600) / 60);
						seconds	= Math.floor((ever % 60));
							
						if(e.hasClass('boxed')){
							days = (days < 10 ? '0' + days : days);
							hours = (hours < 10 ? '0' + hours : hours);
							minutes = (minutes < 10 ? '0' + minutes : minutes);
							seconds = (seconds < 10 ? '0' + seconds : seconds);
							p.find('.days h3').text(days);
							p.find('.hours h3').text(hours);
							p.find('.minutes h3').text(minutes);
							p.find('.seconds h3').text(seconds);
						}else{
							var text = '';
							if(days > 0){text += days + 'd: ';}
							text += hours + 'h: ' + minutes + 'm: ' + seconds + 's';
							e.text(text);
						}
						ever--;
					}, 1000);
				}
			});
		},
		
		minHeightPages: function(){
			var adminBar 		= $('#wpadminbar');
			var adminBarHeight 	= 0;
			var footer 			= $('#footer');
			var footerHeight	= 0;
			if(adminBar.length){
				adminBarHeight = adminBar.height();
			}
			if (window.matchMedia('(max-width: 600px)').matches) {
				adminBarHeight = 0;
			}
			if(footer.length){
				footerHeight = footer.outerHeight();
			}
			$('.metaportal_fn_page_ajax').css({minHeight: ($(window).height() - adminBarHeight - footerHeight) + 'px'});
		},
		
		fixAdminBar: function(){
			if(MetaPortalBody.hasClass('admin-bar')){
				$('html').addClass('frenify-html');
			}
			if($('.metaportal_fn_author_info .info_img img').length){
				$('.metaportal_fn_author_info .info_in').css({marginTop: 0});
			}
		},
		
		
		preloader: function(){
			$('.metaportal_fn_preloader').addClass('ready');
		},
		
		isotopeCollection: function(){
			if($('.collection_masonry_list').length){
				$('.collection_masonry_list').isotope({
					itemSelector: '.collection_masonry_item', // .element-item
					layoutMode: 'fitRows'
				});
			}
		},
		
		
		applyFilter: function(){
			
			// initialization isotope function to our items
			MetaPortalInit.isotopeCollection();
			// left filter on click function
			$('.metaportal_fn_filters .checkbox').off().on('click',function(){
				
					// our clicked filter
				var element 	= $(this),
					
					// detect selected filter ID
					id 			= element.data('id');
				
				
				if(MetaPortalCollection.hasClass('loading')){return false;}
				
				
				// if clicked item has clicked first time
				if(!element.hasClass('selected')){
					
					// attach 'selected' class to our filter
					element.addClass('selected');
					
					// add new filter id into our filters array in order to apply isotope filter for items next
					MetaPortalFilterArray.push(id);
					
					// call Ajax function
					MetaPortalInit.filterAjaxCall(element,1,'add',0);
					
				}
				// if clicked item has already clicked and clicked second time
				else{
					
					// remove attached 'selected' class
					element.removeClass('selected');
					
					// remove new filter ID from our filters array in order to apply isotope filter for items next
					var index = MetaPortalFilterArray.indexOf(id);
					if(index !== -1){
						MetaPortalFilterArray.splice(index, 1);
					}
					
					// call Ajax function
					MetaPortalInit.filterAjaxCall(element,1,'remove',0);
				}
				
				return false;
			});
			
			// call remove filter function
			MetaPortalInit.removeFilter();
		},
		
		
		filterAjaxCall: function(element,page,action,translate){
			MetaPortalCollection.removeClass('ready').addClass('loading');
			var preloader = $('.metaportal_fn_product_preloader');
			preloader.addClass('loading');
			
			
			if(action !== 'clear'){
				// get category name
				var category 	= element.data('category');

				// get filter name
				var filterName	= element.find('.text').text();

				// detect selected filter ID
				var id 			= element.data('id');
			}

			// filter result box
			var resultBox	= MetaPortalCollection.find('.metaportal_fn_result_box');
					
			// filter counter wrapper
			var filterCount = resultBox.find('.filter_count span');
			
			var requestData = {
				action: 'metaportal_fn_ajax_portfolio',
				categories: MetaPortalFilterArray.join(','),
				security: MetaPortalAjax.nonce,
				page: page
			};
			


			$.ajax({
				type: 'POST',
				url: MetaPortalAjax.ajax_url,
				cache: false,
				data: requestData,
				success: function(data) {
					var fnQueriedObj 	= $.parseJSON(data);
					var html			= fnQueriedObj.list;
					var pagination		= fnQueriedObj.pagination;
					
					// append new items into grid 
					MetaPortalCollection.find('.grid').html(html);
					MetaPortalInit.recallGridAfterFiltering();
					
					if(translate === 0 && $('.metaportal_fn_collection').data('scroll-top') === 'enabled'){
						var scrollTop		= $(window).scrollTop();
						var elementOffset	= $(".metaportal_fn_collectionpage").offset().top;
						var difference	 	= Math.abs(scrollTop-elementOffset) * 0.8;

						if(difference < 200){difference = 200;}
						if(difference > 1000){difference = 1000;}
						$([document.documentElement, document.body]).animate({
							scrollTop: $(".metaportal_fn_collectionpage").offset().top
						}, difference);
					}
						
					
					if($('.metaportal_fn_pagination').length){
						$('.metaportal_fn_pagination').remove();
					}
					MetaPortalCollection.find('.metaportal_fn_result_list').append(pagination);
					
					
					
					if(action === 'add'){
						// add 'clear all' button to our result box if there was no any filters early
						if(resultBox.find('.result_item').length === 0){
							resultBox.append('<a href="#" class="clear_all">'+MetaPortalAjax.clear_all_text+'</a>');
						}
						
						// find our 'clear all' button and add our new filter before the button
						resultBox.find('.clear_all').before('<div class="result_item" data-id="'+id+'"><a href="#" title="Remove Filter">' + category + ': '+'<span>' + filterName + '</span>' + '<img src="'+MetaPortalAjax.cancel_svg+'" alt="" class="fn__svg"></a></div>');
					
						// change selected filter checkbox value into 'checked'
						element.find('input[type="checkbox"]').prop('checked','checked');
						
						// increase filter count and insert into our counter wrapper
						filterCount.text(parseInt(filterCount.text())+1);
						
					}else if(action === 'remove'){
						
					
						// remove this filter from result box
						MetaPortalCollection.find('.result_item[data-id="'+id+'"]').remove();

						// remove 'clear all' button if removed filter was the only one (alone)
						if(resultBox.find('.result_item').length === 0){
							resultBox.find('.clear_all').remove();
						}
					
						// change selected filter checkbox value into 'not checked'
						element.find('input[type="checkbox"]').prop('checked','');

						// decrease filter count and insert into our counter wrapper
						filterCount.text(parseInt(filterCount.text())-1);
						
					}else if(action === 'clear'){
						
						
						$('.metaportal_fn_filters .checkbox').removeClass('selected').find('input[type="checkbox"]').prop('checked','');
						
						// remove all filters from result box
						MetaPortalCollection.find('.result_item').remove();
						
						// remove 'clear all' button
						resultBox.find('.clear_all').remove();
						
						// clear filter count
						filterCount.text(0);
					}
						
					
					
					// recall some functions
					MetaPortalInit.imgToSVG();
					MetaPortalInit.removeFilter();
					MetaPortalInit.pagedFilter();
					MetaPortalInit.productModal();
					
					preloader.removeClass('loading');
					MetaPortalCollection.removeClass('loading').addClass('ready');
				},
				error: function(xhr, textStatus, errorThrown){
					console.log(errorThrown);
					console.log(textStatus);
					console.log(xhr);
				}
			});
		},
		
		pagedFilter: function(){
			$('.metaportal_fn_collectionpage .metaportal_fn_pagination a').off().on('click',function(){
				if(MetaPortalCollection.hasClass('loading')){return false;}
				var element		= $(this),
					page		= element.find('input').val();
				if(!element.hasClass('current')){
					MetaPortalInit.filterAjaxCall(element,page,'page',0);
				}
				return false;
			});
		},
		
		removeFilter: function(){
			$('.metaportal_fn_result_box .result_item a').off().on('click',function(){
				if(MetaPortalCollection.hasClass('loading')){return false;}
				var e 			= $(this),
					id 			= e.closest('.result_item').data('id'),
					element		= $('.metaportal_fn_filters .checkbox[data-id="'+id+'"]');
				// remove new filter ID from our filters array in order to apply isotope filter for items next
				var index = MetaPortalFilterArray.indexOf(id);
				if(index !== -1){
					MetaPortalFilterArray.splice(index, 1);
				}
					
				// call Ajax function
				MetaPortalInit.filterAjaxCall(element,1,'remove',1);
				return false;
			});
			
			$('.metaportal_fn_result_box .clear_all').off().on('click',function(){
				if(MetaPortalCollection.hasClass('loading')){return false;}
				var e 			= $(this);
				
				MetaPortalFilterArray = [];	
				// call Ajax function
				MetaPortalInit.filterAjaxCall(e,1,'clear',1);
				return false;
			});
		},
		
		recallGridAfterFiltering: function(){
			var $grid = $('.collection_masonry_list').isotope({
				itemSelector: '.collection_masonry_item', // .element-item
				layoutMode: 'fitRows'
			});
			
			setTimeout(function(){
				$grid.isotope( 'reloadItems' ).isotope();
			}, 200);
		},
		
		filterItems: function(){
			$('.metaportal_fn_filters .filter_item.opened').each(function(){
				var e = $(this);
				e.find('.filter_item__content').slideDown(300);
			});
			$('.filter_item__header a').off().on('click',function(){
				var parent = $(this).closest('.filter_item');
				if(parent.hasClass('opened')){
					parent.removeClass('opened');
					parent.find('.filter_item__content').slideUp(300);
				}else{
					parent.addClass('opened');
					parent.find('.filter_item__content').slideDown(300);
				}
				return false;
			});
		},
		
		widgetTitle: function(){
			$('.wp-block-group__inner-container > h1,.wp-block-group__inner-container > h2,.wp-block-group__inner-container > h3,.wp-block-group__inner-container > h4,.wp-block-group__inner-container > h5,.wp-block-group__inner-container > h6').each(function(){
				var e = $(this);
				e.after('<div class="wid-title"><span class="text">'+e.text()+'</span><span class="icon"></span></div>');
				e.remove();
			});
			MetaPortalInit.widgetTriangle();
		},
		
		widgetTriangle: function(){
			$('.wid-title .text').each(function(){
				var e = $(this);
				e.closest('.wid-title').css('--th',e.outerHeight() + 'px');
			});
		},
		
		menuFixer: function (){
			var body			= $('body');
			var menu	 		= $('.header');
			var WinOffset		= $(window).scrollTop();

			if(WinOffset > 10){
				menu.addClass('active');
			}else{
				menu.removeClass('active');
			}
			if(WinOffset > 300){
				body.addClass('totop-active');
			}else{
				body.removeClass('totop-active');
			}
		},
		
		navFixer: function(){
			var navFooter		= $('.metaportal_fn_nav .nav_footer');
			var adminBar		= $('#wpadminbar');
			var adminBarHeight 	= 0;
			if(adminBar.length){
				adminBarHeight 	= adminBar.height();
			}
			if(navFooter.length){
				var footerHeight = navFooter.outerHeight();
				$('.metaportal_fn_nav .nav_content').css({height: ($(window).height() - footerHeight - adminBarHeight) + 'px' });
			}
			$('.admin-bar .metaportal_fn_nav').css({height: ($(window).height() - adminBarHeight) + 'px'});
		},
		
		
		
		
		// ************************************************************************
		// ************************************************************************
		// ************************************************************************
		blog_info: function(){
			if($('.blog_info').height() === 0){
				$('.metaportal_fn_comment').addClass('margin-no-top');
			}
			if($('.wp-calendar-nav').length){
				$('.wp-calendar-nav').each(function(){
					var e = $(this);
					if(!e.find('a').length){
						e.remove();
					}
				});
			}
		},
		
		projectPopup: function(){
			$('.metaportal_popup_gallery').each(function() { // the containers for all your galleries
				$(this).magnificPopup({
					delegate: 'a.zoom', // the selector for gallery item
					type: 'image',
					gallery: {
					  enabled:true
					},
					removalDelay: 300,
					mainClass: 'mfp-fade'
				});

			});
			$('.metaportal_popup_youtube, .metaportal_popup_vimeo').each(function() { // the containers for all your galleries
				$(this).magnificPopup({
					disableOn: 700,
					type: 'iframe',
					mainClass: 'mfp-fade',
					removalDelay: 160,
					preloader: false,
					fixedContentPos: false
				});
			});

			$('.metaportal_popup_soundcloude').each(function(){
				$(this).magnificPopup({
					type : 'image',
					gallery: {
						enabled: true, 
					},
				});	
			});
		},
		
		
		
		inputCheckBoxInComment: function(){
			if($('p.comment-form-cookies-consent input[type=checkbox]').length){
				$('p.comment-form-cookies-consent input[type=checkbox]').wrap('<label class="fn_checkbox"></label>').after('<span></span>');
			}
		},
		
		portfolioContentHeight: function(){
			var portfolio = $('.metaportal_fn_portfolio_page .portfolio_content');
			if(portfolio.height() === 0){
				portfolio.css({display: 'none'});
			}
		},
		
		url_fixer: function(){
			$('a[href*="fn_ex_link"]').each(function(){
				var oldUrl 	= $(this).attr('href'),
					array   = oldUrl.split('fn_ex_link/'),
					newUrl  = MetaPortalAjax.siteurl + "/" + array[1];
				$(this).attr('href', newUrl);
			});
			if($('.metaportal-fn-protected').length){
				$('.metaportal_fn_pagein').css({paddingTop: 0});
			}
		},
		
		cursor: function () {
			var myCursor = $('.frenify-cursor');
			if (myCursor.length) {
				if ($("body").length) {
					const e = document.querySelector(".cursor-inner"),
						t 	= document.querySelector(".cursor-outer");
					var n, i = 0,W = 0,intro = 0,
						o = !1;
					if($('.metaportal_fn_intro').length){intro=1;}
					
					var buttons = ".modal_ux_closer, .metaportal_fn_nav .trigger,.metaportal_fn_header .trigger,.fn_cs_intro_testimonials .prev, .fn_cs_intro_testimonials .next, .fn_cs_swiper_nav_next, .fn_cs_swiper_nav_prev, .fn_dots, .swiper-button-prev, .swiper-button-next, .fn_cs_accordion .acc_head, .metaportal_fn_popupshare .share_closer, .metaportal_fn_header .fn_finder, .metaportal_fn_header .fn_trigger, a, input[type='submit'], .cursor-link, button";
					var sliders = ".owl-carousel, .swiper-container, .cursor-link";
					// link mouse enter + move
					window.onmousemove = function(s) {
						o || (t.style.transform = "translate(" + s.clientX + "px, " + s.clientY + "px)"), e.style.transform = "translate(" + s.clientX + "px, " + s.clientY + "px)", n = s.clientY, i = s.clientX
					}, $("body").on("mouseenter", buttons, function() {
						e.classList.add("cursor-hover"), t.classList.add("cursor-hover")
					}), $("body").on("mouseleave", buttons, function() {
						$(this).is("a") && $(this).closest(".cursor-link").length || (e.classList.remove("cursor-hover"), t.classList.remove("cursor-hover"))
					}), e.style.visibility = "visible", t.style.visibility = "visible";
					
					
					// slider mouse enter
					MetaPortalBody.on('mouseenter', sliders, function(){
						e.classList.add('cursor-slider');
						t.classList.add('cursor-slider');
					}).on('mouseleave', sliders,function(){
						e.classList.remove('cursor-slider');
						t.classList.remove('cursor-slider');
					});
					
					// slider mouse hold
					MetaPortalBody.on('mousedown', sliders, function(){
						e.classList.add('mouse-down');
						t.classList.add('mouse-down');
					}).on('mouseup', sliders, function(){
						e.classList.remove('mouse-down');
						t.classList.remove('mouse-down');
					});
				}
			}
		},
		
		widget__archives: function(){
			$('.widget_archive li').each(function(){
				var e = $(this);
				var a = e.find('a').clone();
				MetaPortalBody.append('<div class="frenify_hidden_item"></div>');
				$('.frenify_hidden_item').html(e.html());
				$('.frenify_hidden_item').find('a').remove();
				var suffix = $('.frenify_hidden_item').html().match(/\d+/); // 123456
				$('.frenify_hidden_item').remove();
				suffix = parseInt(suffix);
				if(isNaN(suffix)){
					return false;
				}
				suffix = '<span class="count">'+suffix+'</span>';
				e.html(a);
				e.append(suffix);
			});
		},
		
		prev_next_posts: function(){
			if($('.metaportal_fn_siblings')){
				$(document).keyup(function(e) {
					if(e.key.toLowerCase() === 'p') {
						var a = $('.metaportal_fn_siblings').find('a.previous_project_link');
						if(a.length){
							window.location.href = a.attr('href');
							return false;
						}
					}
					if(e.key.toLowerCase() === 'n') {
						var b = $('.metaportal_fn_siblings').find('a.next_project_link');
						if(b.length){
							window.location.href = b.attr('href');
							return false;
						}
					}
				});
			}
		},
		
		
		
		
		widget__pages: function(){
			var nav 						= $('.widget_pages ul');
			nav.each(function(){
				$(this).find('a').off().on('click', function(e){
					var element 			= $(this);
					var parentItem			= element.parent('li');
					var parentItems			= element.parents('li');
					var parentUls			= parentItem.parents('ul.children');
					var subMenu				= element.next();
					var allSubMenusParents 	= nav.find('li');

					allSubMenusParents.removeClass('opened');

					if(subMenu.length){
						e.preventDefault();

						if(!(subMenu.parent('li').hasClass('active'))){
							if(!(parentItems.hasClass('opened'))){parentItems.addClass('opened');}

							allSubMenusParents.each(function(){
								var el = $(this);
								if(!el.hasClass('opened')){el.find('ul.children').slideUp();}
							});

							allSubMenusParents.removeClass('active');
							parentUls.parent('li').addClass('active');
							subMenu.parent('li').addClass('active');
							subMenu.slideDown();


						}else{
							subMenu.parent('li').removeClass('active');
							subMenu.slideUp();
						}
						return false;
					}
				});
			});
		},
		
		submenu__Mobile: function(){
			var nav 						= $('ul.vert_menu_list, .widget_nav_menu ul.menu, .metaportal_fn_mobnav .mob_bot .metaportal_fn_main_nav');
			var mobileAutoCollapse			= MetaPortalWrapper.data('mobile-autocollapse');
			nav.each(function(){
				$(this).find('a').off().on('click', function(e){
					var element 			= $(this);
					var parentItem			= element.parent('li');
					var parentItems			= element.parents('li');
					var parentUls			= parentItem.parents('ul.sub-menu');
					var subMenu				= element.next();
					var allSubMenusParents 	= nav.find('li');

					allSubMenusParents.removeClass('opened');

					if(subMenu.length){
						e.preventDefault();

						if(!(subMenu.parent('li').hasClass('active'))){
							if(!(parentItems.hasClass('opened'))){parentItems.addClass('opened');}

							allSubMenusParents.each(function(){
								var el = $(this);
								if(!el.hasClass('opened')){el.find('ul.sub-menu').slideUp();}
							});

							allSubMenusParents.removeClass('active');
							parentUls.parent('li').addClass('active');
							subMenu.parent('li').addClass('active');
							subMenu.slideDown();


						}else{
							subMenu.parent('li').removeClass('active');
							subMenu.slideUp();
						}
						return false;
					}
					if(mobileAutoCollapse === 'enable'){
						if(nav.parent().parent().hasClass('opened')){
							nav.parent().parent().removeClass('opened').slideUp();
							$('.metaportal_fn_mobilemenu_wrap .hamburger').removeClass('is-active');
						}
					}
				});
			});
		},
		
		hamburgerOpener__Mobile: function(){
			var hamburger		= $('.metaportal_fn_mobilemenu_wrap .hamburger');
			hamburger.off().on('click',function(){
				var element 	= $(this);
				var menupart	= $('.metaportal_fn_mobilemenu_wrap .mobilemenu');
				if(element.hasClass('is-active')){
					element.removeClass('is-active');
					menupart.removeClass('opened');
					menupart.slideUp(500);
				}else{
					element.addClass('is-active');
					menupart.addClass('opened');
					menupart.slideDown(500);
				}return false;
			});
		},
		
		
		
		imgToSVG: function(){
			$('img.fn__svg').each(function(){
				var img 		= $(this);
				var imgClass	= img.attr('class');
				var imgURL		= img.attr('src');

				$.get(imgURL, function(data) {
					var svg 	= $(data).find('svg');
					if(typeof imgClass !== 'undefined') {
						svg 	= svg.attr('class', imgClass+' replaced-svg');
					}
					img.replaceWith(svg);

				}, 'xml');

			});	
		},
		
		
		dataFnStyle: function(){
			$('[data-fn-style]').each(function(){
				var el		= $(this);
				var s 		= el.attr('data-fn-style');
				$.each(s.split(';'),function(i,e){
					el.css(e.split(':')[0],e.split(':')[1]);
				});
			});
		},
		
		dataFnBgImg: function(){
			var bgImage 	= $('*[data-fn-bg-img]');
			bgImage.each(function(){
				var element = $(this);
				var attrBg	= element.attr('data-fn-bg-img');
				var bgImg	= element.data('fn-bg-img');
				if(typeof(attrBg) !== 'undefined'){
					element.addClass('frenify-ready');
					if(bgImg === ''){
						return;
					}
					element.css({backgroundImage:'url('+bgImg+')'});
				}
			});
			var bgImage2 	= $('*[data-bg-img]');
			bgImage2.each(function(){
				var element = $(this);
				var attrBg	= element.attr('data-bg-img');
				var bgImg	= element.data('bg-img');
				if(typeof(attrBg) !== 'undefined'){
					element.addClass('frenify-ready');
					if(bgImg === ''){
						return;
					}
					element.css({backgroundImage:'url('+bgImg+')'});
				}
			});
		},
		
		isotopeMasonry: function(){
			var masonry = $('.fn__masonry');
			if($().isotope){
				masonry.each(function(){
					$(this).isotope({
						itemSelector: '.mas__in',
						masonry: {}
					});
				});
			}
		},
		
		estimateWidgetHeight: function(){
			var est 	= $('.metaportal_fn_widget_estimate');
			est.each(function(){
				var el 	= $(this);
				var h1 	= el.find('.helper1');
				var h2 	= el.find('.helper2');
				var h3 	= el.find('.helper3');
				var h4 	= el.find('.helper4');
				var h5 	= el.find('.helper5');
				var h6 	= el.find('.helper6');
				var eW 	= el.outerWidth();
				var w1 	= Math.floor((eW * 80) / 300);
				var w2 	= eW-w1;
				var e1 	= Math.floor((w1 * 55) / 80);
				h1.css({borderLeftWidth:	w1+'px', borderTopWidth: e1+'px'});
				h2.css({borderRightWidth:	w2+'px', borderTopWidth: e1+'px'});
				h3.css({borderLeftWidth:	w1+'px', borderTopWidth: w1+'px'});
				h4.css({borderRightWidth:	w2+'px', borderTopWidth: w1+'px'});
				h5.css({borderLeftWidth:	w1+'px', borderTopWidth: w1+'px'});
				h6.css({borderRightWidth:	w2+'px', borderTopWidth: w1+'px'});
			});
		},
    };
	
	
	
	// ready functions
	$(document).ready(function(){
		MetaPortalInit.init();
	});
	
	// resize functions
	$(window).on('resize',function(e){
		e.preventDefault();
		MetaPortalInit.isotopeMasonry();
		MetaPortalInit.navFixer();
		MetaPortalInit.estimateWidgetHeight();
		MetaPortalInit.widgetTriangle();
		MetaPortalInit.minHeightPages();
		MetaPortalInit.resizeWalletAndLeftNav();
		MetaPortalInit.totopFixer();
	});
	
	// scroll functions
	$(window).on('scroll', function(e) {
		e.preventDefault();
		MetaPortalInit.menuFixer();
    });
	
	// load functions
	$(window).on('load', function(e) {
		e.preventDefault();
		MetaPortalInit.preloader();
		MetaPortalInit.isotopeMasonry();
		MetaPortalInit.isotopeCollection();
		setTimeout(function(){
			MetaPortalInit.isotopeCollection();
		},100);
	});
	
	
	window.addEventListener("load", function(){
		MetaPortalInit.preloader();
	});
	
	
	$( window ).on( 'elementor/frontend/init', MetaPortalInit.rippleEffect );
	
})(jQuery);