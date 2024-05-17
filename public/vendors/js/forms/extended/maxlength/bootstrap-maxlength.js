!function(t){"use strict";t.event.special.destroyed||(t.event.special.destroyed={remove:function(t){t.handler&&t.handler()}}),t.fn.extend({maxlength:function(e,a){var n=t("body");function o(t){var e=t.charCodeAt();return e?e<128?1:e<2048?2:3:0}function s(t){return t.split("").map(o).concat(0).reduce(function(t,e){return t+e})}function r(t){var a=t.val();return a=e.twoCharLinebreak?a.replace(/\r(?!\n)|\n(?!\r)/g,"\r\n"):a.replace(new RegExp("\r?\n","g"),"\n"),e.utf8?s(a):a.length}function i(t,e){return e-r(t)}function l(t,e){e.css({display:"block"}),t.trigger("maxlength.shown")}function c(t,a,n){var o="";return e.message?o="function"==typeof e.message?e.message(t,a):e.message.replace("%charsTyped%",n).replace("%charsRemaining%",a-n).replace("%charsTotal%",a):(e.preText&&(o+=e.preText),e.showCharsTyped?o+=n:o+=a-n,e.showMaxLength&&(o+=e.separator+a),e.postText&&(o+=e.postText)),o}function p(t,a,n,o){var s,i,p,h;o&&(o.html(c(a.val(),n,n-t)),t>0?(s=a,i=e.threshold,p=n,h=!0,!e.alwaysShow&&p-r(s)>i&&(h=!1),h?l(a,o.removeClass(e.limitReachedClass).addClass(e.warningClass)):function(t,a){e.alwaysShow||(a.css({display:"none"}),t.trigger("maxlength.hidden"))}(a,o)):l(a,o.removeClass(e.warningClass).addClass(e.limitReachedClass))),e.customMaxAttribute&&(t<0?a.addClass("overmax"):a.removeClass("overmax"))}function h(a,n){var o=function(e){var a=e[0];return t.extend({},"function"==typeof a.getBoundingClientRect?a.getBoundingClientRect():{width:a.offsetWidth,height:a.offsetHeight},e.offset())}(a);if("function"!==t.type(e.placement))if(t.isPlainObject(e.placement))!function(a,n){if(a&&n){var o={};t.each(["top","bottom","left","right","position"],function(t,a){var n=e.placement[a];void 0!==n&&(o[a]=n)}),n.css(o)}}(e.placement,n);else{var s=a.outerWidth(),r=n.outerWidth(),i=n.width(),l=n.height();switch(e.appendToParent&&(o.top-=a.parent().offset().top,o.left-=a.parent().offset().left),e.placement){case"bottom":n.css({top:o.top+o.height,left:o.left+o.width/2-i/2});break;case"top":n.css({top:o.top-l,left:o.left+o.width/2-i/2});break;case"left":n.css({top:o.top+o.height/2-l/2,left:o.left-i});break;case"right":n.css({top:o.top+o.height/2-l/2,left:o.left+o.width});break;case"bottom-right":n.css({top:o.top+o.height,left:o.left+o.width});break;case"top-right":n.css({top:o.top-l,left:o.left+s});break;case"top-left":n.css({top:o.top-l,left:o.left-r});break;case"bottom-left":n.css({top:o.top+a.outerHeight(),left:o.left-r});break;case"centered-right":n.css({top:o.top+l/2,left:o.left+s-r-3});break;case"bottom-right-inside":n.css({top:o.top+o.height,left:o.left+o.width-r});break;case"top-right-inside":n.css({top:o.top-l,left:o.left+s-r});break;case"top-left-inside":n.css({top:o.top-l,left:o.left});break;case"bottom-left-inside":n.css({top:o.top+a.outerHeight(),left:o.left})}}else e.placement(a,n,o)}function f(t){var a=t.attr("maxlength")||e.customMaxAttribute;if(e.customMaxAttribute&&!e.allowOverMax){var n=t.attr(e.customMaxAttribute);(!a||n<a)&&(a=n)}return a||(a=t.attr("size")),a}return t.isFunction(e)&&!a&&(a=e,e={}),e=t.extend({showOnReady:!1,alwaysShow:!1,threshold:10,warningClass:"label label-success",limitReachedClass:"label label-important label-danger",separator:" / ",preText:"",postText:"",showMaxLength:!0,placement:"bottom",message:null,showCharsTyped:!0,validate:!1,utf8:!1,appendToParent:!1,twoCharLinebreak:!0,customMaxAttribute:null,allowOverMax:!1},e),this.each(function(){var a,r,l=t(this);function u(){var o=c(l.val(),a,"0");a=f(l),r||(r=t('<span class="bootstrap-maxlength"></span>').css({display:"none",position:"absolute",whiteSpace:"nowrap",zIndex:1099}).html(o)),l.is("textarea")&&(l.data("maxlenghtsizex",l.outerWidth()),l.data("maxlenghtsizey",l.outerHeight()),l.mouseup(function(){l.outerWidth()===l.data("maxlenghtsizex")&&l.outerHeight()===l.data("maxlenghtsizey")||h(l,r),l.data("maxlenghtsizex",l.outerWidth()),l.data("maxlenghtsizey",l.outerHeight())})),e.appendToParent?(l.parent().append(r),l.parent().css("position","relative")):n.append(r),p(i(l,f(l)),l,a,r),h(l,r)}t(window).resize(function(){r&&h(l,r)}),e.showOnReady?l.ready(function(){u()}):l.focus(function(){u()}),l.on("maxlength.reposition",function(){h(l,r)}),l.on("destroyed",function(){r&&r.remove()}),l.on("blur",function(){r&&!e.showOnReady&&r.remove()}),l.on("input",function(){var t=f(l),n=i(l,t),c=!0;return e.validate&&n<0?(function(t,a){var n=t.val();if(e.twoCharLinebreak&&"\n"===(n=n.replace(/\r(?!\n)|\n(?!\r)/g,"\r\n"))[n.length-1]&&(a-=n.length%2),e.utf8){for(var r=n.split("").map(o),i=0,l=s(n)-a;i<l;i+=r.pop());a-=a-r.length}t.val(n.substr(0,a))}(l,t),c=!1):p(n,l,a,r),("bottom-right-inside"===e.placement||"top-right-inside"===e.placement||"function"==typeof e.placement||e.message&&"function"==typeof e.message)&&h(l,r),c})})}})}(jQuery);