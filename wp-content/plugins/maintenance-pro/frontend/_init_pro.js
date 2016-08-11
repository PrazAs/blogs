function resizeSingleVideo() {
    if (jQuery("#single-video").length > 0) {
        var width = jQuery(".main-container").width(),
            vWidth, height = jQuery(".main-container").height(),
            vHeight, videoWrapper = jQuery("#single-video");
        var ratio = 16 / 9;
        if (width / ratio < height) {
            vWidth = Math.ceil(height * ratio);
            jQuery("#single-video iframe").width(vWidth).height(height).css({
                left: (width - vWidth) / 2,
                top: 0
            })
        } else {
            vHeight = Math.ceil(width / ratio);
            jQuery("#single-video iframe").width(width).height(vHeight).css({
                left: 0,
                top: (height - vHeight) / 2
            })
        }
    }
}
jQuery(document).ready(function($) {
    if ($("#gallery-maintenance-pro").length > 0) $("#gallery-maintenance-pro").gallery_init();
    resizeSingleVideo();
    if (jQuery("#read-more-content").length > 0) jQuery("#read-more-content").on("click", function() {
        jQuery(".user-content").fadeToggle("600", function() {
            jQuery(this).css("display", "inline-block")
        });
        return false
    });
    if (jQuery(".close-user-content").length > 0) jQuery(".close-user-content").on("click", function() {
        jQuery(".user-content").fadeToggle("600", function() {
            jQuery(this).css("display", "none")
        });
        return false
    });
    if ($("#custom-subscribe").length > 0) $("#custom-subscribe").submit(function() {
        var vMailChimpData = $(this).serialize();
        var data = {
            action: "send_email_susbscribe",
            data: vMailChimpData
        };
        $.post(maintenance_frontend_vars.ajaxurl, data, function(array_in_data) {
            var array_in = jQuery.parseJSON(array_in_data);
            var vRes = array_in[0];
            var vError = array_in[1];
            var vMess = array_in[2];
            if (vRes == 1) {
                $("#email-subscribe").removeClass("error");
                $("#eicon").removeClass("");
                $("#email-subscribe").val("");
				$("#custom-subscribe").append('<span class="success">' + vMess + '</span>');
				setTimeout(function() {
					$('.success').remove();
				}, 5000);
				
            } else {
                $("#email-subscribe").addClass("error");
                $("#eicon").addClass("error")
            }
        });
        return false
    });
	
	if ($("#cirlce-countdown").length > 0) {
		var date = new Date();
		var ts   = new Date(maintenance_frontend_vars.date_countdown_start * 1E3 + date.getTimezoneOffset() * 60 * 1E3);
		var te   = new Date(maintenance_frontend_vars.date_countdown_end   * 1E3 + date.getTimezoneOffset() * 60 * 1E3);
		var cc = maintenance_frontend_vars.circle_color;
		
		$('#cirlce-countdown').final_countdown({
            'start': Math.floor(ts / 1000),
            'end':   Math.floor(te / 1000),
            'now':   Math.floor($.now() / 1000),
			seconds: {
                borderColor: cc,
                borderWidth: '5'
            },
            minutes: {
                borderColor: cc,
                borderWidth: '5'
            },
            hours: {
                borderColor: cc,
                borderWidth: '5'
            },
            days: {
                borderColor: cc,
                borderWidth: '5'
            }
			
        });
	}	
		
    if ($("#countdown").length > 0) {
        var date = new Date;
        var ts = new Date(maintenance_frontend_vars.date_countdown_end * 1E3 + date.getTimezoneOffset() * 60 * 1E3);
        var d, h, m, s;
        var vArrLabels = [maintenance_frontend_vars.dLabel, maintenance_frontend_vars.hLabel, maintenance_frontend_vars.mLabel, maintenance_frontend_vars.sLabel];
        $("#countdown").countdown({
            timestamp: ts,
            callback: function(days, hours, minutes, seconds) {
                var vHDigits = $("#countdown .box-digits").outerHeight();
				
				if (d != days) {
                    $("#countdown > .countDays").find(".bg-overlay").stop().animate({
                        height: Math.round(days * (vHDigits / 365)).toFixed(2) + "px"
                    }, {
                        duration: 500,
                        easing: "easeOutElastic"
                    });
                    d = days
                }
                if (h != hours) {
                    $("#countdown > .countHours").find(".bg-overlay").stop().animate({
                        height: Math.round(hours * (vHDigits / 24)).toFixed(2) + "px"
                    }, {
                        duration: 500,
                        easing: "easeOutElastic"
                    });
                    h = hours
                }
                if (m != minutes) {
                    $("#countdown > .countMinutes").find(".bg-overlay").stop().animate({
                        height: Math.round(minutes * (vHDigits / 60)).toFixed(2) + "px"
                    }, {
                        duration: 500,
                        easing: "easeOutElastic"
                    });
                    m = minutes
                }
                if (s != seconds) {
                    $("#countdown > .countSeconds").find(".bg-overlay").stop().animate({
                        height: Math.round(seconds * (vHDigits / 60)).toFixed(2) + "px"
                    }, {
                        duration: 500,
                        easing: "easeOutElastic"
                    });
                    s = seconds
                }
                if (s == 0 && m == 0 && h == 0 && d == 0)
                    if (maintenance_frontend_vars.isDown) {
                        location.reload();
                        return false
                    }
            },
            arrLabels: vArrLabels
        })
    }
    if ($("#social").length > 0)
        if ($(window).width() > 640) {
            var vsw = 0;
            $("#social a").each(function() {
                vsw = vsw + $(this).outerWidth(true)
            });
            $("#social").width(vsw);
            var vsc = $("#social").parent().outerWidth();
            var vcw = (vsc - vsw) / 2;
            $("#social").css({
                "margin-left": vcw,
                "margin-right": vcw
            })
        } else {
            $("#social").width("100%");
            $("#social").css({
                "margin-left": 0,
                "margin-right": 0
            })
        }
});
jQuery(window).resize(function() {
    if (jQuery("#social").length > 0)
        if (jQuery(window).width() > 640) {
            var vsw = 0;
            jQuery("#social a").each(function() {
                vsw = vsw + jQuery(this).outerWidth(true)
            });
            jQuery("#social").width(vsw);
            var vsc = jQuery("#social").parent().outerWidth();
            var vcw = (vsc - vsw) / 2;
            jQuery("#social").css({
                "margin-left": vcw,
                "margin-right": vcw
            })
        } else {
            jQuery("#social").width("100%");
            jQuery("#social").css({
                "margin-left": 0,
                "margin-right": 0
            })
        }
    resizeSingleVideo()
});
(function($) {
    function bigvideo_func(containerIn, videoUrl) {
        var bigvideo = new $.BigVideo({
            control: false,
            container: containerIn,
            useFlashForFirefox: true
        });
        bigvideo.init();
        bigvideo.show(videoUrl, {
            ambient: true
        })
    }
    $.fn.gallery_init = function() {
        var vMainElement = $(this);
        var count_slides = $(this).find("ul > li").size();
        var all_elements = $(this).find("ul").children("li");
        all_elements.css({
            "opacity": 0
        });
        var vW = $(window).width(),
            vH = $(window).height();
        all_elements.each(function() {
            var vData = $(this).data();
            if (vData.type == "video") {
                vDataUrl = $(this).find("div").eq(0).data("videourl");
                bigvideo_func($(this).find("div").eq(0), vDataUrl)
            } else fillBg($(this).find("img").eq(0), vMainElement)
        });
        var vData = all_elements.eq(0).data();
        looper(all_elements, 0, vData.delayslider);
        $(window).bind("resize", function() {
            var $self = $(this);
            vMainElement.width($self.width());
            vMainElement.height($self.height());
            all_elements.each(function() {
                fillBg($(this).find("img"), vMainElement)
            });
            return false
        })
    };

    function looper(all_elements, index, interval) {
        all_elements.eq(index).animate({
            opacity: 1
        }, 2E3, function() {
            var $self = $(this);
            if (all_elements.size() > 1) setTimeout(function() {
                $self.animate({
                    opacity: 0
                }, 2E3, function() {});
                var vData = all_elements.eq((index + 1) % all_elements.length).data();
                looper(all_elements, (index + 1) % all_elements.length, vData.delayslider)
            }, interval)
        })
    }

    function fillBg(selector) {
        var windowHeight = $(window).height();
        var windowWidth = $(window).width();
        var imgHeight = selector.attr("height");
        var imgWidth = selector.attr("width");
        var newWidth = windowWidth;
        var newHeight = windowWidth / imgWidth * imgHeight;
        var topMargin = (newHeight - windowHeight) / 2 * -1;
        var leftMargin = 0;
        if (newHeight < windowHeight) {
            var newWidth = windowHeight / imgHeight * imgWidth;
            var newHeight = windowHeight;
            var topMargin = 0;
            var leftMargin = (newWidth - windowWidth) / 2 * -1
        }
        selector.css({
            height: newHeight + "px",
            width: newWidth + "px",
            left: leftMargin + "px",
            top: topMargin + "px"
        })
    }
})(jQuery);