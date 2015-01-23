var controller;
jQuery(document).ready(function($) {
    console.log(location_positions);
    var numwidgets = $('#homepage-widgets section.widget').length;
    $('#homepage-widgets').addClass('cols-'+numwidgets);
    var cols = 12/numwidgets;
    $('#homepage-widgets section.widget').addClass('col-sm-'+cols);
    $('#homepage-widgets section.widget').addClass('col-xs-12');
    $(".section-location .section-body .wrap").wrapInner('<div class="inner-wrap"></div>').append($('#the-hand'));
    $(".section-location .section-body .wrap").prepend($('#locations_popovers'));
      
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
});