$.noConflict(),jQuery(document).ready(function($){function e(){var e=$(".page-container").hasClass("fixed-header"),t=$(".main-container").innerWidth();e&&$(".top-bar").css({width:t+"px"})}function t(){$(".leftbar-action").on("click",function(e){e.preventDefault(),h.hasClass("list-menu-view")?(h.removeClass("list-menu-view"),h.addClass("hide-list-menu")):(h.removeClass("hide-list-menu"),h.addClass("list-menu-view"))}),$(".leftbar-action-mobile").on("click",function(e){e.preventDefault(),h.hasClass("list-menu-view")?(h.removeClass("list-menu-view"),h.addClass("hide-list-menu")):(h.removeClass("hide-list-menu"),h.addClass("list-menu-view"))}),$(".rightbar-action").on("click",function(e){e.preventDefault(),p.hasClass("rightbar-show")?p.removeClass("rightbar-show"):p.addClass("rightbar-show")}),$(".aside-close").on("click",function(e){h.removeClass("hide-list-menu"),h.addClass("list-menu-view")})}function a(){d.hasClass("rightbar-show")&&d.removeClass("rightbar-show")}function i(){$(".search-bar").hasClass("search-show")?$(".search-bar").removeClass("search-show"):($(".search-bar").addClass("search-show"),$(".search-input").focus())}function n(){w.parents(".widget-head").next(".widget-container").unmask()}function s(){var e=$(window).height(),t=$(".chat-user-list");if(t.length)var a=t.offset().top;var i=e-a;$(".chat-user-list").css({height:i+"px"})}function o(){var e=$(window).height(),t=$(".converstaion-list");if(t.length)var a=t.offset().top;var i=$(".chat-input-form").height()+40,n=a+i,s=e-n;$(".converstaion-list").css({height:s+"px"})}function r(){var e=$(window).height(),t=$(".aside-branding").height(),a=e-t;$(".server-stats-content").css({height:a+"px"})}function c(){var e=$(window).height(),t=$(".right-aside .aside-branding").height(),a=e-t;$(".aside-notifications-wrap").css({height:a+"px"})}function l(){var e=$(window).height(),t=$(".left-aside .aside-branding").height(),a=e-t;$(".left-navigation").css({height:a+"px"})}var h=$(".page-container"),d=$(".right-aside"),p=$(".right-aside"),f=$(".m-leftbar-show"),u=$("body"),g=$("html");e(),t();var v=jRespond([{label:"handheld",enter:0,exit:767},{label:"tablet",enter:768,exit:979},{label:"laptop",enter:980,exit:1199},{label:"desktop",enter:1200,exit:1e4}]);v.addFunc([{breakpoint:["desktop","laptop"],enter:function(){},exit:function(){}},{breakpoint:["handheld","tablet"],enter:function(){},exit:function(){a()}}]),$.fn.dcAccordion&&$(".list-accordion").each(function(){$(this).dcAccordion({eventType:"click",hoverDelay:100,autoClose:!0,saveState:!1,disableLink:!0,speed:"fast",showCount:!1,autoExpand:!0,cookie:"dcjq-accordion-1",classExpand:"dcjq-current-parent"})}),$(".widget-collapse").on("click",function(e){var t=$(this).children("i");$(this).parents(".widget-head").next(".widget-container").slideToggle(200),$(t).hasClass("fa-angle-down")?($(t).removeClass("fa-angle-down"),$(t).addClass("fa-angle-left")):($(t).removeClass("fa-angle-left"),$(t).addClass("fa-angle-down")),e.preventDefault()});var w;$(".w-reload").click(function(){w=$(this),$(this).parents(".widget-head").next(".widget-container").mask("Loading..."),setTimeout(n,1500)});try{var m=Array.prototype.slice.call(document.querySelectorAll(".w-on-off"));m.forEach(function(e){var t=new Switchery(e,{size:"small",color:"#15bdc3",jackColor:"#fff",secondaryColor:"#eee",jackSecondaryColor:"#fff"})});var C=document.querySelector(".w-on-off");C.onchange=function(){var e=$(this).parents(".widget-head").next(".widget-container").slideToggle(200);C.checked}}catch(k){}try{$(".w-i-check").iCheck({checkboxClass:"icheckbox_minimal",radioClass:"iradio_minimal",increaseArea:"30%"});var b=$(".w-i-check");b.on("ifChecked ifUnchecked",function(e){var t=$(this).parents(".widget-head").next(".widget-container").slideToggle(200);"ifChecked"==e.type})}catch(k){}if($(".widget-remove").on("click",function(e){$(this).parents(".widget-module").remove(),e.preventDefault()}),$(".search-btn").on("click",function(){i()}),$(".search-close").on("click",function(){i()}),$('[data-tooltip="tooltip"]').tooltip(),$(".chat-close").on("click",function(){$(".conv-container").removeClass("show-conv")}),$(".chat-list").on("click",function(){$(".conv-container").addClass("show-conv")}),s(),o(),r(),c(),l(),$(window).smartresize(function(){s(),o(),r(),c(),l(),e()}),$.fn.sparkline){var x=function(){$(".sparkline").each(function(){var e=$(this).data();e.valueSpots={"0:":e.spotColor},$(this).sparkline(e.data,e);var t=e.compositedata;if(t){var a=$(this).attr("data-stack-line-color"),i=$(this).attr("data-stack-fill-color"),n=$(this).attr("data-stack-spot-color"),s=$(this).attr("data-stack-spot-radius");$(this).sparkline(t,{composite:!0,lineColor:a,fillColor:i,spotColor:n,highlightSpotColor:n,spotRadius:s,valueSpots:{"0:":n}})}})},y;$(window).smartresize(function(e){clearTimeout(y),y=setTimeout(function(){x(!0)},100)}),x(!1)}$(".progress-bar").each(function(){var e=$(this).data("progress");e&&($(this).css("width",e+"%"),$(this).parents(".progress").parents(".progress-wrap").children(".progress-meta").children(".progress-percent").text(e+"%"))}),$.fn.easyPieChart&&$(".epie-chart").each(function(){var e=$(this).data("barcolor"),t=$(this).data("tcolor"),a=$(this).data("scalecolor"),i=$(this).data("linecap"),n=$(this).data("linewidth"),s=$(this).data("size"),o=$(this).data("animate"),r=$(this).data("percent");$(this).children(".percent").css({width:s+"px","line-height":s+"px"}),100===r&&($('<span class="p-done"><i class="fa fa-check"></i></span>').insertBefore($(this).children(".percent")),$(this).children(".p-done").css({width:s+"px",height:s+"px","line-height":s+"px",color:e}),$(this).children(".percent").remove()),$(this).easyPieChart({barColor:e,trackColor:t,scaleColor:a,lineCap:i,lineWidth:n,size:s,animate:o,onStep:function(e,t,a){$(this.el).find(".percent").text(Math.round(a))}})});try{$.scrollUp({scrollName:"scrollTop",topDistance:"300",topSpeed:300,animation:"fade",animationInSpeed:200,animationOutSpeed:200,scrollText:'<i class="fa fa-angle-up"></i>',activeOverlay:!1})}catch(S){console.log("scrollTop is not found")}});