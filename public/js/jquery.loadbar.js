jQuery.fn.extend({

	loadBar: function(options){
		defaults = {
			height_bar: '4',
			z_index: 20001,
			color_bar: "#9A48EC",
			color_shadow: "#f2f2f2",
		}

		var options = $.extend({}, defaults, options);

		this.each(function(){
			$(document).ready(function(){

				loadbar = $("<div />",{
					"id":"loadbar",
				});

				shadbar = $("<div />",{
					"id": "shadbar"
				});

				$("body").prepend(loadbar,shadbar);
				$("#loadbar").css({
					"height": options.height_bar+"px",
					"position": "fixed",
					"background": options.color_bar,
					"z-index": (options.z_index+1)
				});

				$("#shadbar").css({
					"width": 100+"%",
					"height": 100+"%",
					"float": "left",
					"position": "fixed",
					"background": options.color_shadow,
					"z-index": options.z_index
				});

				rand = Math.floor((Math.random()*20)+1);

				$("#loadbar").animate({'width':rand+'%'},200,function(){
				});
			});

			$(window).load(function(){

				rand = Math.floor((Math.random()*450)+1);
				$("#loadbar").animate({'width':100+'%'},rand,function(){
					$("#loadbar").fadeOut(250);
				});

				$("#shadbar").fadeOut(1000);
			});

		});
	}
});
