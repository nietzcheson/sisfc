var salvar = 0;
var fechaG="";
var lastObj=null;
var reSpan=false;
var SOnline=true;
var SOnlineOld=true;
var SpecialCh = new Array();

$(document).ready(function(){
	server = "http://"+window.location.hostname;
	var cambio=false;
	var numemax=-0;
	
	
	SpecialCh["="] = "||igu||";
	SpecialCh["+"] = "||mas||";
	SpecialCh["&"] = "||ans||";

	$("#btn_help").click(function(){
		$('#popuphelp').bPopup();
	});
	$("#btn_mail").click(function(){
		$('#popupmail').bPopup();
	});
	$("#submit_email").click(function(){
		$('#submit_email').attr("disabled", true);
		$.post(server+'/sdt/ennviarEmailRM','dia='+$("#dia").val()+'&correo='+$("#correo").val()+'&asunto='+$("#asunto").val(), function(datos){
			if (datos!="None") {
				$('#submit_email').attr("disabled", false);
				alert("Correo enviado");
			};
		}, 'json').fail(function() {
		    console.log("error de conexion");
		    SOnline=false;
		});
	});
	$(".pizarron").bind('paste', function(e) {
		salvar=5;
		reSpan=true;
	});

	$("#sample thead tr:eq(0)").css("width",$("#sample tbody tr:eq(0)").width());

	var offsetT = $("#sample tbody tr:eq(0)").offset();
	$("#sample thead tr:eq(0)").offset({ top: $("#header-contenido").height(), left: offsetT.left });

	$(window).resize(function(e) {
	    var offsetT = $("#sample tbody tr:eq(0)").offset();
		$("#sample thead tr:eq(0)").offset({ top: ($("#header-contenido").height()+$("#header-contenido").offset().top), left: offsetT.left });
	});
	$( window ).scroll(function() {
		var offsetT = $("#sample tbody tr:eq(0)").offset();
		$("#sample thead tr:eq(0)").offset({ top: ($("#header-contenido").height()+$("#header-contenido").offset().top), left: offsetT.left });
	});
	$("#rmnow").remove();

	$("#Setiqueta").css("visibility", "hidden");
	$("#b-eliminar_top").css("visibility", "hidden");
	$("#save").css("visibility", "hidden");
	$("#abc").css("visibility", "hidden");
	
	
	$("#main_container #drag2").scrollLeft( 300 );
	
	$("#save").attr("disabled", "disabled");
	$("#Setiqueta").change(function(){
		if (lastObj && SOnline) {
			var contenedor = $(lastObj).parent("div:eq(0)");
			var valore = $("#Setiqueta").val();
			if (valore!="0") {
				$.post(server+'/sdt/getEtiquet','eti='+valore, function(datos){
					//alert(datos);
					if (datos!="None") {
		            	$(contenedor).css("font-family",datos.ffamily);
						$(lastObj).css("font-size",datos.fsize+"px");
						$(contenedor).css("color",datos.fcolor);
						$(contenedor).css("background-color",datos.fcback);
						$(contenedor).attr("name",valore);
						$("#save").removeAttr("disabled");
						salvar=5;

						var tdp=$(contenedor).parent("td:eq(0)");
				        var trp=$(tdp).parent();
				        var hijo1 = $(trp).find( ".chek" );
				        var clase = "" + $(hijo1).attr("class") + "";
				        var valor = clase;
				        if (valor.indexOf("active")==-1) {
				        	valor = false;
				        }else{
				        	valor = true;
				        }
						colorMin(contenedor, valor);

		            };
		    	}, 'json').fail(function() {
				    console.log("error de conexion");
				    SOnline=false;
				});
			}else{
				$(contenedor).css("font-family","Klavika");
				$(lastObj).css("font-size","14px");
				$(contenedor).css("color","#000000");
				$(contenedor).css("background-color","transparent");
				$(contenedor).attr("name",0);
				$("#save").removeAttr("disabled");
				salvar=5;
			};
	    }
	});
	$("#b-eliminar_top").click(function(){
		if (lastObj && SOnline) {
			hiddeTools();
			var tdp=$(lastObj).parent();
			var tdp=$(tdp).parent();
	        var trp=$(tdp).parent();

	        var hijo1 = $(trp).find( ".numerar" );
	        var nuR = $(hijo1).text().trim();
	        var nu = nuR;
	        if (nu!="1") {
	        	/// encontrar el nivel del ultimo numero
		        var nivelR = nu.split(".").length;
		        var nivel = nivelR;
		        var stado=0;
		        //controla el aumento del nivel del numeral
		        var inc=0;
		        //tipo de proceso
		        var tipo=0;
	        	$(".numerar").each(function(index, elemento){
		    		//identificar el elemento
		    		var str = $(elemento).text().trim();
					var res = str.split(".");
					//alert(res.length+"<"+(nivel-2) + "  " + stado)
					if (stado==1) {
						stado=2;
				        nu = $(elemento).text().trim();
				        /// encontrar el nivel del ultimo numero
				        nivel = nu.split(".").length;
					};
					if (res.length<nivelR && stado==2) {
					 	stado=3;
					}
		    		if (stado==2) {
		    			//almacenar el nuevo numeral
		    			var newnum="";
		    			for (var i = (res.length-1); i >=0 ; i--) {
		    				if (parseInt(i) == (res.length-1)) {
		    					if ((parseInt(res[i])-1)>0) {
		            				newnum=parseInt(res[i])-1;
		    						newnum="."+newnum;
		    					};
		    				}else{
		            			newnum=res[i] + newnum;
		            			newnum="."+newnum;
		    				};
		    			}
		    			newnum=newnum.slice(1,newnum.length);
		    			$(elemento).text(newnum);
		    			var niv = res.length;
						var avan = $(elemento).text().split(".").length-niv;
						var tdpp=$(elemento).parent();
						var tdpp=$(tdpp).parent();
						var trpp=$(tdpp).parent();
						var hijop1 = $(trpp).find( "div[class^='conpizarron']" );
						$(elemento).animate({
							marginLeft: '+='+(12*avan)+'px'
						}, 500);
						var res = $(elemento).text().split(".");
						$(hijop1).css("margin-left", (32+32*(niv-1))+"px");
						$(hijop1).animate({
							marginLeft: '+='+(32*avan)+'px'
						}, 500);
						nivelR=niv;
		    		};
		    		if (str==nuR && stado==0) {
		    			//cambio de estado, apartir de este elemento procesar los numerales.
		    			stado=1;
		    		};
		    	});
				loastObj=null;
				var id = $(trp).attr("id");
			    if (id) {
			    	id = id.slice(3,id.length);
				    $.post(server+'/sdt/eliminarRMLinea','id='+id).fail(function() {
					    console.log("error de conexion");
					    SOnline=false;
					});
			    };
				jQuery(trp).remove();
				OrdenAll();
	        }else{
	        	if ($('#sample >tbody >tr').length == 1){
	        		var id = $(trp).attr("id");
				    if (id) {
				    	id = id.slice(3,id.length);
					    $.post(server+'/sdt/eliminarRMLinea','id='+id).fail(function() {
						    console.log("error de conexion");
						    SOnline=false;
						});
				    };
	        		jQuery(trp).remove();
	        	}
	        }
	        
		};
	});
	$("#save").click(function(){
		salvar=0;
		OrdenAll();
		$(this).attr("disabled", "disabled");
	});
	$(".numerar").each(function(index, elemento){
		var str = $(elemento).text().trim();
		var res = str.split(".");
		var niv = res.length;
		var tdpp=$(elemento).parent();
		var trpp=$(tdpp).parent();
		var hijop1 = $(trpp).find("div[class^='conpizarron']");

		$(elemento).animate({
			marginLeft: '+='+(12*(niv-1))+'px'
		}, 500);
		var res = $(elemento).text().split(".");
		$(hijop1).animate({
			marginLeft: '+='+(32*(niv-1))+'px'
		}, 500);
	});
	
	$('#contentRM').on('keypress', ".conpizarron", function(e){
		var code = e.keyCode || e.which;
		if (e.keyCode == 13 && SOnline )
	    {
	    	//alert(e.keyCode + " " + e.shiftKey);
	        if (e.shiftKey === false && SOnline)
	        {
	            // new line
	            //obtener el DOM de la fila
	            var tdp=$(this).parent();
                var trp=$(tdp).parent();

	            var hijo1 = (trp).find( ".numerar" );
	            var hijopiz = (trp).find( ".pizarron" );
	            var hijoch = (trp).find( ".chek" );

	         
		        // var clase = "" + $(hijoch).attr("class") + "";
		        // var valor = clase;
		        // if (valor.indexOf("active")==-1) {
		        // 	valor = "";
		        // }else{
		        // 	valor = "active";
		        // }

	            var nume = $(hijo1).text().trim();
	            /// encontrar el nivel del ultimo numero
	            var nivel = nume.split(".").length;

	            /// cambiar todos los numeros de ese nivel desde la fila +1 hasta que encuentre una fila que tenga un numero co  menor nivel
	            newNumber(nume);
	            tr = $('<tr ></tr>');
	            td1 = $('<td></td>');
	            td2 = $('<td></td>');
	            var newnum ="";
	            var res = nume.split(".");
				for (var i = 0; i < res.length; i++) {
					if (i==(nivel-1)) {
						newnum+=(parseInt(res[i])+1);
					}else{
						newnum+=res[i];
					}
					newnum+=".";
				};
				newnum=newnum.slice(0,newnum.length-1);

				input1=$('<div class="btn-group text-center" data-toggle="buttons"><label class="btn btn-default chek" id="checkAll"></label></div>');
				div1 = $('<div style="float:left"></div>');
	            div2 = $('<div class="numerar" style="margin-left:'+(12*nivel)+'px">'+newnum+'</div>');
	            div4 = $('<div class="conpizarron" style="margin-left:'+(32+32*(nivel-1))+'px;border-radius:3px"</div>');
	            div3 = $('<div class="pizarron" name="0" contenteditable="true" style="margin-left:5px;font-weight: bold;word-break: break-all;" ></div>');
	            //div4 = $('<div class="tools"></div>');
	            //botonDel = $('<button type="button" class="btn btn-'+ ruta1 +'"><span class="glyphicon glyphicon-'+ruta2+'"></span></button>');
	            
	            var contenedor = $(lastObj).parent("div:eq(0)");
				var valore = $("#Setiqueta").val();
				if (valore!="0") {
					$.post(server+'/sdt/getEtiquet','eti='+valore, function(datos){
						//alert(datos);
						if (datos!="None") {
			            	div4.css("font-family",datos.ffamily);
							div3.css("font-size",datos.fsize+"px");
							div4.css("color",datos.fcolor);
							div4.css("background-color",datos.fcback);
							div4.attr("name",valore);
			            };
			    	}, 'json').fail(function() {
					    console.log("error de conexion");
					    SOnline=false;
					});
				}else{
					div4.css("font-family","Klavika");
					div3.css("font-size",14+"px");
					div4.css("color","#000000");
					div4.css("background-color","transparent");
					div4.attr("name",0);
				};
				div1.append(div2);
	            div4.append(div3);
	            //div4.append(botonDel);
	            td1.append(input1);
	            td2.append(div1);
	            td2.append(div4);
	            // div3.css("font-family",$(lastObj).css("font-family"));
	            // div3.css("font-size",$(lastObj).css("font-size"));
	            // div3.css("color",$(lastObj).css("color"));
	            // div4.css("background-color",$(this).css("background-color"));
	            div4.attr("name",$(this).attr("name"));


	            tr.append(td1);
	            tr.append(td2);

	            
	            $(trp).after(tr);
	            
	            $(tr).css('display', 'none');
	            $(tr).fadeIn( "slow" );
	            $(div3).focus();
	   			if (lastObj) {
					lastObj.attr('id',"none");
				};
				lastObj=$(div3);
				lastObj.attr("id","myTextArea");
				$("#save").removeAttr("disabled");
	    		salvar=5;
	    		showTools(lastObj);
	            return false;
	        }
	        else
	        {
	            // run your function

	        }
	        //return false;s
	    }
	    $("#save").removeAttr("disabled");
	    salvar=5;
	    
	});
	$('#contentRM').keydown(function(e) {
		$("#save").removeAttr("disabled");
	    salvar=5;
		var keyCode = e.keyCode || e.which;
		if (keyCode==8) {
			
		};
		if (e.shiftKey === true && keyCode == 9 && lastObj){
			e.preventDefault();
			var tdp=$(lastObj).parent();
			var tdp=$(tdp).parent();
            var trp=$(tdp).parent();

            var hijo1 = $(trp).find( ".numerar" );
            var nu = $(hijo1).text().trim();
            /// encontrar el nivel del ultimo numero
            var nivel = nu.split(".").length;
            var stado=0;
            //controla el aumento del nivel del numeral
            var inc=0;
            //tipo de proceso
            var tipo=0;
            if (nivel>1) {
            	$(".numerar").each(function(index, elemento){
            		//identificar el elemento
            		var str = $(elemento).text().trim();
					var res = str.split(".");
					//alert(res.length+"<"+(nivel-2) + "  " + stado)
					if (res.length<=(nivel-2) && stado==1) {
        			 	stado=2;
        			}
        			if (res.length<=(nivel-1) && stado==1) {
        			 	tipo=1;
        			}
            		if (str==nu && stado==0) {
            			// cambio de estado, apartir de este elemento procesar los numerales.
            			stado=1;
            		};
            		if (stado==1) {
            			// almacenar el nuevo numeral
            			var newnum="";
            			
            			if (res.length==nivel && tipo==0) {
            				// se detecta que es necesario subir un nivel al numeral
            				inc+=1;
            			}
            			for (var i = 0; i < res.length; i++) {
            				if (tipo==0) {
            					if (nivel-1!=i) {
	            					if (i<nivel-2) {
		            					newnum+=res[i];
		            				}else if (i==nivel-2) {
		            					newnum+=parseInt(res[i])+inc;
		            				}else{
		            					newnum+=res[i];
		            				}
		            				newnum+=".";
            					};
            				}else{
            					if (i==nivel-2) {
		            				newnum+=parseInt(res[i])+inc;
		            			}else{
		            				newnum+=res[i];
		            			}
		            			newnum+=".";
            				};
            			}
            			newnum=newnum.slice(0,newnum.length-1);
            			$(elemento).text(newnum);

            			var niv = res.length;
						var avan = $(elemento).text().split(".").length-niv;
						

						var tdpp=$(elemento).parent();
						var tdpp=$(tdpp).parent();
						var trpp=$(tdpp).parent();
						var hijop1 = $(trpp).find( "div[class^='conpizarron']" );

						$(elemento).animate({
							marginLeft: '+='+(12*avan)+'px'
						}, 500);
						var res = $(elemento).text().split(".");
						$(hijop1).css("margin-left", (32+32*(niv-1))+"px");
						$(hijop1).animate({
							marginLeft: '+='+(32*avan)+'px'
						}, 500);
            		};
            	});
				$("#save").removeAttr("disabled");
				salvar=5;
            };
		}else if (keyCode == 9 && lastObj) { 
		    e.preventDefault(); 
		    if (lastObj) {
	    		if ($(lastObj).attr("class").slice(0,8)=="pizarron") {
	    			//obtener el DOM de la fila
	    			var tdp=$(lastObj).parent();
	    			var tdp=$(tdp).parent();
	    			showTools(lastObj);

	                var trp=$(tdp).parent();
	                //obtener el numero de la fila

	                var hijo1 = $(tdp).children('div').get(0);
		            var nu = $(hijo1).text().trim();
		            /// encontrar el nivel del ultimo numero
		            var nivel = nu.split(".").length;
		            // ultimo nivel y numeracion
		            var last_nivel = 0;
		            var last_nu = "";

	                var sigui=0;
	                var nume="";
	                //var nu=$(hijo1).text().trim();
	                var nivel;
	                var ante="";
	                var numeral="";
	                var last_str="";
	                $(".numerar").each(function(index, elemento){
	                	var str = $(elemento).text().trim();
	                	var res = str.split(".");

	                	if (sigui==1) {
	                		var newnum ="";
							// nivel de incremento
							if (last_nu!="") {
								if (nu==str.slice(0,nu.length) ) {
									$(elemento).text(last_nu+str.slice(nu.length));
									if ($(elemento).text()==last_str) {
										$(elemento).text(last_nu+"."+1+str.slice(nu.length));
									};
								}else{
									for (var i = 0; i < res.length; i++) {
										if (i==nivel-1) {
											newnum+=(parseInt(res[i])-1);
										}else{
											newnum+=res[i];
										}
										newnum+=".";
										//la cadena debe coincidir para hasta el nivel anterior
										if (i<(nivel-1)) {
											//alert(newnum+"!="+nu.slice(0,newnum.length))
											if (newnum!=nu.slice(0,newnum.length)) {
												sigui=2;
												//sino coinciden entonces no debe incrementar y terminar de buscar
												i = res.length;
											};
										};
									};
									if (sigui==1) {
										newnum=newnum.slice(0,newnum.length-1);
										$(elemento).text(newnum);
									};
								}
							};
	                	}
	                	if(sigui==0){
	                		
		                	if (nu==str) {
								sigui=1;
								if (last_nivel!="") {
		                			numeral= last_nu.split(".");
		                			numeral[numeral.length-1]=parseInt(numeral[numeral.length-1])+1;
		                			numeral=numeral.join(".");
		                			$(elemento).text(numeral);
		                			nivel = nu.split(".").length;
		                			last_nu = numeral;
								}else if (nume!="") {
									nivel = nu.split(".").length;
									if (nume+"."+1!=$(elemento).text()) {
										$(elemento).text(nume+"."+1);
									}else{
										sigui=2;
									}
									last_nu=nume;
								};
							}else {
								nume=str;

								// llevar un registro del ultimo registro con un nivel superior
		                		// al que intento agregar mas niveles
		                		if ((nivel+1)==res.length) {
		                			last_nivel=res.length;
		                			last_nu=str;
		                		}else if ( res.length <= nivel) {
		                			last_nivel=0;
		                			last_nu="";
		                		};
							}
						}
						last_str = $(elemento).text();
						var niv = res.length;
						var avan = $(elemento).text().split(".").length-niv;
						

						var tdpp=$(elemento).parent();
						var tdpp=$(tdpp).parent();
						var trpp=$(tdpp).parent();
						var hijop1 = $(trpp).find( "div[class^='conpizarron']" );

						$(elemento).animate({
							marginLeft: '+='+(12*avan)+'px'
						}, 500);
						var res = $(elemento).text().split(".");
						$(hijop1).css("margin-left", (32+32*(niv-1))+"px");
						$(hijop1).animate({
							marginLeft: '+='+(32*avan)+'px'
						}, 500);
	                });
					$("#save").removeAttr("disabled");
					salvar=5;
	    		};
	    	};
		}
	});
	$('#contentRM').on('click', "div[class^='pizarron']", function(){
		if (lastObj) {
			lastObj.attr('id',"none");
		};
		lastObj=$(this);
		lastObj.attr("id","myTextArea");
		showTools(lastObj);
		// if ($(lastObj).text().trim()=="") {
		// 	$(lastObj).text("-");
		// };
	});
	$('#contentRM').on('click', "div[class^='numerar']", function(){
		var td=$(this).parent();
		var tr=$(td).parent();
		lastObj = $(tr).find( "div[class^='pizarron']" );
		if (lastObj) {
			lastObj.attr('id',"none");
		};
		lastObj.attr("id","myTextArea");
		$(lastObj).focus();
		showTools(lastObj);
		// if ($(lastObj).text().trim()=="") {
		// 	$(lastObj).text("-");
		// };
	});
	$('#contentRM').on('click', '.chek', function(){

		var clase = "" + $(this).attr("class") + "";
        var valor = clase;
        if (valor.indexOf("active")==-1) {
        	valor = true;
        }else{
        	valor = false;
        }

		var td=$(this).parent();
		td=$(td).parent();
		var tr=$(td).parent();
		var hijo1 = $(tr).find( ".conpizarron" );
		var hijo2 = $(tr).find( ".pizarron" );

		var namec = $(hijo1).attr("name");
		if (namec!="0") {
			var colorb = colorToHex($(hijo1).css("background-color"));
		};
		
		if (valor) {
			$(hijo2).css("font-weight", "normal");
			$(tr).css("background-color", "#f1f1f1");

			if (namec!="0") {
				if (colorb=="#ffe527") {
					$(hijo1).css("background-color","#fff8be");
				}else if (colorb=="#dc6519") {
					$(hijo1).css("background-color","#dca481");
				}else if (colorb=="#293cff") {
					$(hijo1).css("background-color","#acb3ff");
				}else if (colorb=="#771edc") {
					$(hijo1).css("background-color","#af87dd");
				}else if (colorb=="#287d17") {
					$(hijo1).css("background-color","#72a268");
				}else if (colorb=="#f0a7a5") {
					$(hijo1).css("background-color","#f4d8d7");
				}else if (colorb=="#7d7980") {
					$(hijo1).css("background-color","#d7d2db");
				}else if (colorb=="#ff1d15") {
					$(hijo1).css("background-color","#ff5f60");
				}
			}
		}else{
			$(hijo2).css("font-weight", "bold");
			$(tr).css("background-color", "transparent");

			if (namec!="0") {
				if (colorb=="#fff8be") {
					$(hijo1).css("background-color","#ffe527");
				}else if (colorb=="#dca481") {
					$(hijo1).css("background-color","#dc6519");
				}else if (colorb=="#acb3ff") {
					$(hijo1).css("background-color","#293cff");
				}else if (colorb=="#af87dd") {
					$(hijo1).css("background-color","#771edc");
				}else if (colorb=="#72a268") {
					$(hijo1).css("background-color","#287d17");
				}else if (colorb=="#f4d8d7") {
					$(hijo1).css("background-color","#f0a7a5");
				}else if (colorb=="#d7d2db") {
					$(hijo1).css("background-color","#7d7980");
				}else if (colorb=="#ff5f60") {
					$(hijo1).css("background-color","#ff1d15");
				}
			}
		}
		$("#save").removeAttr("disabled");
		salvar=5;
	});

	$(".chek" ).each(function(index, elemento){

		var clase = "" + $(elemento).attr("class") + "";
        var valor = clase;
        if (valor.indexOf("active")==-1) {
        	valor = false;
        }else{
        	valor = true;
        }

        var td=$(elemento).parent();
        td=$(td).parent();
		var tr=$(td).parent();

		var hijo1 = $(tr).find(".conpizarron");
		if (valor) {
			$(hijo1).css("font-weight", "normal");
			$(tr).css("background-color", "#f1f1f1");
			colorMin(hijo1,true);
		}else{
			$(hijo1).css("font-weight", "bold");
			$(tr).css("background-color", "transparent");
			colorMin(hijo1,false);
		}
    });

	$("#checkAll").click(function(){
        //var valor = $("#checkAll").prop("checked");
        var clase = "" + $("#checkAll").attr("class") + "";
        var valor = clase;
        if (valor.indexOf("active")==-1) {
        	valor = true;
        	clase = "btn btn-default active";
        }else{
        	valor = false;
        	clase = "btn btn-default";
        }
        
        $("label[class~='chek']" ).each(function(index, elemento){
            //$(elemento).prop("checked",valor);
            $(elemento).attr("class",clase + " chek");
            
    		var td=$(elemento).parent();
    		td=$(td).parent();
			var tr=$(td).parent();
			var hijo1 = $(tr).find("div[class^='conpizarron']");

			

			// // #fff8be
			// // #dca481
			// // #acb3ff
			// // #af87dd
			// // #72a268
			// // #f4d8d7
			// // #d7d2db


			// // #ffe527
			// // #dc6519
			// // #293cff
			// // #771edc
			// // #287d17
			// // #f0a7a5
			// // #7d7980

			if (valor) {
				$(hijo1).css("font-weight", "normal");
				$(tr).css("background-color", "#f1f1f1");
				colorMin(hijo1,true);
			}else{
				$(hijo1).css("font-weight", "bold");
				$(tr).css("background-color", "transparent");
				colorMin(hijo1,false);
			}
        });
        $("#save").removeAttr("disabled");
        salvar=5;
    });
    $("#searchdate").change(function() {
		window.location="http://"+window.location.hostname+"/sdt/rm/"+$(this).val();
	});
	$("#searchdate").click(function() {
		fechaG="";
	});
	var time=setInterval(saveAll, 1000);
	var time=setInterval(showDays, 200);
	var time=setInterval(removeSpanCopy, 50);
	

	//dar formato a la letra de la linea
	$("#LetraFont").change(function(){
		if (lastObj) {
			$(lastObj).css('font-family',$(this).val());
		}
		$("#save").removeAttr("disabled");
        salvar=5;
	});
	$("#LetraSize").change(function(){
		if (lastObj) {
			$(lastObj).css('font-size',$(this).val()+"px");
		}
		$("#save").removeAttr("disabled");
        salvar=5;
	});

	$('.color-box').colpick({
		colorScheme:'dark',
		layout:'rgbhex',
		color:'000000',
		onSubmit:function(hsb,hex,rgb,el) {
			$(el).css('background-color', '#'+hex);
			$(el).colpickHide();
			if (lastObj) {
				$(lastObj).css('color','#'+hex);
			};
			$("#save").removeAttr("disabled");
        	salvar=5;
		}
	})
	.css('background-color', '#000000');

	$('.color-box2').colpick({
		colorScheme:'dark',
		layout:'rgbhex',
		color:'000000',
		onSubmit:function(hsb,hex,rgb,el) {
			$(el).css('background-color', '#'+hex);
			$(el).colpickHide();
			if (lastObj) {
				$(lastObj).css('background-color','#'+hex);
			};
			$("#save").removeAttr("disabled");
        	salvar=5;
		}
	})
	.css('background-color', '#000000');

	$("#bt-searchRM").tooltip({
		placement: 'bottom',
		template: '<div class="tooltip" role="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner" style="background-color:#ef0d0a;"></div></div>'
	});
	$('#bt-searchRM').tooltip('show');
	
});
	
