(function(e,t){jQuery.fn.blink=function(n){var r={times:3,speed:200};n=e.extend(r,n);this.each(function(){var r=e(this);for(var i=0;i<n.times;i++)t.setTimeout(function(){r.fadeOut(n.speed).fadeIn(n.speed)},n.speed*2*i)})}})(jQuery,window);