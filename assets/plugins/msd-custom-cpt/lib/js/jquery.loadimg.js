(function($) {
    $.fn.load_bkg = function(opts) {
        // default configuration
        var config = $.extend({}, {
            opt1: null
        }, opts);
    
        // main function
        function loadit(e) {
      var bkg = img_array[0];
      img_array.shift();
      e.css('background-image','url("'+bkg+'")').fadeIn(1000).delay(5000).fadeOut(1000,function(){
        e.trigger('click');
      });
      img_array.push(bkg);
        }

        // initialize every element
        this.each(function() {
            loadit($(this));
        });

        return this;
    };
})(jQuery);