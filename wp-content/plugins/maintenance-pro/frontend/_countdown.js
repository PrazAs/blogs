(function($){
	var days	= 24*60*60,
		hours	= 60*60,
		minutes	= 60;
	$.fn.countdown = function(prop){
		var options = $.extend({
			callback	: function(){},
			timestamp	: 0,
			arrLabels   : ['Days','Hours','Minutes','Seconds']
		},prop);
		
		var left, d, h, m, s, positions, ed, eh, em, es;
		var outD = Math.floor(Math.floor((options.timestamp - (new Date())) / 1000) / days);
		
		init(this, options, outD);
		positions = this.find('.position');
		
		
		(function tick(){
			left = Math.floor((options.timestamp - (new Date())) / 1000);
			if(left < 0) { left = 0; }
			d = Math.floor(left / days);
			if (d > 99) { updateDuo(0, 2, d); } else { updateDuo(0, 1, d); }			
			left -= d*days;
			h = Math.floor(left / hours);
			if (d > 99) { updateDuo(3, 4, h); } else { updateDuo(2, 3, h); }			
			left -= h*hours;
			m = Math.floor(left / minutes);
			if (d > 99) { updateDuo(5, 6, m); } else { updateDuo(4, 5, m); }			
			left -= m*minutes;
			s = left;
			if (d > 99) { updateDuo(7, 8, s); } else { updateDuo(6, 7, s); }			
			options.callback(d, h, m, s);
			setTimeout(tick, 1000);
		})();
		
		function updateDuo(minor,major,value){
			if (value > 99) {
				switchDigit(positions.eq(minor),Math.floor(value/100)%100);
			} else {
				switchDigit(positions.eq(minor),Math.floor(value/10)%10);
			}
			switchDigit(positions.eq(major),value%10);
		}
		return this;
	};


	function init(elem, options, d){
		elem.addClass('countdownHolder');
		$.each(options.arrLabels,function(i){
			if (i == 0 && d > 99) {
				$('<span class="digits count' +this+'"></span>').html(
					'<div class="box-digits e'+this+'">' +
						'<span class="position"><span class="digit static">0</span></span>' + 
						'<span class="position"><span class="digit static">0</span></span>' + 
						'<span class="position"><span class="digit static">0</span></span>' + 
						'<span class="bg-overlay"></span>' +
					'</div>' +
					'<span class="title-time">'+this+'</span>'
				).appendTo(elem);
			} else {
				$('<span class="digits count' +this+'"></span>').html(
					'<div class="box-digits e'+this+'">' +
						'<span class="position"><span class="digit static">0</span></span>' + 
						'<span class="position"><span class="digit static">0</span></span>' + 
						'<span class="bg-overlay"></span>' +
					'</div>' +
				'<span class="title-time">'+this+'</span>'
				).appendTo(elem);
			}
		});

	}

	function switchDigit(position,number){
		var digit = position.find('.digit')
		 if(digit.is(':animated')){ return false; }
		 if(position.data('digit') == number){
			return false;
		}
		position.data('digit', number);
		var replacement = $('<span>',{
			'class':'digit',
			css:{
				top:'-2.1em',
				opacity:0
			},
			html:number
		});
		
		digit
			.before(replacement)
			.removeClass('static')
			.animate({top:'1em',opacity:0},'fast',function(){
				digit.remove();
			})

		replacement
			.delay(100)
			.animate({top:0,opacity:1},'fast',function(){
				replacement.addClass('static');
			});
	}
})(jQuery);