var newNumber = function(nu){ // VT14 funcion que envia a el controlador ajax y al metodo getCiudades el pais para cargar las ciudades
    var sigui=false;
    $(".numerar").each(function(index, elemento){
		/// cambiar solo los del mismo nivel en el rango
		var str = $(elemento).text();
		//alert(str);
		if (sigui) {
			var res = str.split(".");
			var newnum ="";
			// nivel de incremento
			var nivel = nu.split(".").length;
			for (var i = 0; i < res.length; i++) {
				if (i==nivel-1) {
					newnum+=(parseInt(res[i])+1);
				}else{
					newnum+=res[i];
				}
				newnum+=".";
				//la cadena debe coincidir para hasta el nivel anterior
				if (i<(nivel-1)) {
					//alert(newnum+"!="+nu.slice(0,newnum.length))
					if (newnum!=nu.slice(0,newnum.length)) {
						sigui=false;
						//sino coinciden entonces no debe incrementar y terminar de buscar
						i = res.length;
					};
				};
			};
			if (sigui) {
				newnum=newnum.slice(0,newnum.length-1);
				$(elemento).text(newnum);
			};
		};
		if (str==nu) {
			sigui=true;
		};
	});



}
var LineRM = function(elemento,nume){
	if (SOnline) {
		server = "http://"+window.location.hostname;
		var fecha = $("#searchdate").val();
		// var tdp=$(elemento).parent("td:eq(0)");
		// alert($(tdp).html());
	    var trp=elemento;
	    var hijo1 = $(trp).find( ".numerar" );
		var numeracion = $(hijo1).text();
		var texto = $(trp).find( ".pizarron" ).html();
		var hijo2 = $(trp).find( ".chek" );
		var hijo3 = $(trp).find( ".conpizarron" );

		var clase = "" + $(hijo2).attr("class") + "";
	    var valor = clase;
	    if (valor.indexOf("active")==-1) {
	    	tachado = 0;
	    }else{
	    	tachado = 1;
	    }
		if (!nume) {
			nume=0;
		};
		var orden = nume;
		// var Lf = $(elemento).css("font-family");
		// var Ls = $(elemento).css("font-size");
		// var Lc = $(elemento).css("color");
		// var Lb = $(elemento).css("background-color");
		var inteme = $(hijo3).attr("name");
		//alert('&numeracion='+numeracion+'&orden='+orden+'&texto='+texto+'&tachado='+tachado+'&etiqueta='+inteme);

		//adecuamos el texto con los caracteres epeciales
		texto=""+texto+"";
		for (x in SpecialCh) {
		    texto= texto.split(x).join(SpecialCh[x]);
		}
		
		
		if ($(trp).attr("id")) {
			id = $(trp).attr("id");
	        id = id.slice(3,id.length);
			$.post(server+'/sdt/actualizarLineaTexto','id='+id+'&numeracion='+numeracion+'&orden='+orden+'&texto='+texto+'&tachado='+tachado+'&etiqueta='+inteme).fail(function() {
			    $("#save").removeAttr("disabled");

			});
		}else{
			$.post(server+'/sdt/crearLinea','fecha='+fecha+'&numeracion='+numeracion+'&orden='+orden+'&texto='+texto+'&tachado='+tachado +'&etiqueta='+inteme, function(datos){
		        if (datos!="None" && datos!="") {
		        	$(trp).attr('id',"tr_"+datos);
		        };
		    }, 'json').fail(function() {
			    console.log("error de conexion");
			    salvar=5;
			    $("#save").removeAttr("disabled");
			    SOnline=false;
			});
		}
	};
}
var OrdenAll = function(){
	$("#sample tr").each(function(index, elemento){
		LineRM(elemento,index)
	});
}
var saveAll = function(){

	if (salvar>0) {
		salvar-=1;
		if (salvar==0) {
			OrdenAll();
			$("#save").attr("disabled", "disabled");
		}
	}
}
var showDays = function(){
	var mes = $(".ui-datepicker-month").val();
	mes = parseInt(mes)+1;
	if (mes<10) {
		mes="0"+mes
	};
	var anio=$(".ui-datepicker-year").val();
	var fecha = "/"+mes+"/"+anio;
	if (fechaG!=fecha && SOnline) {
		$.post(server+'/sdt/getDias','fecha='+fecha, function(datos){
			datos = datos.split("+");
            $("#ui-datepicker-div td").each(function(index, elemento){
            	hijo = $(elemento).find( "a" );
            	mes=hijo.text().trim();
            	if (mes!="") {
            		if (mes<10) {
						mes="0"+mes
					};
            		if (datos[0].indexOf(mes+"-")>0) {
            			hijo.css("color","#20ba13");
            			if (datos[1].indexOf(mes+"-")>0) {
	            			hijo.css("color","blue");
	            		}
	            		hijo.css("font-weight","bold");
	            	};
            	};
            });
	    },'json').fail(function() {
		    console.log("error de conexion");
		    SOnline=false;
		});
	    fechaG=fecha;
	};
}
var removeSpanCopy = function(){
	//if (reSpan) {
		reSpan=false;
		if (lastObj) {
			var span = $(lastObj).find("span:eq(0)");
			if (span.length) {
				$(lastObj).find("span").each(function(index, elemento){
					$(elemento).removeAttr('style');
				});
				var  var1 = $(lastObj).html();
				var1 = var1.replace("<span>",'');
				var1 = var1.replace("</span>",'');
				$(lastObj).html(var1);
			};
		};
	//};
	estadoConeccion();
}
var showTools = function(obj){
	var offset = obj.offset();
	offset.top = offset.top + $(obj).height();
	offset.left = offset.left + $(obj).width() - $("#b-eliminar_top").width() - 20;
	$("#b-eliminar_top").offset({ top: offset.top , left: offset.left });
	offset.left = offset.left - $("#save").width() - 30;
	$("#save").offset({ top: offset.top , left: offset.left });
	offset.left = offset.left - $("#abc").width() - 30;
	$("#abc").offset({ top: offset.top , left: offset.left });
	offset.left = offset.left - $("#Setiqueta").width() - 5;
	$("#Setiqueta").offset({ top: offset.top , left: offset.left });

	$("#b-eliminar_top").css("visibility", "none");
	$("#save").css("visibility", "none");
	$("#abc").css("visibility", "none");
	$("#Setiqueta").css("visibility", "none");
	$("#Setiqueta").val($(obj).parent().attr("name"));
}
 var hiddeTools = function(){
 	$("#b-eliminar_top").css("visibility", "hidden");
	$("#save").css("visibility", "hidden");
	$("#abc").css("visibility", "hidden");
	$("#Setiqueta").css("visibility", "hidden");
 }

 var colorToHex = function (color) {
    if (color.substr(0, 1) === '#') {
        return color;
    }
    var digits = /(.*?)rgb\((\d+), (\d+), (\d+)\)/.exec(color);

    var red = parseInt(digits[2]);
    var green = parseInt(digits[3]);
    var blue = parseInt(digits[4]);

    var rgb = blue | (green << 8) | (red << 16);
    return digits[1] + '#' + rgb.toString(16);
};

