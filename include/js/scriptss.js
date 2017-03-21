/**
 * Protect window.console method calls, e.g. console is not defined on IE
 * unless dev tools are open, and IE doesn't define console.debug
 * 
 * Chrome 41.0.2272.118: debug,error,info,log,warn,dir,dirxml,table,trace,assert,count,markTimeline,profile,profileEnd,time,timeEnd,timeStamp,timeline,timelineEnd,group,groupCollapsed,groupEnd,clear
 * Firefox 37.0.1: log,info,warn,error,exception,debug,table,trace,dir,group,groupCollapsed,groupEnd,time,timeEnd,profile,profileEnd,assert,count
 * Internet Explorer 11: select,log,info,warn,error,debug,assert,time,timeEnd,timeStamp,group,groupCollapsed,groupEnd,trace,clear,dir,dirxml,count,countReset,cd
 * Safari 6.2.4: debug,error,log,info,warn,clear,dir,dirxml,table,trace,assert,count,profile,profileEnd,time,timeEnd,timeStamp,group,groupCollapsed,groupEnd
 * Opera 28.0.1750.48: debug,error,info,log,warn,dir,dirxml,table,trace,assert,count,markTimeline,profile,profileEnd,time,timeEnd,timeStamp,timeline,timelineEnd,group,groupCollapsed,groupEnd,clear
 */
(function() {
  // Union of Chrome, Firefox, IE, Opera, and Safari console methods
  var methods = ["assert", "assert", "cd", "clear", "count", "countReset",
    "debug", "dir", "dirxml", "dirxml", "dirxml", "error", "error", "exception",
    "group", "group", "groupCollapsed", "groupCollapsed", "groupEnd", "info",
    "info", "log", "log", "markTimeline", "profile", "profileEnd", "profileEnd",
    "select", "table", "table", "time", "time", "timeEnd", "timeEnd", "timeEnd",
    "timeEnd", "timeEnd", "timeStamp", "timeline", "timelineEnd", "trace",
    "trace", "trace", "trace", "trace", "warn"];
  var length = methods.length;
  var console = (window.console = window.console || {});
  var method;
  var noop = function() {};
  while (length--) {
    method = methods[length];
    // define undefined methods as noops to prevent errors
    if (!console[method])
      console[method] = noop;
  }
})();
$(window).load(function() {
	if ( $(".player-loader").length ) {
		$(".player-loader").hide();
		$(".play-button .fa").css("visibility", "visible");
	}
})
$(document).ready(function(){
	if ( $("#reg_form").length ) {
		$("#subreg").click(function() {
			$(".onload,.onerror").hide();							 
			$(".onload").fadeIn().delay( 3000 );
			$(".onload").fadeOut();
			setTimeout(function() { $(".onerror").fadeIn(); $("#userid, #password").val(""); $("#userid").focus(); }, 3500);
		});
	}
	if ( $("#modal-watch").length ) {
		$("#submov").click(function() {
			$(".onload,.onerror").hide();							 
			$(".onload").fadeIn().delay( 3000 );
			$(".onload").fadeOut();
			setTimeout(function() { $(".onerror").fadeIn(); $("#userid, #password").val(""); $("#userid").focus(); }, 3500);
		});
	}
	$(".cfull").on('click', function() {
		screenfull.request( document.getElementById('player') );
	});
	$(".cvolu,.cset").on('click', function() {
		$('#modal-watch').modal({show: true, backdrop: 'static'});
	});
	$("a.play").on('click', function() {
		screenfull.exit();
	});
        //loading video
        $(".player-loader").delay(9000).fadeOut();
	$('.movie-cover').hover(
        	function(){
			$(this).find('.caption').slideDown(250); //.fadeIn(250)
        	},
        	function(){
			$(this).find('.caption').slideUp(250); //.fadeOut(205)
        	}
	);
	$( ".play-button .fa,.cplay" ).on( "click", function() {
		var 	opening = "http://" + window.location.hostname + "/include/images/opening.jpg",
			loading = "http://" + window.location.hostname + "/include/images/player-loading.gif";
		$(".play-button .fa").hide();
		$(".player-loader").show();
		setTimeout(function() { 
			$(".img-backdrop").attr( 'src', opening );
			$(".player-loader").fadeOut(2000);
			$(".progressbar").animate({
				width:"3%"
				},{
					queue: false,
					duration: 3000,
					complete: function() {
						console.log("ok");
						$("#control").hide();
						$('#modal-watch').modal({show: true, backdrop: 'static'});
					}
				});			
		},2000);
	});
});	
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})