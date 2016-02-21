/*
 * jQuery DP Pro Event Calendar v1.2.1
 *
 * Copyright 2012, Diego Pereyra
 *
 * @Web: http://www.dpereyra.com
 * @Email: info@dpereyra.com
 *
 * Depends:
 * jquery.js
 */
 
(function ($) {
	function DPProEventCalendar(element, options) {
		this.calendar = $(element);
		this.eventDates = $('.dp_pec_date', this.calendar);
		
		/* Setting vars*/
		this.settings = $.extend({}, $.fn.dpProEventCalendar.defaults, options); 
		this.no_draggable = false,
		this.hasTouch = false,
		this.downEvent = "mousedown.rs",
		this.moveEvent = "mousemove.rs",
		this.upEvent = "mouseup.rs",
		this.isDragging = false,
		this.successfullyDragged = false,
		this.startTime = 0,
		this.startMouseX = 0,
		this.startMouseY = 0,
		this.currentDragPosition = 0,
		this.lastDragPosition = 0,
		this.accelerationX = 0,
		this.tx = 0;
		
		// Touch support
		if("ontouchstart" in window) {
					
			this.hasTouch = true;
			this.downEvent = "touchstart.rs";
			this.moveEvent = "touchmove.rs";
			this.upEvent = "touchend.rs";
		} 

		this.init();
	}
	
	DPProEventCalendar.prototype = {
		init : function(){
			var instance = this;
			
			instance._makeResponsive();
			
			$('.prev_month', instance.calendar).click(function(e) { instance._prevMonth(instance); });
			if(instance.settings.dateRangeStart && instance.settings.dateRangeStart.substr(0, 7) == instance.settings.actualYear+"-"+instance._str_pad(instance.settings.actualMonth, 2, "0", 'STR_PAD_LEFT') && !instance.settings.isAdmin) {
				$('.prev_month', instance.calendar).hide();
			}
			$('.next_month', instance.calendar).click(function(e) { instance._nextMonth(instance); });
			if(instance.settings.dateRangeEnd && instance.settings.dateRangeEnd.substr(0, 7) == instance.settings.actualYear+"-"+instance._str_pad(instance.settings.actualMonth, 2, "0", 'STR_PAD_LEFT') && !instance.settings.isAdmin) {
				$('.next_month', instance.calendar).hide();
			}
			
			/* touch support */
			if(instance.settings.draggable) {
				$('.dp_pec_content', instance.calendar).addClass('isDraggable');
				$('.dp_pec_content', instance.calendar).bind(instance.downEvent, function(e) { 	

					if(!instance.no_draggable) {
						instance.startDrag(e); 	
					} else if(!instance.hasTouch) {							
						e.preventDefault();
					}								
				});	
			}
			
			if(!instance.settings.isAdmin) {
				$('.dp_pec_date:not(.disabled)', instance.calendar).live('mouseup', function(event) {
					
					if(!$('.dp_pec_content', instance.calendar).hasClass('isDragging') && event.which === 1) {
						
						instance._removeElements();
						
						$.post(ProEventCalendarAjax.ajaxurl, { date: $(this).data('dppec-date'), calendar: instance.settings.calendar, action: 'getEvents', postEventsNonce : ProEventCalendarAjax.postEventsNonce },
							function(data) {
								
								$('.dp_pec_content', instance.calendar).removeClass( 'dp_pec_content_loading' );
								
								$('.dp_pec_content', instance.calendar).isotope( 'insert', $(data) );
								$('.dp_pec_isotope', instance.calendar).width($('.dp_pec_content', instance.calendar).width() - 42);
								
								instance.eventDates = $('.dp_pec_date', instance.calendar);
								$('.dp_pec_content', instance.calendar).isotope( 'reLayout' );
							}
						);	
					}
	
				});
			}
			
			$('.dp_pec_date_event_back', instance.calendar).live('click', function(event) {
				event.preventDefault();
				instance._removeElements();
				
				instance._changeMonth();
			});
			
			$('.dp_pec_references', instance.calendar).click(function() {
				$('.dp_pec_references_div', instance.calendar).slideDown('fast');
			});
			
			$('.dp_pec_references_close', instance.calendar).click(function() {
				$('.dp_pec_references_div', instance.calendar).slideUp('fast');
			});
			
			$('.dp_pec_search', instance.calendar).one('click', function(event) {
				$(this).val("");
			});
			
			$('.dp_pec_search_form', instance.calendar).submit(function() {
				if($(this).find('.dp_pec_search').val() != "" && !$('.dp_pec_content', instance.calendar).hasClass( 'dp_pec_content_loading' )) {
					instance._removeElements();
					
					$.post(ProEventCalendarAjax.ajaxurl, { key: $(this).find('.dp_pec_search').val(), calendar: instance.settings.calendar, action: 'getSearchResults', postEventsNonce : ProEventCalendarAjax.postEventsNonce },
						function(data) {
							
							$('.dp_pec_content', instance.calendar).removeClass( 'dp_pec_content_loading' );
							
							$('.dp_pec_content', instance.calendar).isotope( 'insert', $(data) );
							$('.dp_pec_isotope', instance.calendar).width($('.dp_pec_content', instance.calendar).width() - 42);
							
							instance.eventDates = $('.dp_pec_date', instance.calendar);
						}
					);	
				}
				return false;
			});
		},
		
		_makeResponsive : function() {
			var instance = this;
			
			if(instance.calendar.width() < 500) {
				$(instance.calendar).addClass('dp_pec_400');

				$('.dp_pec_dayname span', instance.calendar).each(function(i) {
					$(this).html($(this).html().substr(0,3));
				});
				
				$('.prev_month strong', instance.calendar).hide();
				$('.next_month strong', instance.calendar).hide();
				
				$('.dp_pec_content', instance.calendar).isotope( 'reLayout' );
			} else {
				$(instance.calendar).removeClass('dp_pec_400');

				$('.prev_month strong', instance.calendar).show();
				$('.next_month strong', instance.calendar).show();
				
				$('.dp_pec_content', instance.calendar).isotope( 'reLayout' );
			}
		},
		_removeElements : function () {
			var instance = this;
			
			$('.dp_pec_content', instance.calendar).isotope( 'remove', $('.dp_pec_date,.dp_pec_dayname,.dp_pec_isotope', instance.calendar) );
		
			$('.dp_pec_content', instance.calendar).addClass( 'dp_pec_content_loading' );
		},
		
		_prevMonth : function (instance) {
			if(!$('.dp_pec_content', instance.calendar).hasClass( 'dp_pec_content_loading' )) {
				instance.settings.actualMonth--;
				instance.settings.actualMonth = instance.settings.actualMonth == 0 ? 12 : (instance.settings.actualMonth);
				instance.settings.actualYear = instance.settings.actualMonth == 12 ? instance.settings.actualYear - 1 : instance.settings.actualYear;
				
				instance._changeMonth();
			}
		},
		
		_nextMonth : function (instance) {
			if(!$('.dp_pec_content', instance.calendar).hasClass( 'dp_pec_content_loading' )) {
				instance.settings.actualMonth++;
				instance.settings.actualMonth = instance.settings.actualMonth == 13 ? 1 : (instance.settings.actualMonth);
				instance.settings.actualYear = instance.settings.actualMonth == 1 ? instance.settings.actualYear + 1 : instance.settings.actualYear;
	
				instance._changeMonth();
			}
		},
		
		_changeMonth : function () {
			var instance = this;
			
			$('.dp_pec_content', instance.calendar).css({'overflow': 'hidden'});
			$('span.actual_month', instance.calendar).html( instance.settings.monthNames[(instance.settings.actualMonth - 1)] + ' ' + instance.settings.actualYear );

			instance._removeElements();
			
			if(instance.settings.dateRangeStart && instance.settings.dateRangeStart.substr(0, 7) == instance.settings.actualYear+"-"+instance._str_pad(instance.settings.actualMonth, 2, "0", 'STR_PAD_LEFT') && !instance.settings.isAdmin) {
				$('.prev_month', instance.calendar).hide();
			} else {
				$('.prev_month', instance.calendar).show();
			}

			if(instance.settings.dateRangeEnd && instance.settings.dateRangeEnd.substr(0, 7) == instance.settings.actualYear+"-"+instance._str_pad(instance.settings.actualMonth, 2, "0", 'STR_PAD_LEFT') && !instance.settings.isAdmin) {
				$('.next_month', instance.calendar).hide();
			} else {
				$('.next_month', instance.calendar).show();
			}
			
			var date_timestamp = Date.UTC(instance.settings.actualYear, (instance.settings.actualMonth - 1), 1) / 1000;

			$.post(ProEventCalendarAjax.ajaxurl, { date: date_timestamp, calendar: instance.settings.calendar, is_admin: instance.settings.isAdmin, action: 'getDate', postEventsNonce : ProEventCalendarAjax.postEventsNonce },
				function(data) {
					
					$('.dp_pec_content', instance.calendar).removeClass( 'dp_pec_content_loading' );
					
					$('.dp_pec_content', instance.calendar).isotope( 'insert', $(data) );
					
					instance.eventDates = $('.dp_pec_date', instance.calendar);
					
					instance._makeResponsive();
				}
			);	
			
			
		},
		
		_str_pad: function (input, pad_length, pad_string, pad_type) {
			
			var half = '',
				pad_to_go;
		 
			var str_pad_repeater = function (s, len) {
				var collect = '',
					i;
		 
				while (collect.length < len) {
					collect += s;
				}
				collect = collect.substr(0, len);
		 
				return collect;
			};
		 
			input += '';
			pad_string = pad_string !== undefined ? pad_string : ' ';
		 
			if (pad_type != 'STR_PAD_LEFT' && pad_type != 'STR_PAD_RIGHT' && pad_type != 'STR_PAD_BOTH') {
				pad_type = 'STR_PAD_RIGHT';
			}
			if ((pad_to_go = pad_length - input.length) > 0) {
				if (pad_type == 'STR_PAD_LEFT') {
					input = str_pad_repeater(pad_string, pad_to_go) + input;
				} else if (pad_type == 'STR_PAD_RIGHT') {
					input = input + str_pad_repeater(pad_string, pad_to_go);
				} else if (pad_type == 'STR_PAD_BOTH') {
					half = str_pad_repeater(pad_string, Math.ceil(pad_to_go / 2));
					input = half + input + half;
					input = input.substr(0, pad_length);
				}
			}
		 
			return input;
		},
		
		// Start dragging
		startDrag:function(e) {
			var instance = this;
			
			if(!instance.isDragging) {					
				var point;
				if(instance.hasTouch) {
					//parsing touch event
					var currTouches = e.originalEvent.touches;
					if(currTouches && currTouches.length > 0) {
						point = currTouches[0];
					}					
					else {	
						return false;						
					}
				} else {
					point = e;		
					
					if (e.target) el = e.target;
					else if (e.srcElement) el = e.srcElement;

					if(el.toString() !== "[object HTMLEmbedElement]" && el.toString() !== "[object HTMLObjectElement]") {	
						e.preventDefault();						
					}
				}

				instance.isDragging = true;
				
				$(document).bind(instance.moveEvent, function(e) { if(!instance.hasTouch) { e.preventDefault();	} instance.moveDrag(e); });
				$(document).bind(instance.upEvent, function(e) { instance.releaseDrag(e); });		

				
				startPos = instance.tx = parseInt(instance.eventDates.css("margin-left"), 10);	
				
				instance.successfullyDragged = false;
				instance.accelerationX = this.tx;
				instance.startTime = (e.timeStamp || new Date().getTime());
				instance.startMouseX = point.clientX;
				instance.startMouseY = point.clientY;
			}
			return false;	
		},				
		moveDrag:function(e) {	
			var instance = this;
			
			var point;
			if(instance.hasTouch) {	
				
				var touches = e.originalEvent.touches;
				// If touches more then one, so stop sliding and allow browser do default action
				
				if(touches.length > 1) {
					return false;
				}
				
				point = touches[0];	
			
				e.preventDefault();				
			} else {
				point = e;
				e.preventDefault();		
			}

			// Helps find last direction of drag move
			instance.lastDragPosition = instance.currentDragPosition;
			var distance = point.clientX - instance.startMouseX;
			if(instance.lastDragPosition != distance) {
				instance.currentDragPosition = distance;
			}

			if(distance != 0)
			{	

				if(instance.settings.dateRangeStart && instance.settings.dateRangeStart.substr(0, 7) == instance.settings.actualYear+"-"+instance._str_pad(instance.settings.actualMonth, 2, "0", 'STR_PAD_LEFT') && !instance.settings.isAdmin) {			
					if(distance > 0) {
						distance = Math.sqrt(distance) * 5;
					}			
				} else if(instance.settings.dateRangeEnd && instance.settings.dateRangeEnd.substr(0, 7) == instance.settings.actualYear+"-"+instance._str_pad(instance.settings.actualMonth, 2, "0", 'STR_PAD_LEFT') && !instance.settings.isAdmin) {		
					if(distance < 0) {
						distance = -Math.sqrt(-distance) * 5;
					}	
				}
				
				$('.dp_pec_content', instance.calendar).addClass('isDragging');
				instance.eventDates.css("margin-left", distance);		
				
			}	
			
			var timeStamp = (e.timeStamp || new Date().getTime());
			if (timeStamp - instance.startTime > 350) {
				instance.startTime = timeStamp;
				instance.accelerationX = instance.tx + distance;						
			}
			
				
			return false;		
		},
		releaseDrag:function(e) {
			var instance = this;
			
			if(instance.isDragging) {	
				var self = this;
				instance.isDragging = false;			
				$('.dp_pec_content', instance.calendar).removeClass('isDragging');
				
				var endPos = parseInt(instance.eventDates.css('margin-left'), 10);

				$(document).unbind(instance.moveEvent).unbind(instance.upEvent);					

				if(endPos == instance._startPos) {						
					instance.successfullyDragged = false;
					return;
				} else {
					instance.successfullyDragged = true;
				}
				
				var dist = (instance.accelerationX - endPos);		
				var duration =  Math.max(40, (e.timeStamp || new Date().getTime()) - instance.startTime);
				// For nav speed calculation F=ma :)
				var v0 = Math.abs(dist) / duration;	
				
				
				var newDist = instance.eventDates.width() - Math.abs(startPos - endPos);
				var newDuration = Math.max((newDist * 1.08) / v0, 200);
				newDuration = Math.min(newDuration, 600);
	
				function returnToCurrent() {						
					newDist = Math.abs(startPos - endPos);
					newDuration = Math.max((newDist * 1.08) / v0, 200);
					newDuration = Math.min(newDuration, 500);

					$(instance.eventDates).animate(
						{marginLeft: 0}, 
						'fast'
					);
				}
				
				// calculate move direction
				if((startPos - instance.settings.dragOffset) > endPos) {		

					if(instance.lastDragPosition < instance.currentDragPosition) {	
						returnToCurrent();
						return false;					
					}
					
					if(!(instance.settings.dateRangeEnd && instance.settings.dateRangeEnd.substr(0, 7) == instance.settings.actualYear+"-"+instance._str_pad(instance.settings.actualMonth, 2, "0", 'STR_PAD_LEFT') && !instance.settings.isAdmin)) {
						instance._nextMonth(instance);
					} else {
						returnToCurrent();
					}
					
				} else if((startPos + instance.settings.dragOffset) < endPos) {	

					if(instance.lastDragPosition > instance.currentDragPosition) {
						returnToCurrent();
						return false;
					}
					
					if(!(instance.settings.dateRangeStart && instance.settings.dateRangeStart.substr(0, 7) == instance.settings.actualYear+"-"+instance._str_pad(instance.settings.actualMonth, 2, "0", 'STR_PAD_LEFT') && !instance.settings.isAdmin)) {
						instance._prevMonth(instance);
					} else {
						returnToCurrent();
					}

				} else {
					returnToCurrent();
				}
			}

			return false;
		}
	}
	
	$.fn.dpProEventCalendar = function(options){  

		var dpProEventCalendar;
		this.each(function(){
			
			dpProEventCalendar = new DPProEventCalendar($(this), options);
			
			$(this).data("dpProEventCalendar", dpProEventCalendar);
			
		});
		
		return this;

	}
	
  	/* Default Parameters and Events */
	$.fn.dpProEventCalendar.defaults = {  
		monthNames : new Array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'),
		actualMonth : '',
		actualYear : '',
		calendar: null,
		dateRangeStart: null,
		dateRangeEnd: null,
		draggable: true,
		isAdmin: false,
		dragOffset: 50
	};  
	
	$.fn.dpProEventCalendar.settings = {}
	
})(jQuery);