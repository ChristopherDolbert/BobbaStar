var PromoSlideShow=function(){var b=[];var f=0;var e=false;var a=false;var d=function(g){if(!e&&!a&&f!=g){a=true;Effect.Fade(b[f],{duration:0.8,from:1,to:0});f=g;if(f>=b.length||f<=-1){f=0}Effect.Appear(b[f],{duration:0.8,from:0,to:1,afterFinish:function(){a=false}});c(f)}};var c=function(g){$$("#promo-bullets a").each(function(h){h.removeClassName("active")
});$$("#promo-bullets a")[g].addClassName("active")};return{init:function(){b=$$("#promo-box .promo-container");if(b.length<2){return}if($("promo-bullets")){$("promo-bullets").insert('<a href="#" class="active">0</a>');for(var g=1;g<b.length;g++){$("promo-bullets").insert('<a href="#">'+g+"</a>")}$$("#promo-bullets a").each(function(i){i.observe("click",function(j){Event.stop(j);
e=false;d(parseInt(j.target.innerHTML,10));e=true})})}var h=6000;setInterval(function(){d(f+1)},h)}}}();function recordOutboundLink(c,a){if(typeof(_gaq)=="undefined"||!_gaq){return}var b="Outbound Links";_gaq.push(["_trackEvent",b,c,a])}TWTR=window.TWTR||{};if(!Array.forEach){Array.prototype.filter=function(f,g){var e=g||window;
var b=[];for(var d=0,c=this.length;d<c;++d){if(!f.call(e,this[d],d,this)){continue}b.push(this[d])}return b};Array.prototype.indexOf=function(b,c){var c=c||0;for(var a=0;a<this.length;++a){if(this[a]===b){return a}}return -1}}(function(){if(TWTR&&TWTR.Widget){return}function f(l,o,k){for(var n=0,m=l.length;
n<m;++n){o.call(k||window,l[n],n,l)}}function b(i,k,j){this.el=i;this.prop=k;this.from=j.from;this.to=j.to;this.time=j.time;this.callback=j.callback;this.animDiff=this.to-this.from}b.canTransition=function(){var i=document.createElement("twitter");i.style.cssText="-webkit-transition: all .5s linear;";
return !!i.style.webkitTransitionProperty}();b.prototype._setStyle=function(i){switch(this.prop){case"opacity":this.el.style[this.prop]=i;this.el.style.filter="alpha(opacity="+i*100+")";break;default:this.el.style[this.prop]=i+"px";break}};b.prototype._animate=function(){var i=this;this.now=new Date();
this.diff=this.now-this.startTime;if(this.diff>this.time){this._setStyle(this.to);if(this.callback){this.callback.call(this)}clearInterval(this.timer);return}this.percentage=(Math.floor((this.diff/this.time)*100)/100);this.val=(this.animDiff*this.percentage)+this.from;this._setStyle(this.val)};b.prototype.start=function(){var i=this;
this.startTime=new Date();this.timer=setInterval(function(){i._animate.call(i)},15)};TWTR.Widget=function(i){this.init(i)};(function(){var x={};var u=location.protocol.match(/https/);var w=/^.+\/profile_images/;var C="https://s3.amazonaws.com/twitter_production/profile_images";var D=function(N){return u?N.replace(w,C):N
};var M={};var K=function(O){var N=M[O];if(!N){N=new RegExp("(?:^|\\s+)"+O+"(?:\\s+|$)");M[O]=N}return N};var j=function(R,V,S,T){var V=V||"*";var S=S||document;var O=[],N=S.getElementsByTagName(V),U=K(R);for(var P=0,Q=N.length;P<Q;++P){if(U.test(N[P].className)){O[O.length]=N[P];if(T){T.call(N[P],N[P])
}}}return O};var L=function(){var N=navigator.userAgent;return{ie:N.match(/MSIE\s([^;]*)/)}}();var n=function(N){if(typeof N=="string"){return document.getElementById(N)}return N};var F=function(N){return N.replace(/^\s+|\s+$/g,"")};var B=function(){var N=self.innerHeight;var O=document.compatMode;if((O||L.ie)){N=(O=="CSS1Compat")?document.documentElement.clientHeight:document.body.clientHeight
}return N};var J=function(P,N){var O=P.target||P.srcElement;return N(O)};var z=function(O){try{if(O&&3==O.nodeType){return O.parentNode}else{return O}}catch(N){}};var A=function(O){var N=O.relatedTarget;if(!N){if(O.type=="mouseout"){N=O.toElement}else{if(O.type=="mouseover"){N=O.fromElement}}}return z(N)
};var G=function(O,N){N.parentNode.insertBefore(O,N.nextSibling)};var H=function(O){try{O.parentNode.removeChild(O)}catch(N){}};var E=function(N){return N.firstChild};var i=function(P){var O=A(P);while(O&&O!=this){try{O=O.parentNode}catch(N){O=this}}if(O!=this){return true}return false};var m=function(){if(document.defaultView&&document.defaultView.getComputedStyle){return function(O,R){var Q=null;
var P=document.defaultView.getComputedStyle(O,"");if(P){Q=P[R]}var N=O.style[R]||Q;return N}}else{if(document.documentElement.currentStyle&&L.ie){return function(N,P){var O=N.currentStyle?N.currentStyle[P]:null;return(N.style[P]||O)}}}}();var I={has:function(N,O){return new RegExp("(^|\\s)"+O+"(\\s|$)").test(n(N).className)
},add:function(N,O){if(!this.has(N,O)){n(N).className=F(n(N).className)+" "+O}},remove:function(N,O){if(this.has(N,O)){n(N).className=n(N).className.replace(new RegExp("(^|\\s)"+O+"(\\s|$)","g"),"")}}};var k={add:function(P,O,N){if(P.addEventListener){P.addEventListener(O,N,false)}else{P.attachEvent("on"+O,function(){N.call(P,window.event)
})}},remove:function(P,O,N){if(P.removeEventListener){P.removeEventListener(O,N,false)}else{P.detachEvent("on"+O,N)}}};var t=function(){function O(Q){return parseInt((Q).substring(0,2),16)}function N(Q){return parseInt((Q).substring(2,4),16)}function P(Q){return parseInt((Q).substring(4,6),16)}return function(Q){return[O(Q),N(Q),P(Q)]
}}();var o={bool:function(N){return typeof N==="boolean"},def:function(N){return !(typeof N==="undefined")},number:function(N){return typeof N==="number"&&isFinite(N)},string:function(N){return typeof N==="string"},fn:function(N){return typeof N==="function"},array:function(N){if(N){return o.number(N.length)&&o.fn(N.splice)
}return false}};var s=["January","February","March","April","May","June","July","August","September","October","November","December"];var y=function(Q){var T=new Date(Q);if(L.ie){T=Date.parse(Q.replace(/( \+)/," UTC$1"))}var O="";var N=function(){var U=T.getHours();if(U>0&&U<13){O="am";return U}else{if(U<1){O="am";
return 12}else{O="pm";return U-12}}}();var P=T.getMinutes();var S=T.getSeconds();function R(){var U=new Date();if(U.getDate()!=T.getDate()||U.getYear()!=T.getYear()||U.getMonth()!=T.getMonth()){return" - "+s[T.getMonth()]+" "+T.getDate()+", "+T.getFullYear()}else{return""}}return N+":"+P+O+R()};var q=function(T){var V=new Date();
var R=new Date(T);if(L.ie){R=Date.parse(T.replace(/( \+)/," UTC$1"))}var U=V-R;var O=1000,P=O*60,Q=P*60,S=Q*24,N=S*7;if(isNaN(U)||U<0){return""}if(U<O*2){return"right now"}if(U<P){return Math.floor(U/O)+" seconds ago"}if(U<P*2){return"about 1 minute ago"}if(U<Q){return Math.floor(U/P)+" minutes ago"}if(U<Q*2){return"about 1 hour ago"
}if(U<S){return Math.floor(U/Q)+" hours ago"}if(U>S&&U<S*2){return"yesterday"}if(U<S*365){return Math.floor(U/S)+" days ago"}else{return"over a year ago"}};var l={link:function(N){return N.replace(/\b(((https*\:\/\/)|www\.)[^\"\']+?)(([!?,.\)]+)?(\s|$))/g,function(T,S,Q,P,O){var R=Q.match(/w/)?"http://":"";
return'<a class="twtr-hyperlink" target="_blank" href="'+R+S+'">'+((S.length>25)?S.substr(0,24)+"...":S)+"</a>"+O})},at:function(N){return N.replace(/\B[@� ]([a-zA-Z0-9_]{1,20})/g,function(O,P){return'@<a target="_blank" class="twtr-atreply" href="http://twitter.com/intent/user?screen_name='+P+'">'+P+"</a>"
})},list:function(N){return N.replace(/\B[@� ]([a-zA-Z0-9_]{1,20}\/\w+)/g,function(O,P){return'@<a target="_blank" class="twtr-atreply" href="http://twitter.com/'+P+'">'+P+"</a>"})},hash:function(N){return N.replace(/(^|\s+)#(\w+)/gi,function(O,P,Q){return P+'<a target="_blank" class="twtr-hashtag" href="http://twitter.com/search?q=%23'+Q+'">#'+Q+"</a>"
})},clean:function(N){return this.hash(this.at(this.list(this.link(N))))}};function v(O,P,N){this.job=O;this.decayFn=P;this.interval=N;this.decayRate=1;this.decayMultiplier=1.25;this.maxDecayTime=3*60*1000}v.prototype={start:function(){this.stop().run();return this},stop:function(){if(this.worker){window.clearTimeout(this.worker)
}return this},run:function(){var N=this;this.job(function(){N.decayRate=N.decayFn()?Math.max(1,N.decayRate/N.decayMultiplier):N.decayRate*N.decayMultiplier;var O=N.interval*N.decayRate;O=(O>=N.maxDecayTime)?N.maxDecayTime:O;O=Math.floor(O);N.worker=window.setTimeout(function(){N.run.call(N)},O)})},destroy:function(){this.stop();
this.decayRate=1;return this}};function p(O,N,P){this.time=O||6000;this.loop=N||false;this.repeated=0;this.callback=P;this.haystack=[]}p.prototype={set:function(N){this.haystack=N},add:function(N){this.haystack.unshift(N)},start:function(){if(this.timer){return this}this._job();var N=this;this.timer=setInterval(function(){N._job.call(N)
},this.time);return this},stop:function(){if(this.timer){window.clearInterval(this.timer);this.timer=null}return this},_next:function(){var N=this.haystack.shift();if(N&&this.loop){this.haystack.push(N)}return N||null},_job:function(){var N=this._next();if(N){this.callback(N)}return this}};function r(P){function N(){if(P.needle.metadata&&P.needle.metadata.result_type&&P.needle.metadata.result_type=="popular"){return'<span class="twtr-popular">'+P.needle.metadata.recent_retweets+"+ recent retweets</span>"
}else{return""}}var O='<div class="twtr-tweet-wrap">         <div class="twtr-avatar">           <div class="twtr-img"><a target="_blank" href="http://twitter.com/intent/user?screen_name='+P.user+'"><img alt="'+P.user+' profile" src="'+D(P.avatar)+'"></a></div>         </div>         <div class="twtr-tweet-text">           <p>             <a target="_blank" href="http://twitter.com/intent/user?screen_name='+P.user+'" class="twtr-user">'+P.user+"</a> "+P.tweet+'             <em>            <a target="_blank" class="twtr-timestamp" time="'+P.timestamp+'" href="http://twitter.com/'+P.user+"/status/"+P.id+'">'+P.created_at+'</a> &middot;            <a target="_blank" class="twtr-reply" href="http://twitter.com/intent/tweet?in_reply_to='+P.id+'">reply</a> &middot;             <a target="_blank" class="twtr-rt" href="http://twitter.com/intent/retweet?tweet_id='+P.id+'">retweet</a> &middot;             <a target="_blank" class="twtr-fav" href="http://twitter.com/intent/favorite?tweet_id='+P.id+'">favorite</a>             </em> '+N()+"           </p>         </div>       </div>";
var Q=document.createElement("div");Q.id="tweet-id-"+ ++r._tweetCount;Q.className="twtr-tweet";Q.innerHTML=O;this.element=Q}r._tweetCount=0;x.loadStyleSheet=function(P,O){if(!TWTR.Widget.loadingStyleSheet){TWTR.Widget.loadingStyleSheet=true;var N=document.createElement("link");N.href=P;N.rel="stylesheet";
N.type="text/css";document.getElementsByTagName("head")[0].appendChild(N);var Q=setInterval(function(){var R=m(O,"position");if(R=="relative"){clearInterval(Q);Q=null;TWTR.Widget.hasLoadedStyleSheet=true}},50)}};(function(){var N=false;x.css=function(Q){var P=document.createElement("style");P.type="text/css";
if(L.ie){P.styleSheet.cssText=Q}else{var R=document.createDocumentFragment();R.appendChild(document.createTextNode(Q));P.appendChild(R)}function O(){document.getElementsByTagName("head")[0].appendChild(P)}if(!L.ie||N){O()}else{window.attachEvent("onload",function(){N=true;O()})}}})();TWTR.Widget.isLoaded=false;
TWTR.Widget.loadingStyleSheet=false;TWTR.Widget.hasLoadedStyleSheet=false;TWTR.Widget.WIDGET_NUMBER=0;TWTR.Widget.matches={mentions:/^@[a-zA-Z0-9_]{1,20}\b/,any_mentions:/\b@[a-zA-Z0-9_]{1,20}\b/};TWTR.Widget.jsonP=function(O,Q){var N=document.createElement("script");var P=document.getElementsByTagName("head")[0];
N.type="text/javascript";N.src=O;P.insertBefore(N,P.firstChild);Q(N);return N};TWTR.Widget.prototype=function(){var Q=u?"https://":"http://";var T=window.location.hostname.match(/twitter\.com/)?(window.location.hostname+":"+window.location.port):"twitter.com";var S=Q+"search."+T+"/search.";var U=Q+"api."+T+"/1/statuses/user_timeline.";
var P=Q+T+"/favorites/";var R=Q+"api."+T+"/1/";var O=25000;var N=u?"https://twitter-widgets.s3.amazonaws.com/j/1/default.gif":"http://widgets.twimg.com/j/1/default.gif";return{init:function(W){var V=this;this._widgetNumber=++TWTR.Widget.WIDGET_NUMBER;TWTR.Widget["receiveCallback_"+this._widgetNumber]=function(X){V._prePlay.call(V,X)
};this._cb="TWTR.Widget.receiveCallback_"+this._widgetNumber;this.opts=W;this._base=S;this._isRunning=false;this._hasOfficiallyStarted=false;this._hasNewSearchResults=false;this._rendered=false;this._profileImage=false;this._isCreator=!!W.creator;this._setWidgetType(W.type);this.timesRequested=0;this.runOnce=false;
this.newResults=false;this.results=[];this.jsonMaxRequestTimeOut=19000;this.showedResults=[];this.sinceId=1;this.source="TWITTERINC_WIDGET";this.id=W.id||"twtr-widget-"+this._widgetNumber;this.tweets=0;this.setDimensions(W.width,W.height);this.interval=W.interval||6000;this.format="json";this.rpp=W.rpp||50;
this.subject=W.subject||"";this.title=W.title||"";this.setFooterText(W.footer);this.setSearch(W.search);this._setUrl();this.theme=W.theme?W.theme:this._getDefaultTheme();if(!W.id){document.write('<div class="twtr-widget" id="'+this.id+'"></div>')}this.widgetEl=n(this.id);if(W.id){I.add(this.widgetEl,"twtr-widget")
}if(W.version>=2&&!TWTR.Widget.hasLoadedStyleSheet){if(u){x.loadStyleSheet("https://twitter-widgets.s3.amazonaws.com/j/2/widget.css",this.widgetEl)}else{if(W.creator){x.loadStyleSheet("/stylesheets/widgets/widget.css",this.widgetEl)}else{x.loadStyleSheet("http://widgets.twimg.com/j/2/widget.css",this.widgetEl)
}}}this.occasionalJob=new v(function(X){V.decay=X;V._getResults.call(V)},function(){return V._decayDecider.call(V)},O);this._ready=o.fn(W.ready)?W.ready:function(){};this._isRelativeTime=true;this._tweetFilter=false;this._avatars=true;this._isFullScreen=false;this._isLive=true;this._isScroll=false;this._loop=true;
this._showTopTweets=(this._isSearchWidget)?true:false;this._behavior="default";this.setFeatures(this.opts.features);this.intervalJob=new p(this.interval,this._loop,function(X){V._normalizeTweet(X)});return this},setDimensions:function(V,W){this.wh=(V&&W)?[V,W]:[250,300];if(V=="auto"||V=="100%"){this.wh[0]="100%"
}else{this.wh[0]=((this.wh[0]<150)?150:this.wh[0])+"px"}this.wh[1]=((this.wh[1]<100)?100:this.wh[1])+"px";return this},setRpp:function(V){var V=parseInt(V);this.rpp=(o.number(V)&&(V>0&&V<=100))?V:30;return this},_setWidgetType:function(V){this._isSearchWidget=false;this._isProfileWidget=false;this._isFavsWidget=false;
this._isListWidget=false;switch(V){case"profile":this._isProfileWidget=true;break;case"search":this._isSearchWidget=true;this.search=this.opts.search;break;case"faves":case"favs":this._isFavsWidget=true;break;case"list":case"lists":this._isListWidget=true;break}return this},setFeatures:function(W){if(W){if(o.def(W.filters)){this._tweetFilter=W.filters
}if(o.def(W.dateformat)){this._isRelativeTime=!!(W.dateformat!=="absolute")}if(o.def(W.fullscreen)&&o.bool(W.fullscreen)){if(W.fullscreen){this._isFullScreen=true;this.wh[0]="100%";this.wh[1]=(B()-90)+"px";var X=this;k.add(window,"resize",function(aa){X.wh[1]=B();X._fullScreenResize()})}}if(o.def(W.loop)&&o.bool(W.loop)){this._loop=W.loop
}if(o.def(W.behavior)&&o.string(W.behavior)){switch(W.behavior){case"all":this._behavior="all";break;case"preloaded":this._behavior="preloaded";break;default:this._behavior="default";break}}if(o.def(W.toptweets)&&o.bool(W.toptweets)){this._showTopTweets=W.toptweets;var V=(this._showTopTweets)?"inline-block":"none";
x.css("#"+this.id+" .twtr-popular { display: "+V+"; }")}if(!o.def(W.toptweets)){this._showTopTweets=true;var V=(this._showTopTweets)?"inline-block":"none";x.css("#"+this.id+" .twtr-popular { display: "+V+"; }")}if(o.def(W.avatars)&&o.bool(W.avatars)){if(!W.avatars){x.css("#"+this.id+" .twtr-avatar, #"+this.id+" .twtr-user { display: none; } #"+this.id+" .twtr-tweet-text { margin-left: 0; }");
this._avatars=false}else{var Y=(this._isFullScreen)?"90px":"40px";x.css("#"+this.id+" .twtr-avatar { display: block; } #"+this.id+" .twtr-user { display: inline; } #"+this.id+" .twtr-tweet-text { margin-left: "+Y+"; }");this._avatars=true}}else{if(this._isProfileWidget){this.setFeatures({avatars:false});
this._avatars=false}else{this.setFeatures({avatars:true});this._avatars=true}}if(o.def(W.hashtags)&&o.bool(W.hashtags)){(!W.hashtags)?x.css("#"+this.id+" a.twtr-hashtag { display: none; }"):""}if(o.def(W.timestamp)&&o.bool(W.timestamp)){var Z=W.timestamp?"block":"none";x.css("#"+this.id+" em { display: "+Z+"; }")
}if(o.def(W.live)&&o.bool(W.live)){this._isLive=W.live}if(o.def(W.scrollbar)&&o.bool(W.scrollbar)){this._isScroll=W.scrollbar}}else{if(this._isProfileWidget){this.setFeatures({avatars:false});this._avatars=false}if(this._isProfileWidget||this._isFavsWidget){this.setFeatures({behavior:"all"})}}return this
},_fullScreenResize:function(){var V=j("twtr-timeline","div",document.body,function(W){W.style.height=(B()-90)+"px"})},setTweetInterval:function(V){this.interval=V;return this},setBase:function(V){this._base=V;return this},setUser:function(W,V){this.username=W;this.realname=V||" ";if(this._isFavsWidget){this.setBase(P+W+".")
}else{if(this._isProfileWidget){this.setBase(U+this.format+"?screen_name="+W)}}this.setSearch(" ");return this},setList:function(W,V){this.listslug=V.replace(/ /g,"-").toLowerCase();this.username=W;this.setBase(R+W+"/lists/"+this.listslug+"/statuses.");this.setSearch(" ");return this},setProfileImage:function(V){this._profileImage=V;
this.byClass("twtr-profile-img","img").src=D(V);this.byClass("twtr-profile-img-anchor","a").href="http://twitter.com/intent/user?screen_name="+this.username;return this},setTitle:function(V){this.title=V;this.widgetEl.getElementsByTagName("h3")[0].innerHTML=this.title;return this},setCaption:function(V){this.subject=V;
this.widgetEl.getElementsByTagName("h4")[0].innerHTML=this.subject;return this},setFooterText:function(V){this.footerText=(o.def(V)&&o.string(V))?V:"Join the conversation";if(this._rendered){this.byClass("twtr-join-conv","a").innerHTML=this.footerText}return this},setSearch:function(W){this.searchString=W||"";
this.search=encodeURIComponent(this.searchString);this._setUrl();if(this._rendered){var V=this.byClass("twtr-join-conv","a");V.href="http://twitter.com/"+this._getWidgetPath()}return this},_getWidgetPath:function(){if(this._isProfileWidget){return this.username}else{if(this._isFavsWidget){return this.username+"/favorites"
}else{if(this._isListWidget){return this.username+"/lists/"+this.listslug}else{return"#search?q="+this.search}}}},_setUrl:function(){var W=this;function V(){return"&"+(+new Date)+"=cachebust"}function X(){return(W.sinceId==1)?"":"&since_id="+W.sinceId+"&refresh=true"}if(this._isProfileWidget){this.url=this._base+"&callback="+this._cb+"&include_rts=true&count="+this.rpp+X()+"&clientsource="+this.source
}else{if(this._isFavsWidget||this._isListWidget){this.url=this._base+this.format+"?callback="+this._cb+X()+"&include_rts=true&clientsource="+this.source}else{this.url=this._base+this.format+"?q="+this.search+"&include_rts=true&callback="+this._cb+"&rpp="+this.rpp+X()+"&clientsource="+this.source;if(!this.runOnce){this.url+="&result_type=mixed"
}}}this.url+=V();return this},_getRGB:function(V){return t(V.substring(1,7))},setTheme:function(aa,V){var Y=this;var W=" !important";var Z=((window.location.hostname.match(/twitter\.com/))&&(window.location.pathname.match(/goodies/)));if(V||Z){W=""}this.theme={shell:{background:function(){return aa.shell.background||Y._getDefaultTheme().shell.background
}(),color:function(){return aa.shell.color||Y._getDefaultTheme().shell.color}()},tweets:{background:function(){return aa.tweets.background||Y._getDefaultTheme().tweets.background}(),color:function(){return aa.tweets.color||Y._getDefaultTheme().tweets.color}(),links:function(){return aa.tweets.links||Y._getDefaultTheme().tweets.links
}()}};var X="#"+this.id+" .twtr-doc,                      #"+this.id+" .twtr-hd a,                      #"+this.id+" h3,                      #"+this.id+" h4,                      #"+this.id+" .twtr-popular {            background-color: "+this.theme.shell.background+W+";            color: "+this.theme.shell.color+W+";          }          #"+this.id+" .twtr-popular {            color: "+this.theme.tweets.color+W+";            background-color: rgba("+this._getRGB(this.theme.shell.background)+", .3)"+W+";          }          #"+this.id+" .twtr-tweet a {            color: "+this.theme.tweets.links+W+";          }          #"+this.id+" .twtr-bd, #"+this.id+" .twtr-timeline i a,           #"+this.id+" .twtr-bd p {            color: "+this.theme.tweets.color+W+";          }          #"+this.id+" .twtr-new-results,           #"+this.id+" .twtr-results-inner,           #"+this.id+" .twtr-timeline {            background: "+this.theme.tweets.background+W+";          }";
if(L.ie){X+="#"+this.id+" .twtr-tweet { background: "+this.theme.tweets.background+W+"; }"}x.css(X);return this},byClass:function(Y,V,W){var X=j(Y,V,n(this.id));return(W)?X:X[0]},render:function(){var X=this;if(!TWTR.Widget.hasLoadedStyleSheet){window.setTimeout(function(){X.render.call(X)},50);return this
}this.setTheme(this.theme,this._isCreator);if(this._isProfileWidget){I.add(this.widgetEl,"twtr-widget-profile")}if(this._isScroll){I.add(this.widgetEl,"twtr-scroll")}if(!this._isLive&&!this._isScroll){this.wh[1]="auto"}if(this._isSearchWidget&&this._isFullScreen){document.title="Twitter search: "+escape(this.searchString)
}this.widgetEl.innerHTML=this._getWidgetHtml();var W=this.byClass("twtr-timeline","div");if(this._isLive&&!this._isFullScreen){var Y=function(Z){if(X._behavior==="all"){return}if(i.call(this,Z)){X.pause.call(X)}};var V=function(Z){if(X._behavior==="all"){return}if(i.call(this,Z)){X.resume.call(X)}};this.removeEvents=function(){k.remove(W,"mouseover",Y);
k.remove(W,"mouseout",V)};k.add(W,"mouseover",Y);k.add(W,"mouseout",V)}this._rendered=true;this._ready();return this},removeEvents:function(){},_getDefaultTheme:function(){return{shell:{background:"#8ec1da",color:"#ffffff"},tweets:{background:"#ffffff",color:"#444444",links:"#1985b5"}}},_getWidgetHtml:function(){var X=this;
function Z(){if(X._isProfileWidget){return'<a target="_blank" href="http://twitter.com/" class="twtr-profile-img-anchor"><img alt="profile" class="twtr-profile-img" src="'+N+'"></a>                      <h3></h3>                      <h4></h4>'}else{return"<h3>"+X.title+"</h3><h4>"+X.subject+"</h4>"}}function W(){return X._isFullScreen?" twtr-fullscreen":""
}var Y=u?"https://twitter-widgets.s3.amazonaws.com/i/widget-logo.png":"http://widgets.twimg.com/i/widget-logo.png";if(this._isFullScreen){Y="https://twitter-widgets.s3.amazonaws.com/i/widget-logo-fullscreen.png"}var V='<div class="twtr-doc'+W()+'" style="width: '+this.wh[0]+';">            <div class="twtr-hd">'+Z()+'             </div>            <div class="twtr-bd">              <div class="twtr-timeline" style="height: '+this.wh[1]+';">                <div class="twtr-tweets">                  <div class="twtr-reference-tweet"></div>                  <!-- tweets show here -->                </div>              </div>            </div>            <div class="twtr-ft">              <div><a target="_blank" href="http://twitter.com"><img alt="" src="'+Y+'"></a>                <span><a target="_blank" class="twtr-join-conv" style="color:'+this.theme.shell.color+'" href="http://twitter.com/'+this._getWidgetPath()+'">'+this.footerText+"</a></span>              </div>            </div>          </div>";
return V},_appendTweet:function(V){this._insertNewResultsNumber();G(V,this.byClass("twtr-reference-tweet","div"));return this},_slide:function(W){var X=this;var V=E(W).offsetHeight;if(this.runOnce){new b(W,"height",{from:0,to:V,time:500,callback:function(){X._fade.call(X,W)}}).start()}return this},_fade:function(V){var W=this;
if(b.canTransition){V.style.webkitTransition="opacity 0.5s ease-out";V.style.opacity=1;return this}new b(V,"opacity",{from:0,to:1,time:500}).start();return this},_chop:function(){if(this._isScroll){return this}var aa=this.byClass("twtr-tweet","div",true);var ab=this.byClass("twtr-new-results","div",true);
if(aa.length){for(var X=aa.length-1;X>=0;X--){var Z=aa[X];var Y=parseInt(Z.offsetTop);if(Y>parseInt(this.wh[1])){H(Z)}else{break}}if(ab.length>0){var V=ab[ab.length-1];var W=parseInt(V.offsetTop);if(W>parseInt(this.wh[1])){H(V)}}}return this},_appendSlideFade:function(W){var V=W||this.tweet.element;this._chop()._appendTweet(V)._slide(V);
return this},_createTweet:function(V){V.timestamp=V.created_at;V.created_at=this._isRelativeTime?q(V.created_at):y(V.created_at);this.tweet=new r(V);if(this._isLive&&this.runOnce){this.tweet.element.style.opacity=0;this.tweet.element.style.filter="alpha(opacity:0)";this.tweet.element.style.height="0"
}return this},_getResults:function(){var V=this;this.timesRequested++;this.jsonRequestRunning=true;this.jsonRequestTimer=window.setTimeout(function(){if(V.jsonRequestRunning){clearTimeout(V.jsonRequestTimer);V.jsonRequestTimer=null}V.jsonRequestRunning=false;H(V.scriptElement);V.newResults=false;V.decay()
},this.jsonMaxRequestTimeOut);TWTR.Widget.jsonP(V.url,function(W){V.scriptElement=W})},clear:function(){var W=this.byClass("twtr-tweet","div",true);var V=this.byClass("twtr-new-results","div",true);W=W.concat(V);f(W,function(X){H(X)});return this},_sortByMagic:function(V){var W=this;if(this._tweetFilter){if(this._tweetFilter.negatives){V=V.filter(function(X){if(!W._tweetFilter.negatives.test(X.text)){return X
}})}if(this._tweetFilter.positives){V=V.filter(function(X){if(W._tweetFilter.positives.test(X.text)){return X}})}}switch(this._behavior){case"all":this._sortByLatest(V);break;case"preloaded":default:this._sortByDefault(V);break}if(this._isLive&&this._behavior!=="all"){this.intervalJob.set(this.results);
this.intervalJob.start()}return this},_loadTopTweetsAtTop:function(X){var Y=[],Z=[],W=[];f(X,function(aa){if(aa.metadata&&aa.metadata.result_type&&aa.metadata.result_type=="popular"){Z.push(aa)}else{Y.push(aa)}});var V=Z.concat(Y);return V},_sortByLatest:function(V){this.results=V;this.results=this.results.slice(0,this.rpp);
this.results=this._loadTopTweetsAtTop(this.results);this.results.reverse();return this},_sortByDefault:function(W){var X=this;var V=function(Z){return new Date(Z).getTime()};this.results.unshift.apply(this.results,W);f(this.results,function(Z){if(!Z.views){Z.views=0}});this.results.sort(function(aa,Z){if(V(aa.created_at)>V(Z.created_at)){return -1
}else{if(V(aa.created_at)<V(Z.created_at)){return 1}else{return 0}}});this.results=this.results.slice(0,this.rpp);this.results=this._loadTopTweetsAtTop(this.results);var Y=this.results;this.results=this.results.sort(function(aa,Z){if(aa.views<Z.views){return -1}else{if(aa.views>Z.views){return 1}}return 0
});if(!this._isLive){this.results.reverse()}},_prePlay:function(W){if(this.jsonRequestTimer){clearTimeout(this.jsonRequestTimer);this.jsonRequestTimer=null}if(!L.ie){H(this.scriptElement)}if(W.error){this.newResults=false}else{if(W.results&&W.results.length>0){this.response=W;this.newResults=true;this.sinceId=W.max_id_str;
this._sortByMagic(W.results);if(this.isRunning()){this._play()}}else{if((this._isProfileWidget||this._isFavsWidget||this._isListWidget)&&o.array(W)&&W.length){this.newResults=true;if(!this._profileImage&&this._isProfileWidget){var V=W[0].user.screen_name;this.setProfileImage(W[0].user.profile_image_url);
this.setTitle(W[0].user.name);this.setCaption('<a target="_blank" href="http://twitter.com/intent/user?screen_name='+V+'">'+V+"</a>")}this.sinceId=W[0].id_str;this._sortByMagic(W);if(this.isRunning()){this._play()}}else{this.newResults=false}}}this._setUrl();if(this._isLive){this.decay()}},_play:function(){var V=this;
if(this.runOnce){this._hasNewSearchResults=true}if(this._avatars){this._preloadImages(this.results)}if(this._isRelativeTime&&(this._behavior=="all"||this._behavior=="preloaded")){f(this.byClass("twtr-timestamp","a",true),function(W){W.innerHTML=q(W.getAttribute("time"))})}if(!this._isLive||this._behavior=="all"||this._behavior=="preloaded"){f(this.results,function(X){if(X.retweeted_status){X=X.retweeted_status
}if(V._isProfileWidget){X.from_user=X.user.screen_name;X.profile_image_url=X.user.profile_image_url}if(V._isFavsWidget||V._isListWidget){X.from_user=X.user.screen_name;X.profile_image_url=X.user.profile_image_url}X.id=X.id_str;V._createTweet({id:X.id,user:X.from_user,tweet:l.clean(X.text),avatar:X.profile_image_url,created_at:X.created_at,needle:X});
var W=V.tweet.element;(V._behavior=="all")?V._appendSlideFade(W):V._appendTweet(W)});if(this._behavior!="preloaded"){return this}}return this},_normalizeTweet:function(W){var V=this;W.views++;if(this._isProfileWidget){W.from_user=V.username;W.profile_image_url=W.user.profile_image_url}if(this._isFavsWidget||this._isListWidget){W.from_user=W.user.screen_name;
W.profile_image_url=W.user.profile_image_url}if(this._isFullScreen){W.profile_image_url=W.profile_image_url.replace(/_normal\./,"_bigger.")}W.id=W.id_str;this._createTweet({id:W.id,user:W.from_user,tweet:l.clean(W.text),avatar:W.profile_image_url,created_at:W.created_at,needle:W})._appendSlideFade()},_insertNewResultsNumber:function(){if(!this._hasNewSearchResults){this._hasNewSearchResults=false;
return}if(this.runOnce&&this._isSearchWidget){var Y=this.response.total>this.rpp?this.response.total:this.response.results.length;var V=Y>1?"s":"";var X=(this.response.warning&&this.response.warning.match(/adjusted since_id/))?"more than":"";var W=document.createElement("div");I.add(W,"twtr-new-results");
W.innerHTML='<div class="twtr-results-inner"> &nbsp; </div><div class="twtr-results-hr"> &nbsp; </div><span>'+X+" <strong>"+Y+"</strong> new tweet"+V+"</span>";G(W,this.byClass("twtr-reference-tweet","div"));this._hasNewSearchResults=false}},_preloadImages:function(V){if(this._isProfileWidget||this._isFavsWidget||this._isListWidget){f(V,function(X){var W=new Image();
W.src=D(X.user.profile_image_url)})}else{f(V,function(W){(new Image()).src=D(W.profile_image_url)})}},_decayDecider:function(){var V=false;if(!this.runOnce){this.runOnce=true;V=true}else{if(this.newResults){V=true}}return V},start:function(){var V=this;if(!this._rendered){setTimeout(function(){V.start.call(V)
},50);return this}if(!this._isLive){this._getResults()}else{this.occasionalJob.start()}this._isRunning=true;this._hasOfficiallyStarted=true;return this},stop:function(){this.occasionalJob.stop();if(this.intervalJob){this.intervalJob.stop()}this._isRunning=false;return this},pause:function(){if(this.isRunning()&&this.intervalJob){this.intervalJob.stop();
I.add(this.widgetEl,"twtr-paused");this._isRunning=false}if(this._resumeTimer){clearTimeout(this._resumeTimer);this._resumeTimer=null}return this},resume:function(){var V=this;if(!this.isRunning()&&this._hasOfficiallyStarted&&this.intervalJob){this._resumeTimer=window.setTimeout(function(){V.intervalJob.start();
V._isRunning=true;I.remove(V.widgetEl,"twtr-paused")},2000)}return this},isRunning:function(){return this._isRunning},destroy:function(){this.stop();this.clear();this.runOnce=false;this._hasOfficiallyStarted=false;this._profileImage=false;this._isLive=true;this._tweetFilter=false;this._isScroll=false;
this.newResults=false;this._isRunning=false;this.sinceId=1;this.results=[];this.showedResults=[];this.occasionalJob.destroy();if(this.jsonRequestRunning){clearTimeout(this.jsonRequestTimer)}I.remove(this.widgetEl,"twtr-scroll");this.removeEvents();return this}}}()})();var e=/twitter\.com(\:\d{2,4})?\/intent\/(\w+)/,h={tweet:true,retweet:true,favorite:true},g="scrollbars=yes,resizable=yes,toolbar=no,location=yes",d=screen.height,c=screen.width;
function a(p){p=p||window.event;var o=p.target||p.srcElement,j,k,i,n,l;while(o&&o.nodeName.toLowerCase()!=="a"){o=o.parentNode}if(o&&o.nodeName.toLowerCase()==="a"&&o.href){j=o.href.match(e);if(j){k=550;i=(j[2] in h)?420:560;n=Math.round((c/2)-(k/2));l=0;if(d>i){l=Math.round((d/2)-(i/2))}window.open(o.href,"intent",g+",width="+k+",height="+i+",left="+n+",top="+l);
p.returnValue=false;p.preventDefault&&p.preventDefault()}}}if(document.addEventListener){document.addEventListener("click",a,false)}else{if(document.attachEvent){document.attachEvent("onclick",a)}}})();