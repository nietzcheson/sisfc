$(document).ready(function(){
	server = "http://"+window.location.hostname;
	$("button[id^='b-eliminar1_']").click(function(){
		if(confirm("¿Vas sa eliminar?")){
			id = $(this).attr("id");
	        id = id.slice(12,id.length);
	        inde = $("#indefica").val();
            $.post(server+'/clientes/eliminarMarcasClientes','id=' + id + "&marca=" + inde);
	        $("#tr1_"+id).fadeOut(200);
		}
	});
	$("button[id^='b-eliminar2_']").click(function(){
		if(confirm("¿Vas a eliminar?")){
			id = $(this).attr("id");
	        id = id.slice(12,id.length);
	        inde = $("#indefica").val();
            $.post(server+'/clientes/eliminarMarcasRazones','id=' + id + "&marca=" + inde);
	        $("#tr2_"+id).fadeOut(200);
		}
	});
	
	$("label[id^='comuni_']").click(function(){
        clase = $(this).attr('class');
        if (clase=="btn btn-default") {
            $(this).attr('class', 'btn btn-primary');
        }else{
            $(this).attr('class', 'btn btn-default active');
        };
    });


	var getOperacionesLead = function(){
		id = $("#id_u_prospecto").val();
		$.post(server+"/clientes/operacionesLead","lead="+id, function(datos){            
            if(datos){
            	html= "<div id='alerta-cliente' class='alert alert-danger fade in'>";
            		html+="<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>";
					html+="<h4>Oh espera! Detectamos algo!</h4>";
					html+="<p>El Lead que estás escogiendo ya tiene operaciones creadas. Si creas el cliente, las operaciones del Lead pasan inmediatamente él. Respira, no se perderá ninguna información....<p>"
            	html+= "</div>";

            	$("#alerta").html(html);
            }else{
            	$("#alerta-cliente").fadeOut(200);
            }
        }, 'json');

	}


	$("#id_u_prospecto").change(function(){

		getOperacionesLead();
	});


});