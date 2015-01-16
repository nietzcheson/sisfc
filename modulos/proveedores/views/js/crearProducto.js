$(document).ready(function() {
    server = "http://"+window.location.hostname;
	var getPartidas = function(){
        $.post(server+'/proveedores/getPartidas','capitulo=' + $("#capitulo").val(),function(datos){            
            for(var i = 0; i < datos.length; i++){
                $("#partida").append('<option value="' + datos[i].codigo_partida + '">' + datos[i].codigo_partida + '</option>');
            }
            $('#partida').removeAttr('disabled');
        }, 'json');
    }
    var getSubPartidas = function(){
        $.post(server+'/proveedores/getSubPartidas','partida=' + $("#partida").val(),function(datos){            
            for(var i = 0; i < datos.length; i++){
                $("#subpartida").append('<option value="' + datos[i].codigo_subpartida + '">' + datos[i].codigo_subpartida + '</option>');
            }
            $('#subpartida').removeAttr('disabled');
        }, 'json');
    }
    var getFracciones = function(){
        $.post(server+'/proveedores/getFracciones','subpartida=' + $("#subpartida").val(),function(datos){            
            for(var i = 0; i < datos.length; i++){
                $("#fraccion").append('<option value="' + datos[i].codigo_fraccion + '">' + datos[i].codigo_fraccion + '</option>');
            }
            $('#fraccion').removeAttr('disabled');
        }, 'json');
    }
	$("#capitulo").change(function(){
		$("#partida").html('');
        $("#partida").append('<option>Seleccione</option>');
        $('#partida').attr('disabled','-1')
        $("#subpartida").html('');
        $("#subpartida").append('<option>Seleccione</option>');
        $("#fraccion").html('');
        $("#fraccion").append('<option>Seleccione</option>');
    	getPartidas();
    });
    $("#partida").change(function(){
        $("#subpartida").html('');
        $("#subpartida").append('<option>Seleccione</option>');
        $('#subpartida').attr('disabled','-1')
        $("#fraccion").html('');
        $("#fraccion").append('<option>Seleccione</option>');
        getSubPartidas();
    });
    $("#subpartida").change(function(){
        $("#fraccion").html('');
        $("#fraccion").append('<option>Seleccione</option>');
        $('#fraccion').attr('disabled','-1')
        getFracciones();
    });
    $("input").click(function(){
        $("input[name=options]").each(function(){
            if(this.checked)
            {
               alert(this.val());
            }
        });
    });
});