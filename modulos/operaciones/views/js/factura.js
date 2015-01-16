$(document).on("ready",function(){

	offFacturar = function(){
		tFacturacion = $("#tipos_facturacion").val();
		razonSocial = $("#razones_sociales").val();

		if(tFacturacion!="Seleccione" && razonSocial!="Seleccione"){
			button.attr("class","btn btn-success disabled");
			button.html("Facturando...");
		}

	}

	$("#facturar").click(function(){
		button = $(this);
		offFacturar();
	});

	$("#razones_sociales").change(function(){
		id = $(this).val();
		$("input[name=id_u_rs]").attr("value",id);

		if(id=="Seleccione"){
			$("#tabla,#form-facturar").fadeOut(300);
		}else{
			$("#tabla,#form-facturar").fadeIn(300);
		}



		$.post(_root_+"operaciones/saberRazonSocial","id="+id,function(datos){

			dato = datos.razon_social+"<br>";
			dato+= datos.calle+", "+datos.num_ext+", "+datos.num_int+"<br>";
			dato+= datos.colonia+", "+datos.municipio+"<br>";
			dato+= datos.cp+", "+datos.rfc+"<br>";
			$("#razonsocial").html(dato);
		},'json');

	});

	$("#tipos_facturacion").change(function(){
		id = $(this).val();
		$("input[name=tipos_facturacion]").attr("value",id);
	});


	//moneda = $(this).find("input[name=monedas]").val();
	//$("input[name=moneda_factura]").attr("value",moneda);

	$(".monedas").click(function(){
		moneda = $(this).find("input[name=monedas]").val();
		$("input[name=moneda_factura]").attr("value",moneda);
	});

	/*$("#facturar").click(function(){
		razon_social = $("#razones_sociales").val();
		monedas = $(".btn-primary").attr("class");
		alert(monedas);

		if(razon_social=="" || razon_social=="Seleccione"){
			event.preventDefault();
			alert("Debes seleccionar una razón social");
		}
		if(moneda=="active"){
			event.preventDefault();
			alert("Se debe escoger una moneda");
		}


	});*/
	$("label[id^='moneda_']").click(function(){
        id = $(this).attr("id");
        id2 = id.slice(7,id.length);
        valor="";
        $("label[id^='moneda_']" ).each(function(index, elemento){
            if ($(elemento).attr('id')==id) {
                $(elemento).attr('class', 'btn btn-primary');
                valor=$("#moned_"+id2).val();
            }else{
                $(elemento).attr('class', 'btn btn-default');
            };
        });
        $("input[name=moneda_factura]").val(valor);
    });

		$("#b_cancelar").click(function(){
			confirmar = confirm("¿Está seguro de cancelar?");

			if(confirmar==true){
				$("#f_cancelar").submit();
			}else{
				event.preventDefault();
			}

		});

		$("#enviar_pdfXML").click(function(){

			var emails = $("input[name='emails']").map(function(){return $(this).val();}).get();

			$("input[name='correos']").attr("value",emails);

			$("#enviarMailFactura").submit();
		});

		function eliminarWrapInput(){
			padre = $(elemento).parent();
			abuelo = $(padre).parent();

			$(abuelo).remove();
		}

		$("#delete-mail-rs").click(function(){
			$("#mail-rs").remove();
		});

		$("#nuevo-mail").click(function(){

			var inputGroup = $('<div />',{
				'class' : 'input-group',
			});

			var input = $('<input />',{
				'type'	: 'text',
				'class' : 'form-control',
				'name'	: 'emails'
			});

			var spanInput = $('<span />',{
				'class' : 'input-group-btn',
			});

			var button = $("<button />",{
				'class' : 'btn btn-default',
				'type'  : 'button',
				click : function(e){

					elemento = $(this);
					eliminarWrapInput();

				}
			});

			var glyphicon = $('<span />',{
				'class' : 'glyphicon glyphicon-remove'
			});

			var inputHTML = inputGroup.append(input,spanInput.append(button.append(glyphicon)));
			$("#wrap-mails").append("<h1></h1>",inputHTML);
		});
});
