$(document).ready(function() {
	var getCiudades = function(){ // VT14 funcion que envia a el controlador ajax y al metodo getCiudades el pais para cargar las ciudades
        $.post('/mvc/ajax/getCiudades','pais=' + $("#pais").val(),function(datos){            
            
            for(var i = 0; i < datos.length; i++){
                $("#ciudad").append('<option value="' + datos[i].id + '">' + datos[i].ciudad + '</option>');
            }
            
        }, 'json');
    }
	$("#pais").change(function(){
		$("#ciudad").html('');
    	getCiudades();
    });
    $("#btn_insertar").click(function(){ // inserta las ciudades y actualizar el combo de ciudades
        $.post('/mvc/ajax/insertarCiudad',
        'pais=' + $("#pais").val() + '&ciudad=' + $("#ins_ciudad").val())
        
        $("#ins_ciudad").val('');
        $("#ciudad").html('');
        getCiudades();
    });
});