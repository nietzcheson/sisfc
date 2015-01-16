$(document).ready(function(){

    server = "http://"+window.location.hostname;
    //para crear referencia

    var getEmpresas = function(){
        $.post(_root_+'/operaciones/getEmpresas',function(datos){
            for(var i = 0; i < datos.length; i++){
                $("#cliente").append('<option value="' + datos[i].id_u_marca + '">' + datos[i].nombre_marca+'</option>');
            }
            $('#contacto').removeAttr('disabled');
        }, 'json');
    }

    var getLeads = function(){
        $.post(_root_+'/operaciones/getLeads',function(datos){
           for(var i = 0; i < datos.length; i++){
                $("#cliente").append('<option value="' + datos[i].id_u_prospecto + '">' + datos[i].nombre_prospecto + ' ' + datos[i].apellido_prospecto + '</option>');
            }
            $('#contacto').removeAttr('disabled');
        }, 'json');
    }

    $("#tipo_cliente").change(function(){

        if($(this).val()=="Seleccione"){
            $("#contacto").html('');
            $("#cliente").html('');
        }else if($(this).val()==1){
            $("#cliente").html('');
            $('#cliente').attr('disabled',false)
            getEmpresas();
        }else{
            $("#cliente").html('');
            $('#cliente').attr('disabled',false);

            $("#contacto").html('');
            getLeads();
        }
    });



    var getContactoCliente = function(){
        $.post(server+'/operaciones/getContactoCliente','id='+$("#cliente").val(),function(datos){

            for(var i = 0; i < datos.length; i++){
                $("#contacto").append('<option value="' + datos[i].id_u_prospecto + '">' + datos[i].nombre_prospecto + ' ' + datos[i].apellido_prospecto + '</option>');
            }
            $('#contacto').removeAttr('disabled');
        }, 'json');
    }

    $("#cliente").change(function(){
        $("#contacto").html('');
        $('#contacto').attr('disabled','-1')
        getContactoCliente();
    });





    //end crear referencia

    $("button[id^='b-eliminar_']").click(function(){
        if(confirm("¿Está seguro de eliminar la cotizacion?")){
            id = $(this).attr("id");
            id = id.slice(11,id.length);
            $.post(server+'/operaciones/eliminarCotizacion','id=' + id);
            $("#tr_"+id).fadeOut(200);
        }
    });
    $("button[id^='b2-eliminar_']").click(function(){
        if(confirm("¿Está seguro de eliminar la orden?")){
            id = $(this).attr("id");
            id = id.slice(12,id.length);
            $.post(server+'/operaciones/eliminarOrden','id=' + id);
            $("#tr_"+id).fadeOut(200);
        }
    });
    $("button[id^='b-elegir_']").click(function(){
        if(confirm("¿Está seguro de elegir esta cotizacion?")){
            id2 = $(this).attr("id");
            id = id2.slice(9,id2.length);
            $.post(server+'/operaciones/elegirCotizacion','id=' + id);
            //window.open();
            window.location.replace(window.location.pathname+"/3").delay( 800 );
            //location.reload();
        }
    });



});
