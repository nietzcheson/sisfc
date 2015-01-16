$(document).ready(function(){


	$("button[id^='b-eliminar_']").click(function(){

		if(confirm("¿Vas a eliminar?")){
			id = $(this).attr("id");
	        id = id.slice(11,id.length);
	        $.post(_root_+'/operaciones/eliminarOrdenProducto','id=' + id,function(datos){
            }, 'json');
            $("#"+id).fadeOut(200);
		}
	});


	var actualizarProducto = function (){

		$.post(_root_+"operaciones/actualizarOrden","id="+id +"&valor="+valor+"&celda="+celda,function(datos){
			alert(datos);
		},'json');

	}


	$("select[name='productos']").change(function(){

		valor = $(this).val();
		id = $(this).closest('tr').attr("id");
		celda = "producto";
		actualizarProducto();
	});

	var cantidadPorPrecio = function(){
		valorTotal = valor * valorHermano;
		$($(eThis).closest('tr').find("td[name='valorTotal']")).html("<h4>"+valorTotal+"</h4>");
	}

	$("input[name='input-cantidad']").keyup(function(){
		eThis = $(this);
		valor = $(eThis).val();
		id = $(eThis).closest('tr').attr("id");
		valorHermano = $(eThis).closest('tr').find("input[name='input-precio']").val();
		cantidadPorPrecio();
		celda = "cantidad";
		actualizarProducto();
	});

	$("input[name='input-precio']").keyup(function(){
		eThis = $(this);
		valor = $(eThis).val();
		id = $(eThis).closest('tr').attr("id");
		valorHermano = $(eThis).closest('tr').find("input[name='input-cantidad']").val();
		cantidadPorPrecio();
		celda = "precio";
		actualizarProducto();
	});

});
