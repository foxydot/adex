var controller;jQuery(document).ready(function($){function t(t){var i,o=$(t).css("backgroundImage").replace(/url\((['"])?(.*?)\1\)/gi,"$2").split(",")[0],a=new Image;a.src=o;var e=a.width,r=a.height,h=$(t).width(),n=r*h/e,s=n.toString().split(".");return n=s[0]>=5?Math.ceil(n):Math.floor(n),i={height:n,width:h}}function i(t){var i=t.css("background-image"),o;i=i.match(/^url\("?(.+?)"?\)$/),i[1]&&(i=i[1],o=new Image,$(o).load(function(){return console.log(o.width+"x"+o.height),[{width:o.width,height:o.height}]}),o.src=i)}function o(){var i={width:1569,height:600},o=t($(".section-map-area .wrap")),a=o.width,e=o.height,r=o.width/i.width,h=o.height/i.height,n=e-$(".section-map-area .wrap").height(),s=$(window).width();if(s>768){$("#locations_popovers").css("left","50%").css("top",(e-n)/2+"px");for(var c=0,p=location_positions.length;p>c;++c){var l=location_positions[c].elem,d=location_positions[c].position,g=d.split("|"),w=g[0]*r-$(l).width()/2,u=g[1]*h-$(l).height()+20;$(l).css("left",w+"px").css("top",u+"px");var m=$(l).css("bottom");$(l).css("bottom",m).css("top","auto")}}}var a='<div style="height: 100px; width: 100px; background-color: red; opacity: 0.5;position: absolute;top: 50%; left: 50%;"></div>';o(),$("a.map-marker").hover(function(t){}),$("a.map-marker").click(function(t){t.preventDefault();var i=$(this).attr("map-data");$("#the-hand iframe").attr("src",i),o()}),$(window).resize(function(){o()})});