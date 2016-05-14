/**
 * Draggable Background plugin for jQuery
 *
 * v1.2.4
 *
 * Copyright (c) 2014 Kenneth Chung
 *
 * Licensed under the MIT license:
 *   http://www.opensource.org/licenses/mit-license.php
 */
;(function($) {
  var $window = $(window);

  // Helper function to guarantee a value between low and hi unless bool is false
  var limit = function(low, hi, value, bool) {
    if (arguments.length === 3 || bool) {
      if (value < low) return low;
      if (value > hi) return hi;
    }
    return value;
  };

  // Adds clientX and clientY properties to the jQuery's event object from touch
  var modifyEventForTouch = function(e) {
    e.clientX = e.originalEvent.touches[0].clientX;
    e.clientY = e.originalEvent.touches[0].clientY;
  };

  var getBackgroundImageDimensions = function($el) {
    var bgSrc = ($el.css('background-image').match(/^url\(['"]?(.*?)['"]?\)$/i) || [])[1];
    if (!bgSrc) return;

    var imageDimensions = { width: 0, height: 0 },
        image = new Image();

    image.onload = function() {
      if ($el.css('background-size') == "cover") {
        var elementWidth = $el.innerWidth(),
            elementHeight = $el.innerHeight(),
            elementAspectRatio = elementWidth / elementHeight;
            imageAspectRatio = image.width / image.height,
            scale = 1;

        if (imageAspectRatio >= elementAspectRatio) {
          scale = elementHeight / image.height;
        } else {
          scale = elementWidth / image.width;
        }

        imageDimensions.width = image.width * scale;
        imageDimensions.height = image.height * scale;
      } else {
        imageDimensions.width = image.width;
        imageDimensions.height = image.height;
      }
    };

    image.src = bgSrc;

    return imageDimensions;
  };

  function Plugin(element, options) {
    this.element = element;
    this.options = options;
    this.init();
  }

  Plugin.prototype.init = function() {
    var $el = $(this.element),
        bgSrc = ($el.css('background-image').match(/^url\(['"]?(.*?)['"]?\)$/i) || [])[1],
        options = this.options;

    if (!bgSrc) return;

    // Get the image's width and height if bound
    var imageDimensions = { width: 0, height: 0 };
    if (options.bound) {
      imageDimensions = getBackgroundImageDimensions($el);
    }

    $el.on('mousedown.dbg touchstart.dbg', function(e) {
      if (e.target !== $el[0]) {
        return;
      }
      e.preventDefault();

      if (e.originalEvent.touches) {
        modifyEventForTouch(e);
      } else if (e.which !== 1) {
        return;
      }

      var x0 = e.clientX,
          y0 = e.clientY,
          pos = $el.css('background-position').match(/(-?\d+).*?\s(-?\d+)/) || [],
          xPos = parseInt(pos[1]) || 0,
          yPos = parseInt(pos[2]) || 0;

      $window.on('mousemove.dbg touchmove.dbg', function(e) {
        e.preventDefault();

        if (e.originalEvent.touches) {
          modifyEventForTouch(e);
        }

        var x = e.clientX,
            y = e.clientY;

        xPos = options.axis === 'y' ? xPos : limit($el.innerWidth()-imageDimensions.width, 0, xPos+x-x0, options.bound);
        yPos = options.axis === 'x' ? yPos : limit($el.innerHeight()-imageDimensions.height, 0, yPos+y-y0, options.bound);
        x0 = x;
        y0 = y;

        $el.css('background-position', xPos + 'px ' + yPos + 'px');
      });

      $window.on('mouseup.dbg touchend.dbg mouseleave.dbg', function() {
        if (options.done) {
          options.done();
        }

        $window.off('mousemove.dbg touchmove.dbg');
        $window.off('mouseup.dbg touchend.dbg mouseleave.dbg');
      });
    });
  };

  Plugin.prototype.disable = function() {
    var $el = $(this.element);
    $el.off('mousedown.dbg touchstart.dbg');
    $window.off('mousemove.dbg touchmove.dbg mouseup.dbg touchend.dbg mouseleave.dbg');
  }

  $.fn.backgroundDraggable = function(options) {
    var options = options;
    var args = Array.prototype.slice.call(arguments, 1);

    return this.each(function() {
      var $this = $(this);

      if (typeof options == 'undefined' || typeof options == 'object') {
        options = $.extend({}, $.fn.backgroundDraggable.defaults, options);
        var plugin = new Plugin(this, options);
        $this.data('dbg', plugin);
      } else if (typeof options == 'string' && $this.data('dbg')) {
        var plugin = $this.data('dbg');
        Plugin.prototype[options].apply(plugin, args);
      }
    });
  };

  $.fn.backgroundDraggable.defaults = {
    bound: true,
    axis: undefined
  };
}(jQuery));


jq = jQuery;
function ab_initial_avatar(){
	jQuery('.ab-dynamic-avatar').each(function(index, el) {
		jQuery(el).initial({name: jQuery(this).attr('title'), height: jQuery(this).attr('height'), width: jQuery(this).attr('width'), fontSize:15, fontWeight:700});
	});
	
}
function ab_str_to_color(str) {
    var hash = 0;
    for (var i = 0; i < str.length; i++) {
        hash = str.charCodeAt(i) + ((hash << 5) - hash);
    }
    var colour = '#';
    for (var i = 0; i < 3; i++) {
        var value = (hash >> (i * 8)) & 0xFF;
        colour += ('00' + value.toString(16)).substr(-2);
    }
    return ab_shade_color(colour, 20);
}
function ab_shade_color(color, percent) {  
    var num = parseInt(color.slice(1),16), amt = Math.round(2.55 * percent), R = (num >> 16) + amt, G = (num >> 8 & 0x00FF) + amt, B = (num & 0x0000FF) + amt;
    return "#" + (0x1000000 + (R<255?R<1?0:R:255)*0x10000 + (G<255?G<1?0:G:255)*0x100 + (B<255?B<1?0:B:255)).toString(16).slice(1);
}


jQuery(document).ready(function(){

	ab_initial_avatar();
	
	jQuery('.circular-progress').each(function(){
    var circle = new ProgressBar.Circle(this, {
        color: jQuery(this).data('color'),
        strokeWidth: jQuery(this).data('width'),
        trailWidth: jQuery(this).data('width'),
        duration: 1500
      });
      circle.animate(jQuery(this).data('pct')/100);
  });

  jQuery('.profile-progress').each(function(){
    var circle = new ProgressBar.Line(this, {
        color: '#FCB03C',
        strokeWidth: 5,
        trailWidth: 5,
        duration: 1500
      });
      circle.animate(jQuery(this).data('pct')/100);
  }); 

  jQuery('.level-bar').each(function(){
    var line = new ProgressBar.Line(this, {
        color: jQuery(this).data('color'),
        strokeWidth: jQuery(this).data('width'),
        trailWidth: jQuery(this).data('width'),
        duration: 1000,
      });
      line.animate(jQuery(this).data('pct')/100);
  });  

  jQuery('.circle-progress').each(function(){
    var span = jQuery(this).find('span');

    span.css({'margin-top' : -Math.abs(span.innerHeight()/2), 'margin-left' : -Math.abs(span.innerWidth()/2)});
		var circle = new ProgressBar.Circle(this, {
		    color: jQuery(this).data('color'),
		    strokeWidth: jQuery(this).data('width'),
		    trailWidth: jQuery(this).data('width'),
		    duration: 1500,
	    });
	    circle.animate(jQuery(this).data('pct')/100);
	});


	
	jQuery( document ).ajaxComplete(function( event, data, settings ) {
		setTimeout(function() {
			ab_initial_avatar();
		}, 200);		
	});
	/*jQuery('.dropdown-menu').click(function(e) {
        e.stopPropagation();
    });*/

  jq('.activity-type-dropdown li').on( 'click', function(event) {

		/* Reset the page */
		jq.cookie( 'bp-activity-oldestpage', 1, {
			path: '/'
		} );

		/* Activity Stream Tabs */
		scope  = jq(this).attr('id').substr( 9, jq(this).attr('id').length );
		filter = jq('#activity-filter-select select').val();

		if ( scope === 'mentions' ) {
			jq( '#' + target.attr('id') + ' a strong' ).remove();
		}

		bp_activity_request(scope, filter);
		jq('.activity-type-dropdown').removeClass('open')
		return false;
	});

	jq('.user-cover.no-cover').each(function(index, el) {
		jq(this).css({background: ab_str_to_color(jq(this).data('id')) });
	});

	/* Activity filter select */
	jq('.entry-header select#activity-filter-by').change( function() {
		var selected_tab = jq( 'div.activity-type-dropdown li.selected' ),
			filter = jq(this).val(),
			scope;

		if ( !selected_tab.length ) {
			scope = null;
		} else {
			scope = selected_tab.attr('id').substr( 9, selected_tab.attr('id').length );
		}

		bp_activity_request(scope, filter);

		return false;
	});

	jq('[data-action="cover-upload-field"]').change(function(event) {
		jq(this).closest('form').submit();
	});

	jq('[data-action="cover_upload"]').submit(function() {
        jq(this).ajaxSubmit({
            success: function(data) {
            	jq('[data-cont="cover"]').css('background-image', data.image);
              jq('#main-cover').removeClass('no-cover');
            },
            context: this,
            url: ajaxurl,
            dataType: 'json'
        });
        return false
    });

    jq('#enable-cover-drag').click(function(event) {
        jq('.cover-upload').hide();
        jq('.cover-reposition').addClass('active');
        jq('#main-cover').addClass('editing');
        jq('#main-cover').backgroundDraggable({ bound: true, axis: 'y' });
    });

    jq('#enable-cover-drag-done').click(function() {
        jq.ajax({
            url: ajaxurl,
            type: 'POST',
            data: {pos: jq('#main-cover').css('background-position'), action: 'save_cover_position', '__nonce': jq('#main-cover').data('posnonce')},
        })
        .done(function() {
            console.log("success");
        })
        .fail(function() {
            console.log("error");
        })
        .always(function() {
            console.log("complete");
        });
        
        jq('.cover-upload').show();
        jq('.cover-reposition').removeClass('active');
        jq('#main-cover').removeClass('editing');
        jq('#main-cover').backgroundDraggable('disable');
    });

    jq('#user-dd-menu').on('show.bs.dropdown', function (e) {
        setTimeout(function(){
          var span = jq('#user-dd-menu .reputation-badge span');
          span.css({'margin-top' : -Math.abs(span.height()/2), 'margin-left' : -Math.abs(span.width()/2)});
        }, 50);        
    });

      jq('#user-dd-notification').on('show.bs.dropdown', function (e) {
      if(!jq(this).is('.loaded')){
        jq.ajax({
            url: ajaxurl,
            type: 'GET',
            data: {action: 'load_user_notifications'},
            context:this,
            success: function(data){
              if(jq(this).find('li').length> 1)
                jq(this).find('li').remove();

              jq(this).find('.user-dd-notification-loading').hide();
              jq(this).find('.user-dd-notification-items').append(data);
              jq(this).addClass('loaded')
            }
        });
      }
    });

    jq('.site-search-toggle').click(function(e) {
      e.preventDefault();
      jq(this).parent().toggleClass('active');
      jq('#site-search').slideToggle(100);
      jq('body').toggleClass('search-shown');
    });

    jq('.reputation-bar').peity('bar',{
      width:'100%',
      height:'50'
    });

    jq('.reputation-big-bar').peity('bar',{
      width:'100%',
      height:'110'
    });

    jq('#whats-new').on('focus blur', function(event) {
      jq(this).parent().next().slideToggle(200);
    });
	
});
