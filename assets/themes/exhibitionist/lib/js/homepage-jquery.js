var controller;

jQuery(document).ready(function($) {
    var numwidgets = $('#homepage-widgets section.widget').length;
    $('#homepage-widgets').addClass('cols-'+numwidgets);
    var cols = 12/numwidgets;
    $('#homepage-widgets section.widget').addClass('col-sm-'+cols);
    $('#homepage-widgets section.widget').addClass('col-xs-12');
    $(".section-location .section-body .wrap").wrapInner('<div class="inner-wrap"></div>').append($('#the-hand'));
    $(".section-location .section-body .wrap").before($('#locations_popovers'));
    
    $(".section-testimonials .quote").equalHeightColumns();
    $(".section-testimonials .attribution").equalHeightColumns();
      
      // init controller
    controller = new ScrollMagic();
    // build tween
    var phoneTween = TweenMax.fromTo("#the-hand", 0.5, 
            {css:{bottom:"-516px"}},
            {css:{bottom:"-40px"}}
        );

    // build scene
    var phoneScene = new ScrollScene({triggerElement: "#location.section", duration: 700})
                    .setTween(phoneTween)
                    .addTo(controller);

    // show indicators (requires debug extension)
    //scene.addIndicators();
    
    function getBkgSize(img){
    var result;
    var imageSrc = $(img).css('backgroundImage')
                       .replace(/url\((['"])?(.*?)\1\)/gi, '$2')
                        .split(',')[0];    
    var image = new Image();
    image.src = imageSrc;
    var bgwidth = image.width,
        bgheight = image.height,    
        bgContainWidth = $(img).width();
    
    var bgContainHeight = (bgheight*bgContainWidth)/bgwidth;
    
    var decimal = bgContainHeight.toString().split('.');
    
    if(decimal[0]>=5)
    {
        bgContainHeight = Math.ceil(bgContainHeight);
    }
    else
    {
        bgContainHeight = Math.floor(bgContainHeight);
    }
    result = {'height': bgContainHeight,'width':bgContainWidth};
   return result;
    
}
    function original_image_size(elem){
        var image_url = elem.css('background-image'),
            image;
        
        // Remove url() or in case of Chrome url("")
        image_url = image_url.match(/^url\("?(.+?)"?\)$/);
        
        if (image_url[1]) {
            image_url = image_url[1];
            image = new Image();
        
            // just in case it is not already loaded
            $(image).load(function () {
                console.log(image.width + 'x' + image.height);
                return([{width:image.width,height:image.height}]);
            });
        
            //return([{width:image.width,height:image.height}]);
            image.src = image_url;
        }
    }
    
    function position_it(){
        //var bkgSize = original_image_size($('#location .section-body'));
        var bkgSize = {width:1389,height:1156};
        var currBkgSize = getBkgSize($('#location .section-body'));
        var imgWidth = currBkgSize.width; //$('#location .section-body').width(); //checks out
        var imgHeight = currBkgSize.height;
        var widthMultiplier = currBkgSize.width/bkgSize.width;
        var heightMultiplier = currBkgSize.height/bkgSize.height;
        var heightdiff = imgHeight - $('#location .section-body').height();
        var windowsize = $(window).width();
        if(windowsize > 768){
            $('#locations_popovers').css('left', '50%').css('top',(imgHeight-heightdiff)/2 + 'px');
            for(var i = 0, l = location_positions.length; i < l; ++i){
                var elem = location_positions[i].elem;
                var posstr = location_positions[i].position;
                var pos = posstr.split("|");
                var left = ((pos[0]*widthMultiplier)-($(elem).width()/2));
                var top = ((pos[1]*heightMultiplier)-($(elem).height()));
                
                $(elem).css("left",left + "px").css("top",top + "px");
                var btm = $(elem).css("bottom");
                $(elem).css("bottom",btm).css("top","auto");
            }
        }
    }
    var testbox = '<div style="height: 100px; width: 100px; background-color: red; opacity: 0.5;position: absolute;top: 50%; left: 50%;"></div>';
    //$('#locations_popovers').append(testbox);
    position_it();
    $('a.map-marker').hover(function(e){
    });
    $('a.map-marker').click(function(e){
        e.preventDefault();
        var mapdata = $(this).attr('map-data');
        $('#the-hand iframe').attr('src',mapdata);
        //position_it();
    });
    $( window ).resize(function() {
        position_it();
    });
});