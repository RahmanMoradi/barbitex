!function(e){var a={};function t(n){if(a[n])return a[n].exports;var s=a[n]={i:n,l:!1,exports:{}};return e[n].call(s.exports,s,s.exports,t),s.l=!0,s.exports}t.m=e,t.c=a,t.d=function(e,a,n){t.o(e,a)||Object.defineProperty(e,a,{enumerable:!0,get:n})},t.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},t.t=function(e,a){if(1&a&&(e=t(e)),8&a)return e;if(4&a&&"object"==typeof e&&e&&e.__esModule)return e;var n=Object.create(null);if(t.r(n),Object.defineProperty(n,"default",{enumerable:!0,value:e}),2&a&&"string"!=typeof e)for(var s in e)t.d(n,s,function(a){return e[a]}.bind(null,s));return n},t.n=function(e){var a=e&&e.__esModule?function(){return e.default}:function(){return e};return t.d(a,"a",a),a},t.o=function(e,a){return Object.prototype.hasOwnProperty.call(e,a)},t.p="/",t(t.s=72)}({72:function(e,a,t){e.exports=t(73)},73:function(e,a){!function(e,a,t){"use strict";var n=t("html"),s=t("body");if(t(e).on("load",(function(){var e=!1;s.hasClass("menu-collapsed")&&(e=!0),t("html").data("textdirection"),setTimeout((function(){n.removeClass("loading").addClass("loaded")}),1200),t.app.menu.init(e);!1===t.app.nav.initialized&&t.app.nav.init({speed:300}),Unison.on("change",(function(e){t.app.menu.change()})),t('[data-toggle="tooltip"]').tooltip({container:"body"}),t(".navbar-hide-on-scroll").length>0&&(t(".navbar-hide-on-scroll.fixed-top").headroom({offset:205,tolerance:5,classes:{initial:"headroom",pinned:"headroom--pinned-top",unpinned:"headroom--unpinned-top"}}),t(".navbar-hide-on-scroll.fixed-bottom").headroom({offset:205,tolerance:5,classes:{initial:"headroom",pinned:"headroom--pinned-bottom",unpinned:"headroom--unpinned-bottom"}})),t('a[data-action="collapse"]').on("click",(function(e){e.preventDefault(),t(this).closest(".card").children(".card-content").collapse("toggle"),t(this).closest(".card").children(".card-header").css("padding-bottom","1.5rem"),t(this).closest(".card").find('[data-action="collapse"]').toggleClass("rotate")})),t('a[data-action="expand"]').on("click",(function(e){e.preventDefault(),t(this).closest(".card").find('[data-action="expand"] i').toggleClass("icon-maximize icon-minimize"),t(this).closest(".card").toggleClass("card-fullscreen")})),t(".scrollable-container").each((function(){new PerfectScrollbar(t(this)[0],{wheelPropagation:!1})})),t('a[data-action="reload"]').on("click",(function(){var e=t(this).closest(".card").find(".card-content");if(s.hasClass("dark-layout"))var a="#10163a";else a="#fff";e.block({message:'<div class="feather icon-refresh-cw icon-spin font-medium-2 text-primary"></div>',timeout:2e3,overlayCSS:{backgroundColor:a,cursor:"wait"},css:{border:0,padding:0,backgroundColor:"none"}})})),t('a[data-action="close"]').on("click",(function(){t(this).closest(".card").removeClass().slideUp("fast")})),setTimeout((function(){t(".row.match-height").each((function(){t(this).find(".card").not(".card .card").matchHeight()}))}),500),t('.card .heading-elements a[data-action="collapse"]').on("click",(function(){var e,a=t(this).closest(".card");parseInt(a[0].style.height,10)>0?(e=a.css("height"),a.css("height","").attr("data-height",e)):a.data("height")&&(e=a.data("height"),a.css("height",e).attr("data-height",""))})),t(".main-menu-content").find("li.active").parents("li").addClass("sidebar-group-active");var i=s.data("menu");"horizontal-menu"!=i&&!1===e&&t(".main-menu-content").find("li.active").parents("li").addClass("open"),"horizontal-menu"==i&&(t(".main-menu-content").find("li.active").parents("li:not(.nav-item)").addClass("open"),t(".main-menu-content").find("li.active").parents("li").addClass("active")),t(".heading-elements-toggle").on("click",(function(){t(this).next(".heading-elements").toggleClass("visible")}));var o=t(".chartjs"),r=o.children("canvas").attr("height");if(o.css("height",r),s.hasClass("boxed-layout")&&s.hasClass("vertical-overlay-menu")){var l=t(".main-menu").width(),c=t(".app-content").position().left-l;s.hasClass("menu-flipped")?t(".main-menu").css("right",c+"px"):t(".main-menu").css("left",c+"px")}t(".custom-file input").change((function(e){t(this).next(".custom-file-label").html(e.target.files[0].name)})),t(".char-textarea").on("keyup",(function(e){!function(e,a){var n=parseInt(t(e).data("length"));(function(e){return 8==e.keyCode||46==e.keyCode||37==e.keyCode||38==e.keyCode||39==e.keyCode||40==e.keyCode})(a)||e.value.length<n-1&&(e.value=e.value.substring(0,n));t(".char-count").html(e.value.length),e.value.length>n?(t(".counter-value").css("background-color","#ea5455"),t(".char-textarea").css("color","#ea5455"),t(".char-textarea").addClass("max-limit")):(t(".counter-value").css("background-color","#7367f0"),t(".char-textarea").css("color","#4e5154"),t(".char-textarea").removeClass("max-limit"))}(this,e),t(this).addClass("active")})),t(".content-overlay").on("click",(function(){t(".search-list").removeClass("show"),t(".app-content").removeClass("show-overlay"),t(".bookmark-wrapper .bookmark-input").removeClass("show")}));var u=a.getElementsByClassName("main-menu-content");u.length>0&&u[0].addEventListener("ps-scroll-y",(function(){t(this).find(".ps__thumb-y").position().top>0?t(".shadow-bottom").css("display","block"):t(".shadow-bottom").css("display","none")}))})),t(a).on("click",".sidenav-overlay",(function(e){return t.app.menu.hide(),!1})),"undefined"!=typeof Hammer){var i=a.querySelector(".drag-target");if(t(i).length>0)new Hammer(i).on("panright",(function(e){if(s.hasClass("vertical-overlay-menu"))return t.app.menu.open(),!1}));setTimeout((function(){var e,n=a.querySelector(".main-menu");t(n).length>0&&((e=new Hammer(n)).get("pan").set({direction:Hammer.DIRECTION_ALL,threshold:100}),e.on("panleft",(function(e){if(s.hasClass("vertical-overlay-menu"))return t.app.menu.hide(),!1})))}),300);var o=a.querySelector(".sidenav-overlay");if(t(o).length>0)new Hammer(o).on("panleft",(function(e){if(s.hasClass("vertical-overlay-menu"))return t.app.menu.hide(),!1}))}t(a).on("click",".menu-toggle, .modern-nav-toggle",(function(a){return a.preventDefault(),t.app.menu.toggle(),setTimeout((function(){t(e).trigger("resize")}),200),t("#collapse-sidebar-switch").length>0&&setTimeout((function(){s.hasClass("menu-expanded")||s.hasClass("menu-open")?t("#collapse-sidebar-switch").prop("checked",!1):t("#collapse-sidebar-switch").prop("checked",!0)}),50),t(".vertical-overlay-menu .navbar-with-menu .navbar-container .navbar-collapse").hasClass("show")&&t(".vertical-overlay-menu .navbar-with-menu .navbar-container .navbar-collapse").removeClass("show"),!1})),t(".navigation").find("li").has("ul").addClass("has-sub"),t(".carousel").carousel({interval:2e3}),t(".nav-link-expand").on("click",(function(e){"undefined"!=typeof screenfull&&screenfull.isEnabled&&screenfull.toggle()})),"undefined"!=typeof screenfull&&screenfull.isEnabled&&t(a).on(screenfull.raw.fullscreenchange,(function(){screenfull.isFullscreen?(t(".nav-link-expand").find("i").toggleClass("icon-minimize icon-maximize"),t("html").addClass("full-screen")):(t(".nav-link-expand").find("i").toggleClass("icon-maximize icon-minimize"),t("html").removeClass("full-screen"))})),t(a).ready((function(){t(".step-icon").each((function(){var e=t(this);e.siblings("span.step").length>0&&(e.siblings("span.step").empty(),t(this).appendTo(t(this).siblings("span.step")))}))})),t(e).resize((function(){t.app.menu.manualScroller.updateHeight()})),t("#sidebar-page-navigation").on("click","a.nav-link",(function(e){e.preventDefault(),e.stopPropagation();var a=t(this),n=a.attr("href"),s=t(n).offset().top-80;t("html, body").animate({scrollTop:s},0),setTimeout((function(){a.parent(".nav-item").siblings(".nav-item").children(".nav-link").removeClass("active"),a.addClass("active")}),100)})),i18next.use(e.i18nextXHRBackend).init({debug:!1,fallbackLng:"en",backend:{loadPath:"data/locales/{{lng}}.json"},returnObjects:!0},(function(e,a){jqueryI18next.init(i18next,t)})),t(".dropdown-language .dropdown-item").on("click",(function(){var e=t(this);e.siblings(".selected").removeClass("selected"),e.addClass("selected");var a=e.text(),n=e.find(".flag-icon").attr("class");t("#dropdown-flag .selected-language").text(a),t("#dropdown-flag .flag-icon").removeClass().addClass(n);var s=e.data("language");i18next.changeLanguage(s,(function(e,a){t(".main-menu, .horizontal-menu-wrapper").localize()}))}));var r=t(".search-input input").data("search");t(".bookmark-wrapper .bookmark-star").on("click",(function(e){e.stopPropagation(),t(".bookmark-wrapper .bookmark-input").toggleClass("show"),t(".bookmark-wrapper .bookmark-input input").val(""),t(".bookmark-wrapper .bookmark-input input").blur(),t(".bookmark-wrapper .bookmark-input input").focus(),t(".bookmark-wrapper .search-list").addClass("show");var a=t("ul.nav.navbar-nav.bookmark-icons li"),n="";t("ul.search-list li").remove();for(var s=0;s<a.length;s++)n+='<li class="auto-suggestion d-flex align-items-center justify-content-between cursor-pointer '+(0===s?"current_item":"")+'"><a class="d-flex align-items-center justify-content-between w-100" href='+a[s].firstChild.href+'><div class="d-flex justify-content-start"><span class="mr-75 '+a[s].firstChild.firstChild.className+'"  data-icon="'+a[s].firstChild.firstChild.className+'"></span><span>'+a[s].firstChild.dataset.originalTitle+'</span></div><span class="float-right bookmark-icon feather icon-star warning"></span></a></li>';t("ul.search-list").append(n)})),t(".nav-link-search").on("click",(function(){t(this);t(this).parent(".nav-search").find(".search-input").addClass("open"),t(".search-input input").focus(),t(".search-input .search-list li").remove(),t(".search-input .search-list").addClass("show"),t(".bookmark-wrapper .bookmark-input").removeClass("show")})),t(".search-input-close i").on("click",(function(){t(this);var e=t(this).closest(".search-input");e.hasClass("open")&&(e.removeClass("open"),t(".search-input input").val(""),t(".search-input input").blur(),t(".search-input .search-list").removeClass("show"),t(".app-content").hasClass("show-overlay")&&t(".app-content").removeClass("show-overlay"))})),t(".search-input .input").on("keyup",(function(e){if(38!==e.keyCode&&40!==e.keyCode&&13!==e.keyCode){27==e.keyCode&&(t(".app-content").removeClass("show-overlay"),t(".bookmark-input input").val(""),t(".bookmark-input input").blur(),t(".search-input input").val(""),t(".search-input input").blur(),t(".search-input").removeClass("open"),t(".search-list").hasClass("show")&&(t(this).removeClass("show"),t(".search-input").removeClass("show")));var a=t(this).val().toLowerCase(),n="",s=!1;if(t("ul.search-list li").remove(),t(this).parent().hasClass("bookmark-input")&&(s=!0),""!=a){t(".app-content").addClass("show-overlay"),t(".bookmark-input").focus()?t(".bookmark-input .search-list").addClass("show"):(t(".search-input .search-list").addClass("show"),t(".bookmark-input .search-list").removeClass("show")),!1===s&&(t(".search-input .search-list").addClass("show"),t(".bookmark-input .search-list").removeClass("show"));var i="",o="",l="",c="",u=0;t.getJSON("data/"+r+".json",(function(e){for(var r=0;r<e.listItems.length;r++){if(!0===s){n="";for(var d=t("ul.nav.navbar-nav.bookmark-icons li"),h=0;h<d.length;h++){if(e.listItems[r].name===d[h].firstChild.dataset.originalTitle){n=" warning";break}n=""}c='<span class="float-right bookmark-icon feather icon-star'+n+'"></span>'}0==e.listItems[r].name.toLowerCase().indexOf(a)&&u<10&&(i+='<li class="auto-suggestion d-flex align-items-center justify-content-between cursor-pointer '+(0===u?"current_item":"")+'"><a class="d-flex align-items-center justify-content-between w-100" href='+e.listItems[r].url+'><div class="d-flex justify-content-start"><span class="mr-75 '+e.listItems[r].icon+'" data-icon="'+e.listItems[r].icon+'"></span><span>'+e.listItems[r].name+"</span></div>"+c+"</a></li>",u++)}for(r=0;r<e.listItems.length;r++){if(!0===s){n="";for(d=t("ul.nav.navbar-nav.bookmark-icons li"),h=0;h<d.length;h++)n=e.listItems[r].name===d[h].firstChild.dataset.originalTitle?" warning":"";c='<span class="float-right bookmark-icon feather icon-star'+n+'"></span>'}0!=e.listItems[r].name.toLowerCase().indexOf(a)&&e.listItems[r].name.toLowerCase().indexOf(a)>-1&&u<10&&(o+='<li class="auto-suggestion d-flex align-items-center justify-content-between cursor-pointer '+(0===u?"current_item":"")+'"><a class="d-flex align-items-center justify-content-between w-100" href='+e.listItems[r].url+'><div class="d-flex justify-content-start"><span class="mr-75 '+e.listItems[r].icon+'" data-icon="'+e.listItems[r].icon+'"></span><span>'+e.listItems[r].name+"</span></div>"+c+"</a></li>",u++)}""==i&&""==o&&(o='<li class="auto-suggestion d-flex align-items-center justify-content-between cursor-pointer"><a class="d-flex align-items-center justify-content-between w-100"><div class="d-flex justify-content-start"><span class="mr-75 feather icon-alert-circle"></span><span>No results found.</span></div></a></li>'),l=i.concat(o),t("ul.search-list").append(l)}))}else if(!0===s){for(var d=t("ul.nav.navbar-nav.bookmark-icons li"),h="",p=0;p<d.length;p++)0===p?"current_item":"",h+='<li class="auto-suggestion d-flex align-items-center justify-content-between cursor-pointer"><a class="d-flex align-items-center justify-content-between w-100" href='+d[p].firstChild.href+'><div class="d-flex justify-content-start"><span class="mr-75 '+d[p].firstChild.firstChild.className+'"  data-icon="'+d[p].firstChild.firstChild.className+'"></span><span>'+d[p].firstChild.dataset.originalTitle+'</span></div><span class="float-right bookmark-icon feather icon-star warning"></span></a></li>';t("ul.search-list").append(h)}else t(".app-content").hasClass("show-overlay")&&t(".app-content").removeClass("show-overlay"),t(".search-list").hasClass("show")&&t(".search-list").removeClass("show")}})),t(a).on("mouseenter",".search-list li",(function(e){t(this).siblings().removeClass("current_item"),t(this).addClass("current_item")})),t(a).on("click",".search-list li",(function(e){e.stopPropagation()})),t("html").on("click",(function(e){t(e.target).hasClass("bookmark-icon")||(t(".bookmark-input .search-list").hasClass("show")&&t(".bookmark-input .search-list").removeClass("show"),t(".bookmark-input").hasClass("show")&&t(".bookmark-input").removeClass("show"))})),t(a).on("click",".bookmark-input input",(function(e){t(".bookmark-wrapper .bookmark-input").addClass("show"),t(".bookmark-input .search-list").addClass("show")})),t(a).on("click",".bookmark-input .search-list .bookmark-icon",(function(e){if(e.stopPropagation(),t(this).hasClass("warning")){t(this).removeClass("warning");for(var a=t("ul.nav.navbar-nav.bookmark-icons li"),n=0;n<a.length;n++)a[n].firstChild.dataset.originalTitle==t(this).parent()[0].innerText&&a[n].remove();e.preventDefault()}else{a=t("ul.nav.navbar-nav.bookmark-icons li");t(this).addClass("warning"),e.preventDefault();var s;s='<li class="nav-item d-none d-lg-block"><a class="nav-link" href="'+t(this).parent()[0].href+'" data-toggle="tooltip" data-placement="top" title="" data-original-title="'+t(this).parent()[0].innerText+'"><i class="ficon '+t(this).parent()[0].firstChild.firstChild.dataset.icon+'"></i></a></li>',t("ul.nav.bookmark-icons").append(s),t('[data-toggle="tooltip"]').tooltip()}})),t(e).on("keydown",(function(a){var n,s,i=t(".search-list li.current_item");if(40===a.keyCode?(n=i.next(),i.removeClass("current_item"),i=n.addClass("current_item")):38===a.keyCode&&(s=i.prev(),i.removeClass("current_item"),i=s.addClass("current_item")),13===a.keyCode&&t(".search-list li.current_item").length>0){var o=t(".search-list li.current_item a");e.location=o.attr("href"),t(o).trigger("click")}})),Waves.init(),Waves.attach(".btn",["waves-light"])}(window,document,jQuery)}});