!function($){$.fn.blurjs=function(e){function t(e,t,r,c,o,s){if(!(isNaN(s)||s<1)){s|=0;var i=e.getContext("2d"),l;try{try{l=i.getImageData(t,r,c,o)}catch(e){try{netscape.security.PrivilegeManager.enablePrivilege("UniversalBrowserRead"),l=i.getImageData(t,r,c,o)}catch(e){throw new Error("unable to access local image data: "+e)}}}catch(e){throw new Error("unable to access image data: "+e)}var h=l.data,f,d,m,u,b,p,x,v,y,I,w,C,k,S,P,K,j,A,D,E,U=s+s+1,z=c<<2,R=c-1,Z=o-1,N=s+1,B=N*(N+1)/2,L=new a,M=L;for(m=1;m<U;m++)if(M=M.next=new a,m==N)var O=M;M.next=L;var Q=null,q=null;x=p=0;var F=g[s],G=n[s];for(d=0;d<o;d++){for(S=P=K=v=y=I=0,w=N*(j=h[p]),C=N*(A=h[p+1]),k=N*(D=h[p+2]),v+=B*j,y+=B*A,I+=B*D,M=L,m=0;m<N;m++)M.r=j,M.g=A,M.b=D,M=M.next;for(m=1;m<N;m++)u=p+((R<m?R:m)<<2),v+=(M.r=j=h[u])*(E=N-m),y+=(M.g=A=h[u+1])*E,I+=(M.b=D=h[u+2])*E,S+=j,P+=A,K+=D,M=M.next;for(Q=L,q=O,f=0;f<c;f++)h[p]=v*F>>G,h[p+1]=y*F>>G,h[p+2]=I*F>>G,v-=w,y-=C,I-=k,w-=Q.r,C-=Q.g,k-=Q.b,u=x+((u=f+s+1)<R?u:R)<<2,S+=Q.r=h[u],P+=Q.g=h[u+1],K+=Q.b=h[u+2],v+=S,y+=P,I+=K,Q=Q.next,w+=j=q.r,C+=A=q.g,k+=D=q.b,S-=j,P-=A,K-=D,q=q.next,p+=4;x+=c}for(f=0;f<c;f++){for(P=K=S=y=I=v=0,p=f<<2,w=N*(j=h[p]),C=N*(A=h[p+1]),k=N*(D=h[p+2]),v+=B*j,y+=B*A,I+=B*D,M=L,m=0;m<N;m++)M.r=j,M.g=A,M.b=D,M=M.next;for(b=c,m=1;m<=s;m++)p=b+f<<2,v+=(M.r=j=h[p])*(E=N-m),y+=(M.g=A=h[p+1])*E,I+=(M.b=D=h[p+2])*E,S+=j,P+=A,K+=D,M=M.next,m<Z&&(b+=c);for(p=f,Q=L,q=O,d=0;d<o;d++)u=p<<2,h[u]=v*F>>G,h[u+1]=y*F>>G,h[u+2]=I*F>>G,v-=w,y-=C,I-=k,w-=Q.r,C-=Q.g,k-=Q.b,u=f+((u=d+N)<Z?u:Z)*c<<2,v+=S+=Q.r=h[u],y+=P+=Q.g=h[u+1],I+=K+=Q.b=h[u+2],Q=Q.next,w+=j=q.r,C+=A=q.g,k+=D=q.b,S-=j,P-=A,K-=D,q=q.next,p+=c}i.putImageData(l,t,r)}}function a(){this.r=0,this.g=0,this.b=0,this.a=0,this.next=null}var r=document.createElement("canvas"),c=!1,o=$(this).selector.replace(/[^a-zA-Z0-9]/g,"");if(r.getContext){e=$.extend({source:"body",radius:5,overlay:"",offset:{x:0,y:0},optClass:"",cache:!1,cacheKeyPrefix:"blurjs-",draggable:!1,debug:!1},e);var g=[512,512,456,512,328,456,335,512,405,328,271,456,388,335,292,512,454,405,364,328,298,271,496,456,420,388,360,335,312,292,273,512,482,454,428,405,383,364,345,328,312,298,284,271,259,496,475,456,437,420,404,388,374,360,347,335,323,312,302,292,282,273,265,512,497,482,468,454,441,428,417,405,394,383,373,364,354,345,337,328,320,312,305,298,291,284,278,271,265,259,507,496,485,475,465,456,446,437,428,420,412,404,396,388,381,374,367,360,354,347,341,335,329,323,318,312,307,302,297,292,287,282,278,273,269,265,261,512,505,497,489,482,475,468,461,454,447,441,435,428,422,417,411,405,399,394,389,383,378,373,368,364,359,354,350,345,341,337,332,328,324,320,316,312,309,305,301,298,294,291,287,284,281,278,274,271,268,265,262,259,257,507,501,496,491,485,480,475,470,465,460,456,451,446,442,437,433,428,424,420,416,412,408,404,400,396,392,388,385,381,377,374,370,367,363,360,357,354,350,347,344,341,338,335,332,329,326,323,320,318,315,312,310,307,304,302,299,297,294,292,289,287,285,282,280,278,275,273,271,269,267,265,263,261,259],n=[9,11,12,13,13,14,14,15,15,15,15,16,16,16,16,17,17,17,17,17,17,17,18,18,18,18,18,18,18,18,18,19,19,19,19,19,19,19,19,19,19,19,19,19,19,20,20,20,20,20,20,20,20,20,20,20,20,20,20,20,20,20,20,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,22,22,22,22,22,22,22,22,22,22,22,22,22,22,22,22,22,22,22,22,22,22,22,22,22,22,22,22,22,22,22,22,22,22,22,22,22,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,23,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24];return this.each(function(){var a=$(this),g=$(e.source),n=g.css("backgroundImage").replace(/"/g,"").replace(/url\(|\)$/gi,"");ctx=r.getContext("2d"),tempImg=new Image,tempImg.onload=function(){if(c)var s=tempImg.src;else{r.style.display="none",r.width=tempImg.width,r.height=tempImg.height,ctx.drawImage(tempImg,0,0),t(r,0,0,r.width,r.height,e.radius),0!=e.overlay&&(ctx.beginPath(),ctx.rect(0,0,tempImg.width,tempImg.width),ctx.fillStyle=e.overlay,ctx.fill());var s=r.toDataURL();if(e.cache)try{e.debug&&console.log("Cache Set"),localStorage.setItem(e.cacheKeyPrefix+o+"-"+n+"-data-image",s)}catch(e){console.log(e)}}var i=g.css("backgroundAttachment"),l="fixed"==i?"":"-"+(a.offset().left-g.offset().left-e.offset.x)+"px -"+(a.offset().top-g.offset().top-e.offset.y)+"px";a.css({"background-image":'url("'+s+'")',"background-repeat":g.css("backgroundRepeat"),"background-position":l,"background-attachment":i}),0!=e.optClass&&a.addClass(e.optClass),e.draggable&&(a.css({"background-attachment":"fixed","background-position":"0 0"}),a.draggable())},Storage.prototype.cacheChecksum=function(t){var a="";for(var r in t){var c=t[r];"[object Object]"==c.toString()?a+=(c.x.toString()+c.y.toString()+",").replace(/[^a-zA-Z0-9]/g,""):a+=(c+",").replace(/[^a-zA-Z0-9]/g,"")}this.getItem(e.cacheKeyPrefix+o+"-"+n+"-options-cache")!=a&&(this.removeItem(e.cacheKeyPrefix+o+"-"+n+"-options-cache"),this.setItem(e.cacheKeyPrefix+o+"-"+n+"-options-cache",a),e.debug&&console.log("Settings Changed, Cache Emptied"))};var s=null;e.cache&&(localStorage.cacheChecksum(e),s=localStorage.getItem(e.cacheKeyPrefix+o+"-"+n+"-data-image")),null!=s?(e.debug&&console.log("Cache Used"),c=!0,tempImg.src=s):(e.debug&&console.log("Source Used"),tempImg.src=n)})}}}(jQuery);