var colorMin =  function(obj,valor) {
	var namec = $(obj).attr("name");
	if (namec!="0" && namec) {
		var colorb = colorToHex($(obj).css("background-color"));
		if (valor) {
			if (colorb=="#ffe527") {
				$(obj).css("background-color","#fff8be");
			}else if (colorb=="#dc6519") {
				$(obj).css("background-color","#dca481");
			}else if (colorb=="#293cff") {
				$(obj).css("background-color","#acb3ff");
			}else if (colorb=="#771edc") {
				$(obj).css("background-color","#af87dd");
			}else if (colorb=="#287d17") {
				$(obj).css("background-color","#72a268");
			}else if (colorb=="#f0a7a5") {
				$(obj).css("background-color","#f4d8d7");
			}else if (colorb=="#7d7980") {
				$(obj).css("background-color","#d7d2db");
			}else if (colorb=="#ff1d15") {
				$(obj).css("background-color","#ff5f60");
			}
		}else{
			if (colorb=="#fff8be") {
				$(obj).css("background-color","#ffe527");
			}else if (colorb=="#dca481") {
				$(obj).css("background-color","#dc6519");
			}else if (colorb=="#acb3ff") {
				$(obj).css("background-color","#293cff");
			}else if (colorb=="#af87dd") {
				$(obj).css("background-color","#771edc");
			}else if (colorb=="#72a268") {
				$(obj).css("background-color","#287d17");
			}else if (colorb=="#f4d8d7") {
				$(obj).css("background-color","#f0a7a5");
			}else if (colorb=="#d7d2db") {
				$(obj).css("background-color","#7d7980");
			}else if (colorb=="#ff5f60") {
				$(obj).css("background-color","#ff1d15");
			}
		}
	};
};

var estadoConeccion = function() {
	//if (SOnlineOld!=SOnline) {
		if (SOnline) {
			$("#conexion").attr("class","label label-success");
			$("#conexion").text("Online");
		}else{
			$("#conexion").attr("class","label label-danger");
			$("#conexion").text("Offline");
			salvar=5;
		}
		SOnlineOld=SOnline;
	//};
}