var controller;
jQuery(document).ready(function($) {
    var numwidgets = $('#homepage-widgets section.widget').length;
    $('#homepage-widgets').addClass('cols-'+numwidgets);
    var cols = 12/numwidgets;
    $('#homepage-widgets section.widget').addClass('col-sm-'+cols);
    $('#homepage-widgets section.widget').addClass('col-xs-12');
    $(".section-location .section-body .wrap").wrapInner('<div class="inner-wrap"></div>').append($('#the-hand'));
    $(".section-location .section-body .wrap").before($('#locations_popovers'));
      
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
    function position_it(){
        
        var width = $('#location .section-body').width();
        var height = ($('#location .section-body').width()*996)/1406;
        var heightdiff = height - $('#location .section-body').height();
        
        $('#locations_popovers').css('left',width/2 + 'px').css('top',(height-heightdiff)/2 + 'px');
        for(var i = 0, l = location_positions.length; i < l; ++i){
            var elem = location_positions[i].elem;
            var posstr = location_positions[i].position;
            var pos = posstr.split("|");
            var left = ((pos[0]*(width/2))-($(elem).width()/2));
            var top = ((pos[1]*(height/2))+($(elem).height()));
            console.log(elem + ': ' + left + '|' + top);
            $(elem).css("left",left + "px").css("top",top + "px");
            var btm = $(elem).css("bottom");
            $(elem).css("bottom",btm).css("top","auto");
        }
    }
    
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
});