jQuery(document).ready(function($){$("*:first-child").addClass("first-child"),$("*:last-child").addClass("last-child"),$("*:nth-child(even)").addClass("even"),$("*:nth-child(odd)").addClass("odd");var e=$("#footer-widgets div.widget").length;$("#footer-widgets").addClass("cols-"+e),$.each(["show","hide"],function(e,t){var a=$.fn[t];$.fn[t]=function(){return this.trigger(t),a.apply(this,arguments)}}),$(".layerslider_widget .ls-slide").one("show",function(){var e=$(this).find(".fuzzybubble"),t=$(this).find(".ls-bg");e.layersliderblur({radius:10,source:t})}),$("#billboard_nav a[href*=#]:not([href=#]),#floating_nav a[href*=#]:not([href=#]),#filters a[href*=#]:not([href=#]),a[href=#filters]").click(function(){if(location.pathname.replace(/^\//,"")==this.pathname.replace(/^\//,"")&&location.hostname==this.hostname){var e=$(this.hash),t;if(t=$("#floating_nav").length>0?140:0,e=e.length?e:$("[name="+this.hash.slice(1)+"]"),e.length)return $("html,body").animate({scrollTop:e.offset().top-t},1e3),!1}})}),function($){$.fn.layersliderblur=function(e){function t(e,t,r,o,c,i){if(!(isNaN(i)||1>i)){i|=0;var l=e.getContext("2d"),g;try{try{g=l.getImageData(t,r,o,c)}catch(h){try{netscape.security.PrivilegeManager.enablePrivilege("UniversalBrowserRead"),g=l.getImageData(t,r,o,c)}catch(h){throw alert("Cannot access local image"),new Error("unable to access local image data: "+h)}}}catch(h){throw alert("Cannot access image"),new Error("unable to access image data: "+h)}var d=g.data,f,u,m,b,p,v,x,y,w,C,I,k,S,P,K,j,z,A,D,E,U=i+i+1,_=o<<2,R=o-1,Z=c-1,N=i+1,Q=N*(N+1)/2,B=new a,L=B;for(m=1;U>m;m++)if(L=L.next=new a,m==N)var M=L;L.next=B;var O=null,T=null;x=v=0;var q=n[i],F=s[i];for(u=0;c>u;u++){for(P=K=j=y=w=C=0,I=N*(z=d[v]),k=N*(A=d[v+1]),S=N*(D=d[v+2]),y+=Q*z,w+=Q*A,C+=Q*D,L=B,m=0;N>m;m++)L.r=z,L.g=A,L.b=D,L=L.next;for(m=1;N>m;m++)b=v+((m>R?R:m)<<2),y+=(L.r=z=d[b])*(E=N-m),w+=(L.g=A=d[b+1])*E,C+=(L.b=D=d[b+2])*E,P+=z,K+=A,j+=D,L=L.next;for(O=B,T=M,f=0;o>f;f++)d[v]=y*q>>F,d[v+1]=w*q>>F,d[v+2]=C*q>>F,y-=I,w-=k,C-=S,I-=O.r,k-=O.g,S-=O.b,b=x+((b=f+i+1)<R?b:R)<<2,P+=O.r=d[b],K+=O.g=d[b+1],j+=O.b=d[b+2],y+=P,w+=K,C+=j,O=O.next,I+=z=T.r,k+=A=T.g,S+=D=T.b,P-=z,K-=A,j-=D,T=T.next,v+=4;x+=o}for(f=0;o>f;f++){for(K=j=P=w=C=y=0,v=f<<2,I=N*(z=d[v]),k=N*(A=d[v+1]),S=N*(D=d[v+2]),y+=Q*z,w+=Q*A,C+=Q*D,L=B,m=0;N>m;m++)L.r=z,L.g=A,L.b=D,L=L.next;for(p=o,m=1;i>=m;m++)v=p+f<<2,y+=(L.r=z=d[v])*(E=N-m),w+=(L.g=A=d[v+1])*E,C+=(L.b=D=d[v+2])*E,P+=z,K+=A,j+=D,L=L.next,Z>m&&(p+=o);for(v=f,O=B,T=M,u=0;c>u;u++)b=v<<2,d[b]=y*q>>F,d[b+1]=w*q>>F,d[b+2]=C*q>>F,y-=I,w-=k,C-=S,I-=O.r,k-=O.g,S-=O.b,b=f+((b=u+N)<Z?b:Z)*o<<2,y+=P+=O.r=d[b],w+=K+=O.g=d[b+1],C+=j+=O.b=d[b+2],O=O.next,I+=z=T.r,k+=A=T.g,S+=D=T.b,P-=z,K-=A,j-=D,T=T.next,v+=o}l.putImageData(g,t,r)}}function a(){this.r=0,this.g=0,this.b=0,this.a=0,this.next=null}var r=document.createElement("canvas"),o=!1,c=$(this).selector.replace(/[^a-zA-Z0-9]/g,"");if(r.getContext){e=$.extend({source:"body",radius:5,overlay:"",offset:{x:0,y:0},optClass:"",cache:!1,cacheKeyPrefix:"blurjs-",draggable:!1,debug:!1},e);var n=[512,512,456,512,328,456,335,512,405,328,271,456,388,335,292,512,454,405,364,328,298,271,496,456,420,388,360,335,312,292,273,512,482,454,428,405,383,364,345,328,312,298,284,271,259,496,475,456,437,420,404,388,374,360,347,335,323,312,302,292,282,273,265,512,497,482,468,454,441,428,417,405,394,383,373,364,354,345,337,328,320,312,305,298,291,284,278,271,265,259,507,496,485,475,465,456,446,437,428,420,412,404,396,388,381,374,367,360,354,347,341,335,329,323,318,312,307,302,297,292,287,282,278,273,269,265,261,512,505,497,489,482,475,468,461,454,447,441,435,428,422,417,411,405,399,394,389,383,378,373,368,364,359,354,350,345,341,337,332,328,324,320,316,312,309,305,301,298,294,291,287,284,281,278,274,271,268,265,262,259,257,507,501,496,491,485,480,475,470,465,460,456,451,446,442,437,433,428,424,420,416,412,408,404,400,396,392,388,385,381,377,374,370,367,363,360,357,354,350,347,344,341,338,335,332,329,326,323,320,318,315,312,310,307,304,302,299,297,294,292,289,287,285,282,280,278,275,273,271,269,267,265,263,261,259],s=[9,11,12,13,13,14,14,15,15,15,15,16,16,16,16,17,17,17,17,17,17,17,18,18,18,18,18,18,18,18,18,19,19,19,19,19,19,19,19,19,19,19,19,19,19,20,20,20,20,20,20,20,20,20,20,20,20,20,20,20,20,20,20,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,22,22,22,22,22,22,22,22,22,22,22,22,22,22,22,22,22,22,22,22,22,22,22,22,22,22,22,22,22,22,22,22,22,22,22,22,22,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24];return this.each(function(){var a=$(this),n=$(e.source),s=n.attr("src").replace(/"/g,"").replace(/url\(|\)$/gi,"");ctx=r.getContext("2d"),tempImg=new Image,tempImg.onload=function(){if(o)var i=tempImg.src;else{r.style.display="none",r.width=tempImg.width,r.height=tempImg.height,ctx.drawImage(tempImg,0,0),t(r,0,0,r.width,r.height,e.radius),0!=e.overlay&&(ctx.beginPath(),ctx.rect(0,0,tempImg.width,tempImg.width),ctx.fillStyle=e.overlay,ctx.fill());var i=r.toDataURL();if(e.cache)try{e.debug&&console.log("Cache Set"),localStorage.setItem(e.cacheKeyPrefix+c+"-"+s+"-data-image",i)}catch(l){console.log(l)}}var g=n.css("backgroundAttachment"),h="fixed"==g?"":"-"+(a.offset().left-n.offset().left-e.offset.x)+"px -"+(a.offset().top-n.offset().top-e.offset.y)+"px";a.css({"background-image":'url("'+i+'")',"background-repeat":n.css("backgroundRepeat"),"background-position":h,"background-attachment":g}),0!=e.optClass&&a.addClass(e.optClass),e.draggable&&(a.css({"background-attachment":"fixed","background-position":"0 0"}),a.draggable())},Storage.prototype.cacheChecksum=function(t){var a="";for(var r in t){var o=t[r];a+="[object Object]"==o.toString()?(o.x.toString()+o.y.toString()+",").replace(/[^a-zA-Z0-9]/g,""):(o+",").replace(/[^a-zA-Z0-9]/g,"")}var n=this.getItem(e.cacheKeyPrefix+c+"-"+s+"-options-cache");n!=a&&(this.removeItem(e.cacheKeyPrefix+c+"-"+s+"-options-cache"),this.setItem(e.cacheKeyPrefix+c+"-"+s+"-options-cache",a),e.debug&&console.log("Settings Changed, Cache Emptied"))};var i=null;e.cache&&(localStorage.cacheChecksum(e),i=localStorage.getItem(e.cacheKeyPrefix+c+"-"+s+"-data-image")),null!=i?(e.debug&&console.log("Cache Used"),o=!0,tempImg.src=i):(e.debug&&console.log("Source Used"),tempImg.src=s)})}}}(jQuery);