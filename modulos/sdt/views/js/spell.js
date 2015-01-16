$(document).ready(function(){

	$Spelling.DefaultDictionary = "Espanol";
	$Spelling.UserInterfaceTranslation = "es";
	$('#my-button').bind('click', function(e) {
		$Spelling.SpellCheckInWindow('myTextArea');
	});

	// Semicolon (;) to ensure closing of earlier scripting
	// Encapsulation
	// $ is assigned to jQuery
	;(function($) {

	     // DOM Ready
	    $(function() {

	        // Binding a click event
	        // From jQuery v.1.7.0 use .on() instead of .bind()
	        $('#my-button2').bind('click', function(e) {

	        	//$('#myTextArea').spellCheckInDialog({popUpStyle:'fancybox',theme:'clean'})

	            // Prevents the default action to be triggered. 
	            //e.preventDefault();

	            // Triggering bPopup when click event is fired

	            var texto = $("#myTextArea").text().trim();
	            $(".content").text(texto);
	   //         	var codehtml="algo";
	   //         	var elemento=null;
	   //         	var conta=0;
	   //         	var divCont = $('<div></div>');
				// $.post(server+'/sdt/getSpells','frase='+texto, function(datos){
			 //        jQuery.each(datos, function(i, val) {
				// 	  	//alert("palabra : " + val.palabra + " ::sugerencias : " +val.sugerencias)
				// 		if (conta==0) {
							
							
				// 		};
				// 		var sele = $('<select style="float:left;"></select>');
				// 		var div = $('<div style="float:left;">&nbsp&nbsp</div>');
				// 		var opti = $('<option value="'+val.palabra+'">'+val.palabra+'</option>')
						
				// 		if (val.sugerencias) {
				// 			//opti.css("color","red")
				// 			sele.append(opti);
				// 			jQuery.each(val.sugerencias, function(j, val2) {
				// 				var opti = $('<option value="'+val2+'">'+val2+'</option>')
				// 				sele.append(opti);
				// 			});
				// 		}else{
				// 			sele.append(opti);
				// 		}
				// 		divCont.append(sele);
				// 		divCont.append(div);
				// 		conta+=1;
				// 		if (conta>6) {
				// 			conta=0;
				// 			$(".content").append(divCont);
				// 			divCont = $('<div></div>');
				// 		};
				// 	});
				// 	if (conta>0) {
				// 		$(".content").append(divCont);
				// 	}
			 //        //$(".content").html(codehtml);
			 //    }, 'json');
				


	            $('#popup2').bPopup({
		            speed: 650,
            		transition: 'slideIn'
		        });
	        });

	    });

	})(jQuery);
	
    
    
              
});
$(document).ready(function(){
	
});