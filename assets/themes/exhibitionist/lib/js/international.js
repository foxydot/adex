var controller;

jQuery(document).ready(function($) {
   
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
        var bkgSize = {width:1569,height:600};
        var currBkgSize = getBkgSize($('.section-map-area .wrap'));
        var imgWidth = currBkgSize.width; //$('#location .section-body').width(); //checks out
        var imgHeight = currBkgSize.height;
        var widthMultiplier = currBkgSize.width/bkgSize.width;
        var heightMultiplier = currBkgSize.height/bkgSize.height;
        var heightdiff = imgHeight - $('.section-map-area .wrap').height();
        var windowsize = $(window).width();
        if(windowsize > 768){
            $('#locations_popovers').css('left', '50%').css('top',(imgHeight-heightdiff)/2 + 'px');
            for(var i = 0, l = location_positions.length; i < l; ++i){
                var elem = location_positions[i].elem;
                var posstr = location_positions[i].position;
                var pos = posstr.split("|");
                var left = ((pos[0]*widthMultiplier)-($(elem).width()/2));
                var top = ((pos[1]*heightMultiplier)-($(elem).height())+20);
                $(elem).css("left",left + "px").css("top",top + "px");
                var offset = $(elem).offset();
                var btm = $(elem).css("bottom");
                if(btm == "auto"){
                    btm = $(window).height() - offset.top - ($(elem).height());
                }
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
        position_it();
    });
    $( window ).resize(function() {
        position_it();
    });
    
        position_it();
});